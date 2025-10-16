<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationItem extends Model
{
    protected $fillable = ['service_id', 'transportation_id', 'route_id', "dari_tanggal", "sampai_tanggal"];

     public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }
    public function route(){
        return $this->belongsTo(Route::class);
    }
}
