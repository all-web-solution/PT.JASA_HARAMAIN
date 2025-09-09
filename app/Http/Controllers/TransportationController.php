<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Plane;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\Route;

class TransportationController extends Controller
{
    public function index()
    {
        $planes = Plane::all();
        return view('transportasi.pesawat.index',  compact('planes'));
    }
    public function indexCar()
    {
        $Transportations = Transportation::all();
        return view('transportasi.mobil.index', ['Transportations' => $Transportations]);
    }
    public function createCar()
    {
        return view('transportasi.mobil.create');
    }

    public function storeCar(Request $request)
    {
        $status =  Transportation::create([
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga
        ]);

        if ($status) {
            return redirect()->route('transportation.car.index')->with('success', 'Data kendaraan berhasil di tambahkan');
        } else {
            return redirect()->back()->with('failed', 'Data mobil gagal di tambahkan');
        }
    }

    public function editCar($id)
    {
        $Transportation = Transportation::findOrFail($id);
        return view('transportasi.mobil.edit', compact("Transportation"));
    }
    public function updateCar($id, Request $request)
    {
        $Transportation = Transportation::findOrFail($id);
        $status = $Transportation->update([
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga
        ]);

        if ($status) {
            return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
        }
    }
    public function deleteCar($id)
    {
        $Transportation = Transportation::findOrFail($id);
        $Transportation->delete();
        return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
    }

    public function TransportationCustomer()
    {
        $customers = TransportationItem::all();
        return view('transportasi.mobil.customer', compact('customers'));
    }

    public function detailCar($id)
    {
        $transportation = Transportation::findOrFail($id);
        $routes = Route::where('transportation_id', $transportation->id)->get();

        return view('transportasi.mobil.detail', compact('transportation', 'routes'));
    }

    public function edit($id)
    {
        $pesawat = Plane::findOrFail($id);
        return view('transportasi.pesawat.edit', compact('pesawat'));
    }
    public function update(Request $request, $id)
    {
        $plane = Plane::findOrFail($id);
        $plane->update(['harga' => $request->harga]);
        $order = Order::where('service_id', $plane->service->id)->first();

        if ($order) {
            $service = $plane->service;


            $totalPlanes = $service->planes()->sum('harga');
            $grandTotal = $totalPlanes;


            $order->update([
                'total_amount' => $grandTotal,
                'sisa_hutang' => $grandTotal
            ]);
        }

        return redirect()->route('transportation.plane.index')
            ->with('success', 'Harga pesawat & total order berhasil diperbarui!');
    }
}
