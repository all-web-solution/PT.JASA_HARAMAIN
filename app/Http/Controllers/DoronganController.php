<?php

namespace App\Http\Controllers;

use App\Models\DoronganOrder;
use Illuminate\Http\Request;
use App\Models\Dorongan;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class DoronganController extends Controller
{
    public function index()
    {

        $items = Dorongan::with('dorongans')->get();

        return view('palugada.dorongan.index', compact('items'));
    }

    public function create()
    {
        return view('palugada.dorongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Dorongan::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        Session::flash('success', 'Dorongan created successfully!');

        return redirect()->route('dorongan.index');
    }

    public function edit(string $id)
    {
        $item = Dorongan::findOrFail($id);
        return view('palugada.dorongan.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Dorongan::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        Session::flash('success', 'Dorongan updated successfully!');

        return redirect()->route('dorongan.index');
    }

    public function destroy(string $id)
    {
        $item = Dorongan::findOrFail($id);
        $item->delete();

        Session::flash('success', 'Dorongan deleted successfully!');

        return redirect()->route('dorongan.index');
    }

    public function customer()
    {
        // 1. Ambil data DoronganOrder (per item) dan lakukan paginasi
        $doronganOrders = DoronganOrder::with([
                        'service.pelanggan', // Untuk Nama Travel
                        'dorongan'           // Untuk Nama Item Dorongan
                    ])
                    ->latest() // Urutkan berdasarkan yang terbaru
                    ->paginate(15); // Ambil 15 item per halaman

        // 2. Kirim data paginator ke view
        return view('palugada.dorongan.customer', compact('doronganOrders'));
    }

    public function showCustomer(DoronganOrder $dorongan)
    {
        // $dorongan otomatis ditemukan oleh Laravel (Route Model Binding)

        // Load relasi yang dibutuhkan oleh view
        $dorongan->load('service.pelanggan', 'dorongan');

        // Asumsi nama view Anda adalah 'handling.dorongan.show'
        return view('palugada.dorongan.customer_detail', [
            'dorongan' => $dorongan // Mengirim variabel $dorongan
        ]);
    }

    public function editCustomer(DoronganOrder $dorongan)
    {
        // $dorongan adalah instance DoronganOrder yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $doronganItems = Dorongan::all(); // Ambil master data dorongan

        // Asumsi status (sesuai model lain)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('palugada.dorongan.customer_edit', compact(
            'dorongan',
            'services',
            'doronganItems',
            'statuses'
        ));
    }

    public function updateCustomer(Request $request, DoronganOrder $dorongan)
    {
        // Validasi data berdasarkan model DoronganOrder
        $validatedData = $request->validate([
            // 'service_id' => 'required|exists:services,id',
            // 'dorongan_id' => 'required|exists:dorongans,id', // Pastikan tabel 'dorongans'
            'jumlah' => 'nullable|integer|min:0',
            // 'tanggal_pelaksanaan' => 'required|date',
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data dorongan
        $dorongan->update($validatedData);

        Session::flash('success', 'Order dorongan berhasil diperbarui.');

        // Redirect kembali ke halaman detail
        return redirect()->route('dorongan.customer.show', $dorongan->id);
    }

    public function showSupplier($id)
    {
        $content = DoronganOrder::findOrFail($id);
        return view('palugada.dorongan.supplier', compact('content'));
    }
    public function createSupplier($id)
    {
        $content = DoronganOrder::findOrFail($id);
        return view('palugada.dorongan.supplier_create', compact('content'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $content = DoronganOrder::findOrFail($id);
        $content->supplier = $request->input('name');
        $content->harga_dasar = $request->input('price');
        $content->save();
        return redirect()->route('dorongan.supplier.show', $id);
    }
}
