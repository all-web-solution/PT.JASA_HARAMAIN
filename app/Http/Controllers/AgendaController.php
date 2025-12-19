<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentCustomer;
use App\Models\CustomerDocument;
use App\Models\Guide;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use App\Models\Hotel;
use App\Models\Plane;
use App\Models\TransportationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda.index');
    }

    /**
     * Main function to aggregate all events
     */
    public function getEvents(Request $request)
    {
        $user = Auth::user();
        $events = [];

        $events = array_merge(
            $events,
            $this->getTransportationEvents($user),
            $this->getHotelEvents($user),
            $this->getDocumentEvents($user),
            $this->getHandlingEvents($user),
            $this->getGuideEvents($user),
            $this->getContentEvents($user)
        );

        return response()->json($events);
    }

    // =========================================================================
    // PRIVATE METHODS (MODULAR LOGIC)
    // =========================================================================

    /**
     * 1. TRANSPORTATION & TICKET DIVISION
     */
    private function getTransportationEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'transportasi & tiket'])) {
            return [];
        }

        $events = [];

        // A. TIKET PESAWAT
        $planes = Plane::with('service.pelanggan')->get();
        foreach ($planes as $item) {
            if ($item->tanggal_keberangkatan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';

                $desc = "✈️ DETAIL TIKET PESAWAT\n-------------------\n";
                $desc .= "Maskapai: " . ($item->maskapai ?? '-') . "\n";
                $desc .= "Rute: " . ($item->rute ?? '-') . "\n";
                $desc .= "Tanggal: " . $item->tanggal_keberangkatan . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "✈️ " . ($item->maskapai ?? 'Pesawat') . " ({$item->rute})",
                    'start' => $item->tanggal_keberangkatan,
                    'allDay' => true,
                    'color' => '#0dcaf0',
                    'textColor' => '#000',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        // B. TRANSPORT DARAT
        $landTransports = TransportationItem::with(['service.pelanggan', 'transportation', 'route'])->get();
        foreach ($landTransports as $item) {
            if ($item->dari_tanggal) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $kendaraan = $item->transportation->nama ?? 'Bus';
                $ruteInfo = $item->route->route ?? '-';

                $desc = "🚌 DETAIL TRANSPORT DARAT\n-------------------\n";
                $desc .= "Kendaraan: $kendaraan\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Rute: $ruteInfo\n";
                $desc .= "Periode: " . ($item->dari_tanggal ?? '-') . " s/d " . ($item->sampai_tanggal ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "▶️ START: {$kendaraan} ({$pelanggan})",
                    'start' => $item->dari_tanggal,
                    'allDay' => true,
                    'color' => '#198754',
                    'extendedProps' => ['description' => $desc]
                ];

                if ($item->sampai_tanggal) {
                    $events[] = [
                        'title' => "⏹️ END: {$kendaraan} ({$pelanggan})",
                        'start' => $item->sampai_tanggal,
                        'allDay' => true,
                        'color' => '#6c757d',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 2. HOTEL DIVISION
     */
    private function getHotelEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'hotel'])) {
            return [];
        }

        $events = [];
        $hotels = Hotel::with('service.pelanggan')->get();

        foreach ($hotels as $item) {
            if ($item->tanggal_checkin) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $hotelName = $item->nama_hotel ?? 'Hotel';

                $desc = "🏨 DETAIL HOTEL\n-------------------\n";
                $desc .= "Nama Hotel: $hotelName\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Check-in: " . ($item->tanggal_checkin ?? '-') . "\n";
                $desc .= "Check-out: " . ($item->tanggal_checkout ?? '-') . "\n";
                $desc .= "Tipe Kamar: " . ($item->type ?? '-') . "\n";
                $desc .= "Total Kamar: " . ($item->jumlah_kamar ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? 'Nego') . "\n";
                $desc .= "Catatan: " . ($item->catatan ?? '-') . "\n";

                $events[] = [
                    'title' => "⬇️ IN: {$hotelName}",
                    'start' => $item->tanggal_checkin,
                    'allDay' => true,
                    'backgroundColor' => '#0d6efd',
                    'borderColor' => '#0d6efd',
                    'extendedProps' => ['description' => $desc]
                ];

                if ($item->tanggal_checkout) {
                    $events[] = [
                        'title' => "⬆️ OUT: {$hotelName}",
                        'start' => $item->tanggal_checkout,
                        'allDay' => true,
                        'backgroundColor' => '#dc3545',
                        'borderColor' => '#dc3545',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 3. DOCUMENT DIVISION
     */
    private function getDocumentEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'visa dan acara'])) {
            return [];
        }

        $events = [];
        $rawDocs = CustomerDocument::with(['service.pelanggan', 'document', 'documentChild'])->get();

        // Grouping
        $groupedDocs = $rawDocs->groupBy(function ($item) {
            return $item->service_id . '_' . $item->document_id . '_' . $item->created_at->format('Y-m-d');
        });

        foreach ($groupedDocs as $group) {
            $firstItem = $group->first();
            if (!$firstItem->created_at)
                continue;

            $pelanggan = $firstItem->service->pelanggan->nama_travel ?? 'N/A';
            $jenisDokumen = $firstItem->document->name ?? 'Dokumen';
            $totalPax = $group->sum('jumlah');

            $desc = "📄 DETAIL DOKUMEN\n-------------------\n";
            $desc .= "Jenis: $jenisDokumen\n";
            $desc .= "Customer: $pelanggan\n";
            $desc .= "Total: $totalPax Pax\n";
            $desc .= "Tgl Request: " . $firstItem->created_at->format('d M Y') . "\n";
            $desc .= "Status: " . ($firstItem->status ?? '-') . "\n";
            $desc .= "-------------------\nRincian Item:\n";

            foreach ($group as $detail) {
                $itemName = $detail->documentChild->name ?? $detail->document->name ?? '-';
                $itemPax = $detail->jumlah ?? 0;
                $desc .= "• $itemName: $itemPax Pax\n";
            }

            // Tentukan Warna
            $color = '#6c757d';
            if (stripos($jenisDokumen, 'Visa') !== false)
                $color = '#fd7e14';
            elseif (stripos($jenisDokumen, 'Sisko') !== false)
                $color = '#20c997';
            elseif (stripos($jenisDokumen, 'Vaksin') !== false)
                $color = '#6f42c1';

            $events[] = [
                'title' => "📄 {$jenisDokumen}: {$totalPax} Pax ({$pelanggan})",
                'start' => $firstItem->created_at->format('Y-m-d'),
                'allDay' => true,
                'color' => $color,
                'extendedProps' => ['description' => $desc]
            ];
        }

        return $events;
    }

    /**
     * 4. HANDLING DIVISION (Hotel & Planes)
     */
    private function getHandlingEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];

        // A. HANDLING HOTEL
        $handlingHotels = HandlingHotel::with(['handling.service.pelanggan'])->get();
        foreach ($handlingHotels as $item) {
            if ($item->tanggal) {
                $pelanggan = $item->handling->service->pelanggan->nama_travel ?? 'N/A';
                $hotelName = $item->nama_hotel ?? 'Handling Hotel';

                $kodeBookingDisplay = '-';
                if (!empty($item->kode_booking)) {
                    $fileUrl = asset('storage/' . $item->kode_booking);
                    $kodeBookingDisplay = "<a href='{$fileUrl}' target='_blank' class='text-primary text-decoration-underline'>Lihat File</a>";
                }

                $desc = "🏨 DETAIL HANDLING HOTEL\n-------------------\n";
                $desc .= "Hotel: $hotelName\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Pax: " . ($item->pax ?? '-') . "\n";
                $desc .= "Kode Booking: $kodeBookingDisplay\n";

                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "🏨 H-Hotel: {$hotelName} ({$pelanggan})",
                    'start' => $item->tanggal,
                    'allDay' => true,
                    'color' => '#ffc107',
                    'textColor' => '#000',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        $handlingPlanes = HandlingPlanes::with(['handling.service.pelanggan'])->get();
        foreach ($handlingPlanes as $item) {
            if ($item->kedatangan_jamaah) {
                $pelanggan = $item->handling->service->pelanggan->nama_travel ?? 'N/A';
                $bandara = $item->nama_bandara ?? 'Bandara';
                $supir = $item->nama_supir ?? '-';
                $tglKedatangan = Carbon::parse($item->kedatangan_jamaah);

                $desc = "✈️ DETAIL HANDLING BANDARA\n-------------------\n";
                $desc .= "Bandara: $bandara\n";
                $desc .= "Kedatangan: " . $tglKedatangan->format('d M Y') . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Jamaah: " . ($item->jumlah_jamaah ?? '-') . " Pax\n";
                $desc .= "Sopir: " . $supir . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "🛬 H-Bandara: {$bandara} ({$pelanggan})",
                    'start' => $tglKedatangan->format('Y-m-d'),
                    'allDay' => true,
                    'color' => '#fd7e14',
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 5. GUIDE / MUTHAWIF DIVISION
     */
    private function getGuideEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];
        $guides = Guide::with(['service.pelanggan', 'guideItem'])->get();

        foreach ($guides as $item) {
            if ($item->muthowif_dari) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $namaPendamping = $item->guideItem->nama ?? 'Muthawif';

                $desc = "👳 DETAIL PENDAMPING (MUTHAWIF)\n-------------------\n";
                $desc .= "Nama: $namaPendamping\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Periode: " . date('d M Y', strtotime($item->muthowif_dari));
                if ($item->muthowif_sampai) {
                    $desc .= " s/d " . date('d M Y', strtotime($item->muthowif_sampai));
                }
                $desc .= "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "▶️ START: 👳 {$namaPendamping} ({$pelanggan})",
                    'start' => $item->muthowif_dari,
                    'allDay' => true,
                    'color' => '#6610f2',
                    'extendedProps' => ['description' => $desc]
                ];

                if ($item->muthowif_sampai) {
                    $events[] = [
                        'title' => "⏹️ END: 👳 {$namaPendamping}",
                        'start' => $item->muthowif_sampai,
                        'allDay' => true,
                        'color' => '#6c757d',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 6. CONTENT & DOCUMENTATION DIVISION
     */
    private function getContentEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'konten dan dokumentasi'])) {
            return [];
        }

        $events = [];
        $contents = ContentCustomer::with(['service.pelanggan', 'content'])->get();

        foreach ($contents as $item) {
            if ($item->tanggal_pelaksanaan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $namaKonten = $item->content->name ?? 'Dokumentasi';

                $desc = "📸 DETAIL KONTEN & DOKUMENTASI\n-------------------\n";
                $desc .= "Paket: $namaKonten\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal_pelaksanaan)) . "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "📸 {$namaKonten} ({$pelanggan})",
                    'start' => $item->tanggal_pelaksanaan,
                    'allDay' => true,
                    'color' => '#17a2b8',
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }
}
