<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'service_id',
        'transportation_id',
        'tour_id',
        'tanggal_keberangkatan',
        'supplier',
        'harga_dasar'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }

    public function tourItem()
    {
        // Gunakan 'tour_id' sebagai foreign key
        return $this->belongsTo(TourItem::class, 'tour_id');
    }
}
