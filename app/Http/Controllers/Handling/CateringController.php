<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\MealItem;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class CateringController extends Controller
{
    public function index()
    {
        $meals = MealItem::all();
        return view('handling.catering.index', compact('meals'));
    }
    public function create()
    {
        $services = Service::all();
        return view('handling.catering.create', compact('services'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'service_id' => 'required|exists:services,id',
            'pj' => 'nullable|string|max:255',
            'kebutuhan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'status' => 'nullable|in:proses,cancel,selesai',
        ]);

        $mealItem = MealItem::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        Meal::create([
            'service_id' => $request->service_id,
            'meal_id' => $mealItem->id,
            'pj' => $request->pj,
            'kebutuhan' => $request->kebutuhan ?? '-',
            'jumlah' => $request->jumlah,
            'status' => $request->status ?? 'proses',
        ]);

        return redirect()->route('catering.index')->with('success', 'Menu makanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $meal = MealItem::findOrFail($id);
        return view('handling.catering.edit', compact('meal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $meal = MealItem::findOrFail($id);

        $meal->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('catering.index')->with('success', 'Menu makanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meal = MealItem::findOrFail($id);
        $meal->delete();

        return redirect()->route('catering.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function customer(Request $request)
    {
        $meals = Meal::with([
                        'service.pelanggan', // Untuk mengambil Nama Travel
                        'mealItem'           // Untuk mengambil Nama Makanan
                    ])
                    ->latest() // Urutkan berdasarkan yang terbaru
                    ->paginate(10);

        return view('handling.catering.customer', compact('meals'));
    }

    public function showCustomer(Meal $meal)
    {
        // $meal otomatis ditemukan oleh Laravel (Route Model Binding)

        // Load relasi yang dibutuhkan oleh view
        $meal->load('service.pelanggan', 'mealItem');

        // Asumsi nama view Anda adalah 'makanan.show'
        return view('handling.catering.customer_detail', [
            'meal' => $meal // Mengirim variabel $meal
        ]);
    }

    public function editCustomer(Meal $meal)
    {
        // $meal adalah instance Meal yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $mealItems = MealItem::all(); // Ambil master data makanan

        // Asumsi status (sesuai model lain)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('handling.catering.customer_edit', compact(
            'meal',
            'services',
            'mealItems',
            'statuses'
        ));
    }

    public function updateCustomer(Request $request, Meal $meal)
    {
        // Validasi data berdasarkan model Meal
        $validatedData = $request->validate([
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data meal
        $meal->update($validatedData);

        Session::flash('success', 'Order makanan berhasil diperbarui.');

        // Redirect kembali ke halaman detail
        return redirect()->route('catering.customer.show', $meal->id); // Asumsi 'makanan.show' adalah route detail
    }


    public function showSupplier($id)
    {
        $guide = Meal::findOrFail($id);
        return view('handling.catering.supplier_detail', compact('guide'));
    }
    public function createSupplier($id)
    {
        $guide = Meal::findOrFail($id);
        return view('handling.catering.supplier_create', compact('guide'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $guide = Meal::findOrFail($id);
        $guide->supplier = $request->input('name');
        $guide->harga_dasar = $request->input('price');
        $guide->save();
        return redirect()->route('catering.supplier.show', $id);
    }
}
