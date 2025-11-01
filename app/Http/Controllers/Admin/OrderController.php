<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\UploadPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $query = Order::query();

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Filter berdasarkan tanggal spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {

        $travalers = Service::all();
        return view('admin.order.create', compact('travalers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'total_harga'  => 'required|numeric|min:0',
        ]);

        // cek apakah customer sudah ada order
        $order = Order::where('service_id', $request->pelanggan_id)->first();

        if ($order) {
            // kalau sudah ada → tambahin utangnya
            $order->total_amount += $request->total_harga;
            $order->save();
        } else {
            // kalau belum ada → buat order baru
            $order = Order::create([
                'service_id'   => $request->pelanggan_id,
                'total_amount' => $request->total_harga,
            ]);
        }

        return redirect()->route('admin.order')->with('success', 'Order berhasil disimpan');
    }

    public function edit($id)
    {
        $order = Order::find($id);
        $travalers = Pelanggan::all();
        return view('admin.order.edit', compact('order', 'travalers'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update([
            'service_id' => Service::find($request->pelanggan_id)->id,
            'total_amount' => $request->total_harga,
        ]);

        return redirect()->route('admin.order');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('admin.order');
    }

    public function payment_proff(Order $order)
    {
        $paymentPreff = UploadPayment::where('order_id', $order->id)->get();
        return view('admin.order.payment_proff', compact('paymentPreff', 'order'));
    }
    public function payment_proff_create(Order $order)
    {
        return view('admin.order.payment_proff_create', compact('order'));
    }


    // Baik untuk debugging

    public function payment_proff_store(Request $request, Order $order)
    {
        // 1. Validasi Input (WAJIB)
        // Ini memperbaiki bug 'Undefined variable' dan mengamankan upload
        $validated = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Wajib, harus gambar, max 2MB
        ]);

        $path = null; // Inisialisasi $path

    try {
        // 2. Simpan file di dalam subfolder 'payment_proofs'
        if ($request->hasFile('foto')) {
            // Ini akan menyimpan file di: storage/app/public/payment_proofs
            $path = $request->file('foto')->store('payment_proofs', 'public');

        }
        try {
            // 2. Simpan file di dalam subfolder 'payment_proofs'
            if ($request->hasFile('foto')) {
                // Ini akan menyimpan file di: storage/app/public/payment_proofs
                $path = $request->file('foto')->store('payment_proofs', 'public');

            }

            // 3. Buat entri database
            // Gunakan nama kolom yang konsisten.
            // Di Blade Anda sebelumnya: payment_proff
            // Di sini (dan sepertinya lebih benar): payment_proof
            $order->uploadPayments()->create([
                'payment_proof' => $path,
            ]);

            return redirect()->route('payment.proff', $order->id)->with('success', 'Bukti pembayaran berhasil ditambahkan');

        } catch (\Exception $e) {
            // Jika terjadi error saat simpan database atau file
            Log::error('Gagal upload bukti bayar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Gagal menambahkan bukti pembayaran.');
        }
    }

    public function calculateFinalTotal(Request $request, Order $order)
    {
        // 1. Muat Service dengan SEMUA relasi item layanan yang mungkin
        //    Gunakan nama relasi yang Anda definisikan di model Service.php
        $service = $order->service()->with([
            'meals',                // Asumsi relasi hasMany ke Meal
            'hotels',               // Asumsi relasi hasMany ke Hotel
            'planes',               // Asumsi relasi hasMany ke Plane
            'tours',                // Asumsi relasi hasMany ke Tour
            'guides',               // Asumsi relasi hasMany ke Guide
            'contentCustomers',     // Asumsi relasi hasMany ke ContentCustomer
            'badals',               // Asumsi relasi hasMany ke Badal
            'doronganOrders',       // Asumsi relasi hasMany ke DoronganOrder
            'wakafCustomers',       // Asumsi relasi hasMany ke WakafCustomer
            'customerDocuments',    // Asumsi relasi hasMany ke CustomerDocument
            'exchanges',            // Asumsi relasi hasMany ke Exchange
            'handlings.handlingHotels', // Relasi nested
            'handlings.handlingPlanes', // Relasi nested
            'transportationItems'   // Asumsi relasi hasMany ke TransportationItem
        ])->first();

        if (!$service) {
            return back()->with('error', 'Service tidak ditemukan untuk Order ini.');
        }

        // 2. Cek apakah SEMUA item sudah final
        $semuaItemFinal = true;

        // Daftar relasi yang perlu dicek (sesuaikan nama relasi jika berbeda)
        $relationsToCheck = [
            'meals', 'hotels', 'planes', 'tours', 'guides', 'contentCustomers',
            'badals', 'doronganOrders', 'wakafCustomers', 'customerDocuments',
            'exchanges', 'transportationItems'
        ];

        foreach ($relationsToCheck as $relationName) {
            $items = $service->$relationName; // Mengambil collection/item dari relasi

            if ($items instanceof \Illuminate\Database\Eloquent\Collection) {
                // Jika relasinya hasMany (Collection)
                foreach ($items as $item) {
                    if (isset($item->status_item) && $item->status_item !== 'final') {
                        $semuaItemFinal = false;
                        $itemName = class_basename($item); // Mendapat nama model (misal: "Meal")
                        return back()->with('error', "Gagal: Item {$itemName} (ID: {$item->id}) belum final.");
                    }
                }
            } elseif ($items instanceof \Illuminate\Database\Eloquent\Model) {
                // Jika relasinya hasOne (Satu Model)
                if (isset($items->status_item) && $items->status_item !== 'final') {
                    $semuaItemFinal = false;
                    $itemName = class_basename($items);
                    return back()->with('error', "Gagal: Item {$itemName} (ID: {$items->id}) belum final.");
                }
            }
            // Jika $items null (relasi tidak ada data), itu tidak masalah (dianggap 0 item)
        }

        // Cek relasi nested 'handlings' secara terpisah
        if ($service->handlings) {
            foreach ($service->handlings as $handling) {
                foreach ($handling->handlingHotels as $item) {
                    if (isset($item->status_item) && $item->status_item !== 'final') {
                        return back()->with('error', 'Gagal: Item HandlingHotel (ID: '.$item->id.') belum final.');
                    }
                }
                foreach ($handling->handlingPlanes as $item) {
                    if (isset($item->status_item) && $item->status_item !== 'final') {
                        return back()->with('error', 'Gagal: Item HandlingPlane (ID: '.$item->id.') belum final.');
                    }
                }
            }
        }

        if (!$semuaItemFinal) {
            // Pesan ini mungkin tidak akan tercapai jika error di atas sudah return, tapi sebagai penjaga
            return back()->with('error', 'Gagal: Belum semua item layanan diisi harga final oleh divisi.');
        }

        // 3. Jika semua sudah final, HITUNG OTOMATIS
        $finalTotalAmount = 0;

        // Asumsi: Setiap item sekarang punya kolom `harga_jual` yang diisi divisi
        // Sesuaikan logika kalkulasi (misal: * jumlah, * hari) jika diperlukan

        foreach ($service->meals as $item) {
            // Asumsi: harga_jual adalah total untuk item meal tsb (atau harga_jual * jumlah)
            // Kita gunakan asumsi paling umum: harga_jual * jumlah
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->hotels as $hotel) {
            $hargaJualFinal = (float)($hotel->harga_jual ?? 0); // Asumsi harga_jual adalah HARGA PER KAMAR PER MALAM
            $jumlahMalam = Carbon::parse($hotel->tanggal_checkin)->diffInDays($hotel->tanggal_checkout);
            if ($jumlahMalam <= 0) $jumlahMalam = 1;
            $finalTotalAmount += ($hargaJualFinal * (int)($hotel->jumlah_type ?? 1) * $jumlahMalam);
        }

        foreach ($service->planes as $item) {
            // Asumsi: harga_jual adalah HARGA PER JAMAAH
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah_jamaah ?? 1);
        }

        foreach ($service->tours as $item) {
            // Asumsi: harga_jual adalah total biaya (tour + transport) per service tour
            $finalTotalAmount += (float)($item->harga_jual ?? 0);
        }

        foreach ($service->guides as $item) {
            // Asumsi: harga_jual adalah HARGA PER GUIDE
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->contentCustomers as $item) {
            // Asumsi: harga_jual adalah HARGA PER KONTEN
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->badals as $item) {
            // Asumsi: harga_jual adalah HARGA PER BADAL
            $finalTotalAmount += (float)($item->harga_jual ?? 0);
        }

        foreach ($service->doronganOrders as $item) {
            // Asumsi: harga_jual adalah HARGA PER DORONGAN
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->wakafCustomers as $item) {
            // Asumsi: harga_jual adalah HARGA PER WAKAF
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->customerDocuments as $item) {
            // Asumsi: harga_jual adalah HARGA PER DOKUMEN
            $finalTotalAmount += (float)($item->harga_jual ?? 0) * (int)($item->jumlah ?? 1);
        }

        foreach ($service->exchanges as $item) {
            // Asumsi: harga_jual adalah BIAYA JASA penukaran, atau TOTAL HASIL AKHIR
            // Kita gunakan asumsi harga_jual adalah BIAYA JASA
            $finalTotalAmount += (float)($item->harga_jual ?? 0);
        }

        foreach ($service->transportationItems as $item) {
            // Asumsi: harga_jual adalah HARGA PER HARI (mirip hotel)
            $hargaJualFinal = (float)($item->harga_jual ?? 0);
            $jumlahHari = Carbon::parse($item->dari_tanggal)->diffInDays($item->sampai_tanggal);
            if ($jumlahHari <= 0) $jumlahHari = 1;
            $finalTotalAmount += ($hargaJualFinal * $jumlahHari);
        }

        // Kalkulasi untuk Handling
        if ($service->handlings) {
            foreach ($service->handlings as $handling) {
                foreach ($handling->handlingHotels as $item) {
                    // Asumsi: harga_jual adalah BIAYA JASA handling
                    $finalTotalAmount += (float)($item->harga_jual ?? 0);
                }
                foreach ($handling->handlingPlanes as $item) {
                    // Asumsi: harga_jual adalah BIAYA JASA handling
                    $finalTotalAmount += (float)($item->harga_jual ?? 0);
                }
            }
        }

        // 4. Update Order dengan total final
        $order->update([
            'total_amount_final' => $finalTotalAmount, // Gunakan kolom final Anda
            'sisa_hutang' => $finalTotalAmount - $order->total_yang_dibayarkan, // Hitung ulang sisa
            'status_harga' => 'final', // Ubah status harga
            'status' => 'deal' // Ubah status service/order jika perlu (atau 'siap_bayar')
        ]);

        return back()->with('success', 'Total tagihan final berhasil dihitung ulang!');
    }
}
