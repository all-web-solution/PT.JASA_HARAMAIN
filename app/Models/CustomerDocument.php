<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    protected $fillable = ['service_id','document_children_id','document_id', 'jumlah', 'harga', 'keterangan'];

    public function DocumentChildren(){
        return $this->belongsTo(DocumentChildren::class);
    }
    public function documents(){
         return $this->belongsTo(Document::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
