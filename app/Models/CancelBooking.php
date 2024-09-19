<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'cancellention_policies_id',
        'cancel_reason_id',
         'refund_id',
        'payment_response',
        'refundable_amount',
        'note',
    ];

    public function bookingInformation() {
        return $this->belongsTo(BookingInformation::class,'booking_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M dS Y',strtotime($value));
    }

    public function cancellentionReason() {
        return $this->belongsTo(CancellentionReason::class,'cancel_reason_id','id');
    }
}
