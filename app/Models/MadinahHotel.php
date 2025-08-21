<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MadinahHotel extends Model
{
    protected $fillable = [
        'check_in',
        'check_out',
        'hotel_name',
        'room_type',
        'bintang', // Optional field for hotel star rating
    ];
}
