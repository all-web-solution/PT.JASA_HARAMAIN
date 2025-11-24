<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class Transaction extends Model
{
    use HasFactory;

    // Tabel ini bertindak sebagai "Log Transaksi" atau "Buku Kas Masuk" per Order
    protected $fillable = [
        'order_id',         // Link ke Order
        'jumlah_bayar',     // (Ganti paid_amount) Uang yang masuk di transaksi INI saja
        'tanggal_bayar',    // Penting untuk history
        'bukti_pembayaran', // File bukti transfer disimpan DISINI per transaksi
        'status',           // 'pending' (perlu cek admin) atau 'verified' (sah)
        'catatan'           // Opsional: misal "Cicilan ke-1"
    ];

    protected $casts = [
        'tanggal_bayar' => 'date'
    ];

    // Relasi Balik ke Induk
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
