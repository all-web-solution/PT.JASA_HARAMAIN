<?php

namespace App\Http\Controllers;

use App\Models\Wakaf;
use App\Models\WakafCustomer;
use Illuminate\Http\Request;

class WakafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wakaf = Wakaf::all();
        return view('palugada.wakaf.index', compact('wakaf'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('palugada.wakaf.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Wakaf::create([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);
        return redirect()->route('wakaf.index');
;    }

    /**
     * Display the specified resource.
     */
    public function customer()
    {
        $data = WakafCustomer::all();
        return view('palugada.wakaf.customer', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wakaf = Wakaf::findOrFail($id);
        return view('palugada.wakaf.edit', compact('wakaf'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $wakaf = Wakaf::findOrFail($id);
        $wakaf->update([
              'nama' => $request->nama,
            'harga' => $request->harga
        ]);
        return redirect()->route('wakaf.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wakaf = Wakaf::findOrFail($id);
        $wakaf->delete();
         return redirect()->route('wakaf.index');
    }
}
