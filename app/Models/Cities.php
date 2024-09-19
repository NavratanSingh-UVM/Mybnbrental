<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'sub_cities';
    protected $fillable = [
        'country_id','state_id','region_id','city_id','name'
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
    public function city() {
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function getNameAttribute($name) {
        return strlen($name) <=3?strtoupper($name):ucfirst($name);
    }

}
