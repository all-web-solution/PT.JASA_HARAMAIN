<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelBoking extends Model
{
    protected $fillable = [
        'hotel_id',
        'checkin',
        'checkout',
        'room_type',
        'qty_rooms',
        'price'
    ];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
}
