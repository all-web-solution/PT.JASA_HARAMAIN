<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\GuideItems;
use App\Models\Guide;
use App\Models\Service;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendampingController extends Controller
{
    public function index()
    {
        $guides = GuideItems::all();
        return view('handling.pendamping.index', compact('guides'));
    }

    public function create()
    {
        return view('handling.pendamping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
        ]);

        GuideItems::create($validated);

        Session::flash('success', 'Pendamping berhasil ditambahkan.');

        return redirect()->route('handling.pendamping.index');
    }

    public function edit(string $id)
    {
        $guide = GuideItems::findOrFail($id);
        return view('handling.pendamping.edit', compact('guide'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $guide = GuideItems::findOrFail($id);
        $guide->update($validated);

        Session::flash('success', 'Pendamping berhasil diperbarui.');

        return redirect()->route('handling.pendamping.index');
    }

    public function destroy(string $id)
    {
        $guide = GuideItems::findOrFail($id);
        $guide->delete();

        Session::flash('success', 'Pendamping berhasil dihapus.');

        return redirect()->route('handling.pendamping.index');
    }

    public function customer()
    {
        $guides = Guide::with(['service.pelanggan'])
            ->get()
            ->groupBy('service_id');

        return view('handling.pendamping.customer', compact('guides'));
    }
    public function showCustomer($service_id)
    {
        // Ambil data service lengkap dengan pelanggan & pendamping
        $service = Service::with(['pelanggan', 'guides'])->findOrFail($service_id);

        return view('handling.pendamping.detail', compact('service'));
    }

    public function editGuideOrder(Guide $guide)
    {
        // $guide adalah instance Guide yang ingin diedit,
        // otomatis ditemukan oleh Route Model Binding

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $guideItems = GuideItems::all();
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('handling.pendamping.customer_edit', compact(
            'guide',
            'services',
            'guideItems',
            'statuses'
        ));
    }

    public function updateGuideOrder(Request $request, Guide $guide)
    {
        // Validasi data berdasarkan model Guide
        $validatedData = $request->validate([
            'keterangan' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
        ]);

        // Update data guide
        $guide->update($validatedData);

        Session::flash('success', 'Order pendamping berhasil diperbarui.');

        return redirect()->route('pendamping.customer.show', $guide->service_id);
    }

    public function showSupplier($id)
    {
        $guide = Guide::findOrFail($id);

        return view('handling.pendamping.supplier_detail', compact('guide'));
    }
    public function createSupplier($id)
    {
        $guide = Guide::findOrFail($id);
        return view('handling.pendamping.supplier_create', compact('guide'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $guide = Guide::findOrFail($id);
        $guide->supplier = $request->input('name');
        $guide->harga_dasar = $request->input('price');
        $guide->save();
        return redirect()->route('pendamping.supplier.show', $id);
    }
}
