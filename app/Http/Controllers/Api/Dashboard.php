<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyRates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Models\PropertyBooking;

class Dashboard extends Controller
{
    public function logout(Request $request) {
        $token = auth()->user()->token();
        $token->revoke();
        return response()->json([
            'status' => true,
            'msg' => 'You have been successfully logged out.'
        ], 200);
    }

    public function changeUserType(Request $request){
        if(auth()->user()->roles()->first()->id ==$request->input('role_id'))
        return response()->json([
            'status'=>false,
            'msg'=>'Not Allowed change the role'
        ]);
        auth()->user()->roles()->sync([$request->input('role_id')]);
        return response()->json([
            'status'=>true,
            'msg'=>'Role Changed Sucessfully'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request) {
        if(($request->has('old_password')) && $request->input('old_password') !=null):
            if (!Hash::check($request->input('old_password'), auth()->user()->password)) {
                return response()->json([
                    'status'=>false,
                    'msg'=>"You're old password does'nt match"
                ]);
             }
        endif;

        $changePassword = User::find(auth()->user()->id)->update([
            'password'=>Hash::make($request->input('confirm_password')),
            'show_password'=>$request->input('confirm_password')
        ]);
        if(!$changePassword):
            return response()->json([
                'status'=>false,
                'msg'=>"You're password not change,Please try again"
            ]);
        else:
            return response()->json([
                'status'=>true,
                'msg'=>"You're password change successfully"
            ]);
        endif;

    }

    public function getCalanderData(Request $request){
        $calneder = [];
        $selectDates =[];
        $propertyRates = PropertyRates::where('property_id',$request->input('property_id'))->get();
        foreach($propertyRates as $propertyRate):
            $startdate =$propertyRate->from_date;
            $enddate = $propertyRate->to_date;
            $dateRange = CarbonPeriod::create(Carbon::parse($startdate),Carbon::parse($enddate));
            $days = array_map(fn ($date) => $date->format('d-m-Y'), iterator_to_array($dateRange));

            foreach( $days as $date):
                $propertyRat =   PropertyRates::where('property_id',$request->input('property_id'))->where(function($query) use ($date) {
                    $query->whereDate('from_date', '<=', Carbon::parse($date)->format('Y-m-d'))
                          ->whereDate('to_date', '>=',Carbon::parse($date)->format('Y-m-d'));
                })
                ->orWhere(function($query) use ($date) {
                    $query->whereDate('from_date', '>=', Carbon::parse($date)->format('Y-m-d'))
                          ->whereDate('to_date', '<=', Carbon::parse($date)->format('Y-m-d'));
                })
                ->latest()->first();
                if($propertyRat !=null)
                    $selectDates[]=[
                     'price'=>$propertyRat->nightly_rate,
                     'date'=>$date
                    ];

            endforeach;
        endforeach;
        $propertyBookings = PropertyBooking::where('property_id',$request->input('property_id'))->get();
        // $calneder['property_booking'] = $propertyBookings->toArray();
        // $calneder []=   $selectedDate;
        return response()->json([
            'status'=>true,
            'msg'=>"Calneder rates fetched successfully",
            'data'=>[
                'calender'=>$selectDates,
                'property_booking'=>$propertyBookings
            ],
        ]);

    }







}
