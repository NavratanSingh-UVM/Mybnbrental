<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'property_id',
        'check_in',
        'check_out',
        'total_amount',
        'total_guest',
        'total_children',
        'total_night',
        'booking_summary',
        'cancelletion_id'
    ];

    public function property(){
        return $this->belongsTo(PropertyListing::class,'property_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function cancelletionPolicies() {
        return $this->belongsTo(CancellentionPolicy::class,'cancelletion_id');
    }

    public function getCheckInAttribute($value) {
        return date('M d Y',strtotime($value));
    }
    public function getCheckOutAttribute($value) {
        return date('M d Y',strtotime($value));
    }
    public function getNextPaymentDateAttribute($value) {
        return $value !=null?date('M d Y',strtotime($value)):"";
    }

    public function bookingTransactionHistory() {
        return $this->hasMany(BookingPaymentTransactionHistory::class,'booking_information_id','id');
    }

    public function cancelBooking() {
        return $this->hasOne(CancelBooking::class,'booking_id','id');
    }
}
