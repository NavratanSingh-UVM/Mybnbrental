<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
       'tax', 'country_id','state_id'
    ];
    public function country() {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state() {
        return $this->belongsTo(State::class,'state_id','id');
    }
}
