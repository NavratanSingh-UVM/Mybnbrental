<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyExportIcal extends Model
{
    use HasFactory;
    protected $fillable  = [
        'property_id',
        'ical_file_name'
    ];
}
