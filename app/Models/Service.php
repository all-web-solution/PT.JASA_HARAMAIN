<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'services',
        'tanggal_keberangkatan',
        'tanggal_kepulangan',
        'total_jamaah'
    ];

    // Relasi ke Travel
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    protected $casts = [
    'services' => 'array',
];
public function planes()
    {
        return $this->hasMany(Plane::class, 'service_id');
    }

    public function transportation(){
        return $this->hasMany(Transportation::class, 'service_id');
    }
    public function transportationItem(){
    return $this->hasMany(TransportationItem::class, 'service_id');
    }

    public function hotels(){
        return $this->hasMany(Hotel::class, 'service_id');
    }
}
