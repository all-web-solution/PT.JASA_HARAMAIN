<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index()
    {
        return view('keuangan.index');
    }
    public function payment()
    {
        $orders = Order::all();
        $data = $orders->unique('service_id');
        return view('keuangan.payment', compact('data'));
    }

    public function payment_detail($id)
{
    // Ambil satu order utama (misalnya untuk detail utama)
    $order = Order::where('service_id', $id)->firstOrFail();

    // Ambil semua order dengan service_id yang sama (misal untuk riwayat pembayaran)
    $orders = Order::where('service_id', $id)->get();

    return view('keuangan.payment_detail', compact('order', 'orders'));
}

public function pay(Request $request, $service_id) // <-- UBAH DI SINI
{
    $request->validate([
        'jumlah_dibayarkan' => 'required|numeric|min:1',
    ]);

    // <-- TAMBAHAN: CARI ORDER YANG HARUS DIBAYAR
    // Kita cari order dengan service_id yang sesuai,
    // yang statusnya 'belum_bayar', dan ambil yang paling lama (created_at paling awal).
    $order = Order::where('service_id', $service_id)
                  ->where('status_pembayaran', 'belum_bayar')
                  ->orderBy('created_at', 'asc')
                  ->first();

    // <-- TAMBAHAN: Error handling jika tidak ada tagihan
    if (!$order) {
        return redirect()->back()->with('error', 'Tidak ada tagihan yang belum dibayar untuk service ID ini.');
    }

    $jumlahBayar = (int) $request->jumlah_dibayarkan;
    $statusPembayaran = $request->status;

    DB::beginTransaction();

    try {
        // Hitung total pembayaran & sisa hutang
        // Logika di bawah ini SAMA PERSIS dengan kode Anda,
        // karena $order sekarang sudah berisi order yang tepat untuk dibayar.
        $totalDibayarBaru = $order->total_yang_dibayarkan + $jumlahBayar;
        $sisaHutangBaru = $order->total_amount - $totalDibayarBaru;
        // Update order lama
        $order->update([
            'total_yang_dibayarkan' => $totalDibayarBaru,
            'sisa_hutang' => $sisaHutangBaru, // Ini bisa jadi negatif jika kelebihan bayar
            'status_pembayaran' => $statusPembayaran,
        ]);

        // Kalau masih ada hutang → buat order baru khusus sisa hutang
        if ($sisaHutangBaru > 0) {
            $newInvoice = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);

            Order::create([
                'service_id' => $order->service_id, // service_id tetap sama
                'total_amount' => $sisaHutangBaru,
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $sisaHutangBaru,
                'invoice' => $newInvoice,
                'status_pembayaran' => 'belum_bayar', // Order baru statusnya 'belum_bayar'
            ]);
        }

        DB::commit();

        // Redirect tetap ke detail order_id yang baru saja dibayar
        return redirect()->back()
            ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format(max(0, $sisaHutangBaru), 0, ',', '.'));
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
    }


}
}
