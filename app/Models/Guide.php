<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'service_id',
        'guide_id',
        'jumlah',
        'keterangan',
        'muthowif_dari',
        'muthowif_sampai'
    ];

     public function service(){
        return $this->belongsTo(Service::class, 'id');
    }
    public function guideItem()
{
    return $this->belongsTo(GuideItems::class, 'guide_id');
}
}
