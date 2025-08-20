<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'city',
        'stars',
        'price_per_night',
        'checkin',
        'checkout',
        'room_type',
        'qty_rooms',
        'price'
    ];
}
