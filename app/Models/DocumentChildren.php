<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentChildren extends Model
{
    protected $fillable = ['document_id', 'name','price','supplier','harga_dasar'];

    public function document(){
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function CustomerDocuments(){
        return $this->hasMany(CustomerDocument::class);

    }
}
