<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeHotel extends Model
{
     protected $fillable = ['hotel_id', 'nama_tipe', 'jumlah'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
