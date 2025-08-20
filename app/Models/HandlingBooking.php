<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandlingBooking extends Model
{
    protected $fillable = [
        'handling_id',
        'price'
    ];

    public function handling(){
        return $this->belongsTo(Handling::class);
    }
}
