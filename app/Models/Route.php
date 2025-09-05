<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable  = ['transportation_id', 'route', 'price'];

    public function transportation(){
        return $this->belongsTo(Transportation::class);
    }
}
