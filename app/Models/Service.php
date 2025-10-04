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
        'total_jamaah',
        'status',
        'unique_code'
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


    public function transportationItem(){
    return $this->hasMany(TransportationItem::class, 'service_id');
    }

    public function hotels(){
        return $this->hasMany(Hotel::class, 'service_id');
    }
    public function handlings(){
        return $this->hasMany(Handling::class, 'service_id');
    }
     public function meals(){
        return $this->hasMany(Meal::class, 'service_id');
    }
     public function guides(){
        return $this->hasMany(Guide::class, 'service_id');
    }
    public function tours(){
        return $this->hasMany(Tour::class, 'service_id');
    }
    public function documents()
{
    return $this->hasMany(CustomerDocument::class, 'service_id');
}
    public function filess(){
        return $this->hasMany(File::class, 'service_id');
    }
    public function reyals(){
        return $this->hasMany(Exchange::class, 'service_id');
    }
     public function wakafs()
    {
        return $this->hasMany(WakafCustomer::class, 'service_id');
    }
    public function dorongans(){
        return $this->hasMany(DoronganOrder::class, 'service_id');
    }
    public function contents(){
        return $this->hasMany(ContentCustomer::class, 'service_id');
    }
    public function badals(){
        return $this->hasMany(Badal::class, 'service_id');
    }
    public function orders(){
        return $this->hasMany(Order::class, 'service_id');
    }
}
