<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\TourItem;
use App\Models\Transportation;
use App\Models\TransportationItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TourController extends Controller
{
    public function index()
    {
        $tours = TourItem::all();
        return view('handling.tour.index', compact('tours'));
    }
    public function create()
    {
        return view('handling.tour.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TourItem::create($request->only('name'));

        Session::flash('success', 'Tour berhasil ditambahkan.');
        return redirect()->route('handling.tour.index');
    }
    public function edit(TourItem $tour)
    {
        return view('handling.tour.edit', compact('tour'));
    }
    public function update(Request $request, TourItem $tour)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $tour->update($request->only('name'));
        Session::flash('success', 'Tour berhasil diperbarui.');
        return redirect()->route('handling.tour.index');
    }
    public function destroy(TourItem $tour)
    {
        $tour->delete();
        Session::flash('success', 'Tour berhasil dihapus.');
        return redirect()->route('handling.tour.index');
    }
   public function customer()
    {
        // 1. Ambil ID tour terbaru untuk setiap service_id (agar unik per travel)
        $latestIds = Tour::select(DB::raw('MAX(id) as id'))
            ->groupBy('service_id')
            ->pluck('id');

        // 2. Ambil data berdasarkan ID unik tersebut
        $tours = Tour::with('service.pelanggan')
            ->whereIn('id', $latestIds)
            ->latest()
            ->paginate(10);

        // 2. Kirim data paginator ke view
        return view('handling.tour.customer', compact('tours')); // Sesuaikan path view jika perlu
    }

    public function showCustomerTour($service_id)
    {
        // 1. Cari data Service & Pelanggan berdasarkan service_id
        $service = Service::with('pelanggan')->findOrFail($service_id);

        // 2. Ambil SEMUA item tour yang milik service_id tersebut
        $tourList = Tour::where('service_id', $service_id)
                    ->get();

        // 3. Kirim ke view
        // Kita kirim $service (untuk info customer) dan $tourList (untuk tabel)
        return view('handling.tour.show', compact('service', 'tourList'));
    }

    public function editCustomerTour(Tour $tour)
    {
        // $tour adalah instance Tour yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $transportations = Transportation::all();
        $tourItems = TourItem::all();

        // Asumsi status (sesuai model lain)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('handling.tour.customer_edit', compact(
            'tour',
            'services',
            'transportations',
            'tourItems',
            'statuses'
        ));
    }

    public function updateCustomerTour(Request $request, Tour $tour)
    {
        // Validasi data berdasarkan model Tour
        $validatedData = $request->validate([
            // 'service_id' => 'required|exists:services,id',
            // 'transportation_id' => 'nullable|exists:transportations,id',
            // 'tour_id' => 'required|exists:tour_items,id',
            // 'tanggal_keberangkatan' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
        ]);

        // Update data tour
        $tour->update($validatedData);

        Session::flash('success', 'Order tour berhasil diperbarui.');

        // Redirect kembali ke halaman detail tour
        return redirect()->route('tour.customer.show', $tour->id);
    }


    public function showSupplier($id)
    {
        $content = Tour::findOrFail($id);
        return view('handling.tour.supplier', compact('content'));
    }
    public function createSupplier($id)
    {
        $content = Tour::findOrFail($id);
        return view('handling.tour.supplier_create', compact('content'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $content = Tour::findOrFail($id);
        $content->supplier = $request->input('name');
        $content->harga_dasar = $request->input('price');
        $content->save();
        return redirect()->route('tour.supplier.show', $id);
    }

}
