<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCustomer;
use App\Models\ContentItem;
use App\Models\File;
use App\Models\GuideItems;
use App\Models\Hotel;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Tour;
use App\Models\Transportation;
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
            'transportasi' => 'T',
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

        return redirect()->route('service.uploadBerkas', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah,
        ])->with('success', 'Data service berhasil disimpan.');
    }


    public function show($id)
    {
        $service = Service::with('pelanggan')->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }


    public function nego($id)
    {
        $service = Service::findOrFail($id);
        $allServices = Service::where('pelanggan_id', $service->pelanggan_id)->pluck('services')->toArray();
        $selectedServices = collect($allServices)
            ->map(fn($item) => is_array($item) ? $item : json_decode($item, true))
            ->flatten()
            ->unique()
            ->toArray();
        $transportations = Transportation::all();

        return view('admin.services.nego', compact('service', 'selectedServices', 'transportations'));
    }


    public function updateNego(Request $request, $id)
    {
        $oldService = Service::findOrFail($id);
        $newStatus = $request->input('action') === 'nego' ? 'nego' : 'deal';

        Service::where('pelanggan_id', $oldService->pelanggan_id)->update(['status' => $newStatus]);

        $prefixMap = [
            'hotel' => 'H', 'transportasi' => 'T', 'document' => 'D', 'handling' => 'HDL',
            'pendamping' => 'P', 'konten' => 'K', 'reyal' => 'R', 'tour' => 'TO',
            'meals' => 'M', 'dorongan' => 'DR', 'wakaf' => 'W', 'badal' => 'BD',
        ];

        foreach ($request->services as $srv) {
            $prefix = $prefixMap[$srv] ?? 'S';
            $lastService = Service::where('unique_code', 'like', $prefix . '-%')->orderByDesc('id')->first();
            $number = $lastService ? ((int) explode('-', $lastService->unique_code)[1] + 1) : 1;
            $uniqueCode = $prefix . '-' . $number;

            Service::create([
                'pelanggan_id' => $request->travel,
                'services' => json_encode([$srv]),
                'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
                'tanggal_kepulangan' => $request->tanggal_kepulangan,
                'total_jamaah' => $request->total_jamaah,
                'status' => $newStatus,
                'unique_code' => $uniqueCode,
            ]);
        }

        return redirect()->route('admin.services')->with('success', 'Data nego berhasil diperbarui.');
    }


    public function uploadBerkas(Request $request, $service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.upload_berkas', [
            'service_id' => $service->id,
            'total_jamaah' => $service->total_jamaah,
        ]);
    }


    public function storeBerkas(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);
        $service = Service::findOrFail($request->service_id);
        $pasFotoFiles = $request->file('pas_foto', []);
        $pasporFiles = $request->file('paspor', []);
        $ktpFiles = $request->file('ktp', []);
        $visaFiles = $request->file('visa', []);

        $totalJamaah = max(count($pasFotoFiles), count($pasporFiles), count($ktpFiles), count($visaFiles));

        for ($i = 0; $i < $totalJamaah; $i++) {
            $service->filess()->create([
                'pas_foto' => $this->storeFileIfExists($pasFotoFiles, $i, 'documents/pas_foto'),
                'paspor' => $this->storeFileIfExists($pasporFiles, $i, 'documents/paspor'),
                'ktp' => $this->storeFileIfExists($ktpFiles, $i, 'documents/ktp'),
                'visa' => $this->storeFileIfExists($visaFiles, $i, 'documents/visa'),
            ]);
        }

        return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');
    }

    /**
     * Tampilkan daftar berkas.
     *
     * @return \Illuminate\View\View
     */
    public function showFile()
    {
        $files = File::all();
        return view('admin.services.show_file', compact('files'));
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Data layanan berhasil dihapus.');
    }


    // public function edit($id)
    // {
    //     $service = Service::with([
    //         'hotels', 'planes', 'transportationItem',
    //         'handlings.handlingHotels', 'handlings.handlingPlanes',
    //         'meals', 'guides', 'tours', 'documents', 'reyals',
    //         'wakafs', 'dorongans', 'contents', 'badals'
    //     ])->findOrFail($id);

    //     $allServices = Service::where('pelanggan_id', $service->pelanggan_id)
    //         ->pluck('services')
    //         ->toArray();
    //     $selectedServices = collect($allServices)
    //         ->map(fn($item) => is_array($item) ? $item : json_decode($item, true))
    //         ->flatten()
    //         ->unique()
    //         ->toArray();

    //     $data = [
    //         'service' => $service,
    //         'selectedServices' => $selectedServices,
    //         'pelanggans' => Pelanggan::all(),
    //         'transportations' => Transportation::all(),
    //         'guides' => GuideItems::all(),
    //         'tours' => TourItem::all(),
    //         'meals' => MealItem::all(),
    //         'documents' => DocumentModel::with('childrens')->get(),
    //         'wakaf' => Wakaf::all(),
    //         'dorongan' => Dorongan::all(),
    //         'contents' => ContentItem::all(),
    //         'types' => TypeHotel::all(),
    //     ];

    //     return view('admin.services.edit', $data);
    // }
// IN YOUR ServicesController.php
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
        'guides' => GuideItems::all(),
        'tours' => TourItem::all(),
        'meals' => MealItem::all(),
        'documents' => DocumentModel::with('childrens')->get(),
        'wakaf' => Wakaf::all(),
        'dorongan' => Dorongan::all(),
        'contents' => ContentItem::all(),
        'types' => TypeHotel::all(),
    ];

    return view('admin.services.edit', $data);
}

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);



        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);


       // ✅ Update / tambah pesawat
        if ($request->has('rute')) {
            foreach ($request->rute as $i => $rute) {
                $planeId = $request->plane_id[$i] ?? null;
                $plane = Plane::find($planeId);

                if (!$plane) {
                    $plane = new Plane();
                    $plane->service_id = $service->id;
                }

                $plane->tanggal_keberangkatan = $request->tanggal[$i] ?? null;
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
                foreach($request->type as $t => $type){
                    if (empty($namaHotel)) continue;
                    $hotel = $service->hotels()->create([
                        'nama_hotel' => $namaHotel,
                        'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
                        'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                        'type' => $type,
                        'jumlah_kamar' => $request->jumlah_kamar[$i],
                        'harga_perkamar' =>  $request->jumlah_kamar[$i],
                        'jumlah_type' =>  $request->jumlah_type[$i]

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
                $service->tours()->create([
                    'tour_id' => $tourId,
                    'transportation_id' => $transportationId,
                ]);
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
            $document = DocumentModel::findOrFail($docId);

            // Jika dokumen memiliki anak (childrens)
            if ($document->childrens && $document->childrens->count() > 0) {

                // Jika user memilih child document
                if (isset($request->child_documents[$docId])) {
                    foreach ($request->child_documents[$docId] as $childId) {
                        $child = $document->childrens->firstWhere('id', $childId);
                        if ($child) {
                            $jumlah = $request->input("jumlah_doc_child_{$childId}", 1);

                            if ($jumlah > 0) {
                                $service->documents()->create([
                                    'document_id' => $docId,
                                    'document_children_id' => $childId,
                                    'jumlah' => $jumlah,
                                    'harga' => $child->price,
                                    'paspor' => $paspordokumen,
                                    'pas_foto' => $pasfotodokumen

                                ]);
                            }
                        }
                    }
                } else {
                    // Jika tidak ada child dipilih, simpan dokumen induk
                    $jumlah = $request->input("jumlah_doc_{$docId}", 1);

                    if ($jumlah > 0) {
                        $service->documents()->create([
                            'document_id' => $docId,
                            'jumlah' => $jumlah,
                            'harga' => 0,
                             'paspor' => $paspordokumen,
                              'pas_foto' => $pasfotodokumen
                        ]);
                    }
                }
            } else {
                // Dokumen tanpa anak langsung disimpan
                $jumlah = $request->input("jumlah_doc_{$docId}", 1);

                if ($jumlah > 0) {
                    $service->documents()->create([
                        'document_id' => $docId,
                        'jumlah' => $jumlah,
                        'harga' => $document->price,
                        'paspor' => $paspordokumen,
                        'pas_foto' => $pasfotodokumen
                    ]);
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
        } elseif ($request->input('tipe') === 'tumis') {
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
}
