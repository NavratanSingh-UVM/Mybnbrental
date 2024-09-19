<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyEnquiry extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='property_enquires';
    protected $fillable = [
        'owner_id',
        'property_id',
        'traveller_id',
        'check_in',
        'check_out',
        'no_of_guest',
        'message',
    ];

    public function property() {
        return $this->belongsTo(PropertyListing::class,'property_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'traveller_id','id');
    }
}
