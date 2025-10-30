@extends('admin.master')
@section('title', 'Edit Permintaan Service')
@push('styles')
    <style>
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --haramain-accent: #3d8bfd;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --checked-color: #2a6fdb;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        .service-create-container { max-width: 100vw; margin: 0 auto; padding: 2rem; background-color: #f8fafd; }
        .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid var(--border-color); margin-bottom: 2rem; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); }
        .card-header { background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%); border-bottom: 1px solid var(--border-color); padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-weight: 700; color: var(--haramain-primary); margin: 0; font-size: 1.25rem; display: flex; align-items: center; gap: 12px; }
        .card-title i { font-size: 1.5rem; color: var(--haramain-secondary); }
        .card-body { padding: 1.5rem; }
        .form-section { margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .form-section:last-of-type { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
        .form-section-title { font-size: 1.1rem; color: var(--haramain-primary); margin-bottom: 1rem; display: flex; align-items: center; gap: 8px; }
        .form-section-title i { color: var(--haramain-secondary); }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary); }
        .form-control, .form-select { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease; background-color: #fff; }
        .form-control:focus, .form-select:focus { outline: none; border-color: var(--haramain-secondary); box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1); }
        .form-control[readonly] { background-color: #e9ecef; }
        .form-row { display: flex; gap: 1rem; margin-bottom: 1rem; }
        .form-col { flex: 1; }
        .service-grid, .cars, .tours { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .service-item, .transport-item, .type-item, .service-car, .handling-item, .document-item, .child-item, .content-item, .pendamping-item, .meal-item, .dorongan-item, .wakaf-item, .transport-option, .service-tour { border: 2px solid var(--border-color); border-radius: 8px; padding: 1.25rem; text-align: center; cursor: pointer; transition: all 0.3s ease; background-color: white; }
        .service-item:hover, .transport-item:hover, .type-item:hover, .service-car:hover, .handling-item:hover, .document-item:hover, .child-item:hover, .content-item:hover, .pendamping-item:hover, .meal-item:hover, .dorongan-item:hover, .wakaf-item:hover, .transport-option:hover, .service-tour:hover { border-color: var(--haramain-secondary); transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .service-item.selected, .transport-item.selected, .type-item.selected, .handling-item.selected, .service-car.selected, .document-item.selected, .child-item.selected, .content-item.selected, .pendamping-item.selected, .meal-item.selected, .dorongan-item.selected, .wakaf-item.selected, .transport-option.selected, .service-tour.selected { border-color: var(--haramain-secondary); background-color: var(--haramain-light); }
        .service-icon { font-size: 2rem; color: var(--haramain-secondary); margin-bottom: 0.75rem; }
        .service-name { font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; }
        .service-desc { font-size: 0.875rem; color: var(--text-secondary); }
        .detail-form { background-color: var(--haramain-light); border-radius: 8px; padding: 1.5rem; margin-top: 1.5rem; }
        .detail-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .detail-section:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .detail-title { font-weight: 600; color: var(--haramain-primary); margin-bottom: 1rem; display: flex; align-items: center; gap: 8px; }
        .detail-title i { color: var(--haramain-secondary); }
        .btn { padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; border: none; cursor: pointer; }
        .btn-sm { padding: 0.5rem 1rem; font-size: 0.875rem; }
        .btn-danger { background-color: var(--danger-color); color: white; }
        .btn-danger:hover { opacity: 0.85; }
        .btn-primary { background-color: var(--haramain-secondary); color: white; }
        .btn-primary:hover { background-color: var(--haramain-primary); }
        .btn-secondary { background-color: white; color: var(--text-secondary); border: 1px solid var(--border-color); }
        .btn-secondary:hover { background-color: #f8f9fa; }
        .form-actions { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
        .hidden { display: none !important; }
        .card-reyal.selected { border: 2px solid var(--haramain-secondary); background-color: var(--haramain-light); }
        @media (max-width: 768px) {
            .form-row { flex-direction: column; gap: 0; }
            .service-grid, .cars, .tours { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
@endpush
@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-pencil-square"></i> Edit Permintaan Service
                </h5>
                <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div
                            style="background-color: #fde8e8; border: 1px solid var(--danger-color); color: #9b1c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            <h6 style="color: #9b1c1c; margin-top: 0; margin-bottom: 0.75rem; font-weight: 700;">
                                <i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan
                            </h6>
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- SECTION: DATA TRAVEL --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-select" name="travel" id="travel-select">
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                                data-email="{{ $pelanggan->email }}" data-telepon="{{ $pelanggan->phone }}"
                                                {{ $pelanggan->id == $service->pelanggan_id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_travel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly id="penanggung"
                                        value="{{ $service->pelanggan->penanggung_jawab }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" readonly id="email"
                                        value="{{ $service->pelanggan->email }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" readonly id="phone"
                                        value="{{ $service->pelanggan->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required
                                        value="{{ $service->tanggal_keberangkatan }}"> {{-- Fix: Format date --}}
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ $service->tanggal_kepulangan }}"> {{-- Fix: Format date --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ $service->total_jamaah }}">
                        </div>
                    </div>

                    {{-- PHP LOGIC TO PREPARE DATA --}}
                    @php
                        // $selectedServices ada dari controller
                        $existingPlanes = $service->planes;
                        $existingTransports = $service->transportationItem;
                        $existingHotels = $service->hotels;
                        $existingBadals = $service->badals;

                        // PERBAIKAN: Ambil seluruh objek pivot, diindeks oleh ID master
                        $selectedGuides = $service->guides?->keyBy('guide_id') ?? collect();
                        $selectedMeals = $service->meals?->keyBy('meal_id') ?? collect();
                        $selectedDorongan = $service->dorongans?->keyBy('dorongan_id') ?? collect();
                        $selectedWakaf = $service->wakafs?->keyBy('wakaf_id') ?? collect();
                        $selectedContents = $service->contents?->keyBy('content_id') ?? collect();
                        $selectedTours = $service->tours?->keyBy('tour_id') ?? collect();

                        // Untuk Dokumen
                        $customerDocs = $service->documents;

                        $selectedDocParents = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->pluck('document_id')
                            ->unique()
                            ->toArray();

                        $selectedDocChildren = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->document_children_id => [
                                        'jumlah' => $item->jumlah,
                                        'id' => $item->id,
                                    ],
                                ];
                            })
                            ->all();

                        $selectedBaseDocs = $customerDocs
                            ->whereNull('document_children_id')
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->document_id => [
                                        'jumlah' => $item->jumlah,
                                        'id' => $item->id,
                                    ],
                                ];
                            })
                            ->all();

                        $allSelectedDocItems = array_merge($selectedDocParents, array_keys($selectedBaseDocs));

                        // Untuk Handling
                        $existingHandlingHotel = $service->handlingHotel;
                        $existingHandlingPlanes = $service->handlingPlanes;

                        // Untuk Reyal
                        $existingReyal = $service->reyal;
                    @endphp

                    {{-- SECTION: SERVICE SELECTION --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                        </h6>
                        <div class="service-grid">
                            @foreach ([
            'transportasi' => ['icon' => 'bi-airplane', 'name' => 'Transportasi'],
            'hotel' => ['icon' => 'bi-building', 'name' => 'Hotel'],
            'dokumen' => ['icon' => 'bi-file-text', 'name' => 'Dokumen'],
            'handling' => ['icon' => 'bi-briefcase', 'name' => 'Handling'],
            'pendamping' => ['icon' => 'bi-people', 'name' => 'Muthowif'], // {{-- Ganti nama --}}
            'konten' => ['icon' => 'bi-camera', 'name' => 'Konten'],
            'reyal' => ['icon' => 'bi-currency-exchange', 'name' => 'Reyal'],
            'tour' => ['icon' => 'bi-geo-alt', 'name' => 'Tour'],
            'meals' => ['icon' => 'bi-egg-fried', 'name' => 'Meals'],
            'dorongan' => ['icon' => 'bi-basket', 'name' => 'Dorongan'],
            'waqaf' => ['icon' => 'bi-gift', 'name' => 'Waqaf'],
            'badal' => ['icon' => 'bi-gift', 'name' => 'Badal Umrah'],
        ] as $key => $serviceInfo)
                                <div class="service-item {{ in_array($key, $selectedServices) ? 'selected' : '' }}"
                                    data-service="{{ $key }}">
                                    <div class="service-icon"><i class="bi {{ $serviceInfo['icon'] }}"></i></div>
                                    <div class="service-name">{{ $serviceInfo['name'] }}</div>
                                    <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none"
                                        {{ in_array($key, $selectedServices) ? 'checked' : '' }}>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SECTION: DETAIL FORMS --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>

                        {{-- TRANSPORTASI FORM --}}
                        <div class="detail-form {{ in_array('transportasi', $selectedServices) ? '' : 'hidden' }}"
                            id="transportasi-details">
                            <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="transport-item {{ !$existingPlanes->isEmpty() ? 'selected' : '' }}"
                                        data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation_types[]" value="airplane"
                                            class="d-none" {{ !$existingPlanes->isEmpty() ? 'checked' : '' }}>
                                    </div>
                                    <div class="transport-item {{ !$existingTransports->isEmpty() ? 'selected' : '' }}"
                                        data-transportasi="bus">
                                        <div class="service-name">Transportasi Darat</div>
                                        <input type="checkbox" name="transportation_types[]" value="bus"
                                            class="d-none" {{ !$existingTransports->isEmpty() ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="form-group {{ $existingPlanes->isEmpty() ? 'hidden' : '' }}" id="pesawat"
                                    data-transportasi="airplane">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary mb-3" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        @forelse($existingPlanes as $plane)
                                            <div class="ticket-form bg-white p-3 border mb-3">
                                                <input type="hidden" name="plane_id[]" value="{{ $plane->id }}">
                                                <div class="row g-3">
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Tanggal</label><input
                                                            type="date" class="form-control" name="tanggal[]"
                                                            value="{{ $plane->tanggal_keberangkatan }}"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Rute</label><input
                                                            type="text" class="form-control" name="rute[]"
                                                            value="{{ $plane->rute }}"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Maskapai</label><input
                                                            type="text" class="form-control" name="maskapai[]"
                                                            value="{{ $plane->maskapai }}"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Keterangan</label><input
                                                            type="text" class="form-control" name="keterangan[]"
                                                            value="{{ $plane->keterangan }}"></div>
                                                    <div class="col-12"><label class="form-label">Jumlah
                                                            (Jamaah)
                                                        </label><input type="number" class="form-control"
                                                            name="jumlah[]" value="{{ $plane->jumlah_jamaah }}"></div>
                                                </div>
                                                <div class="mt-3 text-end"><button type="button"
                                                        class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                            </div>
                                        @empty
                                            <div class="ticket-form bg-white p-3 border mb-3">
                                                <input type="hidden" name="plane_id[]" value="">
                                                <div class="row g-3">
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Tanggal</label><input
                                                            type="date" class="form-control" name="tanggal[]"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Rute</label><input
                                                            type="text" class="form-control" name="rute[]"
                                                            placeholder="Contoh: CGK - JED"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Maskapai</label><input
                                                            type="text" class="form-control" name="maskapai[]"></div>
                                                    <div class="col-md-6"><label
                                                            class="form-label fw-semibold">Keterangan</label><input
                                                            type="text" class="form-control" name="keterangan[]">
                                                    </div>
                                                    <div class="col-12"><label class="form-label">Jumlah
                                                            (Jamaah)</label><input type="number" class="form-control"
                                                            name="jumlah[]"></div>
                                                </div>
                                                <div class="mt-3 text-end"><button type="button"
                                                        class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="form-group {{ $existingTransports->isEmpty() ? 'hidden' : '' }}"
                                    id="bis" data-transportasi="bus">
                                    <label class="form-label">Transportasi darat</label>
                                    <button type="button" class="btn btn-primary btn-sm mb-3"
                                        id="add-transport-btn">Tambah
                                        Transportasi</button>
                                    <div id="new-transport-forms">
                                        @forelse($existingTransports as $index => $transport)
                                            <div class="transport-set card p-3 mt-3" data-index="{{ $index }}">
                                                <input type="hidden" name="item_id[]" value="{{ $transport->id }}">
                                                <div class="cars">
                                                    @foreach ($transportations as $data)
                                                        <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}"
                                                            data-id="{{ $data->id }}"
                                                            data-routes='@json($data->routes)'
                                                            data-name="{{ $data->nama }}"
                                                            data-price="{{ $data->harga }}">
                                                            <div class="service-name">{{ $data->nama }}</div>
                                                            <input type="radio"
                                                                name="transportation_id[{{ $index }}]"
                                                                value="{{ $data->id }}" class="d-none"
                                                                {{ $data->id == $transport->transportation_id ? 'checked' : '' }}>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="route-select mt-3">
                                                    <label class="form-label">Pilih Rute:</label>
                                                    <select name="rute_id[{{ $index }}]" class="form-select">
                                                        @if ($transport->transportation)
                                                            @foreach ($transport->transportation->routes as $route)
                                                                <option value="{{ $route->id }}"
                                                                    {{ $route->id == $transport->route_id ? 'selected' : '' }}>
                                                                    {{ $route->route }} - Rp.
                                                                    {{ number_format($route->price) }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">-- Pilih Tipe Transportasi Dulu --
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>

                                                {{-- BARIS BARU: Input Tanggal Transportasi Darat --}}
                                                <div class="form-row mt-3">
                                                    <div class="form-col">
                                                        <label class="form-label">Dari Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            name="transport_dari[]"
                                                            value="{{ $transport->dari_tanggal }}">
                                                    </div>
                                                    <div class="form-col">
                                                        <label class="form-label">Sampai Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            name="transport_sampai[]"
                                                            value="{{ $transport->sampai_tanggal }}">
                                                    </div>
                                                </div>
                                                {{-- AKHIR BARIS BARU --}}

                                                <div class="mt-2 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="transport-set card p-3 mt-3" data-index="0">
                                                <input type="hidden" name="item_id[]" value="">
                                                <div class="cars">
                                                    @foreach ($transportations as $data)
                                                        <div class="service-car" data-id="{{ $data->id }}"
                                                            data-routes='@json($data->routes)'
                                                            data-name="{{ $data->nama }}"
                                                            data-price="{{ $data->harga }}">
                                                            <div class="service-name">{{ $data->nama }}</div>
                                                            <input type="radio" name="transportation_id[0]"
                                                                value="{{ $data->id }}" class="d-none">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="route-select mt-3 hidden">
                                                    <label class="form-label">Pilih Rute:</label>
                                                    <select name="rute_id[0]" class="form-select">
                                                        <option value="">-- Pilih Rute --</option>
                                                    </select>
                                                </div>

                                                {{-- BARIS BARU: Input Tanggal Transportasi Darat --}}
                                                <div class="form-row mt-3">
                                                    <div class="form-col">
                                                        <label class="form-label">Dari Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            name="transport_dari[]">
                                                    </div>
                                                    <div class="form-col">
                                                        <label class="form-label">Sampai Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            name="transport_sampai[]">
                                                    </div>
                                                </div>
                                                {{-- AKHIR BARIS BARU --}}

                                                <div class="mt-2 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HOTEL FORM --}}
                        <div class="detail-form {{ in_array('hotel', $selectedServices) ? '' : 'hidden' }}"
                            id="hotel-details">
                            <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addHotel">Tambah
                                Hotel</button>
                            <div id="hotelWrapper">
                                @forelse($existingHotels as $index => $hotel)
                                    <div class="hotel-form bg-white p-3 border mb-3" data-index="{{ $index }}">
                                        <input type="hidden" name="hotel_id[]" value="{{ $hotel->id }}">
                                        <div class="row g-3">
                                            <div class="col-md-6"><label
                                                    class="form-label fw-semibold">Checkin</label><input type="date"
                                                    class="form-control" name="tanggal_checkin[]"
                                                    value="{{ $hotel->tanggal_checkin }}"></div>
                                            <div class="col-md-6"><label
                                                    class="form-label fw-semibold">Checkout</label><input type="date"
                                                    class="form-control" name="tanggal_checkout[]"
                                                    value="{{ $hotel->tanggal_checkout }}"></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Nama
                                                    Hotel</label><input type="text" class="form-control"
                                                    name="nama_hotel[]" placeholder="Nama hotel"
                                                    value="{{ $hotel->nama_hotel }}"></div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Tipe Kamar</label>
                                                <select class="form-select" name="type_hotel[]">
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->nama_tipe }}"
                                                            {{ $hotel->type == $type->nama_tipe ? 'selected' : '' }}>
                                                            {{ $type->nama_tipe }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Jumlah Tipe</label>
                                                <input type="number" class="form-control" name="jumlah_type[]"
                                                    min="0" value="{{ $hotel->jumlah_type }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Jumlah Kamar</label>
                                                <input type="number" class="form-control" name="jumlah_kamar[]"
                                                    min="0" value="{{ $hotel->jumlah_kamar }}">
                                            </div>

                                        </div>
                                        <div class="mt-3 text-end"><button type="button"
                                                class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                    </div>
                                @empty
                                    <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
                                        <input type="hidden" name="hotel_id[]" value="">
                                        <div class="row g-3">
                                            <div class="col-md-6"><label
                                                    class="form-label fw-semibold">Checkin</label><input type="date"
                                                    class="form-control" name="tanggal_checkin[]"></div>
                                            <div class="col-md-6"><label
                                                    class="form-label fw-semibold">Checkout</label><input type="date"
                                                    class="form-control" name="tanggal_checkout[]"></div>
                                            <div class="col-12"><label class="form-label fw-semibold">Nama
                                                    Hotel</label><input type="text" class="form-control"
                                                    name="nama_hotel[]" placeholder="Nama hotel"></div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Tipe Kamar</label>
                                                <select class="form-select" name="type_hotel[]">
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->nama_tipe }}">{{ $type->nama_tipe }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Jumlah Tipe</label>
                                                <input type="number" class="form-control" name="jumlah_type[]"
                                                    min="0" value="0">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Jumlah Kamar</label>
                                                <input type="number" class="form-control" name="jumlah_kamar[]"
                                                    min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="mt-3 text-end"><button type="button"
                                                class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- DOKUMEN FORM --}}
                        <div class="detail-form {{ in_array('dokumen', $selectedServices) ? '' : 'hidden' }}"
                            id="dokumen-details">
                            <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($documents as $document)
                                        <div class="document-item {{ in_array($document->id, $allSelectedDocItems) ? 'selected' : '' }}"
                                            data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}">
                                            <div class="service-name">{{ $document->nama_dokumen }}</div>

                                            <input type="checkbox" name="dokumen_parent_id[]"
                                                value="{{ $document->id }}"
                                                {{ in_array($document->id, $allSelectedDocItems) ? 'checked' : '' }}
                                                class="d-none">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="document-forms-container">
                                @foreach ($documents as $document)
                                    @if ($document->childrens->isNotEmpty())
                                        {{-- Form untuk Dokumen DENGAN ANAK --}}
                                        <div class="form-group {{ in_array($document->id, $allSelectedDocItems) ? '' : 'hidden' }} document-child-form"
                                            data-parent-id="{{ $document->id }}">
                                            <label class="form-label fw-bold">{{ $document->nama_dokumen }}</label>
                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    <div class="child-item {{ array_key_exists($child->id, $selectedDocChildren) ? 'selected' : '' }}"
                                                        data-child-id="{{ $child->id }}">
                                                        <div class="service-name">{{ $child->nama_dokumen }}</div>
                                                        <div class="service-desc">Rp. {{ number_format($child->harga) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="child-forms-wrapper mt-3">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        $selectedChildData = $selectedDocChildren[$child->id] ?? null;
                                                    @endphp
                                                    <div id="doc-child-form-{{ $child->id }}"
                                                        class="form-group mt-2 bg-white p-3 border rounded {{ $selectedChildData ? '' : 'hidden' }}">

                                                        <input type="hidden" name="customer_document_id[]"
                                                            value="{{ $selectedChildData['id'] ?? '' }}">

                                                        <input type="hidden" class="dokumen_id_input"
                                                            name="dokumen_id[]" value="{{ $child->id }}"
                                                            {{ !$selectedChildData ? 'disabled' : '' }}>

                                                        <label class="form-label">Jumlah
                                                            {{ $child->nama_dokumen }}</label>
                                                        <input type="number" class="form-control jumlah_doc_child_input"
                                                            name="jumlah_doc_child[]" min="1"
                                                            value="{{ $selectedChildData['jumlah'] ?? 1 }}"
                                                            {{ !$selectedChildData ? 'disabled' : '' }}>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        {{-- Form untuk Dokumen BIASA (TANPA ANAK) --}}
                                        @php
                                            $selectedBaseData = $selectedBaseDocs[$document->id] ?? null;
                                        @endphp
                                        <div class="form-group {{ $selectedBaseData ? '' : 'hidden' }} document-base-form"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}">

                                            <input type="hidden" name="customer_document_id[]"
                                                value="{{ $selectedBaseData['id'] ?? '' }}">

                                            <input type="hidden" class="dokumen_id_input" name="dokumen_id[]"
                                                value="{{ $document->id }}" {{ !$selectedBaseData ? 'disabled' : '' }}>

                                            <label class="form-label fw-bold">Jumlah {{ $document->nama_dokumen }}</label>
                                            <input type="number" class="form-control jumlah_doc_child_input"
                                                name="jumlah_doc_child[]" min="1"
                                                value="{{ $selectedBaseData['jumlah'] ?? 1 }}"
                                                {{ !$selectedBaseData ? 'disabled' : '' }}>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- HANDLING FORM --}}
                        <div class="detail-form {{ in_array('handling', $selectedServices) ? '' : 'hidden' }}"
                            id="handling-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="handling-item {{ $existingHandlingHotel ? 'selected' : '' }}"
                                        data-handling="hotel">
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" class="d-none"
                                            {{ $existingHandlingHotel ? 'checked' : '' }}>
                                    </div>
                                    <div class="handling-item {{ $existingHandlingPlanes ? 'selected' : '' }}"
                                        data-handling="bandara">
                                        <div class="service-name">Bandara</div>
                                        <input type="checkbox" name="handlings[]" value="bandara" class="d-none"
                                            {{ $existingHandlingPlanes ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $existingHandlingHotel ? '' : 'hidden' }}"
                                id="hotel-handling-form">
                                <input type="hidden" name="handling_hotel_id"
                                    value="{{ $existingHandlingHotel?->id }}">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Hotel</label><input
                                            type="text" class="form-control" name="nama_hotel_handling"
                                            value="{{ $existingHandlingHotel?->nama }}"></div>
                                    <div class="form-col"><label class="form-label">Tanggal</label><input type="date"
                                            class="form-control" name="tanggal_hotel_handling"
                                            value="{{ $existingHandlingHotel?->tanggal?->format('Y-m-d') }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_hotel_handling"
                                            value="{{ $existingHandlingHotel?->harga }}"></div>
                                    <div class="form-col"><label class="form-label">Pax</label><input type="text"
                                            class="form-control" name="pax_hotel_handling"
                                            value="{{ $existingHandlingHotel?->pax }}"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kode Booking</label><input type="file"
                                        class="form-control" name="kode_booking_hotel_handling">
                                    <label class="form-label">Room List</label><input type="file" class="form-control"
                                        name="rumlis_hotel_handling">
                                    <label class="form-label">Identitas Koper</label><input type="file"
                                        class="form-control" name="identitas_hotel_handling">
                                </div>
                            </div>
                            <div class="form-group {{ $existingHandlingPlanes ? '' : 'hidden' }}"
                                id="bandara-handling-form">
                                <input type="hidden" name="handling_bandara_id"
                                    value="{{ $existingHandlingPlanes?->id }}">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Bandara</label><input
                                            type="text" class="form-control" name="nama_bandara_handling"
                                            value="{{ $existingHandlingPlanes?->nama_bandara }}"></div>
                                    <div class="form-col"><label class="form-label">Jumlah Jamaah</label><input
                                            type="text" class="form-control" name="jumlah_jamaah_handling"
                                            value="{{ $existingHandlingPlanes?->jumlah_jamaah }}"></div>
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_bandara_handling"
                                            value="{{ $existingHandlingPlanes?->harga }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Kedatangan Jamaah</label><input
                                            type="date" class="form-control" name="kedatangan_jamaah_handling"
                                            value="{{ $existingHandlingPlanes?->kedatangan_jamaah?->format('Y-m-d') }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Paket Info</label><input
                                            type="file" class="form-control" name="paket_info"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Sopir</label><input
                                            type="text" class="form-control" name="nama_supir"
                                            value="{{ $existingHandlingPlanes?->nama_supir }}"></div>
                                    <div class="form-col"><label class="form-label">Identitas Koper</label><input
                                            type="file" class="form-control" name="identitas_koper_bandara_handling">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING (MUTHOWIF) FORM --}}
                        <div class="detail-form {{ in_array('pendamping', $selectedServices) ? '' : 'hidden' }}"
                            id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-people"></i> Muthowif</h6>
                            <div class="service-grid">
                                @foreach ($guides as $guide)
                                    <div class="pendamping-item {{ $selectedGuides->has($guide->id) ? 'selected' : '' }}"
                                        data-id="{{ $guide->id }}" data-type="pendamping">
                                        <div class="service-name">{{ $guide->nama }}</div>
                                        <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    @php $selectedGuide = $selectedGuides->get($guide->id); @endphp
                                    <div id="form-pendamping-{{ $guide->id }}"
                                        class="form-group {{ $selectedGuide ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $guide->nama }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="0"
                                            value="{{ $selectedGuide ? $selectedGuide->jumlah : 0 }}">

                                        {{-- BARIS BARU: Input Tanggal Muthowif --}}
                                        <div class="form-row mt-3">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="pendamping_dari[{{ $guide->id }}]"
                                                    value="{{ $selectedGuide ? $selectedGuide->tanggal_dari?->format('Y-m-d') : '' }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="pendamping_sampai[{{ $guide->id }}]"
                                                    value="{{ $selectedGuide ? $selectedGuide->tanggal_sampai?->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                        {{-- AKHIR BARIS BARU --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form {{ in_array('konten', $selectedServices) ? '' : 'hidden' }}"
                            id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-camera"></i> Konten</h6>
                            <div class="service-grid">
                                @foreach ($contents as $content)
                                    <div class="content-item {{ $selectedContents->has($content->id) ? 'selected' : '' }}"
                                        data-id="{{ $content->id }}" data-type="konten">
                                        <div class="service-name">{{ $content->nama }}</div>
                                        <div class="service-desc">Rp {{ number_format($content->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    @php $selectedContent = $selectedContents->get($content->id); @endphp
                                    <div id="form-konten-{{ $content->id }}"
                                        class="form-group {{ $selectedContent ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $content->nama }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_konten[{{ $content->id }}]" min="0"
                                            value="{{ $selectedContent ? $selectedContent->jumlah : 0 }}">

                                        {{-- BARIS BARU: Input Tanggal Konten --}}
                                        <label class="form-label mt-2">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control"
                                            name="konten_tanggal[{{ $content->id }}]"
                                            value="{{ $selectedContent ? $selectedContent->tanggal_pelaksanaan?->format('Y-m-d') : '' }}">
                                        {{-- AKHIR BARIS BARU --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form {{ in_array('reyal', $selectedServices) ? '' : 'hidden' }}"
                            id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-currency-exchange"></i> Reyal</h6>
                            <div class="detail-section">
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Field 1 (contoh)</label>
                                        <input type="text" class="form-control" name="reyal_field_1"
                                            value="{{ $existingReyal?->field_1 }}">
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Field 2 (contoh)</label>
                                        <input type="text" class="form-control" name="reyal_field_2"
                                            value="{{ $existingReyal?->field_2 }}">
                                    </div>
                                </div>
                                {{-- BARIS BARU: Input Tanggal Reyal --}}
                                <div class="form-group mt-3">
                                    <label class="form-label">Tanggal Penyerahan ke Travel</label>
                                    <input type="date" class="form-control" name="tanggal_penyerahan_reyal"
                                        value="{{ $existingReyal?->tanggal_penyerahan?->format('Y-m-d') }}">
                                </div>
                                {{-- AKHIR BARIS BARU --}}
                            </div>
                        </div>


                        {{-- TOUR FORM --}}
                        <div class="detail-form {{ in_array('tour', $selectedServices) ? '' : 'hidden' }}"
                            id="tour-details">
                            <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            <div class="detail-section">
                                <div class="tours service-grid">
                                    @foreach ($tours as $tour)
                                        <div class="service-tour {{ $selectedTours->has($tour->id) ? 'selected' : '' }}"
                                            data-id="{{ $tour->id }}">
                                            <div class="service-name">{{ $tour->name }}</div>
                                            <input type="checkbox" name="tour_id[]" value="{{ $tour->id }}"
                                                class="d-none" {{ $selectedTours->has($tour->id) ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tours as $tour)
                                @php
                                    $selectedTourData = $selectedTours->get($tour->id);
                                @endphp
                                <div id="tour-{{ $tour->id }}-form"
                                    class="tour-form detail-section {{ $selectedTourData ? '' : 'hidden' }}">
                                    <h6 class="fw-bold mb-3">Transportasi untuk {{ $tour->name }}</h6>
                                    <div class="transport-options service-grid">
                                        @foreach ($transportations as $trans)
                                            @php
                                                $isSelectedTour =
                                                    $selectedTourData &&
                                                    $selectedTourData->transportation_id == $trans->id;
                                            @endphp
                                            <div class="transport-option {{ $isSelectedTour ? 'selected' : '' }}"
                                                data-tour-id="{{ $tour->id }}"
                                                data-trans-id="{{ $trans->id }}">
                                                <div class="service-name">{{ $trans->nama }}</div>
                                                <input type="radio" name="tour_transport[{{ $tour->id }}]"
                                                    value="{{ $trans->id }}" class="d-none"
                                                    {{ $isSelectedTour ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        {{-- MEALS FORM --}}
                        <div class="detail-form {{ in_array('meals', $selectedServices) ? '' : 'hidden' }}"
                            id="meals-details">
                            <h6 class="detail-title"><i class="bi bi-egg-fried"></i> Makanan</h6>
                            <div class="service-grid">
                                @foreach ($meals as $meal)
                                    <div class="meal-item {{ $selectedMeals->has($meal->id) ? 'selected' : '' }}"
                                        data-id="{{ $meal->id }}" data-type="meal">
                                        <div class="service-name">{{ $meal->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($meals as $meal)
                                    @php $selectedMeal = $selectedMeals->get($meal->id); @endphp
                                    <div id="form-meal-{{ $meal->id }}"
                                        class="form-group {{ $selectedMeal ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $meal->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_meals[{{ $meal->id }}]" min="0"
                                            value="{{ $selectedMeal ? $selectedMeal->jumlah : 0 }}">

                                        {{-- BARIS BARU: Input Tanggal Meals --}}
                                        <div class="form-row mt-3">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_dari[{{ $meal->id }}]"
                                                    value="{{ $selectedMeal ? $selectedMeal->tanggal_dari?->format('Y-m-d') : '' }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_sampai[{{ $meal->id }}]"
                                                    value="{{ $selectedMeal ? $selectedMeal->tanggal_sampai?->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                        {{-- AKHIR BARIS BARU --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DORONGAN FORM --}}
                        <div class="detail-form {{ in_array('dorongan', $selectedServices) ? '' : 'hidden' }}"
                            id="dorongan-details">
                            <h6 class="detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                            <div class="service-grid">
                                @foreach ($dorongan as $item)
                                    <div class="dorongan-item {{ $selectedDorongan->has($item->id) ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="dorongan">
                                        <div class="service-name">{{ $item->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($dorongan as $item)
                                    @php $selectedItem = $selectedDorongan->get($item->id); @endphp
                                    <div id="form-dorongan-{{ $item->id }}"
                                        class="form-group {{ $selectedItem ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_dorongan[{{ $item->id }}]" min="0"
                                            value="{{ $selectedItem ? $selectedItem->jumlah : 0 }}">

                                        {{-- BARIS BARU: Input Tanggal Dorongan --}}
                                        <label class="form-label mt-2">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control"
                                            name="dorongan_tanggal[{{ $item->id }}]"
                                            value="{{ $selectedItem ? $selectedItem->tanggal_pelaksanaan : '' }}">
                                        {{-- AKHIR BARIS BARU --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WAQAF FORM --}}
                        <div class="detail-form {{ in_array('waqaf', $selectedServices) ? '' : 'hidden' }}"
                            id="waqaf-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Waqaf</h6>
                            <div class="service-grid">
                                @foreach ($wakaf as $item)
                                    <div class="wakaf-item {{ $selectedWakaf->has($item->id) ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="wakaf">
                                        <div class="service-name">{{ $item->nama }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($wakaf as $item)
                                    @php $selectedItem = $selectedWakaf->get($item->id); @endphp
                                    <div id="form-wakaf-{{ $item->id }}"
                                        class="form-group {{ $selectedItem ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->nama }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_wakaf[{{ $item->id }}]" min="0"
                                            value="{{ $selectedItem ? $selectedItem->jumlah : 0 }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- BADAL UMRAH FORM --}}
                        <div class="detail-form {{ in_array('badal', $selectedServices) ? '' : 'hidden' }}"
                            id="badal-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addBadal">Tambah
                                Badal</button>
                            <div id="badalWrapper">
                                @forelse($existingBadals as $index => $badal)
                                    <div class="badal-form bg-white p-3 border mb-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label">Nama yang dibadalkan</label>
                                            <input type="text" class="form-control nama_badal" name="nama_badal[]"
                                                value="{{ $badal->name }}">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Harga</label>
                                            <input type="number" class="form-control harga_badal" name="harga_badal[]"
                                                min="0" value="{{ $badal->price }}">
                                        </div>
                                        {{-- BARIS BARU: Input Tanggal Badal --}}
                                        <div class="form-group mb-2">
                                            <label class="form-label">Tanggal Pelaksanaan</label>
                                            <input type="date" class="form-control tanggal_badal"
                                                name="tanggal_badal[]" value="{{ $badal->tanggal_pelaksanaan }}">
                                        </div>
                                        {{-- AKHIR BARIS BARU --}}
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                                Badal</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="badal-form bg-white p-3 border mb-3">
                                        <div class="form-group mb-2">
                                            <label class="form-label">Nama yang dibadalkan</label>
                                            <input type="text" class="form-control nama_badal" name="nama_badal[]">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Harga</label>
                                            <input type="number" class="form-control harga_badal" name="harga_badal[]"
                                                min="0">
                                        </div>
                                        {{-- BARIS BARU: Input Tanggal Badal --}}
                                        <div class="form-group mb-2">
                                            <label class="form-label">Tanggal Pelaksanaan</label>
                                            <input type="date" class="form-control tanggal_badal"
                                                name="tanggal_badal[]">
                                        </div>
                                        {{-- AKHIR BARIS BARU --}}
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                                Badal</button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="form-actions">
                        <button type="submit" name="action" value="nego" class="btn btn-secondary">Simpan sebagai
                            Nego</button>
                        <button type="submit" name="action" value="deal" class="btn btn-primary">Simpan dan
                            Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TEMPLATE UNTUK CLONE/DUPLIKAT (JANGAN DIHAPUS) --}}
    <template id="ticket-template">
        <div class="ticket-form bg-white p-3 border mb-3">
            <input type="hidden" name="plane_id[]" value="">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal</label><input type="date"
                        class="form-control" name="tanggal[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text"
                        class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text"
                        class="form-control" name="maskapai[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text"
                        class="form-control" name="keterangan[]"></div>
                <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number"
                        class="form-control" name="jumlah[]"></div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button>
            </div>
        </div>
    </template>

    <template id="hotel-template">
        <div class="hotel-form bg-white p-3 border mb-3" data-index="0"> {{-- data-index akan diupdate JS --}}
            <input type="hidden" name="hotel_id[]" value="">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Checkin</label><input type="date"
                        class="form-control" name="tanggal_checkin[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Checkout</label><input type="date"
                        class="form-control" name="tanggal_checkout[]"></div>
                <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text"
                        class="form-control" name="nama_hotel[]" placeholder="Nama hotel"></div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipe Kamar</label>
                    <select class="form-select" name="type_hotel[]">
                        @foreach ($types as $type)
                            <option value="{{ $type->nama_tipe }}">{{ $type->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jumlah Tipe</label>
                    <input type="number" class="form-control" name="jumlah_type[]" min="0" value="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jumlah Kamar</label>
                    <input type="number" class="form-control" name="jumlah_kamar[]" min="0" value="0">
                </div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus</button>
            </div>
        </div>
    </template>

    <template id="badal-template">
        <div class="badal-form bg-white p-3 border mb-3">
            <div class="form-group mb-2">
                <label class="form-label">Nama yang dibadalkan</label>
                <input type="text" class="form-control nama_badal" name="nama_badal[]">
            </div>
            <div class="form-group mb-2">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control harga_badal" name="harga_badal[]" min="0">
            </div>
            {{-- BARIS BARU: Input Tanggal Badal Template --}}
            <div class="form-group mb-2">
                <label class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" class="form-control tanggal_badal" name="tanggal_badal[]">
            </div>
            {{-- AKHIR BARIS BARU --}}
            <div class="mt-2 text-end">
                <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button>
            </div>
        </div>
    </template>

    <template id="transport-set-template">
        <div class="transport-set card p-3 mt-3" data-index="0"> {{-- data-index akan diupdate JS --}}
            <input type="hidden" name="item_id[]" value="">
            <div class="cars">
                @foreach ($transportations as $data)
                    <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)'
                        data-name="{{ $data->nama }}" data-price="{{ $data->harga }}">
                        <div class="service-name">{{ $data->nama }}</div>
                        <input type="radio" name="transportation_id[0]" {{-- name akan diupdate JS --}}
                            value="{{ $data->id }}" class="d-none">
                    </div>
                @endforeach
            </div>
            <div class="route-select mt-3 hidden">
                <label class="form-label">Pilih Rute:</label>
                <select name="rute_id[0]" class="form-select"> {{-- name akan diupdate JS --}}
                    <option value="">-- Pilih Rute --</option>
                </select>
            </div>
            {{-- BARIS BARU: Input Tanggal Transportasi Darat Template --}}
            <div class="form-row mt-3">
                <div class="form-col">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="transport_dari[]">
                </div>
                <div class="form-col">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="transport_sampai[]">
                </div>
            </div>
            {{-- AKHIR BARIS BARU --}}
            <div class="mt-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
            </div>
        </div>
    </template>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter untuk form dinamis
            let hotelCounter = {{ $existingHotels->count() > 0 ? $existingHotels->count() : 1 }};
            let transportCounter = {{ $existingTransports->count() > 0 ? $existingTransports->count() : 1 }};

            // --- FUNGSI UPDATE INFO TRAVEL ---
            const travelSelect = document.getElementById('travel-select');
            const penanggungInput = document.getElementById('penanggung');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            function updateTravelInfo() {
                const selectedOption = travelSelect.options[travelSelect.selectedIndex];
                penanggungInput.value = selectedOption.dataset.penanggung || '';
                emailInput.value = selectedOption.dataset.email || '';
                phoneInput.value = selectedOption.dataset.telepon || '';
            }
            travelSelect.addEventListener('change', updateTravelInfo);
            updateTravelInfo(); // Panggil saat load


            // --- FUNGSI UNTUK TOMBOL "TAMBAH" ---

            document.getElementById('addTicket').addEventListener('click', function() {
                const template = document.getElementById('ticket-template').content.cloneNode(true);
                document.getElementById('ticketWrapper').appendChild(template);
            });

            document.getElementById('addHotel').addEventListener('click', function() {
                const template = document.getElementById('hotel-template').content.cloneNode(true);
                const hotelForm = template.querySelector('.hotel-form');
                hotelForm.dataset.index = hotelCounter;
                // Update name attributes for arrays
                hotelForm.querySelector('[name="tanggal_checkin[]"]').name =
                    `tanggal_checkin[${hotelCounter}]`;
                hotelForm.querySelector('[name="tanggal_checkout[]"]').name =
                    `tanggal_checkout[${hotelCounter}]`;
                hotelForm.querySelector('[name="nama_hotel[]"]').name = `nama_hotel[${hotelCounter}]`;
                hotelForm.querySelector('[name="type_hotel[]"]').name = `type_hotel[${hotelCounter}]`;
                hotelForm.querySelector('[name="jumlah_type[]"]').name = `jumlah_type[${hotelCounter}]`;
                hotelForm.querySelector('[name="jumlah_kamar[]"]').name = `jumlah_kamar[${hotelCounter}]`;
                hotelCounter++;
                document.getElementById('hotelWrapper').appendChild(template);
            });

            document.getElementById('addBadal').addEventListener('click', function() {
                const template = document.getElementById('badal-template').content.cloneNode(true);
                document.getElementById('badalWrapper').appendChild(template);
            });

            document.getElementById('add-transport-btn').addEventListener('click', function() {
                const template = document.getElementById('transport-set-template').content.cloneNode(true);
                const transportSet = template.querySelector('.transport-set');

                const newIndex = transportCounter;
                transportSet.dataset.index = newIndex;

                // Update name untuk semua radio button
                transportSet.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.name = `transportation_id[${newIndex}]`;
                });
                // Update name untuk select, input tanggal
                transportSet.querySelector('select').name = `rute_id[${newIndex}]`;
                transportSet.querySelector('[name="transport_dari[]"]').name =
                `transport_dari[${newIndex}]`;
                transportSet.querySelector('[name="transport_sampai[]"]').name =
                    `transport_sampai[${newIndex}]`;
                transportSet.querySelector('[name="item_id[]"]').name = `item_id[${newIndex}]`;

                document.getElementById('new-transport-forms').appendChild(template);
                transportCounter++;
            });


            // --- EVENT LISTENER UTAMA (EVENT DELEGATION) ---
            document.body.addEventListener('click', function(e) {

                // --- 1. Klik Main Service Item ---
                const serviceItem = e.target.closest('.service-item');
                if (serviceItem) {
                    const serviceType = serviceItem.dataset.service;
                    const checkbox = serviceItem.querySelector('input[type="checkbox"]');
                    const detailForm = document.getElementById(`${serviceType}-details`);

                    serviceItem.classList.toggle('selected');
                    checkbox.checked = serviceItem.classList.contains('selected');

                    if (detailForm) {
                        detailForm.classList.toggle('hidden', !checkbox.checked);
                    }
                }

                // --- 2. Klik Pilihan Transportasi (Pesawat / Bus) ---
                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    const form = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
                    const checkbox = transportItem.querySelector('input');

                    transportItem.classList.toggle('selected');
                    checkbox.checked = transportItem.classList.contains('selected');

                    if (form) form.classList.toggle('hidden', !checkbox.checked);
                }

                // --- 3. Klik Pilihan Handling (Hotel / Bandara) ---
                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    const form = document.getElementById(type === 'hotel' ? 'hotel-handling-form' :
                        'bandara-handling-form');
                    const checkbox = handlingItem.querySelector('input');

                    handlingItem.classList.toggle('selected');
                    checkbox.checked = handlingItem.classList.contains('selected');

                    if (form) form.classList.toggle('hidden', !checkbox.checked);
                }

                // --- 4. Klik Item Pilihan (Pendamping, Konten, Meal, dll) ---
                const toggleItem = e.target.closest(
                    '.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item, .service-tour'
                    );
                if (toggleItem) {
                    const type = toggleItem.dataset.type || (toggleItem.classList.contains('service-tour') ?
                        'tour' : null);
                    const id = toggleItem.dataset.id;

                    if (type && id) {
                        const form = document.getElementById(`form-${type}-${id}`) || document
                            .getElementById(`${type}-${id}-form`);
                        toggleItem.classList.toggle('selected');

                        if (form) {
                            form.classList.toggle('hidden', !toggleItem.classList.contains('selected'));
                        }

                        if (type === 'tour') {
                            const tourCheckbox = toggleItem.querySelector('input[type="checkbox"]');
                            if (tourCheckbox) tourCheckbox.checked = toggleItem.classList.contains(
                                'selected');
                        }
                    }
                }

                // --- 5. Klik Pilihan Transportasi untuk Tour ---
                const tourTransportOption = e.target.closest('.transport-option');
                if (tourTransportOption) {
                    const group = tourTransportOption.closest('.transport-options');
                    group.querySelectorAll('.transport-option').forEach(opt => {
                        if (opt !== tourTransportOption) {
                            opt.classList.remove('selected');
                            opt.querySelector('input[type="radio"]').checked = false;
                        }
                    });

                    tourTransportOption.classList.add('selected');
                    tourTransportOption.querySelector('input[type="radio"]').checked = true;
                }

                // --- 6. Klik Pilihan Transportasi Darat (Bus/Mobil) ---
                const serviceCar = e.target.closest('.service-car');
                if (serviceCar) {
                    const transportSet = serviceCar.closest('.transport-set');
                    const routeSelectDiv = transportSet.querySelector('.route-select');
                    const routeSelect = routeSelectDiv.querySelector('select');

                    transportSet.querySelectorAll('.service-car').forEach(car => {
                        if (car !== serviceCar) {
                            car.classList.remove('selected');
                            car.querySelector('input[type="radio"]').checked = false;
                        }
                    });

                    serviceCar.classList.add('selected');
                    serviceCar.querySelector('input[type="radio"]').checked = true;

                    const routes = JSON.parse(serviceCar.dataset.routes || '[]');
                    routeSelect.innerHTML = '<option value="">-- Pilih Rute --</option>';
                    routes.forEach(route => {
                        routeSelect.innerHTML +=
                            `<option value="${route.id}" data-price="${route.price}">${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`;
                    });
                    routeSelectDiv.classList.remove('hidden');
                }

                // --- 7. Klik Pilihan Dokumen (Parent) ---
                const documentItem = e.target.closest('.document-item');
                if (documentItem) {
                    const docId = documentItem.dataset.documentId;
                    const hasChildren = documentItem.dataset.hasChildren === 'true';
                    const checkbox = documentItem.querySelector('input');

                    documentItem.classList.toggle('selected');
                    checkbox.checked = documentItem.classList.contains('selected');

                    let form;
                    if (hasChildren) {
                        form = document.querySelector(`.document-child-form[data-parent-id="${docId}"]`);
                    } else {
                        form = document.getElementById(`doc-${docId}-form`);
                    }

                    if (form) {
                        form.classList.toggle('hidden', !checkbox.checked);
                        form.querySelectorAll('input.dokumen_id_input, input.jumlah_doc_child_input')
                            .forEach(input => {
                                input.disabled = !checkbox.checked;
                            });
                    }
                }

                // --- 8. Klik Pilihan Dokumen (Anak) ---
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const childId = childItem.dataset.childId;
                    const form = document.getElementById(`doc-child-form-${childId}`);

                    childItem.classList.toggle('selected');

                    if (form) {
                        form.classList.toggle('hidden', !childItem.classList.contains('selected'));
                        form.querySelectorAll('input.dokumen_id_input, input.jumlah_doc_child_input')
                            .forEach(input => {
                                input.disabled = !childItem.classList.contains('selected');
                            });
                    }
                }

                // --- 9. Tombol Hapus Dinamis ---
                const removeAction = (e, wrapperId, itemClass, minItems = 1, alertMsg =
                    'Minimal harus ada 1 form.') => {
                    const wrapper = e.target.closest(wrapperId);
                    if (wrapper.querySelectorAll(itemClass).length > minItems) {
                        e.target.closest(itemClass).remove();
                    } else {
                        alert(alertMsg);
                    }
                };

                if (e.target.matches('.removeTicket')) {
                    removeAction(e, '#ticketWrapper', '.ticket-form', 1, 'Minimal harus ada 1 form tiket.');
                }
                if (e.target.matches('.remove-transport')) {
                    removeAction(e, '#new-transport-forms', '.transport-set', 1,
                        'Minimal harus ada 1 form transportasi darat.');
                }
                if (e.target.matches('.removeHotel')) {
                    removeAction(e, '#hotelWrapper', '.hotel-form', 1, 'Minimal harus ada 1 form hotel.');
                }
                if (e.target.matches('.removeBadal')) {
                    removeAction(e, '#badalWrapper', '.badal-form', 1, 'Minimal harus ada 1 form badal.');
                }
            });

        });
    </script>
@endsection
