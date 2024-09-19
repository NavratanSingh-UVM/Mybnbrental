<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyListing extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'property_name',
        'property_main_photos',
        'square_feet',
        'property_type_id',
        'bedrooms',
        'sleeps',
        'avg_night_rates',
        'avg_rate_unit',
        'baths',
        'description',
        'country_id',
        'state_id',
        'region_id',
        'city_id',
        'sub_city_id',
        'address',
        'town',
        'zip_code',
        'currency_id',
        'rates_notes',
        'rental_policies',
        'upload_rental_polices',
        'property_website_link',
        'third_party_calender_link',
        'location',
        'iframe_link_google',
        'latitude',
        'longitude',
        'status',
        'youtube_video_link',
        'cancelletion_policies_id'
    ];

    public function region() {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function city() {
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function sub_city() {
        return $this->belongsTo(Cities::class,'sub_city_id','id');
    }

    public function property_aminities() {
        return $this->hasMany(PropertiesAminites::class,'property_id','id')->groupBy('aminities_id');
    }

    public function property_gallery_image() {
        return $this->hasMany(PropertyGallery::class,'property_id')->orderBy('image_order', 'ASC');
    }

    public function property_booking() {
        return $this->hasMany(PropertyBooking::class,'property_id','id');
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function property_types(){
        return $this->belongsTo(PropertyType::class,'property_type_id');
    }

    public function property_rates() {
        return $this->hasMany(PropertyRates::class,'property_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function reviews_rating(){
        return $this->hasMany(PropertyReviewsRating::class,'property_id','id');
    }

    public function enquires() {
        return $this->hasMany(PropertyEnquiry::class,'property_id','id');
    }

    public function icalLink() {
        return $this->hasMany(ImportIcal::class,'property_id','id')->latest();
    }

    public function cancelletionPolicies() {
        return $this->belongsTo(CancellentionPolicy::class,'cancelletion_policies_id','id');
    }

    public function country() {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function property_amenites() {
        return $this->hasMany(PropertiesAminites::class,'property_id','id');
    }
}
