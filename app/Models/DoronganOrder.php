<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoronganOrder extends Model
{
    protected $fillable = ['service_id', 'dorongan_id', 'jumlah', 'tanggal_pelaksanaan', 'status', 'supplier', 'harga_dasar', 'harga_jual'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function dorongan()
    {
        return $this->belongsTo(Dorongan::class);
    }
}
