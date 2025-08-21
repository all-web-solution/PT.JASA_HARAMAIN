<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catering extends Model
{
    protected $fillable = ['type', 'qty_pack',
        'days',
        'total_price'
        
    ];
}
