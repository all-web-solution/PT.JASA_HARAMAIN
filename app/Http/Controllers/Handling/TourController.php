<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\TourItem;
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
    // Ambil semua tour lengkap dengan relasi service dan pelanggan
    $tours = Tour::with('service.pelanggan')
        ->get()
        ->groupBy('service_id');

    return view('handling.tour.customer', compact('tours'));
}
public function show($id)
{
   // 1. Ambil data Service utama, beserta relasi pelanggannya.
    // Gunakan findOrFail agar otomatis error 404 jika service_id tidak ditemukan.
    $service = Service::with('pelanggan')->findOrFail($id);

    // 2. Ambil SEMUA item tour yang terkait dengan service_id ini.
    // Lakukan Eager Loading untuk 'transportation' dan 'tourItem' untuk performa.
    $tour = Tour::with(['transportation', 'tourItem'])
                  ->where('service_id', $id)
                  ->get();

    // 3. Kirim KEDUA variabel ($service dan $tour) ke view.
    return view('handling.tour.show', compact('service', 'tour'));
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
