<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'pesawat',
        'mobil', // e.g., 'pesawat', 'bus', 'mobil'
    ];

    public function user()
    {
        return $this->belongsTo(Pelanggan::class);
    }

}
