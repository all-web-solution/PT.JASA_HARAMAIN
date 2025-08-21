<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'nama',
        'bus_facility_id',
    ];

    public function busFacility()
    {
        return $this->belongsTo(BusFacility::class);
    }

   
}
