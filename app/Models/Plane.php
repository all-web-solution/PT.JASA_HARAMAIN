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
        'tiket_pulang'
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
