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
    $query = Service::with('pelanggan');

if ($request->filled('service')) {
    $query->whereJsonContains('services', $request->service);
}

$services = $query->get();

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

    $status = $request->action === 'nego' ? 'nego' : 'deal';

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

        // cek di DB service terakhir dengan prefix ini
        $lastService = Service::where('unique_code', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastService) {
            // ambil nomor terakhir
            $lastNumber = (int) explode('-', $lastService->unique_code)[1];
            $uniqueCode = $prefix . '-' . ($lastNumber + 1);
        } else {
            $uniqueCode = $prefix . '-1';
        }

        // buat service
        $service = Service::create([
            'pelanggan_id' => $request->travel,
            'services' => [$srv],
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
            'unique_code' => $uniqueCode,
        ]);

        // relasi detail
        switch ($srv) {
            case 'hotel':
                foreach ($request->tanggal_checkin as $i => $tglCheckin) {
                    if (!empty($tglCheckin)) {
                        $service->hotels()->create([
                            'tanggal_checkin' => $tglCheckin,
                            'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                            'nama_hotel' => $request->nama_hotel[$i] ?? null,
                            'tipe_kamar' => $request->tipe_kamar[$i] ?? null,
                            'jumlah_kamar' => $request->jumlah_kamar[$i] ?? null,
                            'harga_perkamar' => $request->harga_per_kamar[$i] ?? null,
                            'catatan' => $request->catatan[$i] ?? null,
                        ]);
                    }
                }
                break;

            case 'transportasi':
                if ($request->transportation) {
                    foreach ($request->transportation as $i => $tipe) {
                        if ($tipe === 'airplane') {
                            foreach ($request->tanggal as $j => $tgl) {
                                if (!empty($tgl)) {
                                    $service->planes()->create([
                                        'tanggal_keberangkatan' => $tgl,
                                        'rute' => $request->rute[$j] ?? null,
                                        'maskapai' => $request->maskapai[$j] ?? null,
                                        'harga' => $request->harga[$j] ?? null,
                                        'keterangan' => $request->keterangan[$j] ?? null,
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

            // Tambahkan case lain sesuai kebutuhan (meals, tour, handling, dll)
        }
    }

    return redirect()->route('admin.services')
        ->with('success', 'Data service berhasil disimpan.');
}





    public function nego($id)
    {
        $service = Service::findOrFail($id);
        $transportations = Transportation::all();
        return view('admin.services.nego', ['service' => $service, 'transportations' => $transportations]);
    }
public function updateNego(Request $request, $id)
{
    $oldService = Service::findOrFail($id);
    $newStatus = $request->action === 'nego' ? 'nego' : 'deal';
    $oldService->update(['status' => $newStatus]);

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
        $service = Service::create([
            'pelanggan_id' => $request->travel,
            'services' => [$srv],
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $newStatus,
            'unique_code' => $uniqueCode,
        ]);


        // Tambahkan relasi detail service baru (copas dari store)
        // hotel, transportasi, handling, meals, pendamping, tour, dll.
    }

    return redirect()->route('admin.services')
        ->with('success', 'Data nego berhasil diperbarui.');
}


}
