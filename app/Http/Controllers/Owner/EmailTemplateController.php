<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function paymentReminder() {
        $paymentReminder = EmailTemplate::where(['user_id'=>auth()->user()->id,'slug'=>'payment-reminder'])->first();
        if($paymentReminder ==null):
            $paymentReminder = EmailTemplate::where(['user_id'=>'1','slug'=>'payment-reminder'])->first();
        endif;
        return view('owner.payment-reminder',compact('paymentReminder'));
    }

    public function storePaymentRequest (Request $request) {
        if($request->input('id') !=null):
            $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
                'user_id'=>auth()->user()->id,
                'slug'=>'payment-reminder',
                'subject'=>'Payment Reminder',
                'content'=>$request->input('paymnet_reminder_content')
            ]);
        else:
            $paymentReminder = EmailTemplate::create([
                'user_id'=>auth()->user()->id,
                'slug'=>'payment-reminder',
                'subject'=>'Payment Reminder',
                'content'=>$request->input('paymnet_reminder_content')
            ]);
        endif;
        if($paymentReminder):
            session()->flash('success','Payment Reminder Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Payment Reminder Template Not Added Please Try Again !');
           return redirect()->back();
        endif;

    }


    public function cancellationMessage() {
        $cancellationMessage = EmailTemplate::where(['user_id'=>auth()->user()->id,'slug'=>'cancellation-message'])->first();
        if($cancellationMessage ==null):
            $cancellationMessage = EmailTemplate::where(['user_id'=>'1','slug'=>'cancellation-message'])->first();
        endif;
        return view('owner.cancellation-message',compact('cancellationMessage'));
    }

    public function storeCancellationMessage (Request $request) {
        if($request->input('id') !=null):
            $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
                'user_id'=>auth()->user()->id,
                'slug'=>'cancellation-message',
                'subject'=>'Cancellation Message',
                'content'=>$request->input('cancelletion_messeage_content')
            ]);
        else:
            $paymentReminder = EmailTemplate::create([
                'user_id'=>auth()->user()->id,
                'slug'=>'cancellation-message',
                'subject'=>'Cancellation Message',
                'content'=>$request->input('cancelletion_messeage_content')
            ]);
        endif;
        if($paymentReminder):
            session()->flash('success','Cancellation Message Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Cancellation Message Template Not Added Please Try Again !');
           return redirect()->back();
        endif;
    }
    public function welcomeMessage() {
        $welcomeMessage = EmailTemplate::where(['user_id'=>auth()->user()->id,'slug'=>'welcome-message'])->first();
        if($welcomeMessage ==null):
            $welcomeMessage = EmailTemplate::where(['user_id'=>'1','slug'=>'welcome-message'])->first();
        endif;
        return view('owner.welcome-message',compact('welcomeMessage'));
    }

    public function storeWelcomeMessage(Request $request) {
        if($request->input('id') !=null):
            $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
                'user_id'=>auth()->user()->id,
                'slug'=>'welcome-message',
                'subject'=>'Welcome Message',
                'content'=>$request->input('welcome_message_content')
            ]);
        else:
            $paymentReminder = EmailTemplate::create([
                'user_id'=>auth()->user()->id,
                'slug'=>'welcome-message',
                'subject'=>'Welcome Message',
                'content'=>$request->input('welcome_message_content')
            ]);
        endif;
        if($paymentReminder):
            session()->flash('success','Welcome Message Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Welcome Message Template Not Added Please Try Again !');
           return redirect()->back();
        endif;
    }

    public function inviteToLeaveAReview() {
        $inviteToLeaveAReview = EmailTemplate::where(['user_id'=>auth()->user()->id,'slug'=>'invite-to-leave-a-review'])->first();
        if($inviteToLeaveAReview ==null):
            $inviteToLeaveAReview = EmailTemplate::where(['user_id'=>'1','slug'=>'invite-to-leave-a-review'])->first();
        endif;
        return view('owner.invite-to-leave-a-review',compact('inviteToLeaveAReview'));
    }

    public function storeInviteToLeaveAReview(Request $request) {
        if($request->input('id') !=null):
            $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
                'user_id'=>auth()->user()->id,
                'slug'=>'invite-to-leave-a-review',
                'subject'=>'Invite to leave a review',
                'content'=>$request->input('invite_to_leave_a_review')
            ]);
        else:
            $paymentReminder = EmailTemplate::create([
                'user_id'=>auth()->user()->id,
                'slug'=>'invite-to-leave-a-review',
                'subject'=>'Invite to leave a review',
                'content'=>$request->input('invite_to_leave_a_review')
            ]);
        endif;
        if($paymentReminder):
            session()->flash('success','Invite to leave a review Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Invite to leave a review Template Not Added Please Try Again !');
           return redirect()->back();
        endif;
    }

}
