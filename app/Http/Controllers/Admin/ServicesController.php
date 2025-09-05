<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\GuideItems;
use App\Models\Hotel;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Tour;
use App\Models\Transportation;
use App\Models\TransportationOrder;
use Dom\Document;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\TourItem;
use App\Models\MealItem;

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
        $guides = GuideItems::all();
        $tours = TourItem::all();
        $meals = MealItem::all();
        return view('admin.services.create', compact('pelanggans', 'transportations', 'guides', 'tours', 'meals'));
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
                    if ($request->filled('nama_hotel')) {
                        foreach ($request->nama_hotel as $i => $namaHotel) {
                            if ($namaHotel) {
                                $hotel = $service->hotels()->create([
                                    'nama_hotel'       => $namaHotel,
                                    'tanggal_checkin'  => $request->tanggal_checkin[$i] ?? null,
                                    'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                                    'harga_perkamar'   => $request->harga_per_kamar[$i] ?? 0,
                                    'jumlah_kamar'     => $request->jumlah_kamar[$i] ?? 0,
                                    'catatan'          => $request->catatan[$i] ?? null,
                                ]);

                                // Ambil tipe kamar
                                $tipeKamar   = $request->tipe_kamar[$i]['nama']   ?? [];
                                $jumlahKamar = $request->tipe_kamar[$i]['jumlah'] ?? [];

                                $typeHotelsData = [];
                                foreach ($tipeKamar as $j => $namaTipe) {
                                    $jumlah = $jumlahKamar[$j] ?? 0;
                                    if (!empty($namaTipe) && (int)$jumlah > 0) {
                                        $typeHotelsData[] = [
                                            'nama_tipe' => (string) $namaTipe,
                                            'jumlah'    => (int) $jumlah,
                                        ];
                                    }
                                }

                                if (!empty($typeHotelsData)) {
                                    $hotel->typeHotels()->createMany($typeHotelsData);
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
                                foreach ((array)$request->transportation_id as $index => $busId) {
                                    $service->transportationItem()->create([
                                        'transportation_id' => $busId,
                                        'route_id'          => $request->rute_id[$index] ?? null, // simpan juga route kalau ada
                                    ]);
                                }

                                foreach($request->rute_id as $rute){
                                    foreach($request->transportation_id as $index => $i){
                                        $service->transportationItem()->create([
                                            'transportation_id' => $i,
                                            'route_id'          => $rute ?? 0 // simpan juga route kalau ada
                                        ]);
                                    }
                                };

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
        foreach ($request->meals as $mealId) {
            $jumlah = $request->input("jumlah_meals.$mealId", 0);

            $service->meals()->create([
                'meal_id' => $mealId,
                'jumlah'  => $jumlah,
            ]);
        }
    }
    break;

                case 'pendamping':
                    if ($request->filled('pendamping')) {
                        foreach ($request->pendamping as $guideId) {
                            $jumlah = $request->input("jumlah_$guideId");
                            $keterangan = $request->input("ket_$guideId");

                            $service->guides()->create([
                                'guide_id'   => $guideId,
                                'jumlah'     => $jumlah,
                                'keterangan' => $keterangan,
                            ]);
                        }
                    }
                    break;

                case 'tour':
                    if ($request->filled('tours')) {
                        foreach ($request->tours as $tourId) {
                            $tour = \App\Models\TourItem::find($tourId);

                            if (!$tour) continue;

                            $slug = strtolower(str_replace(' ', '-', $tour->name));
                            $transportation = $request->input('select_car_' . $slug, 0);

                            $service->tours()->create([
                                'tour_id' => $tour->id,
                                'transportation_id' => $transportation,
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




        // 4. Buat order
        $order = Order::create([
            'service_id' => $service->id,
            'total_amount' => $request->input('total_amount', 0), // ambil dari input hidden
            'invoice' => 'INV-' . time(),
            'total_yang_dibayarkan' => $request->input('total_amount', 0),
            'sisa_hutang' => $request->input('total_amount'),
        ]);


        return redirect()->route('service.uploadBerkas', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah
        ])
            ->with('success', 'Data service berhasil disimpan.');
    }



    public function uploadBerkas(Request $request, $service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.upload_berkas', [
            'service_id' => $service->id,
            'total_jamaah' => $service->total_jamaah
        ]);
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

    public function storeBerkas(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($request->service_id);

        $pasFotoFiles = $request->file('pas_foto', []);
        $pasporFiles  = $request->file('paspor', []);
        $ktpFiles     = $request->file('ktp', []);
        $visaFiles    = $request->file('visa', []);

        $totalJamaah = count($pasFotoFiles);

        for ($i = 0; $i < $totalJamaah; $i++) {
            $service->filess()->create([
                'pas_foto' => isset($pasFotoFiles[$i]) ? $pasFotoFiles[$i]->store('documents/pas_foto', 'public') : null,
                'paspor'   => isset($pasporFiles[$i]) ? $pasporFiles[$i]->store('documents/paspor', 'public') : null,
                'ktp'      => isset($ktpFiles[$i]) ? $ktpFiles[$i]->store('documents/ktp', 'public') : null,
                'visa'     => isset($visaFiles[$i]) ? $visaFiles[$i]->store('documents/visa', 'public') : null,
            ]);
        }

        return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');
    }
    public function showFile()
    {
        $files = File::all();
        return view('admin.services.show_file', ['files' => $files]);
    }

    public function bayar(Order $order)
    {
        $order->load('service.meals'); // load relasi sesuai kebutuhan
        return view('admin.order.bayar', compact('order'));
    }

    // public function payment(Request $request, Order $order)
    // {
    //     $request->validate([
    //         'jumlah_dibayarkan' => 'required|numeric|min:1',
    //     ]);

    //     $jumlahBayar = (int) $request->jumlah_dibayarkan;

    //     // Hitung sisa hutang
    //     $sisaHutang = $order->total_amount - $jumlahBayar;
    //     if ($sisaHutang < 0) {
    //         $sisaHutang = 0;
    //     }

    //     // Ambil invoice terakhir untuk service ini
    //     $lastOrder = Order::where('service_id', $order->service_id)
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     $lastNumber = 0;
    //     if ($lastOrder && $lastOrder->invoice) {
    //         $parts = explode('-', $lastOrder->invoice);
    //         $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
    //     }
    //     $newInvoiceCode = 'INV-' . ($lastNumber + 1);

    //     $order->total_yang_dibayarkan += $jumlahBayar;
    //     $order->sisa_hutang = $order->total_amount - $order->total_yang_dibayarkan;
    //     $order->save();

    //     // Buat order baru untuk pembayaran ini
    //     Order::create([
    //         'service_id' => $order->service_id,
    //         'total_amount' => $sisaHutang,          // total amount = sisa hutang
    //         'total_yang_dibayarkan' => $jumlahBayar,
    //         'sisa_hutang' => $sisaHutang,
    //         'invoice' => $newInvoiceCode,
    //     ]);

    //     return redirect()->route('orders.bayar', $order->id)
    //         ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format($sisaHutang, 0, ',', '.'));
    // }

//     public function payment(Request $request, Order $order)
// {
//     $request->validate([
//         'jumlah_dibayarkan' => 'required|numeric|min:1',
//     ]);

//     $jumlahBayar = (int) $request->jumlah_dibayarkan;

//     // Ambil order pertama untuk service ini (master record)
//     $firstOrder = Order::where('service_id', $order->service_id)
//         ->orderBy('id', 'asc')
//         ->first();

//     if (!$firstOrder) {
//         return back()->with('error', 'Order utama tidak ditemukan.');
//     }

//     // Hitung sisa hutang dari row pertama
//     $sisaHutang = $firstOrder->sisa_hutang - $jumlahBayar;
//     if ($sisaHutang < 0) {
//         $sisaHutang = 0;
//     }

//     // Update row pertama (master record)
//     $firstOrder->total_yang_dibayarkan += $jumlahBayar;
//     $firstOrder->sisa_hutang = $sisaHutang;
//     $firstOrder->save();

//     // Buat invoice baru
//     $lastOrder = Order::where('service_id', $order->service_id)
//         ->orderBy('id', 'desc')
//         ->first();

//     $lastNumber = 0;
//     if ($lastOrder && $lastOrder->invoice) {
//         $parts = explode('-', $lastOrder->invoice);
//         $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
//     }
//     $newInvoiceCode = 'INV-' . ($lastNumber + 1);

//     // Simpan riwayat pembayaran
//     Order::create([
//         'service_id'          => $order->service_id,
//         'total_amount'        => $jumlahBayar, // jumlah yang dibayarkan kali ini
//         'total_yang_dibayarkan' => $jumlahBayar,
//         'sisa_hutang'         => $sisaHutang,
//         'invoice'             => $newInvoiceCode,
//     ]);

//     return redirect()->route('admin.order', $firstOrder->id)
//         ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format($sisaHutang, 0, ',', '.'));
// }

// public function payment(Request $request, Order $order)
// {
//     $request->validate([
//         'jumlah_dibayarkan' => 'required|numeric|min:1',
//     ]);

//     $jumlahBayar = (int) $request->jumlah_dibayarkan;

//     // Ambil order terakhir untuk service ini (riwayat pembayaran terakhir)
//     $lastPayment = Order::where('service_id', $order->service_id)
//         ->orderBy('id', 'desc')
//         ->first();

//     // Kalau belum ada pembayaran, ambil total dari row pertama
//     $firstOrder = Order::where('service_id', $order->service_id)
//         ->orderBy('id', 'asc')
//         ->first();

//     $sisaHutangSebelumnya = $lastPayment && $lastPayment->id !== $firstOrder->id
//         ? $lastPayment->sisa_hutang
//         : $firstOrder->total_amount;

//     // Hitung sisa hutang baru
//     $sisaHutangBaru = $sisaHutangSebelumnya - $jumlahBayar;
//     if ($sisaHutangBaru < 0) {
//         $sisaHutangBaru = 0;
//     }

//     // Buat invoice baru
//     $lastNumber = 0;
//     if ($lastPayment && $lastPayment->invoice) {
//         $parts = explode('-', $lastPayment->invoice);
//         $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
//     }
//     $newInvoiceCode = 'INV-' . ($lastNumber + 1);

//     // Simpan pembayaran baru (row kedua, ketiga, dst)
//     Order::create([
//         'service_id'            => $order->service_id,
//         'total_amount'          => $jumlahBayar,   // jumlah yang dibayar kali ini
//         'total_yang_dibayarkan' => $jumlahBayar,
//         'sisa_hutang'           => $sisaHutangBaru,
//         'invoice'               => $newInvoiceCode,
//     ]);

//     return redirect()->route('admin.order', $order->id)
//         ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format($sisaHutangBaru, 0, ',', '.'));
// }


public function payment(Request $request, Order $order)
{
    $request->validate([
        'jumlah_dibayarkan' => 'required|numeric|min:1',
    ]);

    $jumlahBayar = (int) $request->jumlah_dibayarkan;

    // Ambil row terakhir (bisa row master kalau belum ada pembayaran)
    $lastOrder = Order::where('service_id', $order->service_id)
        ->orderBy('id', 'desc')
        ->first();

    // Kalau row terakhir itu master, maka total_amount = total keseluruhan
    $totalSebelumnya = $lastOrder->sisa_hutang ?? $lastOrder->total_amount;

    // Hitung sisa hutang baru
    $sisaHutang = $totalSebelumnya - $jumlahBayar;
    if ($sisaHutang < 0) {
        $sisaHutang = 0;
    }

    // Buat invoice baru
    $lastNumber = 0;
    if ($lastOrder && $lastOrder->invoice) {
        $parts = explode('-', $lastOrder->invoice);
        $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
    }
    $newInvoiceCode = 'INV-' . ($lastNumber + 1);

    // Simpan pembayaran baru
    Order::create([
        'service_id'            => $order->service_id,
        'total_amount'          => $totalSebelumnya, // dari sisa hutang sebelumnya
        'total_yang_dibayarkan' => $jumlahBayar,     // jumlah dibayar kali ini
        'sisa_hutang'           => $sisaHutang,
        'invoice'               => $newInvoiceCode,
    ]);

    return redirect()->route('admin.order', $order->id)
        ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format($sisaHutang, 0, ',', '.'));
}


}
