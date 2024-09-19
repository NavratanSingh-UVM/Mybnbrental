<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\PropertyRates;
use App\Models\PropertyBooking;
use App\Models\PropertyListing;
use App\Models\BookingInformation;
use App\Http\Controllers\Controller;
use net\authorize\api\contract\v1 as AnetAPI;
use App\Models\BookingPaymentTransactionHistory;
use net\authorize\api\controller as AnetController;
use App\Http\Requests\Api\BookingInformationRequest;

class BookingInformationController extends Controller
{
    //
    public function storeBookingDetails(BookingInformationRequest $request){
        $property = PropertyListing::where('id',$request->input('property_id'))->first();
        $checkInDate = Carbon::parse($request->input('check_in'));
        $checkOutDate = Carbon::parse($request->input('check_out'));
        $totalNight = $checkOutDate->diffInDays($checkInDate);
        $toDay = date('Y-m-d');
        $date1 = Carbon::parse($toDay);
        $date2 = $request->input('check_in');
        $diffDays = $date1->diffInDays($date2);
        if($diffDays < 30 && $request->input('payment_type') =='partial'):
            return response()->json([
                'status'=>false,
                'msg'=>"This Payment type not allowed, please try again another paymnet type",
            ],500);
        endif;
        $dateRange = CarbonPeriod::create($checkInDate,$checkOutDate->subDays(1) );
        $dates = array_map(fn($date)=>$date->format('Y-m-d'),iterator_to_array($dateRange));
        $grossAmount = 0;
        for($i=0;$i<count($dates);$i++):
            $property_rates = PropertyRates::where(['property_id'=>$request->input('property_id')])->where('from_date', '<=',$dates[$i])->where('to_date','>=',$dates[$i])->first();
            if(!is_null($property_rates)):
                if($property_rates->nightly_rate !=null):
                    $grossAmount +=$property_rates->nightly_rate;
                elseif($property_rates->weekly_rate !=null && $property_rates->nightly_rate ==null):
                    $oneNight = $property_rates->weekly_rate/7;
                    $grossAmount +=$oneNight;
                elseif($property_rates->monthly_rate !=null && $property_rates->weekly_rate ==null && $property_rates->nightly_rate ==null):
                    $oneNight = $property_rates->monthly_rate/30;
                    $grossAmount +=$oneNight;
                endif;
            else:
                // $property = PropertyListing::where('id',$request->input('property_id'))->first();
                $grossAmount +=$property->avg_night_rates;
            endif;
        endfor;
        $bookingSummery = [];
        $totalAmount = ($grossAmount);
        $bookingSummery[$totalNight." nights"] =  $totalAmount;
        if($property->admin_fees !=null):
            $totalAmount +=$property->admin_fees;
            $bookingSummery['admin_fees'] = $property->admin_fees;
        endif;
        if($property->cleaning_fees !=null):
            $totalAmount +=$property->cleaning_fees;
            $bookingSummery['cleaning_fees'] = $property->cleaning_fees;
        endif;
        if($property->refundable_damage_deposite !=null):
            $totalAmount +=$property->refundable_damage_deposite;
            $bookingSummery['refundable_damage_deposite'] = $property->refundable_damage_deposite;
        endif;
        if($property->danage_waiver !=null):
            $totalAmount +=$property->danage_waiver;
            $bookingSummery['damage_waiver'] = $property->danage_waiver;
        endif;
        if($property->peet_fee !=null && $request->input('pet') =='1'):
            if($property->pet_fees_unit =='Per Day'):
                $petFees = $property->peet_fee;
                $totalAmount = ($totalAmount+($petFees*$totalNight));
                $totalPetFees = $petFees*$totalNight;
            elseif($property->pet_fees_unit =='Per Week'):
                $oneday = $property->peet_fee/7;
                $totalAmount = ($totalAmount+($oneday*$totalNight));
                $totalPetFees = $oneday*$totalNight;
            else:
                $petFees = $property->peet_fee;
                $totalAmount = ($totalAmount+$petFees);
                $totalPetFees = $petFees;
            endif;
            $bookingSummery['pet_fees'] = $totalPetFees;
        endif;
        if($property->extra_person_fee !=null && $property->after_guest < ($request->input('adult')+$request->input('children'))):
            $extraPerson = ((float)$request->input('adult') + $request->input('children')) - $property->after_guest;
            $totalAmount  +=$property->extra_person_fee*$extraPerson*$totalNight;
            $bookingSummery['extra_person_fees'] =$property->extra_person_fee*$extraPerson*$totalNight;
        endif;
        if($property->poolheating_fee !=null && $request->input('pool_heating')=='1'):
            if($property->pool_heating_fees_perday =='Per Day'):
                $poolHeatingFess = $property->poolheating_fee*$totalNight;
                $totalAmount = ($totalAmount+($poolHeatingFess));
            elseif($property->pool_heating_fees_perday =='Per Week'):
                $oneday = $property->poolheating_fee/7;
                $poolHeatingFess = $oneday*$totalNight;
                $totalAmount = ($totalAmount+($oneday*$totalNight));
            else:
                $poolHeatingFess = $property->poolheating_fee;
                $totalAmount = ($totalAmount+($poolHeatingFess));
            endif;
            $bookingSummery['pool_heating_fees'] = $poolHeatingFess;
        endif;
        if($property->tax_rates !=null):
            if($property->refundable_damage_deposite !=null):
                $taxableAmount = $totalAmount - $property->refundable_damage_deposite;
            endif;
            $totalAmount += $taxableAmount*$property->tax_rates/100;
            $bookingSummery['tax'] = $taxableAmount*$property->tax_rates/100;
        endif;
        $bookingSummery['total_amount'] = $totalAmount;
        $checkBooking = BookingInformation::where('user_id',auth()->user()->id)->whereNull('status')->first();
        // dd($checkBooking);
        if(!is_null($checkBooking)):
            $bookingInformation =  $checkBooking->update([
                'user_id'=>auth()->user()->id,
                'property_id'=>$request->input('property_id'),
                'check_in'=>$checkInDate->format('Y-m-d'),
                'check_out'=>$checkOutDate->format('Y-m-d'),
                'total_amount'=>$totalAmount,
                'total_guest'=>$request->input('adult'),
                'total_children'=>$request->input('children')??0,
                'total_night'=>$totalNight,
                'booking_summary'=>json_encode($bookingSummery),
                'cancelletion_id'=>$property->cancelletion_policies_id
            ]);
        else:
            $bookingInformation = BookingInformation::create([
                'user_id'=>auth()->user()->id,
                'property_id'=>$request->input('property_id'),
                'check_in'=>$checkInDate->format('Y-m-d'),
                'check_out'=>$checkOutDate->format('Y-m-d'),
                'total_amount'=>$totalAmount,
                'total_guest'=>$request->input('adult'),
                'total_children'=>$request->input('children')??0,
                'total_night'=>$totalNight,
                'booking_summary'=>json_encode($bookingSummery),
                'cancelletion_id'=>$property->cancelletion_policies_id
            ]);
        endif;
        if($request->input('payment_type')=='partial'):
            $payableAmount = ($totalAmount*50)/100;
            $nextPaymentDate =  date('Y-m-d', strtotime('-30 days', strtotime($checkInDate)));
        else:
            $payableAmount =  $totalAmount;
        endif;
        $expireMonth = $request->input('expire_month');
        $expireYears = $request->input('expire_year');
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
        $refId = time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('card_number'));
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expireYears . "-" .$expireMonth);
        $creditCard->setCardCode($request->input('cvv_pin'));
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($payableAmount);
        $transactionRequestType->setPayment($paymentOne);
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if($response !=null):
            if($response->getMessages()->getResultCode() == "Ok"):
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                if($tresponse != null && $tresponse->getMessages() != null):
                    $message_text = $tresponse->getMessages()[0]->getDescription()." Transaction ID: " .$tresponse->getTransId() ;
                    $msg_type = "success_msg";
                    BookingPaymentTransactionHistory::create([
                        'booking_information_id'=>$bookingInformation->id??$checkBooking->id,
                        'pay_amount'=>$payableAmount,
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'status'=>'success'
                    ]);
                    BookingInformation::where('id',$bookingInformation->id??$checkBooking->id)->update([
                        'dues_amount'=>$bookingInformation->total_amount??$totalAmount-$payableAmount,
                        'payment_type'=>$request->input('payment_type'),
                        'next_payment_date'=>$nextPaymentDate??NULL,
                        'status'=>'confirmed'
                    ]);
                    PropertyBooking::create([
                        'property_id'=>$bookingInformation->property_id??$checkBooking->id,
                        'start_date' =>$bookingInformation->check_in??$checkInDate,
                        'end_date' =>$bookingInformation->check_out??$checkOutDate,
                        'events' =>$bookingInformation->user->name??$checkBooking->user->name.'- Reserved',
                        'booking_time_stamps'=>Carbon::now(),
                        'type'=>"0",
                    ]);
                else:
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                endif;
            else:

                 // Or, print errors if the API request wasn't successful
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";
                $tresponse = $response->getTransactionResponse();
                if($tresponse != null && $tresponse->getErrors() != null):
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                else:
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                endif;
            endif;
        else:
            $message_text = "No response returned";
            $msg_type = "error_msg";
        endif;
        if($msg_type=='success_msg'):
            return response()->json([
                'status'=>true,
                'msg'=>$message_text
            ],200);
            // return to_route('payment.success')->with('success',$message_text);
        else:
            session()->put('error',$message_text);
            return response()->json([
                'status'=>false,
                'msg'=>$message_text,
            ],500);
        endif;
    }

    public function myBookingList(Request $request) {
        $bookingList=[];
        $paymentTransaction = BookingInformation::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
            $traveller->where('user_id',auth()->user()->id);
        })->when(auth()->user()->roles()->first()->name=='Owner',function($owner){
            $owner->whereHas('property',function($property){
                $property->where('user_id',auth()->user()->id);
            });
        })->when($request->input('booking_type') !=null,function($bookingInformation) use ($request) {
            $currentDate = Carbon::now()->format('Y-m-d');
            if($request->input('booking_type')=='upcoming_booking'):
                $bookingInformation->where('check_in','>=',$currentDate);
            endif;
            if($request->input('booking_type')=='current_booking'):
                $bookingInformation->where('check_in','<=',$currentDate)->where('check_out','>=',$currentDate);
            endif;
            if($request->input('booking_type')=='checking_out'):
                $bookingInformation->where('check_out','=',Carbon::now()->addDays(1)->format('Y-m-d'))->where('check_out','=',$currentDate);
            endif;
            if($request->input('booking_type')=='arriving_soon'):
                $bookingInformation->where('check_in','=',Carbon::now()->addDays(1)->format('Y-m-d'))->where('check_in','=',$currentDate);
            endif;
        })->where('status','confirmed')->get();
        // dd($paymentTransaction);
        foreach($paymentTransaction as $booking):
            if(auth()->user()->roles()->first()->name=='Owner'):
                $userInfor=[
                    'user_id'=>$booking->user()?$booking->user->id:null,
                    'user_name'=>$booking->user()?$booking->user->name:null,
                    'user_mobile'=>$booking->user()?$booking->user->phone:null,
                    'user_email'=>$booking->user()?$booking->user->email:null,
                    'user_pic'=> $booking->user()?($booking->user->image !=null?url('public/storage/profile_image/'.$booking->user->image):null):null,
                ];
            endif;
            $bookings = [
                'id'=>$booking->id,
                'property_name'=>$booking->property->property_name,
                'property_image'=>url('public/storage/upload/property_image/main_image/'.$booking->property->property_main_photos),
                'check_in_date'=>$booking->check_in,
                'check_out_date'=>$booking->check_out,
                'total_booking_fees'=>$booking->total_amount,
                'paid_amount'=>$booking->total_amount - $booking->dues_amount,
                'dues_amount'=>$booking->dues_amount,
                'next_payment_date'=>$booking->next_payment_date
            ];

            $both=array_merge($bookings,$userInfor);
            array_push($bookingList, $both);
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Booking List fetched seccessfully",
            'data'=>$bookingList
        ]);
    }

    public function bookingDetails(Request $request){
        // dd(auth()->user()->getRoleNames()->first());
        $bookingInformation = BookingInformation::where('id',$request->id)->first();
        $bookingDetails =[
            'id'=>$bookingInformation->id,
            'name'=>auth()->user()->getRoleNames()->first()=='Traveller'?$bookingInformation->property->user->name:$bookingInformation->user->name,
            'phone'=>auth()->user()->getRoleNames()->first()=='Traveller'?$bookingInformation->property->user->phone:$bookingInformation->user->phone,
            'address'=>auth()->user()->getRoleNames()->first()=='Traveller'?$bookingInformation->property->address:"",
            'property_id'=>$bookingInformation->property->id,
            'property_name'=>$bookingInformation->property->property_name,
            'check_in' =>$bookingInformation->check_in,
            'check_out' =>$bookingInformation->check_out,
            'adults' =>$bookingInformation->total_guest,
            'children' =>$bookingInformation->total_children,
            'booking_summry'=>$bookingInformation->booking_summary,
            'total_amount'=>$bookingInformation->total_amount,
            'guest_paid'=>($bookingInformation->total_amount - $bookingInformation->dues_amount),
            'payment_type'=>$bookingInformation->payment_type,
            'cancellention_policy'=>[
                $bookingInformation->cancelletionPolicies->name,
                $bookingInformation->cancelletionPolicies->description,
                $bookingInformation->cancelletionPolicies->note,
            ],
            'next_payment_date'=>$bookingInformation->next_payment_date
        ];
        $hostPayOut = [];
        if(auth()->user()->getRoleNames()->first()=='Owner'):
            $total_amount = 0;
            $bookingDetailss = json_decode($bookingInformation->booking_summary, true);
			ksort($bookingDetailss, 5);
            foreach ($bookingDetailss as $key => $item):
                if(!in_array($key,['total_amount'])):
                    $hostPayOut[$key] = $item;
                endif;
                if(!in_array($key,['refundable_damage_deposite','tax','total_amount'])):
                    $total_amount += $item;

                endif;
            endforeach;
            $hostPayOut['service_fees'] =$total_amount*8/100;
            $hostPayOut['total'] = $total_amount-$total_amount*8/100;
            $bookingDetails['host_payout']= $hostPayOut;
        endif;

        return response()->json([
            'status'=>true,
            'msg'=>"Booking details fetched successfully",
            'data'=>$bookingDetails,

        ]);
    }

    public function payRemeningBalance(Request $request){
        $bookingInformation =  BookingInformation::where('id',$request->input('id'))->first();
        $totalAmount =  BookingInformation::where('id',$request->input('id'))->first()->dues_amount;
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('MERCHANT_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('MERCHANT_TRANSACTION_KEY'));
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('card_number'));
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate("20".$request->input('expire_year') . "-" .$request->input('expire_month'));
        $creditCard->setCardCode($request->input('cvv_pin'));
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($totalAmount);
        $transactionRequestType->setPayment($paymentOne);
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if($response !=null):
            // Check to see if the API request was successfully received and acted upon
            if($response->getMessages()->getResultCode() == "Ok"):
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " .$tresponse->getTransId() ;
                    $msg_type = "success_msg";
                    $redirectUrl = route('traveller.booking');
                    BookingPaymentTransactionHistory::create([
                        'booking_information_id'=>$bookingInformation->id,
                        'pay_amount'=>$totalAmount,
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'status'=>'success'
                    ]);
                    BookingInformation::where('id',$bookingInformation->id)->update([
                        'dues_amount'=>$bookingInformation->dues_amount-$totalAmount,
                    ]);
                } else {
                    BookingPaymentTransactionHistory::create([
                        'booking_information_id'=>$bookingInformation->id,
                        'pay_amount'=>$totalAmount,
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'status'=>'failed'
                    ]);
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }
                // Or, print errors if the API request wasn't successful
            else:
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";
                $tresponse = $response->getTransactionResponse();
                BookingPaymentTransactionHistory::create([
                    'booking_information_id'=>$bookingInformation->id,
                    'pay_amount'=>$totalAmount,
                    // 'transaction_id'=>$tresponse->getTransId(),
                    'payment_response'=>json_encode($tresponse),
                    'status'=>'failed'
                ]);
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }
            endif;
        else:
            $message_text = "No response returned";
            $msg_type = "error_msg";
        endif;

        if($msg_type=='success_msg'):
            return response()->json([
                'status'=>true,
                'msg'=>$message_text
            ],200);
            // return to_route('payment.success')->with('success',$message_text);
        else:
            session()->put('error',$message_text);
            return response()->json([
                'status'=>false,
                'msg'=>$message_text,
            ],500);
        endif;
    }


    public function transactionHistory() {
        // dd(auth()->user()->roles()->first());
        $paymentTransaction = BookingPaymentTransactionHistory::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
            $traveller->whereHas('bookingInformation',function($bookingInformation){
                $bookingInformation->where('user_id',auth()->user()->id);
            });
        })->when(auth()->user()->roles()->first()->name=='Owner',function($owner){
            $owner->whereHas('property',function($property){
                $property->where('user_id',auth()->user()->id);
            });
        })->where('status','success')->get(['transaction_id','pay_amount','created_at']);
       return response()->json([
            'status'=>true,
            'msg'=>"Payment Transaction History Successfully",
            'data'=>$paymentTransaction
       ]);

    }
}
