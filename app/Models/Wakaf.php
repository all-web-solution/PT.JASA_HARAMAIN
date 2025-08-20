<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wakaf extends Model
{
    protected $fillable = ['type', 'price', 'qty', 'total_price'];
}
