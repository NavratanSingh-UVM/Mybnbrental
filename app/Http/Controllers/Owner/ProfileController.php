<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Owner\BillingDetailsRequst;
use App\Models\OwnerBillingDetails;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function billingDetails(Request $request){
        $ownerBillingAdress =  OwnerBillingDetails::where('user_id',Auth()->user()->id)->first();
        return view('owner.billing-details',compact('ownerBillingAdress'));
    }

    public function storeBillingDetails(BillingDetailsRequst $request){
        if($request->input('billing_details_id') ==""):
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
            return redirect()->back()->with('success','Your Billing Address Added Successfully');
        else:
            return redirect()->back()->with('error','Your Billing Address Not Added. Please try again');
        endif;
    }

    public function editProfile () {
        return view('owner.edit-profile');
    }

    public function updateProfile(Request $request){
        if(($request->has('oldPassword')) && $request->input('oldPassword') !=null):
            if (!Hash::check($request->input('oldPassword'), auth()->user()->password)) { 
                $request->session()->flash('error', 'Your Old Password does not match');
                return redirect()->back();
            }
        endif;
        $path = public_path('storage/profile_image');
        if($request->hasFile('file')):
            $profileImage = time().uniqid().'.'.$request->file('file')->getClientOriginalExtension();
           $request->file('file')->move($path,$profileImage);

        endif;
        $user = User::find(Auth()->user()->id)->update([
            'name'=>$request->input('firsName'),
            'email'=>$request->input('lastname'),
            'phone'=>$request->input('phone'),
            'image'=> $profileImage??auth()->user()->image,
            'type'=>'Owner',
            'password'=>Hash::make($request->input('newPassword'))??auth()->user()->password,
            'show_password'=>$request->input('newPassword'),
        ]);
        if($user):
            return redirect()->back()->with('success','Your Profile Updated Successfully');
        else:
            return redirect()->back()->with('error','Your Profile Not Updated. Please try again');
        endif;
    }
}
