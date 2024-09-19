<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerPaymentTransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'traveler_id',
        'total_amount',
        'type',
        'payment_status',
        'payment_response',
    ];

    
}
