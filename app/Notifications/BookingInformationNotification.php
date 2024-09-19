<?php

namespace App\Notifications;

use App\Models\BookingInformation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\PropertyListing;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingInformationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $name;
    protected $propertyListing;
    protected $bookingInformation;
    protected $travellerName;
    protected $role;
    protected $paymentType;
    protected $payableAmount;
    protected $nextPaymentDate;

    public function __construct(PropertyListing $propertyListing,BookingInformation $bookingInformation,$name,$travellerNane,$role,$paymentType,$payableAmount,$nextPaymentDate)
    {
        $this->name = $name;
        $this->travellerName = $travellerNane;
        $this->propertyListing = $propertyListing;
        $this->bookingInformation = $bookingInformation;
        $this->role = $role;
        $this->paymentType = $paymentType;
        $this->payableAmount = $payableAmount;
        $this->nextPaymentDate = $nextPaymentDate;
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
        $subject = "Booking Confimation";
        return (new MailMessage)
        ->subject($subject)
        ->view('email-template.booking-information',['bookingInformation'=>$this->bookingInformation,'property'=>$this->propertyListing,'travellerName'=>$this->travellerName,'name'=>$this->name,'role'=>$this->role,'paymentType'=>$this->paymentType,'payableAmount'=>$this->payableAmount,'nextPaymentDate'=>$this->nextPaymentDate]);
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
