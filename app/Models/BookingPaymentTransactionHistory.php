<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPaymentTransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_information_id',
        'pay_amount',
        'transaction_id',
        'payment_response',
        'status',
    ];

    public function bookingInformation(){
        return $this->belongsTo(BookingInformation::class,'booking_information_id');
        
    }
}
