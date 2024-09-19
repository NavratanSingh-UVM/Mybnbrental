<?php

namespace App\Http\Controllers\Partner;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\PartnerListing;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PartnerListingPaymnet;
use Intervention\Image\Facades\Image;
use AnetAPI\MerchantAuthenticationType;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PartnerListingGalleryImage;
use net\authorize\api\contract\v1 as AnetAPI;
use App\Notifications\PartnerListingNotification;
use net\authorize\api\controller as AnetController;
use App\Http\Requests\Partner\PropertyListingImageRequest;
use App\Http\Requests\Partner\PaymentPartnerListingRequest;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function dashboard() {
        return view('partner.dashboard');
    }
    public function addPartnerListingPayment(Request $request) {
        return view('partner.partner-listing.payment-partner-listing');
    }
    public function storePartnerPaymentListing(PaymentPartnerListingRequest $request) {
       
        if(!is_null(PartnerListingPaymnet::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->first())):
            PartnerListingPaymnet::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->update([
                'user_id'=>auth()->user()->id,
                'no_of_listing'=>$request->input('no_of_listing'),
                'no_year'=>$request->input('no_year'),
                'total_amount'=>env('PARTNER_LISTING_PRICE')*$request->input('no_of_listing')*$request->input('no_year'),
                'payment_status'=>'pending'
            ]);
        else:
           
            $partnerPaymentListingPayment = PartnerListingPaymnet::create([
                'user_id'=>auth()->user()->id,
                'no_of_listing'=>$request->input('no_of_listing'),
                'no_year'=>$request->input('no_year'),
                'total_amount'=>env('PARTNER_LISTING_PRICE')*$request->input('no_of_listing')*$request->input('no_year'),
                'payment_status'=>'pending'
            ]); 
        endif;
        return view('partner.partner-listing.card-details',['total_amount'=>env('PARTNER_LISTING_PRICE')*$request->input('no_of_listing')*$request->input('no_year')]);
    }

    public function makePartnerListingPayment(Request $request) {
        $totalAmount = PartnerListingPaymnet::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->latest()->first();
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
        $transactionRequestType->setAmount($totalAmount->total_amount);
        $transactionRequestType->setPayment($paymentOne);
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

       
        if ($response != null) {
           
            if ($response->getMessages()->getResultCode() == "Ok") {
                
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " .$tresponse->getTransId() ;
                    $msg_type = "success_msg";    
                    $redirectUrl = route('partner.manage.payment');
                    PartnerListingPaymnet::where(['user_id'=>Auth::user()->id,'payment_status'=>'pending'])->update([
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'payment_status'=>'success',
                        'payment_type'=>"2",
                    ]);
                    auth()->user()->notify(New PartnerListingNotification($totalAmount));
                   
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";                                    

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";                                    
                    }
                }
                
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

    public function managePayment (Request $request) {
        if($request->ajax()):
            $partnerListingPayment = PartnerListingPaymnet::where(['user_id'=>auth()->user()->id,'payment_status'=>'success'])->orderBy('id','desc');
            return DataTables::of($partnerListingPayment)
            ->addIndexColumn()
            ->editColumn('created_at',function($row){
                return date('M dS Y',strtotime($row->created_at));
            })
            ->addColumn('expired_date',function($row){
                return date('M dS Y',strtotime("+12 months",strtotime($row->created_at)));
            })
            ->rawColumns(['created_at','status','expired_date'])
            ->make(true);
        endif;
       return view('partner.partner-listing.manage-payment');
    }

    public function managePartnerListing(Request $request) {
        if($request->ajax()):
            $partnerListings = PartnerListing::where('user_id',auth()->user()->id);
            return DataTables::of($partnerListings)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('partner.edit.partner.listing',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="partnerListingDelete('.$row->id.')">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        endif;
        return view('partner.partner-listing.manage-partner-listing');
    }

    public function createPartnerListing() {
       
       
        $businessCategories = BusinessCategory::get();
        $states = State::get();
        return view ('partner.partner-listing.add-partner-listing',compact('businessCategories','states'));
    }

    public function storePartnerListing(PropertyListingImageRequest $request) {
        $partnerListing = PartnerListing::create([
            'user_id'=>auth()->user()->id,
            'bussiness_category_id'=>$request->input('business_category'),
            'title'=>$request->input('title'),
            'address'=>$request->input('address'),
            'description'=>$request->input('description'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'website'=>$request->input('website'),
            'location'=>$request->input('location'),
            'state_id'=>$request->input('state'),
            'region_id'=>$request->input('region'),
            'city_id'=>$request->input('city'),

        ]);
        if($partnerListing):
         
            foreach($request->images as $image):
                $ext = "webp";
                $convertImage = Image::make($image->getRealPath())->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($ext);
                $originalImageName = uniqid().'.'.$ext;
                Storage::put('public/upload/partner_listing/gallery_image/'.$originalImageName, $convertImage);
                $partnerListingGallery = PartnerListingGalleryImage::create([
                    "partner_listing_id"=>$partnerListing->id,
                    "image"=>$originalImageName
                ]);
            endforeach;
            return response()->json([
                'status'=>true,
                'msg'=>"Partner Listing Created Successfully,Please wait redirecting",
                'url'=>route('partner.manage.partner.listing')
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Partner Listing not Creating,Please try again",
            ],200);
        endif;

    }

    public function partnerListingDelete(Request $request) {
        $partnerListingDelete = PartnerListing::findOrFail($request->input('id'))->delete();
        if($partnerListingDelete):
            return response()->json([
                'status'=>true,
                'msg'=>"Partner Listing Delete Successfully ,Please wait redirecting",
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Partner Listing Not Delete ,Please try again",
            ],500);
        endif;
    }

    public function partnerListingEdit($id){
        $businessCategories = BusinessCategory::get();
        $states = State::get();
        $partnerListing = PartnerListing::findOrFail(decrypt($id));
        $regions = Region::where('state_id',$partnerListing->state_id)->get();
        $cities = City::where('region_id',$partnerListing->region_id)->get();
        return view('partner.partner-listing.edit-partner-listing',compact('partnerListing','states','businessCategories','regions','cities'));
    }

    public function updatePartnerListing(Request $request){
        if(str_word_count($request->input('description')) > 510){
            return response()->json([
                'status'=>false,
                'msg'=>"Please less than description word 510",
            ],440);
        }
        $updatePartnerListing = PartnerListing::findOrFail($request->input('id'))->update([
            'user_id'=>auth()->user()->id,
            'bussiness_category_id'=>$request->input('business_category'),
            'title'=>$request->input('title'),
            'address'=>$request->input('address'),
            'description'=>$request->input('description'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'website'=>$request->input('website'),
            'location'=>$request->input('location'),
            'state_id'=>$request->input('state'),
            'region_id'=>$request->input('region'),
            'city_id'=>$request->input('city'),

        ]);

        if($updatePartnerListing):
            if($request->has('images')):
              
                foreach($request->images as $image):
                    $ext = "webp";
                    $convertImage = Image::make($image->getRealPath())->resize(1000, 720, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode($ext,100);
                    $originalImageName = uniqid().'.'.$ext;
                    Storage::put('public/upload/partner_listing/gallery_image/'.$originalImageName, $convertImage);
                    $partnerListingGallery = PartnerListingGalleryImage::create([
                        "partner_listing_id"=>$request->id,
                        "image"=>$originalImageName
                    ]);
                endforeach;
            endif;
            return response()->json([
                'status'=>true,
                'msg'=>"Partner Listing Update Successfully,Please wait redirecting",
                'url'=>route('partner.manage.partner.listing')
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Partner Listing not update,Please try again",
            ],200);
        endif;
    }
    public function deleteImagePartnerListingImage(Request $request) {
        $partnerListingImage = PartnerListingGalleryImage::findOrFail($request->input('id'))->delete();
        if($partnerListingImage):
            return response()->json([
                'status'=>true,
                'msg'=>"Partner Listing Gallery Image Delete Successfully ,Please wait redirecting",
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Partner Listing Not Delete ,Please try again",
            ],500);
        endif;
    }

   
}
