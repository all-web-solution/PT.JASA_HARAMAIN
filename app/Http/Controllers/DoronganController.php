<?php

namespace App\Http\Controllers;

use App\Models\DoronganOrder;
use Illuminate\Http\Request;
use App\Models\Dorongan;
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

    public function customer()
    {
        $AllData = DoronganOrder::with('dorongan')->get();
        $data = $AllData->unique('service_id');

        return view('palugada.dorongan.customer', compact('data'));
    }
    public function customer_detail($id)
    {
       $doronganOrders = DoronganOrder::with('dorongan', 'service.pelanggan')->findOrFail($id);
       return view('palugada.dorongan.customer_detail', compact('doronganOrders'));
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
