<?php

namespace App\Http\Controllers;

use App\Models\PriceListTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PriceListTicketController extends Controller
{
    /**
     * Menampilkan daftar harga tiket.
     */
    public function index()
    {
        $tickets = PriceListTicket::latest()
            ->paginate(15);

        return view('transportasi.pesawat.price-list.index', compact('tickets'));
    }

    /**
     * Menampilkan form tambah tiket.
     */
    public function create()
    {
        return view('transportasi.pesawat.price-list.create');
    }

    /**
     * Menyimpan data tiket baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_berangkat' => 'required',
            'kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        PriceListTicket::create($request->all());

        return redirect()->route('price.list.ticket')
            ->with('success', 'Data tiket berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit tiket.
     */
    public function edit(PriceListTicket $ticket)
    {
        return view('transportasi.pesawat.price-list.edit', compact('ticket'));
    }

    /**
     * Mengupdate data tiket.
     */
    public function update(Request $request, PriceListTicket $ticket)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_berangkat' => 'required',
            'kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $ticket->update($request->all());

        return redirect()->route('price.list.ticket')
            ->with('success', 'Data tiket berhasil diperbarui.');
    }

    /**
     * Menghapus data tiket.
     */
    public function destroy(PriceListTicket $ticket)
    {
        $ticket->delete();

        return redirect()->route('price.list.ticket')
            ->with('success', 'Data tiket berhasil dihapus.');
    }
}
