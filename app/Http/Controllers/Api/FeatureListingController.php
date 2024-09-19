<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FeaturePropertyPayment;
use net\authorize\api\contract\v1 as AnetAPI;
use App\Notifications\FeaturePropertyNotification;
use net\authorize\api\controller as AnetController;
use App\Http\Requests\Api\CreateFeatureListingRequest;
use App\Http\Requests\Api\MakePaymentFeatureListngPropertyRequest;

class FeatureListingController extends Controller
{
    public function createFeatureListing(CreateFeatureListingRequest $request) {
        $totalAmount = env('FEATURED_PROPERTY_PRICE')*count($request->input('property_id'))*$request->input('no_month');
        $packages = FeaturePropertyPayment::create([
            'user_id'=>Auth::user()->id,
            'property_id'=>json_encode($request->input('property_id')),
            'month'=>$request->input('no_month'),
            'amount'=>$totalAmount,
            'type'=>'2',
            'payment_status'=>'pending'
        ]);
        if($packages):
                return response()->json([
                    'status'=>true,
                    'msg'=>"Feature property information added successfully",
                    'feature_property_id'=>$packages->id,
                    'total_amount'=>$totalAmount
                ],200);
        else:
            return response()->json([
                'msg'=>"Feature property information not added,Please try again",
            ],500);
       endif;
    }


    public function makePaymentFeatureListingProperty(MakePaymentFeatureListngPropertyRequest $request) {
        $totalAmount = FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending','id'=>$request->input('feature_listing_property_id')])->latest()->first();
        $expireDate = explode('/',$request->input('expire_year'));
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('card_number'));
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate("20".$expireDate[1]."-".$expireDate[0]);
        $creditCard->setCardCode($request->input('cvv_pin'));
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
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
        if($response != null):
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " .$tresponse->getTransId() ;
                    $msg_type = "success_msg";    
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
        else:
            $message_text = "No response returned";
            $msg_type = "error_msg";
        endif;

        if($msg_type =='success_msg'):
            return response()->json([
                'status'=>true,
                'msg'=>$message_text
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>$message_text
            ],500); 
        endif;
    }

    public function featureListingPorperty() {
        $featureProperty = FeaturePropertyPayment::where(['user_id'=>Auth::user()->id,'payment_status'=>'success'])->latest()->get();
        $featureListing = [];
        foreach($featureProperty as $feature):
            if($feature->property['0']->feature =='1' && $feature->property[0]->property_feature_expiration_date ==null):
                $status ='Active';
            elseif($feature->property['0']->feature =='0' && $feature->property['0']->property_feature_expiration_date ==null):
                $status ='Pending Approval';
            elseif($feature->property['0']->feature =='0' && $feature->property['0']->property_feature_expiration_date !=null):
                $status ='Expired';
            endif;
            $featureListing [] = [
                'id'=>$feature->id,
                'transaction_id'=>$feature->transaction_id,
                'property_id'=>$feature->property_id,
                'no_month'=>$feature->month,    
                'amount'=>$feature->amount,    
                'amount'=>$feature->amount,
                'status'=>$status,
                'transaction_date'=>date('M dS Y',strtotime($feature->created_at)),
                'expiration_date'=>date('M dS Y',strtotime($feature->created_at."+".$feature->month."month")),
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Feature property listing fetched successfully",
            'data'=>$featureListing,
        ],200);
    }
}
