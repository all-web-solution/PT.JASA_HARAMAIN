<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['service_id', 'nama', 'jumlah'];
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
