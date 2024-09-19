<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Http\Helper\Helper;
use Illuminate\Http\Request;
use App\Mail\OwnerRegistrationMail;
use App\Http\Controllers\Controller;
use App\Mail\OwnerRegistrationEmail;
// use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\OwnerLoginRequest;
use App\Notifications\RegistrationNotification;
use App\Http\Requests\Auth\OwnerRegistrationRequest;

class AuthController extends Controller
{
    public function OwnerRegistration(OwnerRegistrationRequest $request){
        $userDetails = [
            'name'=>$request->input('full_name'),
            'email'=>$request->input('username'),
            'password'=>Hash::make($request->input('password')),
            'phone'=>$request->input('country_code').$request->input('phone'),
            'show_password'=>$request->input('password'),
            'type'=>$request->input('type'),
        ];
        $user = User::create( $userDetails);
        $user->notify(New RegistrationNotification($userDetails));
        $message = "Welcome to MY BNB RENTALS ! \r\r Congratulations! Your account is all set up and ready to go. We're thrilled to have you on board.\r\r Thank you for choosing My BNB RENTALS! We look forward to providing you with a great experience.";
        Helper::sendSms("+".$request->input('country_code').$request->input('phone'),$message);
        $user->assignRole($request->input('type'));
        if($request->ajax()):
            if($user):
                return response()->json([
                    'status'=>'1',
                    'msg'=>"Your Registration has been successfully ! Please Login Now..",
                    'url'=>route('frontend.index')
                ]);
            else:
                return response()->json([
                    'status'=>'1',
                    'msg'=>"Your Registration has been not  proceed ! Please try again"
                ]);
            endif;
        else:
            if($user):
                return redirect()->back()->with('success','Your Registration has been successfully ! Please Login Now.. ');
            else:
                return redirect()->back()->with('error','Your Registration has been not  proceed ! Please try again');
            endif;
            
        endif;
    }

    public function ownerLogin(OwnerLoginRequest $request){
        $creditials = [
            'email'=>$request->input('username'),
            'password'=>$request->input('password'),
            'type'=>$request->input('Check')

        ];
          $userDetails=user::where('email', '=', $request->input('username'))->first();
        if(Auth::attempt(['email' => $request->input('username'), 'password' =>$request->input('password')])):
            if(Auth::user()->status=='0'):
                Auth::logout();
                return response()->json([
                    'status'=>'0',
                    'msg'=>'Your Account Has been Blocked, Please Contact a administrator',
                ]);
            else:
               // if(auth()->user()->getRoleNames()->first() =='Owner'):
                  if($request['Check']==$userDetails->type && $request['Check']=='Owner'):
                    $url = route('owner.dashboard');
                    elseif($request['Check']==$userDetails->type && $request['Check']=='Partner'):  
                        $url = route('partner.dashboard');
                else:
                    if(Session::get('current_url')):
                        $url = Session::get('current_url');
                    else:
                        $url = route('traveller.dashboard');
                    endif;
                endif;
                return response()->json([
                    'status'=>'1',
                    'msg'=>"Login Successfully. Redirecting Please Wait...",
                    'url'=>$url
                ]);
            endif;
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>"Your Credentials invalid,Please try adain !",
            ],200);
        endif;
    }
}
