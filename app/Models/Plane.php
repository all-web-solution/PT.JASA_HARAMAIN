<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'service_id',
        'tanggal_keberangkatan',
        'rute',
        'maskapai',
        'harga',
        'keterangan',
        'tiket',
        'jumlah_jamaah',
        'status',
        'supplier',
        'harga_dasar',
        'harga_jual'
    ];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
}
