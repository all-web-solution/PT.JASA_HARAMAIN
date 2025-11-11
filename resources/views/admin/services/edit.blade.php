@extends('admin.master')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
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
            --danger-color: #dc3545
        }

        .service-create-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / .05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgb(0 0 0 / .1)
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary)
        }

        .card-body {
            padding: 1.5rem
        }

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color)
        }

        .form-section:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0
        }

        .form-section-title {
            font-size: 1.1rem;
            color: var(--haramain-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .form-section-title i {
            color: var(--haramain-secondary)
        }

        .form-group {
            margin-bottom: 1.25rem
        }

        .form-label {
            display: block;
            margin-bottom: .5rem;
            font-weight: 600;
            color: var(--text-primary)
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: .75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background-color: #fff
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--haramain-secondary);
            box-shadow: 0 0 0 3px rgb(42 111 219 / .1)
        }

        .form-control[readonly] {
            background-color: #e9ecef
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem
        }

        .form-col {
            flex: 1
        }

        .service-grid,
        .cars,
        .tours {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem
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
        .transport-option,
        .service-tour {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fff
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
        .transport-option:hover,
        .service-tour:hover {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgb(0 0 0 / .1)
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
        .transport-option.selected,
        .service-tour.selected {
            border-color: var(--haramain-secondary);
            background-color: var(--haramain-light)
        }

        .service-icon {
            font-size: 2rem;
            color: var(--haramain-secondary);
            margin-bottom: .75rem
        }

        .service-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: .25rem
        }

        .service-desc {
            font-size: .875rem;
            color: var(--text-secondary)
        }

        .detail-form {
            background-color: var(--haramain-light);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem
        }

        .detail-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color)
        }

        .detail-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none
        }

        .detail-title {
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .detail-title i {
            color: var(--haramain-secondary)
        }

        .btn {
            padding: .75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer
        }

        .btn-sm {
            padding: .5rem 1rem;
            font-size: .875rem
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: #fff
        }

        .btn-danger:hover {
            opacity: .85
        }

        .btn-primary {
            background-color: var(--haramain-secondary);
            color: #fff
        }

        .btn-primary:hover {
            background-color: var(--haramain-primary)
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--text-secondary);
            border: 1px solid var(--border-color)
        }

        .btn-secondary:hover {
            background-color: #f8f9fa
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color)
        }

        .hidden {
            display: none !important
        }

        .card-reyal.selected {
            border: 2px solid var(--haramain-secondary);
            background-color: var(--haramain-light)
        }

        #backToServicesBtn {
            visibility: hidden;
            opacity: 0;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border-radius: 50%;
            padding: .6rem .9rem;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgb(0 0 0 / .15);
            transition: opacity 0.3s ease, visibility 0.3s ease
        }

        #backToServicesBtn.show {
            visibility: visible;
            opacity: 1
        }

        @media (max-width:768px) {
            .form-row {
                flex-direction: column;
                gap: 0
            }

            .service-grid,
            .cars,
            .tours {
                grid-template-columns: 1fr
            }

            .form-actions {
                flex-direction: column
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center
            }
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
                <a href="javascript:history.back()" class="btn btn-secondary">
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
                                                {{ old('travel', $service->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
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
                                        value="{{ old('tanggal_keberangkatan', $service->tanggal_keberangkatan) }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    {{-- PERBAIKAN: Gunakan old() dengan fallback ke data service --}}
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ old('tanggal_kepulangan', $service->tanggal_kepulangan) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ old('total_jamaah', $service->total_jamaah) }}">
                        </div>
                    </div>

                    {{-- PHP LOGIC TO PREPARE DATA --}}
                    @php
                        $oldOrSelectedServices = old('services', $selectedServices);

                        $existingPlanes = $service->planes;
                        $existingTransports = $service->transportationItem;
                        $existingHotels = $service->hotels;
                        $existingBadals = $service->badals;

                        $oldTransportTypes = old('transportation_types');
                        $isAirplaneSelected = !is_null($oldTransportTypes)
                            ? in_array('airplane', $oldTransportTypes)
                            : !$existingPlanes->isEmpty();
                        $isBusSelected = !is_null($oldTransportTypes)
                            ? in_array('bus', $oldTransportTypes)
                            : !$existingTransports->isEmpty();

                        // Siapkan data lama (jika ada) untuk item yang bisa dipilih (checkbox/radio)
                        $oldPendampingQty = old('jumlah_pendamping');
                        $oldMealsQty = old('jumlah_meals');
                        $oldDoronganQty = old('jumlah_dorongan');
                        $oldWakafQty = old('jumlah_wakaf');
                        $oldContentsQty = old('jumlah_konten');
                        $oldTourIds = old('tour_id'); // Untuk tour
                        $oldTourTransports = old('tour_transport'); // Untuk transport tour

                        // Siapkan data yang sudah ada (existing) dari controller
                        $selectedGuides = $service->guides?->keyBy('guide_id') ?? collect();
                        $selectedMeals = $service->meals?->keyBy('meal_id') ?? collect();
                        $selectedDorongan = $service->dorongans?->keyBy('dorongan_id') ?? collect();
                        $selectedWakaf = $service->wakafs?->keyBy('wakaf_id') ?? collect();
                        $selectedContents = $service->contents?->keyBy('content_id') ?? collect();
                        $selectedTours = $service->tours?->keyBy('tour_id') ?? collect();

                        // Data Dokumen (ini rumit, kita gunakan data dari controller sebagai fallback)
                        $customerDocs = $service->documents;
                        $selectedDocParents = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->pluck('document_id')
                            ->unique()
                            ->toArray();
                        $selectedDocChildren = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->mapWithKeys(
                                fn($item) => [
                                    $item->document_children_id => ['jumlah' => $item->jumlah, 'id' => $item->id],
                                ],
                            )
                            ->all();
                        $selectedBaseDocs = $customerDocs
                            ->whereNull('document_children_id')
                            ->mapWithKeys(
                                fn($item) => [$item->document_id => ['jumlah' => $item->jumlah, 'id' => $item->id]],
                            )
                            ->all();
                        $allSelectedDocItems = array_merge($selectedDocParents, array_keys($selectedBaseDocs));

                        // Handling
                        $oldHandlingTypes = old('handlings');
                        $isHandlingHotelSelected = !is_null($oldHandlingTypes)
                            ? in_array('hotel', $oldHandlingTypes)
                            : !is_null($service->handlingHotel);
                        $isHandlingPlaneSelected = !is_null($oldHandlingTypes)
                            ? in_array('bandara', $oldHandlingTypes)
                            : !is_null($service->handlingPlanes);

                        $existingReyal = $service->exchanges->first();
                        $oldReyalTipe = old('tipe', $existingReyal?->tipe);

                    @endphp

                    <div class="form-section" id="service-selection-grid">
                        <h6 class="form-section-title">
                            <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                        </h6>
                        <div class="service-grid">
                            @foreach ([
            'transportasi' => ['icon' => 'bi-airplane', 'name' => 'Transportasi', 'desc' => 'Tiket & Transport'],
            'hotel' => ['icon' => 'bi-building', 'name' => 'Hotel', 'desc' => 'Akomodasi'],
            'dokumen' => ['icon' => 'bi-file-text', 'name' => 'Dokumen', 'desc' => 'Visa & Administrasi'],
            'handling' => ['icon' => 'bi-briefcase', 'name' => 'Handling', 'desc' => 'Bandara & Hotel'],
            'pendamping' => ['icon' => 'bi-people', 'name' => 'Pendamping', 'desc' => 'Tour Leader & Mutawwif'],
            'konten' => ['icon' => 'bi-camera', 'name' => 'Konten', 'desc' => 'Dokumentasi'],
            'reyal' => ['icon' => 'bi-currency-exchange', 'name' => 'Reyal', 'desc' => 'Penukaran Mata Uang'],
            'tour' => ['icon' => 'bi-geo-alt', 'name' => 'Tour', 'desc' => 'City Tour & Ziarah'],
            'meals' => ['icon' => 'bi-egg-fried', 'name' => 'Meals', 'desc' => 'Makanan'],
            'dorongan' => ['icon' => 'bi-basket', 'name' => 'Dorongan', 'desc' => 'Bagi penyandang disabilitas'],
            'waqaf' => ['icon' => 'bi-gift', 'name' => 'Waqaf', 'desc' => 'Sedekah & Waqaf'],
            'badal' => ['icon' => 'bi-gift', 'name' => 'Badal Umrah', 'desc' => 'Umrah Badal'],
        ] as $key => $item)
                                <div class="service-item {{ in_array($key, $oldOrSelectedServices) ? 'selected' : '' }}"
                                    data-service="{{ $key }}">
                                    <div class="service-icon"><i class="bi {{ $item['icon'] }}"></i></div>
                                    <div class="service-name">{{ $item['name'] }}</div>
                                    <div class="service-desc">{{ $item['desc'] }}</div>
                                    <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none"
                                        {{ in_array($key, $oldOrSelectedServices) ? 'checked' : '' }}>
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
                        <div class="detail-form {{ in_array('transportasi', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="transportasi-details">
                            <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="service-grid">
                                    {{-- PERBAIKAN: Gunakan variabel $is...Selected --}}
                                    <div class="transport-item {{ $isAirplaneSelected ? 'selected' : '' }}"
                                        data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation_types[]" value="airplane"
                                            class="d-none" {{ $isAirplaneSelected ? 'checked' : '' }}>
                                    </div>
                                    <div class="transport-item {{ $isBusSelected ? 'selected' : '' }}"
                                        data-transportasi="bus">
                                        <div class="service-name">Transportasi Darat</div>
                                        <input type="checkbox" name="transportation_types[]" value="bus"
                                            class="d-none" {{ $isBusSelected ? 'checked' : '' }}>
                                    </div>
                                </div>

                                {{-- FORM PESAWAT --}}
                                <div class="form-group {{ $isAirplaneSelected ? '' : 'hidden' }}" id="pesawat"
                                    data-transportasi="airplane">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary mb-3" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        {{-- PERBAIKAN: Logika untuk memuat 'old' ATAU data 'existing' --}}
                                        @if (is_array(old('tanggal')))
                                            {{-- Jika ada data 'old' (validasi gagal), render dari 'old' --}}
                                            @foreach (old('tanggal') as $index => $oldTanggal)
                                                <div class="ticket-form bg-white p-3 border mb-3">
                                                    {{-- Penting untuk update --}}
                                                    <input type="hidden" name="plane_id[]"
                                                        value="{{ old('plane_id.' . $index) }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Tanggal</label>
                                                            <input type="date" class="form-control" name="tanggal[]"
                                                                value="{{ $oldTanggal }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Rute</label>
                                                            <input type="text" class="form-control" name="rute[]"
                                                                value="{{ old('rute.' . $index) }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Maskapai</label>
                                                            <input type="text" class="form-control" name="maskapai[]"
                                                                value="{{ old('maskapai.' . $index) }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                name="keterangan[]"
                                                                value="{{ old('keterangan.' . $index) }}">
                                                        </div>
                                                        <div class="col-12"><label class="form-label">Jumlah
                                                                (Jamaah)
                                                            </label>
                                                            <input type="number" class="form-control" name="jumlah[]"
                                                                value="{{ old('jumlah.' . $index) }}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-end"><button type="button"
                                                            class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Jika tidak ada data 'old', render dari database ($existingPlanes) --}}
                                            @forelse($existingPlanes as $index => $plane)
                                                <div class="ticket-form bg-white p-3 border mb-3">
                                                    <input type="hidden" name="plane_id[]" value="{{ $plane->id }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Tanggal</label>
                                                            <input type="date" class="form-control" name="tanggal[]"
                                                                value="{{ $plane->tanggal_keberangkatan }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Rute</label>
                                                            <input type="text" class="form-control" name="rute[]"
                                                                value="{{ $plane->rute }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Maskapai</label>
                                                            <input type="text" class="form-control" name="maskapai[]"
                                                                value="{{ $plane->maskapai }}">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                name="keterangan[]" value="{{ $plane->keterangan }}">
                                                        </div>
                                                        <div class="col-12"><label class="form-label">Jumlah
                                                                (Jamaah)
                                                            </label>
                                                            <input type="number" class="form-control" name="jumlah[]"
                                                                value="{{ $plane->jumlah_jamaah }}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-end"><button type="button"
                                                            class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
                                                </div>
                                            @empty
                                                {{-- Jika tidak ada 'old' dan tidak ada 'existing', tampilkan 1 form kosong --}}
                                                <div class="ticket-form bg-white p-3 border mb-3">
                                                    <input type="hidden" name="plane_id[]" value="">
                                                    <div class="row g-3">
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Tanggal</label><input
                                                                type="date" class="form-control" name="tanggal[]">
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Rute</label><input
                                                                type="text" class="form-control" name="rute[]"
                                                                placeholder="Contoh: CGK - JED"></div>
                                                        <div class="col-md-6"><label
                                                                class="form-label fw-semibold">Maskapai</label><input
                                                                type="text" class="form-control" name="maskapai[]">
                                                        </div>
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
                                        @endif
                                    </div>
                                </div>

                                {{-- FORM TRANSPORTASI DARAT --}}
                                <div class="form-group {{ $isBusSelected ? '' : 'hidden' }}" id="bis"
                                    data-transportasi="bus">
                                    <label class="form-label">Transportasi darat</label>
                                    @error('transportation_id.*')
                                        <div style="color:red; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                    @error('rute_id.*')
                                        <div style="color:red; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                    @error('transport_dari.*')
                                        <div style="color:red; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror
                                    @error('transport_sampai.*')
                                        <div style="color:red; font-size: 0.875rem;">{{ $message }}</div>
                                    @enderror

                                    <button type="button" class="btn btn-primary btn-sm mb-3"
                                        id="add-transport-btn">Tambah Transportasi</button>

                                    <div id="new-transport-forms">
                                        @if (is_array(old('transportation_id')))
                                            @foreach (old('transportation_id') as $index => $oldTransportId)
                                                @php
                                                    $selectedTransport = $transportations->firstWhere(
                                                        'id',
                                                        $oldTransportId,
                                                    );
                                                    $oldRouteId = old('rute_id.' . $index);
                                                @endphp
                                                <div class="transport-set card p-3 mt-3"
                                                    data-index="{{ $index }}">
                                                    <input type="hidden" name="item_id[]"
                                                        value="{{ old('item_id.' . $index) }}">
                                                    <div class="cars">
                                                        @foreach ($transportations as $data)
                                                            <div class="service-car {{ $data->id == $oldTransportId ? 'selected' : '' }}"
                                                                data-id="{{ $data->id }}"
                                                                data-routes='@json($data->routes)'
                                                                data-name="{{ $data->nama }}"
                                                                data-price="{{ $data->harga }}">

                                                                <div class="service-name">{{ $data->nama }}</div>
                                                                <div class="service-desc">Kapasitas:
                                                                    {{ $data->kapasitas }}</div>
                                                                <div class="service-desc">Fasilitas:
                                                                    {{ $data->fasilitas }}</div>
                                                                <div class="service-desc">Harga:
                                                                    {{ number_format($data->harga) }}/hari</div>
                                                                <input type="radio"
                                                                    name="transportation_id[{{ $index }}]"
                                                                    value="{{ $data->id }}"
                                                                    {{ $data->id == $oldTransportId ? 'checked' : '' }}>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div
                                                        class="route-select mt-3 {{ $selectedTransport ? '' : 'hidden' }}">
                                                        <label class="form-label">Pilih Rute:</label>
                                                        <select name="rute_id[{{ $index }}]" class="form-select">
                                                            <option value="">-- Pilih Rute --</option>
                                                            @if ($selectedTransport)
                                                                @foreach ($selectedTransport->routes as $route)
                                                                    <option value="{{ $route->id }}"
                                                                        {{ $route->id == $oldRouteId ? 'selected' : '' }}>
                                                                        {{ $route->route }} - Rp.
                                                                        {{ number_format($route->price) }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-row mt-3">
                                                        <div class="form-col">
                                                            <label class="form-label">Dari Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_dari[]"
                                                                value="{{ old('transport_dari.' . $index) }}">
                                                        </div>
                                                        <div class="form-col">
                                                            <label class="form-label">Sampai Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_sampai[]"
                                                                value="{{ old('transport_sampai.' . $index) }}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Jika tidak ada data 'old', render dari database ($existingTransports) --}}
                                            @forelse($existingTransports as $index => $transport)
                                                <div class="transport-set card p-3 mt-3"
                                                    data-index="{{ $index }}">
                                                    <input type="hidden" name="item_id[]" value="{{ $transport->id }}">
                                                    <div class="cars">
                                                        @foreach ($transportations as $data)
                                                            <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}"
                                                                data-id="{{ $data->id }}"
                                                                data-routes='@json($data->routes)'
                                                                data-name="{{ $data->nama }}"
                                                                data-price="{{ $data->harga }}">

                                                                <div class="service-name">{{ $data->nama }}</div>
                                                                <div class="service-desc">Kapasitas:
                                                                    {{ $data->kapasitas }}</div>
                                                                <div class="service-desc">Fasilitas:
                                                                    {{ $data->fasilitas }}</div>
                                                                <div class="service-desc">Harga:
                                                                    {{ number_format($data->harga) }}/hari</div>
                                                                <input type="radio"
                                                                    name="transportation_id[{{ $index }}]"
                                                                    value="{{ $data->id }}"
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
                                                    <div class="form-row mt-3">
                                                        <div class="form-col">
                                                            <label class="form-label">Dari Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_dari[{{ $index }}]"
                                                                value="{{ $transport->dari_tanggal }}">
                                                        </div>
                                                        <div class="form-col">
                                                            <label class="form-label">Sampai Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_sampai[{{ $index }}]"
                                                                value="{{ $transport->sampai_tanggal }}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @empty
                                                {{-- Jika tidak ada 'old' dan 'existing', tampilkan 1 form kosong --}}
                                                <div class="transport-set card p-3 mt-3" data-index="0">
                                                    <input type="hidden" name="item_id[]" value="">
                                                    <div class="cars">
                                                        @foreach ($transportations as $data)
                                                            <div class="service-car" data-id="{{ $data->id }}"
                                                                data-routes='@json($data->routes)'
                                                                data-name="{{ $data->nama }}"
                                                                data-price="{{ $data->harga }}">

                                                                <div class="service-name">{{ $data->nama }}</div>
                                                                <div class="service-desc">Kapasitas:
                                                                    {{ $data->kapasitas }}</div>
                                                                <div class="service-desc">Fasilitas:
                                                                    {{ $data->fasilitas }}</div>
                                                                <div class="service-desc">Harga:
                                                                    {{ number_format($data->harga) }}/hari</div>
                                                                <input type="radio" name="transportation_id[0]"
                                                                    value="{{ $data->id }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="route-select mt-3 hidden">
                                                        {{-- ... (sisa kode 'empty' loop) ... --}}
                                                        <label class="form-label">Pilih Rute:</label>
                                                        <select name="rute_id[0]" class="form-select">
                                                            <option value="">-- Pilih Rute --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-row mt-3">
                                                        <div class="form-col">
                                                            <label class="form-label">Dari Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_dari[0]">
                                                        </div>
                                                        <div class="form-col">
                                                            <label class="form-label">Sampai Tanggal</label>
                                                            <input type="date" class="form-control"
                                                                name="transport_sampai[0]">
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HOTEL FORM --}}
                        <div class="detail-form {{ in_array('hotel', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="hotel-details">
                            <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            <div style="clear: both;"></div>

                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addHotel">Tambah
                                Hotel</button>
                            <div id="hotelWrapper">
                                {{-- PERBAIKAN: Logika untuk memuat 'old' ATAU data 'existing' --}}
                                @if (is_array(old('nama_hotel')))
                                    {{-- Jika ada data 'old' (validasi gagal), render dari 'old' --}}
                                    @foreach (old('nama_hotel') as $index => $oldNamaHotel)
                                        <div class="hotel-form bg-white p-3 border mb-3"
                                            data-index="{{ $index }}">
                                            <input type="hidden" name="hotel_id[]"
                                                value="{{ old('hotel_id.' . $index) }}">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkin</label>
                                                    <input type="date" class="form-control" name="tanggal_checkin[]"
                                                        value="{{ old('tanggal_checkin.' . $index) }}">
                                                </div>
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkout</label>
                                                    <input type="date" class="form-control" name="tanggal_checkout[]"
                                                        value="{{ old('tanggal_checkout.' . $index) }}">
                                                </div>
                                                <div class="col-12"><label class="form-label fw-semibold">Nama
                                                        Hotel</label>
                                                    <input type="text" class="form-control" name="nama_hotel[]"
                                                        placeholder="Nama hotel" value="{{ $oldNamaHotel }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Tipe Kamar</label>
                                                    <select class="form-select" name="type_hotel[]">
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->nama_tipe }}"
                                                                {{ old('type_hotel.' . $index) == $type->nama_tipe ? 'selected' : '' }}>
                                                                {{ $type->nama_tipe }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Jumlah Tipe</label>
                                                    <input type="number" class="form-control" name="jumlah_type[]"
                                                        min="0" value="{{ old('jumlah_type.' . $index) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Jumlah Kamar</label>
                                                    <input type="number" class="form-control" name="jumlah_kamar[]"
                                                        min="0" value="{{ old('jumlah_kamar.' . $index) }}">
                                                </div>
                                            </div>
                                            <div class="mt-3 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Jika tidak ada data 'old', render dari database ($existingHotels) --}}
                                    @forelse($existingHotels as $index => $hotel)
                                        <div class="hotel-form bg-white p-3 border mb-3"
                                            data-index="{{ $index }}">
                                            <input type="hidden" name="hotel_id[]" value="{{ $hotel->id }}">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkin</label>
                                                    <input type="date" class="form-control" name="tanggal_checkin[]"
                                                        value="{{ $hotel->tanggal_checkin }}">
                                                </div>
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkout</label>
                                                    <input type="date" class="form-control" name="tanggal_checkout[]"
                                                        value="{{ $hotel->tanggal_checkout }}">
                                                </div>
                                                <div class="col-12"><label class="form-label fw-semibold">Nama
                                                        Hotel</label>
                                                    <input type="text" class="form-control" name="nama_hotel[]"
                                                        placeholder="Nama hotel" value="{{ $hotel->nama_hotel }}">
                                                </div>
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
                                        {{-- Jika tidak ada 'old' dan 'existing', tampilkan 1 form kosong --}}
                                        <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
                                            <input type="hidden" name="hotel_id[]" value="">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkin</label><input
                                                        type="date" class="form-control" name="tanggal_checkin[]">
                                                </div>
                                                <div class="col-md-6"><label
                                                        class="form-label fw-semibold">Checkout</label><input
                                                        type="date" class="form-control" name="tanggal_checkout[]">
                                                </div>
                                                <div class="col-12"><label class="form-label fw-semibold">Nama
                                                        Hotel</label><input type="text" class="form-control"
                                                        name="nama_hotel[]" placeholder="Nama hotel"></div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Tipe Kamar</label>
                                                    <select class="form-select" name="type_hotel[]">
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->nama_tipe }}">
                                                                {{ $type->nama_tipe }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4"><label class="form-label fw-semibold">Jumlah
                                                        Tipe</label><input type="number" class="form-control"
                                                        name="jumlah_type[]" min="0" value="0"></div>
                                                <div class="col-md-4"><label class="form-label fw-semibold">Jumlah
                                                        Kamar</label><input type="number" class="form-control"
                                                        name="jumlah_kamar[]" min="0" value="0"></div>
                                            </div>
                                            <div class="mt-3 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeHotel">Hapus</button></div>
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                        </div>

                        {{-- DOKUMEN FORM --}}
                        <div class="detail-form {{ in_array('dokumen', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="dokumen-details">
                            <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="service-grid">
                                    @php
                                        $oldDocParentsChecked = old('dokumen_parent_id', $allSelectedDocItems);
                                    @endphp
                                    @foreach ($documents as $document)
                                        <div class="document-item {{ in_array($document->id, $oldDocParentsChecked) ? 'selected' : '' }}"
                                            data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}"
                                            data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                            <div class="service-name">{{ $document->name }}</div>
                                            <input type="checkbox" name="dokumen_parent_id[]"
                                                value="{{ $document->id }}"
                                                {{ in_array($document->id, $oldDocParentsChecked) ? 'checked' : '' }}
                                                class="d-none">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="document-forms-container">
                                @php
                                    $oldDocChildQtys = old('jumlah_doc_child');
                                    $oldDocChildIds = old('dokumen_id');
                                @endphp
                                @foreach ($documents as $document)
                                    @if ($document->childrens->isNotEmpty())
                                        <div class="form-group {{ in_array($document->id, $oldDocParentsChecked) ? '' : 'hidden' }} document-child-form"
                                            data-parent-id="{{ $document->id }}">
                                            <label class="form-label fw-bold">{{ $document->name }}</label>
                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        $isChildSelected = !is_null($oldDocChildIds)
                                                            ? in_array($child->id, $oldDocChildIds)
                                                            : array_key_exists($child->id, $selectedDocChildren);
                                                    @endphp
                                                    <div class="child-item {{ $isChildSelected ? 'selected' : '' }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-price="{{ $child->price }}"
                                                        data-name="{{ $child->name }}">
                                                        <div class="service-name">{{ $child->name }}</div>
                                                        <div class="service-desc">Rp. {{ number_format($child->price) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="child-forms-wrapper mt-3">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        $isChildSelected = !is_null($oldDocChildIds)
                                                            ? in_array($child->id, $oldDocChildIds)
                                                            : array_key_exists($child->id, $selectedDocChildren);
                                                        $selectedChildData = $selectedDocChildren[$child->id] ?? null;
                                                        $oldChildIndex = !is_null($oldDocChildIds)
                                                            ? array_search($child->id, $oldDocChildIds)
                                                            : false;
                                                    @endphp
                                                    <div id="doc-child-form-{{ $child->id }}"
                                                        class="form-group mt-2 bg-white p-3 border rounded {{ $isChildSelected ? '' : 'hidden' }}">
                                                        <input type="hidden" name="customer_document_id[]"
                                                            value="{{ $oldChildIndex !== false ? old('customer_document_id.' . $oldChildIndex) : $selectedChildData['id'] ?? '' }}">
                                                        {{-- (PERUBAHAN 1) Ganti 'name' agar spesifik untuk 'child' --}}
                                                        <input type="hidden" class="dokumen_id_input"
                                                            name="child_documents[]" value="{{ $child->id }}"
                                                            {{ !$isChildSelected ? 'disabled' : '' }}>
                                                        <label class="form-label">Jumlah
                                                            {{ $child->name }}</label>
                                                        {{-- (PERUBAHAN 2) Ganti 'name' menjadi array asosiatif [ID => jumlah] --}}
                                                        <input type="number" class="form-control jumlah_doc_child_input"
                                                            name="jumlah_child_doc[{{ $child->id }}]" min="1"
                                                            value="{{ $oldChildIndex !== false ? old('jumlah_doc_child.' . $oldChildIndex) : $selectedChildData['jumlah'] ?? 1 }}"
                                                            {{ !$isChildSelected ? 'disabled' : '' }}>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $isBaseSelected = !is_null($oldDocChildIds)
                                                ? in_array($document->id, $oldDocChildIds)
                                                : array_key_exists($document->id, $selectedBaseDocs);
                                            $selectedBaseData = $selectedBaseDocs[$document->id] ?? null;
                                            $oldBaseIndex = !is_null($oldDocChildIds)
                                                ? array_search($document->id, $oldDocChildIds)
                                                : false;
                                        @endphp
                                        <div class="form-group {{ $isBaseSelected ? '' : 'hidden' }} document-base-form"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}">
                                            <input type="hidden" name="customer_document_id[]"
                                                value="{{ $oldBaseIndex !== false ? old('customer_document_id.' . $oldBaseIndex) : $selectedBaseData['id'] ?? '' }}">
                                            {{-- (PERUBAHAN 1) Ganti 'name' agar spesifik untuk 'base' --}}
                                            <input type="hidden" class="dokumen_id_input" name="base_documents[]"
                                                value="{{ $document->id }}" {{ !$isBaseSelected ? 'disabled' : '' }}>
                                            <label class="form-label fw-bold">Jumlah
                                                {{ $document->name }}</label>
                                            {{-- (PERUBAHAN 2) Ganti 'name' menjadi array asosiatif [ID => jumlah] --}}
                                            <input type="number" class="form-control jumlah_doc_child_input"
                                                name="jumlah_base_doc[{{ $document->id }}]" min="1"
                                                value="{{ $oldBaseIndex !== false ? old('jumlah_doc_child.' . $oldBaseIndex) : $selectedBaseData['jumlah'] ?? 1 }}"
                                                {{ !$isBaseSelected ? 'disabled' : '' }}>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- HANDLING FORM --}}
                        <div class="detail-form {{ in_array('handling', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="handling-details">
                            @php
                                // (1) Ambil data handling yang sudah ada
                                $hotelHandling = $service->handlings->firstWhere('name', 'hotel');
                                $existingHotelHandling = $hotelHandling?->handlingHotels;

                                $planeHandling = $service->handlings->firstWhere('name', 'bandara');
                                $existingPlaneHandling = $planeHandling?->handlingPlanes;

                                // (2) Cek 'old' input jika ada error validasi
                                $oldHandlingTypes = old('handlings');

                                // (3) TENTUKAN APAKAH CHECKBOX HARUS AKTIF
                                if (!is_null($oldHandlingTypes)) {
                                    // Jika ada 'old' input, gunakan itu
                                    $isHandlingHotelSelected = in_array('hotel', $oldHandlingTypes);
                                    $isHandlingPlaneSelected = in_array('bandara', $oldHandlingTypes);
                                } else {
                                    // Jika tidak ada 'old' input, cek dari data database
                                    $isHandlingHotelSelected = !is_null($existingHotelHandling);
                                    $isHandlingPlaneSelected = !is_null($existingPlaneHandling);
                                }
                            @endphp
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="handling-item {{ $isHandlingHotelSelected ? 'selected' : '' }}"
                                        data-handling="hotel">
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" class="d-none"
                                            {{ $isHandlingHotelSelected ? 'checked' : '' }}>
                                    </div>
                                    <div class="handling-item {{ $isHandlingPlaneSelected ? 'selected' : '' }}"
                                        data-handling="bandara">
                                        <div class="service-name">Bandara</div>
                                        <input type="checkbox" name="handlings[]" value="bandara" class="d-none"
                                            {{ $isHandlingPlaneSelected ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $isHandlingHotelSelected ? '' : 'hidden' }}"
                                id="hotel-handling-form">
                                <input type="hidden" name="handling_hotel_id"
                                    value="{{ $existingHotelHandling?->id }}">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Hotel</label><input
                                            type="text" class="form-control" name="nama_hotel_handling"
                                            value="{{ old('nama_hotel_handling', $existingHotelHandling?->nama) }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Tanggal</label><input type="date"
                                            class="form-control" name="tanggal_hotel_handling"
                                            value="{{ old('tanggal_hotel_handling', $existingHotelHandling?->tanggal?->format('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_hotel_handling"
                                            value="{{ old('harga_hotel_handling', $existingHotelHandling?->harga) }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Pax</label><input type="text"
                                            class="form-control" name="pax_hotel_handling"
                                            value="{{ old('pax_hotel_handling', $existingHotelHandling?->pax) }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Kode Booking</label>
                                        <input type="file" class="form-control" name="kode_booking_hotel_handling">
                                        @if ($existingHotelHandling?->kode_booking)
                                            <small class="d-block mt-1">File saat ini:
                                                <a href="{{ Storage::url($existingHotelHandling->kode_booking) }}"
                                                    target="_blank">Lihat File</a>
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Rumlis</label>
                                        <input type="file" class="form-control" name="rumlis_hotel_handling">
                                        @if ($existingHotelHandling?->rumlis)
                                            <small class="d-block mt-1">File saat ini:
                                                <a href="{{ Storage::url($existingHotelHandling->rumlis) }}"
                                                    target="_blank">Lihat File</a>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Identitas Koper</label>
                                    <input type="file" class="form-control" name="identitas_hotel_handling">
                                    @if ($existingHotelHandling?->identitas_koper)
                                        <small class="d-block mt-1">File saat ini:
                                            <a href="{{ Storage::url($existingHotelHandling->identitas_koper) }}"
                                                target="_blank">Lihat File</a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $isHandlingPlaneSelected ? '' : 'hidden' }}"
                                id="bandara-handling-form">
                                <input type="hidden" name="handling_bandara_id"
                                    value="{{ $existingPlaneHandling?->id }}">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Bandara</label><input
                                            type="text" class="form-control" name="nama_bandara_handling"
                                            value="{{ old('nama_bandara_handling', $existingPlaneHandling?->nama_bandara) }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Jumlah Jamaah</label><input
                                            type="text" class="form-control" name="jumlah_jamaah_handling"
                                            value="{{ old('jumlah_jamaah_handling', $existingPlaneHandling?->jumlah_jamaah) }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_bandara_handling"
                                            value="{{ old('harga_bandara_handling', $existingPlaneHandling?->harga) }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Kedatangan Jamaah</label><input
                                            type="date" class="form-control" name="kedatangan_jamaah_handling"
                                            value="{{ old('kedatangan_jamaah_handling', $existingPlaneHandling?->kedatangan_jamaah?->format('Y-m-d')) }}">
                                    </div>
                                    <div class="form-col"><label class="form-label">Nama Sopir</label><input
                                            type="text" class="form-control" name="nama_supir"
                                            value="{{ old('nama_supir', $existingPlaneHandling?->nama_supir) }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Paket Info</label>
                                        <input type="file" class="form-control" name="paket_info">
                                        @if ($existingPlaneHandling?->paket_info)
                                            <small class="d-block mt-1">File saat ini:
                                                <a href="{{ Storage::url($existingPlaneHandling->paket_info) }}"
                                                    target="_blank">Lihat File</a>
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Identitas Koper</label>
                                        <input type="file" class="form-control"
                                            name="identitas_koper_bandara_handling">
                                        @if ($existingPlaneHandling?->identitas_koper)
                                            <small class="d-block mt-1">File saat ini:
                                                <a href="{{ Storage::url($existingPlaneHandling->identitas_koper) }}"
                                                    target="_blank">Lihat File</a>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING (MUTHOWIF) FORM --}}
                        <div class="detail-form {{ in_array('pendamping', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-people"></i> Muthowif</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($guides as $guide)
                                    @php
                                        // Cek old() dulu, baru existing
                                        $isGuideSelected = !is_null($oldPendampingQty)
                                            ? array_key_exists($guide->id, $oldPendampingQty)
                                            : $selectedGuides->has($guide->id);
                                    @endphp
                                    <div class="pendamping-item {{ $isGuideSelected ? 'selected' : '' }}"
                                        data-id="{{ $guide->id }}" data-type="pendamping">
                                        <div class="service-name">{{ $guide->nama }}</div>
                                        <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    @php
                                        $selectedGuide = $selectedGuides->get($guide->id);
                                        $isGuideSelected = !is_null($oldPendampingQty)
                                            ? array_key_exists($guide->id, $oldPendampingQty)
                                            : $selectedGuides->has($guide->id);
                                    @endphp
                                    <div id="form-pendamping-{{ $guide->id }}"
                                        class="form-group {{ $isGuideSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $guide->nama }}</label>
                                        {{-- PERBAIKAN: Gunakan old() dengan fallback --}}
                                        <input type="number" class="form-control"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="0"
                                            value="{{ old('jumlah_pendamping.' . $guide->id, $selectedGuide ? $selectedGuide->jumlah : 0) }}">

                                        <div class="form-row mt-3">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                {{-- PERBAIKAN: Gunakan old() dengan fallback --}}
                                                <input type="date" class="form-control"
                                                    name="pendamping_dari[{{ $guide->id }}]"
                                                    value="{{ old('pendamping_dari.' . $guide->id, $selectedGuide ? $selectedGuide->muthowif_dari : '') }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                {{-- PERBAIKAN: Gunakan old() dengan fallback --}}
                                                <input type="date" class="form-control"
                                                    name="pendamping_sampai[{{ $guide->id }}]"
                                                    value="{{ old('pendamping_sampai.' . $guide->id, $selectedGuide ? $selectedGuide->muthowif_sampai : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form {{ in_array('konten', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-camera"></i> Konten</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($contents as $content)
                                    @php
                                        $isContentSelected = !is_null($oldContentsQty)
                                            ? array_key_exists($content->id, $oldContentsQty)
                                            : $selectedContents->has($content->id);
                                    @endphp
                                    <div class="content-item {{ $isContentSelected ? 'selected' : '' }}"
                                        data-id="{{ $content->id }}" data-type="konten">
                                        <div class="service-name">{{ $content->name }}</div> {{-- Ganti ke 'name' --}}
                                        <div class="service-desc">Rp {{ number_format($content->price) }}</div>
                                        {{-- Ganti ke 'price' --}}
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    @php
                                        $selectedContent = $selectedContents->get($content->id);
                                        $isContentSelected = !is_null($oldContentsQty)
                                            ? array_key_exists($content->id, $oldContentsQty)
                                            : $selectedContents->has($content->id);
                                    @endphp
                                    <div id="form-konten-{{ $content->id }}"
                                        class="form-group {{ $isContentSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $content->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_konten[{{ $content->id }}]" min="0"
                                            value="{{ old('jumlah_konten.' . $content->id, $selectedContent ? $selectedContent->jumlah : 0) }}">

                                        <label class="form-label mt-2">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control"
                                            name="konten_tanggal[{{ $content->id }}]"
                                            value="{{ old('konten_tanggal.' . $content->id, $selectedContent ? $selectedContent->tanggal_pelaksanaan : '') }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form {{ in_array('reyal', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-currency-exchange"></i> Reyal</h6>
                            <div style="clear: both;"></div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tamis' ? 'selected' : '' }}"
                                        data-reyal-type="tamis">
                                        <h5>Tamis (Rupiah → Reyal)</h5>
                                        <input type="radio" name="tipe" value="tamis" class="d-none"
                                            {{ $oldReyalTipe == 'tamis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tumis' ? 'selected' : '' }}"
                                        data-reyal-type="tumis">
                                        <h5>Tumis (Reyal → Rupiah)</h5>
                                        <input type="radio" name="tipe" value="tumis" class="d-none"
                                            {{ $oldReyalTipe == 'tumis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Tamis --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tamis' ? '' : 'hidden' }}"
                                id="form-tamis">
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah"
                                        value="{{ old('jumlah_rupiah', $oldReyalTipe == 'tamis' ? $existingReyal?->jumlah_input : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis"
                                        value="{{ old('kurs_tamis', $oldReyalTipe == 'tamis' ? $existingReyal?->kurs : '') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis"
                                        readonly
                                        value="{{ old('hasil_tamis', $oldReyalTipe == 'tamis' ? $existingReyal?->hasil : '') }}">
                                </div>
                            </div>

                            {{-- Form Tumis --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tumis' ? '' : 'hidden' }}"
                                id="form-tumis">
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal"
                                        value="{{ old('jumlah_reyal', $oldReyalTipe == 'tumis' ? $existingReyal?->jumlah_input : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis"
                                        value="{{ old('kurs_tumis', $oldReyalTipe == 'tumis' ? $existingReyal?->kurs : '') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis"
                                        readonly
                                        value="{{ old('hasil_tumis', $oldReyalTipe == 'tumis' ? $existingReyal?->hasil : '') }}">
                                </div>
                            </div>

                            <label class="form-label mt-2">Tanggal penyerahan</label>
                            <input type="date" class="form-control" name="tanggal_penyerahan"
                                value="{{ old('tanggal_penyerahan', $existingReyal?->tanggal_penyerahan) }}">
                        </div>

                        {{-- TOUR FORM --}}
                        <div class="detail-form {{ in_array('tour', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="tour-details">
                            <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="tours service-grid">
                                    @foreach ($tours as $tour)
                                        @php
                                            $isTourSelected = !is_null($oldTourIds)
                                                ? in_array($tour->id, $oldTourIds)
                                                : $selectedTours->has($tour->id);
                                        @endphp
                                        <div class="service-tour {{ $isTourSelected ? 'selected' : '' }}"
                                            data-id="{{ $tour->id }}">
                                            <div class="service-name">{{ $tour->name }}</div>
                                            <input type="checkbox" name="tour_id[]" value="{{ $tour->id }}"
                                                class="d-none" {{ $isTourSelected ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tours as $tour)
                                @php
                                    $isTourSelected = !is_null($oldTourIds)
                                        ? in_array($tour->id, $oldTourIds)
                                        : $selectedTours->has($tour->id);
                                    $selectedTourData = $selectedTours->get($tour->id);
                                    // Tentukan transport yang dipilih
                                    $selectedTourTransportId = old(
                                        'tour_transport.' . $tour->id,
                                        $selectedTourData?->transportation_id,
                                    );
                                @endphp
                                <div id="tour-{{ $tour->id }}-form"
                                    class="tour-form detail-section {{ $isTourSelected ? '' : 'hidden' }}">
                                    <h6 class="fw-bold mb-3">Detail untuk {{ $tour->name }}</h6>

                                    {{-- Input Tanggal Tour --}}
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Tour</label>
                                        <input type="date" class="form-control"
                                            name="tour_tanggal[{{ $tour->id }}]"
                                            value="{{ old('tour_tanggal.' . $tour->id, $selectedTourData?->tanggal_keberangkatan) }}">
                                    </div>

                                    <h6 class="fw-bold mb-2">Transportasi</h6>
                                    <div class="transport-options service-grid">
                                        @foreach ($transportations as $trans)
                                            <div class="transport-option {{ $selectedTourTransportId == $trans->id ? 'selected' : '' }}"
                                                data-tour-id="{{ $tour->id }}"
                                                data-trans-id="{{ $trans->id }}">
                                                <div class="service-name">{{ $trans->nama }}</div>
                                                <input type="radio" name="tour_transport[{{ $tour->id }}]"
                                                    value="{{ $trans->id }}" class="d-none"
                                                    {{ $selectedTourTransportId == $trans->id ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- MEALS FORM --}}
                        <div class="detail-form {{ in_array('meals', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="meals-details">
                            <h6 class="detail-title"><i class="bi bi-egg-fried"></i> Makanan</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($meals as $meal)
                                    @php
                                        $isMealSelected = !is_null($oldMealsQty)
                                            ? array_key_exists($meal->id, $oldMealsQty)
                                            : $selectedMeals->has($meal->id);
                                    @endphp
                                    <div class="meal-item {{ $isMealSelected ? 'selected' : '' }}"
                                        data-id="{{ $meal->id }}" data-type="meal">
                                        <div class="service-name">{{ $meal->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($meals as $meal)
                                    @php
                                        $selectedMeal = $selectedMeals->get($meal->id);
                                        $isMealSelected = !is_null($oldMealsQty)
                                            ? array_key_exists($meal->id, $oldMealsQty)
                                            : $selectedMeals->has($meal->id);
                                    @endphp
                                    <div id="form-meal-{{ $meal->id }}"
                                        class="form-group {{ $isMealSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $meal->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_meals[{{ $meal->id }}]" min="0"
                                            value="{{ old('jumlah_meals.' . $meal->id, $selectedMeal ? $selectedMeal->jumlah : 0) }}">

                                        <div class="form-row mt-3">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_dari[{{ $meal->id }}]"
                                                    value="{{ old('meals_dari.' . $meal->id, $selectedMeal ? $selectedMeal->dari_tanggal : '') }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_sampai[{{ $meal->id }}]"
                                                    value="{{ old('meals_sampai.' . $meal->id, $selectedMeal ? $selectedMeal->sampai_tanggal : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DORONGAN FORM --}}
                        <div class="detail-form {{ in_array('dorongan', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="dorongan-details">
                            <h6 class="detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($dorongan as $item)
                                    @php
                                        $isDoronganSelected = !is_null($oldDoronganQty)
                                            ? array_key_exists($item->id, $oldDoronganQty)
                                            : $selectedDorongan->has($item->id);
                                    @endphp
                                    <div class="dorongan-item {{ $isDoronganSelected ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="dorongan">
                                        <div class="service-name">{{ $item->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($dorongan as $item)
                                    @php
                                        $selectedItem = $selectedDorongan->get($item->id);
                                        $isDoronganSelected = !is_null($oldDoronganQty)
                                            ? array_key_exists($item->id, $oldDoronganQty)
                                            : $selectedDorongan->has($item->id);
                                    @endphp
                                    <div id="form-dorongan-{{ $item->id }}"
                                        class="form-group {{ $isDoronganSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_dorongan[{{ $item->id }}]" min="0"
                                            value="{{ old('jumlah_dorongan.' . $item->id, $selectedItem ? $selectedItem->jumlah : 0) }}">

                                        <label class="form-label mt-2">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control"
                                            name="dorongan_tanggal[{{ $item->id }}]"
                                            value="{{ old('dorongan_tanggal.' . $item->id, $selectedItem ? $selectedItem->tanggal_pelaksanaan : '') }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WAQAF FORM --}}
                        <div class="detail-form {{ in_array('waqaf', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="waqaf-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Waqaf</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($wakaf as $item)
                                    @php
                                        $isWakafSelected = !is_null($oldWakafQty)
                                            ? array_key_exists($item->id, $oldWakafQty)
                                            : $selectedWakaf->has($item->id);
                                    @endphp
                                    <div class="wakaf-item {{ $isWakafSelected ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="wakaf">
                                        <div class="service-name">{{ $item->nama }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($wakaf as $item)
                                    @php
                                        $selectedItem = $selectedWakaf->get($item->id);
                                        $isWakafSelected = !is_null($oldWakafQty)
                                            ? array_key_exists($item->id, $oldWakafQty)
                                            : $selectedWakaf->has($item->id);
                                    @endphp
                                    <div id="form-wakaf-{{ $item->id }}"
                                        class="form-group {{ $isWakafSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->nama }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_wakaf[{{ $item->id }}]" min="0"
                                            value="{{ old('jumlah_wakaf.' . $item->id, $selectedItem ? $selectedItem->jumlah : 0) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- BADAL UMRAH FORM --}}
                        <div class="detail-form {{ in_array('badal', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="badal-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                            <div style="clear: both;"></div>

                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addBadal">Tambah
                                Badal</button>
                            <div id="badalWrapper">
                                {{-- PERBAIKAN: Logika untuk memuat 'old' ATAU data 'existing' --}}
                                @if (is_array(old('nama_badal')))
                                    {{-- Jika ada data 'old' (validasi gagal), render dari 'old' --}}
                                    @foreach (old('nama_badal') as $index => $oldNamaBadal)
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]"
                                                value="{{ old('badal_id.' . $index) }}">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal" name="nama_badal[]"
                                                    value="{{ $oldNamaBadal }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0"
                                                    value="{{ old('harga_badal.' . $index) }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]" value="{{ old('tanggal_badal.' . $index) }}">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Jika tidak ada data 'old', render dari database ($existingBadals) --}}
                                    @forelse($existingBadals as $index => $badal)
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]" value="{{ $badal->id }}">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal" name="nama_badal[]"
                                                    value="{{ $badal->name }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0" value="{{ $badal->price }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]" value="{{ $badal->tanggal_pelaksanaan }}">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @empty
                                        {{-- Jika tidak ada 'old' dan 'existing', tampilkan 1 form kosong --}}
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]" value="">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal"
                                                    name="nama_badal[]">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="form-actions">
                        <button type="submit" name="action" value="nego" class="btn btn-secondary">Simpan
                            sebagai Nego</button>
                        <button type="submit" name="action" value="deal" class="btn btn-primary">Simpan dan
                            Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TEMPLATE UNTUK CLONE/DUPLIKAT --}}
    <template id="ticket-template">
        <div class="ticket-form bg-white p-3 border mb-3">
            <input type="hidden" name="plane_id[]" value=""> {{-- Pastikan ada plane_id kosong --}}
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
            <div class="mt-3 text-end"><button type="button"
                    class="btn btn-danger btn-sm removeTicket">Hapus</button></div>
        </div>
    </template>

    <template id="hotel-template">
        <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
            <input type="hidden" name="hotel_id[]" value=""> {{-- Pastikan ada hotel_id kosong --}}
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
                <div class="col-md-4"><label class="form-label fw-semibold">Jumlah Tipe</label><input type="number"
                        class="form-control" name="jumlah_type[]" min="0" value="0"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Jumlah Kamar</label><input type="number"
                        class="form-control" name="jumlah_kamar[]" min="0" value="0"></div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus</button>
            </div>
        </div>
    </template>

    <template id="badal-template">
        <div class="badal-form bg-white p-3 border mb-3">
            <input type="hidden" name="badal_id[]" value=""> {{-- Pastikan ada badal_id kosong --}}
            <div class="form-group mb-2"><label class="form-label">Nama yang dibadalkan</label><input type="text"
                    class="form-control nama_badal" name="nama_badal[]"></div>
            <div class="form-group mb-2"><label class="form-label">Harga</label><input type="number"
                    class="form-control harga_badal" name="harga_badal[]" min="0"></div>
            <div class="form-group mb-2"><label class="form-label">Tanggal Pelaksanaan</label><input type="date"
                    class="form-control tanggal_badal" name="tanggal_badal[]"></div>
            <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                    Badal</button></div>
        </div>
    </template>

    <template id="transport-set-template">
        <div class="transport-set card p-3 mt-3" data-index="0">
            <input type="hidden" name="item_id[]" value="">
            <div class="cars">
                @foreach ($transportations as $data)
                    <div class="service-car" data-id="{{ $data->id }}"
                        data-routes='@json($data->routes)' data-name="{{ $data->nama }}"
                        data-price="{{ $data->harga }}">
                        <div class="service-name">{{ $data->nama }}</div>
                        <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                        <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                        <div class="service-desc">Harga: {{ number_format($data->harga) }}/hari</div>
                        <input type="radio" name="transportation_id[0]" value="{{ $data->id }}">
                    </div>
                @endforeach
            </div>
            <div class="route-select mt-3 hidden">
                <label class="form-label">Pilih Rute:</label>
                <select name="rute_id[0]" class="form-select">
                    <option value="">-- Pilih Rute --</option>
                </select>
            </div>
            <div class="form-row mt-3">
                <div class="form-col"><label class="form-label">Dari Tanggal</label><input type="date"
                        class="form-control" name="transport_dari[]"></div>
                <div class="form-col"><label class="form-label">Sampai Tanggal</label><input type="date"
                        class="form-control" name="transport_sampai[]"></div>
            </div>
            <div class="mt-2 text-end"><button type="button"
                    class="btn btn-danger btn-sm remove-transport">Hapus</button></div>
        </div>
    </template>

    <button type="button" id="backToServicesBtn" class="btn btn-primary" title="Kembali ke Pilihan Layanan">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ▼▼▼ JS UNTUK TOMBOL BACK TO TOP ▼▼▼
            const backToServicesBtn = document.getElementById('backToServicesBtn');
            const targetServiceGrid = document.getElementById('service-selection-grid');
            if (backToServicesBtn && targetServiceGrid) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > targetServiceGrid.offsetTop) {
                        backToServicesBtn.classList.add('show');
                    } else {
                        backToServicesBtn.classList.remove('show');
                    }
                });
                backToServicesBtn.addEventListener('click', function() {
                    targetServiceGrid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }
            // ▲▲▲ AKHIR JS BACK TO TOP ▲▲▲

            // Tombol "Kembali ke Pilihan Layanan" di dalam form
            document.querySelectorAll('.back-to-services-btn').forEach(button => {
                button.addEventListener('click', function() {
                    targetServiceGrid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // PERBAIKAN: Inisialisasi counter berdasarkan jumlah data 'old' ATAU 'existing'
            let hotelCounter =
                {{ old('nama_hotel') ? count(old('nama_hotel')) : ($existingHotels->count() > 0 ? $existingHotels->count() : 1) }};
            let transportCounter =
                {{ old('transportation_id') ? count(old('transportation_id')) : ($existingTransports->count() > 0 ? $existingTransports->count() : 1) }};
            let ticketCounter =
                {{ old('tanggal') ? count(old('tanggal')) : ($existingPlanes->count() > 0 ? $existingPlanes->count() : 1) }};
            let badalCounter =
                {{ old('nama_badal') ? count(old('nama_badal')) : ($existingBadals->count() > 0 ? $existingBadals->count() : 1) }};


            // --- FUNGSI UPDATE INFO TRAVEL ---
            const travelSelect = document.getElementById('travel-select');
            const penanggungInput = document.getElementById('penanggung');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            function updateTravelInfo() {
                const selectedOption = travelSelect.options[travelSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    penanggungInput.value = selectedOption.dataset.penanggung || '';
                    emailInput.value = selectedOption.dataset.email || '';
                    phoneInput.value = selectedOption.dataset.telepon || '';
                }
            }
            travelSelect.addEventListener('change', updateTravelInfo);
            // Tidak perlu panggil updateTravelInfo() saat load, karena sudah diisi oleh Blade (old/existing)


            // --- FUNGSI UNTUK TOMBOL "TAMBAH" ---

            document.getElementById('addTicket').addEventListener('click', function() {
                const template = document.getElementById('ticket-template').content.cloneNode(true);
                document.getElementById('ticketWrapper').appendChild(template);
                ticketCounter++;
            });

            document.getElementById('addHotel').addEventListener('click', function() {
                const template = document.getElementById('hotel-template').content.cloneNode(true);
                const hotelForm = template.querySelector('.hotel-form');
                hotelForm.dataset.index = hotelCounter;
                // Update name attributes for arrays
                hotelForm.querySelector('[name="hotel_id[]"]').name =
                    `hotel_id[${hotelCounter}]`; // Nama baru
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
                const badalForm = template.querySelector('.badal-form');

                badalForm.querySelector('[name="badal_id[]"]').name = `badal_id[${badalCounter}]`;
                badalForm.querySelector('[name="nama_badal[]"]').name = `nama_badal[${badalCounter}]`;
                badalForm.querySelector('[name="harga_badal[]"]').name = `harga_badal[${badalCounter}]`;
                badalForm.querySelector('[name="tanggal_badal[]"]').name = `tanggal_badal[${badalCounter}]`;

                document.getElementById('badalWrapper').appendChild(template);
                badalCounter++;
            });

            document.getElementById('add-transport-btn').addEventListener('click', function() {
                const template = document.getElementById('transport-set-template').content.cloneNode(true);
                const transportSet = template.querySelector('.transport-set');

                const newIndex = transportCounter;
                transportSet.dataset.index = newIndex;

                transportSet.querySelector('[name="item_id[]"]').name = `item_id[${newIndex}]`;
                transportSet.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.name = `transportation_id[${newIndex}]`;
                });
                transportSet.querySelector('select').name = `rute_id[${newIndex}]`;
                transportSet.querySelector('[name="transport_dari[]"]').name =
                    `transport_dari[${newIndex}]`; // PERBAIKAN: Ganti nama
                transportSet.querySelector('[name="transport_sampai[]"]').name =
                    `transport_sampai[${newIndex}]`; // PERBAIKAN: Ganti nama

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

                    // Toggle status
                    serviceItem.classList.toggle('selected');
                    const isSelected = serviceItem.classList.contains('selected'); // Dapatkan status baru
                    checkbox.checked = isSelected;

                    if (detailForm) {
                        detailForm.classList.toggle('hidden', !isSelected); // Sembunyikan/tampilkan form

                        detailForm.querySelectorAll('input, select, textarea, button').forEach(el => {
                            if (!el.classList.contains('back-to-services-btn')) {

                                // ▼▼▼ PERBAIKAN DIMULAI DI SINI ▼▼▼

                                // Pengecualian KHUSUS untuk service 'dokumen'
                                if (serviceType === 'dokumen' && isSelected) {
                                    // Saat MENGAKTIFKAN 'dokumen', JANGAN aktifkan
                                    // input-input spesifik ini secara paksa.
                                    // Biarkan mereka 'disabled' sampai dipilih manual.
                                    const name = el.getAttribute('name');
                                    if (name && (
                                            name.startsWith('child_documents') ||
                                            name.startsWith('jumlah_child_doc') ||
                                            name.startsWith('base_documents') ||
                                            name.startsWith('jumlah_base_doc') ||
                                            name.startsWith('customer_document_id')
                                        )) {
                                        // Lewati (return), jangan ubah status 'disabled'.
                                        // Biarkan Event 7 & 8 yang mengaturnya.
                                        return;
                                    }
                                }

                                // ▲▲▲ PERBAIKAN SELESAI ▲▲▲

                                // Logika normal:
                                // - Untuk service non-dokumen, ini akan toggle enable/disable.
                                // - Untuk service 'dokumen' saat di-UNCHECK, ini akan disable semua.
                                el.disabled = !isSelected;
                            }
                        });
                        if (isSelected) {
                            detailForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 2. Klik Pilihan Transportasi (Pesawat / Bus) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    const form = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
                    const checkbox = transportItem.querySelector('input');

                    transportItem.classList.toggle('selected');
                    const isSelected = transportItem.classList.contains('selected'); // Dapatkan status baru
                    checkbox.checked = isSelected;

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalam sub-form
                        form.querySelectorAll('input, select, textarea, button').forEach(el => {
                            // Jangan disable tombol "Tambah" atau "Hapus"
                            if (!el.classList.contains('removeTicket') && !el.classList.contains(
                                    'remove-transport') && !el.id.includes('addTicket') && !el.id
                                .includes('add-transport-btn')) {
                                el.disabled = !isSelected;
                            }
                        });
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 3. Klik Pilihan Handling (Hotel / Bandara) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    const form = document.getElementById(type === 'hotel' ? 'hotel-handling-form' :
                        'bandara-handling-form');
                    const checkbox = handlingItem.querySelector('input');

                    handlingItem.classList.toggle('selected');
                    const isSelected = handlingItem.classList.contains('selected'); // Dapatkan status baru
                    checkbox.checked = isSelected;

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalamnya
                        form.querySelectorAll('input, select, textarea').forEach(el => {
                            el.disabled = !isSelected;
                        });
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 4. Klik Item Pilihan (Pendamping, Konten, Meal, dll) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
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
                        const isSelected = toggleItem.classList.toggle('selected');

                        if (form) {
                            form.classList.toggle('hidden', !isSelected);
                            // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalamnya
                            form.querySelectorAll('input, select, textarea').forEach(el => {
                                el.disabled = !isSelected;
                            });

                            const qtyInput = form.querySelector('input[type="number"]');
                            if (qtyInput) {
                                if (isSelected && (qtyInput.value === '0' || qtyInput.value === '')) {
                                    qtyInput.value = 1;
                                }
                            }
                        }

                        if (type === 'tour') {
                            const tourCheckbox = toggleItem.querySelector('input[type="checkbox"]');
                            if (tourCheckbox) tourCheckbox.checked = isSelected;
                        }
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

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
                    const isSelected = documentItem.classList.contains('selected');
                    checkbox.checked = isSelected;

                    let form;
                    if (hasChildren) {
                        form = document.querySelector(`.document-child-form[data-parent-id="${docId}"]`);
                    } else {
                        form = document.getElementById(`doc-${docId}-form`);
                    }

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);

                        // ▼▼▼ PERBAIKAN DIMULAI DI SINI ▼▼▼
                        form.querySelectorAll('input, select').forEach(input => {

                            // Pengecualian KHUSUS untuk parent yang punya 'children' (e.g. Visa)
                            if (hasChildren && isSelected) {
                                // Saat MENGAKTIFKAN parent ('Visa'), JANGAN aktifkan
                                // input-input child-nya secara paksa.
                                const name = input.getAttribute('name');
                                if (name && (
                                        name.startsWith('child_documents') ||
                                        name.startsWith('jumlah_child_doc') ||
                                        name.startsWith('customer_document_id')
                                    )) {
                                    // Lewati (return), biarkan 'disabled'.
                                    // Event 8 (klik child) yang akan mengaturnya.
                                    return;
                                }
                            }

                            // Logika normal:
                            // - Untuk 'base' doc (Siskopatuh), ini akan toggle enable/disable (INI BENAR).
                            // - Untuk 'parent' doc (Visa) saat di-UNCHECK, ini akan disable semua (INI BENAR).
                            input.disabled = !isSelected;
                        });
                        // ▲▲▲ AKHIR PERBAIKAN ▲▲▲
                    }
                }

                // --- 8. Klik Pilihan Dokumen (Anak) ---
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const childId = childItem.dataset.childId;
                    const form = document.getElementById(`doc-child-form-${childId}`);

                    childItem.classList.toggle('selected');
                    const isSelected = childItem.classList.contains('selected');

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        form.querySelectorAll('input, select').forEach(input => {
                            input.disabled = !isSelected;
                        });
                    }
                }

                // --- 9. Tombol Hapus Dinamis ---
                const removeAction = (e, wrapperId, itemClass, minItems = 0, alertMsg =
                    'Minimal harus ada 1 form.') => {
                    const wrapper = e.target.closest(wrapperId);
                    if (wrapper.querySelectorAll(itemClass).length > minItems) {
                        e.target.closest(itemClass).remove();
                    } else {
                        if (minItems > 0) alert(alertMsg);
                        else e.target.closest(itemClass).remove();
                    }
                };

                if (e.target.matches('.removeTicket')) {
                    removeAction(e, '#ticketWrapper', '.ticket-form', 0);
                }
                if (e.target.matches('.remove-transport')) {
                    removeAction(e, '#new-transport-forms', '.transport-set', 0);
                }
                if (e.target.matches('.removeHotel')) {
                    removeAction(e, '#hotelWrapper', '.hotel-form', 0);
                }
                if (e.target.matches('.removeBadal')) {
                    removeAction(e, '#badalWrapper', '.badal-form', 0);
                }

                // --- 10. Klik Reyal ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const reyalCard = e.target.closest('.card-reyal');
                if (reyalCard) {
                    document.querySelectorAll('.card-reyal').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('.card-reyal input[type="radio"]').forEach(radio => radio
                        .checked = false);
                    reyalCard.classList.add('selected');
                    const type = reyalCard.dataset.reyalType;
                    const radioInput = reyalCard.querySelector('input[type="radio"]');
                    if (radioInput) radioInput.checked = true;

                    const formTamis = document.getElementById('form-tamis');
                    const formTumis = document.getElementById('form-tumis');
                    formTamis.classList.toggle('hidden', type !== 'tamis');
                    formTumis.classList.toggle('hidden', type !== 'tumis');

                    // 💡 PERBAIKAN UTAMA: Nonaktifkan input di form yang tersembunyi
                    formTamis.querySelectorAll('input').forEach(el => el.disabled = (type !== 'tamis'));
                    formTumis.querySelectorAll('input').forEach(el => el.disabled = (type !== 'tumis'));
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲
            });

            // --- Kalkulasi Reyal (Sama seperti create) ---
            document.body.addEventListener('input', function(e) {
                const input = e.target;
                if (input.id === 'rupiah-tamis' || input.id === 'kurs-tamis') {
                    const rupiah = parseFloat(document.getElementById('rupiah-tamis').value);
                    const kurs = parseFloat(document.getElementById('kurs-tamis').value);
                    document.getElementById('hasil-tamis').value = (!isNaN(rupiah) && !isNaN(kurs) && kurs >
                        0) ? (rupiah / kurs).toFixed(2) : '';
                }
                if (input.id === 'reyal-tumis' || input.id === 'kurs-tumis') {
                    const reyal = parseFloat(document.getElementById('reyal-tumis').value);
                    const kurs = parseFloat(document.getElementById('kurs-tumis').value);
                    document.getElementById('hasil-tumis').value = (!isNaN(reyal) && !isNaN(kurs) && kurs >
                        0) ? (reyal * kurs).toFixed(2) : '';
                }
            });

        });
    </script>
@endsection
