<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'total_amount'
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }
}
