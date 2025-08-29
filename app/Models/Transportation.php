<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $fillable = ['nama', 'kapasitas', 'fasilitas', 'harga'];

    public function tours(){
        return $this->hasMany(Tour::class, 'transportation_id');
    }
}
