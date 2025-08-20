<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideBooking extends Model
{
    protected $fillable = [
        'guide_id',
        'days',
        'total_price'
    ];

    public function guide(){
        return $this->belongsTo(Guide::class);
    }
}
