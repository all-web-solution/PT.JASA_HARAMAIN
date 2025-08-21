<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {

        return view('admin.services.index');
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

        // Services::create($request->all());

        // return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
        
    }

    public function edit($id)
    {
        $service = Services::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view('admin.services.edit', compact('service', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jamaah' => 'required|string|max:255',
            'service' => 'required|integer',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'plane_id' => 'required|exists:planes,id',
            'bus_id' => 'nullable|exists:buses,id',
            'makkah_hotel_id' => 'required|exists:makkah_hotels,id',
            'madina_hotel_id' => 'required|exists:madina_hotels,id',
            'visa' => 'required|string|max:255',
            'vaksin' => 'required|string|max:255',
            'bandara_indonesia' => 'required|string|max:255',
            'bandara_jeddah' => 'required|string|max:255',
            'checkout_hotel_makkah' => 'nullable|date',
        ]);

        $service = Services::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
