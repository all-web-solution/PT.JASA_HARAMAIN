<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'service_id',
        'meal_id',
        'jumlah',
        'pj',
        'kebutuhan',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function mealItem()
    {
        return $this->belongsTo(MealItem::class, 'meal_id');
    }
}
