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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransportationController extends Controller
{
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

    public function detailCar($id)
    {
        $transportation = TransportationItem    ::findOrFail($id);
        $routes = Route::where('transportation_id', $transportation->id)->get();

        return view('transportasi.mobil.detail', compact('transportation', 'routes'));
    }

    //Customer Car👇

    public function TransportationCustomer()
    {
        // 1. Cari ID item terbaru untuk setiap service_id (agar unik)
        // Kita ambil MAX(id) supaya jika ada duplikat service_id, kita ambil data inputan terakhir
        $latestIds = TransportationItem::select(DB::raw('MAX(id) as id'))
            ->groupBy('service_id')
            ->pluck('id');

        // 2. Ambil data lengkap berdasarkan ID unik tersebut + Pagination
        $customers = TransportationItem::with('service.pelanggan') // Eager loading agar cepat
            ->whereIn('id', $latestIds)
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Tampilkan 10 data per halaman

        return view('transportasi.mobil.customer', compact('customers'));
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

    //Customer Plane👇

    public function indexPlane()
    {
        // 1. Ambil ID pesawat pertama/terbaru untuk setiap service_id agar unik
        $latestPlaneIds = Plane::select(DB::raw('MAX(id) as id'))
            ->groupBy('service_id')
            ->pluck('id');

        // 2. Query data berdasarkan ID tersebut
        $planes = Plane::with(['service.pelanggan'])
            ->whereIn('id', $latestPlaneIds)
            ->latest()
            ->paginate(10);

        return view('transportasi.pesawat.index', compact('planes'));
    }

    /**
     * Halaman Detail: Menampilkan info customer dan LIST tiket pesawat mereka.
     * Parameter: $service_id
     */
    public function showPlane($service_id)
    {
        // Ambil service beserta data pelanggan
        $service = Service::with('pelanggan')->findOrFail($service_id);

        // Ambil semua pesawat yang terkait dengan service ini
        $planes = Plane::where('service_id', $service_id)->get();

        return view('transportasi.pesawat.detail', compact('service', 'planes'));
    }

    /**
     * Halaman Edit: Mengedit SATU item tiket pesawat.
     * Parameter: $plane (Model Binding)
     */
    public function editPlane(Plane $plane)
    {
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        // Kita butuh list service jika ingin memindahkan order (opsional, biasanya read-only)
        $services = Service::with('pelanggan')->get();

        return view('transportasi.pesawat.edit', compact('plane', 'statuses', 'services'));
    }

    /**
     * Proses Update: Menyimpan data dan menghandle 4 file upload.
     */
    public function updatePlane(Request $request, Plane $plane)
    {
        // Validasi disesuaikan dengan Model baru
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'maskapai' => 'required|string|max:255',
            'rute' => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date',
            'jumlah_jamaah' => 'required|integer|min:1',

            // Finansial
            'harga' => 'nullable|numeric|min:0',       // Estimasi
            'harga_dasar' => 'nullable|numeric|min:0', // Modal
            'harga_jual' => 'nullable|numeric|min:0',  // Jual

            'status' => 'required|string',
            'keterangan' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',

            // PERUBAHAN: Tiket sekarang adalah string/text, bukan file
            'tiket' => 'nullable|string|max:255',
        ]);

        // Update data (Tidak ada lagi logika upload file)
        $plane->update($validatedData);

        // Redirect kembali ke halaman DETAIL service
        return redirect()->route('plane.show', $plane->service_id)
                         ->with('success', 'Data penerbangan berhasil diperbarui!');
    }
}
