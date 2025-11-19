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
        // 1. Mulai query, JANGAN panggil all()
        $allPlanes = Plane::query();

        $planes = $allPlanes->latest()->paginate(10);

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
        $transportation = TransportationItem    ::findOrFail($id);
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
                'total_amount_final' => $GrandTotal,
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
        // Temukan item transportasi yang diklik
        $transportationItem = TransportationItem::findOrFail($id);

        // Ambil service_id dari item tersebut
        $service_id = $transportationItem->service_id;

        // Load SEMUA data service yang relevan
        // Ini adalah cara terbaik untuk mendapatkan semua data untuk view
        $service = Service::with([
            'pelanggan', // Untuk kartu detail customer
            'transportationItem.transportation', // Untuk tabel (nama mobil)
            'transportationItem.route'           // Untuk tabel (nama rute)
        ])->find($service_id);


        // Kirim 'service' (yang berisi semua data) dan 'transportationItem' (item spesifik)
        return view('transportasi.mobil.detail_customer', compact('service', 'transportationItem'));
    }

    public function editCustomer(TransportationItem $item)
    {
        // $item adalah instance TransportationItem yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $transportations = Transportation::all();
        $routes = Route::all();

        // Asumsi status diambil dari model atau enum
        // (Jika 'status' tidak ada di model Anda, hapus baris ini dan dropdown-nya)
        $statuses = ['nego', 'deal', 'batal', 'done']; // Sesuaikan dengan kebutuhan

        return view('transportasi.mobil.customer_edit', compact(
            'item', // Mengirim data dengan nama $item
            'services',
            'transportations',
            'routes',
            'statuses'
        ));
    }

    public function updateCustomer(Request $request, TransportationItem $item)
    {
        // Validasi data berdasarkan model
        $validatedData = $request->validate([
            'status' => 'required|string', // Sesuaikan aturan validasi status
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data
        $item->update($validatedData);

        // Redirect kembali ke halaman detail customer
        return redirect()->route('transportation.car.detail.customer', $item->id)
                         ->with('success', 'Order transportasi berhasil diperbarui!');
    }
}
