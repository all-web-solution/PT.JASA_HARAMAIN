<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'mekkah',
        'medinah',
    ];

    public function travel()
    {
        return $this->belongsTo(Pelanggan::class, 'travel_id');
    }
}
