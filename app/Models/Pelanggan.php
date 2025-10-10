<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $fillable = [
        'foto',
        'nama_travel',
        'alamat',
        'email',
        'penanggung_jawab',
        'phone',
        'no_ktp',
        'status'
    ];


    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('assets/images/default-travel.png');
    }
    protected $casts = [
        'status' => 'string'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('nama_travel', 'like', "%$term%")
            ->orWhere('email', 'like', "%$term%")
            ->orWhere('penanggung_jawab', 'like', "%$term%");
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSort($query, $sort)
    {
        switch ($sort) {
            case 'latest':
                return $query->latest();
            case 'oldest':
                return $query->oldest();
            case 'name_asc':
                return $query->orderBy('nama_travel', 'asc');
            case 'name_desc':
                return $query->orderBy('nama_travel', 'desc');
            default:
                return $query->latest();
        }
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'pelanggan_id');
    }



    public function getTotalTransaksiAttribute()
    {
        return $this->services->flatMap->orders->sum('total');
    }

    public function getTotalHutangAttribute()
    {
        return $this->services->flatMap->orders->where('status', 'hutang')->sum('total');
    }

}
