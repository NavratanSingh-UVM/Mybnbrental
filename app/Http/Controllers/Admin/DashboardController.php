<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PartnerListing;
use App\Models\PropertyListing;
use App\Models\BookingInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index () {
        $totalProperties = PropertyListing::count();
        $featureListing = PropertyListing::where('feature','1')->count();
        $partnerListing = PartnerListing::count();
        $totalBooking = BookingInformation::where('status','confirmed')->count();
        $users = User::whereHas('roles',function($q){
            $q->whereNot('name','super-admin');
        })->latest()->take(10)->get();
        return view('admin.dashboard',compact('totalProperties','featureListing','partnerListing','totalBooking','users'));
    }

    public function editProfile(){
    return view('admin.edit-profile');
    }
    
    public function updateProfile(Request $request){
        $rules = ['firstName' => 'required'];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
           return redirect()->back()->with('error','Name is required');
        }
        
        if(($request->has('oldPassword')) && $request->input('oldPassword') !=null):
            if (!Hash::check($request->input('oldPassword'), auth()->user()->password)) { 
                $request->session()->flash('error', 'Your Old Password does not match');
                return redirect()->back();
             }
        endif;
        $path = storage_path('app/public/profile_image');
        if($request->hasFile('file')):
            $profileImage = time().uniqid().'.'.$request->file('file')->getClientOriginalExtension();
           $request->file('file')->move($path,$profileImage);

        endif;
        $user = User::find(Auth()->user()->id)->update([
            'name'=>$request->input('firstName'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'type'=>'super-admin',
            'image'=> $profileImage??auth()->user()->image,
            'password'=>$request->input('newPassword')!=null?Hash::make($request->input('newPassword')):auth()->user()->password,
            'show_password'=>$request->input('newPassword')!=null?$request->input('newPassword'):auth()->user()->show_password,
        ]);
        if($user):
            return redirect()->back()->with('success','Your Profile Updated Successfully');
        else:
            return redirect()->back()->with('error','Your Profile Not Updated. Please try again');
        endif;
    }
    // Logout Method
    public function logout() {
        Session::flush();
        Auth::logout();
        return to_route('admin.login');
    }
}
