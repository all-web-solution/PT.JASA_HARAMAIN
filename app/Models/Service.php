<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'contact_person',
        'email',
        'phone',
        'departure_date',
        'return_date',
        'total_jamaah',
        'jumlah_jamaah',
        'harga_bandara',
        'nama_bandara',
        'kedatangan_jamaah',
        'jumlah_pendamping',
        'services_type',
    ];

    // Relasi ke Travel
    public function travel()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke planes
    public function planes()
    {
        return $this->hasMany(ServicePlane::class);
    }

    // Relasi ke hotels
    public function hotels()
    {
        return $this->hasMany(ServiceHotel::class);
    }

    // Relasi ke handlings
    public function handlings()
    {
        return $this->hasMany(ServiceHandling::class);
    }

    // Relasi ke pendampings
    public function pendampings()
    {
        return $this->hasMany(ServicePendamping::class);
    }

    // Relasi ke contents
    public function contents()
    {
        return $this->hasMany(ServiceContent::class);
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }
}
