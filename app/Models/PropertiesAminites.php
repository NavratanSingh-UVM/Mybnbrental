<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertiesAminites extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'property_id',
        'aminities_id',
        'sub_aminities_id'
    ];
    
    public function mainAmenities() {
        return $this->belongsTo(MainAminity::class,'aminities_id','id');
    }

    public function subAminites() {
        return $this->belongsTo(SubAminities::class,'sub_aminities_id','id');
    }
}
