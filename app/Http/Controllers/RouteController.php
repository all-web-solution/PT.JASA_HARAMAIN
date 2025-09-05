<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Models\Route;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $transportation = Transportation::findOrFail($id);
        return view('transportasi.route.create', compact('transportation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $tranportationStore = Transportation::findOrFail($id);
        $tranportationStore->routes()->create([
            'transportation_id' => $tranportationStore->id,
            'route' => $request->nama,
            'price' => $request->harga
        ]);

        return redirect()->route('transportation.car.detail', $tranportationStore);

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
         $route = Route::findOrFail($id);
        return view('transportasi.route.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tranportationStore = Transportation::findOrFail($id);
         $route = Route::findOrFail($id);
         $route->update([
            'transportation_id' => $tranportationStore->id,
            'route' => $request->nama,
            'price' => $request->harga
         ]);
          return redirect()->route('transportation.car.detail', $tranportationStore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $tranportationStore = Transportation::findOrFail($id);
         $route = Route::findOrFail($id);
         $route->delete();
           return redirect()->route('transportation.car.detail', $tranportationStore);
    }
}
