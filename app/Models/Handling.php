<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handling extends Model
{
    protected $fillable = ['name', 'service_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function handlingHotels()
    {
        return $this->hasOne(HandlingHotel::class, 'handling_id');
    }
    public function handlingPlanes()
    {
        return $this->hasOne(HandlingPlanes::class, 'handling_id');
    }

}
