<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerListingGalleryImage extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'partner_listing_id',
        'image'
    ];
}
