<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyRates extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'property_id',
        'session_name',
        'from_date',
        'to_date',
        'nightly_rate',
        'weekly_rate',
        'weekend_rates',
        'monthly_rate',
        'minimum_stay',
    ];

    public function getFromDateAttribute($value) {
        return date('m/d/Y',strtotime($value));
    }
    public function getToDateAttribute($value) {
        return date('m/d/Y',strtotime($value));
    }
}
