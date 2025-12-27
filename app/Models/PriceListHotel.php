<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceListHotel extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_hotel',
        'category',
        'tipe_kamar',
        'harga',

        // --- KOLOM BARU ---
        'tanggal_checkOut',
        'catatan',
        'add_on',
        'supplier_utama',
        'kontak_supplier_utama',
        'supplier_cadangan',
        'kontak_supplier_cadangan',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
