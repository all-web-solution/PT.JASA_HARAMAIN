<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|between:1,12',
            'tahun' => 'nullable|integer|digits:4',
            'tanggal' => 'nullable|date',
        ]);

        $query = Pelanggan::query();
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $totalPelanggan = Pelanggan::count();
        $pelangganAktif = Pelanggan::where('status', 'active')->count();
        $pelangganNonAktif = Pelanggan::where('status', 'inactive')->count();
        $pelangganBulanIni = Pelanggan::whereMonth('created_at', now()->month)->count();

        $persenAktif = $totalPelanggan > 0 ? round(($pelangganAktif / $totalPelanggan) * 100) : 0;
        $persenNonAktif = $totalPelanggan > 0 ? round(($pelangganNonAktif / $totalPelanggan) * 100) : 0;

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
        $validated = $request->validate([
            'nama_travel' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:pelanggans,email',
            'penanggung_jawab' => 'required|string|max:100',
            'no_ktp' => 'required|string',
            'phone' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ]);

        $path = null;
        if ($request->hasFile('foto')) {

            $path = $request->file('foto')->store('pelanggan-foto', 'public');
        }

        Pelanggan::create([
            'nama_travel' => $validated['nama_travel'],
            'email' => $validated['email'],
            'penanggung_jawab' => $validated['penanggung_jawab'],
            'no_ktp' => $validated['no_ktp'],
            'phone' => $validated['phone'],
            'alamat' => $validated['alamat'],
            'foto' => $path,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.pelanggan')->with('success', 'Travel berhasil ditambahkan');
    }

    public function show(Pelanggan $pelanggan)
    {

        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {

        return view('admin.pelanggan.edit', compact('pelanggan'));
    }


    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_travel' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('pelanggans')->ignore($pelanggan->id),
            ],
            'penanggung_jawab' => 'required|string|max:100',
            'no_ktp' => [
                'required',
                'string',
                Rule::unique('pelanggans')->ignore($pelanggan->id),
            ],
            'phone' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ]);

        $updateData = $validated;

        if ($request->hasFile('foto')) {

            if ($pelanggan->foto) {
                Storage::disk('public')->delete($pelanggan->foto);
            }

            $updateData['foto'] = $request->file('foto')->store('pelanggan-foto', 'public');
        }


        $pelanggan->update($updateData);

        return redirect()->route('admin.pelanggan')
            ->with('success', 'Pelanggan berhasil diperbarui');
    }

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
