<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'pendamping_type',
        'harga',
        'jumlah',
    ];


}
