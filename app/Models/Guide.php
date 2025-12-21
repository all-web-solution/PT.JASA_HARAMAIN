<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model{
    protected $fillable=[
        'service_id',
        'guide_id',
        'jumlah',
        'keterangan',
        'muthowif_dari',
        'muthowif_sampai',
        'supplier',
        'harga_dasar',
        'harga_jual',
        'status'
    ];

    public function service(){
        return $this->belongsTo(Service::class,'service_id','id');
    }

    public function guideItem(){
        return $this->belongsTo(GuideItems::class,'guide_id');
    }
}
