<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationBookings extends Model
{
    protected $fillable = ['transportation_id', 'qty_pack', 'total_price'];
}
