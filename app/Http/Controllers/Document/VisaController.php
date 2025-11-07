<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visa;

class VisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visas = Visa::all();
        return view('content.visa.index', compact('visas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.visa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Visa::create([
            'name' => $request->name,
            'price' => $request->price
        ]);
        return redirect()->route('content.visa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $visa = Visa::findOrFail($id);
        return view('content.visa.edit', ['visa' => $visa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visa = Visa::findOrFail($id);
        $visa->update(['name' => $request->name]);
        return redirect()->route('content.visa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $visa = Visa::findOrFail($id);
         $visa->delete();
         return redirect()->route('content.visa.index');
    }
}
