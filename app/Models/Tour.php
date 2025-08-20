<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['name', 'price', 'tour_id', 'qty_pack', 'total_price'];
}
