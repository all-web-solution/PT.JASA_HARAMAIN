<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'jamaah',
        'service',
        'tanggal_keberangkatan',
        'tanggal_kepulangan'
    ];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function travel(){
        return $this->belongsTo(Pelanggan::class, 'travel_id');
    }
}
