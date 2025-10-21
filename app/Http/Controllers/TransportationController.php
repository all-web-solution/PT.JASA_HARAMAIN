<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Plane;
use App\Models\PriceListTicket;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\Route;
use App\Models\Service;

class TransportationController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data pesawat
        $allPlanes = Plane::all();

        // 2. Filter koleksi untuk mendapatkan hanya satu data per 'service_id'
        //    Ini akan mengambil data *pertama* yang ditemui untuk setiap service_id unik.
        $planes = $allPlanes->unique('service_id');

        // 3. Kirim data yang sudah unik ke view
        return view('transportasi.pesawat.index', compact('planes'));
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
        $AllCustomers = TransportationItem::all();
        $customers = $AllCustomers->unique('service_id');

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
        $listTickets = PriceListTicket::all();
        return view('transportasi.pesawat.edit', compact('pesawat', 'listTickets'));
    }
public function update(Request $request, $id)
    {
       $plane = Plane::findOrFail($id);
       $plane->update([
        'harga' => $request->harga,
        'tiket_berangkat' => $request->tiket_berangkat,
        'tiket_pulang' => $request->tiket_pulang
        ]);

       if($plane->service){
            $pelangganId = $plane->service->pelanggan_id;
            $allServices = Service::where('pelanggan_id', $pelangganId)->get();
            $GrandTotal = 0;

            foreach ($allServices as $service) {
                // Hitung total semua pesawat yang terhubung ke layanan ini
                $totalPlanes = $service->planes()->sum('harga');

                // Hitung total semua hotel yang terhubung ke layanan ini
                $totalHotels = $service->hotels()->sum('harga_perkamar');

                // Tambahkan ke total keseluruhan
                $GrandTotal += $totalPlanes + $totalHotels;
            }
            Order::whereHas('service', function ($query) use ($pelangganId) {
                $query->where('pelanggan_id', $pelangganId);
            })->update([
                'total_amount' => $GrandTotal,
                'sisa_hutang' => $GrandTotal,
                'status_pembayaran' => 'belum_bayar'

            ]);
       }
        return redirect()->route('transportation.plane.index')
            ->with('success', 'Harga pesawat & total order berhasil diperbarui!');
    }

// app/Http/Controllers/PlaneController.php (atau nama controller Anda)

public function detail($id)
{
    // Gunakan 'with()' untuk memuat relasi 'service' dan juga 'pelanggan' dari service tsb.
    $plane = Plane::with('service.pelanggan')->findOrFail($id);

    // Kirim data $plane (yang kini sudah berisi service dan pelanggan) ke view
    return view('transportasi.pesawat.detail', compact('plane'));
}

public function detailCustomer($id)
{
    $transportationItem = TransportationItem::with('service.pelanggan')->findOrFail($id);

    return view('transportasi.mobil.detail_customer', compact('transportationItem'));
}
}
