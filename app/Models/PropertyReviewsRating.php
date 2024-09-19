<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyReviewsRating extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'property_id',
        'reviews_heading',
        'guest_name',
        'place',
        'reviews',
        'rating',
        'email',
    ];
}
