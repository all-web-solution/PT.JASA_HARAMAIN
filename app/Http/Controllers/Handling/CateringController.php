<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catering;
use App\Models\cateringItem;

class CateringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cateringItems = cateringItem::all();
        return view('handling.catering.index', compact('cateringItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('handling.catering.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        cateringItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return redirect()->route('catering.index')->with('success', 'Data catering berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    $catering = cateringItem::findOrFail($id);
    return view('handling.catering.show', compact('catering'));
}

public function edit(string $id)
{
    $catering = cateringItem::findOrFail($id);
    return view('handling.catering.edit', compact('catering'));
}

public function update(Request $request, $id)
{
    $catering = cateringItem::findOrFail($id);

    $catering->update([
       'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price
    ]);

    return redirect()->route('catering.index')->with('success', 'Data catering berhasil diperbarui.');
}

public function destroy(string $id)
{
    $catering = cateringItem::findOrFail($id);
    $catering->delete();

    return redirect()->route('catering.index')->with('success', 'Data catering berhasil dihapus.');
}

}
