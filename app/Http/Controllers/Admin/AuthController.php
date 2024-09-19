<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    Admin Login Form Method Start
    */

    public function index() {
        return view ('admin.auth.login');
    }

    public function doLogin(LoginRequest $request) {
       $creditials = [
        'email'=>$request->input('email'),
        'password'=>$request->input('password')
       ];

       if(auth()->attempt($creditials)):
        //  dd('hello',auth()->user()->getRoleNames()->first());
            if(auth()->user()->getRoleNames()->first() =='Owner' || auth()->user()->getRoleNames()->first() =='Traveller'|| auth()->user()->getRoleNames()->first() =='Partner'):
            Session::flush();
            Auth::logout();
            return response()->json([
                'status'=>'0',
                'msg'=>"Unauthorized Accesss !",
            ],200);
            endif;
            return response()->json([
                'status'=>'1',
                'msg'=>"Login Successfully. Redirecting Please Wait...",
                'url'=>route('admin.dashboard')
            ],200);
       else:
        return response()->json([
            'status'=>'0',
            'msg'=>"Your Credentials invalid,Please try again !",
        ],200);
       endif;
    }

    /*
    Admin Login Form Method End
    */

    public function forgetPassword() {
        return view('admin.auth.forget-password');
    }

    public function sendForgetPasswordLink(Request $request) {
        $rule = [
            'email' => 'required|email|exists:users',
        ];
        $validator = \Validator::make($request->all(),$rule);
        if($validator->fails()):
            return response()->json([
                'status'=>422,
                'errors'=>$validator->errors()
            ],422);
        else:
            $token = Str::random(64);
            try {

                $user = User::where('email',$request->email)->first();
                $checkEmail=DB::table('password_reset_tokens')->where('email',$request->input('email'))->first();

                if($checkEmail ==null){
                   $mail= $user->notify(New PasswordResetNotification ($user->name,$token));
                }else{
                    return response()->json([
                        'status'=>500,
                        'msg'=>'We have Email Already Sent Please check your inbox !'
                    ], 500,);
                }
            } catch (\Throwable $e) {
                return response()->json([
                    'msg'=>$e->getMessage(),
                ]);
            }
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
              ]);
            return response()->json([
                'status'=>'1',
                'msg'=>'We have e-mailed your password reset link!'
            ],200);
        endif;
    }

    public function resetPassword($token){
        return view('admin.auth.reset-password',compact('token'));
    }


    public function passwordReset(Request $request){
        $rule = [
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ];
        $validator = \Validator::make($request->all(),$rule);
        if($validator->fails()):
            return response()->json([
                'status'=>422,
                'errors'=>$validator->errors()
            ],422);
        else:
            $checkToken = DB::table('password_reset_tokens')->where('token',$request->input('token'))->first();
            if(!$checkToken):
                return response()->json([
                    'status'=>500,
                    'msg'=>"Invalid Token Please try again"
                ],500);
            else:
                $user = User::where('email',$checkToken->email)->update([
                    'password'=>Hash::make($request->input('password')),
                    'show_password'=>$request->input('password'),
                ]);
                if($user):
                   DB::table('password_reset_tokens')->where('token',$request->input('token'))->delete();
                    return response()->json([
                        'status'=>200,
                        'msg'=>"Your password has been changed!",
                        'url'=>route('admin.login'),
                    ], 200);
                else:
                    return response()->json([
                        'status'=>500,
                        'msg'=>"Your password has been not changed"
                    ], 500);
                endif;
            endif;
        endif;
    }
}
