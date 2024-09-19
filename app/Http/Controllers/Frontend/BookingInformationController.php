<?php

namespace App\Http\Controllers\Frontend;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Chat;
use Carbon\CarbonPeriod;
use App\Http\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\PropertyRates;
use App\Models\PropertyBooking;
use App\Models\PropertyListing;
use App\Models\BookingInformation;
use App\Http\Controllers\Controller;
use net\authorize\api\contract\v1 as AnetAPI;
use App\Http\Requests\Frontend\PaymentRequest;
use App\Http\Requests\Frontend\GetQuoteRequest;
use App\Models\BookingPaymentTransactionHistory;
use net\authorize\api\controller as AnetController;
use App\Notifications\BookingInformationNotification;
use Guzzle\Http\Client;

class BookingInformationController extends Controller
{
    
    public function bookingInformation(){
        $bookingInformation = BookingInformation::where('user_id',auth()->user()->id)->whereNull('status')->first();
        return view('frontend.booking.booking-information',compact('bookingInformation'));
    }

    public function storeBookingInformation(GetQuoteRequest $request) {
        $property  =  PropertyListing::where('id',$request->input('property_id'))->first();
        $checkIn = Carbon::parse($request->input('check_in'));
        $checkOut = Carbon::parse($request->input('check_out'));
        $totalNight = $checkIn->diffInDays($checkOut);
        $dateRange = CarbonPeriod::create($checkIn,$checkOut->subDays(1) );
        $dates = array_map(fn($date)=>$date->format('Y-m-d'),iterator_to_array($dateRange));
        $grossAmount = 0;
        for($i=0;$i<count($dates);$i++):
            $property_rates = PropertyBooking::where(['property_id'=>$request->input('property_id')])->where('start_date','LIKE',"%{$dates[$i]}%")->where('end_date','lIKE',"%{$dates[$i]}%")->first();
            if(!is_null($property_rates)):
                if($property_rates->rate !=null):
                    $grossAmount +=$property_rates->rate;
                endif;
            else:
                $property = PropertyListing::where('id',$request->input('property_id'))->first();
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
        if($property->extra_person_fee !=null && $property->after_guest < ($request->input('guests')+$request->input('children'))):
            $extraPerson = ((float)$request->input('guests') + $request->input('children')) - $property->after_guest;
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
            $TotalAmount = $totalAmount*$property->tax_rates/100;
            $bookingSummery['tax'] = $totalAmount*$property->tax_rates/100;
            $totalAmount+= $TotalAmount;
        endif;
        $bookingSummery['total_amount'] = $totalAmount;
        // Check Booking
        $checkBooking = BookingInformation::where('user_id',auth()->user()->id)->whereNull('status')->first();
        if(!is_null($checkBooking)):
            $bookingInformation =  $checkBooking->update([
                'user_id'=>auth()->user()->id,
                'property_id'=>$request->input('property_id'),
                'check_in'=>$checkIn->format('Y-m-d'),
                'check_out'=>$checkOut->format('Y-m-d'),
                'total_amount'=>$totalAmount,
                'total_guest'=>$request->input('guests'),
                'total_children'=>$request->input('children'),
                'total_night'=>$totalNight,
                'booking_summary'=>json_encode($bookingSummery),
                'cancelletion_id'=>$property->cancelletion_policies_id
            ]);
        else:
            $bookingInformation = BookingInformation::create([
                'user_id'=>auth()->user()->id,
                'property_id'=>$request->input('property_id'),
                'check_in'=>$checkIn->format('Y-m-d'),
                'check_out'=>$checkOut->format('Y-m-d'),
                'total_amount'=>$totalAmount,
                'total_guest'=>$request->input('guests'),
                'total_children'=>$request->input('children'),
                'total_night'=>$totalNight,
                'booking_summary'=>json_encode($bookingSummery),
                'cancelletion_id'=>$property->cancelletion_policies_id
            ]);
        endif;

        if($bookingInformation):
            return response()->json([
                'status'=>true,
                'msg'=>'Please wait redirecting...',
                'url'=>route('booking.information'),
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>'Internal Server Error'
            ],500);
        endif;
    }

    public function makePayment(PaymentRequest $request) {
        // dd($request->all());
        $bookingInformation = BookingInformation::where('user_id',auth()->user()->id)->whereNull('status')->first();
        $propertyListing = PropertyListing::where('id',$bookingInformation->property_id)->first();
        $owner = User::where('id',$propertyListing->user_id)->first();
        $customer= User::where('id',$bookingInformation->user_id)->first();
        $payableAmount = 0;
        $nextPaymentDate =Null;
         //$this->insurance($request->all(),$bookingInformation,$propertyListing,$owner);
        if($request->input('payment_type')=='partial'):
            // $bookingInformation = BookingInformation::where('user_id',auth()->user()->id)->whereNull('status')->first();
            $payableAmount = ($bookingInformation->total_amount*50)/100;
            $nextPaymentDate =  date('Y-m-d', strtotime('-30 days', strtotime($bookingInformation->check_in)));
        else:
            $payableAmount = $bookingInformation->total_amount;
        endif;
        $expireMonths = explode('/',$request->input('expiry_month'));
        $expireMonth = $expireMonths[0];
        $expireYears = $expireMonths[1];
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
                        'booking_information_id'=>$bookingInformation->id,
                        'pay_amount'=>$payableAmount,
                        'transaction_id'=>$tresponse->getTransId(),
                        'payment_response'=>json_encode($tresponse),
                        'status'=>'success'
                    ]);
                    BookingInformation::where('id',$bookingInformation->id)->update([
                        'dues_amount'=>$bookingInformation->total_amount-$payableAmount,
                        'payment_type'=>$request->input('payment_type'),
                        'next_payment_date'=>$nextPaymentDate,
                        'status'=>'confirmed'
                    ]);
                    PropertyBooking::create([
                        'property_id'=>$bookingInformation->property_id,
                        'start_date' =>Carbon::parse($bookingInformation->check_in)->format('Y-m-d h:i:s'),
                        'end_date' =>Carbon::parse($bookingInformation->check_out)->format('Y-m-d h:i:s'),
                        'events' =>$bookingInformation->user->name.'- Reserved',
                        'booking_time_stamps'=>Carbon::now(),
                        'type'=>'0'
                    ]);
                     $msg="Bookging confirmed <br> Property Name : ".$propertyListing->property_name .",<br> Customer Name : ".$customer->name.",<br> Check in: ".$bookingInformation->check_in. ",<br> Check out: ".$bookingInformation->check_out;
                     Chat::create([
                        'sender_id'=>auth()->user()->id,
                        'reciver_id'=>$propertyListing->user_id,
                        'msg'=>$msg
                     ]);
                    // auth()->user()->notify(New BookingInformationNotification($propertyListing,$bookingInformation,$owner->name,auth()->user()->name,auth()->user()->getRoleNames()->first(),$request->input('payment_type'),$payableAmount,$nextPaymentDate));
                    auth()->user()->notify(New BookingInformationNotification($propertyListing,$bookingInformation,$owner->name,auth()->user()->name,$customer->type,$request->input('payment_type'),$payableAmount,$nextPaymentDate));
                     $owner->notify(New BookingInformationNotification($propertyListing,$bookingInformation,auth()->user()->name,auth()->user()->name,$owner->getRoleNames()->first(),$request->input('payment_type'),$payableAmount,$nextPaymentDate));
                    $travellerMessage ="Thank you for choosing MY BNB Rentals! Your booking for Property ID".$propertyListing->id." on ".date('M dS Y',strtotime($bookingInformation->check_in))." is confirmed. \r\r We look forward to serving you!";
                     $ownerMessage = "You have a new booking! on Property ID".$propertyListing->id."\r\r Need more details log in to your dashboard.\r\rThank you for using MY BNB RENTALS !";
                    Helper::sendSms("+".auth()->user()->phone,$travellerMessage);
                    Helper::sendSms("+".$owner->phone,$ownerMessage);
                else:
                    BookingPaymentTransactionHistory::create([
                        'booking_information_id'=>$bookingInformation->id,
                        'pay_amount'=>$payableAmount,
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
                endif;
            else:
                 // Or, print errors if the API request wasn't successful
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg"; 
                $tresponse = $response->getTransactionResponse();
                BookingPaymentTransactionHistory::create([
                    'booking_information_id'=>$bookingInformation->id,
                    'pay_amount'=>$payableAmount,
                    'transaction_id'=>$tresponse->getTransId(),
                    'payment_response'=>json_encode($tresponse),
                    'status'=>'failed'
                ]);
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
            session()->put('success',$message_text);
            return response()->json([
                'status'=>true,
                'url'=>route('payment.success'),
            ],200);
        else:
            session()->put('error',$message_text);
            return response()->json([
                'status'=>false,
                'url'=>route('payment.failed'),
            ],500);
        endif;
    }
    
    public function insurance($data,$bookingInformation,$propertyListing,$owner){
        // $check_in=$bookingInformation->check_in;
        // $check_out=$bookingInformation->check_out;
        // $total_guest=$bookingInformation->total_guest;
        // $total_children=$bookingInformation->total_children;
        // $total_night=$bookingInformation->total_night;
        // $next_payment_date=$bookingInformation->next_payment_date;
        // $property_name=$propertyListing->property_name;
        // $name=$owner->name;
        // $email=$owner->email;
        // $total_Amount=$data['Total_amount'];
        // $array = explode('(', $total_Amount);
        // $Total_amount = str_replace('$', '', substr($array[1], 0, -2));
        // $Due_payment=$Total_amount/2;
        // $insurance_amount="";
        // $basicAmount="";
        // if($data['insurance_type']=='Travel'){
        //     $basicAmount=number_format((($Total_amount)*100)/106.95,2);
        //     $number1 = floatval(str_replace(',', '', $basicAmount));
        //     $insurance_amount=$Total_amount-$number1;
        // }else if($data['insurance_type']=='damage'){
        //     $basicAmount=number_format(($Total_amount-55),2);
        //     $number1 = floatval(str_replace(',', '', $basicAmount));
        //     $insurance_amount=$Total_amount-$number1;
        // }else if($data['insurance_type']=='both'){
        //       $basicAmount=number_format((($Total_amount-55)*100)/106.95,2);
        //       $number1 = floatval(str_replace(',', '', $basicAmount));
        //       $insurance_amount=$Total_amount-$number1;
        // }
        
        $url = 'https://staging.csatravelprotection.com/ws/policyrequest';
        $data='xmlrequeststring=<?xml version="1.0" encoding="UTF-8"?>
         <purchaserequest>
            <actioncode>NEW</actioncode>
            <aff>MYBNBREN</aff>
            <producer>MYBNBREN</producer>
            <productclass>GR330</productclass>
            <bookingreservno>AB123456</bookingreservno>
            <numinsured>1</numinsured>
            <departdate>2025-06-11</departdate>
            <returndate>2025-06-21</returndate>
            <tripcost>1000</tripcost>
           <travelers>
             <traveler>
                <travelerfirstname>Ryan</travelerfirstname>
                <travelerlastname>Test</travelerlastname>
              </traveler>
          </travelers>
        <emailaddress>rmy@csatp.com</emailaddress>
          <address1>123 test</address1>
          <city>Detroit</city>
         <state>MI</state>
         <zipcode>48127</zipcode>
         <telephonehome>5865551234</telephonehome>
         <printpolconfltr>3</printpolconfltr>
         <price>69.50</price>
         <paymentmethod>AR</paymentmethod>
         </purchaserequest>';
         
      $headers = array(
      'Host: www.csatravelprotection.com',
      'Content-Length:1132' ,
      'Content-Type: application/x-www-form-urlencoded',
       );
   
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);

 dd($response);
 if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
   } else {
      echo $response;
    }

curl_close($ch);
    }
}
