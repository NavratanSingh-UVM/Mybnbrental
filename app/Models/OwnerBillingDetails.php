<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerBillingDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'routing_number',
        'billing_address',
    ];
    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
