<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WakafCustomer extends Model
{
    protected $table = 'wakaf_customers'; // opsional, Laravel otomatis paham
    protected $fillable = ['service_id', 'wakaf_id', 'jumlah'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id');
    }

    public function wakaf()
    {
        return $this->belongsTo(Wakaf::class);
    }
}

