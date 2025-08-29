<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandlingPlanes extends Model
{
    protected $fillable = ['handling_id', 'nama_bandara', 'jumlah_jamaah', 'harga', 'kedatangan_jamaah'];
    public function handling(){
        return $this->belongsTo(Handling::class);
    }
}
