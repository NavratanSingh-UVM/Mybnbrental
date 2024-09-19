<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'country_id','state_id','name'
    ];
    
    public function country() {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state() {
        return $this->belongsTo(State::class,'state_id','id');
    }
    protected static function boot() 
    {
        parent::boot();
        static::deleting(function(Region $region) {
            foreach ($region->city()->get() as $city) {
                $city->delete();
            }
        });
        static::deleting(function(Region $region) {
            foreach ($region->subCity()->get() as $subCity) {
                $subCity->delete();
            }
        });
    }
    public function city() {
        return $this->hasMany(City::class,'region_id','id');
    }

    public function subCity() {
        return $this->hasMany(Cities::class,'region_id','id');
    }

    public function getNameAttribute($name) {
        return strlen($name) <=3?htmlspecialchars_decode(strtoupper($name)):htmlspecialchars_decode(ucfirst($name));
    }
}
