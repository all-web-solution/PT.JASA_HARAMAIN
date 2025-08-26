<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePendamping extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'nama',
        'jumlah',
        'harga',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
