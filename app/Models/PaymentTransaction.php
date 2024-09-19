<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'no_of_property',
        'year',
        'coupon',
        'total_amount',
        'type',
        'transaction_id',
        'payment_status',
        'payment_response',
    ];

    public function package_name() {
        return $this->belongsTo(Package::class,'package_id','id');
    }
    public function users() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
