<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Transportation;
use App\Models\TransportationOrder;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::with('pelanggan')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $transportations = Transportation::all();
        return view('admin.services.create', compact('pelanggans', 'transportations'));
    }

    public function show($id)
    {
        $service = Service::with(['pelanggan'])->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        $service = Service::create([
            'pelanggan_id' => $request->travel,
            'services' => $request->services, // Laravel auto handle json
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
        ]);

        $updateData = [];

        foreach ($request->services as $srv) {
            switch ($srv) {
                case 'hotel':
                    foreach ($request->tanggal_checkin as $i => $tglCheckin) {
                        if (!empty($tglCheckin)) {
                            $service->hotels()->create([
                                'tanggal_checkin'   => $tglCheckin,
                                'tanggal_checkout'  => $request->tanggal_checkout[$i] ?? null,
                                'nama_hotel'        => $request->nama_hotel[$i] ?? null,
                                'tipe_kamar'        => $request->tipe_kamar[$i] ?? null,
                                'jumlah_kamar'      => $request->jumlah_kamar[$i] ?? null,
                                'harga_perkamar'    => $request->harga_per_kamar[$i] ?? null,
                                'catatan'           => $request->catatan[$i] ?? null,
                            ]);
                        }
                    }
                    break;

                case 'transportasi':
                    if ($request->transportation) {
                        foreach ($request->transportation as $tipe) {
                            if ($tipe === 'airplane') {
                                foreach ($request->tanggal as $i => $tgl) {
                                    if (!empty($tgl)) {
                                        $service->planes()->create([
                                            'tanggal_keberangkatan' => $tgl,
                                            'rute' => $request->rute[$i] ?? null,
                                            'maskapai' => $request->maskapai[$i] ?? null,
                                            'harga' => $request->harga[$i] ?? null,
                                            'keterangan' => $request->keterangan[$i] ?? null,
                                        ]);
                                    }
                                }
                            }

                            if ($tipe === 'bus' && $request->filled('transportation_id')) {
                                $service->transportationItem()->create([
                                    'transportation_id' => $request->transportation_id,
                                ]);
                            }
                        }
                    }
                    break;

                case 'handling':
                    if ($request->filled('handlings')) {
                        foreach ($request->handlings as $handling) {
                            $habdlingModel = $service->handlings()->create([
                                'name' => $handling
                            ]);

                            switch ($handling) {
                                case 'hotel':
                                    if ($request->filled('nama_hotel_handling')) {
                                        $habdlingModel->handlingHotels()->create([
                                            'nama'    => $request->nama_hotel_handling,
                                            'tanggal' => $request->tanggal_hotel_handling,
                                            'harga'   => $request->harga_hotel_handling,
                                            'pax'     => $request->pax_hotel_handling,
                                        ]);
                                    }
                                    break;
                                case 'bandara':
                                    if ($request->filled('nama_bandara_handling')) {
                                        // $handlingModel->handlingPlanes()->create([
                                        //    'nama_bandara' => $request->nama_bandara_handling,
                                        //    'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                                        //    'harga' => $request->harga_bandara_handling,
                                        //    'kedatangan_jamaah' => $request->kedatangan_jamaah_handling
                                        // ]);
                                        $habdlingModel->handlingPlanes()->create([
                                            'nama_bandara' => $request->nama_bandara_handling,
                                            'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                                            'harga' => $request->harga_bandara_handling,
                                            'kedatangan_jamaah' => $request->kedatangan_jamaah_handling
                                        ]);
                                    }
                            }
                        }
                    }
                    break;
                case 'meals':
                    if ($request->filled('meals')) {
                        foreach ($request->meals as $meal) {
                            // Tentukan nama input jumlah sesuai meal
                            switch (strtolower($meal)) {
                                case 'nasi box':
                                    $jumlah = $request->input('jumlah_nasi_box', 0);
                                    break;
                                case 'buffle hotel':
                                    $jumlah = $request->input('jumlah_buffle_hotel', 0);
                                    break;
                                case 'snack':
                                    $jumlah = $request->input('jumlah_snack', 0);
                                    break;
                                default:
                                    $jumlah = 0;
                            }

                            $service->meals()->create([
                                'nama' => $meal,
                                'jumlah' => $jumlah,
                            ]);
                        }
                    }
                    break;
                case 'pendamping':
                    if ($request->filled('pendamping')) {
                        foreach ($request->pendamping as $guide) {
                            switch (strtolower($guide)) {
                                case 'premium':
                                    $jumlah = $request->input('jumlah_premium');
                                    $keterangan = $request->input('ket_premium');
                                    break;
                                case 'standard':
                                    $jumlah = $request->input('jumlah_standard');
                                    $keterangan = $request->input('ket_standard');
                                    break;
                                case 'muthawifah':
                                    $jumlah = $request->input('jumlah_muthwifah');
                                    $keterangan = $request->input('ket_muthwifah');
                                    break;
                                case 'leader':
                                    $jumlah = $request->input('jumlah_leader');
                                    $keterangan = $request->input('ket_leader');
                                    break;
                            }

                            $service->guides()->create([
                                'nama' => $guide,
                                'jumlah' => $jumlah,
                                'keterangan' => $keterangan
                            ]);
                        }
                    }
                case 'tour':
                    if ($request->filled('tours')) {
                        foreach ($request->tours as $tour) {
                            $transportation = 0;

                            switch (strtolower($tour)) {
                                case 'makkah':
                                    $transportation = $request->input('select_car_makkah', 0);
                                    break;
                                case 'madinah':
                                    $transportation = $request->input('select_car_madinah', 0);
                                    break;
                                case 'al ula':
                                    $transportation = $request->input('select_car_al_ula', 0);
                                    break;
                                case 'thoif':
                                    $transportation = $request->input('select_car_thoif', 0);
                                    break;
                                default:
                                    $transportation = 0;
                                    break;
                            }

                            $service->tours()->create([
                                'transportation_id' => $transportation,
                                'name'              => $tour,
                            ]);
                        }
                    }
                    break;
            }
        }

        if (!empty($updateData)) {
            $service->update($updateData);
        }

        return redirect()->route('admin.services');
    }



    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view('admin.services.edit', compact('service', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Service berhasil diperbarui');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service berhasil dihapus');
    }
}
