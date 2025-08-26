<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'order_id',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'status'

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
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
