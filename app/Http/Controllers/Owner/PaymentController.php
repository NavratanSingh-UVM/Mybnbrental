<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\AddPaymentRequest;
use App\Http\Requests\Owner\CardDetailsRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PropertyListing;
use App\Models\FeaturePropertyPayment;
use App\Notifications\FeaturePropertyNotification;

class PaymentController extends Controller
{
    public function transaction(Request $request){
        if($request->ajax()):
            $featureProperty = FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'success'])->latest();
            return DataTables::of($featureProperty)
            ->addIndexColumn()
            ->editColumn('created_date',function($row){
                return date('M dS Y',strtotime($row->created_at));
            })
            ->editColumn('expiration_date',function($row){
                return date('M dS Y',strtotime($row->created_at."+".$row->month."month"));
            })
            ->addColumn('status',function($row){
                if($row->property['0']->feature =='1' && $row->property[0]->property_feature_expiration_date ==null):
                    return '<span class="badge badge-pill badge-success">Active</span>';
                elseif($row->property['0']->feature =='0' && $row->property['0']->property_feature_expiration_date ==null):
                    return '<span class="badge badge-pill badge-secondary">Pending Approval</span>';
                elseif($row->property['0']->feature =='0' && $row->property['0']->property_feature_expiration_date !=null):
                    return '<span class="badge badge-pill badge-danger">Expired</span>';
                endif;

            })
            ->rawColumns(['created_date','status'])
            ->make(true);
        endif;
        return view('owner.transaction');
    }

    public function addFeatureProperty  () {
       $properties = PropertyListing::where('user_id',auth()->user()->id)->get(['id','property_name']);
        return view('owner.create-payment',compact('properties'));
    }

    public function calculatePrice(Request $request) {
        // dd($request->all());
        $totalAmount = env('FEATURED_PROPERTY_PRICE')*count($request->input('property'))*$request->input('no_month');
        return response()->json([
            'data'=>$totalAmount
        ],200);
    }

    public function makePayment(AddPaymentRequest $request) {
        $totalAmount = env('FEATURED_PROPERTY_PRICE')*count($request->input('property'))*$request->input('no_of_month');
        $packages = FeaturePropertyPayment::create([
            'user_id'=>Auth::user()->id,
            'property_id'=>json_encode($request->input('property')),
            'month'=>$request->input('no_of_month'),
            'amount'=>$totalAmount,
            'type'=>'2',
            'payment_status'=>'pending'
        ]);
        if($packages):
                return response()->json([
                    'msg'=>"Payment Added Successfully,Please Wait Redirecting",
                    'url'=>route('owner.card.details')
                ],200);
        else:
            return response()->json([
                'msg'=>"Payment Not Added, Please try again",
            ],500);
       endif;
    }

    public function cardDetails() {
        $totalAmount = FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->latest()->first()->amount;
        return view('owner.card-details',compact('totalAmount'));
    }

    public function payment (CardDetailsRequest $request) {
        // dd(env('MERCHANT_LOGIN_ID'),env('MERCHANT_TRANSACTION_KEY'));
        $totalAmount = FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->latest()->first();
       
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('card_number'));
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request->input('expiry_year') . "-" .$request->input('expiry_month'));
        $creditCard->setCardCode($request->input('cvv_pin'));
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($totalAmount->amount);
        $transactionRequestType->setPayment($paymentOne);
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
       
        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " .$tresponse->getTransId() ;
                    $msg_type = "success_msg";    
                    $redirectUrl = route('owner.transaction');
                    FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->update([
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'payment_status'=>'success',
                        'payment_type'=>'3',
                    ]);
                    auth()->user()->notify(new FeaturePropertyNotification($totalAmount));
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";                                    

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";                                    
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";                                    

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";                    
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }                
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }
        return response()->json([
            'msg_type'=>$msg_type,
            'url'=>$redirectUrl??"",
            'msg'=>$message_text,
        ]);
    }
}
