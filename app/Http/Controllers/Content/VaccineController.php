<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vaccine;

class VaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $vaccines = vaccine::all();
        return view('content.vaccine.index', compact('vaccines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.vaccine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        vaccine::create(['name' => $request->name]);
        return redirect()->route('content.vaccine.index');
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
        $vaccine = vaccine::findOrFail($id);
        return view('content.vaccine.edit', ['vaccine' => $vaccine]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vaccine = vaccine::findOrFail($id);
        $vaccine->update(['name' => $request->name]);
        return redirect()->route('content.vaccine.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $vaccine = vaccine::findOrFail($id);
         $vaccine->delete();
         return redirect()->route('content.vaccine.index');
    }
}
