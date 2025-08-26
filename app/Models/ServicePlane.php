<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePlane extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'plane_name',
        'ticket_price',
        'jumlah_jamaah',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
