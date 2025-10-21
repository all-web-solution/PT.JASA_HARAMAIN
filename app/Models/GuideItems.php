<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideItems extends Model
{
    protected $fillable = ['nama', 'harga', 'keterangan', 'supplier', 'harga_dasar'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
