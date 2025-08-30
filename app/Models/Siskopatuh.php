<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siskopatuh extends Model
{
    protected $fillable =  ['document_id', 'nama','jumlah','harga','keterangan'];

    public function document(){
        return $this->belongsTo(Document::class);
    }

}
