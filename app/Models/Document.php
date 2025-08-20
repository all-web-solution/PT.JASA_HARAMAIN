<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'type',
        'price',
         'qty_pack',
        'total_price'
    ];
}
