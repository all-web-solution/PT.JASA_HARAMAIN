<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

    // Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('created_at', $request->bulan);
    }

    // Filter berdasarkan tahun
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    // Filter berdasarkan tanggal spesifik
    if ($request->filled('tanggal')) {
        $query->whereDate('created_at', $request->tanggal);
    }

        $totalPelanggan = Pelanggan::count();
        $pelangganAktif = Pelanggan::where('status', 'active')->count();
        $pelangganNonAktif = Pelanggan::where('status', 'inactive')->count();
        $pelangganBulanIni = Pelanggan::whereMonth('created_at', now()->month)->count();

        // Hitung persentase dengan pengecekan zero division
        $persenAktif = $totalPelanggan > 0 ? round(($pelangganAktif / $totalPelanggan) * 100) : 0;
        $persenNonAktif = $totalPelanggan > 0 ? round(($pelangganNonAktif / $totalPelanggan) * 100) : 0;

        $bulan = request()->get('bulan');
        $tahun = request()->get('tahun');

        $pelanggans = $query->latest()->paginate(10);

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


        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('/', 'public');
        }

        Pelanggan::create([
            'nama_travel' => $request->nama_travel,
            'email' => $request->email,
            'penanggung_jawab' => $request->penanggung_jawab,
            'no_ktp' => $request->no_ktp,
            'phone' => $request->phone,
            'alamat' =>$request->alamat,
            'foto' => $path,
            'status' => $request->status,
        ]);

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
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('/', 'public');
    } else {
        $path = $pelanggan->foto; // pakai foto lama kalau tidak upload baru
    }

    $pelanggan->update([
        'nama_travel' => $request->nama_travel,
        'email' => $request->email,
        'penanggung_jawab' => $request->penanggung_jawab,
        'no_ktp' => $request->no_ktp,
        'phone' => $request->phone,
        'alamat' => $request->alamat,
        'foto' => $path,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.pelanggan')
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

        return redirect()->route('admin.pelanggan')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
