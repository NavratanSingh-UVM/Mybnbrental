<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'country_id','state_id','region_id','name'
    ];
    public function country() {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state() {
        return $this->belongsTo(State::class,'state_id','id');
    }
    public function region() {
        return $this->belongsTo(Region::class,'region_id','id');
    }
    protected static function boot() 
    {
        parent::boot();
        static::deleting(function(City $city) {
            foreach ($city->subCity()->get() as $city) {
                $city->delete();
            }
        });
    }

    public function subCity() {
        return $this->hasMany(Cities::class,'city_id','id');
    }
    public function getNameAttribute($name) {
        return strlen($name) <=3?strtoupper($name):ucfirst($name);
    }

}
