<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyBooking extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
      "property_id",
        "start_date",
        "end_date",
        "rate",
        "minimum_stay",
        "events",
        "booking_time_stamps",
        'type'
    ];
}
