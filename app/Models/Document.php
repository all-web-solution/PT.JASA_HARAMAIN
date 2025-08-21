<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'visa',
        'vaksin', // e.g., 'pesawat', 'bus', 'mobil'
        'tasreh_roudoh' // e.g., 'pesawat', 'bus', 'mobil'
    ];

    public function travel()
    {
        return $this->belongsTo(Pelanggan::class, 'travel_id');
    }
}
