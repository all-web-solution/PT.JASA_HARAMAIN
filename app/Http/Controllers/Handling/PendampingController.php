<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;

class PendampingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $guides = Guide::all();
        return view('handling.pendamping.index',  compact('guides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('handling.pendamping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       Guide::create([
        'pendamping_type' => $request->name,
        'harga' => $request->description]);

        return redirect()->route('handling.pendamping.index');
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
        $guide = Guide::findOrFail($id);
        return view('handling.pendamping.edit', compact('guide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guide = Guide::findOrFail($id);
        $guide->update([
            'pendamping_type' => $request->name,
            'harga' => $request->description
        ]);
        return redirect()->route('handling.pendamping.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guide = Guide::findOrFail($id);
        $guide->delete();
        return redirect()->route('handling.pendamping.index');

    }
}
