<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadPayment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_proof',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
