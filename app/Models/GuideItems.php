<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideItems extends Model
{
    protected $fillable = ['nama', 'harga', 'keterangan'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
