<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Service;
use Illuminate\Http\Request;

class ReyalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reyals = Exchange::query()
            ->latest()
            ->paginate(10);

        return view('reyal.index', compact('reyals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function createSupplier($id)
    {
        $supplier = Exchange::findOrFail($id);

        return view('reyal.supplier_create', compact('supplier'));
    }

    public function showReyal(Exchange $reyal)
    {
        // $reyal otomatis ditemukan oleh Laravel (Route Model Binding)

        // Load relasi yang dibutuhkan oleh view (Info Pelanggan)
        $reyal->load('service.pelanggan');

        // Asumsi nama view Anda adalah 'reyal.detail'
        return view('reyal.reyal_detail', [
            'reyal' => $reyal
        ]);
    }

    public function editReyal(Exchange $reyal)
    {
        // Ambil data untuk dropdown
        $services = Service::with('pelanggan')->get();

        // Ambil opsi 'tipe' dari model
        $tipeOptions = ['tamis', 'tumis'];
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        // Asumsi nama view Anda adalah 'reyal.edit'
        return view('reyal.reyal_edit', [
            'reyal' => $reyal,
            'services' => $services,
            'tipeOptions' => $tipeOptions,
            'statuses' => $statuses
        ]);
    }

    /**
     * Memvalidasi dan MENYIMPAN perubahan dari form edit Reyal.
     */
    public function updateReyal(Request $request, Exchange $reyal)
    {
        // Validasi berdasarkan 'fillable' di model Exchange
        $validatedData = $request->validate([
            'tanggal_penyerahan' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:1',
            'status' => 'required'
        ]);

        if ($request->filled('harga_jual') && $request->harga_jual > 0) {

            // Ambil jumlah_input yang sudah ada di database
            $jumlahInput = $reyal->jumlah_input;
            $hargaJual   = $request->harga_jual;
            $tipe        = $reyal->tipe;

            // Terapkan Rumus Berdasarkan Tipe
            if ($tipe === 'tamis') {
                // Tamis (Biasanya Rupiah -> Reyal): DIBAGI
                // Rumus: Hasil = Jumlah Input / Kurs
                $validatedData['hasil'] = $jumlahInput / $hargaJual;

            } elseif ($tipe === 'tumis') {
                // Tumis (Biasanya Reyal -> Rupiah): DIKALI
                // Rumus: Hasil = Jumlah Input * Kurs
                $validatedData['hasil'] = $jumlahInput * $hargaJual;
            }
        }

        // Update data reyal
        $reyal->update($validatedData);

        // Redirect kembali ke halaman detail
        return redirect()->route('reyal.detail', $reyal->id)
                         ->with('success', 'Data penukaran reyal berhasil diperbarui!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function supplier(string $id)
    {
        $supplier = Exchange::findOrFail($id);
        return view('reyal.supplier', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function createSupplierStore(Request $request, string $id)
    {
        $supplier = Exchange::findOrFail($id);
        $supplier->supplier = $request->input('name');
        $supplier->harga_dasar = $request->input('price');
        $supplier->save();
        return redirect()->route('reyal.supplier.index', $id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
