<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
     protected $fillable = [
        'nama_produk',
        'supplier',
        'harga_dasar',
        'divisi',
    ];
}
