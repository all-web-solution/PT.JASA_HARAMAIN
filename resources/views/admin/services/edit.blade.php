@extends('admin.master')

@section('content')
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

    .service-create-container {
        max-width: 100vw;
        margin: 0 auto;
        padding: 2rem;
        background-color: #f8fafd;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-weight: 700;
        color: var(--haramain-primary);
        margin: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title i {
        font-size: 1.5rem;
        color: var(--haramain-secondary);
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-section:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 1.1rem;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title i {
        color: var(--haramain-secondary);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--haramain-secondary);
        box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-col {
        flex: 1;
    }

    .service-grid,
    .cars,
    .tours {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .service-item, .transport-item, .type-item, .service-car, .handling-item, .document-item, .child-item, .content-item, .pendamping-item, .meal-item, .dorongan-item, .wakaf-item, .transport-option {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
    }

    .service-item:hover, .transport-item:hover, .type-item:hover, .service-car:hover, .handling-item:hover, .document-item:hover, .child-item:hover, .content-item:hover, .pendamping-item:hover, .meal-item:hover, .dorongan-item:hover, .wakaf-item:hover, .transport-option:hover {
        border-color: var(--haramain-secondary);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .service-item.selected, .transport-item.selected, .type-item.selected, .handling-item.selected, .service-car.selected, .document-item.selected, .child-item.selected, .content-item.selected, .pendamping-item.selected, .meal-item.selected, .dorongan-item.selected, .wakaf-item.selected, .transport-option.selected {
        border-color: var(--haramain-secondary);
        background-color: var(--haramain-light);
    }

    .service-icon {
        font-size: 2rem;
        color: var(--haramain-secondary);
        margin-bottom: 0.75rem;
    }

    .service-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .service-desc {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .detail-form {
        background-color: var(--haramain-light);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .detail-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .detail-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .detail-title {
        font-weight: 600;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-title i {
        color: var(--haramain-secondary);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--haramain-secondary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--haramain-primary);
    }

    .btn-secondary {
        background-color: white;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background-color: #f8f9fa;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .hidden {
        display: none !important;
    }

    .card-reyal.selected {
        border: 2px solid var(--haramain-secondary);
        background-color: var(--haramain-light);
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        .service-grid, .cars, .tours {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

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
                @method("PUT")

                {{-- SECTION: DATA TRAVEL --}}
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Travel
                    </h6>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Nama Travel</label>
                                <select class="form-control" name="travel" id="travel-select">
                                    @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}"
                                        data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                        data-email="{{ $pelanggan->email }}"
                                        data-telepon="{{ $pelanggan->phone }}"
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
                                <input type="text" class="form-control" readonly id="penanggung" value="{{ $service->pelanggan->penanggung_jawab }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" readonly id="email" value="{{ $service->pelanggan->email }}">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <input type="tel" class="form-control" readonly id="phone" value="{{ $service->pelanggan->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Keberangkatan</label>
                                <input type="date" class="form-control" name="tanggal_keberangkatan" required value="{{ $service->tanggal_keberangkatan }}">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Kepulangan</label>
                                <input type="date" class="form-control" name="tanggal_kepulangan" required value="{{ $service->tanggal_kepulangan }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Jamaah</label>
                        <input type="number" class="form-control" name="total_jamaah" min="1" required value="{{ $service->total_jamaah }}">
                    </div>
                </div>

                {{-- PHP LOGIC TO PREPARE DATA --}}
                @php
                    $selectedServices = json_decode($service->services, true) ?? [];
                    $existingPlanes = $service->planes;
                    $existingTransports = $service->transportationItem;
                    $existingHotels = $service->hotels;
                    $existingBadals = $service->badals;
                    $selectedGuides = $service->guides?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedMeals = $service->meals?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedDorongan = $service->dorongans?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedWakaf = $service->wakafs?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedContents = $service->contents?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedDocs = $service->documents?->pluck('id')->toArray() ?? [];
                    $selectedDocChildren = $service->documentChildren?->pluck('pivot.jumlah', 'id')->all() ?? [];
                    $selectedTours = $service->tours->keyBy('id') ?? collect();
                    $selectedHandlings = $service->handlings?->pluck('name')->toArray() ?? [];
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
                            'pendamping' => ['icon' => 'bi-people', 'name' => 'Pendamping'],
                            'konten' => ['icon' => 'bi-camera', 'name' => 'Konten'],
                            'reyal' => ['icon' => 'bi-currency-exchange', 'name' => 'Reyal'],
                            'tour' => ['icon' => 'bi-geo-alt', 'name' => 'Tour'],
                            'meals' => ['icon' => 'bi-egg-fried', 'name' => 'Meals'],
                            'dorongan' => ['icon' => 'bi-basket', 'name' => 'Dorongan'],
                            'waqaf' => ['icon' => 'bi-gift', 'name' => 'Waqaf'],
                            'badal' => ['icon' => 'bi-gift', 'name' => 'Badal Umrah'],
                        ] as $key => $serviceInfo)
                        <div class="service-item {{ in_array($key, $selectedServices) ? 'selected' : '' }}" data-service="{{ $key }}">
                            <div class="service-icon"><i class="bi {{ $serviceInfo['icon'] }}"></i></div>
                            <div class="service-name">{{ $serviceInfo['name'] }}</div>
                            <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none" {{ in_array($key, $selectedServices) ? 'checked' : '' }}>
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
                    <div class="detail-form {{ in_array('transportasi', $selectedServices) ? '' : 'hidden' }}" id="transportasi-details">
                        <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                <div class="transport-item {{ !$existingPlanes->isEmpty() ? 'selected' : '' }}" data-transportasi="airplane">
                                    <div class="service-name">Pesawat</div>
                                    <input type="checkbox" name="transportation_types[]" value="airplane" class="d-none" {{ !$existingPlanes->isEmpty() ? 'checked' : '' }}>
                                </div>
                                <div class="transport-item {{ !$existingTransports->isEmpty() ? 'selected' : '' }}" data-transportasi="bus">
                                    <div class="service-name">Transportasi Darat</div>
                                    <input type="checkbox" name="transportation_types[]" value="bus" class="d-none" {{ !$existingTransports->isEmpty() ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="form-group {{ $existingPlanes->isEmpty() ? 'hidden' : '' }}" id="pesawat" data-transportasi="airplane">
                                <label class="form-label">Tiket Pesawat</label>
                                <button type="button" class="btn btn-sm btn-primary" id="addTicket">Tambah Tiket</button>
                                <div id="ticketWrapper">
                                    @forelse($existingPlanes as $plane)
                                    <div class="ticket-form bg-white p-3 border mb-3">
                                        <input type="hidden" name="plane_id[]" value="{{ $plane->id }}">
                                        <div class="row g-3">
                                            <div class="col-md-6"><label class="form-label fw-semibold">Tanggal</label><input type="date" class="form-control" name="tanggal[]" value="{{$plane->tanggal_keberangkatan}}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text" class="form-control" name="rute[]" value="{{$plane->rute}}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text" class="form-control" name="maskapai[]" value="{{$plane->maskapai}}"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan[]" value="{{$plane->keterangan}}"></div>
                                            <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number" class="form-control" name="jumlah[]" value="{{$plane->jumlah_jamaah}}"></div>
                                        </div>
                                        <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                    </div>
                                    @empty
                                    <div class="ticket-form bg-white p-3 border mb-3">
                                        <div class="row g-3">
                                            <div class="col-md-6"><label class="form-label fw-semibold">Tanggal</label><input type="date" class="form-control" name="tanggal[]"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text" class="form-control" name="maskapai[]"></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan[]"></div>
                                            <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number" class="form-control" name="jumlah[]"></div>
                                        </div>
                                        <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="form-group {{ $existingTransports->isEmpty() ? 'hidden' : '' }}" id="bis" data-transportasi="bus">
                                <label class="form-label">Transportasi darat</label>
                                <button type="button" class="btn btn-primary btn-sm" id="add-transport-btn">Tambah Transportasi</button>
                                <div id="new-transport-forms">
                                    @forelse($existingTransports as $index => $transport)
                                        <div class="transport-set card p-3 mt-3" data-index="{{$index}}">
                                            <div class="cars">
                                                @foreach ($transportations as $data)
                                                <input type="hidden" name="transport_id[]" value="{{ $data->id }}">
                                                    <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}" data-id="{{ $data->id }}" data-routes='@json($data->routes)' data-name="{{ $data->nama }}" data-price="{{$data->harga}}">
                                                        <div class="service-name">{{ $data->nama }}</div>
                                                        <input type="radio" name="transportation_id[{{$index}}]" value="{{ $data->id }}" class="d-none" {{ $data->id == $transport->transportation_id ? 'checked' : '' }}>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="route-select mt-3">
                                                <label class="form-label">Pilih Rute:</label>
                                                <select name="rute_id[{{$index}}]" class="form-control">
                                                    {{-- Options populated by JS --}}
                                                </select>
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="transport-set card p-3 mt-3" data-index="0">
                                            <div class="cars">
                                                @foreach ($transportations as $data)
                                                    <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)' data-name="{{ $data->nama }}" data-price="{{$data->harga}}">
                                                        <div class="service-name">{{ $data->nama }}</div>
                                                        <input type="radio" name="transportation_id[0]" value="{{ $data->id }}" class="d-none">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="route-select mt-3 hidden">
                                                <label class="form-label">Pilih Rute:</label>
                                                <select name="rute_id[0]" class="form-control">
                                                    <option value="">-- Pilih Rute --</option>
                                                </select>
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HOTEL FORM --}}
                    <div class="detail-form {{ in_array('hotel', $selectedServices) ? '' : 'hidden' }}" id="hotel-details">
                       <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                       <button type="button" class="btn btn-sm btn-primary mb-2" id="addHotel">Tambah Hotel</button>
                       <div id="hotelWrapper">
                            @forelse($existingHotels as $index => $hotel)
                                <div class="hotel-form bg-white p-3 border mb-3" data-index="{{ $index }}">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label fw-semibold">Checkin</label><input type="date" class="form-control" name="tanggal_checkin[]" value="{{$hotel->tanggal_checkin}}"></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Checkout</label><input type="date" class="form-control" name="tanggal_checkout[]" value="{{$hotel->tanggal_checkout}}"></div>
                                        <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel" data-field="nama_hotel" value="{{$hotel->nama_hotel}}"></div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Tipe Kamar</label>
                                            <div class="service-grid">

                                                <div class="type-item ">
                                                    <div class="service-name">
                                                        {{ $hotel->type }}
                                                    </div>
                                                </div>



                                            </div><div class="form-group mt-2"><label class="form-label">Jumlah type</label><input type="text" class="form-control" name="harga_total_hotel[]" min="0" value="{{$hotel->jumlah_type}}"></div>

                                            <div class="type-input-container"></div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2"><label class="form-label">Jumlah kamar</label><input type="text" class="form-control" name="harga_total_hotel[]" min="0" value="{{$hotel->jumlah_kamar}}"></div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                </div>
                            @empty
                                <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
                                     <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label fw-semibold">Checkin</label><input type="date" class="form-control" name="tanggal_checkin[0]"></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Checkout</label><input type="date" class="form-control" name="tanggal_checkout[0]"></div>
                                        <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[0]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Tipe Kamar</label>
                                            <div class="service-grid">
                                                @foreach ($types as $type)
                                                <div class="type-item" data-type-id="{{ $type->id }}" data-price="{{ $type->jumlah }}" data-name="{{ $type->nama_tipe }}">
                                                    <div class="service-name">{{ $type->nama_tipe }}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="type-input-container"></div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2"><label class="form-label">Harga Total (Divisi Hotel)</label><input type="number" class="form-control" name="harga_total_hotel[0]" min="0"></div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                </div>
                            @endforelse
                       </div>
                    </div>

                    {{-- DOKUMEN FORM --}}
                    <div class="detail-form {{ in_array('dokumen', $selectedServices) ? '' : 'hidden' }}" id="dokumen-details">
                       <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($documents as $document)
                                <div class="document-item {{ in_array($document->id, $selectedDocs) ? 'selected' : '' }}" data-document-id="{{ $document->id }}" data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}" data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                    <div class="service-name">{{ $document->name }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="document-forms-container">
                            @foreach ($documents as $document)
                            @if ($document->childrens->isNotEmpty())
                            <div class="form-group {{ in_array($document->id, $selectedDocs) ? '' : 'hidden' }} document-child-form" data-parent-id="{{ $document->id }}">
                                <label class="form-label">{{ $document->name }}</label>
                                <div class="cars">
                                    @foreach ($document->childrens as $child)
                                    <div class="child-item {{ array_key_exists($child->id, $selectedDocChildren) ? 'selected' : '' }}" data-child-id="{{ $child->id }}" data-price="{{ $child->price }}" data-name="{{ $child->name }}">
                                        <div class="child-name">{{ $child->name }}</div>
                                        <div class="child-name">Rp. {{ number_format($child->price) }}</div>
                                    </div>
                                    @endforeach
                                </div>
                                 @foreach ($document->childrens as $child)
                                     @if(array_key_exists($child->id, $selectedDocChildren))
                                        <div id="doc-child-form-{{$child->id}}" class="form-group mt-2 bg-white p-3 border rounded">
                                            <label class="form-label">Jumlah {{$child->name}}</label>
                                            <input type="number" class="form-control jumlah-child-doc" data-parent-id="{{$document->id}}" data-child-id="{{$child->id}}" data-name="{{$child->name}}" data-price="{{$child->price}}" min="1" value="{{$selectedDocChildren[$child->id]}}">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <input type="text" class="form-control" name="keterangan_doc_child_{{$child->id}}" value="{{$service->documentChildren->find($child->id)->pivot->keterangan ?? ''}}">
                                        </div>
                                     @endif
                                 @endforeach
                            </div>
                            @else
                            <div class="form-group {{ in_array($document->id, $selectedDocs) ? '' : 'hidden' }} document-base-form" id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}">
                                <label class="form-label">Jumlah {{ $document->name }}</label>
                                <input type="number" class="form-control" name="jumlah_doc_{{ $document->id }}" min="1" value="{{$service->documents->find($document->id)->pivot->jumlah ?? '1'}}">
                                <label class="form-label">Keterangan {{ $document->name }}</label>
                                <input type="text" class="form-control" name="keterangan_doc_{{ $document->id }}" value="{{$service->documents->find($document->id)->pivot->keterangan ?? ''}}">
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- HANDLING FORM --}}
                    <div class="detail-form {{ in_array('handling', $selectedServices) ? '' : 'hidden' }}" id="handling-details">
                       <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                <div class="handling-item {{ in_array('hotel', $selectedHandlings) ? 'selected' : '' }}" data-handling="hotel" data-name="Hotel Handling">
                                    <div class="service-name">Hotel</div>
                                    <input type="checkbox" name="handlings[]" value="hotel" class="d-none" {{ in_array('hotel', $selectedHandlings) ? 'checked' : '' }}>
                                </div>
                                <div class="handling-item {{ in_array('bandara', $selectedHandlings) ? 'selected' : '' }}" data-handling="bandara" data-name="Bandara Handling">
                                    <div class="service-name">Bandara</div>
                                    <input type="checkbox" name="handlings[]" value="bandara" class="d-none" {{ in_array('bandara', $selectedHandlings) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        @php $hotelHandling = $service->handlings->where('name', 'hotel')->first(); @endphp
                        <div class="form-group {{ in_array('hotel', $selectedHandlings) ? '' : 'hidden' }}" id="hotel-handling-form">
                            <div class="form-row">
                                <div class="form-col"><label class="form-label">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel_handling" value="{{$hotelHandling->handlingHotels->nama ?? ''}}"></div>
                                <div class="form-col"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="tanggal_hotel_handling" value="{{$hotelHandling->handlingHotels->tanggal ?? ''}}"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-col"><label class="form-label">Harga</label><input type="text" class="form-control" name="harga_hotel_handling" value="{{$hotelHandling->handlingHotels->harga ?? ''}}"></div>
                                <div class="form-col"><label class="form-label">Pax</label><input type="text" class="form-control" name="pax_hotel_handling" value="{{$hotelHandling->handlingHotels->pax ?? ''}}"></div>
                            </div>
                        </div>
                        @php $bandaraHandling = $service->handlings->where('name', 'bandara')->first(); @endphp
                        <div class="form-group {{ in_array('bandara', $selectedHandlings) ? '' : 'hidden' }}" id="bandara-handling-form">
                           <div class="form-row">
                                <div class="form-col"><label class="form-label">Nama Bandara</label><input type="text" class="form-control" name="nama_bandara_handling" value="{{$bandaraHandling->handlingPlanes->nama_bandara ?? ''}}"></div>
                                <div class="form-col"><label class="form-label">Jumlah Jamaah</label><input type="text" class="form-control" name="jumlah_jamaah_handling" value="{{$bandaraHandling->handlingPlanes->jumlah_jamaah ?? ''}}"></div>
                                <div class="form-col"><label class="form-label">Harga</label><input type="text" class="form-control" name="harga_bandara_handling" value="{{$bandaraHandling->handlingPlanes->harga ?? ''}}"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-col"><label class="form-label">Kedatangan</label><input type="date" class="form-control" name="kedatangan_jamaah_handling" value="{{$bandaraHandling->handlingPlanes->kedatangan_jamaah ?? ''}}"></div>
                                <div class="form-col"><label class="form-label">Nama Sopir</label><input type="text" class="form-control" name="nama_supir" value="{{$bandaraHandling->handlingPlanes->nama_supir ?? ''}}"></div>
                            </div>
                        </div>
                    </div>

                    {{-- PENDAMPING FORM --}}
                    <div class="detail-form {{ in_array('pendamping', $selectedServices) ? '' : 'hidden' }}" id="pendamping-details">
                        <h6 class="detail-title"><i class="bi bi-people"></i> Pendamping</h6>
                        <div class="service-grid">
                            @foreach ($guides as $guide)
                            <div class="pendamping-item {{ array_key_exists($guide->id, $selectedGuides) ? 'selected' : '' }}" data-id="{{ $guide->id }}" data-price="{{ $guide->harga }}" data-name="{{ $guide->nama }}" data-type="pendamping">
                                <div class="service-name">{{ $guide->nama }}</div>
                                <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="detail-section">
                            @foreach ($guides as $guide)
                            <div id="form-pendamping-{{ $guide->id }}" class="form-group {{ array_key_exists($guide->id, $selectedGuides) ? '' : 'hidden' }}">
                                <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                <input type="number" class="form-control jumlah-item" data-id="{{ $guide->id }}" data-name="{{ $guide->nama }}" data-price="{{ $guide->harga }}" data-type="pendamping" name="jumlah_pendamping[{{ $guide->id }}]" min="1" value="{{ $selectedGuides[$guide->id] ?? 1 }}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- KONTEN FORM --}}
                    <div class="detail-form {{ in_array('konten', $selectedServices) ? '' : 'hidden' }}" id="konten-details">
                         <h6 class="detail-title"><i class="bi bi-camera"></i> Konten</h6>
                        <div class="service-grid">
                            @foreach ($contents as $content)
                                <div class="content-item {{ array_key_exists($content->id, $selectedContents) ? 'selected' : '' }}" data-id="{{ $content->id }}" data-name="{{ $content->name }}" data-price="{{ $content->price }}" data-type="konten">
                                    <div class="service-name">{{ $content->name }}</div>
                                    <div class="service-desc">Rp. {{ number_format($content->price) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="detail-section">
                            @foreach ($contents as $content)
                                <div id="form-konten-{{ $content->id }}" class="form-group {{ array_key_exists($content->id, $selectedContents) ? '' : 'hidden' }}">
                                    <label class="form-label">Jumlah {{ $content->name }}</label>
                                    <input type="number" class="form-control jumlah-item" data-id="{{ $content->id }}" data-name="{{ $content->name }}" data-price="{{ $content->price }}" data-type="konten" name="jumlah_konten[{{ $content->id }}]" min="1" value="{{ $selectedContents[$content->id] ?? 1 }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TOUR FORM --}}
                    <div class="detail-form {{ in_array('tour', $selectedServices) ? '' : 'hidden' }}" id="tour-details">
                       <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                        <div class="detail-section">
                            <div class="tours">
                                @foreach ($tours as $tour)
                                <div class="service-tour {{ isset($selectedTours[$tour->id]) ? 'selected' : '' }}" data-id="{{ $tour->id }}" data-name="{{ $tour->name }}">
                                    <div class="service-name">{{ $tour->name }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach ($tours as $tour)
                        <div id="tour-{{ $tour->id }}-form" class="tour-form {{ isset($selectedTours[$tour->id]) ? '' : 'hidden' }}">
                            <h6>Transportasi {{ $tour->name }}</h6>
                            <div class="transport-options service-grid">
                                @foreach ($transportations as $trans)
                                    @php
                                       $isSelectedTour = isset($selectedTours[$tour->id]) && $selectedTours[$tour->id]->transportation_id == $trans->id;
                                    @endphp
                                    <div class="transport-option {{ $isSelectedTour ? 'selected' : '' }}" data-tour-id="{{ $tour->id }}" data-trans-id="{{ $trans->id }}" data-price="{{ $trans->harga }}" data-tour-name="{{ $tour->name }}" data-trans-name="{{ $trans->nama }}">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <input type="radio" name="tour_transport[{{ $tour->id }}]" value="{{ $trans->id }}" class="d-none" {{ $isSelectedTour ? 'checked' : '' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- MEALS FORM --}}
                    <div class="detail-form {{ in_array('meals', $selectedServices) ? '' : 'hidden' }}" id="meals-details">
                       <h6 class="detail-title"><i class="bi bi-egg-fried"></i> Makanan</h6>
                        <div class="service-grid">
                            @foreach ($meals as $meal)
                            <div class="meal-item {{ array_key_exists($meal->id, $selectedMeals) ? 'selected' : '' }}" data-id="{{ $meal->id }}" data-name="{{ $meal->name }}" data-price="{{ $meal->price }}" data-type="meal">
                                <div class="service-name">{{ $meal->name }}</div>
                                <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="detail-section">
                            @foreach ($meals as $meal)
                            <div id="form-meal-{{ $meal->id }}" class="form-group {{ array_key_exists($meal->id, $selectedMeals) ? '' : 'hidden' }}">
                                <label class="form-label">Jumlah {{ $meal->name }}</label>
                                <input type="number" class="form-control jumlah-item" data-id="{{ $meal->id }}" data-name="{{ $meal->name }}" data-price="{{ $meal->price }}" data-type="meal" name="jumlah_meals[{{ $meal->id }}]" min="1" value="{{ $selectedMeals[$meal->id] ?? 1 }}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- DORONGAN FORM --}}
                    <div class="detail-form {{ in_array('dorongan', $selectedServices) ? '' : 'hidden' }}" id="dorongan-details">
                         <h6 class="detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                        <div class="service-grid">
                            @foreach ($dorongan as $item)
                            <div class="dorongan-item {{ array_key_exists($item->id, $selectedDorongan) ? 'selected' : '' }}" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" data-type="dorongan">
                                <div class="service-name">{{ $item->name }}</div>
                                <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="detail-section">
                            @foreach ($dorongan as $item)
                            <div id="form-dorongan-{{ $item->id }}" class="form-group {{ array_key_exists($item->id, $selectedDorongan) ? '' : 'hidden' }}">
                                <label class="form-label">Jumlah {{ $item->name }}</label>
                                <input type="number" class="form-control jumlah-item" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" data-type="dorongan" name="jumlah_dorongan[{{ $item->id }}]" min="1" value="{{ $selectedDorongan[$item->id] ?? 1 }}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- WAQAF FORM --}}
                    <div class="detail-form {{ in_array('waqaf', $selectedServices) ? '' : 'hidden' }}" id="waqaf-details">
                        <h6 class="detail-title"><i class="bi bi-gift"></i> Waqaf</h6>
                        <div class="service-grid">
                            @foreach ($wakaf as $item)
                            <div class="wakaf-item {{ array_key_exists($item->id, $selectedWakaf) ? 'selected' : '' }}" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" data-price="{{ $item->harga }}" data-type="wakaf">
                                <div class="service-name">{{ $item->nama }}</div>
                                <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="detail-section">
                            @foreach ($wakaf as $item)
                            <div id="form-wakaf-{{ $item->id }}" class="form-group {{ array_key_exists($item->id, $selectedWakaf) ? '' : 'hidden' }}">
                                <label class="form-label">Jumlah {{ $item->nama }}</label>
                                <input type="number" class="form-control jumlah-item" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" data-price="{{ $item->harga }}" data-type="wakaf" name="jumlah_wakaf[{{ $item->id }}]" min="1" value="{{ $selectedWakaf[$item->id] ?? 1 }}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- BADAL UMRAH FORM --}}
                    <div class="detail-form {{ in_array('badal', $selectedServices) ? '' : 'hidden' }}" id="badal-details">
                        <h6 class="detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                        <button type="button" class="btn btn-sm btn-primary mb-2" id="addBadal">Tambah Badal</button>
                        <div id="badalWrapper">
                            @forelse(($existingBadals ?? []) as $index => $badal)
                            <div class="badal-form bg-white p-3 border mb-3" data-index="{{$index}}">
                                <div class="form-group mb-2">
                                    <label class="form-label">Nama yang dibadalkan</label>
                                    <input type="text" class="form-control nama_badal" name="nama_badal[]" value="{{$badal->name}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control harga_badal" name="harga_badal[]" min="0" value="{{$badal->price}}">
                                </div>
                                <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button>
                                </div>
                            </div>
                            @empty
                             <div class="badal-form bg-white p-3 border mb-3" data-index="0">
                                <div class="form-group mb-2">
                                    <label class="form-label">Nama yang dibadalkan</label>
                                    <input type="text" class="form-control nama_badal" name="nama_badal[0]">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control harga_badal" name="harga_badal[0]" min="0">
                                </div>
                                <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="form-section p-3" id="cart-total-price" style="display: none;">
                    <h6 class="form-section-title">
                        <i class="bi bi-card-checklist"></i> Detail produk yang dipilih
                    </h6>
                    <ul id="cart-items" class="list-group mt-2"></ul>
                    <div class="mt-3 text-end">
                        <strong>Total:
                            <input type="hidden" name="total_amount" id="cart-total" value="0">
                            <span id="cart-total-text">Rp. 0</span>
                        </strong>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                    <button type="submit" name="action" value="nego" class="btn btn-warning">Nego</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = {};
    const cartSection = document.getElementById("cart-total-price");
    const cartItemsList = document.getElementById("cart-items");
    const cartTotalInput = document.getElementById("cart-total");
    const cartTotalText = document.getElementById("cart-total-text");

    let hotelCounter = {{ $existingHotels->count() > 0 ? $existingHotels->count() : 1 }};
    let badalCounter = {{ max(1, $existingBadals?->count() ?? 0) }};;
    let transportCounter = {{ $existingTransports->count() > 0 ? $existingTransports->count() : 1 }};
    let ticketCounter = {{ $existingPlanes->count() > 0 ? $existingPlanes->count() : 1 }};

    function updateCartUI() {
        cartItemsList.innerHTML = "";
        let totalAll = 0;
        const items = Object.values(cart).filter(item => item && item.total >= 0 && item.qty > 0);

        items.forEach(item => {
            totalAll += item.total;
            const li = document.createElement("li");
            li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
            li.innerHTML = `
                <div>
                    <strong>${item.name}</strong>
                    <small class="text-muted d-block">Rp ${Number(item.price).toLocaleString('id-ID')} x ${item.qty}</small>
                </div>
                <span>Rp ${Number(item.total).toLocaleString('id-ID')}</span>
            `;
            cartItemsList.appendChild(li);
        });

        cartTotalInput.value = totalAll;
        cartTotalText.textContent = `Rp ${totalAll.toLocaleString('id-ID')}`;
        cartSection.style.display = items.length > 0 ? "block" : "none";
    }

    function updateItemInCart(key, name, qty, price) {
        qty = Number(qty);
        price = Number(price);
        if (qty > 0 && price >= 0 && name) {
            cart[key] = { name: name, qty: qty, price: price, total: qty * price };
        } else {
            delete cart[key];
        }
        updateCartUI();
    }

    // --- MAIN EVENT DELEGATION ---
    document.body.addEventListener('click', function(e) {
        // --- Service Selection ---
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

        // --- Transport Type Selection (Pesawat/Bus) ---
        const transportItem = e.target.closest('.transport-item');
        if (transportItem) {
            const type = transportItem.dataset.transportasi;
            const form = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
            const checkbox = transportItem.querySelector('input');
            transportItem.classList.toggle('selected');
            checkbox.checked = transportItem.classList.contains('selected');
            if(form) form.classList.toggle('hidden', !checkbox.checked);
        }

        // --- Add Buttons ---
        if (e.target.matches('#addTicket')) addTicketForm();
        if (e.target.matches('#add-transport-btn')) addTransportSet();
        if (e.target.matches('#addHotel')) addHotelForm();
        if (e.target.matches('#addBadal')) addBadalForm();

        // --- Remove Buttons ---
        if (e.target.matches('.removeTicket') && e.target.closest('#ticketWrapper').children.length > 1) e.target.closest('.ticket-form').remove();
        if (e.target.matches('.remove-transport') && e.target.closest('#new-transport-forms').children.length > 1) e.target.closest('.transport-set').remove();
        if (e.target.matches('.removeHotel') && e.target.closest('#hotelWrapper').children.length > 1) e.target.closest('.hotel-form').remove();
        if (e.target.matches('.removeBadal') && e.target.closest('#badalWrapper').children.length > 1) e.target.closest('.badal-form').remove();

        // --- Item Selections (Pendamping, Konten, etc.) ---
        const toggleItem = e.target.closest('.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item, .document-item, .child-item, .handling-item, .service-tour, .transport-option, .service-car');
        if(toggleItem) handleItemSelection(toggleItem);
    });

    document.body.addEventListener('dblclick', function(e) {
        const typeItem = e.target.closest('.type-item');
        if(typeItem) handleHotelTypeSelection(typeItem);
    });

    // --- Input/Change Delegation ---
    document.body.addEventListener('input', function(e) {
        const input = e.target;
        if(input.closest('.badal-form')) handleBadalInput(input.closest('.badal-form'));
        if(input.matches('input[data-is-qty="true"]')) handleHotelQtyInput(input);
        if(input.matches('#rupiah-tamis, #kurs-tamis, #reyal-tumis, #kurs-tumis')) handleReyalConversion();
    });

    document.body.addEventListener('change', function(e) {
        const select = e.target.closest('select[name^="rute_id"]');
        if(select) handleRouteChange(select);
    });

    // --- HANDLER FUNCTIONS ---
    function handleItemSelection(item) {
        // Handling for single-choice within a group (like tour transport)
        if (item.classList.contains('transport-option') || item.classList.contains('service-car')) {
            const group = item.parentElement;
            group.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));
        }
        item.classList.toggle('selected');

        // Logic for different item types
        if (item.classList.contains('pendamping-item') || item.classList.contains('content-item') || item.classList.contains('meal-item') || item.classList.contains('dorongan-item') || item.classList.contains('wakaf-item')) {
            const type = item.dataset.type;
            const id = item.dataset.id;
            const form = document.getElementById(`form-${type}-${id}`);
            if(form) form.classList.toggle('hidden', !item.classList.contains('selected'));
        }

        if (item.classList.contains('service-tour')) {
             const form = document.getElementById(`tour-${item.dataset.id}-form`);
             if(form) form.classList.toggle('hidden', !item.classList.contains('selected'));
        }

        initializeCart(); // Recalculate cart anytime a selection changes
    }

    function handleHotelTypeSelection(typeItem) {
        const hotelForm = typeItem.closest('.hotel-form');
        const container = hotelForm.querySelector('.type-input-container');
        const typeId = typeItem.dataset.typeId;
        const existingForm = container.querySelector(`[data-type-id-form="${typeId}"]`);

        typeItem.classList.toggle('selected');
        if (existingForm) {
            existingForm.remove();
        } else {
            const hotelIndex = hotelForm.dataset.index;
            const name = typeItem.dataset.name;
            const price = typeItem.dataset.price;
            const inputDiv = document.createElement('div');
            inputDiv.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border', 'rounded');
            inputDiv.dataset.typeIdForm = typeId;
            inputDiv.innerHTML = `<label class="form-label">Jumlah Kamar (${name})</label><input type="number" class="form-control" name="jumlah_kamar[${hotelIndex}][${typeId}]" min="1" value="1" data-is-qty="true" data-type-id="${typeId}">`;
            container.appendChild(inputDiv);
        }
        initializeCart();
    }

    function handleBadalInput(badalForm) {
        const index = badalForm.dataset.index;
        const namaValue = badalForm.querySelector('.nama_badal').value.trim();
        const hargaValue = parseFloat(badalForm.querySelector('.harga_badal').value) || 0;
        updateItemInCart(`badal-${index}`, `Badal Umrah untuk: ${namaValue}`, 1, hargaValue);
    }

    function handleHotelQtyInput(qtyInput) {
        const hotelForm = qtyInput.closest('.hotel-form');
        const typeId = qtyInput.dataset.typeId;
        const typeItem = hotelForm.querySelector(`.type-item[data-type-id="${typeId}"]`);
        if(typeItem) {
            const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value.trim() || `Hotel`;
            const price = parseInt(typeItem.dataset.price) || 0;
            updateItemInCart(`hotel-${hotelForm.dataset.index}-type-${typeId}`, `Hotel: ${hotelName} - Tipe ${typeItem.dataset.name}`, parseInt(qtyInput.value) || 0, price);
        }
    }

    function handleRouteChange(select) {
        const transportSet = select.closest('.transport-set');
        const index = transportSet.dataset.index;
        Object.keys(cart).forEach(key => {
            if (key.startsWith(`tour-bus-${index}-`)) delete cart[key];
        });

        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption.value) {
            const carName = selectedOption.dataset.carName;
            const price = parseInt(selectedOption.dataset.price) || 0;
            const key = `tour-bus-${index}-${selectedOption.value}`;
            updateItemInCart(key, `Transportasi Darat - ${carName} - ${selectedOption.textContent.split(' - ')[0]}`, 1, price);
        } else {
            updateCartUI();
        }
    }

    // --- DYNAMIC FORM ADDERS ---
    function addHotelForm() { /* ... logic to add new hotel form ... */ }
    function addBadalForm() { /* ... logic to add new badal form ... */ }
    function addTicketForm() { /* ... logic to add new ticket form ... */ }
    function addTransportSet() { /* ... logic to add new transport set form ... */ }

    // --- INITIALIZATION FUNCTION ---
    function initializeCart() {
        cart = {}; // Reset cart before recalculating

        // Simple Items (Pendamping, Meals, etc.)
        document.querySelectorAll('.jumlah-item').forEach(input => {
            const parentForm = input.closest('.form-group');
            const itemDiv = document.querySelector(`.${input.dataset.type}-item[data-id="${input.dataset.id}"]`);
            if (itemDiv && itemDiv.classList.contains('selected') && !parentForm.classList.contains('hidden')) {
                updateItemInCart(`${input.dataset.type}-${input.dataset.id}`, input.dataset.name, input.value, input.dataset.price);
            }
        });

        // Hotels
        document.querySelectorAll('.hotel-form').forEach(form => {
            const hotelIndex = form.dataset.index;
            const hotelName = form.querySelector('[data-field="nama_hotel"]').value.trim() || `Hotel`;
            form.querySelectorAll('.type-item.selected').forEach(typeItem => {
                const typeId = typeItem.dataset.typeId;
                const qtyInput = form.querySelector(`input[data-type-id="${typeId}"]`);
                if(qtyInput){
                    updateItemInCart(`hotel-${hotelIndex}-type-${typeId}`, `Hotel: ${hotelName} - ${typeItem.dataset.name}`, qtyInput.value, typeItem.dataset.price);
                }
            });
        });

        // Transportasi Darat
        document.querySelectorAll('.transport-set').forEach(set => {
            const index = set.dataset.index;
            const routeSelect = set.querySelector(`select[name="rute_id[${index}]"]`);
            if(routeSelect && routeSelect.value){
                 const selectedOption = routeSelect.options[routeSelect.selectedIndex];
                 const carName = selectedOption.dataset.carName;
                 const price = parseInt(selectedOption.dataset.price) || 0;
                 updateItemInCart(`tour-bus-${index}-${selectedOption.value}`, `Transportasi Darat - ${carName} - ${selectedOption.textContent.split(' - ')[0]}`, 1, price);
            }
        });

        // Tours
        document.querySelectorAll('.transport-option.selected').forEach(opt => {
             updateItemInCart(`tour-${opt.dataset.tourId}-${opt.dataset.transId}`, `Tour ${opt.dataset.tourName} - ${opt.dataset.transName}`, 1, opt.dataset.price);
        });

        // Badal Umrah
        document.querySelectorAll('.badal-form').forEach(form => {
            handleBadalInput(form);
        });

        updateCartUI();
    }

    // --- INITIAL PAGE LOAD SETUP ---
    // Trigger a change on the travel select to populate info
    document.getElementById('travel-select').dispatchEvent(new Event('change'));

    // Populate routes for existing transport sets
    document.querySelectorAll('.transport-set').forEach(form => {
        const selectedCar = form.querySelector('.service-car.selected');
        if (selectedCar) {
            const routes = JSON.parse(selectedCar.dataset.routes || '[]');
            const select = form.querySelector('select');
            const transportData = @json($existingTransports);
            const thisTransport = transportData.find(t => t.transportation_id == selectedCar.dataset.id);
            if(thisTransport){
                select.innerHTML = '<option value="">-- Pilih Rute --</option>';
                 routes.forEach(route => {
                    const selected = route.id == thisTransport.route_id ? 'selected' : '';
                    select.innerHTML += `<option value="${route.id}" data-price="${route.price}" data-car-name="${selectedCar.dataset.name}" ${selected}>${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`;
                });
            }
        }
    });

    // Populate room types for existing hotels
    const existingHotelsData = @json($service->load('hotels'));
     document.querySelectorAll('.hotel-form').forEach((form, index) => {
        const hotelData = existingHotelsData[index];
        if (hotelData && hotelData.room_types) {
            hotelData.room_types.forEach(roomType => {
                const typeItem = form.querySelector(`.type-item[data-type-id="${roomType.type_hotel_id}"]`);
                if (typeItem) {
                    typeItem.classList.add('selected');
                    const container = form.querySelector('.type-input-container');
                    const inputDiv = document.createElement('div');
                    inputDiv.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border', 'rounded');
                    inputDiv.dataset.typeIdForm = roomType.type_hotel_id;
                    inputDiv.innerHTML = `<label class="form-label">Jumlah Kamar (${typeItem.dataset.name})</label><input type="number" class="form-control" name="jumlah_kamar[${index}][${roomType.type_hotel_id}]" min="1" value="${roomType.jumlah_kamar}" data-is-qty="true" data-type-id="${roomType.type_hotel_id}">`;
                    container.appendChild(inputDiv);
                }
            });
        }
    });

    // Initial cart calculation
    initializeCart();
});
</script>
@endsection
