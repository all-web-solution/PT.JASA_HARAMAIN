<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\Handling;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HandlingController extends Controller
{
    public function index()
    {
        $planes = HandlingPlanes::with(['handling.service.pelanggan'])->get();

        return view('handling.handling.index', compact('planes'));
    }


    //Function handling hotel
    public function hotel()
    {
        $hotels = HandlingHotel::with('handling.service.pelanggan')
            ->latest()
            ->paginate(10);

        $hotels->load('handling.service.pelanggan');

        return view('handling.handling.hotel', compact('hotels'));
    }
    public function showCustomerHotel($id)
    {
        $hotel = HandlingHotel::with('handling.service.pelanggan')->findOrFail($id);

        return view('handling.handling.hotel.show', compact('hotel'));
    }

    public function editCustomerHotel(HandlingHotel $hotel)
    {
        // $hotel adalah instance HandlingHotel yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $handlings = HandlingHotel::with('handling.service.pelanggan')->get();

        // Asumsi status (jika tidak ada di model, Anda bisa hardcode)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('handling.handling.hotel.edit', compact(
            'hotel',
            'handlings',
            'statuses'
        ));
    }

    public function updateCustomerHotel(Request $request, HandlingHotel $hotel)
    {
        // Validasi data berdasarkan model
        $validatedData = $request->validate([
            'pax' => 'required|min:0',
            'status' => 'required|string', // Sesuaikan aturan validasi status
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
            'kode_booking' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file
            'rumlis' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'identitas_koper' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // --- Penanganan File Upload ---

        // 1. Handle Kode Booking
        if ($request->hasFile('kode_booking')) {
            // Hapus file lama jika ada
            if ($hotel->kode_booking) {
                Storage::disk('public')->delete($hotel->kode_booking);
            }
            // Simpan file baru
            $validatedData['kode_booking'] = $request->file('kode_booking')->store('handling_hotels/kode_booking', 'public');
        }

        // 2. Handle Rumlis
        if ($request->hasFile('rumlis')) {
            if ($hotel->rumlis) {
                Storage::disk('public')->delete($hotel->rumlis);
            }
            $validatedData['rumlis'] = $request->file('rumlis')->store('handling_hotels/rumlis', 'public');
        }

        // 3. Handle Identitas Koper
        if ($request->hasFile('identitas_koper')) {
            if ($hotel->identitas_koper) {
                Storage::disk('public')->delete($hotel->identitas_koper);
            }
            $validatedData['identitas_koper'] = $request->file('identitas_koper')->store('handling_hotels/identitas_koper', 'public');
        }

        // --- Update data ---
        $hotel->update($validatedData);

        // Redirect kembali ke halaman detail
        return redirect()->route('handling.handling.hotel.show', $hotel->id) // Asumsi 'handling.hotel.show' adalah route detail
                         ->with('success', 'Data handling hotel berhasil diperbarui!');
    }

    public function plane($id)
    {
        $plane = HandlingPlanes::with('handling.service.pelanggan')->findOrFail($id);

        return view('handling.handling.plane.show', compact('plane'));
    }

    public function editCustomerPlane(HandlingPlanes $plane)
    {
        // $plane adalah instance HandlingPlanes yang ingin diedit
        // (Otomatis ditemukan oleh Route Model Binding)

        // Ambil data untuk dropdowns
        $handlings = Handling::with('service.pelanggan')->get();

        // Asumsi status (jika tidak ada di model, Anda bisa hardcode)
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('handling.handling.plane.edit', compact(
            'plane',      // Mengirim data dengan nama $plane
            'handlings',
            'statuses'
        ));
    }

    public function updateCustomerPlane(Request $request, HandlingPlanes $plane)
    {
        // Validasi data berdasarkan model
        $validatedData = $request->validate([
            'nama_supir' => 'nullable|string|max:255',
            'status' => 'required|string', // Sesuaikan aturan validasi status
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
            'paket_info' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file
            'identitas_koper' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // --- Penanganan File Upload ---

        // 1. Handle Paket Info
        if ($request->hasFile('paket_info')) {
            // Hapus file lama jika ada
            if ($plane->paket_info) {
                Storage::disk('public')->delete($plane->paket_info);
            }
            // Simpan file baru
            $validatedData['paket_info'] = $request->file('paket_info')->store('handling_planes/paket_info', 'public');
        }

        // 2. Handle Identitas Koper
        if ($request->hasFile('identitas_koper')) {
            if ($plane->identitas_koper) {
                Storage::disk('public')->delete($plane->identitas_koper);
            }
            $validatedData['identitas_koper'] = $request->file('identitas_koper')->store('handling_planes/identitas_koper', 'public');
        }

        // --- Update data ---
        $plane->update($validatedData);

        // Redirect kembali ke halaman detail
        return redirect()->route('handling.handling.plane.show', $plane->id) // Asumsi 'handling.pesawat.show' adalah route detail
                         ->with('success', 'Data handling pesawat berhasil diperbarui!');
    }

}
