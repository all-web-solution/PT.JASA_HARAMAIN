<?php

namespace App\Http\Controllers;

use App\Models\Badal;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BadalController extends Controller
{
    public function index()
    {
        $badals = Badal::with('service.pelanggan') // Eager load
                        ->latest()
                        ->paginate(15);

        // Asumsi nama view handling.badal.index
        return view('palugada.badal', compact('badals'));
    }

    public function show(Badal $badal)
    {
        // $badal otomatis ditemukan oleh Laravel
        $badal->load('service.pelanggan'); // Load relasi

        // Asumsi nama view handling.badal.show
        return view('palugada.badal_detail', compact('badal'));
    }

    public function edit(Badal $badal)
    {
        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        // Asumsi nama view handling.badal.edit
        return view('palugada.badal_edit', compact(
            'badal',
            'services',
            'statuses'
        ));
    }

    public function update(Request $request, Badal $badal)
    {
        // Validasi data berdasarkan model Badal
        $validatedData = $request->validate([
            // 'service_id' => 'required|exists:services,id',
            // 'name' => 'required|string|max:255',
            // 'price' => 'nullable|numeric|min:0', // 'price' adalah harga lama/estimasi
            // 'tanggal_pelaksanaan' => 'required|date',
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data badal
        $badal->update($validatedData);

        Session::flash('success', 'Order badal berhasil diperbarui.');

        // Redirect kembali ke halaman detail
        return redirect()->route('badal.show', $badal->id);
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
