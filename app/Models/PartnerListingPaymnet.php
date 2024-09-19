<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerListingPaymnet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'no_of_listing',
        'no_year',
        'total_amount',
        'payment_status',
        'payment_type',
        'payment_response',
    ];
}
