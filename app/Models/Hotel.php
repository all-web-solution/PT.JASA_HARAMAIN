<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'checkin',
        'checkout',
        'room_type',
        'star',
        'travel_id',
    ];

    public function travel()
    {
        return $this->belongsTo(Pelanggan::class, 'travel_id');
    }
}
