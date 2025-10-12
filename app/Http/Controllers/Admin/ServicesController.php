<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCustomer;
use App\Models\ContentItem;
use App\Models\File;
use App\Models\Guide;
use App\Models\GuideItems;
use App\Models\Hotel;
use App\Models\Meal;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Tour;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\TransportationOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\TourItem;
use App\Models\MealItem;
use App\Models\Document as DocumentModel;
use App\Models\CustomerDocument;
use App\Models\Wakaf;
use App\Models\Dorongan;
use App\Models\DoronganOrder;
use App\Models\TypeHotel;
use Illuminate\Support\Facades\DB;
use App\Models\Badal;
use App\Models\DocumentChildren;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use App\Models\WakafCustomer;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    /**
     * Tampilkan daftar layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $serviceFilter = $request->get('service');

        // Tentukan prefix kode unik berdasarkan filter service
        $codePrefix = match ($serviceFilter) {
            'transportasi' => 'TRX',
            'hotel' => 'H',
            'dokumen' => 'D',
            'handling' => 'G',
            'pendamping' => 'P',
            'konten' => 'K',
            'reyal' => 'R',
            'tour' => 'O',
            'meal' => 'M',
            'dorongan' => 'C',
            'wakaf' => 'W',
            'badal' => 'B',
            default => null,
        };

        // Query Nego
        $negoQuery = Service::where('status', 'nego')
            ->selectRaw('
                MIN(id) as id,
                pelanggan_id,
                MIN(tanggal_keberangkatan) as tanggal_keberangkatan,
                MIN(tanggal_kepulangan) as tanggal_kepulangan,
                SUM(total_jamaah) as total_jamaah,
                GROUP_CONCAT(services) as services,
                MIN(unique_code) as unique_code,
                status
            ')
            ->groupBy('pelanggan_id', 'status');

        // Query Deal
        $dealQuery = Service::where('status', 'deal');

        // Terapkan filter berdasarkan kode unik jika ada prefix
        if ($codePrefix) {
            $negoQuery->where('unique_code', 'LIKE', $codePrefix . '-%');
            $dealQuery->where('unique_code', 'LIKE', $codePrefix . '-%');
        }

        // Urutkan berdasarkan angka dari MIN(unique_code)
        $negoQuery->orderByRaw("CAST(SUBSTRING_INDEX(MIN(unique_code), '-', -1) AS UNSIGNED)");
        $dealQuery->orderByRaw("CAST(SUBSTRING_INDEX(unique_code, '-', -1) AS UNSIGNED)");

        $nego = $negoQuery->get();
        $deal = $dealQuery->get();

        $services = $nego->merge($deal);

        return view('admin.services.index', compact('services'));
    }


    public function create()
    {
        $data = [
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::all(),
            'guides' => GuideItems::all(),
            'tours' => TourItem::all(),
            'meals' => MealItem::all(),
            'documents' => DocumentModel::with('childrens')->get(),
            'wakaf' => Wakaf::all(),
            'dorongan' => Dorongan::all(),
            'contents' => ContentItem::all(),
            'types' => TypeHotel::all(),
        ];

        return view('admin.services.create', $data);
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

        $masterPrefix = 'TRX';
        $lastService = Service::where('unique_code', 'like', $masterPrefix . '-%')
            ->orderByDesc('id')
            ->first();
        $lastNumber = $lastService ? (int) explode('-', $lastService->unique_code)[1] : 0;
        $uniqueCode = $masterPrefix . '-' . ($lastNumber + 1);
        $status = $request->input('action') === 'nego' ? 'nego' : 'deal';

        $service = Service::create([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
            'unique_code' => $uniqueCode,
        ]);

        $this->processServiceItems($request, $service);

        // Buat order
        $totalAmount = (float) $request->input('total_amount', 0);
        Order::create([
            'service_id' => $service->id,
            'total_amount' => $totalAmount,
            'invoice' => 'INV-' . time(),
            'total_yang_dibayarkan' => 0,
            'sisa_hutang' => $totalAmount,
            'status_pembayaran' => $totalAmount == 0 ? 'lunas' : 'belum_bayar',
        ]);
        if ($status === 'deal') {
            return redirect()->route('service.uploadBerkas', [
                'service_id' => $service->id,
                'total_jamaah' => $request->total_jamaah,
            ])->with('success', 'Data service berhasil disimpan.');
        }
        return redirect()->route('admin.services')->with('success', 'Data nego berhasil diperbarui.');

    }


    public function show($id)
    {
        $service = Service::with('pelanggan')->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }


    public function nego($id)
    {
        // Eager load semua relasi yang mungkin dibutuhkan di view
        $service = Service::with([
            'pelanggan',
            'planes',
            'transportationItem.transportation.routes',
            'transportationItem.route',
            'hotels', // Asumsi ada relasi hotels() di model Service
            'documents',
            'guides',
            'contents',
            'meals',
            'dorongans',
            'wakafs',
            'badals',
            'tours.transportation', // Memuat tour yang dipilih beserta transportasinya
            'handlings.handlingHotels',
            'handlings.handlingPlanes'
        ])->findOrFail($id);

        // Siapkan semua data master yang dibutuhkan untuk form
        $data = [
            'service' => $service,
            'pelanggans' => \App\Models\Pelanggan::all(),
            'transportations' => \App\Models\Transportation::with('routes')->get(),
            'types' => \App\Models\TypeHotel::all(),
            'documents' => \App\Models\Document::with('childrens')->get(), // Ganti DocumentModel dengan nama model Anda
            'guides' => \App\Models\GuideItems::all(), // Master data pemandu
            'contents' => \App\Models\ContentItem::all(), // Master data konten
            'meals' => \App\Models\MealItem::all(), // Master data makanan
            'tours' => \App\Models\TourItem::all(), // Master data tour
            'dorongan' => \App\Models\Dorongan::all(), // Master data dorongan
            'wakaf' => \App\Models\Wakaf::all(), // Master data wakaf
        ];

        return view('admin.services.nego', $data);
    }





    public function uploadBerkas(Request $request, $service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.upload_berkas', [
            'service' => $service
        ]);
    }


public function storeBerkas(Request $request, $id)
{
    $service = Service::findOrFail($id);

    // Default null biar gak error kalau file gak diupload
    $path = $pathPaspor = $pathktp = $pathvisa = null;

    // Simpan file jika ada
    if ($request->hasFile('pas_foto')) {
        $path = $request->file('pas_foto')->store('/', 'public');
    }
    if ($request->hasFile('paspor')) {
        $pathPaspor = $request->file('paspor')->store('/', 'public');
    }
    if ($request->hasFile('ktp')) {
        $pathktp = $request->file('ktp')->store('/', 'public');
    }
    if ($request->hasFile('visa')) {
        $pathvisa = $request->file('visa')->store('/', 'public');
    }

    // Simpan ke tabel files
    File::create([
        'service_id' => $service->id,
        'pas_foto'   => $path,
        'paspor'     => $pathPaspor,
        'ktp'        => $pathktp,
        'visa'       => $pathvisa,
    ]);

    return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');


}



    /**
     * Tampilkan daftar berkas.
     *
     * @return \Illuminate\View\View
     */
    public function showFile($id)
    {

        $service = Service::findOrFail($id);
        $files = File::where('service_id', $service->id)->get();
        return view('admin.services.show_file', compact('files', 'service'));
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Data layanan berhasil dihapus.');
    }

    public function updateNego(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $status = 'deal'; // status otomatis NEGO

        // ✅ Validasi dasar
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        /* =====================================================
     * 🧩 GABUNGKAN SERVICES LAMA & BARU
     * ===================================================== */
        $existingServices = json_decode($service->services, true) ?? [];
        $newServices = $request->input('services', []);
        $mergedServices = array_unique(array_merge($existingServices, $newServices));

        // ✅ Update data utama
        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($mergedServices), // ← tidak menimpa, tapi menggabung
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);
        // Ambil total baru dari request
        $newAmount = (float) $request->input('total_amount', 0);

        // Cek apakah sudah ada order untuk service ini
        $order = Order::where('service_id', $service->id)->first();

        if ($order) {
            // Jika order sudah ada, tambahkan total_amount baru ke yang lama
            $order->update([
                'total_amount' => $order->total_amount + $newAmount,
                'sisa_hutang' => ($order->sisa_hutang ?? 0) + $newAmount,
                'status_pembayaran' => 'belum_bayar', // tetap belum lunas karena ada tambahan
            ]);
        } else {
            // Jika belum ada order, buat baru
            Order::create([
                'service_id' => $service->id,
                'total_amount' => $newAmount,
                'invoice' => 'INV-' . time(),
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $newAmount,
                'status_pembayaran' => $newAmount == 0 ? 'lunas' : 'belum_bayar',
            ]);
        }


        /* =====================================================
     * ✈️ PESAWAT
     * ===================================================== */
        if ($request->has('rute') && is_array($request->rute) && collect($request->rute)->filter()->isNotEmpty()) {
            foreach ($request->rute as $i => $rute) {
                if (empty($rute)) continue;

                $planeId = $request->plane_id[$i] ?? null;
                $plane = Plane::find($planeId);

                $data = [
                    'service_id' => $service->id,
                    'tanggal_keberangkatan' => $request->tanggal[$i] ?? now(),
                    'rute' => $rute,
                    'maskapai' => $request->maskapai[$i] ?? null,
                    'harga' => $request->harga_tiket[$i] ?? 0,
                    'keterangan' => $request->keterangan[$i] ?? null,
                    'jumlah_jamaah' => $request->jumlah[$i] ?? 0,
                ];

                if ($request->hasFile("tiket_berangkat.$i")) {
                    $data['tiket_berangkat'] = $this->storeFileIfExists($request->file("tiket_berangkat.$i"), $i, 'tiket');
                }

                if ($request->hasFile("tiket_pulang.$i")) {
                    $data['tiket_pulang'] = $this->storeFileIfExists($request->file("tiket_pulang.$i"), $i, 'tiket');
                }

                if ($plane) {
                    $plane->update($data);
                } else {
                    foreach ($request->tanggal as $j => $tgl) {
                        if ($tgl) {
                            Plane::create([
                                'service_id' => $service->id,
                                'tanggal_keberangkatan' => $tgl,
                                'rute' => $request->rute[$j] ?? null,
                                'maskapai' => $request->maskapai[$j] ?? null,
                                'harga' => $request->harga_tiket[$j] ?? null,
                                'keterangan' => $request->keterangan[$j] ?? null,
                                'jumlah_jamaah' => $request->jumlah[$j] ?? 0,
                                'tiket_berangkat' => $this->storeFileIfExists($request->file('tiket_berangkat', []), $j, 'tiket'),
                                'tiket_pulang' => $this->storeFileIfExists($request->file('tiket_pulang', []), $j, 'tiket'),
                            ]);
                        }
            }
                }
            }
        }

        /* =====================================================
     * 🚐 TRANSPORTASI
     * ===================================================== */
        if ($request->has('transportation_id') && collect($request->transportation_id)->filter()->isNotEmpty()) {
            foreach ($request->transportation_id as $ti => $transportId) {
                if (empty($transportId)) continue;

                $itemId = $request->item_id[$ti] ?? null;
                $routeId = $request->rute_id[$ti] ?? null;

                $transportItem = TransportationItem::find($itemId);

                if ($transportItem) {
                    $transportItem->update([
                        'transportation_id' => $transportId,
                        'route_id' => $routeId,
                    ]);
                } else {
                    TransportationItem::create([
                        'service_id' => $service->id,
                        'transportation_id' => $transportId,
                        'route_id' => $routeId,
                    ]);
                }
            }
        }

        /* =====================================================
     * 📄 DOKUMEN
     * ===================================================== */
        if ($request->has('dokumen_id') && collect($request->dokumen_id)->filter()->isNotEmpty()) {
            foreach ($request->dokumen_id as $index => $documentId) {
                if (empty($documentId)) continue;

                $cusdocid = $request->customer_document_id[$index] ?? null;
                $jumlah   = $request->jumlah_doc_child[$index] ?? 0;

                $itemCusDoc = CustomerDocument::find($cusdocid);

                if ($itemCusDoc) {
                    $itemCusDoc->update(['jumlah' => $jumlah]);
                } else {
                    CustomerDocument::create([
                        'service_id'  => $service->id,
                        'dokumen_id'  => $documentId,
                        'jumlah'      => $jumlah,
                    ]);
                }
            }
        }

        /* =====================================================
     * 🏨 HOTEL
     * ===================================================== */
        if ($request->has('tanggal_checkin') && is_array($request->tanggal_checkin)) {
            foreach ($request->tanggal_checkin as $index => $tanggalCheckin) {
                if (empty($tanggalCheckin)) continue;

                $hotelId = $request->hotel_id[$index] ?? null;
                $hotel = Hotel::find($hotelId);

                $typeHotel  = $request->type_hotel[$index] ?? 'Standard';
                $jumlahType = $request->jumlah_type[$index] ?? 0;

                if ($hotel) {
                    $hotel->update([
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel'      => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar'    => $request->jumlah_kamar[$index] ?? 0,
                        'type'            => $typeHotel,
                        'jumlah_type'     => $jumlahType,
                    ]);
                } else {
                    Hotel::create([
                        'service_id'      => $service->id,
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel'      => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar'    => $request->jumlah_kamar[$index] ?? 0,
                        'type'            => $typeHotel,
                        'jumlah_type'     => $jumlahType,
                    ]);
                }
            }
        }
        if ($request->has('nama_hotel_handling') && is_array($request->nama_hotel_handling)) {
            foreach ($request->nama_hotel_handling as $index => $namaHotelHandling) {
                if (empty($namaHotelHandling)) continue; // lewati jika kosong

                $handlingHotelId = $request->handling_hotel_id[$index] ?? null;
                $itemHandlingHotel = HandlingHotel::find($handlingHotelId);

                if ($itemHandlingHotel) {
                    // 🔸 Update data lama
                    $itemHandlingHotel->update([
                        'nama'    => $namaHotelHandling,
                        'tanggal' => $request->tanggal_hotel_handling[$index] ?? null,
                        'harga'   => $request->harga_hotel_handling[$index] ?? 0,
                        'pax'     => $request->pax_hotel_handling[$index] ?? 0,
                    ]);
                } else {
                    // 🔹 Insert data baru
                    HandlingHotel::create([
                        'service_id' => $service->id,
                        'nama'       => $namaHotelHandling,
                        'tanggal'    => $request->tanggal_hotel_handling[$index] ?? null,
                        'harga'      => $request->harga_hotel_handling[$index] ?? 0,
                        'pax'        => $request->pax_hotel_handling[$index] ?? 0,
                    ]);
                }
            }
        }

        if ($request->has('nama_bandara_handling') && collect($request->nama_bandara_handling)->filter()->isNotEmpty()) {
            $handlingBandaraId = $request->handling_bandara_id;
            $itemHandlingBandara = HandlingPlanes::find($handlingBandaraId);
            if ($itemHandlingBandara) {
                $itemHandlingBandara->update([
                    'nama_bandara' => $request->nama_bandara_handling,
                    'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                    'harga' => $request->harga_bandara_handling,
                    'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                    "nama_supir" => $request->nama_supir,
                ]);
            }
        }

        if ($request->has('jumlah_pendamping') && is_array($request->jumlah_pendamping)) {
            foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data pendamping sesuai service & guide_id
                    $guideItem = Guide::where('service_id', $service->id)
                        ->where('guide_id', $guideId);
                    if ($guideItem) {
                        $guideItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambahkan data baru kalau belum ada
                        Guide::create([
                            'service_id' => $service->id,
                            'guide_id'   => $guideId,
                            'jumlah'     => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_konten') && is_array($request->jumlah_konten)) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data konten berdasarkan service dan content_id
                    $contentItem = ContentCustomer::where('service_id', $service->id)
                        ->where('content_id', $contentId)
                        ->first();

                    if ($contentItem) {
                        // 🔸 Update data jika sudah ada
                        $contentItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambahkan data baru jika belum ada
                        ContentCustomer::create([
                            'service_id' => $service->id,
                            'content_id' => $contentId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_meals') && is_array($request->jumlah_meals)) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data meal berdasarkan service dan meal_id
                    $mealItem = Meal::where('service_id', $service->id)
                        ->where('meal_id', $mealId)
                        ->first();

                    if ($mealItem) {
                        // 🔸 Update jumlah jika sudah ada
                        $mealItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambah data baru jika belum ada
                        Meal::create([
                            'service_id' => $service->id,
                            'meal_id'    => $mealId,
                            'jumlah'     => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_dorongan') && is_array($request->jumlah_dorongan)) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data dorongan sesuai service & dorongan_id
                    $doronganItem = DoronganOrder::where('service_id', $service->id)
                        ->where('dorongan_id', $doronganId)
                        ->first();

                    if ($doronganItem) {
                        // 🔸 Jika sudah ada → update jumlah
                        $doronganItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Jika belum ada → tambahkan data baru
                        DoronganOrder::create([
                            'service_id'   => $service->id,
                            'dorongan_id'  => $doronganId,
                            'jumlah'       => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('tour_id') && collect($request->tour_id)->filter()->isNotEmpty()) {
            foreach ($request->tour_id as $index => $tourItemId) {
                if (empty($tourItemId)) continue;

                $transportId = $request->tour_transport[$index] ?? null;

                // Cek apakah sudah ada data tour untuk service ini dan tour_id terkait
                $tourItem = Tour::where('service_id', $service->id)
                    ->where('tour_id', $tourItemId)
                    ->first();

                if ($tourItem) {
                    // 🔸 Update data jika sudah ada
                    $tourItem->update([
                        'transportation_id' => $transportId,
                    ]);
                } else {
                    // 🔹 Tambah baru jika belum ada
                    Tour::create([
                        'service_id'        => $service->id,
                        'tour_id'           => $tourItemId,
                        'transportation_id' => $transportId,

                    ]);
                }
            }
        }
        if ($request->has('jumlah_wakaf') && is_array($request->jumlah_wakaf)) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $wakafItem = WakafCustomer::where('service_id', $service->id)
                        ->where('wakaf_id', $wakafId)
                        ->first();

                    if ($wakafItem) {
                        // 🔸 Jika sudah ada, update jumlah
                        $wakafItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Jika belum ada, buat baru
                        WakafCustomer::create([
                            'service_id' => $service->id,
                            'wakaf_id'   => $wakafId,
                            'jumlah'     => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('nama_badal') && is_array($request->nama_badal)) {
            foreach ($request->nama_badal as $index => $namaBadal) {
                if (empty($namaBadal)) continue;

                $hargaBadal = $request->harga_badal[$index] ?? 0;
                $badalId = $request->badal_id[$index] ?? null; // pastikan hidden input badal_id[] di form

                Badal::updateOrCreate(
                    ['id' => $badalId, 'service_id' => $service->id],
                    [
                        'name'  => $namaBadal,
                        'price' => $hargaBadal,
                    ]
                );
            }
        }

        // 🔁 Redirect
        return redirect()->route('admin.services', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah,
        ])->with('success', 'Data service berhasil diperbarui dengan status NEGO.');
    }






    public function edit($id)
    {
        $service = Service::with([
            'pelanggan',
            'hotels',
            'planes',
            'transportationItem.transportation.routes',
            'transportationItem.route',
            'handlings', // Simplified for clarity
            'meals',
            'guides',
            'tours', // Eager load the tours and their selected transportation
            'documents',
            'wakafs',
            'dorongans',
            'contents',
            'badals'
        ])->findOrFail($id);

        $data = [
            'service' => $service,
            // The selectedServices can be decoded directly from the service object
            'selectedServices' => $service->services ?? [],
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::with('routes')->get(),
            'guides' => Guide::all(),
            'tours' => Tour::all(),
            'meals' => Meal::all(),
            'documents' => DocumentModel::with('childrens')->get(),
            'wakaf' => WakafCustomer::all(),
            'dorongan' => DoronganOrder::all(),
            'contents' => ContentCustomer::all(),
            'types' => TypeHotel::all(),
        ];

        return view('admin.services.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $status = $request->input('action') === 'nego' ? 'nego' : 'deal';

        /* =====================================================
     * ✅ VALIDASI INPUT
     * ===================================================== */
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        /* =====================================================
     * 🔁 UPDATE DATA SERVICE UTAMA
     * ===================================================== */
        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);

        /* =====================================================
     * ✈️ UPDATE / TAMBAH DATA PESAWAT
     * ===================================================== */
        if (
            $request->has('rute') &&
            is_array($request->rute) &&
            collect($request->rute)->filter()->isNotEmpty() &&
            $request->filled('tanggal')
        ) {
            foreach ($request->rute as $i => $rute) {
                if (empty($rute)) continue;

                $planeId = $request->plane_id[$i] ?? null;
                $plane = Plane::find($planeId) ?? new Plane(['service_id' => $service->id]);

                $plane->tanggal_keberangkatan = $request->tanggal[$i] ?? now();
                $plane->rute = $rute;
                $plane->maskapai = $request->maskapai[$i] ?? null;
                $plane->harga = $request->harga_tiket[$i] ?? null;
                $plane->keterangan = $request->keterangan[$i] ?? null;
                $plane->jumlah_jamaah = $request->jumlah[$i] ?? 0;

                if ($request->hasFile("tiket_berangkat.$i")) {
                    $plane->tiket_berangkat = $this->storeFileIfExists($request->file("tiket_berangkat.$i"), $i, 'tiket');
                }

                if ($request->hasFile("tiket_pulang.$i")) {
                    $plane->tiket_pulang = $this->storeFileIfExists($request->file("tiket_pulang.$i"), $i, 'tiket');
                }

                $plane->save();
            }
        }

        /* =====================================================
     * 🚌 TRANSPORTASI
     * ===================================================== */
        if ($request->has('transportation_id') && collect($request->transportation_id)->filter()->isNotEmpty()) {
            foreach ($request->transportation_id as $ti => $transportId) {
                if (empty($transportId)) continue;

                $itemId = $request->item_id[$ti] ?? null;
                $transp = TransportationItem::find($itemId) ?? new TransportationItem(['service_id' => $service->id]);

                $transp->transportation_id = $transportId;
                $transp->route_id = $request->rute_id[$ti];
                $transp->save();
            }
        }

        /* =====================================================
     * 📄 DOKUMEN
     * ===================================================== */
        if ($request->has('dokumen_id') && collect($request->dokumen_id)->filter()->isNotEmpty()) {
            foreach ($request->dokumen_id as $index => $documentId) {
                if (empty($documentId)) continue;

                $cusdocid = $request->customer_document_id[$index] ?? null;
                $jumlah   = $request->jumlah_doc_child[$index] ?? 0;

                $itemCusDoc = CustomerDocument::find($cusdocid) ?? new CustomerDocument(['service_id' => $service->id]);
                $itemCusDoc->jumlah = $jumlah;
                $itemCusDoc->save();
            }
        }

        /* =====================================================
     * 🏨 HANDLING HOTEL
     * ===================================================== */
        if ($request->has('nama_hotel_handling') && collect($request->nama_hotel_handling)->filter()->isNotEmpty()) {
            $handlingHotelId = $request->handling_hotel_id;
            $item = HandlingHotel::find($handlingHotelId);
            if ($item) {
                $item->update([
                    'nama' => $request->nama_hotel_handling,
                    'tanggal' => $request->tanggal_hotel_handling,
                    'harga' => $request->harga_hotel_handling,
                    'pax' => $request->pax_hotel_handling,
                ]);
            }
        }

        /* =====================================================
     * 🛬 HANDLING BANDARA
     * ===================================================== */
        if ($request->has('nama_bandara_handling') && collect($request->nama_bandara_handling)->filter()->isNotEmpty()) {
            $handlingBandaraId = $request->handling_bandara_id;
            $item = HandlingPlanes::find($handlingBandaraId);
            if ($item) {
                $item->update([
                    'nama_bandara' => $request->nama_bandara_handling,
                    'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                    'harga' => $request->harga_bandara_handling,
                    'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                    'nama_supir' => $request->nama_supir,
                ]);
            }
        }

        /* =====================================================
     * 👥 PENDAMPING
     * ===================================================== */
        if ($request->has('jumlah_pendamping') && is_array($request->jumlah_pendamping)) {
            foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $guideItem = Guide::where('service_id', $service->id)->where('guide_id', $guideId)->first();
                    if ($guideItem) $guideItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
     * 📸 KONTEN
     * ===================================================== */
        if ($request->has('jumlah_konten') && is_array($request->jumlah_konten)) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $contentItem = ContentCustomer::where('service_id', $service->id)->where('content_id', $contentId)->first();
                    if ($contentItem) $contentItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
     * 🗺️ TOUR
     * ===================================================== */
        if ($request->has('tour_id') && collect($request->tour_id)->filter()->isNotEmpty()) {
            $tourId = $request->id_tour;
            $tourFinally = Tour::find($tourId);
            if ($tourFinally) {
                foreach ($request->tour_transport as $transport) {
                    $tourFinally->update([
                        'transportation_id' => $transport,
                        'tour_id' => $request->tour_id,
                    ]);
                }
            }
        }

        /* =====================================================
     * 🍱 MEALS
     * ===================================================== */
        if ($request->has('jumlah_meals') && is_array($request->jumlah_meals)) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $mealItem = Meal::where('service_id', $service->id)->where('meal_id', $mealId)->first();
                    if ($mealItem) $mealItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
     * 💸 DORONGAN
     * ===================================================== */
        if ($request->has('jumlah_dorongan') && is_array($request->jumlah_dorongan)) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $doronganItem = DoronganOrder::where('service_id', $service->id)->where('dorongan_id', $doronganId)->first();
                    if ($doronganItem) $doronganItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
     * 🕋 BADAL
     * ===================================================== */
        if ($request->has('nama_badal') && is_array($request->nama_badal)) {
            foreach ($request->nama_badal as $index => $namaBadal) {
                if (empty($namaBadal)) continue;

                $hargaBadal = $request->harga_badal[$index] ?? 0;
                $badalItem = Badal::where('service_id', $service->id)->first();

                if ($badalItem) {
                    $badalItem->update([
                        'name' => $namaBadal,
                        'price' => $hargaBadal,
                    ]);
                }
            }
        }

        /* =====================================================
     * 🏨 HOTEL
     * ===================================================== */
        if ($request->has('tanggal_checkin') && is_array($request->tanggal_checkin)) {
            foreach ($request->tanggal_checkin as $index => $tanggalCheckin) {
                if (empty($tanggalCheckin)) continue;

                $hotel = Hotel::where('service_id', $service->id)->skip($index)->first();
                $typeHotel = $request->type_hotel[$index] ?? 'Standard';
                $jumlahType = $request->jumlah_type[$index] ?? 0;

                if ($hotel) {
                    $hotel->update([
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel' => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar' => $request->jumlah_kamar[$index] ?? 0,
                        'type' => $typeHotel,
                        'jumlah_type' => $jumlahType
                    ]);
                }
            }
        }

        /* =====================================================
     * 💰 WAKAF
     * ===================================================== */
        if ($request->has('jumlah_wakaf') && is_array($request->jumlah_wakaf)) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $wakafItem = WakafCustomer::where('service_id', $service->id)
                        ->where('wakaf_id', $wakafId)
                        ->first();

                    if ($wakafItem) {
                        $wakafItem->update(['jumlah' => $jumlah]);
                    }
                }
            }
        }
        /* =====================================================
     * ✅ REDIRECT SELESAI
     * ===================================================== */
        return redirect()->route('admin.services', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah,
        ])->with('success', 'Data service berhasil diperbarui.');
    }








    private function storeFileIfExists(array $files, int $index, string $path)
    {
        if (isset($files[$index]) && $files[$index]->isValid()) {
            return $files[$index]->store($path, 'public');
        }
        return null;
    }

    /**
     * Memproses dan menyimpan item layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return void
     */
    private function processServiceItems(Request $request, Service $service)
    {
        foreach ($request->services as $srv) {
            $srvLower = strtolower($srv);
            switch ($srvLower) {
                case 'hotel':
                    $this->handleHotelItems($request, $service);
                    break;
                case 'transportasi':
                    $this->handleTransportationItems($request, $service);
                    break;
                case 'handling':
                    $this->handleHandlingItems($request, $service);
                    break;
                case 'meals':
                    $this->handleMealItems($request, $service);
                    break;
                case 'pendamping':
                    $this->handleGuideItems($request, $service);
                    break;
                case 'tour':
                    $this->handleTourItems($request, $service);
                    break;
                case 'dokumen':
                    $this->handleDocumentItems($request, $service);
                    break;
                case 'reyal':
                    $this->handleReyalItems($request, $service);
                    break;
                case 'waqaf':
                    $this->handleWakafItems($request, $service);
                    break;
                case 'dorongan':
                    $this->handleDoronganItems($request, $service);
                    break;
                case 'konten':
                    $this->handleContentItems($request, $service);
                    break;
                case 'badal':
                    $this->handleBadalItems($request, $service);
                    break;
            }
        }
    }


    private function deleteServiceItems(Service $service)
    {
        $service->hotels()->delete();
        $service->planes()->delete();
        $service->transportationItem()->delete();
        $service->handlings()->delete();
        $service->meals()->delete();
        $service->guides()->delete();
        $service->tours()->delete();
        $service->documents()->delete();
        $service->reyals()->delete();
        $service->wakafs()->delete();
        $service->dorongans()->delete();
        $service->contents()->delete();
        $service->badals()->delete();
    }



    private function handleHotelItems(Request $request, Service $service)
    {
        if ($request->filled('nama_hotel')) {
            foreach ($request->nama_hotel as $i => $namaHotel) {
                foreach ($request->type as $t => $type) {
                    if (empty($namaHotel)) continue;
                    $hotel = $service->hotels()->create([
                        'nama_hotel' => $namaHotel,
                        'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
                        'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                        'type' => $type,
                        'jumlah_kamar' => $request->jumlah_kamar[$i],
                        'harga_perkamar' =>  $request->jumlah_kamar[$i],
                        'jumlah_type' =>  $request->jumlah_type[$i],
                        'type_custom_special_room' => $request->type_custom_special_room[$i],
                        'jumlah_kasur' => $request->jumlah_kasur[$i],
                    ]);
                }
            }
        }
    }

    private function handleTransportationItems(Request $request, Service $service)
    {
        // Tiket Pesawat
        if ($request->filled('transportation') && in_array('airplane', $request->transportation)) {
            foreach ($request->tanggal as $j => $tgl) {
                if ($tgl) {
                    $service->planes()->create([
                        'tanggal_keberangkatan' => $tgl,
                        'rute' => $request->rute[$j] ?? null,
                        'maskapai' => $request->maskapai[$j] ?? null,
                        'harga' => $request->harga_tiket[$j] ?? null,
                        'keterangan' => $request->keterangan[$j] ?? null,
                        'jumlah_jamaah' => $request->jumlah[$j] ?? 0,
                        'tiket_berangkat' => $this->storeFileIfExists($request->file('tiket_berangkat', []), $j, 'tiket'),
                        'tiket_pulang' => $this->storeFileIfExists($request->file('tiket_pulang', []), $j, 'tiket'),
                    ]);
                }
            }
        }

        // Transportasi Darat (Bus)
        if ($request->filled('transportation') && in_array('bus', $request->transportation)) {
            $transportationIds = $request->input('transportation_id');
            $ruteIds = $request->input('rute_id');
            if (is_array($transportationIds)) {
                foreach ($transportationIds as $index => $transportId) {
                    $ruteId = $ruteIds[$index] ?? null;
                    if ($transportId && $ruteId) {
                        $service->transportationItem()->create([
                            'transportation_id' => $transportId,
                            'route_id' => $ruteId,
                        ]);
                    }
                }
            }
        }
    }

    private function handleHandlingItems(Request $request, Service $service)
    {
        if ($request->filled('handlings')) {
            foreach ($request->handlings as $handling) {
                $handlingModel = $service->handlings()->create(['name' => $handling]);
                switch (strtolower($handling)) {
                    case 'hotel':
                        if ($request->filled('nama_hotel_handling')) {
                            $handlingModel->handlingHotels()->create([
                                'nama' => $request->nama_hotel_handling,
                                'tanggal' => $request->tanggal_hotel_handling,
                                'harga' => $request->harga_hotel_handling,
                                'pax' => $request->pax_hotel_handling,
                                'kode_booking' => $request->file('kode_booking_hotel_handling') ? $request->file('kode_booking_hotel_handling')->store('handling/hotel', 'public') : null,
                                'rumlis' => $request->file('rumlis_hotel_handling') ? $request->file('rumlis_hotel_handling')->store('handling/hotel', 'public') : null,
                                'identitas_koper' => $request->file('identitas_hotel_handling') ? $request->file('identitas_hotel_handling')->store('handling/hotel', 'public') : null,
                            ]);
                        }
                        break;
                    case 'bandara':
                        if ($request->filled('nama_bandara_handling')) {
                            $handlingModel->handlingPlanes()->create([
                                'nama_bandara' => $request->nama_bandara_handling,
                                'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                                'harga' => $request->harga_bandara_handling,
                                'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                                'paket_info' => $request->file('paket_info') ? $request->file('paket_info')->store('handling/bandara', 'public') : null,
                                'nama_supir' => $request->nama_supir,
                                'identitas_koper' => $request->file('identitas_koper_bandara_handling') ? $request->file('identitas_koper_bandara_handling')->store('handling/bandara', 'public') : null,
                            ]);
                        }
                        break;
                }
            }
        }
    }

    private function handleMealItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_meals')) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if ($jumlah > 0) {
                    $service->meals()->create(['meal_id' => $mealId, 'jumlah' => $jumlah]);
                }
            }
        }
    }

    private function handleGuideItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_pendamping')) {
            foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                if ($jumlah > 0) {
                    $service->guides()->create([
                        'guide_id' => $guideId,
                        'jumlah' => $jumlah,
                        'keterangan' => $request->input("keterangan_pendamping.$guideId") ?? null,
                    ]);
                }
            }
        }
    }

private function handleTourItems(Request $request, Service $service)
{
    if ($request->filled('tour_transport')) {
        foreach ($request->tour_transport as $tourId => $transportationId) {
            $tanggal = $request->tanggal_tour[$tourId] ?? null;

            if ($tanggal) {
                $service->tours()->create([
                    'tour_id' => $tourId,
                    'transportation_id' => $transportationId,
                    'tanggal_keberangkatan' => $tanggal,
                ]);
            }
        }
    }
}

    private function handleDocumentItems(Request $request, Service $service)
    {
        if ($request->filled('dokumen_id')) {
            if ($request->hasFile('paspor_dokumen')) {
                $paspordokumen = $request->file('paspor_dokumen')->store('/', 'public');
            }
            if ($request->hasFile('pas_foto_dokumen')) {
                $pasfotodokumen = $request->file('pas_foto_dokumen')->store('/', 'public');
            }
            foreach ($request->dokumen_id as $docId) {
                foreach ($request->child_documents as $child) {
                    if ($child) {
                        $itemChild = DocumentChildren::find($child);
                        $jumlah = $request->input("jumlah_doc_child_{$itemChild->id}", 1);
                        if ($jumlah > 0) {
                            $service->documents()->create([
                                'document_id' => $docId,
                                'document_children_id' => $itemChild->id,
                                'jumlah' => $jumlah,
                                'harga' => $itemChild->price,

                            ]);
                        }
                    } {
                        $jumlah = $request->input("jumlah_doc_{$docId}", 1);
                        if ($jumlah > 0) {
                            $service->documents()->create([
                                'document_id' => $docId,
                                'document_children_id' => null,
                                'jumlah' => $jumlah,
                                'harga' => '0',


                            ]);
                        }
                    }
                }
            }
        }
    }


    private function handleReyalItems(Request $request, Service $service)
    {
        if ($request->input('tipe') === 'tamis') {
            $service->reyals()->create([
                'tipe' => 'tamis',
                'jumlah_input' => $request->input('jumlah_rupiah'),
                'kurs' => $request->input('kurs_tamis'),
                'hasil' => $request->input('hasil_tamis'),
            ]);
        }
        if ($request->input('tipe') === 'tumis') {
            $service->reyals()->create([
                'tipe' => 'tumis',
                'jumlah_input' => $request->input('jumlah_reyal'),
                'kurs' => $request->input('kurs_tumis'),
                'hasil' => $request->input('hasil_tumis'),
            ]);
        }
    }

    private function handleWakafItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_wakaf')) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if ($jumlah > 0) {
                    $service->wakafs()->create([
                        'wakaf_id' => $wakafId,
                        'jumlah' => $jumlah
                    ]);
                }
            }
        }
    }

    private function handleDoronganItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_dorongan')) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if ($jumlah > 0) {
                    DoronganOrder::create([
                        'service_id' => $service->id,
                        'dorongan_id' => $doronganId,
                        'jumlah' => $jumlah,
                    ]);
                }
            }
        }
    }

    private function handleContentItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_konten')) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if ($jumlah > 0) {
                    ContentCustomer::create([
                        'service_id' => $service->id,
                        'content_id' => $contentId,
                        'jumlah' => $jumlah,
                        'keterangan' => $request->input("keterangan_konten.{$contentId}"),
                    ]);
                }
            }
        }
    }

    private function handleBadalItems(Request $request, Service $service)
    {
        if ($request->has('nama_badal')) {
            foreach ($request->nama_badal as $index => $nama) {
                if (!empty($nama)) {
                    Badal::create([
                        'service_id' => $service->id,
                        'name' => $nama,
                        'price' => $request->harga_badal[$index] ?? 0,
                    ]);
                }
            }
        }
    }
    public function bayar(Order $order)
    {
        $order->load('service.meals'); // load relasi sesuai kebutuhan
        return view('admin.order.bayar', compact('order'));
    }

    public function payment(Request $request, Order $order)
    {
        $request->validate([
            'jumlah_dibayarkan' => 'required|numeric|min:1',
        ]);

        $jumlahBayar = (int) $request->jumlah_dibayarkan;

        DB::beginTransaction();

        try {
            // Hitung total pembayaran & sisa hutang
            $totalDibayarBaru = $order->total_yang_dibayarkan + $jumlahBayar;
            $sisaHutangBaru = $order->total_amount - $totalDibayarBaru;

            // Tentukan status order lama
            $statusLama = $sisaHutangBaru <= 0 ? 'lunas' : 'sudah_bayar';

            // Update order lama
            $order->update([
                'total_yang_dibayarkan' => $totalDibayarBaru,
                'sisa_hutang' => max(0, $sisaHutangBaru),
                'status_pembayaran' => $statusLama,
            ]);

            // Kalau masih ada hutang → buat order baru khusus sisa hutang
            if ($sisaHutangBaru > 0) {
                $newInvoice = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);

                Order::create([
                    'service_id' => $order->service_id,
                    'total_amount' => $sisaHutangBaru,
                    'total_yang_dibayarkan' => 0,
                    'sisa_hutang' => $sisaHutangBaru,
                    'invoice' => $newInvoice,
                    'status_pembayaran' => 'belum_bayar',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.order')
                ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format(max(0, $sisaHutangBaru), 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}
