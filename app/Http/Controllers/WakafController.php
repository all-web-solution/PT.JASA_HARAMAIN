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

    public function customer()
    {

        $AllData = WakafCustomer::with('wakaf')->get();

        $data = $AllData->unique('service_id');

        return view('palugada.wakaf.customer', compact('data'));
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
    public function customer_detail($id)
    {
        $wakafCustomers = WakafCustomer::with('service.pelanggan')->findOrFail($id);
        return view('palugada.wakaf.customer_detail', compact('wakafCustomers'));
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
