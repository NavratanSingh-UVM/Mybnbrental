<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Helper\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Mail\OwnerRegistrationMail;
use App\Http\Controllers\Controller;
use App\Mail\OwnerRegistrationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RegistrationNotification;

class AuthController extends Controller
{
    public function registration(AuthRequest $request) {
        $userDetails = [
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'country_code'=>$request->input('country_code'),
            'phone'=>$request->input('phone'),
            'show_password'=>$request->input('password'),
        ];
        $user = User::create( $userDetails);
        $user->notify(New RegistrationNotification($userDetails));
        $message = "Welcome to MY BNB RENTALS ! \r\r Congratulations! Your account is all set up and ready to go. We're thrilled to have you on board.\r\r Thank you for choosing My BNB RENTALS! We look forward to providing you with a great experience.";
        Helper::sendSms("+".$request->input('country_code').$request->input('phone'),$message);
        $role = Role::findOrFail($request->input('role_id'))->name;
        $user->assignRole($role);
        if($user):
            return response()->json([
                'status'=>true,
                'msg'=>"Your Registration has been successfully",
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"You have not been registered,Please try again",
            ],500);
        endif;
    }

    public function login(LoginRequest $request) {
        if(Auth::attempt(['email' => $request->input('email'), 'password' =>$request->input('password')])):
            if(Auth::user()->status=='0'):
                $token = auth()->user()->token();
                $token->revoke();
                return response()->json([
                    'status'=>false,
                    'msg'=>'Your Account Has been Blocked, Please Contact a administrator',
                ]);
            else:
                
                $token = auth()->user()->createToken('Login Key')->accessToken;
                 
                return response()->json([
                    'status'=>true,
                    'msg'=>"Login Successfully.",
                    'user_id'=>auth()->user()->id,
                    'token'=>$token,
                    'user_type'=>auth()->user()->getRoleNames()->first()
                ]);
            endif;
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Your Credentials invalid,Please try adain !",
            ],200);
        endif;
    }

    public function sendForgetPasswordLink(Request $request) {
        $rule = [
            'email' => 'required|email|exists:users',
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()):
            return response()->json([
                'status'=>false,
                'msg'=>$validator->errors()->first()
            ],422);
        else:
            $token = Str::random(64);
            try {

                $user = User::where('email',$request->email)->first();
                $checkEmail=DB::table('password_reset_tokens')->where('email',$request->input('email'))->first();

                if($checkEmail ==null){

                    $mail=Mail::send('owner.email-template.forget-password', ['token' => $token,'name'=>$user->name], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Reset Password');
                    });
                }else{
                    return response()->json([
                        'status'=>false,
                        'msg'=>'We have Email Already Sent Please check your inbox !'
                    ], 500,);
                }
            } catch (\Throwable $e) {
                return response()->json([
                    'status'=>false,
                    'msg'=>$e->getMessage(),
                ]);
            }
          if($mail):
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
              ]);
            return response()->json([
                'status'=>true,
                'msg'=>'We have e-mailed your password reset link!'
            ],200);
          else:
            return response()->json([
                'status'=>false,
                'msg'=>'Internal Server Error'
            ],500);
          endif;
        endif;
    }
}
