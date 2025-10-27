<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandlingHotel extends Model
{
    protected $fillable = [
        'handling_id',
        'nama',
        'tanggal',
        'harga',
        'pax',
        'kode_booking',
        'rumlis',
        'identitas_koper',
        'status',
        'harga_dasar',
        'supplier',
    ];

    public function handling()
    {
        return $this->belongsTo(Handling::class, 'id');
    }
}
