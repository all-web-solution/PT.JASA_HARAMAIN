<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $fillable = ['type', 'route', 'return_date', 'price_per_pack',  'qty_pack', 'total_price'];
}
