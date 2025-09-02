<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Tour;
use App\Models\Transportation;
use App\Models\TransportationOrder;
use Dom\Document;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data nego → group per pelanggan
        $nego = Service::where('status', 'nego')
            ->selectRaw('MIN(id) as id,
                     pelanggan_id,
                     MIN(tanggal_keberangkatan) as tanggal_keberangkatan,
                     MIN(tanggal_kepulangan) as tanggal_kepulangan,
                     SUM(total_jamaah) as total_jamaah,
                     GROUP_CONCAT(services) as services,
                     MIN(unique_code) as unique_code,
                     status')
            ->groupBy('pelanggan_id', 'status')
            ->get();

        // Ambil semua data deal → tampilkan per service
        $deal = Service::where('status', 'deal')->get();

        // Gabungkan
        $services = $nego->merge($deal);

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
        // Tentukan file paspor & visa global
        $pasporGlobal = null;
        $visaGlobal = null;

        // 1. Transportasi dipilih
        if ($request->filled('transportation')) {
            $pasporGlobal = $request->file('paspor_transportasi')
                ? $request->file('paspor_transportasi')->store('paspor', 'public')
                : null;
            $visaGlobal = $request->file('visa_transportasi')
                ? $request->file('visa_transportasi')->store('visa', 'public')
                : null;
        }
        // 2. Transportasi tidak dipilih, hotel dipilih
        elseif ($request->filled('nama_hotel')) {
            $pasporGlobal = $request->file('paspor_hotel')
                ? $request->file('paspor_hotel')->store('hotel/paspor', 'public')
                : null;
            $visaGlobal = $request->file('visa_hotel')
                ? $request->file('visa_hotel')->store('hotel/visa', 'public')
                : null;
        }
        // 3. Tidak pilih keduanya → upload sendiri
        else {
            $pasporGlobal = $request->file('paspor')
                ? $request->file('paspor')->store('documents/paspor', 'public')
                : null;
            $visaGlobal = $request->file('visa')
                ? $request->file('visa')->store('documents/visa', 'public')
                : null;
        }
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        $status = $request->action === 'nego' ? 'nego' : 'deal';

        $prefixMap = [
            'hotel' => 'H',
            'transportasi' => 'T',
            'dokumen' => 'D',
            'handling' => 'HDL',
            'pendamping' => 'P',
            'konten' => 'K',
            'reyal' => 'R',
            'tour' => 'TO',
            'meals' => 'M',
            'dorongan' => 'DR',
            'wakaf' => 'W',
            'badal' => 'BD'
        ];

        foreach ($request->services as $srv) {
            $srvLower = strtolower($srv); // pastikan lowercase
            $prefix = $prefixMap[$srvLower] ?? 'S';

            // Ambil service terakhir berdasarkan prefix
            $lastService = Service::where('unique_code', 'like', $prefix . '-%')
                ->orderBy('id', 'desc')
                ->first();

            $lastNumber = $lastService ? (int) explode('-', $lastService->unique_code)[1] : 0;
            $uniqueCode = $prefix . '-' . ($lastNumber + 1);

            // Buat service
            $service = Service::create([
                'pelanggan_id' => $request->travel,
                'services' => [$srvLower],
                'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
                'tanggal_kepulangan' => $request->tanggal_kepulangan,
                'total_jamaah' => $request->total_jamaah,
                'status' => $status,
                'unique_code' => $uniqueCode,
            ]);

            // Relasi detail
            switch ($srvLower) {
                case 'hotel':

                    // Simpan hotel
                    if ($request->filled('tanggal_checkin')) {
                        foreach ($request->tanggal_checkin as $i => $tglCheckin) {
                            if ($tglCheckin) {
                                $hotel = $service->hotels()->create([
                                    'tanggal_checkin' => $tglCheckin,
                                    'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                                    'nama_hotel' => $request->nama_hotel[$i] ?? null,
                                    'harga_perkamar' => $request->harga_per_kamar[$i] ?? null,
                                    'catatan' => $request->catatan[$i] ?? null,
                                    
                                ]);

                                // Simpan tipe kamar per hotel
                                if (isset($request->tipe_kamar[$i])) {
                                    foreach ($request->tipe_kamar[$i] as $tipe) {
                                        if (!empty($tipe['nama']) && !empty($tipe['jumlah']) && $tipe['jumlah'] > 0) {
                                            $hotel->typeHotels()->create([
                                                'nama_tipe' => $tipe['nama'],
                                                'jumlah' => $tipe['jumlah'],
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;




                case 'transportasi':
                    if ($request->filled('transportation')) {
                        foreach ($request->transportation as $i => $tipe) {
                            $tipeLower = strtolower($tipe);

                            // === Pesawat ===
                            if ($tipeLower === 'airplane' && $request->filled('tanggal')) {
                                foreach ($request->tanggal as $j => $tgl) {
                                    if ($tgl) {
                                        $service->planes()->create([
                                            'tanggal_keberangkatan' => $tgl,
                                            'rute' => $request->rute[$j] ?? null,
                                            'maskapai' => $request->maskapai[$j] ?? null,
                                            'harga' => $request->harga[$j] ?? null,
                                            'keterangan' => $request->keterangan[$j] ?? null,

                                            // upload paspor & visa (global, bukan per tiket)
                                            'paspor' => $pasporGlobal,
                                            'visa' => $visaGlobal,

                                            // upload tiket per item (array)
                                            'tiket_berangkat' => isset($request->file('tiket_berangkat')[$j])
                                                ? $request->file('tiket_berangkat')[$j]->store('tiket') : null,
                                            'tiket_pulang' => isset($request->file('tiket_pulang')[$j])
                                                ? $request->file('tiket_pulang')[$j]->store('tiket') : null,
                                        ]);
                                    }
                                }
                            }



                            // === Transportasi Darat (Bus, Mobil dll) ===
                            if ($tipeLower === 'bus' && $request->filled('transportation_id')) {
                                foreach ((array)$request->transportation_id as $busId) {
                                    $service->transportationItem()->create([
                                        'transportation_id' => $busId,
                                        // tambahin upload file paspor & visa
                                        'paspor' => $request->file('paspor_transportasi')
                                            ? $request->file('paspor_transportasi')->store('paspor') : null,
                                        'visa' => $request->file('visa_transportasi')
                                            ? $request->file('visa_transportasi')->store('visa') : null,
                                    ]);
                                }
                            }
                        }
                    }
                    break;


                case 'handling':
                    if ($request->filled('handlings')) {
                        foreach ($request->handlings as $handling) {
                            $handlingModel = $service->handlings()->create([
                                'name' => $handling
                            ]);

                            switch (strtolower($handling)) {
                                // ================== HOTEL ==================
                                case 'hotel':
                                    if ($request->filled('nama_hotel_handling')) {
                                        $handlingModel->handlingHotels()->create([
                                            'nama'           => $request->nama_hotel_handling,
                                            'tanggal'        => $request->tanggal_hotel_handling,
                                            'harga'          => $request->harga_hotel_handling,
                                            'pax'            => $request->pax_hotel_handling,
                                            'kode_booking'   => $request->file('kode_booking_hotel_handling')
                                                ? $request->file('kode_booking_hotel_handling')->store('handling/hotel', 'public')
                                                : null,
                                            'rumlis'         => $request->file('rumlis_hotel_handling')
                                                ? $request->file('rumlis_hotel_handling')->store('handling/hotel', 'public')
                                                : null,
                                            'identitas_koper' => $request->file('identitas_hotel_handling')
                                                ? $request->file('identitas_hotel_handling')->store('handling/hotel', 'public')
                                                : null,
                                        ]);
                                    }
                                    break;

                                // ================== BANDARA ==================
                                case 'bandara':
                                    if ($request->filled('nama_bandara_handling')) {
                                        $handlingModel->handlingPlanes()->create([
                                            'nama_bandara'   => $request->nama_bandara_handling,
                                            'jumlah_jamaah'  => $request->jumlah_jamaah_handling,
                                            'harga'          => $request->harga_bandara_handling,
                                            'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                                            'paket_info'     => $request->file('paket_info')
                                                ? $request->file('paket_info')->store('handling/bandara', 'public')
                                                : null,
                                            'nama_supir'     => $request->nama_supir,
                                            'identitas_koper' => $request->file('identitas_koper_bandara_handling')
                                                ? $request->file('identitas_koper_bandara_handling')->store('handling/bandara', 'public')
                                                : null,
                                        ]);
                                    }
                                    break;
                            }
                        }
                    }
                    break;


                case 'meals':
                    if ($request->filled('meals')) {
                        foreach ($request->meals as $meal) {
                            $mealLower = strtolower($meal);
                            $jumlah = match ($mealLower) {
                                'nasi box' => $request->input('jumlah_nasi_box', 0),
                                'buffle hotel' => $request->input('jumlah_buffle_hotel', 0),
                                'snack' => $request->input('jumlah_snack', 0),
                                default => 0,
                            };

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
                            $guideLower = strtolower($guide);
                            [$jumlah, $keterangan] = match ($guideLower) {
                                'premium' => [$request->input('jumlah_premium'), $request->input('ket_premium')],
                                'standard' => [$request->input('jumlah_standard'), $request->input('ket_standard')],
                                'muthawifah' => [$request->input('jumlah_muthawifah'), $request->input('ket_muthawifah')],
                                'leader' => [$request->input('jumlah_leader'), $request->input('ket_leader')],
                                default => [0, null],
                            };

                            $service->guides()->create([
                                'nama' => $guide,
                                'jumlah' => $jumlah,
                                'keterangan' => $keterangan,
                            ]);
                        }
                    }
                    break;

                case 'tour':
                    if ($request->filled('tours')) {
                        foreach ($request->tours as $tour) {
                            $transportation = match (strtolower($tour)) {
                                'makkah' => $request->input('select_car_makkah', 0),
                                'madinah' => $request->input('select_car_madinah', 0),
                                'al ula' => $request->input('select_car_al_ula', 0),
                                'thoif' => $request->input('select_car_thoif', 0),
                                default => 0,
                            };

                            $service->tours()->create([
                                'transportation_id' => $transportation,
                                'name' => $tour,
                            ]);
                        }
                    }
                    break;

                case 'dokumen':
                    if ($request->filled('documents')) {
                        foreach ($request->documents as $doc) {

                            // Simpan file kalau ada
                            $pasFotoPath = $request->hasFile('pas_foto')
                                ? $request->file('pas_foto')->store('documents/pas_foto', 'public')
                                : null;

                            $ktpPath = $request->hasFile('ktp')
                                ? $request->file('ktp')->store('documents/ktp', 'public')
                                : null;

                            // Buat service document
                            $docService = $service->documents()->create([
                                'name'      => $doc,
                                'pas_foto'  => $pasFotoPath,
                                'paspor'    => $pasporGlobal,
                                'ktp'       => $ktpPath,
                            ]);

                            // === VISA ===
                            if ($doc === 'visa' && $request->filled('visa')) {
                                foreach ($request->visa as $visaType) {
                                    $docService->visaDetails()->create([
                                        'nama'       => $visaType,
                                        'jumlah'     => $request->input('jumlah_' . $visaType, 0),
                                        'harga'      => $request->input('harga_' . $visaType, 0),
                                        'keterangan' => $request->input('keterangan_' . $visaType, null),
                                    ]);
                                }
                            }

                            // === VAKSIN ===
                            if ($doc === 'vaksin' && $request->filled('vaksin')) {
                                foreach ($request->vaksin as $vaksinType) {
                                    $docService->vaksinDetails()->create([
                                        'nama'       => $vaksinType,
                                        'jumlah'     => $request->input('jumlah_' . $vaksinType, 0),
                                        'harga'      => $request->input('harga_' . $vaksinType, 0),
                                        'keterangan' => $request->input('keterangan_' . $vaksinType, null),
                                    ]);
                                }
                            }

                            // === SISKOPATUH ===
                            if ($doc === 'siskopatuh') {
                                $docService->sikopaturDetails()->create([
                                    'nama'       => 'siskopatuh',
                                    'jumlah'     => $request->input('jumlah_siskopatur'),
                                    'harga'      => $request->input('harga_siskopatur'),
                                    'keterangan' => $request->input('keterangan_siskopatur')
                                ]);
                            }
                        }
                    }
                    break;
            }
        }

        return redirect()->route('admin.services')
            ->with('success', 'Data service berhasil disimpan.');
    }






    public function nego($id)
    {
        $service = Service::findOrFail($id);

        // ambil semua services milik pelanggan_id yg sama
        $allServices = Service::where('pelanggan_id', $service->pelanggan_id)
            ->pluck('services') // ambil kolom services saja
            ->toArray();

        // decode JSON jika perlu, dan gabungkan semua
        $selectedServices = collect($allServices)
            ->map(function ($item) {
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->flatten()
            ->unique()
            ->toArray();
        $transportations = Transportation::all();
        return view('admin.services.nego', [
            'service' => $service,
            'selectedServices' => $selectedServices,
            'transportations' => $transportations
        ]);
    }

    public function updateNego(Request $request, $id)
    {
        $oldService = Service::findOrFail($id);
        $newStatus = $request->action === 'nego' ? 'nego' : 'deal';

        // ✅ Update semua service dari pelanggan ini, bukan cuma 1 baris
        Service::where('pelanggan_id', $oldService->pelanggan_id)
            ->update(['status' => $newStatus]);

        $prefixMap = [
            'hotel' => 'H',
            'transportasi' => 'T',
            'document' => 'D',
            'handling' => 'HDL',
            'pendamping' => 'P',
            'konten' => 'K',
            'reyal' => 'R',
            'tour' => 'TO',
            'meals' => 'M',
            'dorongan' => 'DR',
            'wakaf' => 'W',
            'badal' => 'BD'
        ];

        foreach ($request->services as $srv) {
            $prefix = $prefixMap[$srv] ?? 'S';

            // Ambil nomor terakhir dari DB
            $lastService = Service::where('unique_code', 'like', $prefix . '-%')
                ->orderBy('id', 'desc')
                ->first();

            $number = $lastService ? ((int) explode('-', $lastService->unique_code)[1] + 1) : 1;
            $uniqueCode = $prefix . '-' . $number;

            // Jika status berubah menjadi deal atau service baru → buat baris baru
            Service::create([
                'pelanggan_id' => $request->travel,
                'services' => [$srv],
                'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
                'tanggal_kepulangan' => $request->tanggal_kepulangan,
                'total_jamaah' => $request->total_jamaah,
                'status' => $newStatus,
                'unique_code' => $uniqueCode,
            ]);
        }

        return redirect()->route('admin.services')
            ->with('success', 'Data nego berhasil diperbarui.');
    }
}
