<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siskopatuh;

class SiskopaturController extends Controller
{
     public function index()
    {
        $siskopatuhs = siskopatuh::all();
        return view('content.siskopatuh.index', compact('siskopatuhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.siskopatuh.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        siskopatuh::create(['number' => $request->name, 'price' => $request->price]);
        return redirect()->route('content.siskopatur.index');
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
        $siskopatuh = siskopatuh::findOrFail($id);
        return view('content.siskopatuh.edit', ['siskopatuh' => $siskopatuh]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siskopatuh = siskopatuh::findOrFail($id);
        $siskopatuh->update(['number' => $request->name, 'price' => $request->price]);
        return redirect()->route('content.siskopatur.index',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $siskopatuh = siskopatuh::findOrFail($id);
         $siskopatuh->delete();
         return redirect()->route('content.siskopatur.index');
    }
}
