<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['name','service_id', 'transportation_id'];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }
}
