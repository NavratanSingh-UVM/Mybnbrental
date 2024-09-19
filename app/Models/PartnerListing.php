<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerListing extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'bussiness_category_id',
        'title',
        'address',
        'description',
        'email',
        'phone',
        'website',
        'location',
        'state_id',
        'region_id',
        'city_id',
    ];
    /**
        * Override parent boot and Call deleting event
        *
        * @return void
    */
    protected static function boot() 
    {
        parent::boot();

        static::deleting(function(PartnerListing $PartnerListing) {
            foreach ($PartnerListing->partnerListingGalleryImage()->get() as $partnerListingGalleryImage) {
                $partnerListingGalleryImage->delete();
            }
        });
    }

    public function partnerListingGalleryImage() {
        return $this->hasMany(PartnerListingGalleryImage::class,'partner_listing_id','id');
    }

    public function user() {
        return $this->BelongsTo(User::class,'user_id','id');
    }
}
