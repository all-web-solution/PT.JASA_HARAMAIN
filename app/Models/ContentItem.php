<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
     protected $fillable = ['name', 'price',  'supplier', 'harga_dasar'];
     public function contents(){
           return $this->hasMany(ContentCustomer::class, 'content_id');
       }
}
