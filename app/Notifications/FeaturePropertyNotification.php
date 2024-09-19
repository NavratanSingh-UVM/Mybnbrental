<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeaturePropertyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $featurePropertyDetails;
    public function __construct($featurePropertyDetails)
    {
        //
        $this->featurePropertyDetails = $featurePropertyDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Feature Propery Listing')
            ->view('email-template.feautre-property-notification',['content'=>$this->featurePropertyDetails]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
