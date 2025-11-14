<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'service_id',
        'invoice',
        'total_estimasi',
        'total_yang_dibayarkan',
        'sisa_hutang',
        'total_amount_final',
        'status_harga',
        'status_pembayaran',
        'upload_transfer',
        'bukti_pembayaran',
        'status_bukti_pembayaran'
    ];

    public function service(){
        return $this->BelongsTo(Service::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function uploadPayments()
    {
        return $this->hasMany(UploadPayment::class, 'order_id', 'id');
    }
}
