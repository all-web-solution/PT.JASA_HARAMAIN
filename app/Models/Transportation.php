<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transportation extends Model
{
    protected $fillable = ['nama', 'kapasitas', 'fasilitas', 'harga'];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'transportation_id');
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'transportation_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
