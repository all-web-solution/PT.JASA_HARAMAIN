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

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function details()
    {
        return $this->hasMany(PriceListDetail::class, 'price_list_id');
    }

}
