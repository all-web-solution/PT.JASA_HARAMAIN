<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'bandara_asal',
        'bandara_tujuan',
        'tanggal_berangkat',
        'maskapai',
        'transit',
        'pax',
        'description'
    ];


}
