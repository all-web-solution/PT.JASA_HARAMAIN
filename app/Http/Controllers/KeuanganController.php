<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


public function payment_detail($service_id)
{
    // 1. Tentukan SEMUA relasi yang dibutuhkan oleh Blade Anda.
    // Ini adalah 'service' DAN semua sub-relasinya.
    $relationsToLoad = [
        'service.meals.mealItem',
        'service.planes',
        'service.transportationItem.transportation',
        'service.transportationItem.route',
        'service.hotels',
        'service.tours',
        'service.guides',
        'service.documents.document',
        'service.contents.content',
        'service.handlings',
        'service.badals',
        'service.wakafs',
        'service.dorongans',
        'service.exchanges',
        'service.filess'
    ];

    // 1. Cari tagihan AKTIF yang belum dibayar untuk service ini
    $order = Order::with($relationsToLoad)
                ->where('service_id', $service_id)
                ->where('status_pembayaran', 'belum_bayar') // <-- Cari yang aktif
                ->orderBy('created_at', 'asc') // Ambil yang terlama
                ->first();

    // 2. Jika tidak ada yang 'belum_bayar' (mungkin sudah 'lunas' atau masih 'estimasi')
    if (!$order) {
        // Ambil saja order terakhir sebagai referensi
        $order = Order::with($relationsToLoad)
                    ->where('service_id', $service_id)
                    ->latest()
                    ->firstOrFail(); // Gagal jika service_id tidak ada sama sekali
    }

    // 3. Ambil SEMUA order untuk riwayat
    $orders = Order::where('service_id', $service_id)->orderBy('created_at', 'desc')->get();

    // 4. Ambil semua item
    $semuaItem = $order->service->getAllItemsFromService();

    // 5. Kirim data ke view
    return view('keuangan.payment_detail', compact('order', 'orders', 'semuaItem'));
}

public function pay(Request $request, $service_id)
{
    // 1. Pindahkan 'beginTransaction' ke paling atas
    DB::beginTransaction();

    try {
        // 2. Perbaiki Query: Ganti 'belum bayar' (dgn spasi) menjadi 'belum_bayar' (tanpa spasi)
        $order = Order::where('service_id', $service_id)
            ->whereIn('status_pembayaran', ['belum_bayar', 'belum_lunas']) // <-- PERBAIKAN STRING
            ->orderBy('created_at', 'asc')
            ->first();

        // 3. Aktifkan kembali Error Handling (PENTING)
        if (!$order) {
            // Jika tidak ada tagihan, batalkan transaksi (meskipun belum ada)
            // DB::rollBack();
            return dd('error', 'Tidak ada tagihan yang siap dibayar (status "belum_bayar") untuk service ini.');
        }

        $jumlahBayar = (int) $request->jumlah_dibayarkan;
        $statusBuktiPembayaran = $request->status_bukti_pembayaran;

        // Inisialisasi path (sekarang aman karena $order dijamin tidak null)
        $pathBuktiPembayaran = $order->bukti_pembayaran;

        // --- LOGIKA UPLOAD BUKTI PEMBAYARAN ---
        if ($request->hasFile('bukti_pembayaran')) {
            $pathBuktiPembayaran = $request->file('bukti_pembayaran')->store('payment_proofs', 'public');
        }

        // --- LOGIKA PERHITUNGAN ---
        $totalDibayarBaru = $order->total_yang_dibayarkan + $jumlahBayar;
        $sisaHutangBaru = $order->total_amount - $totalDibayarBaru;

        // 4. Perbaiki Logika Status Cicilan (PENTING)
        //    (Ganti $statusPembayaran dari form, dengan logika 'belum_lunas')
        $finalStatusPembayaran = ($sisaHutangBaru <= 0) ? 'lunas' : 'belum_lunas';

        // Update order lama
        $order->update([
            'total_yang_dibayarkan' => $totalDibayarBaru,
            'sisa_hutang' => max(0, $sisaHutangBaru),
            'status_pembayaran' => $finalStatusPembayaran, // <-- Menggunakan status yang sudah diperbaiki
            'bukti_pembayaran' => $pathBuktiPembayaran,
            'status_bukti_pembayaran' => $statusBuktiPembayaran,
            'upload_transfer' => null
        ]);

        // --- LOGIKA PEMBUATAN ORDER BARU (CICILAN) ---
        if ($sisaHutangBaru > 0 && $finalStatusPembayaran !== 'lunas') {
            $newInvoice = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);

            Order::create([
                'service_id' => $order->service_id,
                'total_amount' => $sisaHutangBaru,
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $sisaHutangBaru,
                'invoice' => $newInvoice,
                'status_pembayaran' => 'belum_bayar', // Tagihan baru siap dibayar
                'bukti_pembayaran' => null,
                'status_bukti_pembayaran' => null,
                'upload_transfer' => null
            ]);
        }

        DB::commit();

        return redirect()->back()
            ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format(max(0, $sisaHutangBaru), 0, ',', '.'));

    } catch (\Exception $e) {
        // DB::rollBack();
        Log::error("Gagal memproses pembayaran Service ID {$service_id}: " . $e->getMessage());

        // Aktifkan 'dd' ini HANYA jika Anda masih gagal, untuk melihat error sebenarnya
        // dd($e);

        return dd('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
    }
}
}
