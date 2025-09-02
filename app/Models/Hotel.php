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
        'tipe_kamar',
        'jumlah_kamar',
        'harga_perkamar',
        'catatan',
        'visa'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function typeHotels()
{
    return $this->hasMany(TypeHotel::class);
}
}
