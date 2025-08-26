<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('admin.services.index', compact('services'));
    }
    public function create()
    {

        $pelanggans = Pelanggan::all();
        return view('admin.services.create', compact('pelanggans'));
    }


    public function show()
    {
        return view('admin.services.show', compact('service'));
    }

   public function store(Request $request)
{
    // Validasi dasar (bisa kamu tambah sesuai kebutuhan)


    // 1. Simpan data utama ke tabel services
    $service = \App\Models\Service::create([
        'pelanggan_id' => $request->travel_id,
        'contact_person' => $request->contact_person,
        'email' => $request->email,
        'phone' => $request->phone,
        'departure_date' => $request->departure_date,
        'return_date' => $request->return_date,
        'total_jamaah' => $request->total_jamaah,
        'jumlah_jamaah' => $request->jumlah_jamaah,
        'harga_bandara' => $request->harga_bandara,
        'nama_bandara' => $request->nama_bandara,
        'kedatangan_jamaah' => $request->kedatangan_jamaah,
        'jumlah_pendamping' => $request->jumlah_pendamping,
        'services_type' => $request->services, // contoh: transport
    ]);

    // 2. Simpan planes
    if ($request->has('plane')) {
        foreach ($request->plane as $plane) {
            $service->planes()->create([
                'plane_name' => $plane['plane_name'] ?? null,
                'ticket_price' => $plane['ticket_price'] ?? null,
                'jumlah_jamaah' => $plane['jumlah_jamaah'] ?? null,
            ]);
        }
    }

    // 3. Simpan hotel
    if ($request->filled('nama_hotel')) {
        $service->hotels()->create([
            'nama_hotel' => $request->nama_hotel,
            'tanggal_hotel' => $request->tanggal_hotel,
            'harga_hotel' => $request->harga_hotel,
            'pax_hotel' => $request->pax_hotel,
            'lokasi' => 'makkah', // bisa kamu mapping sesuai input
        ]);
    }

    // 4. Simpan handling
    if ($request->has('handlings')) {
        foreach ($request->handlings as $handling) {
            $service->handlings()->create([
                'handling_type' => $handling['type'] ?? 'default',
                'harga' => $handling['harga'] ?? 0,
                'jumlah' => $handling['jumlah'] ?? 0,
            ]);
        }
    }

    // 5. Simpan pendamping
    if ($request->has('pendamping')) {
        foreach ($request->pendamping as $pendamping) {
            $service->pendampings()->create([
                'nama' => $pendamping['nama'] ?? null,
                'jumlah' => $pendamping['jumlah'] ?? $request->jumlah_pendamping,
                'harga' => $pendamping['harga'] ?? null,
            ]);
        }
    }

    // 6. Simpan contents
    if ($request->has('content')) {
        foreach ($request->content as $key => $value) {
            $service->contents()->create([
                'content_type' => $key,     // misalnya "itinerary", "fasilitas"
                'content_text' => $value,   // isi kontennya
            ]);
        }
    }

    return redirect()
        ->route('admin.services')
        ->with('success', 'Service created successfully.');
}


    public function edit($id)
    {
        // $service = Services::findOrFail($id);
        // $pelanggans = Pelanggan::all();
        // return view('admin.services.edit', compact('service', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'pelanggan_id' => 'required|exists:pelanggans,id',
        //     'jamaah' => 'required|string|max:255',
        //     'service' => 'required|integer',
        //     'tanggal_keberangkatan' => 'required|date',
        //     'tanggal_kepulangan' => 'required|date',
        //     'plane_id' => 'required|exists:planes,id',
        //     'bus_id' => 'nullable|exists:buses,id',
        //     'makkah_hotel_id' => 'required|exists:makkah_hotels,id',
        //     'madina_hotel_id' => 'required|exists:madina_hotels,id',
        //     'visa' => 'required|string|max:255',
        //     'vaksin' => 'required|string|max:255',
        //     'bandara_indonesia' => 'required|string|max:255',
        //     'bandara_jeddah' => 'required|string|max:255',
        //     'checkout_hotel_makkah' => 'nullable|date',
        // ]);

        // $service = Services::findOrFail($id);
        // $service->update($request->all());

        // return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        // $service = Services::findOrFail($id);
        // $service->delete();

        // return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
