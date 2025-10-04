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
    public function index(Request $request)
    {
        $serviceFilter = $request->get('service'); // transportasi, hotel, dll

        // Tentukan huruf awal kode unik berdasarkan filter service
        $codePrefix = null;
        switch($serviceFilter) {
            case 'transportasi':
                $codePrefix = 'T';
                break;
            case 'hotel':
                $codePrefix = 'H';
                break;
            case 'dokumen':
                $codePrefix = 'D';
                break;
            case 'handling':
                $codePrefix = 'G'; // misal
                break;
            case 'pendamping':
                $codePrefix = 'P';
                break;
            case 'konten':
                $codePrefix = 'K';
                break;
            case 'reyal':
                $codePrefix = 'R';
                break;
            case 'tour':
                $codePrefix = 'O'; // misal
                break;
            case 'meal':
                $codePrefix = 'M';
                break;
            case 'dorongan':
                $codePrefix = 'C'; // misal
                break;
            case 'wakaf':
                $codePrefix = 'W';
                break;
            case 'badal':
                $codePrefix = 'B';
                break;
        }

        // Query Nego
        $negoQuery = Service::where('status', 'nego')
            ->selectRaw('MIN(id) as id,
                         pelanggan_id,
                         MIN(tanggal_keberangkatan) as tanggal_keberangkatan,
                         MIN(tanggal_kepulangan) as tanggal_kepulangan,
                         SUM(total_jamaah) as total_jamaah,
                         GROUP_CONCAT(services) as services,
                         MIN(unique_code) as unique_code,
                         status')
            ->groupBy('pelanggan_id', 'status');

        // Query Deal
        $dealQuery = Service::where('status', 'deal');

        // Filter berdasarkan kode unik jika ada prefix
        if ($codePrefix) {
            $negoQuery->where('unique_code', 'LIKE', $codePrefix.'-%');
            $dealQuery->where('unique_code', 'LIKE', $codePrefix.'-%');
        }

        // Urutkan berdasarkan angka setelah '-'
        $negoQuery->orderByRaw("CAST(SUBSTRING_INDEX(unique_code, '-', -1) AS UNSIGNED)");
        $dealQuery->orderByRaw("CAST(SUBSTRING_INDEX(unique_code, '-', -1) AS UNSIGNED)");

        $nego = $negoQuery->get();
        $deal = $dealQuery->get();

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
        $documents = DocumentModel::with('childrens')->get();
        $wakaf = Wakaf::all();
        $dorongan = Dorongan::all();
        $contents = ContentItem::all();
        $types = TypeHotel::all();
        return view('admin.services.create', compact(
            'pelanggans',
            'transportations',
            'guides',
            'tours',
            'meals',
            'documents',
            'wakaf',
            'dorongan',
            'contents',
            'types'
        ));
    }

    public function show($id)
    {
        $service = Service::with(['pelanggan'])->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    public function store(Request $request)
    {
        // === Perbaikan Logika: Satu Service per Request ===
        // Buat satu entri Service utama untuk seluruh permintaan
        $masterPrefix = 'TRX';
        $lastService = \App\Models\Service::where('unique_code', 'like', $masterPrefix . '-%')
            ->orderBy('id', 'desc')
            ->first();
        $lastNumber = $lastService ? (int) explode('-', $lastService->unique_code)[1] : 0;
        $uniqueCode = $masterPrefix . '-' . ($lastNumber + 1);

        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        $status = $request->action === 'nego' ? 'nego' : 'deal';

        $service = \App\Models\Service::create([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services), // Simpan array sebagai JSON
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
            'unique_code' => $uniqueCode,
        ]);
        
        // --- Memproses setiap layanan yang dipilih dan menyimpannya sebagai relasi ---
        foreach ($request->services as $srv) {
            $srvLower = strtolower($srv);

            switch ($srvLower) {
                case 'hotel':
                    // Perbaikan: Loop untuk hotel
                    if ($request->filled('nama_hotel')) {
                        foreach ($request->nama_hotel as $i => $namaHotel) {
                            if (empty($namaHotel)) continue;
                            
                            $service->hotels()->create([
                                'nama_hotel' => $namaHotel,
                                'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
                                'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                            ]);

                            // Jika ada tipe kamar yang dipilih untuk hotel ini
                            if (isset($request->jumlah_kamar[$i])) {
                                foreach ($request->jumlah_kamar[$i] as $typeId => $jumlah) {
                                    if ($jumlah > 0) {
                                        $hotel->roomTypes()->create([
                                            'type_hotel_id' => $typeId,
                                            'jumlah_kamar' => $jumlah,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'transportasi':
                    // Perbaikan: Logika untuk menyimpan tiket pesawat
                    if ($request->filled('transportation') && in_array('airplane', $request->transportation)) {
                        foreach ($request->tanggal as $j => $tgl) {
                            if ($tgl) {
                                $service->planes()->create([
                                    'tanggal_keberangkatan' => $tgl,
                                    'rute' => $request->rute[$j] ?? null,
                                    'maskapai' => $request->maskapai[$j] ?? null,
                                    'harga' => $request->harga_tiket[$j] ?? null, // Mengambil harga dari form
                                    'keterangan' => $request->keterangan[$j] ?? null,
                                    'jumlah_jamaah' => $request->jumlah[$j] ?? 0,
                                    'tiket_berangkat' => isset($request->file('tiket_berangkat')[$j]) ? $request->file('tiket_berangkat')[$j]->store('tiket', 'public') : null,
                                    'tiket_pulang' => isset($request->file('tiket_pulang')[$j]) ? $request->file('tiket_pulang')[$j]->store('tiket', 'public') : null,
                                ]);
                            }
                        }
                    }

                    // Perbaikan: Logika untuk menyimpan transportasi darat (bus)
                    if ($request->filled('transportation') && in_array('bus', $request->transportation)) {
                        foreach ((array)$request->transportation_id as $index => $busId) {
                            $service->transportationItem()->create([
                                'transportation_id' => $busId,
                                'route_id' => $request->rute_id[$index] ?? null,
                            ]);
                        }
                    }
                    break;
                case 'handling':
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
                    break;
                case 'meals':
                    if ($request->filled('jumlah_meals')) {
                        foreach ($request->jumlah_meals as $mealId => $jumlah) {
                            if ($jumlah > 0) {
                                $service->meals()->create([
                                    'meal_id' => $mealId,
                                    'jumlah' => $jumlah,
                                ]);
                            }
                        }
                    }
                    break;
                case 'pendamping':
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
                    break;
                case 'tour':
                    if ($request->filled('tour_transport')) {
                        foreach ($request->tour_transport as $tourId => $transportationId) {
                            $service->tours()->create([
                                'tour_id' => $tourId,
                                'transportation_id' => $transportationId,
                            ]);
                        }
                    }
                    break;
                case 'dokumen':
                    // Perbaikan: Logika penyimpanan dokumen
                    if ($request->filled('dokumen_id')) { // Gunakan nama input yang lebih konsisten
                        foreach ($request->dokumen_id as $docId) {
                            $document = DocumentModel::find($docId);
                            if (!$document) continue;

                            // Jika dokumen punya anak (misal: vaksin)
                            if ($document->childrens->isNotEmpty()) {
                                if (isset($request->child_documents[$docId])) {
                                    foreach ($request->child_documents[$docId] as $childId) {
                                        $child = $document->childrens->firstWhere('id', $childId);
                                        if ($child) {
                                            $jumlah = $request->input("jumlah_doc_child_{$childId}") ?? 1;
                                            if ($jumlah > 0) {
                                                $service->documents()->create([
                                                    'document_id' => $docId,
                                                    'document_children_id' => $childId,
                                                    'jumlah' => $jumlah,
                                                    'harga' => $child->price,
                                                ]);
                                            }
                                        }
                                    }
                                }
                            } else {
                                // Jika dokumen tidak punya anak
                                $jumlah = $request->input("jumlah_doc_{$docId}") ?? 1;
                                if ($jumlah > 0) {
                                    $service->documents()->create([
                                        'document_id' => $docId,
                                        'jumlah' => $jumlah,
                                        'harga' => $document->price,
                                    ]);
                                }
                            }
                        }
                    }
                    // Simpan file paspor dan pas foto
                    if ($request->hasFile('paspor_dokumen')) {
                        // Anda perlu menentukan bagaimana file ini berelasi.
                        // Mungkin ada model terpisah untuk file. Untuk contoh ini, saya asumsikan
                        // Anda menyimpannya dalam suatu model `DocumentFile` atau sejenisnya.
                    }
                    break;
                case 'reyal':
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
                    break;
                case 'waqaf':
                    if ($request->filled('jumlah_wakaf')) {
                        foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                            if ($jumlah > 0) {
                                $service->wakafs()->create([
                                    'wakaf_id' => $wakafId,
                                    'jumlah' => intval($jumlah),
                                ]);
                            }
                        }
                    }
                    break;
                case 'dorongan':
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
                    break;
                case 'konten':
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
                    break;
                case 'badal':
                    if ($request->filled('nama_badal')) {
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
                    break;
            }
        }
        
        // Buat order
        $totalAmount = (float) $request->input('total_amount', 0);
        $order = Order::create([
            'service_id' => $service->id,
            'total_amount' => $totalAmount,
            'invoice' => 'INV-' . time(),
            'total_yang_dibayarkan' => 0,
            'sisa_hutang' => $totalAmount,
            'status_pembayaran' => $totalAmount == 0 ? 'lunas' : 'belum_bayar',
        ]);
        
        return redirect()->route('service.uploadBerkas', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah
        ])->with('success', 'Data service berhasil disimpan.');
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
        $allServices = Service::where('pelanggan_id', $service->pelanggan_id)
            ->pluck('services')
            ->toArray();
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

        Service::where('pelanggan_id', $oldService->pelanggan_id)
            ->update(['status' => $newStatus]);

        $prefixMap = [
            'hotel' => 'H', 'transportasi' => 'T', 'document' => 'D', 'handling' => 'HDL',
            'pendamping' => 'P', 'konten' => 'K', 'reyal' => 'R', 'tour' => 'TO',
            'meals' => 'M', 'dorongan' => 'DR', 'wakaf' => 'W', 'badal' => 'BD'
        ];

        foreach ($request->services as $srv) {
            $prefix = $prefixMap[$srv] ?? 'S';
            $lastService = Service::where('unique_code', 'like', $prefix . '-%')
                ->orderBy('id', 'desc')
                ->first();
            $number = $lastService ? ((int) explode('-', $lastService->unique_code)[1] + 1) : 1;
            $uniqueCode = $prefix . '-' . $number;

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
        $pasporFiles = $request->file('paspor', []);
        $ktpFiles = $request->file('ktp', []);
        $visaFiles = $request->file('visa', []);

        $totalJamaah = max(
            count($pasFotoFiles),
            count($pasporFiles),
            count($ktpFiles),
            count($visaFiles)
        );

        for ($i = 0; $i < $totalJamaah; $i++) {
            $service->filess()->create([
                'pas_foto' => isset($pasFotoFiles[$i]) ? $pasFotoFiles[$i]->store('documents/pas_foto', 'public') : null,
                'paspor' => isset($pasporFiles[$i]) ? $pasporFiles[$i]->store('documents/paspor', 'public') : null,
                'ktp' => isset($ktpFiles[$i]) ? $ktpFiles[$i]->store('documents/ktp', 'public') : null,
                'visa' => isset($visaFiles[$i]) ? $visaFiles[$i]->store('documents/visa', 'public') : null,
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

    public function destroy($id){
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');
    }

    public function edit($id){
        $pelanggans = Pelanggan::all();
        $transportations = Transportation::all();
        $guides = GuideItems::all();
        $tours = TourItem::all();
        $meals = MealItem::all();
        $documents = DocumentModel::with('childrens')->get();
        $wakaf = Wakaf::all();
        $dorongan = Dorongan::all();
        $contents = ContentItem::all();
        $types = TypeHotel::all();
        $service = Service::findOrFail($id);
        $allServices = Service::where('pelanggan_id', $service->pelanggan_id)
            ->pluck('services')
            ->toArray();
        $selectedServices = collect($allServices)
            ->map(function ($item) {
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->flatten()
            ->unique()
            ->toArray();
        $transportations = Transportation::all();
        return view('admin.services.edit', compact( 'pelanggans',
            'transportations',
            'guides',
            'tours',
            'meals',
            'documents',
            'wakaf',
            'dorongan',
            'contents',
            'types',
            'service',
            'selectedServices'
        ));
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
        
        $status = $request->action === 'nego' ? 'nego' : 'deal';
        
        // Perbaikan: Update service utama di sini
        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);
        
        // Hapus relasi lama sebelum menyimpan relasi baru
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
        
        // Memproses ulang semua layanan
        foreach ($request->services as $srv) {
            $srvLower = strtolower($srv);
            
            // Logika penyimpanan relasi, SAMA DENGAN FUNGSI STORE
            switch ($srvLower) {
                case 'hotel':
                    if ($request->filled('nama_hotel')) {
                        foreach ($request->nama_hotel as $i => $namaHotel) {
                            if (empty($namaHotel)) continue;
                            $service->hotels()->create([
                                'nama_hotel' => $namaHotel,
                                'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
                                'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                            ]);
                            if (isset($request->jumlah_kamar[$i])) {
                                foreach ($request->jumlah_kamar[$i] as $typeId => $jumlah) {
                                    if ($jumlah > 0) {
                                        $hotel->roomTypes()->create(['type_hotel_id' => $typeId, 'jumlah_kamar' => $jumlah]);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'transportasi':
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
                                    'tiket_berangkat' => isset($request->file('tiket_berangkat')[$j]) ? $request->file('tiket_berangkat')[$j]->store('tiket', 'public') : null,
                                    'tiket_pulang' => isset($request->file('tiket_pulang')[$j]) ? $request->file('tiket_pulang')[$j]->store('tiket', 'public') : null,
                                ]);
                            }
                        }
                    }
                    if ($request->filled('transportation') && in_array('bus', $request->transportation)) {
                        foreach ((array)$request->transportation_id as $index => $busId) {
                            $service->transportationItem()->create([
                                'transportation_id' => $busId,
                                'route_id' => $request->rute_id[$index] ?? null,
                            ]);
                        }
                    }
                    break;
                case 'handling':
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
                    break;
                case 'meals':
                    if ($request->filled('jumlah_meals')) {
                        foreach ($request->jumlah_meals as $mealId => $jumlah) {
                            if ($jumlah > 0) {
                                $service->meals()->create(['meal_id' => $mealId, 'jumlah' => $jumlah]);
                            }
                        }
                    }
                    break;
                case 'pendamping':
                    if ($request->filled('jumlah_pendamping')) {
                        foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                            if ($jumlah > 0) {
                                $service->guides()->create([
                                    'guide_id' => $guideId,
                                    'jumlah' => $jumlah,
                                    'keterangan' => $request->input("keterangan_pendamping.{$guideId}") ?? null,
                                ]);
                            }
                        }
                    }
                    break;
                case 'tour':
                    if ($request->filled('tour_transport')) {
                        foreach ($request->tour_transport as $tourId => $transportationId) {
                            $service->tours()->create([
                                'tour_id' => $tourId,
                                'transportation_id' => $transportationId,
                            ]);
                        }
                    }
                    break;
                case 'dokumen':
                    if ($request->filled('dokumen_id')) {
                        foreach ($request->dokumen_id as $docId) {
                            $document = DocumentModel::find($docId);
                            if (!$document) continue;
                            if ($document->childrens->isNotEmpty()) {
                                if (isset($request->child_documents[$docId])) {
                                    foreach ($request->child_documents[$docId] as $childId) {
                                        $child = $document->childrens->firstWhere('id', $childId);
                                        if ($child) {
                                            $jumlah = $request->input("jumlah_doc_child_{$childId}") ?? 1;
                                            if ($jumlah > 0) {
                                                $service->documents()->create(['document_id' => $docId, 'document_children_id' => $childId, 'jumlah' => $jumlah, 'harga' => $child->price]);
                                            }
                                        }
                                    }
                                }
                            } else {
                                $jumlah = $request->input("jumlah_doc_{$docId}") ?? 1;
                                if ($jumlah > 0) {
                                    $service->documents()->create(['document_id' => $docId, 'jumlah' => $jumlah, 'harga' => $document->price]);
                                }
                            }
                        }
                    }
                    break;
                case 'reyal':
                    if ($request->input('tipe') === 'tamis') {
                        $service->reyals()->create([
                            'tipe' => 'tamis', 'jumlah_input' => $request->input('jumlah_rupiah'),
                            'kurs' => $request->input('kurs_tamis'), 'hasil' => $request->input('hasil_tamis'),
                        ]);
                    } elseif ($request->input('tipe') === 'tumis') {
                        $service->reyals()->create([
                            'tipe' => 'tumis', 'jumlah_input' => $request->input('jumlah_reyal'),
                            'kurs' => $request->input('kurs_tumis'), 'hasil' => $request->input('hasil_tumis'),
                        ]);
                    }
                    break;
                case 'wakaf':
                    if ($request->filled('jumlah_wakaf')) {
                        foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                            if ($jumlah > 0) {
                                $service->wakafs()->create(['wakaf_id' => $wakafId, 'jumlah' => intval($jumlah)]);
                            }
                        }
                    }
                    break;
                case 'dorongan':
                    if ($request->filled('jumlah_dorongan')) {
                        foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                            if ($jumlah > 0) {
                                DoronganOrder::create([
                                    'service_id' => $service->id, 'dorongan_id' => $doronganId, 'jumlah' => $jumlah,
                                ]);
                            }
                        }
                    }
                    break;
                case 'konten':
                    if ($request->filled('jumlah_konten')) {
                        foreach ($request->jumlah_konten as $contentId => $jumlah) {
                            if ($jumlah > 0) {
                                ContentCustomer::create([
                                    'service_id' => $service->id, 'content_id' => $contentId,
                                    'jumlah' => $jumlah, 'keterangan' => $request->input("keterangan_konten.{$contentId}"),
                                ]);
                            }
                        }
                    }
                    break;
                case 'badal':
                    if ($request->has('nama_badal')) {
                        foreach ($request->nama_badal as $index => $nama) {
                            if (!empty($nama)) {
                                Badal::create([
                                    'service_id' => $service->id, 'name' => $nama,
                                    'price' => $request->harga_badal[$index] ?? 0,
                                ]);
                            }
                        }
                    }
                    break;
            }
        }

        return redirect()->route('service.uploadBerkas', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah
        ])->with('success', 'Data service berhasil diperbarui.');
    }
}