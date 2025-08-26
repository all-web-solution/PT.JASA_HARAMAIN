<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'nama_hotel',
        'tanggal_hotel',
        'harga_hotel',
        'pax_hotel',
        'lokasi',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
