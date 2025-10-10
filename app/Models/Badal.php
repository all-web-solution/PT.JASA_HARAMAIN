<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badal extends Model
{
    protected $fillable = ['service_id', 'name', 'price'];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
