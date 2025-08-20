<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    protected $fillable = ['tour_id', 'qty_pack', 'total_price'];
    public function tour(){
        return $this->belongsTo(Tour::class);
    }
}
