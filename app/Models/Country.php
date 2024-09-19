<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'name',
        'status'
    ];
    /**
        * Override parent boot and Call deleting event
        *
        * @return void
    */
    protected static function boot() 
    {
        parent::boot();

        static::deleting(function(Country $country) {
            foreach ($country->state()->get() as $state) {
                $state->delete();
            }
        });

        static::deleting(function(Country $country) {
            foreach ($country->region()->get() as $region) {
                $region->delete();
            }
        });
        static::deleting(function(Country $country) {
            foreach ($country->city()->get() as $city) {
                $city->delete();
            }
        });

        static::deleting(function(Country $country) {
            foreach ($country->subCity()->get() as $subCity) {
                $subCity->delete();
            }
        });
    }

    public function state() {
        return $this->hasMany(State::class,'country_id','id');
    }

    public function region() {
        return $this->hasMany(Region::class,'country_id','id');
    }
    public function city() {
        return $this->hasMany(City::class,'country_id','id');
    }

    public function subCity() {
        return $this->hasMany(Cities::class,'country_id','id');
    }

    public function getNameAttribute($name) {
        return strlen($name) <=3?strtoupper($name):ucfirst($name);
    }
}
