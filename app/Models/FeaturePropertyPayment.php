<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class FeaturePropertyPayment extends Model
{
    use HasFactory,HasJsonRelationships;
    protected $fillable = [
        'user_id',
        'property_id',
        'month',
        'amount',
        'payment_type',
        'transaction_id',
        'payment_status',
        'payment_response'
    ];

    public function getPropertyIdAttribute($value) {
       return implode(",",json_decode($value));
    }

    public function users() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function property() {
        return $this->belongsToJson(PropertyListing::class,'property_id','id');
    }



}
