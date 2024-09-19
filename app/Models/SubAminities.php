<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAminities extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'main_aminities_id',
        'name',
        ''
    ];
    public function mainAminities() {
        return $this->belongsTo(MainAminity::class,'main_aminities_id','id');
    }

}
