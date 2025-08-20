<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan_services extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'service_id',
        'quantity',
        'total_price',
        'start_date',
        'end_date',
        'notes'
    ];
}
