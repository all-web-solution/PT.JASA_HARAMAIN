<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WakafBooking extends Model
{
    protected $fillable = ['wakaf_id', 'qty', 'total_price'];
}
