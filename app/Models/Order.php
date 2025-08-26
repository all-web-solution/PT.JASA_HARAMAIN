<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'service_id',
        'total_amount'
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}

public function getTotalPaidAttribute()
{
    return $this->payments()->sum('paid_amount');
}

public function getOutstandingDebtAttribute()
{
    return $this->total_amount - $this->total_paid;
}

}
