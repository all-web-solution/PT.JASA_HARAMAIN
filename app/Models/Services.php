<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'subcategory_id',
        'name',
        'description',
        'price',
        'currency',
        'duration',
        'is_active'
    ];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
}
