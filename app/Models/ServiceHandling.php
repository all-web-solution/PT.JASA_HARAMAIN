<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHandling extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'handling_type',
        'harga',
        'jumlah',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
