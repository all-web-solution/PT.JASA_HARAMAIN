<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KeuanganController extends Controller
{
    public function index()
    {
        // ==========================================================
        // DATA UNTUK KARTU & GRAFIK BULAT (Pie Chart)
        // ==========================================================

        // Ambil data (collection) untuk kartu count()
        $dataBelumBayar = Order::where('status_pembayaran', 'belum_bayar')->get();
        $dataBelumLunas = Order::where('status_pembayaran', 'belum_lunas')->get();
        $dataLunas = Order::where('status_pembayaran', 'lunas')->get();

        // Hitung total (sum) untuk kartu jumlah dan pie chart
        $totalBelumBayar = Order::where('status_pembayaran', 'belum_bayar')->sum('total_amount_final');
        $totalBelumLunas = Order::where('status_pembayaran', 'belum_lunas')->sum('total_amount_final');
        $totalLunas      = Order::where('status_pembayaran', 'lunas')->sum('total_amount_final');

        // Hitung total keseluruhan
        $totalKeseluruhan = Order::get()->sum('total_amount_final');

        // Siapkan data untuk Pie Chart
        $pieChartData = [
            'labels' => ['Belum Bayar', 'Belum Lunas', 'Lunas'],
            'data'   => [$totalBelumBayar, $totalBelumLunas, $totalLunas],
        ];


        // ==========================================================
        // (BARU) DATA UNTUK GRAFIK BATANG (Monthly Performance)
        // ==========================================================

        // 1. Kueri efisien: Ambil data bulanan untuk SEMUA status sekaligus
        $monthlyPerformance = Order::select(
                DB::raw('MONTH(created_at) as bulan'),
                'status_pembayaran', // <-- Kunci: Ambil statusnya
                DB::raw('SUM(total_amount_final) as total')
            )
            ->whereYear('created_at', date('Y')) // Hanya tahun ini
            // Kelompokkan berdasarkan bulan DAN status
            ->groupBy('bulan', 'status_pembayaran')
            ->orderBy('bulan', 'asc')
            ->get();

        // 2. Siapkan array label (Bulan)
        $barChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        // 3. Siapkan 3 array data, isi dengan 0 (nilai default)
        $barChartDataLunas = array_fill(0, 12, 0);
        $barChartDataBelumLunas = array_fill(0, 12, 0);
        $barChartDataBelumBayar = array_fill(0, 12, 0);

        // 4. Proses hasil kueri ke 3 array data
        foreach ($monthlyPerformance as $data) {
            // $data->bulan adalah 1-12, index array adalah 0-11
            $bulanIndex = $data->bulan - 1;

            if ($data->status_pembayaran == 'lunas') {
                $barChartDataLunas[$bulanIndex] = $data->total;
            } elseif ($data->status_pembayaran == 'belum_lunas') {
                $barChartDataBelumLunas[$bulanIndex] = $data->total;
            } elseif ($data->status_pembayaran == 'belum_bayar') {
                $barChartDataBelumBayar[$bulanIndex] = $data->total;
            }
        }


        // ==========================================================
        // 6. Kirim semua variabel ke view
        // ==========================================================
        return view('keuangan.index', [
            // Data List (untuk kartu count())
            'dataBelumBayar' => $dataBelumBayar,
            'dataBelumLunas' => $dataBelumLunas,
            'dataLunas' => $dataLunas,

            // Data Total Angka (untuk kartu jumlah Rp)
            'totalBelumBayar' => $totalBelumBayar,
            'totalBelumLunas' => $totalBelumLunas,
            'totalLunas' => $totalLunas,
            'totalKeseluruhan' => $totalKeseluruhan,

            // Data untuk Grafik Bulat
            'pieChartData' => $pieChartData,

            // (BARU) Data untuk Grafik Batang (3 set)
            'barChartLabels' => $barChartLabels,
            'barChartDataLunas' => $barChartDataLunas,
            'barChartDataBelumLunas' => $barChartDataBelumLunas,
            'barChartDataBelumBayar' => $barChartDataBelumBayar,
        ]);
    }
    public function payment()
    {
        $orders = Order::latest()->get();
        $data = $orders->unique('service_id');
        return view('keuangan.payment', compact('data'));
    }

    public function payment_detail($id)
    {
        // Ambil satu order utama (misalnya untuk detail utama)
        $order = Order::where('service_id', $id)->firstOrFail();

        // Ambil semua order dengan service_id yang sama (misal untuk riwayat pembayaran)
        $transactions = Transaction::where('order_id', $id)->get();

        return view('keuangan.payment_detail', compact('order', 'transactions'));
    }

    public function pay(Request $request, $service_id)
    {
        // 1. Cari Order Utama berdasarkan Service ID
        $order = Order::where('service_id', $service_id)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Data tagihan tidak ditemukan.');
        }

        // =================================================================
        // 🔒 GERBANG PENGAMAN (OPSI A)
        // Cek apakah harga sudah final. Jika belum, tolak pembayaran.
        // =================================================================
        if ($order->status_harga !== 'final') {
            return redirect()->back()->with('error', 'Harga belum final. Mohon lakukan "Hitung & Finalkan Total" terlebih dahulu sebelum input pembayaran.');
        }

        // Validasi Input
        $request->validate([
            'jumlah_bayar'      => 'required|numeric|min:1',
            'bukti_pembayaran'  => 'nullable|image|max:2048', // Max 2MB
            'catatan'           => 'nullable|string'
        ]);

        $jumlahBayarInput = (float) $request->jumlah_bayar;

        // Cek Overpayment (Opsional tapi disarankan)
        if ($jumlahBayarInput > $order->sisa_hutang) {
            return redirect()->back()->with('error', 'Jumlah pembayaran melebihi sisa hutang (Rp ' . number_format($order->sisa_hutang, 0, ',', '.') . ').');
        }

        DB::beginTransaction();

        try {
            // 2. Upload Bukti (Jika ada)
            $pathBuktiPembayaran = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $pathBuktiPembayaran = $request->file('bukti_pembayaran')->store('payment_proofs', 'public');
            }

            // 3. CREATE PAYMENT RECORD (Log Transaksi)
            // Kita mencatat detail transaksi ini di tabel 'payments'
            Transaction::create([
                'order_id'          => $order->id,
                'jumlah_bayar'      => $jumlahBayarInput,
                'tanggal_bayar'     => $request->tanggal_bayar,
                'bukti_pembayaran'  => $pathBuktiPembayaran,
                'status'            => $request->status, // Asumsi admin yang input langsung verified
                'catatan'           => $request->catatan ?? 'Pembayaran Cicilan/Pelunasan',
            ]);

            // 4. HITUNG ULANG TOTAL & UPDATE ORDER (INDUK)
            // Ambil total yang sudah dibayar dari SEMUA history payment (termasuk yang barusan dibuat)
            $totalSudahDibayar = $order->transactions()->sum('jumlah_bayar');

            // Hitung sisa hutang berdasarkan Total Final
            $sisaHutang = $order->total_amount_final - $totalSudahDibayar;
            $sisaHutang = max(0, $sisaHutang); // Menjaga agar tidak negatif

            // Tentukan status pembayaran
            if ($sisaHutang <= 0) {
                $statusPembayaran = 'lunas';
            } elseif ($totalSudahDibayar > 0) {
                $statusPembayaran = 'belum_lunas'; // Cicilan berjalan
            } else {
                $statusPembayaran = 'belum_bayar';
            }

            // Update Order Utama
            $order->update([
                'total_yang_dibayarkan' => $totalSudahDibayar,
                'sisa_hutang'           => $sisaHutang,
                'status_pembayaran'     => $statusPembayaran,
                // Note: Kita tidak perlu simpan bukti_pembayaran di Order lagi,
                // karena sudah ada di tabel payments per transaksi.
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil dicatat! Sisa hutang: Rp ' . number_format($sisaHutang, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal memproses pembayaran Order ID {$order->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
