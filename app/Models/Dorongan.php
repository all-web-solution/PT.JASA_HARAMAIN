<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorongan extends Model
{
      protected $fillable = ['name', 'price'];
      public function dorongans(){
        return $this->hasMany(DoronganOrder::class, 'dorongan_id');
    }
}


