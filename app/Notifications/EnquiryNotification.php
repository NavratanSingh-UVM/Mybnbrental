<?php

namespace App\Notifications;

use App\Models\PropertyListing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnquiryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $user;
    protected $property;
    protected $requestData;
    protected $travellerName;
    public function __construct(User $user,PropertyListing $property,$requestData,$travellerName)
    {
        $this->user = $user;
        $this->property = $property;
        $this->requestData = $requestData;
        $this->travellerName = $travellerName;
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
        $subject = "Inquiry Email";
        
        $emailContent['property_url'] =route('property.listing.details',$this->property->id);
        $emailContent['property_image'] =url('public/storage/upload/property_image/main_image/'.$this->property->property_main_photos);
        $emailContent['property_name'] =$this->property->property_name;
        $emailContent['property_type'] =$this->property->property_types->property_type_name;
        $emailContent['request_data'] = $this->requestData;
        $emailContent['traveller_name'] = $this->travellerName;
        return (new MailMessage)
        ->subject($subject)
        ->view(
            'email-template.enquiry',['emailContent'=>$emailContent]
        );
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
