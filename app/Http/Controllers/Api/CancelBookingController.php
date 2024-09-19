<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CancelBooking;
use App\Models\PropertyBooking;
use App\Models\BookingInformation;
use App\Models\CancellentionReason;
use App\Http\Controllers\Controller;
use App\Models\CancellationSlabFees;
use App\Http\Requests\Api\CancellentionBookingRequest;

class CancelBookingController extends Controller
{
    public function cancellentionReasonList() {
        $cancellentionReasons = CancellentionReason::get(['id','name']);
        return response()->json([
            "status"=>true,
            'msg'=>"Cancellention Reason Fetched Successfully",
            'data'=>$cancellentionReasons
        ]);
    }

    public function cancelBooking(CancellentionBookingRequest $request) {
        $refundAbleAmount = 0;
        $daysBefore = false;
        $daysAfter = false;
        $booking  = BookingInformation::where('id',$request->input('booking_id'))->first();
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
        $cancelBooking = CancelBooking::create([
            'booking_id'=>$booking->id,
            'cancellention_policies_id'=>$booking->cancelletion_id,
            'cancel_reason_id'=>$request->input('cancellention_reason'),
            'refundable_amount'=>$refundAbleAmount,
            'note'=>$request->input('reason')
        ]);
        if($cancelBooking):
            BookingInformation::where('id',$booking->id)->update([
                'status'=>'cancelled',
            ]);
            PropertyBooking::where(['property_id'=>$booking->property_id,'start_date'=>Carbon::parse($booking->check_in)->format('Y-m-d h:i:s'),'end_date'=>Carbon::parse($booking->check_out)->format('Y-m-d h:i:s')])->delete();
            return response()->json([
                'status'=>true,
                'msg'=>"You're booking  cancel successfully",
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"You're booking not cancel, Please try again",

            ],500);
        endif;        
    }

    private function dates($value) {
        return $value*60*60/86400;
    }

    public function cancelBookingList() {
        $cancelBookingList =[];
        $cancelBookings = CancelBooking::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
            $traveller->whereHas('bookingInformation',function ($u){
                $u->where('user_id',auth()->user()->id)->where('status','cancelled');
            });
        })->with('bookingInformation')->orderBy('id','desc')->get();
        foreach($cancelBookings as $cancelBooking):
            $cancelBookingList[] = [
                'id'=>$cancelBooking->id,
                'booking_id'=>$cancelBooking->booking_id,
                'check_in'=>$cancelBooking->bookingInformation->check_in,
                'check_out'=>$cancelBooking->bookingInformation->check_out,
                'total_booking_fees'=>$cancelBooking->bookingInformation->total_amount,
                'paid_amount'=>$cancelBooking->bookingInformation->total_amount-$cancelBooking->bookingInformation->dues_amount,
                'refund_amount'=>$cancelBooking->refundable_amount,
                'cancel_reason'=>$cancelBooking->cancellentionReason->name,
                'cancel_date'=>$cancelBooking->created_at
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Cancellation Booking List",
            'data'=>$cancelBookingList
        ]);
    }
}
