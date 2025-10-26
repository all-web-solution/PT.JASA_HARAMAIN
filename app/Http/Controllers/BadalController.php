<?php

namespace App\Http\Controllers;

use App\Models\Badal;
use Illuminate\Http\Request;

class BadalController extends Controller
{
    public function index()
    {
        $AllBadal = \App\Models\Badal::all();
        $wakaf = $AllBadal->unique('service_id');
        return view('palugada.badal', compact('wakaf'));
    }

    public function show($id)
    {
       // 1. Cari satu item Badal yang di-klik (untuk dapat service_id-nya)
    // Kita juga load relasi service dan pelanggan-nya
    $satuBadal = \App\Models\Badal::with('service.pelanggan')->findOrFail($id);

    // 2. Ambil objek Service-nya
    // Objek $service ini sudah berisi info pelanggan (karena di-load di atas)
    $service = $satuBadal->service;

    // 3. Ambil SEMUA item Badal yang punya service_id yang sama
    // Kita bisa load dari relasi di $service (jika sudah didefinisikan)
    // Asumsi di model Service ada relasi: public function badals() { return $this->hasMany(Badal::class); }
    $semuaItemBadal = $service->badals;

    // ATAU jika relasi belum ada, query manual:
    // $semuaItemBadal = \App\Models\Badal::where('service_id', $service->id)->get();

    // 4. Kirim data service (untuk info customer) dan semuaItemBadal (untuk list) ke view
    return view('palugada.badal_detail', compact('service', 'semuaItemBadal'));
    }

    public function supplier($id){

        return view('palugada.badal_supplier', ['badal' => Badal::find($id)]);
    }
    public function supplierCreate($id){

        return view('palugada.badal_supplier_create', ['content' => Badal::find($id)]);
    }
    public function supplierStore(Request $request, $id){

       $badal = Badal::findOrFail($id);
       $badal->supplier = $request->name;
       $badal->harga_dasar = $request->price;
       $badal->save();
        return redirect()->route('palugada.badal.supplier.show', $id);
    }
}
