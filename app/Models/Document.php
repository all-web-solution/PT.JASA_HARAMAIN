<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
    ];

    public function childrens()
    {
        return $this->hasMany(DocumentChildren::class, 'document_id');
    }
    public function CustomerDocuments()
    {
        return $this->hasMany(CustomerDocument::class, 'document_id');

    }
}
