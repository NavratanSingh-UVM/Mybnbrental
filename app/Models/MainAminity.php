<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainAminity extends Model
{
    use HasFactory,SoftDeletes;
    protected $cascadeDeletes = ['sub_aminities'];
    protected $fillable = [
        'aminity_name',
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

        static::deleting(function(MainAminity $MainAminity) {
            foreach ($MainAminity->subAminities()->get() as $subAminities) {
                $subAminities->delete();
            }
        });
    }

    public function subAminities() {
        return $this->hasMany(SubAminities::class,'main_aminities_id');
    }

}
