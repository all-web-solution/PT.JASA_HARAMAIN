<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Wakaf;
use App\Models\WakafCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WakafController extends Controller
{
    public function index()
    {
        $wakaf = Wakaf::all();

        return view('palugada.wakaf.index', compact('wakaf'));
    }

    public function create()
    {
        return view('palugada.wakaf.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);


        Wakaf::create([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);


        Session::flash('success', 'Wakaf created successfully!');

        return redirect()->route('wakaf.index');
    }

    public function edit(string $id)
    {
        $wakaf = Wakaf::findOrFail($id);
        return view('palugada.wakaf.edit', compact('wakaf'));
    }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $wakaf = Wakaf::findOrFail($id);
        $wakaf->update([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);


        Session::flash('success', 'Wakaf updated successfully!');

        return redirect()->route('wakaf.index');
    }

    public function destroy(string $id)
    {
        $wakaf = Wakaf::findOrFail($id);
        $wakaf->delete();
        Session::flash('success', 'Wakaf deleted successfully!');

        return redirect()->route('wakaf.index');
    }

    public function customer()
    {
        // 1. Ambil data WakafCustomer (per item) dan lakukan paginasi
        $wakafCustomers = WakafCustomer::with([
                        'service.pelanggan', // Untuk Nama Travel
                        'wakaf'              // Untuk Nama Item Wakaf
                    ])
                    ->latest() // Urutkan berdasarkan yang terbaru
                    ->paginate(10); // Ambil 15 item per halaman

        // 2. Kirim data paginator ke view
        return view('palugada.wakaf.customer', compact('wakafCustomers'));
    }

    public function customerDetail(WakafCustomer $wakaf)
    {
        $wakaf->load('service.pelanggan', 'wakaf');

        // Asumsi nama view Anda adalah 'wakaf.show'
        return view('palugada.wakaf.customer_detail', [
            'wakaf' => $wakaf // Mengirim variabel $wakaf
        ]);
    }

    public function editCustomer(WakafCustomer $wakaf)
    {
        // $wakaf adalah instance WakafCustomer yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $wakafItems = Wakaf::all(); // Ambil master data wakaf

        // Asumsi status (sesuai model lain)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('palugada.wakaf.customer_edit', compact(
            'wakaf',
            'services',
            'wakafItems',
            'statuses'
        ));
    }

    /**
     * Menyimpan perubahan untuk order Wakaf.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\WakafCustomer $wakaf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCustomer(Request $request, WakafCustomer $wakaf)
    {
        // Validasi data berdasarkan model WakafCustomer
        $validatedData = $request->validate([
            // 'service_id' => 'required|exists:services,id',
            // 'wakaf_id' => 'required|exists:wakafs,id', // Pastikan tabel 'wakafs'
            // 'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data wakaf
        $wakaf->update($validatedData);

        Session::flash('success', 'Order wakaf berhasil diperbarui.');

        // Redirect kembali ke halaman detail
        return redirect()->route('wakaf.customer.show', $wakaf->id);
    }

    public function showSupplier($id)
    {
        $content = WakafCustomer::findOrFail($id);
        return view('palugada.wakaf.supplier', compact('content'));
    }
    public function createSupplier($id)
    {
        $content = WakafCustomer::findOrFail($id);
        return view('palugada.wakaf.supplier_create', compact('content'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $content = WakafCustomer::findOrFail($id);
        $content->supplier = $request->input('name');
        $content->harga_dasar = $request->input('price');
        $content->save();
        return redirect()->route('wakaf.supplier.show', $id);
    }
}
