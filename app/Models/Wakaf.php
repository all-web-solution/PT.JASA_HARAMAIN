<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wakaf extends Model
{
    protected $fillable = ['nama', 'harga', 'supplier', 'harga_dasar'];
    public function wakafs()
    {
        return $this->hasMany(Wakaf::class, 'service_id');
    }
}
