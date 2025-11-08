<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'service_id',
        'tanggal_checkin',
        'tanggal_checkout',
        'nama_hotel',
        'jumlah_kamar',
        'harga_perkamar',
        'catatan',
        'type',
        'jumlah_type',
        'status',
        'supplier',
        'harga_dasar',
        'harga_jual'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

}
