<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OwnerBillingDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\BillingDetailsRequest;
use App\Http\Requests\Api\UpdateBillingDetailsRequest;

class ProfileController extends Controller
{
    public function billingDetails(BillingDetailsRequest $request) {
        if($request->input('billing_details_id') ==null):
            $ownerBillingAddress = OwnerBillingDetails::create([
                'user_id'=>Auth()->user()->id,
                'account_holder_name'=>$request->input('account_holder_name'),
                'bank_name'=>$request->input('bank_name'),
                'account_number'=>$request->input('account_number'),
                'routing_number'=>$request->input('routing_number'),
                'billing_address'=>$request->input('billing_address'),
            ]);
        else:
            $ownerBillingAddress = OwnerBillingDetails::where('id',$request->input('billing_details_id'))->update([
                'user_id'=>Auth()->user()->id,
                'account_holder_name'=>$request->input('account_holder_name'),
                'bank_name'=>$request->input('bank_name'),
                'account_number'=>$request->input('account_number'),
                'routing_number'=>$request->input('routing_number'),
                'billing_address'=>$request->input('billing_address'),
            ]);
        endif;
        if($ownerBillingAddress):
            return response()->json([
                'status'=>true,
                'msg'=>"Billing Details Added Successfully !",
            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Billing Details Not Added, Please Try Aagin"
            ]);
        endif;
    }

    public function getOwnerBillingDetails() {
        $ownerBillingAdress =  OwnerBillingDetails::where('user_id',Auth()->user()->id)->first();
        return response()->json([
            'status'=>true,
            "msg"=>"Owner Billing Details fetch successfully",
            'data'=>$ownerBillingAdress
        ]);
    }

    public function updateOwnerProfile(Request $request) {
        if(($request->has('oldPassword')) && $request->input('oldPassword') !=null):
            if (!Hash::check($request->input('oldPassword'), auth()->user()->password)):
                return response()->json([
                    "status"=>false,
                    "msg"=>"You're old password does not match,Please enter a right old password",
                ]);
            endif;
        endif;
        $path = storage_path('app/public/profile_image');
        if($request->hasFile('file')):
            $profileImage = time().uniqid().'.'.$request->file('file')->getClientOriginalExtension();
           $request->file('file')->move($path,$profileImage);
        endif;
        $user = User::find(Auth()->user()->id)->update([
            'name'=>$request->input('firsName'),
            'email'=>$request->input('email'),
            'country_code'=>$request->input('country_code'),
            'phone'=>$request->input('phone'),
            'image'=> $profileImage??auth()->user()->image,
            'password'=>Hash::make($request->input('newPassword'))??auth()->user()->password,
            'show_password'=>$request->input('newPassword'),
        ]);
        if($user):
            return response()->json([
                'status'=>true,
                'msg'=>"Profile Updated Successfully",
            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Profile Not Updated, Please try again !",
            ]);
        endif;
    }

    public function getOwnerProfileDetails() {
        $user = User::findOrFail(auth()->user()->id);
        return response()->json([
            'status'=>true,
            'msg'=>"Owner Profile Details Fetch successfully",
            'data'=>[
                "id"=>$user->id,
                'country_code'=>$user->country_code,
                'name'=>$user->name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'image'=>$user->image !=null? url('public/storage/profile_image/'.$user->image):"",
            ]
        ]);
    }

    public function updateOwnerBillingDetails(UpdateBillingDetailsRequest $request){
        $ownerBillingAddress = OwnerBillingDetails::where('id',$request->input('id'))->update([
            'user_id'=>Auth()->user()->id,
            'account_holder_name'=>$request->input('account_holder_name'),
            'bank_name'=>$request->input('bank_name'),
            'account_number'=>$request->input('account_number'),
            'routing_number'=>$request->input('routing_number'),
            'billing_address'=>$request->input('billing_address'),
        ]);
        if($ownerBillingAddress):
            return response()->json([
                'status'=>true,
                'msg'=>"Owner Billing details Update Successfully",
            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Owner Billing details Not Update, Please try again !",
            ]);
        endif;


    }


}
