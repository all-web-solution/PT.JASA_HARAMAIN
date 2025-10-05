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

    .service-item,
    .transport-item,
    .type-item,
    .service-car,
    .handling-item,
    .document-item,
    .child-item,
    .content-item,
    .pendamping-item,
    .meal-item,
    .dorongan-item,
    .wakaf-item,
    .transport-option {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
    }

    .service-item:hover,
    .transport-item:hover,
    .type-item:hover,
    .service-car:hover,
    .handling-item:hover,
    .document-item:hover,
    .child-item:hover,
    .content-item:hover,
    .pendamping-item:hover,
    .meal-item:hover,
    .dorongan-item:hover,
    .wakaf-item:hover,
    .transport-option:hover {
        border-color: var(--haramain-secondary);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .service-item.selected,
    .transport-item.selected,
    .type-item.selected,
    .handling-item.selected,
    .service-car.selected,
    .document-item.selected,
    .child-item.selected,
    .content-item.selected,
    .pendamping-item.selected,
    .meal-item.selected,
    .dorongan-item.selected,
    .wakaf-item.selected,
    .transport-option.selected {
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

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .service-grid,
        .cars,
        .tours {
            grid-template-columns: 1fr;
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
                                        {{ $pelanggan->id === $service->pelanggan_id ? 'selected' : '' }}>
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
                    // FIX: Decode the JSON string from the database into a PHP array.
                    $selectedServices = json_decode($service->services, true) ?? [];

                    $existingHotels = $service->hotels;
                    $existingPlanes = $service->planes;
                    $existingTransports = $service->transportationItem;
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
                            'wakaf' => ['icon' => 'bi-gift', 'name' => 'Waqaf'],
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

                        {{-- Pesawat Section --}}
                        <div class="form-group {{ !$existingPlanes->isEmpty() ? '' : 'hidden' }}" data-transportasi-form="airplane">
                            <button type="button" class="btn btn-primary btn-sm mb-3" id="addTicket">Tambah Tiket Pesawat</button>
                            <div id="ticketWrapper">
                                @forelse($existingPlanes as $plane)
                                <div class="ticket-form bg-white p-3 border mb-3 rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="tanggal[]" value="{{ $plane->tanggal_keberangkatan }}"></div>
                                        <div class="col-md-6"><label class="form-label">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED" value="{{ $plane->rute }}"></div>
                                        <div class="col-md-6"><label class="form-label">Maskapai</label><input type="text" class="form-control" name="maskapai[]" value="{{ $plane->maskapai }}"></div>
                                        <div class="col-md-6"><label class="form-label">Jumlah Jamaah</label><input type="number" class="form-control" name="jumlah[]" value="{{ $plane->jumlah_jamaah }}"></div>
                                        <div class="col-12"><label class="form-label">Keterangan</label><textarea class="form-control" name="keterangan[]">{{ $plane->keterangan }}</textarea></div>
                                    </div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                </div>
                                @empty
                                <div class="ticket-form bg-white p-3 border mb-3 rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="tanggal[]"></div>
                                        <div class="col-md-6"><label class="form-label">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                                        <div class="col-md-6"><label class="form-label">Maskapai</label><input type="text" class="form-control" name="maskapai[]"></div>
                                        <div class="col-md-6"><label class="form-label">Jumlah Jamaah</label><input type="number" class="form-control" name="jumlah[]"></div>
                                        <div class="col-12"><label class="form-label">Keterangan</label><textarea class="form-control" name="keterangan[]"></textarea></div>
                                    </div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Transportasi Darat Section --}}
                        <div class="form-group {{ !$existingTransports->isEmpty() ? '' : 'hidden' }}" data-transportasi-form="bus">
                            <button type="button" class="btn btn-primary btn-sm mb-3" id="add-transport-btn">Tambah Transportasi Darat</button>
                            <div id="new-transport-forms">
                                @forelse($existingTransports as $index => $transport)
                                    <div class="transport-set card p-3 mt-3" data-index="{{$index}}">
                                        <h6>Pilih Kendaraan & Rute</h6>
                                        <div class="cars">
                                            @foreach ($transportations as $data)
                                                <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}" data-id="{{ $data->id }}" data-routes='@json($data->routes)'>
                                                    <div class="service-name">{{ $data->nama }}</div>
                                                    <input type="radio" name="transportation_id[{{$index}}]" value="{{ $data->id }}" class="d-none" {{ $data->id == $transport->transportation_id ? 'checked' : '' }}>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="route-select mt-3">
                                            <label class="form-label">Pilih Rute:</label>
                                            <select name="rute_id[{{$index}}]" class="form-control">
                                                {{-- Options will be populated by JS --}}
                                            </select>
                                        </div>
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="transport-set card p-3 mt-3" data-index="0">
                                        <h6>Pilih Kendaraan & Rute</h6>
                                        <div class="cars">
                                            @foreach ($transportations as $data)
                                                <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)'>
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

                    {{-- HOTEL FORM --}}
                    <div class="detail-form {{ in_array('hotel', $selectedServices) ? '' : 'hidden' }}" id="hotel-details">
                         <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                        <button type="button" class="btn btn-primary btn-sm mb-3" id="addHotel">Tambah Hotel</button>
                        <div id="hotelWrapper">
                             @forelse($existingHotels as $index => $hotel)
                                <div class="hotel-form bg-white p-3 border mb-3 rounded" data-index="{{ $index }}">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Check-in</label><input type="date" class="form-control" name="tanggal_checkin[]" value="{{$hotel->tanggal_checkin}}"></div>
                                        <div class="col-md-6"><label class="form-label">Check-out</label><input type="date" class="form-control" name="tanggal_checkout[]" value="{{$hotel->tanggal_checkout}}"></div>
                                        <div class="col-12"><label class="form-label">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel" data-field="nama_hotel" value="{{$hotel->nama_hotel}}"></div>
                                        <div class="col-12">
                                            <label class="form-label">Tipe Kamar (Double click to add/remove)</label>
                                            <div class="service-grid">
                                                @foreach ($types as $type)
                                                    <div class="type-item" data-type-id="{{ $type->id }}" data-name="{{ $type->nama_tipe }}">
                                                        <div class="service-name">{{ $type->nama_tipe }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="type-input-container mt-3">
                                                {{-- JS will populate this --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>
                                </div>
                             @empty
                                <div class="hotel-form bg-white p-3 border mb-3 rounded" data-index="0">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Check-in</label><input type="date" class="form-control" name="tanggal_checkin[]"></div>
                                        <div class="col-md-6"><label class="form-label">Check-out</label><input type="date" class="form-control" name="tanggal_checkout[]"></div>
                                        <div class="col-12"><label class="form-label">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                                        <div class="col-12">
                                            <label class="form-label">Tipe Kamar (Double click to add/remove)</label>
                                            <div class="service-grid">
                                                @foreach ($types as $type)
                                                    <div class="type-item" data-type-id="{{ $type->id }}" data-name="{{ $type->nama_tipe }}">
                                                        <div class="service-name">{{ $type->nama_tipe }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="type-input-container mt-3"></div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>
                                </div>
                             @endforelse
                        </div>
                    </div>

                    {{-- Other forms can be added here following the same pattern --}}

                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="save" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let hotelCounter = {{ $existingHotels->count() > 0 ? $existingHotels->count() - 1 : 0 }};
    let transportCounter = {{ $existingTransports->count() > 0 ? $existingTransports->count() - 1 : 0 }};

    const updateTravelInfo = (option) => {
        document.getElementById('penanggung').value = option.dataset.penanggung || '';
        document.getElementById('email').value = option.dataset.email || '';
        document.getElementById('phone').value = option.dataset.telepon || '';
    };

    document.getElementById('travel-select').addEventListener('change', function() {
        updateTravelInfo(this.options[this.selectedIndex]);
    });

    // Toggle main service sections
    document.querySelectorAll('.service-item').forEach(item => {
        item.addEventListener('click', () => {
            const service = item.dataset.service;
            const detailForm = document.getElementById(`${service}-details`);
            const checkbox = item.querySelector('input[type="checkbox"]');

            item.classList.toggle('selected');
            checkbox.checked = item.classList.contains('selected');
            if (detailForm) {
                detailForm.classList.toggle('hidden', !checkbox.checked);
            }
        });
    });

    // Toggle transport types (airplane/bus)
    document.querySelectorAll('.transport-item').forEach(item => {
        item.addEventListener('click', () => {
            const type = item.dataset.transportasi;
            const form = document.querySelector(`[data-transportasi-form="${type}"]`);
            const checkbox = item.querySelector('input[type="checkbox"]');

            item.classList.toggle('selected');
            checkbox.checked = item.classList.contains('selected');

            if (form) {
                form.classList.toggle('hidden', !checkbox.checked);
            }
        });
    });

    // --- HOTEL LOGIC ---
    const hotelWrapper = document.getElementById('hotelWrapper');

    function initializeHotelForms() {
        const existingHotelsData = @json($service->hotels->load('roomTypes.typeHotel'));
        document.querySelectorAll('.hotel-form').forEach((form, index) => {
            const hotelData = existingHotelsData[index];
            if (hotelData && hotelData.room_types) {
                hotelData.room_types.forEach(roomType => {
                    const typeItem = form.querySelector(`.type-item[data-type-id="${roomType.type_hotel_id}"]`);
                    if (typeItem) {
                        typeItem.classList.add('selected');
                        addHotelTypeForm(typeItem, roomType.jumlah_kamar);
                    }
                });
            }
        });
    }

    function addHotelTypeForm(typeItem, quantity = 1) {
        const hotelForm = typeItem.closest('.hotel-form');
        const container = hotelForm.querySelector('.type-input-container');
        const hotelIndex = hotelForm.dataset.index;
        const typeId = typeItem.dataset.typeId;
        const name = typeItem.dataset.name;

        const inputDiv = document.createElement('div');
        inputDiv.classList.add('form-group', 'mt-2', 'bg-light', 'p-3', 'border', 'rounded');
        inputDiv.dataset.typeId = typeId;
        inputDiv.innerHTML = `
            <label class="form-label"><strong>${name}</strong></label>
            <div class="row">
                <div class="col-6">
                    <label class="form-label small">Jumlah Kamar</label>
                    <input type="number" class="form-control" name="jumlah_kamar[${hotelIndex}][${typeId}]" min="1" value="${quantity}">
                </div>
                <div class="col-6">
                    <label class="form-label small">Harga</label>
                    <input type="number" class="form-control" name="harga_kamar[${hotelIndex}][${typeId}]" readonly value="0" placeholder="Diisi oleh divisi hotel">
                </div>
            </div>
        `;
        container.appendChild(inputDiv);
    }

    hotelWrapper.addEventListener('dblclick', function(e) {
        const typeItem = e.target.closest('.type-item');
        if (!typeItem) return;

        const hotelForm = typeItem.closest('.hotel-form');
        const container = hotelForm.querySelector('.type-input-container');
        const typeId = typeItem.dataset.typeId;
        const existingForm = container.querySelector(`[data-type-id="${typeId}"]`);

        if (existingForm) {
            existingForm.remove();
            typeItem.classList.remove('selected');
        } else {
            typeItem.classList.add('selected');
            addHotelTypeForm(typeItem, 1);
        }
    });

    document.getElementById('addHotel').addEventListener('click', () => {
        hotelCounter++;
        const newForm = document.createElement('div');
        newForm.classList.add('hotel-form', 'bg-white', 'p-3', 'border', 'mb-3', 'rounded');
        newForm.dataset.index = hotelCounter;
        newForm.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Check-in</label><input type="date" class="form-control" name="tanggal_checkin[]"></div>
                <div class="col-md-6"><label class="form-label">Check-out</label><input type="date" class="form-control" name="tanggal_checkout[]"></div>
                <div class="col-12"><label class="form-label">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                <div class="col-12">
                    <label class="form-label">Tipe Kamar (Double click to add/remove)</label>
                    <div class="service-grid">
                        @foreach ($types as $type)
                            <div class="type-item" data-type-id="{{ $type->id }}" data-name="{{ $type->nama_tipe }}">
                                <div class="service-name">{{ $type->nama_tipe }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="type-input-container mt-3"></div>
                </div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>
        `;
        hotelWrapper.appendChild(newForm);
    });

    hotelWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeHotel')) {
            if (hotelWrapper.children.length > 1) {
                e.target.closest('.hotel-form').remove();
            } else {
                alert('Minimal harus ada 1 form hotel.');
            }
        }
    });

    // --- TRANSPORTASI DARAT LOGIC ---
    const transportWrapper = document.getElementById('new-transport-forms');

    function populateRoutes(selectElement, routes, selectedRouteId) {
        selectElement.innerHTML = '<option value="">-- Pilih Rute --</option>';
        routes.forEach(route => {
            const selected = route.id == selectedRouteId ? 'selected' : '';
            selectElement.innerHTML += `<option value="${route.id}" ${selected}>${route.route}</option>`;
        });
    }

    function initializeTransportForms() {
        document.querySelectorAll('.transport-set').forEach(form => {
            const selectedCar = form.querySelector('.service-car.selected');
            if (selectedCar) {
                const routes = JSON.parse(selectedCar.dataset.routes || '[]');
                const select = form.querySelector('select');
                const selectedRouteId = '{{ $transport->route_id ?? null }}';
                populateRoutes(select, routes, selectedRouteId);
            }
        });
    }

    transportWrapper.addEventListener('click', function(e) {
        const carItem = e.target.closest('.service-car');
        if (carItem) {
            const parentSet = carItem.closest('.transport-set');
            parentSet.querySelectorAll('.service-car').forEach(c => c.classList.remove('selected'));
            carItem.classList.add('selected');
            carItem.querySelector('input[type="radio"]').checked = true;

            const routes = JSON.parse(carItem.dataset.routes || '[]');
            const select = parentSet.querySelector('select');
            populateRoutes(select, routes);
            parentSet.querySelector('.route-select').classList.remove('hidden');
        }

        if (e.target.classList.contains('remove-transport')) {
             if (transportWrapper.children.length > 1) {
                e.target.closest('.transport-set').remove();
            } else {
                alert('Minimal harus ada 1 form transportasi darat.');
            }
        }
    });

    document.getElementById('add-transport-btn').addEventListener('click', () => {
        transportCounter++;
        const newForm = document.createElement('div');
        newForm.classList.add('transport-set', 'card', 'p-3', 'mt-3');
        newForm.dataset.index = transportCounter;
        newForm.innerHTML = `
            <h6>Pilih Kendaraan & Rute</h6>
            <div class="cars">
                @foreach ($transportations as $data)
                    <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)'>
                        <div class="service-name">{{ $data->nama }}</div>
                        <input type="radio" name="transportation_id[${transportCounter}]" value="{{ $data->id }}" class="d-none">
                    </div>
                @endforeach
            </div>
            <div class="route-select mt-3 hidden">
                <label class="form-label">Pilih Rute:</label>
                <select name="rute_id[${transportCounter}]" class="form-control">
                    <option value="">-- Pilih Rute --</option>
                </select>
            </div>
            <div class="mt-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
            </div>
        `;
        transportWrapper.appendChild(newForm);
    });

    // --- TICKET LOGIC ---
    document.getElementById('addTicket').addEventListener('click', () => {
        const wrapper = document.getElementById('ticketWrapper');
        const newForm = document.createElement('div');
        newForm.classList.add('ticket-form', 'bg-white', 'p-3', 'border', 'mb-3', 'rounded');
        newForm.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="tanggal[]"></div>
                <div class="col-md-6"><label class="form-label">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                <div class="col-md-6"><label class="form-label">Maskapai</label><input type="text" class="form-control" name="maskapai[]"></div>
                <div class="col-md-6"><label class="form-label">Jumlah Jamaah</label><input type="number" class="form-control" name="jumlah[]"></div>
                <div class="col-12"><label class="form-label">Keterangan</label><textarea class="form-control" name="keterangan[]"></textarea></div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
        `;
        wrapper.appendChild(newForm);
    });

    document.getElementById('ticketWrapper').addEventListener('click', (e) => {
        if (e.target.classList.contains('removeTicket')) {
            if (document.getElementById('ticketWrapper').children.length > 1) {
                e.target.closest('.ticket-form').remove();
            } else {
                alert('Minimal harus ada 1 form tiket.');
            }
        }
    });

    // --- INITIALIZE ALL FORMS ON PAGE LOAD ---
    initializeHotelForms();
    initializeTransportForms();
});
</script>
@endsection
