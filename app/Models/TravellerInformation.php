<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravellerInformation extends Model
{
    use HasFactory;
    protected $casts = [
        'traveler_booking_information' => 'array',
    ];
    protected $fillable = [
        'user_id',
        'property_id',
        'unique',
        'check_in',
        'check_out',
        'guest',
        'children',
        'pet',
        'traveler_name',
        'traveler_email',
        'traveler_phone',
        'special_request',
        'traveler_booking_information',
    ];

    public function property() {
        return $this->belongsTo(PropertyListing::class,'property_id','id');
    }

    public function traveler_payment_history_transaction() {
        return $this->hasOne(TravelerPaymentTransactionHistory::class,'traveler_id','id');
    }

    public function getCheckInAttribute($value){
        return date('dS M Y',strtotime($value));
    }
    public function getCheckOutAttribute($value){
        return date('dS M Y',strtotime($value));
    }

    public function getTravelerBookingInformationAttribute($value) {
        // dd(json_decode($value,true));
        return json_decode(json_decode($value,true),true);
    }
}
