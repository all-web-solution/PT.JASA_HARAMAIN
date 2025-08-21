<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'pelanggan_id',
        'jamaah',
        'service',
        'tanggal_keberangkatan',
        'tanggal_kepulangan',
        'plane_id',
        'bus_id',
        'makkah_hotel_id',
        'madina_hotel_id',
        'visa',
        'vaksin',
        'bandara_indonesia',
        'bandara_jeddah',
        'checkout_hotel_makkah'
    ];

    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan', 'pelanggan_id');
    }

    public function plane()
    {
        return $this->belongsTo('App\Models\Plane', 'plane_id');
    }

    public function bus()
    {
        return $this->belongsTo('App\Models\Bus', 'bus_id');
    }

    public function makkahHotel()
    {
        return $this->belongsTo('App\Models\MakkahHotel', 'makkah_hotel_id');
    }

    public function madinaHotel()
    {
        return $this->belongsTo('App\Models\MadinaHotel', 'madina_hotel_id');
    }

    public function getServiceAttribute($value)
    {
        return $value; // You can add any transformation logic here if needed
    }

    public function setServiceAttribute($value)
    {
        $this->attributes['service'] = $value; // You can add any transformation logic here if needed
    }

    public function getVisaAttribute($value)
    {
        return $value; // You can add any transformation logic here if needed
    }

    public function setVisaAttribute($value)
    {
        $this->attributes['visa'] = $value; // You can add any transformation logic here if needed
    }

    public function getVaksinAttribute($value)
    {
        return $value; // You can add any transformation logic here if needed
    }

    public function setVaksinAttribute($value)
    {
        $this->attributes['vaksin'] = $value; // You can add any transformation logic here if needed
    }

    public function getBandaraIndonesiaAttribute($value)
    {
        return $value; // You can add any transformation logic here if needed
    }

    public function setBandaraIndonesiaAttribute($value)
    {
        $this->attributes['bandara_indonesia'] = $value; // You can add any transformation logic here if needed
    }

    public function getBandaraJeddahAttribute($value)
    {
        return $value; // You can add any transformation logic here if needed
    }
    
}
