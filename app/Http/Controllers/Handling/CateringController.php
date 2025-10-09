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
        $meals = Meal::with(['mealItem', 'service.pendamping', 'service.pelanggan'])->get();
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
        $meal = Meal::findOrFail($id);
        $services = Service::all();
        return view('handling.catering.edit', compact('meal', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'pj' => 'nullable|string|max:255',
            'kebutuhan' => 'nullable|string',
            'status' => 'nullable|in:proses,cancel,selesai',
        ]);

        $meal = Meal::findOrFail($id);

        $meal->update([
            'jumlah' => $request->jumlah,
            'pj' => $request->pj,
            'kebutuhan' => $request->kebutuhan ?? '-',
            'status' => $request->status ?? 'proses',
        ]);

        return redirect()->route('catering.index')->with('success', 'Menu makanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();

        return redirect()->route('catering.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function show($id)
    {
        $meal = Meal::with(['mealItem', 'service.pendamping', 'service.pelanggan'])->findOrFail($id);

        return view('handling.catering.show', compact('meal'));
    }

    public function customer(Request $request)
    {
        $query = Meal::with(['mealItem', 'service.pelanggan']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $customerMeal = $query->get()->map(function ($meal) {
            $meal->total_price = $meal->mealItem->price * $meal->jumlah;
            return $meal;
        });

        return view('handling.catering.customer', compact('customerMeal'));
    }
}
