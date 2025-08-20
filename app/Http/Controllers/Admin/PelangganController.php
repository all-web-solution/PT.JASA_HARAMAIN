<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $pelangganAktif = Pelanggan::where('status', 'active')->count();
        $pelangganNonAktif = Pelanggan::where('status', 'inactive')->count();
        $pelangganBulanIni = Pelanggan::whereMonth('created_at', now()->month)->count();

        // Hitung persentase dengan pengecekan zero division
        $persenAktif = $totalPelanggan > 0 ? round(($pelangganAktif / $totalPelanggan) * 100) : 0;
        $persenNonAktif = $totalPelanggan > 0 ? round(($pelangganNonAktif / $totalPelanggan) * 100) : 0;

        $pelanggans = Pelanggan::latest()->paginate(5);

        return view('admin.pelanggan.index', compact(
            'totalPelanggan',
            'pelangganAktif',
            'pelangganNonAktif',
            'pelangganBulanIni',
            'persenAktif',
            'persenNonAktif',
            'pelanggans'
        ));
    }
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_travel' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'penanggung_jawab' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pelanggans', 'public');
        }

        Pelanggan::create($validated);

        return redirect()->route('admin.pelanggan')->with('success', 'Travel berhasil ditambahkan');
    }
    public function show(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_travel' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'penanggung_jawab' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'no_ktp' => 'required|string|unique:pelanggans,no_ktp,' . $pelanggan->id,
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pelanggan->foto) {
                Storage::disk('public')->delete($pelanggan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pelanggans', 'public');
        }

        $pelanggan->update($data);

        return redirect()->route('admin.pelanggans.index')
            ->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->foto) {
            Storage::disk('public')->delete($pelanggan->foto);
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggans.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
