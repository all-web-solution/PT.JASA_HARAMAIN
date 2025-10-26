<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\MealItem;
use App\Models\Service;

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

    public function show($id)
    {
        $meal = Meal::findOrFail($id);
        $service = Service::with('meals.mealItem')->findOrFail($meal->service_id);

        return view('handling.catering.show', compact('service'));
    }

    public function customer(Request $request)
    {
        $data = Meal::all();
        $customerMeal = $data->unique('service_id');

        return view('handling.catering.customer', compact('customerMeal'));
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
