<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealItem extends Model
{
   protected $fillable = ['name', 'price', 'supplier', 'harga_dasar'];

   public function meals()
   {
      return $this->hasMany(Meal::class, 'meal_id');
   }
}
