<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BookingInformation;
use App\Models\CancellentionReason;
use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\CancellationSlabFees;
use App\Models\BookingPaymentTransactionHistory;
use App\Http\Requests\CancellentionRequest;
use App\Models\CancelBooking;
use App\Models\PropertyBooking;
use Yajra\DataTables\Facades\DataTables;
use net\authorize\api\controller as AnetController;
use net\authorize\api\contract\v1 as AnetAPI;


class CancelBookingController extends Controller
{
    public function cancelBooking($id) {
        $refundAbleAmount = 0;
        $daysBefore = false;
        $daysAfter = false;
        $cancellentionReasons = CancellentionReason::get();
        $booking  = BookingInformation::where('id',base64_decode($id))->first();
        // dd($booking);
        $cancellentionPolicies = CancellationSlabFees::where('cancelletion_polices_id',$booking->cancelletion_id)->get();
        foreach($cancellentionPolicies as $cancellentionFess):
            $units  = explode(' ',$cancellentionFess->days_period);
            if($units[1]==='Hours'):
                $days = $this->dates($units[0]);
            else:
                $days = $units[0];
            endif;
            $day = explode('-',$days);
            $daysBefore = array_key_exists(0,$day)?true:false;
            $daysAfter = array_key_exists(1,$day)?true:false;
            $diffrenceDays = Carbon::now()->diffInDays(Carbon::parse($booking->check_in));
            if($daysBefore && $daysAfter && $day[0] <=$diffrenceDays && $day[1] >=$diffrenceDays ):
                if($booking->dues_amount =='0'):
                    $refundAbleAmount=$booking->total_amount*$cancellentionFess->rates_in_percent/100;
                else:
                    if($booking->total_amount*$cancellentionFess->rates_in_percent/100 ===$booking->total_amount):
                        $refundAbleAmount = $booking->dues_amount;
                    else:
                        $refundAbleAmount = $booking->dues_amount - ($booking->total_amount*$cancellentionFess->rates_in_percent/100);
                    endif;
                  
                endif;
            elseif(!$daysAfter && $day[0] <=$diffrenceDays):
                if($booking->dues_amount =='0'):
                    $refundAbleAmount=$booking->total_amount*$cancellentionFess->rates_in_percent/100;
                else:
                    if($booking->total_amount*$cancellentionFess->rates_in_percent/100 ===$booking->total_amount):
                        $refundAbleAmount = $booking->dues_amount;
                    else:
                        $refundAbleAmount = $booking->dues_amount - ($booking->total_amount*$cancellentionFess->rates_in_percent/100);
                    endif;
                  
                endif;
            endif;
        endforeach;
        return view('traveller.cancel-booking.cancel-booking',compact('cancellentionReasons','booking','refundAbleAmount'));
    }


    private function dates($value) {
        return $value*60*60/86400;
    }


    public function cancelBookingStore(CancellentionRequest $request) {
        $cancel_reason_id=$request->input('cancel_reason');
        $note=$request->input('reason');
        $refundAbleAmount = 0;
        $daysBefore = false;
        $daysAfter = false;
        $booking  = BookingInformation::where('id',base64_decode($request->input('id')))->first();
        $cancellentionPolicies = CancellationSlabFees::where('cancelletion_polices_id',$booking->cancelletion_id)->get();
        foreach($cancellentionPolicies as $cancellentionFess):
            $units  = explode(' ',$cancellentionFess->days_period);
            if($units[1]==='Hours'):
                $days = $this->dates($units[0]);
            else:
                $days = $units[0];
            endif;
            $day = explode('-',$days);
            $daysBefore = array_key_exists(0,$day)?true:false;
            $daysAfter = array_key_exists(1,$day)?true:false;
            $diffrenceDays = Carbon::now()->diffInDays(Carbon::parse($booking->check_in));
            if($daysBefore && $daysAfter && $day[0] <=$diffrenceDays && $day[1] >=$diffrenceDays ):
                if($booking->dues_amount =='0'):
                    $refundAbleAmount=$booking->total_amount*$cancellentionFess->rates_in_percent/100;
                else:
                    if($booking->total_amount*$cancellentionFess->rates_in_percent/100 ===$booking->total_amount):
                        $refundAbleAmount = $booking->dues_amount;
                    else:
                        $refundAbleAmount = $booking->dues_amount - ($booking->total_amount*$cancellentionFess->rates_in_percent/100);
                    endif;
                  
                endif;
            elseif(!$daysAfter && $day[0] <=$diffrenceDays):
                if($booking->dues_amount =='0'):
                    $refundAbleAmount=$booking->total_amount*$cancellentionFess->rates_in_percent/100;
                else:
                    if($booking->total_amount*$cancellentionFess->rates_in_percent/100 ===$booking->total_amount):
                        $refundAbleAmount = $booking->dues_amount;
                    else:
                        $refundAbleAmount = $booking->dues_amount - ($booking->total_amount*$cancellentionFess->rates_in_percent/100);
                    endif;
                  
                endif;
            endif;
        endforeach;
        $refTrans= BookingPaymentTransactionHistory::where('booking_information_id',$booking->id)->where('status','success')->first();
       $refTransJson_Decode= json_decode($refTrans->payment_response);
       $CardNumber=substr($refTransJson_Decode->accountNumber,-4);
      // $refTransId=$refTrans->transaction_id;
        $refTransId=$refTrans->transaction_id==0?120236451534:$refTrans->transaction_id;
        // refund amount api
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
    $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
      // Set the transaction's refId
      $refId = time();
      // Create the payment data for a credit card
     $creditCard = new AnetAPI\CreditCardType();
     $creditCard->setCardNumber($CardNumber);
     $creditCard->setExpirationDate("0227");
     $paymentOne = new AnetAPI\PaymentType();
     $paymentOne->setCreditCard($creditCard);
     //create a transaction
     $transactionRequest = new AnetAPI\TransactionRequestType();
     // $transactionRequest->setTransactionType("authCaptureTransaction"); 
     $transactionRequest->setTransactionType("refundTransaction"); 
     $transactionRequest->setAmount($refundAbleAmount);
     $transactionRequest->setPayment($paymentOne);
     $transactionRequest->setRefTransId($refTransId);
     
     $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest( $transactionRequest);

    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    if ($response != null):
        if($response->getMessages()->getResultCode() == "Ok"): 
            $tresponse = $response->getTransactionResponse(); 
            if($tresponse != null && $tresponse->getMessages() != null):
                $message_text = $tresponse->getMessages()[0]->getDescription()." Transaction ID: " .$tresponse->getTransId() ;
                $msg_type = "success_msg";  
                  $cancelBooking = CancelBooking::create([
                    'booking_id'=>$booking->id,
                    'cancellention_policies_id'=>$booking->cancelletion_id,
                    'cancel_reason_id'=> $cancel_reason_id,
                    'refund_id'=>$tresponse->getRefTransID(),
                    'payment_response'=>json_encode($tresponse),
                    'refundable_amount'=>$refundAbleAmount,
                    'note'=>$note
                  ]);
                 $travellerCancelMessage = "We received your request to cancel the booking for Property ID ".$booking->property_id." scheduled on ".date('M dS Y',strtotime($booking->check_in)).".\r\rNeed more details log in to your dashboard.\r\rMY BNB RENTALS";
                 $ownerCancelMessage = "A customer has canceled their booking Property ID:- ".$booking->property_id."\r\rNeed more details log in to your dashboard.\r\rMY BNB RENTALS";
                 Helper::sendSms("+".auth()->user()->phone,$travellerCancelMessage);
                 Helper::sendSms("+".$booking->property->user->phone,$ownerCancelMessage);
                 BookingInformation::where('id',$booking->id)->update([
                     'status'=>'cancelled',
                  ]);
                 PropertyBooking::where(['property_id'=>$booking->property_id,'start_date'=>Carbon::parse($booking->check_in)->format('Y-m-d h:i:s'),'end_date'=>Carbon::parse($booking->check_out)->format('Y-m-d h:i:s')])->delete();
                  return response()->json([
                     'status'=>true,
                     'msg'=>"You're booking  cancel successfully",
                     'url'=>route('traveller.booking')
                   ],200);
            else:
                $message_text = "You're booking not cancel, Please try again";
                $msg_type = "error_msg"; 
                if($tresponse->getErrors() != null) {  
                  $message_text = $tresponse->getErrors()[0]->getErrorText();
                  $msg_type = "error_msg";           
                }
                endif;
                    return response()->json([
                        'status'=>false,
                        'msg'=>"You're booking not cancel, Please try again",
        
                    ],500);
            endif;
        else:
            echo "Transaction Failed \n";
            $tresponse = $response->getTransactionResponse();
            if($tresponse != null && $tresponse->getErrors() != null):
               echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
               echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";                      
            else:
                 echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                 echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
        endif;
       return $response;
     endif;
        $cancelBooking = CancelBooking::create([
            'booking_id'=>$booking->id,
            'cancellention_policies_id'=>$booking->cancelletion_id,
            'cancel_reason_id'=> $cancel_reason_id,
            'refund_id'=>null,
            'payment_response'=>null,
            'refundable_amount'=>$refundAbleAmount,
            'note'=>$note
        ]);
        if($cancelBooking):
            $travellerCancelMessage = "We received your request to cancel the booking for Property ID ".$booking->property_id." scheduled on ".date('M dS Y',strtotime($booking->check_in)).".\r\rNeed more details log in to your dashboard.\r\rMY BNB RENTALS";
            $ownerCancelMessage = "A customer has canceled their booking Property ID:- ".$booking->property_id."\r\rNeed more details log in to your dashboard.\r\rMY BNB RENTALS";
            Helper::sendSms("+".auth()->user()->phone,$travellerCancelMessage);
            Helper::sendSms("+".$booking->property->user->phone,$ownerCancelMessage);
            BookingInformation::where('id',$booking->id)->update([
                'status'=>'cancelled',
            ]);
            PropertyBooking::where(['property_id'=>$booking->property_id,'start_date'=>Carbon::parse($booking->check_in)->format('Y-m-d h:i:s'),'end_date'=>Carbon::parse($booking->check_out)->format('Y-m-d h:i:s')])->delete();
            return response()->json([
                'status'=>true,
                'msg'=>"You're booking  cancel successfully",
                'url'=>route('traveller.booking')
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"You're booking not cancel, Please try again",

            ],500);
        endif;
    }

    public function cancelBookingList(Request $request) {
        if($request->ajax()):
            $paymentTransaction = CancelBooking::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
                $traveller->whereHas('bookingInformation',function ($u){
                    $u->where('user_id',auth()->user()->id)->where('status','cancelled');
                });
            })->with('bookingInformation')->orderBy('id','desc')->get();
            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->editColumn('paid_amount',function($row){
                return $row->bookingInformation->total_amount - $row->bookingInformation->dues_amount;
            })
            ->addColumn('action', function($row){
                $url = "";
                if(auth()->user()->roles()->first()->name=='Owner'):
                    $url = route('owner.property.booking.details',base64_encode($row->bookingInformation->id));
                else:
                    $url=route('traveller.booking.details',base64_encode($row->bookingInformation->id));
                endif;
                $actionBtn = '<a href="'.$url.'" class="edit btn btn-success btn-sm" onclick="viewDetails('.$row->bookingInformation->id.')">View Details</a> ';
                return $actionBtn;
            })
            ->rawColumns(['paid_amount','action'])
            ->make(true);
        endif;
        return view('traveller.cancel-booking.list');
    }
}
