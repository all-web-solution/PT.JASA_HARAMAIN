<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'service_id',
        'tanggal_checkin',
        'tanggal_checkout',
        'nama_hotel',
        'jumlah_kamar',
        'harga_perkamar',
        'catatan',
        'type',
        'jumlah_type',
        'type_custom_special_room',
        'jumlah_kasur',
        'harga_type_custom_special_room'
        ];

    public function service(){
        return $this->belongsTo(Service::class, 'id');
    }
    public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class);
}


}
