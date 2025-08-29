<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['order_id', 'invoice_code','total_hutang', 'total_yang_di_bayarkan', 'sisa_hutang'];

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
