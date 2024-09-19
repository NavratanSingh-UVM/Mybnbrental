<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;

class EmailTemplateController extends Controller
{
    public function paymentReminder () {
        $paymentReminder = EmailTemplate::where(['user_id'=>auth()->user()->id,'slug'=>'payment-reminder'])->first();
        return view('admin.email-template.payment-reminder',compact('paymentReminder'));
        
    }

    public function storePaymentRequest(Request $request) {
        $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
            'slug'=>'payment-reminder',
            'subject'=>'Payment Reminder',
            'content'=>$request->input('paymnet_reminder_content')
        ]);
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
        return view('admin.email-template.cancellention',compact('cancellationMessage'));
    }

    public function storeCancellationMessage (Request $request) {
        $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
            'slug'=>'cancellation-message',
            'subject'=>'Cancellation Message',
            'content'=>$request->input('cancelletion_messeage_content')
        ]);
        if($paymentReminder):
            session()->flash('success','Cancellation Message Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Cancellation Message Template Not Added Please Try Again !');
           return redirect()->back();
        endif;
    }

    public function welcomeMessage() {
        $welcomeMessage = EmailTemplate::where(['slug'=>'welcome-message'])->first();
        return view('admin.email-template.welcome',compact('welcomeMessage'));
    }

    public function storeWelcomeMessage(Request $request) {
        $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
            'slug'=>'welcome-message',
            'subject'=>'Welcome Message',
            'content'=>$request->input('welcome_message_content')
        ]);
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
        return view('admin.email-template.invite-to-leave-a-review',compact('inviteToLeaveAReview'));
    }

    public function storeInviteToLeaveAReview(Request $request) {
        $paymentReminder = EmailTemplate::findOrFail($request->input('id'))->update([
            'slug'=>'invite-to-leave-a-review',
            'subject'=>'Invite to leave a review',
            'content'=>$request->input('invite_to_leave_a_review')
        ]);
        if($paymentReminder):
            session()->flash('success','Invite to leave a review Template Added Successfully !');
            return redirect()->back();
        else:
            session()->flash('error','Invite to leave a review Template Not Added Please Try Again !');
           return redirect()->back();
        endif;
    }
}
