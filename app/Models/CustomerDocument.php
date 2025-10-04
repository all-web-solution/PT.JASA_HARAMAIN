<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    protected $fillable = ['service_id','document_children_id','document_id', 'jumlah', 'harga', 'paspor', 'pas_foto'];

    public function DocumentChildren(){
        return $this->belongsTo(DocumentChildren::class, 'id');
    }
    public function documents(){
         return $this->belongsTo(Document::class, 'id');
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
