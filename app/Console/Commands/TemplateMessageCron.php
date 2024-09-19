<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\TemplateMessages;
use Illuminate\Support\Facades\Mail;


class TemplateMessageCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templateMessage:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends daily reminder emails to users';

    /**
     * Execute the console command.
     */
    public function handle():void
    {
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d H:i");
        $TemplateMessage=TemplateMessages::get();
      
        foreach ($TemplateMessage as $template) {
            $setTime = date('Y-m-d H:i',strtotime($template->msg_send_time));
          if($setTime==$timestamp){
                $users = User::where('id',$template->user_id)->where('status', 1)->get();
                    foreach ($users as $user) {
                    Mail::raw("This is automatically generated everyMinute Update", function ($mail) use ($user) {
                             $mail->from('support@mybnbrentals.com');
                             $mail->to($user->email)
                                ->subject('Testing event!') 
                                ->view('owner.email-template.templateMessage','template');
                         });
                 }
                 $this->info('Template message emails sent successfully!');
                 log::info("msg send successfully",([$timestamp,$setTime]));
            }
        }
    }
}
