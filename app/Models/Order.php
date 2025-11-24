<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'service_id',
        'invoice',

        // --- AREA HARGA ---
        'total_estimasi',       // Harga awal (sebelum divisi kerja)
        'total_amount_final',   // Harga fix (setelah tombol hitung ditekan)
        'status_harga',         // 'provisional' vs 'final'

        // --- AREA PEMBAYARAN (AGREGASI) ---
        // Kolom ini di-update otomatis setiap kali ada Payment baru masuk/verified
        'total_yang_dibayarkan', // Total dari sum(payments.jumlah_bayar)
        'sisa_hutang',           // total_amount_final - total_yang_dibayarkan
        'status_pembayaran',     // 'belum_bayar', 'cicilan', 'lunas'
    ];

    // HAPUS: 'bukti_pembayaran', 'upload_transfer' (Pindah ke Payment)

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relasi ke Anak (Payment Histories)
    public function transactions() // Ganti nama dari transactions jadi transactions
    {
        return $this->hasMany(Transaction::class); // Pastikan class transaction di-import
    }

    public function uploadPayments()
    {
        return $this->hasMany(UploadPayment::class, 'order_id', 'id');
    }

    // Helper untuk menghitung ulang (opsional tapi berguna)
    public function recalculatePaymentStatus()
    {
        // Hitung total uang yang masuk dan statusnya 'verified'
        $totalBayar = $this->payments()->where('status', 'verified')->sum('jumlah_bayar');

        $this->total_yang_dibayarkan = $totalBayar;

        // Gunakan total_amount_final jika ada, jika tidak gunakan estimasi (tergantung kebijakan)
        $targetTotal = $this->total_amount_final ?? $this->total_estimasi;

        $this->sisa_hutang = max(0, $targetTotal - $totalBayar);

        // Tentukan status text
        if ($this->sisa_hutang <= 0 && $targetTotal > 0) {
            $this->status_pembayaran = 'lunas';
        } elseif ($this->total_yang_dibayarkan > 0) {
            $this->status_pembayaran = 'cicilan'; // atau 'belum_lunas'
        } else {
            $this->status_pembayaran = 'belum_bayar';
        }

        $this->save();
    }
}
