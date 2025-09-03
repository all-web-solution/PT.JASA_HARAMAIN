<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['service_id','invoice','total_amount', 'total_yang_dibayarkan', 'sisa_hutang'];

    public function service(){
        return $this->BelongsTo(Service::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
