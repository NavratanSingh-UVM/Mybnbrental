<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Owner\BillingDetailsRequst;
use App\Models\OwnerBillingDetails;
use App\Models\User;

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
        $this->validate($request, [
            'newPassword' => 'required',
            'confirmNewPassword' => 'required_with:newPassword|same:newPassword|min:8|different:password',
        ]);
        if (!\Hash::check($request->input('oldPassword'), auth()->user()->password)) { 
            $request->session()->flash('error', 'Your Old Password does not match');
            return redirect()->back();
         }
        $path = storage_path('app/public/profile_image');
        if($request->hasFile('file')):
            $profileImage = time().uniqid().'.'.$request->file('file')->getClientOriginalExtension();
           $request->file('file')->move($path,$profileImage);

        endif;
        // dd($request->all());
        $user = User::find(Auth()->user()->id)->update([
            'name'=>$request->input('firsName'),
            'email'=>$request->input('lastname'),
            'phone'=>$request->input('phone'),
            'image'=> $profileImage,
            'password'=>\Hash::make($request->input('newPassword')),
            'show_password'=>$request->input('newPassword'),
        ]);
        if($user):
            return redirect()->back()->with('success','Your Profile Updated Successfully');
        else:
            return redirect()->back()->with('error','Your Profile Not Updated. Please try again');
        endif;
    }
}
