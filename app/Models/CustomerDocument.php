<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    protected $fillable = [
        'service_id',
        'document_children_id',
        'document_id',
        'jumlah',
        'harga',
    ];

    public function documentChild()
    {
        return $this->belongsTo(DocumentChildren::class, 'document_children_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
