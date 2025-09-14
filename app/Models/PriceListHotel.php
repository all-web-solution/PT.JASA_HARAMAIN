<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceListHotel extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_hotel',
        'tipe_kamar',
        'harga'
    ];
}
