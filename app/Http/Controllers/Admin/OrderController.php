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
use App\Models\Transaction;
use App\Models\TransportationItem;
use App\Models\UploadPayment;
use App\Models\WakafCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $mainOrderIds = Order::select(DB::raw('MAX(id) as id'))
            ->groupBy('service_id')
            ->pluck('id');

        $query = Order::with('service.pelanggan')
            ->whereIn('id', $mainOrderIds);

        $statsQueryBase = Order::whereIn('id', $mainOrderIds);

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
            $statsQueryBase->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
            $statsQueryBase->whereYear('created_at', $request->tahun);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
            $statsQueryBase->whereDate('created_at', $request->tanggal);
        }
        if ($request->filled('search')) {
            $search_term = '%' . $request->search . '%';

            $searchFilter = function ($q) use ($search_term) {
                $q->where('invoice', 'like', $search_term);

                $q->orWhereHas('service.pelanggan', function ($q_pelanggan) use ($search_term) {
                    $q_pelanggan->where('nama_travel', 'like', $search_term);
                });
            };

            $query->where($searchFilter);
            $statsQueryBase->where($searchFilter);
        }
        $stats = [
            'total' => $statsQueryBase->clone()->count(),
            'belum_bayar' => $statsQueryBase->clone()->where('status_pembayaran', 'belum_bayar')->count(),
            'belum_lunas' => $statsQueryBase->clone()->where('status_pembayaran', 'belum_lunas')->count(),
            'lunas' => $statsQueryBase->clone()->where('status_pembayaran', 'lunas')->count()
        ];

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.order.index', compact('orders', 'stats'));
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
            'total_harga' => 'required|numeric|min:0',
        ]);

        $order = Order::where('service_id', $request->pelanggan_id)->first();

        if ($order) {
            $order->total_amount += $request->total_harga;
            $order->save();
        } else {
            $order = Order::create([
                'service_id' => $request->pelanggan_id,
                'total_amount' => $request->total_harga,
            ]);
        }

        return redirect()->route('admin.order')->with('success', 'Order berhasil disimpan');
    }

    public function show(Order $order)
    {
        $relationsToLoad = [
            'service.pelanggan',
            'transactions',
            'uploadPayments',
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
            'service.handlings.handlingHotels',
            'service.handlings.handlingPlanes',
            'service.filess'
        ];

        $order->load($relationsToLoad);

        $orders = Order::where('service_id', $order->service_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $transactions = Transaction::where('order_id', $order->service_id)->get();

        $semuaItem = $order->service->getAllItemsFromService();

        return view('admin.order.show', compact('order', 'orders', 'transactions', 'semuaItem'));
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
        // 1. Muat Service dengan SEMUA relasi item layanan
        $service = $order->service()->with([
            'meals',
            'hotels',
            'planes',
            'tours',
            'guides',
            'contents',
            'badals',
            'dorongans',
            'wakafs',
            'documents',
            'exchanges',
            'transportationItem',
            'handlings.handlingHotels',
            'handlings.handlingPlanes'
        ])->first();

        if (!$service) {
            return back()->with('error', 'Service tidak ditemukan untuk Order ini.');
        }

        // 2. Kumpulkan semua item menggunakan helper
        //    PASTIKAN Anda sudah menambahkan helper getAllItemsFromService() di Model Service.php
        $allItems = $service->getAllItemsFromService();

        if ($allItems->isEmpty()) {
            return back()->with('error', 'Gagal: Service ini tidak memiliki item layanan detail.');
        }

        // 3. Cek apakah SEMUA item sudah final (status BUKAN 'nego')
        foreach ($allItems as $item) {
            // Asumsi kolom status di semua item adalah 'status'
            if (isset($item->status) && $item->status === 'nego') {
                $itemName = class_basename($item);
                return back()->with('error', "Gagal: Item {$itemName} (ID: {$item->id}) statusnya masih 'nego'.");
            }
        }

        // 4. Jika semua sudah final, HITUNG OTOMATIS
        $finalTotalAmount = 0;
        foreach ($allItems as $item) {
            // Panggil helper kalkulasi harga
            $finalTotalAmount += $this->calculateItemFinalPrice($item);
        }

        // 5. Update Order dengan total final
        $order->update([
            'total_amount_final' => $finalTotalAmount,
            'sisa_hutang' => $finalTotalAmount - $order->total_yang_dibayarkan, // Hitung ulang sisa
            'status_harga' => 'final', // Ubah status harga
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

        // Ambil harga jual (asumsi semua model sudah punya kolom 'harga_jual')
        $hargaJual = (float) ($item->harga_jual ?? 0);

        // Tentukan logika berdasarkan tipe Model
        if ($item instanceof Hotel) {
            $jumlahMalam = Carbon::parse($item->tanggal_checkin)->diffInDays($item->tanggal_checkout);
            if ($jumlahMalam <= 0)
                $jumlahMalam = 1;
            $total = $hargaJual * (int) ($item->jumlah_type ?? 1) * $jumlahMalam;

        } elseif ($item instanceof Meal) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof Plane) {
            $total = $hargaJual * (int) ($item->jumlah_jamaah ?? 1);

        } elseif ($item instanceof Guide) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof ContentCustomer) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof DoronganOrder) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof WakafCustomer) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof CustomerDocument) {
            $total = $hargaJual * (int) ($item->jumlah ?? 1);

        } elseif ($item instanceof TransportationItem) {
            $jumlahHari = Carbon::parse($item->dari_tanggal)->diffInDays($item->sampai_tanggal);
            if ($jumlahHari <= 0)
                $jumlahHari = 1;
            $total = $hargaJual * $jumlahHari;

        } elseif ($item instanceof Exchange) {
            $jumlahInput = (float) ($item->jumlah_input ?? 0);
            $total = $jumlahInput;

        } elseif ($item instanceof HandlingHotel) {
            $hargaFinal = (float) ($item->harga_jual ?? 0);
            $total = $hargaFinal;
        } elseif ($item instanceof HandlingPlanes) {
            $hargaFinal = (float) ($item->harga_jual ?? 0);
            $total = $hargaFinal;
        } elseif (
            $item instanceof Tour ||
            $item instanceof Badal
        ) {
            $total = $hargaJual; // Asumsi harga total

        }

        return $total;
    }
}
