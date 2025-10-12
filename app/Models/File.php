<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['service_id','paspor', 'pas_foto', 'ktp', 'visa'];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }


}
