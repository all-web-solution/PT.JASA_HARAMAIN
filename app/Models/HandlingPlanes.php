<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandlingPlanes extends Model
{
    protected $fillable = ['handling_id', 'nama_bandara', 'jumlah_jamaah', 'harga', 'kedatangan_jamaah', 'paket_info', 'nama_supir', 'identitas_koper', 'status'];
    public function handling()
    {
        return $this->belongsTo(Handling::class);
    }
}
