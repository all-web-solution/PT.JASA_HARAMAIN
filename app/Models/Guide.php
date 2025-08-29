<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = ['service_id', 'nama','jumlah', 'keterangan'];

     public function service(){
        return $this->belongsTo(Service::class);
    }
}
