<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentCustomer extends Model
{
    protected $fillable = ['service_id', 'content_id', 'jumlah', 'keterangan', 'status', 'tanggal_pelaksanaaan'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function content(){
        return $this->belongsTo(ContentItem::class);
    }
}
