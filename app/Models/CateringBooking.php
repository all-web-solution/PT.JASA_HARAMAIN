<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CateringBooking extends Model
{
    protected $fillable = [
        'category_id',
        'qty_pack',
        'days',
        'total_price'
    ];

    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
