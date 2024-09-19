<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyListing;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TemplateMessages extends Model
{
    use HasFactory;
    protected $table="template_messages";
    protected $fillable = [
        "template_name",
        "user_id",
        "message",
        "property_listing",
        "scheduling",
        "day",
        "time",
        "msg_send_time"
    ];
    public function PropertyDetails(){
        return $this->belongsTo(PropertyListing::class,'property_listing_id','id');
    }
}
