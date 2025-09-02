<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'pas_foto',
        'paspor',
        'ktp'
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function visaDetails() { return $this->hasMany(Visa::class); }
public function vaksinDetails() { return $this->hasMany(Vaccine::class); }
public function sikopaturDetails() { return $this->hasMany(Siskopatuh::class); }
}
