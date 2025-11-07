<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
        protected $fillable = [
            'service_id',
            'tipe',         // tamis atau tumis
            'jumlah_input', // rupiah atau reyal
            'kurs',         // kurs
            'hasil',
            'tanggal_penyerahan',
            'supplier',
            'harga_dasar',
            'harga_jual',
            'status'
        ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
