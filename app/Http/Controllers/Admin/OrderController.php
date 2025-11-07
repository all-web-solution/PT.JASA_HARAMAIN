<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badal;
use App\Models\ContentCustomer;
use App\Models\CustomerDocument;
use App\Models\DoronganOrder;
use App\Models\Exchange;
use App\Models\Guide;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use App\Models\Hotel;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Plane;
use App\Models\Service;
use App\Models\Tour;
use App\Models\TransportationItem;
use App\Models\UploadPayment;
use App\Models\WakafCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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

    public function show(Order $order)
    {
        // $order otomatis ditemukan oleh Laravel (Route Model Binding)

        // Load SEMUA relasi yang dibutuhkan oleh view secara efisien
        $order->load([
            'service.pelanggan', // Untuk info customer
            'transactions',      // Untuk riwayat pembayaran
            'uploadPayments',    // Untuk riwayat upload bukti

            // --- "Struk Supermarket" ---
            'service.hotels',
            'service.meals.mealItem',
            'service.planes',
            'service.transportationItem.transportation',
            'service.transportationItem.route',
            'service.tours.tourItem',
            'service.tours.transportation',
            'service.guides.guideItem',
            'service.documents.document',
            'service.documents.documentChild',
            'service.contents.content',
            'service.badals',
            'service.wakafs.wakaf',
            'service.dorongans.dorongan',
            'service.exchanges',
            'service.handlings',
            'service.filess' // Pastikan relasi 'filess' ada di model Service
        ]);

        // Kirim data order yang sudah lengkap ke view
        return view('admin.order.show', compact('order'));
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
        $service = $order->service()->with([
            'meals', 'hotels', 'planes', 'tours', 'guides', 'contents',
            'badals', 'dorongans', 'wakafs', 'documents', 'exchanges',
            'transportationItem',
            // Load relasi handling secara nested
            'handlings.handlingHotels',
            'handlings.handlingPlanes'
        ])->first();

        if (!$service) {
            return back()->with('error', 'Service tidak ditemukan untuk Order ini.');
        }

        // 2. Kumpulkan semua item menggunakan helper
        $allItems = $service->getAllItemsFromService();

        if ($allItems->isEmpty()) {
             return back()->with('error', 'Gagal: Service ini tidak memiliki item layanan detail.');
        }

        // 4. Jika semua sudah final, HITUNG OTOMATIS
        $finalTotalAmount = 0;
        foreach ($allItems as $item) {
            // Panggil helper kalkulasi harga
            $finalTotalAmount += $this->calculateItemFinalPrice($item);
        }

        // 5. Update Order dengan total final
        $order->update([
            // Asumsi Anda punya kolom 'total_amount_final'
            'total_amount' => $finalTotalAmount,
            'sisa_hutang' => $finalTotalAmount - $order->total_yang_dibayarkan, // Hitung ulang sisa
            'status_pembayaran' => 'belum_bayar'
        ]);

        return back()->with('success', 'Total tagihan final berhasil dihitung ulang!');
    }

    /**
     * Helper private untuk menghitung harga jual final dari satu item model.
     * Menggunakan 'instanceof' untuk menentukan logika kalkulasi yang tepat.
     */
    private function calculateItemFinalPrice(Model $item): float
    {
        $total = 0;

        // Ambil harga jual (asumsi semua model sudah punya kolom ini)
        $hargaJual = (float)($item->harga_jual ?? 0);

        // Tentukan logika berdasarkan tipe Model
        if ($item instanceof Hotel) {
            // Asumsi: harga_jual adalah HARGA PER KAMAR PER MALAM
            $jumlahMalam = Carbon::parse($item->tanggal_checkin)->diffInDays($item->tanggal_checkout);
            if ($jumlahMalam <= 0) $jumlahMalam = 1;
            $total = $hargaJual * (int)($item->jumlah_type ?? 1) * $jumlahMalam;

        } elseif ($item instanceof Meal) {
            // Asumsi: harga_jual adalah HARGA PER PORSI
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof Plane) {
            // Asumsi: harga_jual adalah HARGA PER JAMAAH
            $total = $hargaJual * (int)($item->jumlah_jamaah ?? 1);

        } elseif ($item instanceof Guide) {
            // Asumsi: harga_jual adalah HARGA PER GUIDE
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof ContentCustomer) {
            // Asumsi: harga_jual adalah HARGA PER KONTEN
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof DoronganOrder) {
            // Asumsi: harga_jual adalah HARGA PER DORONGAN
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof WakafCustomer) {
            // Asumsi: harga_jual adalah HARGA PER WAKAF
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof CustomerDocument) {
            // Asumsi: harga_jual adalah HARGA PER DOKUMEN
            $total = $hargaJual * (int)($item->jumlah ?? 1);

        } elseif ($item instanceof TransportationItem) {
            // Asumsi: harga_jual adalah HARGA SEWA PER HARI
            $jumlahHari = Carbon::parse($item->dari_tanggal)->diffInDays($item->sampai_tanggal);
            if ($jumlahHari <= 0) $jumlahHari = 1;
            $total = $hargaJual * $jumlahHari;

        } elseif (
            $item instanceof Tour ||
            $item instanceof Badal ||
            $item instanceof Exchange ||
            $item instanceof HandlingHotel ||
            $item instanceof HandlingPlanes
        ) {
            // Asumsi: harga_jual adalah total biaya jasa (bukan per item/per hari)
            $total = $hargaJual;

        } else {
            // Fallback jika ada model lain, bisa ditambahkan
            // $total = $hargaJual;
        }

        return $total;
    }
}
