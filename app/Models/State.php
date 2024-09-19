<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'country_id',
        'name'
    ];
    public function country() {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    protected static function boot() 
    {
        parent::boot();
        static::deleting(function(State $state) {
            foreach ($state->region()->get() as $region) {
                $region->delete();
            }
        });
        static::deleting(function(State $state) {
            foreach ($state->city()->get() as $city) {
                $city->delete();
            }
        });
        static::deleting(function(State $state) {
            foreach ($state->subCity()->get() as $subCity) {
                $subCity->delete();
            }
        });
    }

    public function region() {
        return $this->hasMany(Region::class,'state_id','id');
    }
    public function city() {
        return $this->hasMany(City::class,'state_id','id');
    }

    public function subCity() {
        return $this->hasMany(Cities::class,'state_id','id');
    }

    public function getNameAttribute($name) {
        return strlen($name) <=3?strtoupper($name):ucfirst($name);
    }
}
