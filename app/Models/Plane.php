<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'service_id',
        'tanggal_keberangkatan',
        'rute', 'maskapai',
        'harga',
        'keterangan',
        'paspor',
        'visa',
        'tiket_berangkat',
        'tiket_pulang',
        'jumlah_jamaah',
        'status',
        'harga_dasar',
        'harga_jual'
    ];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
}
