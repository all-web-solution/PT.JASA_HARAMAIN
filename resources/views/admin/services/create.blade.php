@extends('admin.master')
@section('title', 'Tambah Permintaan Service')
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

        .form-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
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

        .service-option,
        .service-item,
        .transport-item,
        .type-item,
        .service-car,
        .handling-item,
        .document-item,
        .child-item,
        .content-item,
        .visa-item,
        .vaksin-item,
        .service-tour,
        .service-tour-makkah,
        .service-tour-madinah,
        .service-tour-al-ula,
        .service-tour-thoif,
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

        .service-option:hover,
        .service-item:hover,
        .transport-item:hover,
        .type-item:hover,
        .service-car:hover,
        .handling-item:hover,
        .document-item:hover,
        .child-item:hover,
        .content-item:hover,
        .visa-item:hover,
        .vaksin-item:hover,
        .service-tour:hover,
        .service-tour-makkah:hover,
        .service-tour-madinah:hover,
        .service-tour-al-ula:hover,
        .service-tour-thoif:hover,
        .pendamping-item:hover,
        .meal-item:hover,
        .dorongan-item:hover,
        .wakaf-item:hover,
        .transport-option:hover {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-option.selected,
        .service-item.selected,
        .transport-item.selected,
        .type-item.selected,
        .handling-item.selected,
        .service-car.selected,
        .document-item.selected,
        .child-item.selected,
        .content-item.selected,
        .visa-item.selected,
        .vaksin-item.selected,
        .service-tour.selected,
        .service-tour-makkah.selected,
        .service-tour-madinah.selected,
        .service-tour-al-ula.selected,
        .service-tour-thoif.selected,
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

        .btn-primary {
            background-color: var(--haramain-secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
            color: var(--text-secondary);
        }

        .btn-submit {
            background-color: var(--success-color);
            color: white;
        }

        .btn-submit:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-grid,
            .cars,
            .tours {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .card-title {
                display: none;
            }
        }

        .hidden {
            display: none !important;
        }

        .card-reyal.selected {
            border: 2px solid var(--haramain-secondary);
            background-color: var(--haramain-light);
        }


        .validation-error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        #backToServicesBtn {
            visibility: hidden;
            opacity: 0;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border-radius: 50%;
            padding: 0.6rem 0.9rem;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #backToServicesBtn.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endpush
@section('content')

    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle"></i>Tambah Permintaan Service Baru
                </h5>
                <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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

                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-control" name="travel" id="travel-select" required>
                                        {{-- Tambahkan 'selected' jika old('travel') kosong --}}
                                        <option value="" disabled {{ !old('travel') ? 'selected' : '' }}>Pilih Travel
                                        </option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                                data-email="{{ $pelanggan->email }}" data-telepon="{{ $pelanggan->phone }}"
                                                {{ old('travel') == $pelanggan->id ? 'selected' : '' }}>
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
                                        value="{{ old('penanggung_jawab') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required id="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" required id="phone"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required
                                        value="{{ old('tanggal_keberangkatan') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ old('tanggal_kepulangan') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ old('total_jamaah') }}">
                        </div>
                    </div>

                    @php
                        $oldServices = old('services', []);
                        $oldTransportTypes = old('transportation', []);
                        $oldHandlingTypes = old('handlings', []);
                        $oldReyalTipe = old('tipe');
                        $oldTourIds = old('tour_ids', []);
                        $oldDocParents = old('dokumen_id', []);
                        $oldDocChildrenQty = old('jumlah_child_doc', []);
                        $oldDocBaseQty = collect(request()->old())->filter(
                            fn($val, $key) => str_starts_with($key, 'jumlah_doc_'),
                        );
                        $oldPendampingQty = old('jumlah_pendamping', []);
                        $oldKontenQty = old('jumlah_konten', []);
                        $oldMealsQty = old('jumlah_meals', []);
                        $oldDoronganQty = old('jumlah_dorongan', []);
                        $oldWakafQty = old('jumlah_wakaf', []);
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
        ] as $key => $service)
                                <div class="service-item {{ in_array($key, $oldServices) ? 'selected' : '' }}"
                                    data-service="{{ $key }}">
                                    <div class="service-icon"><i class="bi {{ $service['icon'] }}"></i></div>
                                    <div class="service-name">{{ $service['name'] }}</div>
                                    <div class="service-desc">{{ $service['desc'] }}</div>
                                    <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none"
                                        {{ in_array($key, $oldServices) ? 'checked' : '' }}>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SECTION DETAIL PERMINTAAN --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>

                        {{-- TRANSPORTASI FORM --}}
                        {{-- PERBAIKAN: Tampilkan form jika 'transportasi' ada di 'oldServices' --}}
                        <div class="detail-form {{ in_array('transportasi', $oldServices) ? '' : 'hidden' }}"
                            id="transportasi-details">
                            <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    {{-- PERBAIKAN: Tambahkan 'selected' dan 'checked' berdasarkan 'oldTransportTypes' --}}
                                    <div class="transport-item {{ in_array('airplane', $oldTransportTypes) ? 'selected' : '' }}"
                                        data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" class="d-none"
                                            {{ in_array('airplane', $oldTransportTypes) ? 'checked' : '' }}>
                                    </div>
                                    <div class="transport-item {{ in_array('bus', $oldTransportTypes) ? 'selected' : '' }}"
                                        data-transportasi="bus">
                                        <div class="service-name">Transportasi darat</div>
                                        <input type="checkbox" name="transportation[]" value="bus" class="d-none"
                                            {{ in_array('bus', $oldTransportTypes) ? 'checked' : '' }}>
                                    </div>
                                </div>

                                {{-- FORM PESAWAT --}}
                                <div class="form-group {{ in_array('airplane', $oldTransportTypes) ? '' : 'hidden' }}"
                                    data-transportasi="airplane" id="pesawat">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary mb-3" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        {{-- PERBAIKAN: Loop data 'old' untuk tiket pesawat --}}
                                        @if (is_array(old('tanggal')))
                                            @foreach (old('tanggal') as $index => $oldTanggal)
                                                <div class="ticket-form bg-white p-3 border mb-3">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Tanggal
                                                                Keberangkatan</label>
                                                            <input type="date" class="form-control" name="tanggal[]"
                                                                value="{{ $oldTanggal }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Rute</label>
                                                            <input type="text" class="form-control" name="rute[]"
                                                                placeholder="Contoh: CGK - JED"
                                                                value="{{ old('rute.' . $index) }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Maskapai</label>
                                                            <input type="text" class="form-control" name="maskapai[]"
                                                                placeholder="Nama maskapai"
                                                                value="{{ old('maskapai.' . $index) }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                name="keterangan_tiket[]" placeholder="Keterangan"
                                                                value="{{ old('keterangan_tiket.' . $index) }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="paspor-tiket-{{ $index }}"
                                                                class="form-label">Jumlah (Jamaah)</label>
                                                            <input type="number" class="form-control"
                                                                id="paspor-tiket-{{ $index }}" name="jumlah[]"
                                                                value="{{ old('jumlah.' . $index) }}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Form default jika tidak ada data 'old' --}}
                                            <div class="ticket-form bg-white p-3 border mb-3">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Tanggal Keberangkatan</label>
                                                        <input type="date" class="form-control" name="tanggal[]">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Rute</label>
                                                        <input type="text" class="form-control" name="rute[]"
                                                            placeholder="Contoh: CGK - JED">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Maskapai</label>
                                                        <input type="text" class="form-control" name="maskapai[]"
                                                            placeholder="Nama maskapai">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Keterangan</label>
                                                        <input type="text" class="form-control"
                                                            name="keterangan_tiket[]" placeholder="Keterangan">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="paspor-tiket-0" class="form-label">Jumlah
                                                            (Jamaah)</label>
                                                        <input type="number" class="form-control" id="paspor-tiket-0"
                                                            name="jumlah[]">
                                                    </div>
                                                </div>
                                                <div class="mt-3 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- FORM TRANSPORTASI DARAT --}}
                                <div class="form-group {{ in_array('bus', $oldTransportTypes) ? '' : 'hidden' }}"
                                    data-transportasi="bus" id="bis">
                                    <label class="form-label">Transportasi darat</label>
                                    @error('transportation_id')
                                        <div class="validation-error-message">{{ $message }}</div>
                                    @enderror
                                    @error('rute_id.*')
                                        <div class="validation-error-message">Rute wajib dipilih untuk setiap transportasi
                                            darat.</div>
                                    @enderror
                                    @error('tanggal_transport.*.dari')
                                        <div class="validation-error-message">Tanggal "Dari" wajib diisi.</div>
                                    @enderror
                                    @error('tanggal_transport.*.sampai')
                                        <div class="validation-error-message">{{ $message }}</div>
                                    @enderror

                                    <button type="button" class="btn btn-submit" id="add-transport-btn">Tambah
                                        Transportasi</button>

                                    <div id="new-transport-forms">
                                        {{-- PERBAIKAN: Loop data 'old' untuk transportasi darat --}}
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
                                                    <div class="cars">
                                                        @foreach ($transportations as $i => $data)
                                                            <div class="service-car {{ $oldTransportId == $data->id ? 'selected' : '' }}"
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
                                                                    {{ $oldTransportId == $data->id ? 'checked' : '' }}>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="route-select {{ $selectedTransport ? '' : 'hidden' }}">
                                                        <label class="form-label mt-2">Pilih Rute:</label>
                                                        <select name="rute_id[{{ $index }}]" class="form-control">
                                                            <option value="">-- Pilih Rute --</option>
                                                            @if ($selectedTransport)
                                                                @foreach ($selectedTransport->routes as $route)
                                                                    <option value="{{ $route->id }}"
                                                                        {{ $oldRouteId == $route->id ? 'selected' : '' }}>
                                                                        {{ $route->route }} - Rp.
                                                                        {{ number_format($route->price) }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="route-select">
                                                        <label class="form-label mt-2">Dari tanggal:</label>
                                                        <input type="date"
                                                            name="tanggal_transport[{{ $index }}][dari]"
                                                            class="form-control"
                                                            value="{{ old('tanggal_transport.' . $index . '.dari') }}">
                                                    </div>

                                                    <div class="route-select">
                                                        <label class="form-label mt-2">Sampai tanggal:</label>
                                                        <input type="date"
                                                            name="tanggal_transport[{{ $index }}][sampai]"
                                                            class="form-control"
                                                            value="{{ old('tanggal_transport.' . $index . '.sampai') }}">
                                                    </div>

                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Form default jika tidak ada data 'old' --}}
                                            <div class="transport-set card p-3 mt-3" data-index="0">
                                                <div class="cars">
                                                    @foreach ($transportations as $i => $data)
                                                        <div class="service-car" data-id="{{ $data->id }}"
                                                            data-routes='@json($data->routes)'
                                                            data-name="{{ $data->nama }}"
                                                            data-price="{{ $data->harga }}">
                                                            <div class="service-name">{{ $data->nama }}</div>
                                                            <div class="service-desc">Kapasitas: {{ $data->kapasitas }}
                                                            </div>
                                                            <div class="service-desc">Fasilitas: {{ $data->fasilitas }}
                                                            </div>
                                                            <div class="service-desc">Harga:
                                                                {{ number_format($data->harga) }}/hari</div>
                                                            <input type="radio" name="transportation_id[0]"
                                                                value="{{ $data->id }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="route-select hidden">
                                                    <label class="form-label mt-2">Pilih Rute:</label>
                                                    <select name="rute_id[0]" class="form-control">
                                                        <option value="">-- Pilih Rute --</option>
                                                    </select>
                                                </div>
                                                <div class="route-select">
                                                    <label class="form-label mt-2">Dari tanggal:</label>
                                                    <input type="date" name="tanggal_transport[0][dari]"
                                                        class="form-control">
                                                </div>
                                                <div class="route-select">
                                                    <label class="form-label mt-2">Sampai tanggal:</label>
                                                    <input type="date" name="tanggal_transport[0][sampai]"
                                                        class="form-control">
                                                </div>
                                                <div class="mt-2 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HOTEL FORM --}}
                        <div class="detail-form {{ in_array('hotel', $oldServices) ? '' : 'hidden' }}"
                            id="hotel-details">
                            <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addHotel">Tambah
                                Hotel</button>
                            <div id="hotelWrapper">
                                {{-- PERBAIKAN: Loop data 'old' untuk hotel --}}
                                @if (is_array(old('nama_hotel')))
                                    @foreach (old('nama_hotel') as $index => $oldNamaHotel)
                                        <div class="hotel-form bg-white p-3 border mb-3"
                                            data-index="{{ $index }}">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal Checkin</label>
                                                    <input type="date" class="form-control"
                                                        name="tanggal_checkin[{{ $index }}]"
                                                        value="{{ old('tanggal_checkin.' . $index) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal Checkout</label>
                                                    <input type="date" class="form-control"
                                                        name="tanggal_checkout[{{ $index }}]"
                                                        value="{{ old('tanggal_checkout.' . $index) }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Nama Hotel</label>
                                                    <input type="text" class="form-control"
                                                        name="nama_hotel[{{ $index }}]" placeholder="Nama hotel"
                                                        data-field="nama_hotel" value="{{ $oldNamaHotel }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Tipe Kamar</label>
                                                    <div class="service-grid">
                                                        @php
                                                            // Dapatkan tipe kamar yang dipilih untuk hotel[index] ini
                                                            $oldHotelTypes = array_keys(
                                                                old('hotel_data.' . $index, []),
                                                            );
                                                        @endphp
                                                        @foreach ($types as $type)
                                                            <div class="type-item {{ in_array($type->id, $oldHotelTypes) ? 'selected' : '' }}"
                                                                data-type-id="{{ $type->id }}"
                                                                data-price="{{ $type->jumlah }}"
                                                                data-name="{{ $type->nama_tipe }}">
                                                                <div class="service-name">{{ $type->nama_tipe }}</div>
                                                                {{-- Checkbox 'type[]' tidak terlalu penting, tapi 'hotel_data' iya --}}
                                                                <input type="checkbox" name="type[]"
                                                                    value="{{ $type->nama_tipe }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="type-input-container">
                                                        {{-- Render ulang input tipe kamar yang sudah dipilih --}}
                                                        @if (isset($oldHotelTypes))
                                                            @foreach ($oldHotelTypes as $oldTypeId)
                                                                @php
                                                                    $type = $types->firstWhere('id', $oldTypeId);
                                                                    $oldTypeData = old(
                                                                        'hotel_data.' . $index . '.' . $oldTypeId,
                                                                    );
                                                                @endphp
                                                                @if ($type && $oldTypeData)
                                                                    <div class="form-group mt-2 bg-white p-3 border rounded"
                                                                        data-type-id="{{ $oldTypeId }}">
                                                                        <label class="form-label">Jumlah Kamar
                                                                            ({{ $type->nama_tipe }})
                                                                        </label>
                                                                        <input type="number"
                                                                            class="form-control qty-input-hotel"
                                                                            name="hotel_data[{{ $index }}][{{ $oldTypeId }}][jumlah]"
                                                                            min="1"
                                                                            value="{{ $oldTypeData['jumlah'] }}"
                                                                            data-is-qty="true"
                                                                            data-type-id="{{ $oldTypeId }}">
                                                                        <label class="form-label mt-2">Harga
                                                                            ({{ $type->nama_tipe }})</label>
                                                                        <input type="text" class="form-control"
                                                                            name="hotel_data[{{ $index }}][{{ $oldTypeId }}][harga]"
                                                                            value="{{ $oldTypeData['harga'] }}" readonly>
                                                                        <input type="hidden"
                                                                            name="hotel_data[{{ $index }}][{{ $oldTypeId }}][type_name]"
                                                                            value="{{ $type->nama_tipe }}">
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2">
                                                <label class="form-label">Total kamar</label>
                                                <input type="number" class="form-control"
                                                    name="jumlah_kamar[{{ $index }}]" min="0"
                                                    value="{{ old('jumlah_kamar.' . $index) }}">
                                            </div>
                                            <div class="form-group mt-2">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" class="form-control"
                                                    name="keterangan[{{ $index }}]" min="0"
                                                    value="{{ old('keterangan.' . $index) }}">
                                            </div>
                                            <div class="mt-3 text-end">
                                                <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                                                    Hotel</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Form default jika tidak ada data 'old' --}}
                                    <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Tanggal Checkin</label>
                                                <input type="date" class="form-control" name="tanggal_checkin[0]">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Tanggal Checkout</label>
                                                <input type="date" class="form-control" name="tanggal_checkout[0]">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Nama Hotel</label>
                                                <input type="text" class="form-control" name="nama_hotel[0]"
                                                    placeholder="Nama hotel" data-field="nama_hotel">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Tipe Kamar</label>
                                                <div class="service-grid">
                                                    @foreach ($types as $type)
                                                        <div class="type-item" data-type-id="{{ $type->id }}"
                                                            data-price="{{ $type->jumlah }}"
                                                            data-name="{{ $type->nama_tipe }}">
                                                            <div class="service-name">{{ $type->nama_tipe }}</div>
                                                            <input type="checkbox" name="type[]"
                                                                value="{{ $type->nama_tipe }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="type-input-container"></div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label class="form-label">Total kamar</label>
                                            <input type="number" class="form-control" name="jumlah_kamar[0]"
                                                min="0">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label class="form-label">Keterangan</label>
                                            <input type="text" class="form-control" name="keterangan[0]"
                                                min="0">
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                                                Hotel</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- DOKUMEN FORM --}}
                        <div class="detail-form {{ in_array('dokumen', $oldServices) ? '' : 'hidden' }}"
                            id="dokumen-details">
                            <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($documents as $document)
                                        @php
                                            $isParentSelected = in_array($document->id, $oldDocParents);
                                            $isBaseSelected = $oldDocBaseQty->has('jumlah_doc_' . $document->id);
                                        @endphp
                                        <div class="document-item {{ $isParentSelected || $isBaseSelected ? 'selected' : '' }}"
                                            data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}"
                                            data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                            <div class="service-name">{{ $document->name }}</div>
                                            <input type="checkbox" name="dokumen_id[]" value="{{ $document->id }}"
                                                {{ $isParentSelected || $isBaseSelected ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="document-forms-container">
                                @foreach ($documents as $document)
                                    @if ($document->childrens->isNotEmpty())
                                        <div class="form-group {{ in_array($document->id, $oldDocParents) ? '' : 'hidden' }} document-child-form"
                                            data-parent-id="{{ $document->id }}">
                                            <label class="form-label">{{ $document->name }}</label>
                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    <div class="child-item {{ array_key_exists($child->id, $oldDocChildrenQty) ? 'selected' : '' }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-price="{{ $child->price }}"
                                                        data-name="{{ $child->name }}">
                                                        <div class="child-name">{{ $child->name }}</div>
                                                        <div class="child-name">Rp. {{ number_format($child->price) }}
                                                        </div>
                                                        <input type="checkbox" name="child_documents[]"
                                                            value="{{ $child->id }}"
                                                            {{ array_key_exists($child->id, $oldDocChildrenQty) ? 'checked' : '' }}>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @foreach ($document->childrens as $child)
                                                <div id="doc-child-form-{{ $child->id }}"
                                                    class="form-group mt-2 bg-white p-3 border rounded {{ array_key_exists($child->id, $oldDocChildrenQty) ? '' : 'hidden' }}">
                                                    <label class="form-label">Jumlah {{ $child->name }}</label>
                                                    <input type="number" class="form-control jumlah-child-doc"
                                                        data-parent-id="{{ $document->id }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-name="{{ $child->name }}"
                                                        data-price="{{ $child->price }}" min="1"
                                                        value="{{ old('jumlah_child_doc.' . $child->id, 1) }}"
                                                        name="jumlah_child_doc[{{ $child->id }}]">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="form-group {{ $oldDocBaseQty->has('jumlah_doc_' . $document->id) ? '' : 'hidden' }} document-base-form"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}"
                                            data-price="{{ $document->price }}" data-name="{{ $document->name }}">
                                            <label class="form-label">Jumlah {{ $document->name }}</label>
                                            <input type="number" class="form-control"
                                                name="jumlah_doc_{{ $document->id }}" min="1"
                                                value="{{ old('jumlah_doc_' . $document->id) }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- HANDLING FORM --}}
                        <div class="detail-form {{ in_array('handling', $oldServices) ? '' : 'hidden' }}"
                            id="handling-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="handling-item {{ in_array('hotel', $oldHandlingTypes) ? 'selected' : '' }}"
                                        data-handling="hotel" data-name="Hotel Handling">
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" class="d-none"
                                            {{ in_array('hotel', $oldHandlingTypes) ? 'checked' : '' }}>
                                    </div>
                                    <div class="handling-item {{ in_array('bandara', $oldHandlingTypes) ? 'selected' : '' }}"
                                        data-handling="bandara" data-name="Bandara Handling">
                                        <div class="service-name">Bandara</div>
                                        <input type="checkbox" name="handlings[]" value="bandara" class="d-none"
                                            {{ in_array('bandara', $oldHandlingTypes) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ in_array('hotel', $oldHandlingTypes) ? '' : 'hidden' }}"
                                id="hotel-handling-form">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Hotel</label><input
                                            type="text" class="form-control" name="nama_hotel_handling"
                                            value="{{ old('nama_hotel_handling') }}"></div>
                                    <div class="form-col"><label class="form-label">Tanggal</label><input type="date"
                                            class="form-control" name="tanggal_hotel_handling"
                                            value="{{ old('tanggal_hotel_handling') }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_hotel_handling"
                                            value="{{ old('harga_hotel_handling') }}"></div>
                                    <div class="form-col"><label class="form-label">Pax</label><input type="text"
                                            class="form-control" name="pax_hotel_handling"
                                            value="{{ old('pax_hotel_handling') }}"></div>
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
                            <div class="form-group {{ in_array('bandara', $oldHandlingTypes) ? '' : 'hidden' }}"
                                id="bandara-handling-form">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Bandara</label><input
                                            type="text" class="form-control" name="nama_bandara_handling"
                                            value="{{ old('nama_bandara_handling') }}"></div>
                                    <div class="form-col"><label class="form-label">Jumlah Jamaah</label><input
                                            type="text" class="form-control" name="jumlah_jamaah_handling"
                                            value="{{ old('jumlah_jamaah_handling') }}"></div>
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_bandara_handling"
                                            value="{{ old('harga_bandara_handling') }}"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Kedatangan Jamaah</label><input
                                            type="date" class="form-control" name="kedatangan_jamaah_handling"
                                            value="{{ old('kedatangan_jamaah_handling') }}"></div>
                                    <div class="form-col"><label class="form-label">Paket Info</label><input
                                            type="file" class="form-control" name="paket_info"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Sopir</label><input
                                            type="text" class="form-control" name="nama_supir"
                                            value="{{ old('nama_supir') }}"></div>
                                    <div class="form-col"><label class="form-label">Identitas Koper</label><input
                                            type="file" class="form-control" name="identitas_koper_bandara_handling">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING FORM --}}
                        <div class="detail-form {{ in_array('pendamping', $oldServices) ? '' : 'hidden' }}"
                            id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Pendamping</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($guides as $guide)
                                        <div class="pendamping-item {{ array_key_exists($guide->id, $oldPendampingQty) ? 'selected' : '' }}"
                                            data-id="{{ $guide->id }}" data-price="{{ $guide->harga }}"
                                            data-name="{{ $guide->nama }}" data-type="pendamping">
                                            <div class="service-name">{{ $guide->nama }}</div>
                                            <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    <div id="form-pendamping-{{ $guide->id }}"
                                        class="form-group {{ array_key_exists($guide->id, $oldPendampingQty) ? '' : 'hidden' }}">
                                        <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $guide->id }}" data-name="{{ $guide->nama }}"
                                            data-price="{{ $guide->harga }}" data-type="pendamping"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="1"
                                            value="{{ old('jumlah_pendamping.' . $guide->id) }}">
                                        <div class="form-row d-flex gap-3 mt-2">
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Dari</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_pendamping[{{ $guide->id }}][dari]"
                                                    value="{{ old('tanggal_pendamping.' . $guide->id . '.dari') }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Sampai</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_pendamping[{{ $guide->id }}][sampai]"
                                                    value="{{ old('tanggal_pendamping.' . $guide->id . '.sampai') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form {{ in_array('konten', $oldServices) ? '' : 'hidden' }}"
                            id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Content</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($contents as $content)
                                        <div class="content-item {{ array_key_exists($content->id, $oldKontenQty) ? 'selected' : '' }}"
                                            data-id="{{ $content->id }}" data-name="{{ $content->name }}"
                                            data-price="{{ $content->price }}" data-type="konten">
                                            <div class="service-name">{{ $content->name }}</div>
                                            <div class="service-desc">Rp. {{ number_format($content->price) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    <div id="form-konten-{{ $content->id }}"
                                        class="form-group {{ array_key_exists($content->id, $oldKontenQty) ? '' : 'hidden' }}">
                                        <div class="form-row d-flex gap-3 mt-2">
                                            <div class="form-col">
                                                <label class="form-label">Jumlah {{ $content->name }}</label>
                                                <input type="number" class="form-control jumlah-item"
                                                    data-id="{{ $content->id }}" data-name="{{ $content->name }}"
                                                    data-price="{{ $content->price }}" data-type="konten"
                                                    name="jumlah_konten[{{ $content->id }}]" min="1"
                                                    value="{{ old('jumlah_konten.' . $content->id) }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_konten[{{ $content->id }}]"
                                                    value="{{ old('tanggal_konten.' . $content->id) }}">
                                            </div>
                                        </div>
                                        <label for="keterangan_konten" class="form-label mt-3">Keterangan</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_konten[{{ $content->id }}]"
                                            value="{{ old('keterangan_konten.' . $content->id) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form {{ in_array('reyal', $oldServices) ? '' : 'hidden' }}"
                            id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Penukaran mata uang</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tamis' ? 'selected' : '' }}"
                                        data-reyal-type="tamis">
                                        <h5>Tamis</h5>
                                        <p>Rupiah → Reyal</p>
                                        <input type="radio" name="tipe" value="tamis"
                                            {{ $oldReyalTipe == 'tamis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tumis' ? 'selected' : '' }}"
                                        data-reyal-type="tumis">
                                        <h5>Tumis</h5>
                                        <p>Reyal → Rupiah</p>
                                        <input type="radio" name="tipe" value="tumis"
                                            {{ $oldReyalTipe == 'tumis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tamis' ? '' : 'hidden' }}"
                                id="form-tamis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Rupiah → Reyal</h6>
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah"
                                        value="{{ old('jumlah_rupiah') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis"
                                        value="{{ old('kurs_tamis') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis"
                                        readonly value="{{ old('hasil_tamis') }}">
                                </div>
                            </div>
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tumis' ? '' : 'hidden' }}"
                                id="form-tumis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Reyal → Rupiah</h6>
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal"
                                        value="{{ old('jumlah_reyal') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis"
                                        value="{{ old('kurs_tumis') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis"
                                        readonly value="{{ old('hasil_tumis') }}">
                                </div>
                            </div>
                            <label class="form-label mt-2">Tanggal penyerahan</label>
                            <input type="date" class="form-control" name="tanggal_penyerahan"
                                value="{{ old('tanggal_penyerahan') }}">
                        </div>

                        {{-- TOUR FORM --}}
                        <div class="detail-form {{ in_array('tour', $oldServices) ? '' : 'hidden' }}" id="tour-details">
                            <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($tours as $tour)
                                        <div class="service-tour selectable-item {{ in_array($tour->id, $oldTourIds) ? 'selected' : '' }}"
                                            data-id="{{ $tour->id }}" data-name="{{ $tour->name }}">
                                            <div class="service-name">{{ $tour->name }}</div>
                                            <input type="checkbox" name="tour_ids[]" value="{{ $tour->id }}"
                                                {{ in_array($tour->id, $oldTourIds) ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tours as $tour)
                                @php
                                    $oldTourTransport = old('tour_transport.' . $tour->id);
                                @endphp
                                <div id="tour-{{ $tour->id }}-form"
                                    class="tour-form {{ in_array($tour->id, $oldTourIds) ? '' : 'hidden' }}">
                                    <h6 class="detail-title">Transportasi untuk Tour {{ $tour->name }}</h6>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Tour</label>
                                        <input type="date" class="form-control"
                                            name="tanggal_tour[{{ $tour->id }}]"
                                            value="{{ old('tanggal_tour.' . $tour->id) }}">
                                    </div>
                                    <div class="service-grid">
                                        @foreach ($transportations as $trans)
                                            <div class="transport-option selectable-item {{ $oldTourTransport == $trans->id ? 'selected' : '' }}"
                                                data-tour-id="{{ $tour->id }}" data-trans-id="{{ $trans->id }}"
                                                data-price="{{ $trans->harga }}" data-tour-name="{{ $tour->name }}"
                                                data-trans-name="{{ $trans->nama }}">
                                                <div class="service-name">{{ $trans->nama }}</div>
                                                <div class="service-desc">Kapasitas: {{ $trans->kapasitas ?? 'N/A' }}
                                                </div>
                                                <div class="service-desc">Fasilitas: {{ $trans->fasilitas ?? 'N/A' }}
                                                </div>
                                                <div class="service-desc">Harga: Rp {{ number_format($trans->harga) }}
                                                </div>
                                                <input type="radio" name="tour_transport[{{ $tour->id }}]"
                                                    value="{{ $trans->id }}"
                                                    {{ $oldTourTransport == $trans->id ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- MEALS FORM --}}
                        <div class="detail-form {{ in_array('meals', $oldServices) ? '' : 'hidden' }}"
                            id="meals-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Makanan</h6>
                            <div class="service-grid">
                                @foreach ($meals as $meal)
                                    <div class="meal-item {{ array_key_exists($meal->id, $oldMealsQty) ? 'selected' : '' }}"
                                        data-id="{{ $meal->id }}" data-name="{{ $meal->name }}"
                                        data-price="{{ $meal->price }}" data-type="meal">
                                        <div class="service-name">{{ $meal->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($meals as $meal)
                                    <div id="form-meal-{{ $meal->id }}"
                                        class="form-group {{ array_key_exists($meal->id, $oldMealsQty) ? '' : 'hidden' }}"
                                        style="margin-bottom: 50px">
                                        <label class="form-label">Jumlah {{ $meal->name }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $meal->id }}" data-name="{{ $meal->name }}"
                                            data-price="{{ $meal->price }}" data-type="meal"
                                            name="jumlah_meals[{{ $meal->id }}]" min="1"
                                            value="{{ old('jumlah_meals.' . $meal->id) }}">
                                        <div class="form-row d-flex gap-3 mt-2">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="dari_tanggal_makanan[{{ $meal->id }}][dari]"
                                                    value="{{ old('dari_tanggal_makanan.' . $meal->id . '.dari') }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="sampai_tanggal_makanan[{{ $meal->id }}][sampai]"
                                                    value="{{ old('sampai_tanggal_makanan.' . $meal->id . '.sampai') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DORONGAN FORM --}}
                        <div class="detail-form {{ in_array('dorongan', $oldServices) ? '' : 'hidden' }}"
                            id="dorongan-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Dorongan</h6>
                            <div class="service-grid">
                                @foreach ($dorongan as $item)
                                    <div class="dorongan-item {{ array_key_exists($item->id, $oldDoronganQty) ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                        data-price="{{ $item->price }}" data-type="dorongan">
                                        <div class="service-name">{{ $item->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($dorongan as $item)
                                    <div id="form-dorongan-{{ $item->id }}"
                                        class="form-group {{ array_key_exists($item->id, $oldDoronganQty) ? '' : 'hidden' }}">
                                        <label class="form-label">Jumlah {{ $item->name }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                            data-price="{{ $item->price }}" data-type="dorongan"
                                            name="jumlah_dorongan[{{ $item->id }}]" min="1"
                                            value="{{ old('jumlah_dorongan.' . $item->id) }}">
                                        <label class="form-label">Tanggal Pelaksanaan Dorongan
                                            {{ $item->name }}</label>
                                        <input type="date" class="form-control"
                                            name="tanggal_dorongan[{{ $item->id }}]"
                                            value="{{ old('tanggal_dorongan.' . $item->id) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WAQAF FORM --}}
                        <div class="detail-form {{ in_array('waqaf', $oldServices) ? '' : 'hidden' }}"
                            id="waqaf-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Waqaf</h6>
                            <div class="service-grid">
                                @foreach ($wakaf as $item)
                                    <div class="wakaf-item {{ array_key_exists($item->id, $oldWakafQty) ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-name="{{ $item->nama }}"
                                        data-price="{{ $item->harga }}" data-type="wakaf">
                                        <div class="service-name">{{ $item->nama }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                                        <input type="checkbox" name="wakaf_id" value="{{ $item->id }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($wakaf as $item)
                                    <div id="form-wakaf-{{ $item->id }}"
                                        class="form-group {{ array_key_exists($item->id, $oldWakafQty) ? '' : 'hidden' }}">
                                        <label class="form-label">Jumlah {{ $item->nama }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $item->id }}" data-name="{{ $item->nama }}"
                                            data-price="{{ $item->harga }}" data-type="wakaf"
                                            name="jumlah_wakaf[{{ $item->id }}]" min="1"
                                            value="{{ old('jumlah_wakaf.' . $item->id) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- BADAL UMRAH FORM --}}
                        <div class="detail-form {{ in_array('badal', $oldServices) ? '' : 'hidden' }}"
                            id="badal-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Badal Umrah</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addBadal">Tambah
                                Badal</button>
                            <div id="badalWrapper">
                                {{-- PERBAIKAN: Loop data 'old' untuk badal --}}
                                @if (is_array(old('nama_badal')))
                                    @foreach (old('nama_badal') as $index => $oldNamaBadal)
                                        <div class="badal-form bg-white p-3 border mb-3"
                                            data-index="{{ $index }}">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal"
                                                    name="nama_badal[{{ $index }}]"
                                                    value="{{ $oldNamaBadal }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[{{ $index }}]" min="0"
                                                    value="{{ old('harga_badal.' . $index) }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal pelaksanaan</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_pelaksanaan_badal[{{ $index }}]"
                                                    value="{{ old('tanggal_pelaksanaan_badal.' . $index) }}">
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                                    Badal</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Form default jika tidak ada data 'old' --}}
                                    <div class="badal-form bg-white p-3 border mb-3" data-index="0">
                                        <div class="form-group mb-2">
                                            <label class="form-label">Nama yang dibadalkan</label>
                                            <input type="text" class="form-control nama_badal" name="nama_badal[0]">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Harga</label>
                                            <input type="number" class="form-control harga_badal" name="harga_badal[0]"
                                                min="0">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Tanggal pelaksanaan</label>
                                            <input type="date" class="form-control"
                                                name="tanggal_pelaksanaan_badal[0]">
                                        </div>
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                                Badal</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.detail-form.hidden').forEach(detailForm => {
                detailForm.querySelectorAll('input, select, textarea, button').forEach(el => {
                    if (!el.classList.contains('back-to-services-btn')) {
                        el.disabled = true;
                    }
                });
            });
            let cart = {};
            const cartSection = document.getElementById("cart-total-price");
            const cartItemsList = document.getElementById("cart-items");
            const cartTotalInput = document.getElementById("cart-total");
            const cartTotalText = document.getElementById("cart-total-text");

            // PERBAIKAN: Hitung counter berdasarkan data 'old' atau default ke 0
            let hotelCounter = {{ is_array(old('nama_hotel')) ? count(old('nama_hotel')) : 1 }};
            let badalCounter = {{ is_array(old('nama_badal')) ? count(old('nama_badal')) : 1 }};
            let transportCounter = {{ is_array(old('transportation_id')) ? count(old('transportation_id')) : 1 }};
            let ticketCounter = {{ is_array(old('tanggal')) ? count(old('tanggal')) : 1 }};


            function updateCartUI() {
                cartItemsList.innerHTML = "";
                let totalAll = 0;
                const items = Object.values(cart).filter(item => item && item.total >= 0 && item.qty > 0);

                items.forEach(item => {
                    totalAll += item.total;
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "d-flex", "justify-content-between",
                        "align-items-center");
                    li.innerHTML = `
                    <div>
                        <strong>${item.name}</strong>
                        <small class="text-muted d-block">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</small>
                    </div>
                    <span>Rp ${item.total.toLocaleString('id-ID')}</span>
                `;
                    cartItemsList.appendChild(li);
                });

                cartTotalInput.value = totalAll;
                cartTotalText.textContent = `Rp ${totalAll.toLocaleString('id-ID')}`;
                cartSection.style.display = items.length > 0 ? "block" : "none";
            }

            function updateItemInCart(key, name, qty, price) {
                if (qty > 0 && price >= 0 && name) {
                    cart[key] = {
                        name: name,
                        qty: qty,
                        price: price,
                        total: qty * price
                    };
                } else {
                    delete cart[key];
                }
                updateCartUI();
            }
            const backToServicesBtn = document.getElementById('backToServicesBtn');
            const targetServiceGrid = document.getElementById('service-selection-grid');

            if (backToServicesBtn && targetServiceGrid) {

                // 1. Tampilkan/Sembunyikan tombol berdasarkan scroll
                window.addEventListener('scroll', function() {
                    // Tampilkan tombol setelah user scroll melewati bagian atas grid layanan
                    if (window.scrollY > targetServiceGrid.offsetTop) {
                        backToServicesBtn.classList.add('show');
                    } else {
                        backToServicesBtn.classList.remove('show');
                    }
                });

                // 2. Aksi klik untuk scroll ke atas
                backToServicesBtn.addEventListener('click', function() {
                    targetServiceGrid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }
            // --- Data Travel Section ---
            const travelSelect = document.getElementById('travel-select');
            const penanggungInput = document.getElementById('penanggung');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            function updateTravelInfo() {
                const option = travelSelect.options[travelSelect.selectedIndex];
                if (option && option.value) { // Hanya update jika bukan placeholder "Pilih Travel"
                    penanggungInput.value = option.dataset.penanggung || '';
                    emailInput.value = option.dataset.email || '';
                    phoneInput.value = option.dataset.telepon || '';
                } else {
                    // Jika data 'old' tidak ada, JS akan mengosongkan ini
                    // Jika ada 'old', biarkan
                    if (!penanggungInput.value) penanggungInput.value = '';
                    if (!emailInput.value) emailInput.value = '';
                    if (!phoneInput.value) phoneInput.value = '';
                }
            }
            travelSelect.addEventListener('change', updateTravelInfo);

            // Panggil saat load HANYA jika tidak ada data 'old' untuk travel
            // Jika ada data 'old', JS tidak boleh menimpa info travel
            if (!{{ old('travel') ? 'true' : 'false' }}) {
                updateTravelInfo();
            }


            // --- Master Service Selection ---
            // --- Master Service Selection ---
            document.querySelectorAll('.service-item').forEach(item => {
                item.addEventListener('click', () => {
                    const serviceType = item.dataset.service;
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    const detailForm = document.getElementById(`${serviceType}-details`);

                    // Toggle status
                    item.classList.toggle('selected');
                    const isSelected = item.classList.contains('selected');
                    checkbox.checked = isSelected;

                    if (detailForm) {
                        detailForm.classList.toggle('hidden', !isSelected);

                        // ▼▼▼ PERBAIKAN VALIDASI ▼▼▼
                        // Nonaktifkan semua input jika service tidak dipilih
                        detailForm.querySelectorAll('input, select, textarea, button').forEach(
                            el => {
                                // JANGAN disable tombol "Kembali ke Atas"
                                if (!el.classList.contains('back-to-services-btn')) {
                                    el.disabled = !isSelected;
                                }
                            });

                        // Jika service dibatalkan (tidak dipilih)
                        if (!isSelected) {
                            // Hapus juga centang/seleksi di sub-item
                            detailForm.querySelectorAll(
                                '.transport-item, .handling-item, .document-item, .child-item, .pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item, .service-tour'
                            ).forEach(subItem => {
                                subItem.classList.remove('selected');
                                const subCheck = subItem.querySelector(
                                    'input[type="checkbox"], input[type="radio"]');
                                if (subCheck) subCheck.checked = false;
                            });
                            // Sembunyikan semua sub-form
                            detailForm.querySelectorAll(
                                '.form-group[data-transportasi], .form-group[id$="-handling-form"], .document-child-form, .document-base-form, .tour-form, div[id^="form-"]'
                            ).forEach(subForm => {
                                subForm.classList.add('hidden');
                            });
                        }
                        // ▲▲▲ AKHIR PERBAIKAN ▲▲▲

                        if (isSelected) {
                            detailForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // --- Add/Remove Dynamic Forms (Buttons) ---
            document.getElementById("addTicket").addEventListener("click", () => {
                const ticketWrapper = document.getElementById("ticketWrapper");
                const newForm = document.createElement('div');
                newForm.classList.add("ticket-form", "bg-white", "p-3", "border", "mb-3");
                newForm.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Keberangkatan</label><input type="date" class="form-control" name="tanggal[]"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text" class="form-control" name="maskapai[]" placeholder="Nama maskapai"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan_tiket[]" placeholder="Keterangan"></div>
                    <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number" class="form-control" name="jumlah[]"></div>
                </div>
                <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button></div>
            `;
                ticketWrapper.appendChild(newForm);
                ticketCounter++; // Counter tetap bertambah
            });

            document.getElementById("add-transport-btn").addEventListener("click", function() {
                const wrapper = document.getElementById("new-transport-forms");
                const template = `
                <div class="transport-set card p-3 mt-3" data-index="${transportCounter}">
                    <div class="cars">
                        @foreach ($transportations as $data)
                            <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)' data-name="{{ $data->nama }}" data-price="{{ $data->harga }}"><div class="service-name">{{ $data->nama }}</div><div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div><div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div><div class="service-desc">Harga: {{ number_format($data->harga) }}/hari</div><input type="radio" name="transportation_id[${transportCounter}]" value="{{ $data->id }}" class="d-none"></div>
                        @endforeach
                    </div>
                    <div class="route-select hidden"><label class="form-label mt-2">Pilih Rute:</label><select name="rute_id[${transportCounter}]" class="form-control"><option value="">-- Pilih Rute --</option></select></div>
                    <div class="route-select">
                        <label class="form-label mt-2">Dari tanggal:</label>
                        <input type="date" name="tanggal_transport[${transportCounter}][dari]" class="form-control">
                    </div>
                    <div class="route-select">
                        <label class="form-label mt-2">Sampai tanggal:</label>
                        <input type="date" name="tanggal_transport[${transportCounter}][sampai]" class="form-control">
                    </div>
                    <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button></div>
                </div>
            `;
                wrapper.insertAdjacentHTML('beforeend', template);
                transportCounter++;
            });

            document.getElementById("addHotel").addEventListener("click", () => {
                const hotelWrapper = document.getElementById("hotelWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("hotel-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = hotelCounter;
                newForm.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkin</label><input type="date" class="form-control" name="tanggal_checkin[${hotelCounter}]"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkout</label><input type="date" class="form-control" name="tanggal_checkout[${hotelCounter}]"></div>
                    <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[${hotelCounter}]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                    <div class="col-12"><label class="form-label fw-semibold">Tipe Kamar</label><div class="service-grid">
                        @foreach ($types as $type)
                            <div class="type-item" data-type-id="{{ $type->id }}" data-price="{{ $type->jumlah }}" data-name="{{ $type->nama_tipe }}"><div class="service-name">{{ $type->nama_tipe }}</div></div>
                        @endforeach
                    </div><div class="type-input-container"></div></div>
                </div>
                <div class="form-group mt-2">
                    <label class="form-label">Total kamar</label>
                    <input type="number" class="form-control" name="jumlah_kamar[${hotelCounter}]" min="0">
                </div>
                <div class="form-group mt-2">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan[${hotelCounter}]" min="0">
                </div>
                <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>
            `;
                hotelWrapper.appendChild(newForm);
                hotelCounter++;
            });

            document.getElementById("addBadal").addEventListener("click", () => {
                const badalWrapper = document.getElementById("badalWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("badal-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = badalCounter;
                newForm.innerHTML = `
                <div class="form-group mb-2"><label class="form-label">Nama yang dibadalkan</label><input type="text" class="form-control nama_badal" name="nama_badal[${badalCounter}]"></div>
                <div class="form-group mb-2"><label class="form-label">Harga</label><input type="number" class="form-control harga_badal" name="harga_badal[${badalCounter}]" min="0"></div>
                <div class="form-group mb-2">
                    <label class="form-label">Tanggal pelaksanaan</label>
                    <input type="date" class="form-control" name="tanggal_pelaksanaan_badal[${badalCounter}]">
                </div>
                <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
            `;
                badalWrapper.appendChild(newForm);
                badalCounter++;
            });


            // --- Main Event Delegation for Clicks ---
            document.body.addEventListener('click', function(e) {

                // Transportasi Darat - Vehicle Click
                const carItem = e.target.closest('.service-car');
                if (carItem) {
                    const transportSet = carItem.closest('.transport-set');
                    const radioButton = carItem.querySelector('input[type="radio"]');

                    transportSet.querySelectorAll('.service-car').forEach(car => {
                        const otherRadio = car.querySelector('input[type="radio"]');
                        if (car === carItem && radioButton) {
                            car.classList.add('selected');
                            radioButton.checked = true;
                        } else {
                            car.classList.remove('selected');
                            if (otherRadio) {
                                otherRadio.checked = false;
                            }
                        }
                    });

                    const routes = JSON.parse(carItem.dataset.routes || '[]');
                    const select = transportSet.querySelector('select[name^="rute_id"]');
                    const routeSelectDiv = transportSet.querySelector(
                        '.route-select'); // Cari div yg pertama
                    select.innerHTML = `<option value="">-- Pilih Rute --</option>`;
                    routes.forEach(route => {
                        select.insertAdjacentHTML('beforeend',
                            `<option value="${route.id}" data-price="${route.price}" data-car-name="${carItem.dataset.name}">${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`
                        );
                    });
                    if (routeSelectDiv) {
                        routeSelectDiv.classList.remove('hidden');
                    }
                }

                function updateJumlahKamarTotal(hotelForm) {
                    let totalKamar = 0;
                    const qtyInputs = hotelForm.querySelectorAll(
                        '.type-input-container input[data-is-qty="true"]');
                    qtyInputs.forEach(input => {
                        totalKamar += parseInt(input.value) || 0;
                    });
                    const jumlahKamarInput = hotelForm.querySelector('input[name^="jumlah_kamar["]');
                    if (jumlahKamarInput) {
                        jumlahKamarInput.value = totalKamar;
                    }
                }

                function addQtyChangeListener(inputElement, hotelForm) {
                    inputElement.addEventListener('input', function() {
                        const typeId = this.dataset.typeId;
                        const newQty = parseInt(this.value) || 0;
                        const typeItem = hotelForm.querySelector(
                            `.type-item[data-type-id="${typeId}"]`);
                        if (typeItem) {
                            const price = parseInt(typeItem.dataset.price) || 0;
                            const name = typeItem.dataset.name;
                            const cartId = `hotel-${hotelForm.dataset.index}-type-${typeId}`;
                            const hotelName = hotelForm.querySelector(
                                    'input[data-field="nama_hotel"]').value.trim() ||
                                `Hotel ${hotelForm.dataset.index}`;
                            if (newQty > 0) {
                                updateItemInCart(cartId, `Hotel ${hotelName} - Tipe ${name}`,
                                    newQty, price);
                            } else {
                                delete cart[cartId];
                            }
                        }
                        updateJumlahKamarTotal(hotelForm);
                        updateCartUI();
                    });
                }



                const documentItem = e.target.closest('.document-item');
                if (documentItem) {
                    const docId = documentItem.dataset.documentId;
                    const hasChildren = documentItem.dataset.hasChildren === 'true';
                    documentItem.classList.toggle('selected');

                    // PERBAIKAN: Aktifkan/nonaktifkan checkbox juga
                    const parentCheckbox = documentItem.querySelector('input[type="checkbox"]');
                    if (parentCheckbox) parentCheckbox.checked = documentItem.classList.contains(
                        'selected');

                    const formElement = document.querySelector(
                        `.document-child-form[data-parent-id="${docId}"]`) || document.querySelector(
                        `.document-base-form[data-document-id="${docId}"]`);
                    if (formElement) {
                        const isHidden = formElement.classList.toggle('hidden');
                        if (!isHidden && !hasChildren) {
                            const qtyInput = formElement.querySelector('input[type="number"]');
                            if (qtyInput) qtyInput.value = 1;
                            const name = documentItem.dataset.name;
                            const price = parseInt(documentItem.dataset.price) || 0;
                            updateItemInCart(`doc-base-${docId}`, `Dokumen - ${name}`, 1, price);
                        } else if (isHidden) {
                            Object.keys(cart).forEach(key => {
                                if (key.startsWith(`doc-base-${docId}`) || key.startsWith(
                                        `doc-child-${docId}`)) {
                                    delete cart[key];
                                }
                            });
                            // Jika punya anak, reset juga semua anak
                            if (hasChildren) {
                                formElement.querySelectorAll('.child-item').forEach(child => child.classList
                                    .remove('selected'));
                                formElement.querySelectorAll('.form-group.mt-2').forEach(childForm =>
                                    childForm.classList.add('hidden'));
                                formElement.querySelectorAll('input[name^="jumlah_child_doc"]').forEach(
                                    input => input.value = 1);
                            }
                        }
                    }
                    updateCartUI();
                }

                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const parentId = childItem.closest('.document-child-form').dataset.parentId;
                    const childId = childItem.dataset.childId;
                    const name = childItem.dataset.name;
                    const price = parseInt(childItem.dataset.price) || 0;
                    const cartId = `doc-child-${parentId}-${childId}`;
                    const isSelected = childItem.classList.toggle('selected');

                    // PERBAIKAN: Aktifkan/nonaktifkan checkbox juga
                    const childCheckbox = childItem.querySelector('input[type="checkbox"]');
                    if (childCheckbox) childCheckbox.checked = isSelected;

                    const formContainer = childItem.closest('.document-child-form');
                    let existingForm = formContainer.querySelector(`#doc-child-form-${childId}`);

                    // Buat form jika belum ada
                    if (isSelected && !existingForm) {
                        const newForm = document.createElement('div');
                        newForm.id = `doc-child-form-${childId}`;
                        newForm.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border', 'rounded');
                        newForm.innerHTML =
                            `<label class="form-label">Jumlah ${name}</label>
                            <input type="number"
                                class="form-control jumlah-child-doc"
                                data-parent-id="${parentId}"
                                data-child-id="${childId}"
                                data-name="${name}"
                                data-price="${price}"
                                min="1"
                                value="1"
                                name="jumlah_child_doc[${childId}]">`; // <-- Nama input sudah benar
                        formContainer.appendChild(newForm);
                        existingForm = newForm; // Set existingForm ke form yang baru dibuat
                    }

                    // Tampilkan/sembunyikan form
                    if (existingForm) {
                        existingForm.classList.toggle('hidden', !isSelected);
                    }

                    // Update cart
                    if (isSelected) {
                        updateItemInCart(cartId, `Dokumen - ${name}`, 1, price);
                    } else {
                        delete cart[cartId];
                    }
                    updateCartUI();
                }

                const toggleItem = e.target.closest(
                    '.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item');
                if (toggleItem) {
                    const isSelected = toggleItem.classList.toggle('selected');
                    const type = toggleItem.dataset.type;
                    const id = toggleItem.dataset.id;
                    const form = document.getElementById(`form-${type}-${id}`);
                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        const qtyInput = form.querySelector('input[type="number"]');
                        const name = toggleItem.dataset.name;
                        const price = parseInt(toggleItem.dataset.price) || 0;
                        if (isSelected) {
                            qtyInput.value = 1;
                            updateItemInCart(`${type}-${id}`, name, 1, price);
                        } else {
                            qtyInput.value = 0;
                            delete cart[`${type}-${id}`];
                        }
                    }
                    updateCartUI();
                }

                if (e.target.classList.contains("removeTicket") && document.querySelectorAll(".ticket-form")
                    .length > 0) { // Izinkan hapus sampai 0
                    e.target.closest(".ticket-form").remove();
                }
                const removeTransportBtn = e.target.closest(".remove-transport");
                if (removeTransportBtn && document.querySelectorAll(".transport-set").length >
                    0) { // Izinkan hapus sampai 0
                    const transportSet = removeTransportBtn.closest('.transport-set');
                    const index = transportSet.dataset.index;
                    Object.keys(cart).forEach(key => {
                        if (key.includes(`tour-bus-${index}`)) delete cart[key];
                    });
                    transportSet.remove();
                    updateCartUI();
                }
                const removeHotelBtn = e.target.closest('.removeHotel');
                if (removeHotelBtn && document.querySelectorAll('.hotel-form').length >
                    0) { // Izinkan hapus sampai 0
                    const hotelForm = removeHotelBtn.closest('.hotel-form');
                    const formIndex = hotelForm.dataset.index;
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`hotel-${formIndex}`)) delete cart[key];
                    });
                    hotelForm.remove();
                    updateCartUI();
                }
                if (e.target.classList.contains("removeBadal") && document.querySelectorAll(".badal-form")
                    .length > 0) { // Izinkan hapus sampai 0
                    const formEl = e.target.closest(".badal-form");
                    const id = `badal-${formEl.dataset.index}`;
                    delete cart[id];
                    updateCartUI();
                    formEl.remove();
                }

                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    const isSelected = transportItem.classList.toggle('selected');
                    const checkbox = transportItem.querySelector('input');
                    if (checkbox) checkbox.checked = isSelected;

                    const formElement = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
                    if (formElement) {
                        formElement.classList.toggle('hidden', !isSelected);
                        formElement.querySelectorAll('input, select, textarea, button').forEach(el => {
                            if (!el.classList.contains('removeTicket') && !el.classList.contains(
                                    'remove-transport') && !el.id.includes('addTicket') && !el.id
                                .includes('add-transport-btn')) {
                                el.disabled = !isSelected;
                            }
                        });
                    }
                }

                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    const isSelected = handlingItem.classList.toggle('selected');
                    handlingItem.querySelector('input').checked = isSelected;
                    document.getElementById(`${type}-handling-form`).classList.toggle('hidden', !
                        isSelected);
                }

                const tourItem = e.target.closest('.service-tour');
                if (tourItem) {
                    const tourId = tourItem.dataset.id;
                    const form = document.getElementById(`tour-${tourId}-form`);
                    const isSelected = tourItem.classList.toggle('selected');
                    // PERBAIKAN: Aktifkan/nonaktifkan checkbox juga
                    const tourCheckbox = tourItem.querySelector('input[type="checkbox"]');
                    if (tourCheckbox) tourCheckbox.checked = isSelected;

                    form.classList.toggle('hidden', !isSelected);
                    if (!isSelected) {
                        Object.keys(cart).forEach(key => {
                            if (key.startsWith(`tour-${tourId}-`)) {
                                delete cart[key];
                            }
                        });
                        // Reset radio buttons di dalam form
                        form.querySelectorAll('.transport-option').forEach(opt => {
                            opt.classList.remove('selected');
                            const radio = opt.querySelector('input[type="radio"]');
                            if (radio) radio.checked = false;
                        });
                        updateCartUI();
                    }
                }

                const tourTransOption = e.target.closest('.transport-option');
                if (tourTransOption) {
                    const tourId = tourTransOption.dataset.tourId;
                    const transId = tourTransOption.dataset.transId;
                    const tourName = tourTransOption.dataset.tourName;
                    const transName = tourTransOption.dataset.transName;
                    const price = parseInt(tourTransOption.dataset.price) || 0;
                    const uniqueKey = `tour-${tourId}-${transId}`;
                    const currentRadio = tourTransOption.querySelector('input[type="radio"]');
                    const tourForm = tourTransOption.closest('.tour-form');

                    let isSelected = false;
                    tourForm.querySelectorAll('.transport-option').forEach(option => {
                        const otherRadio = option.querySelector('input[type="radio"]');
                        if (option === tourTransOption && currentRadio) {
                            option.classList.add('selected');
                            currentRadio.checked = true;
                            isSelected = true;
                        } else {
                            option.classList.remove('selected');
                            if (otherRadio) otherRadio.checked = false;
                        }
                    });

                    // Hapus dulu semua item cart untuk tour ini
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`tour-${tourId}-`)) {
                            delete cart[key];
                        }
                    });

                    // Tambahkan item yang baru dipilih
                    if (isSelected) {
                        updateItemInCart(uniqueKey, `Tour ${tourName} - ${transName}`, 1, price);
                    }
                    updateCartUI();
                }


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
                }
            });

            // --- Event Delegation for Inputs ---
            document.body.addEventListener('input', function(e) {
                const input = e.target;
                const badalInput = input.closest('.nama_badal, .harga_badal');
                if (badalInput) {
                    const badalForm = badalInput.closest('.badal-form');
                    const index = badalForm.dataset.index;
                    const namaInput = badalForm.querySelector('.nama_badal');
                    const hargaInput = badalForm.querySelector('.harga_badal');
                    const namaValue = namaInput.value.trim();
                    const hargaValue = parseFloat(hargaInput.value) || 0;
                    const key = `badal-${index}`;
                    const itemName = `Badal Umrah untuk: ${namaValue}`;
                    if (namaValue && hargaValue > 0) {
                        updateItemInCart(key, itemName, 1, hargaValue);
                    } else {
                        delete cart[key];
                        updateCartUI();
                    }
                }

                const hotelQtyInput = input.closest('input[data-is-qty="true"]');
                if (hotelQtyInput) {
                    const hotelForm = hotelQtyInput.closest('.hotel-form');
                    const hotelIndex = hotelForm.dataset.index;
                    const typeId = hotelQtyInput.dataset.typeId;
                    const typeItem = hotelForm.querySelector(`.type-item[data-type-id="${typeId}"]`);
                    const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value
                        .trim() || `Hotel ${hotelIndex}`;
                    if (typeItem) {
                        const price = parseInt(typeItem.dataset.price) || 0;
                        updateItemInCart(`hotel-${hotelIndex}-type-${typeId}`,
                            `Hotel ${hotelName} - Tipe ${typeItem.dataset.name}`, parseInt(hotelQtyInput
                                .value) || 0, price);
                    }
                    // Panggil fungsi update jumlah kamar total
                    const hotelFormForTotal = hotelQtyInput.closest('.hotel-form');
                    if (hotelFormForTotal) {
                        // Cari fungsi updateJumlahKamarTotal() dan panggil
                        // (Fungsi ini didefinisikan di dalam event handler klik,
                        //  sebaiknya pindahkan ke scope luar agar bisa dipanggil dari sini)
                        // Untuk sementara, kita duplikat logikanya:
                        let totalKamar = 0;
                        const qtyInputs = hotelFormForTotal.querySelectorAll(
                            '.type-input-container input[data-is-qty="true"]');
                        qtyInputs.forEach(input => {
                            totalKamar += parseInt(input.value) || 0;
                        });
                        const jumlahKamarInput = hotelFormForTotal.querySelector(
                            'input[name^="jumlah_kamar["]');
                        if (jumlahKamarInput) {
                            jumlahKamarInput.value = totalKamar;
                        }
                    }
                }

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

                // Input jumlah untuk item (dokumen base, pendamping, konten, dll)
                const jumlahItemInput = e.target.closest('.jumlah-item, .jumlah-child-doc');
                if (jumlahItemInput) {
                    const qty = parseInt(jumlahItemInput.value) || 0;
                    const type = jumlahItemInput.dataset.type;
                    const id = jumlahItemInput.dataset.id || jumlahItemInput.dataset.childId;
                    const name = jumlahItemInput.dataset.name;
                    const price = parseInt(jumlahItemInput.dataset.price) || 0;

                    let key;
                    if (type) { // Untuk pendamping, konten, dll.
                        key = `${type}-${id}`;
                    } else if (jumlahItemInput.classList.contains(
                            'jumlah-child-doc')) { // Untuk dokumen anak
                        const parentId = jumlahItemInput.dataset.parentId;
                        key = `doc-child-${parentId}-${id}`;
                    } else { // Untuk dokumen base (dari input yg tersembunyi)
                        const baseDocForm = jumlahItemInput.closest('.document-base-form');
                        if (baseDocForm) {
                            key = `doc-base-${baseDocForm.dataset.documentId}`;
                        }
                    }

                    if (key && name && price) {
                        updateItemInCart(key, name, qty, price);
                    }
                }
            });

            // --- Event Delegation for Change events ---
            document.body.addEventListener('change', e => {
                const select = e.target.closest('select[name^="rute_id"]');
                if (select) {
                    const transportSet = select.closest('.transport-set');
                    const index = transportSet.dataset.index;
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`tour-bus-${index}-`)) delete cart[key];
                    });
                    const selected = select.options[select.selectedIndex];
                    if (selected.value) {
                        const carName = selected.dataset.carName || transportSet.querySelector(
                            '.service-car.selected')?.dataset.name || 'Transport';
                        const price = parseInt(selected.dataset.price) || 0;
                        const key = `tour-bus-${index}-${selected.value}`;
                        updateItemInCart(key,
                            `Transportasi Darat - ${carName} - ${selected.textContent.split(' - ')[0]}`,
                            1, price);
                    } else {
                        updateCartUI();
                    }
                }
            });
        });

        function toggleCheckboxOnClick(selector) {
            const items = document.querySelectorAll(selector);
            items.forEach(function(item) {
                item.addEventListener("click", function(e) {
                    if (e.target.tagName.toLowerCase() === 'input' || e.target.closest('input, select'))
                        return;
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });
        }
        toggleCheckboxOnClick(".document-item");
        toggleCheckboxOnClick(".type-item");
        toggleCheckboxOnClick(".child-item");
        toggleCheckboxOnClick(".service-tour")
        toggleCheckboxOnClick(".wakaf-item")
    </script>
    <script>
        // Asumsikan 'cart', 'updateItemInCart', dan 'updateCartUI' sudah didefinisikan.

        // ==========================================================
        // 1. Fungsi Utama: Menghitung Total Kamar dalam Satu Hotel Form
        // ==========================================================
        /**
         * Menghitung total jumlah kamar dari semua input kuantitas (qty-input-hotel)
         * di dalam satu form hotel dan memperbarui input 'Total kamar'.
         * @param {HTMLElement} hotelForm - Elemen div.hotel-form
         */
        function updateJumlahKamarTotal(hotelForm) {
            let totalKamar = 0;

            // Cari semua input kuantitas di dalam hotelForm
            const qtyInputs = hotelForm.querySelectorAll('.qty-input-hotel[data-is-qty="true"]');

            qtyInputs.forEach(input => {
                // Ambil nilai, pastikan itu adalah angka positif, default ke 0
                const qty = parseInt(input.value) || 0;
                totalKamar += Math.max(0, qty); // Pastikan tidak ada nilai negatif
            });

            // Temukan input 'Total kamar' (jumlah_kamar) dan perbarui nilainya
            const totalKamarInput = hotelForm.querySelector('input[name^="jumlah_kamar"]');
            if (totalKamarInput) {
                totalKamarInput.value = totalKamar;
            }
        }

        // ==========================================================
        // 2. Fungsi Pembantu: Menambahkan Listener pada Input Kuantitas Baru
        // ==========================================================
        /**
         * Menambahkan event listener ke input kuantitas kamar yang baru dibuat.
         * @param {HTMLElement} newQtyInput - Elemen input kuantitas tipe kamar yang baru.
         * @param {HTMLElement} hotelForm - Elemen div.hotel-form terkait.
         */
        function addQtyChangeListener(newQtyInput, hotelForm) {
            newQtyInput.addEventListener('input', function() {
                // Panggil fungsi utama untuk menghitung ulang total kamar
                updateJumlahKamarTotal(hotelForm);

                // --- Opsional: Perbarui Cart/Keranjang setelah kuantitas berubah ---
                // Kode untuk update cart, misalnya:
                const typeId = newQtyInput.dataset.typeId;
                const hotelIndex = hotelForm.dataset.index;
                const cartId = `hotel-${hotelIndex}-type-${typeId}`;

                // Dapatkan harga dari input harga (asumsi harga berada di form yang sama)
                const priceInput = hotelForm.querySelector(
                    `input[name="hotel_data[${hotelIndex}][${typeId}][harga]"]`);
                const typeNameInput = hotelForm.querySelector(
                    `input[name="hotel_data[${hotelIndex}][${typeId}][type_name]"]`);

                if (priceInput && typeNameInput) {
                    const qty = parseInt(newQtyInput.value) || 0;
                    // Hilangkan format IDR/titik agar bisa diubah jadi angka
                    const priceValue = parseInt(priceInput.value.replace(/\./g, '')) || 0;

                    const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value.trim() ||
                        `Hotel ${hotelIndex}`;

                    if (qty > 0) {
                        updateItemInCart(cartId, `Hotel ${hotelName} - Tipe ${typeNameInput.value}`, qty,
                            priceValue);
                    } else {
                        delete cart[cartId];
                    }
                    updateCartUI();
                }
            });
        }

        // ==========================================================
        // 3. Inisialisasi: Melampirkan Listener pada Input yang Sudah Ada
        // ==========================================================
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan listener untuk input kuantitas yang sudah ada (dari data 'old' atau form default)
            document.querySelectorAll('.hotel-form').forEach(hotelForm => {
                hotelForm.querySelectorAll('.qty-input-hotel[data-is-qty="true"]').forEach(input => {
                    addQtyChangeListener(input, hotelForm);
                });
                // Pastikan total awal dihitung
                updateJumlahKamarTotal(hotelForm);
            });

            // ==========================================================
            // 4. Tambahkan Listener untuk Logika Pilihan Tipe Kamar Anda
            // ==========================================================
            document.getElementById('hotelWrapper').addEventListener('click', function(e) {
                const typeItem = e.target.closest('.type-item');
                if (typeItem) {
                    const hotelForm = typeItem.closest('.hotel-form');
                    const dynamicContainer = hotelForm.querySelector('.type-input-container');
                    const typeId = typeItem.dataset.typeId;
                    const name = typeItem.dataset.name;
                    // Pastikan harga diambil dengan benar dan bersih
                    const price = parseInt(typeItem.dataset.price) || 0;
                    const cartId = `hotel-${hotelForm.dataset.index}-type-${typeId}`;
                    const existingInputDiv = dynamicContainer.querySelector(`[data-type-id="${typeId}"]`);

                    if (existingInputDiv) {
                        // Logika Hapus
                        existingInputDiv.remove();
                        typeItem.classList.remove('selected');
                        delete cart[cartId];
                    } else {
                        // Logika Tambah
                        typeItem.classList.add('selected');
                        const inputDiv = document.createElement('div');
                        inputDiv.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border',
                            'rounded');
                        inputDiv.dataset.typeId = typeId;
                        const hotelIndex = hotelForm.dataset.index;

                        // Format harga untuk tampilan (misalnya: 100.000)
                        const formattedPrice = price.toLocaleString('id-ID');

                        inputDiv.innerHTML =
                            `<label class="form-label">Jumlah Kamar (${name})</label>` +
                            `<input type="number" class="form-control qty-input-hotel" name="hotel_data[${hotelIndex}][${typeId}][jumlah]" min="1" data-is-qty="true" data-type-id="${typeId}">` +
                            `<label class="form-label mt-2">Harga (${name})</label>` +
                            `<input type="text" class="form-control" name="hotel_data[${hotelIndex}][${typeId}][harga]" value="${formattedPrice}" readonly>` +
                            `<input type="hidden" name="hotel_data[${hotelIndex}][${typeId}][type_name]" value="${name}">`;

                        dynamicContainer.appendChild(inputDiv);

                        // Tambahkan listener ke input kuantitas yang baru dibuat!
                        const newQtyInput = inputDiv.querySelector('input[data-is-qty="true"]');
                        addQtyChangeListener(newQtyInput, hotelForm);

                        // Perbarui Cart (Asumsi)
                        const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value
                            .trim() || `Hotel ${hotelForm.dataset.index}`;
                        updateItemInCart(cartId, `Hotel ${hotelName} - Tipe ${name}`, 1, price);
                    }

                    // Panggil fungsi utama setelah menambah/menghapus
                    updateJumlahKamarTotal(hotelForm);
                    updateCartUI(); // Panggil update cart secara keseluruhan
                }
            });

            // Anda juga perlu memanggil updateJumlahKamarTotal saat form hotel dihapus (removeHotel)
            // dan saat form hotel baru ditambahkan (addHotel), jika logika tersebut ada.
        });
    </script>
    <button type="button" id="backToServicesBtn" class="btn btn-primary" title="Kembali ke Pilihan Layanan">
        <i class="bi bi-arrow-up"></i>
    </button>
@endsection
