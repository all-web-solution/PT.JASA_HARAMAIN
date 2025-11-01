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

public function pay(Request $request, $service_id) // <-- MENGGUNAKAN service_id KEMBALI
{
    // <-- CARI ORDER TERLAMA YANG BELUM DIBAYAR BERDASARKAN service_id
    // Ini memastikan kita selalu membayar tagihan terlama (yang paling duluan dibuat)
    $order = Order::where('service_id', $service_id)
                  ->where('status_pembayaran', 'belum_bayar')
                  ->orderBy('created_at', 'asc')
                  ->first();

    // <-- Error handling jika tidak ada tagihan
    if (!$order) {
        return redirect()->back()->with('error', 'Tidak ada tagihan yang belum dibayar untuk service ID ini.');
    }

    $jumlahBayar = (int) $request->jumlah_dibayarkan;
    $statusPembayaran = $request->status;
    // Asumsi: Perbaikan typo pada request name (pemabayaran -> pembayaran)
    $statusBuktiPembayaran = $request->status_bukti_pembayaran;

    DB::beginTransaction();

    // Inisialisasi pathBuktiPembayaran
    $pathBuktiPembayaran = $order->bukti_pembayaran; // Ambil bukti lama, jika ada

    try {
        // --- LOGIKA UPLOAD BUKTI PEMBAYARAN ---
        if ($request->hasFile('bukti_pembayaran')) {
            // Ini akan menyimpan file di: storage/app/public/payment_proofs
            $pathBuktiPembayaran = $request->file('bukti_pembayaran')->store('payment_proofs', 'public');
        }

        // --- LOGIKA PERHITUNGAN DAN UPDATE ORDER LAMA ---
        $totalDibayarBaru = $order->total_yang_dibayarkan + $jumlahBayar;
        $sisaHutangBaru = $order->total_amount - $totalDibayarBaru;

        // Tentukan status pembayaran akhir untuk order lama
        // Jika sisa hutang <= 0, maka order ini dianggap lunas.
        $finalStatusPembayaran = ($sisaHutangBaru <= 0) ? 'lunas' : $statusPembayaran;

        // Update order lama (tagihan terlama yang sedang dibayar)
        $order->update([
            'total_yang_dibayarkan' => $totalDibayarBaru,
            'sisa_hutang' => max(0, $sisaHutangBaru), // Pastikan sisa_hutang tidak negatif
            'status_pembayaran' => $finalStatusPembayaran,
            'bukti_pembayaran' => $pathBuktiPembayaran,
            'status_bukti_pembayaran' => $statusBuktiPembayaran,
            'upload_transfer' => null // Catatan: ini selalu diset null?
        ]);

        // --- LOGIKA PEMBUATAN ORDER BARU UNTUK SISA HUTANG (JIKA ADA) ---
        // Kalau masih ada sisa hutang (> 0) dan order ini belum lunas,
        // buat order baru khusus untuk sisa hutang tersebut.
        if ($sisaHutangBaru > 0 && $finalStatusPembayaran !== 'lunas') {
            $newInvoice = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);

            Order::create([
                'service_id' => $order->service_id,
                'total_amount' => $sisaHutangBaru,
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $sisaHutangBaru,
                'invoice' => $newInvoice,
                'status_pembayaran' => 'belum_bayar', // Order baru statusnya 'belum_bayar'
                // Bukti pembayaran tidak di-copy ke order baru karena order baru belum dibayar
                'bukti_pembayaran' => null,
                'status_bukti_pembayaran' => null,
                'upload_transfer' => null
            ]);
        }

        DB::commit();

        return redirect()->back()
            ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format(max(0, $sisaHutangBaru), 0, ',', '.'));

    } catch (\Exception $e) {
        DB::rollBack();
        // Log error untuk debugging
        Log::error("Gagal memproses pembayaran Service ID {$service_id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
    }
}
}
