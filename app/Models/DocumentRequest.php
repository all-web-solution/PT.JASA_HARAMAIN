<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    protected $fillable = [
        'document_id',
        'qty_pack',
        'total_price'
    ];

    public function document(){
        return $this->belongsTo(Document::class);
    }
}
