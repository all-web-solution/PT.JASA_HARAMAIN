<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'kota_asal',
        'tanggal_berangkat',
        'maskapai',
        'transit',
    ];

    
}
