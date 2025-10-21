<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourItem extends Model
{
    protected $fillable = ['name', 'price', 'supplier', 'harga_dasar'];
}
