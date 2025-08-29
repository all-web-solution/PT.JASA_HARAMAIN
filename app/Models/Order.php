<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['service_id', 'total_amount'];

    public function service(){
        return $this->BelongsTo(Service::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
