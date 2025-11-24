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
                        @php
                            $selectedPelanggan = null;
                            $oldTravelId = old('travel');
                            if ($oldTravelId && isset($pelanggans)) {
                                foreach ($pelanggans as $pelanggan) {
                                    if ($pelanggan->id == $oldTravelId) {
                                        $selectedPelanggan = $pelanggan;
                                        break;
                                    }
                                }
                            }

                            $pjValue = $selectedPelanggan ? $selectedPelanggan->penanggung_jawab : '';
                            $emailValue = $selectedPelanggan ? $selectedPelanggan->email : old('email');
                            $phoneValue = $selectedPelanggan ? $selectedPelanggan->phone : old('phone');

                            if (!$selectedPelanggan) {
                                $emailValue = old('email');
                                $phoneValue = old('phone');
                            }
                        @endphp

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-control" name="travel" id="travel-select" required>
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
                                    @error('travel')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly id="penanggung"
                                        value="{{ $pjValue }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required id="email" name="email"
                                        value="{{ $emailValue }}">
                                    @error('email')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" required id="phone" name="phone"
                                        value="{{ $phoneValue }}">
                                    @error('phone')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required
                                        value="{{ old('tanggal_keberangkatan') }}">
                                    @error('tanggal_keberangkatan')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ old('tanggal_kepulangan') }}">
                                    @error('tanggal_kepulangan')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ old('total_jamaah') }}">
                            @error('total_jamaah')
                                <div class="validation-error-message mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php
                        $oldServices = old('services', []);
                        $oldTransportTypes = old('transportation', []);
                        $oldHandlingTypes = old('handlings', []);
                        $oldReyalTipe = old('tipe');
                        $oldTourIds = old('tour_ids', []);
                        $oldDocParents = old('dokumen_id', []);
                        $oldChildDocs = old('child_documents', []);
                        $oldDocChildrenQtyValues = old('jumlah_child_doc', []);
                        $oldDocBaseQtyValues = old('jumlah_base_doc', []);
                        $oldPendampingIds = old('pendamping_id', []);
                        $oldKontenQty = old('jumlah_konten', []);
                        $oldPendampingQtyValues = old('jumlah_pendamping', []);
                        $oldMealsQty = old('jumlah_meals', []);
                        $oldDoronganQty = old('jumlah_dorongan', []);
                        $oldWakafQty = old('jumlah_wakaf', []);
                        $oldContentIds = old('content_id', []); // Array ID Konten yang dipilih
                        $oldKontenQtyValues = old('jumlah_konten', []); // Array Nilai Jumlahnya

                        // (Variabel Reyal tetap sama)
                        $oldReyalTipe = old('tipe');
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
                                @error('transportation')
                                    <div class="validation-error-message mt-2 mb-3">{{ $message }}</div>
                                @enderror

                                {{-- FORM PESAWAT --}}
                                <div class="form-group {{ in_array('airplane', $oldTransportTypes) ? '' : 'hidden' }}"
                                    data-transportasi="airplane" id="pesawat">
                                    <label class="form-label">Tiket Pesawat</label>

                                    {{-- Error untuk array Pesawat (min:1) diletakkan di dekat tombol tambah --}}
                                    @error('rute')
                                        <div class="validation-error-message mt-2">{{ $message }}</div>
                                    @enderror

                                    <button type="button" class="btn btn-sm btn-primary mb-3" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        @if (is_array(old('tanggal')))
                                            @foreach (old('tanggal') as $index => $oldTanggal)
                                                <div class="ticket-form bg-white p-3 border mb-3">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Tanggal
                                                                Keberangkatan</label>
                                                            <input type="date" class="form-control" name="tanggal[]"
                                                                value="{{ $oldTanggal }}">
                                                            @error('tanggal.' . $index)
                                                                <div class="validation-error-message mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Rute</label>
                                                            <input type="text" class="form-control" name="rute[]"
                                                                placeholder="Contoh: CGK - JED"
                                                                value="{{ old('rute.' . $index) }}">
                                                            @error('rute.' . $index)
                                                                <div class="validation-error-message mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Maskapai</label>
                                                            <input type="text" class="form-control" name="maskapai[]"
                                                                placeholder="Nama maskapai"
                                                                value="{{ old('maskapai.' . $index) }}">
                                                            @error('maskapai.' . $index)
                                                                <div class="validation-error-message mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
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
                                                            @error('jumlah.' . $index)
                                                                <div class="validation-error-message mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
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
                                    <button type="button" class="btn btn-sm btn-primary mb-3"
                                        id="add-transport-btn">Tambah
                                        Transportasi</button>
                                    @error('transportation_id')
                                        <div class="validation-error-message mt-2">{{ $message }}</div>
                                    @enderror
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
                                                    @error('transportation_id.' . $index)
                                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                                    @enderror

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
                                                        @error('rute_id.' . $index)
                                                            <div class="validation-error-message mt-1">Rute wajib dipilih untuk
                                                                setiap transportasi darat.</div>
                                                        @enderror
                                                    </div>

                                                    <div class="route-select">
                                                        <label class="form-label mt-2">Dari tanggal:</label>
                                                        <input type="date"
                                                            name="tanggal_transport[{{ $index }}][dari]"
                                                            class="form-control"
                                                            value="{{ old('tanggal_transport.' . $index . '.dari') }}">
                                                        @error('tanggal_transport.' . $index . '.dari')
                                                            <div class="validation-error-message mt-1">Tanggal "Dari" wajib
                                                                diisi untuk setiap transportasi darat.</div>
                                                        @enderror
                                                    </div>

                                                    <div class="route-select">
                                                        <label class="form-label mt-2">Sampai tanggal:</label>
                                                        <input type="date"
                                                            name="tanggal_transport[{{ $index }}][sampai]"
                                                            class="form-control"
                                                            value="{{ old('tanggal_transport.' . $index . '.sampai') }}">
                                                        @error('tanggal_transport.' . $index . '.sampai')
                                                            <div class="validation-error-message mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Default form (INDEX 0) - DITAMBAHKAN ERROR CHECK --}}
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
                                                @error('transportation_id.0')
                                                    <div class="validation-error-message mt-1">{{ $message }}</div>
                                                @enderror

                                                <div class="route-select hidden">
                                                    <label class="form-label mt-2">Pilih Rute:</label>
                                                    <select name="rute_id[0]" class="form-control">
                                                        <option value="">-- Pilih Rute --</option>
                                                    </select>
                                                    @error('rute_id.0')
                                                        <div class="validation-error-message mt-1">Rute wajib dipilih untuk
                                                            setiap transportasi darat.</div>
                                                    @enderror
                                                </div>

                                                <div class="route-select">
                                                    <label class="form-label mt-2">Dari tanggal:</label>
                                                    <input type="date" name="tanggal_transport[0][dari]"
                                                        class="form-control">
                                                    @error('tanggal_transport.0.dari')
                                                        <div class="validation-error-message mt-1">Tanggal "Dari" wajib diisi
                                                            untuk setiap transportasi darat.</div>
                                                    @enderror
                                                </div>
                                                <div class="route-select">
                                                    <label class="form-label mt-2">Sampai tanggal:</label>
                                                    <input type="date" name="tanggal_transport[0][sampai]"
                                                        class="form-control">
                                                    @error('tanggal_transport.0.sampai')
                                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                                    @enderror
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
                                @if (is_array(old('nama_hotel')))
                                    @foreach (old('nama_hotel') as $index => $oldNamaHotel)
                                        <div class="hotel-form bg-white p-3 border mb-3"
                                            data-index="{{ $index }}">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal Checkin</label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal_checkin.' . $index) is-invalid @enderror"
                                                        name="tanggal_checkin[{{ $index }}]"
                                                        value="{{ old('tanggal_checkin.' . $index) }}">
                                                    @error('tanggal_checkin.' . $index)
                                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal Checkout</label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal_checkout.' . $index) is-invalid @enderror"
                                                        name="tanggal_checkout[{{ $index }}]"
                                                        value="{{ old('tanggal_checkout.' . $index) }}">
                                                    @error('tanggal_checkout.' . $index)
                                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Nama Hotel</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_hotel.' . $index) is-invalid @enderror"
                                                        name="nama_hotel[{{ $index }}]" placeholder="Nama hotel"
                                                        data-field="nama_hotel" value="{{ $oldNamaHotel }}">
                                                    @error('nama_hotel.' . $index)
                                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Tipe Kamar</label>
                                                    @error('hotel_data.' . $index)
                                                        <div class="validation-error-message mb-2">{{ $message }}</div>
                                                    @enderror

                                                    <div class="service-grid">
                                                        @php
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
                                                                <input type="checkbox" name="type[]"
                                                                    value="{{ $type->nama_tipe }}">
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="type-input-container">
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
                                                                            class="form-control qty-input-hotel @error('hotel_data.' . $index . '.' . $oldTypeId . '.jumlah') is-invalid @enderror"
                                                                            name="hotel_data[{{ $index }}][{{ $oldTypeId }}][jumlah]"
                                                                            min="1"
                                                                            value="{{ $oldTypeData['jumlah'] }}"
                                                                            data-is-qty="true"
                                                                            data-type-id="{{ $oldTypeId }}">

                                                                        @error('hotel_data.' . $index . '.' . $oldTypeId .
                                                                            '.jumlah')
                                                                            <div class="validation-error-message mt-1">
                                                                                {{ $message }}</div>
                                                                        @enderror

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
                                                <input type="number"
                                                    class="form-control @error('jumlah_kamar.' . $index) is-invalid @enderror"
                                                    name="jumlah_kamar[{{ $index }}]" min="0"
                                                    value="{{ old('jumlah_kamar.' . $index) }}">
                                                @error('jumlah_kamar.' . $index)
                                                    <div class="validation-error-message mt-1">{{ $message }}</div>
                                                @enderror
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
                                        @endphp
                                        <div class="document-item {{ $isParentSelected ? 'selected' : '' }}"
                                            data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}"
                                            data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                            <div class="service-name">{{ $document->name }}</div>
                                            <input type="checkbox" name="dokumen_id[]" value="{{ $document->id }}"
                                                {{ $isParentSelected ? 'checked' : '' }} class="d-none">
                                        </div>
                                    @endforeach
                                </div>
                                @error('dokumen_id')
                                    <div class="validation-error-message mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="document-forms-container">
                                @foreach ($documents as $document)
                                    @if ($document->childrens->isNotEmpty())
                                        <div class="form-group {{ in_array($document->id, $oldDocParents) ? '' : 'hidden' }} document-child-form"
                                            data-parent-id="{{ $document->id }}">
                                            <label class="form-label">{{ $document->name }}</label>
                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        $isChildChecked = in_array($child->id, $oldChildDocs);
                                                    @endphp
                                                    <div class="child-item {{ $isChildChecked ? 'selected' : '' }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-price="{{ $child->price }}"
                                                        data-name="{{ $child->name }}">
                                                        <div class="child-name">{{ $child->name }}</div>
                                                        <div class="child-name">Rp. {{ number_format($child->price) }}
                                                        </div>
                                                        <input type="checkbox" name="child_documents[]"
                                                            value="{{ $child->id }}"
                                                            {{ $isChildChecked ? 'checked' : '' }} class="d-none">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('child_documents')
                                                @if (in_array($document->id, $oldDocParents))
                                                    <div class="validation-error-message mt-2 mb-3">{{ $message }}</div>
                                                @endif
                                            @enderror
                                            @foreach ($document->childrens as $child)
                                                @php
                                                    $isChildChecked = in_array($child->id, $oldChildDocs);
                                                    $oldQty = $oldDocChildrenQtyValues[$child->id] ?? 1;
                                                @endphp
                                                <div id="doc-child-form-{{ $child->id }}"
                                                    class="form-group mt-2 bg-white p-3 border rounded {{ $isChildChecked ? '' : 'hidden' }}">
                                                    <label class="form-label">Jumlah {{ $child->name }}</label>
                                                    <input type="number" class="form-control jumlah-child-doc"
                                                        data-parent-id="{{ $document->id }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-name="{{ $child->name }}"
                                                        data-price="{{ $child->price }}" min="1"
                                                        value="{{ $oldQty }}"
                                                        name="jumlah_child_doc[{{ $child->id }}]"
                                                        {{ !$isChildChecked ? 'disabled' : '' }}>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        @php
                                            $isBaseSelected = in_array($document->id, $oldDocParents);
                                        @endphp
                                        <div class="form-group {{ $isBaseSelected ? '' : 'hidden' }} document-base-form"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}">
                                            <label class="form-label">Jumlah {{ $document->name }}</label>
                                            <input type="number" class="form-control"
                                                name="jumlah_doc_{{ $document->id }}" min="1"
                                                value="{{ old('jumlah_doc_' . $document->id, 1) }}"
                                                {{ !$isBaseSelected ? 'disabled' : '' }}>
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
                                @error('handlings')
                                    <div class="validation-error-message mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group {{ in_array('hotel', $oldHandlingTypes) ? '' : 'hidden' }}"
                                id="hotel-handling-form">
                                <h6 class="fw-bold mb-3 text-primary">Detail Handling Hotel</h6>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Nama Hotel</label>
                                        <input type="text"
                                            class="form-control @error('nama_hotel_handling') is-invalid @enderror"
                                            name="nama_hotel_handling" value="{{ old('nama_hotel_handling') }}">
                                        @error('nama_hotel_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_hotel_handling') is-invalid @enderror"
                                            name="tanggal_hotel_handling" value="{{ old('tanggal_hotel_handling') }}">
                                        @error('tanggal_hotel_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Harga</label>
                                        <input type="text"
                                            class="form-control @error('harga_hotel_handling') is-invalid @enderror"
                                            name="harga_hotel_handling" value="{{ old('harga_hotel_handling') }}">
                                        @error('harga_hotel_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Pax</label>
                                        <input type="text"
                                            class="form-control @error('pax_hotel_handling') is-invalid @enderror"
                                            name="pax_hotel_handling" value="{{ old('pax_hotel_handling') }}">
                                        @error('pax_hotel_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kode Booking</label>
                                    <input type="file" class="form-control" name="kode_booking_hotel_handling">

                                    <label class="form-label mt-2">Room List</label>
                                    <input type="file" class="form-control" name="rumlis_hotel_handling">

                                    <label class="form-label mt-2">Identitas Koper</label>
                                    <input type="file" class="form-control" name="identitas_hotel_handling">
                                </div>
                            </div>

                            <div class="form-group {{ in_array('bandara', $oldHandlingTypes) ? '' : 'hidden' }}"
                                id="bandara-handling-form">
                                <h6 class="fw-bold mb-3 text-primary">Detail Handling Bandara</h6>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Nama Bandara</label>
                                        <input type="text"
                                            class="form-control @error('nama_bandara_handling') is-invalid @enderror"
                                            name="nama_bandara_handling" value="{{ old('nama_bandara_handling') }}">
                                        @error('nama_bandara_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Jumlah Jamaah</label>
                                        <input type="text"
                                            class="form-control @error('jumlah_jamaah_handling') is-invalid @enderror"
                                            name="jumlah_jamaah_handling" value="{{ old('jumlah_jamaah_handling') }}">
                                        @error('jumlah_jamaah_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Harga</label>
                                        <input type="text"
                                            class="form-control @error('harga_bandara_handling') is-invalid @enderror"
                                            name="harga_bandara_handling" value="{{ old('harga_bandara_handling') }}">
                                        @error('harga_bandara_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Kedatangan Jamaah</label>
                                        <input type="date"
                                            class="form-control @error('kedatangan_jamaah_handling') is-invalid @enderror"
                                            name="kedatangan_jamaah_handling"
                                            value="{{ old('kedatangan_jamaah_handling') }}">
                                        @error('kedatangan_jamaah_handling')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Paket Info</label>
                                        <input type="file" class="form-control" name="paket_info">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Nama Sopir</label>
                                        <input type="text"
                                            class="form-control @error('nama_supir') is-invalid @enderror"
                                            name="nama_supir" value="{{ old('nama_supir') }}">
                                        @error('nama_supir')
                                            <div class="validation-error-message mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Identitas Koper</label>
                                        <input type="file" class="form-control"
                                            name="identitas_koper_bandara_handling">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING FORM --}}
                        <div class="detail-form {{ in_array('pendamping', $oldServices) ? '' : 'hidden' }}"
                            id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-people"></i> Pendamping</h6>

                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($guides as $guide)
                                        @php
                                            // Cek apakah ID ada di array checkbox yang dipilih
                                            $isSelected = in_array($guide->id, $oldPendampingIds);
                                        @endphp
                                        <div class="pendamping-item {{ $isSelected ? 'selected' : '' }}"
                                            data-id="{{ $guide->id }}" data-price="{{ $guide->harga }}"
                                            data-name="{{ $guide->nama }}" data-type="pendamping">

                                            <div class="service-name">{{ $guide->nama }}</div>
                                            <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>

                                            {{-- TAMBAHKAN CHECKBOX INI --}}
                                            <input type="checkbox" name="pendamping_id[]" value="{{ $guide->id }}"
                                                {{ $isSelected ? 'checked' : '' }} class="d-none">
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Error Message Global --}}
                                @error('jumlah_pendamping')
                                    <div class="validation-error-message mt-2 mb-3">{{ $message }}</div>
                                @enderror
                                @error('tanggal_pendamping')
                                    <div class="validation-error-message mt-2 mb-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    @php
                                        $isSelected = in_array($guide->id, $oldPendampingIds);
                                        $oldQty = $oldPendampingQtyValues[$guide->id] ?? '';
                                    @endphp
                                    <div id="form-pendamping-{{ $guide->id }}"
                                        class="form-group {{ $isSelected ? '' : 'hidden' }}">

                                        <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $guide->id }}" data-name="{{ $guide->nama }}"
                                            data-price="{{ $guide->harga }}" data-type="pendamping"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="1"
                                            value="{{ $oldQty }}" {{-- PENTING: Matikan input jika tidak dipilih --}}
                                            {{ !$isSelected ? 'disabled' : '' }}>

                                        <div class="form-row d-flex gap-3 mt-2">
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Dari</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_pendamping[{{ $guide->id }}][dari]"
                                                    value="{{ old('tanggal_pendamping.' . $guide->id . '.dari') }}"
                                                    {{ !$isSelected ? 'disabled' : '' }}>
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Sampai</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_pendamping[{{ $guide->id }}][sampai]"
                                                    value="{{ old('tanggal_pendamping.' . $guide->id . '.sampai') }}"
                                                    {{ !$isSelected ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form {{ in_array('konten', $oldServices) ? '' : 'hidden' }}"
                            id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-camera"></i> Content</h6>

                            {{-- 1. GRID KONTEN (PILIHAN) --}}
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($contents as $content)
                                        @php
                                            // UBAH LOGIKA: Cek berdasarkan ID Checkbox, bukan jumlah
                                            $isSelected = in_array($content->id, $oldContentIds);
                                        @endphp
                                        <div class="content-item {{ $isSelected ? 'selected' : '' }}"
                                            data-id="{{ $content->id }}" data-name="{{ $content->name }}"
                                            data-price="{{ $content->price }}" data-type="konten">

                                            <div class="service-name">{{ $content->name }}</div>
                                            <div class="service-desc">Rp. {{ number_format($content->price) }}</div>

                                            {{-- TAMBAHKAN CHECKBOX 'content_id' DI SINI --}}
                                            <input type="checkbox" name="content_id[]" value="{{ $content->id }}"
                                                class="d-none" {{ $isSelected ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- ERROR MESSAGE --}}
                                @error('jumlah_konten')
                                    <div class="validation-error-message mt-2">{{ $message }}</div>
                                @enderror
                                @error('tanggal_konten')
                                    <div class="validation-error-message mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 2. FORM DETAIL KONTEN (INPUT) --}}
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    @php
                                        $isSelected = in_array($content->id, $oldContentIds);
                                        $oldQty = $oldKontenQtyValues[$content->id] ?? '';
                                        $oldDate = old('tanggal_konten.' . $content->id);
                                        $oldKet = old('keterangan_konten.' . $content->id);
                                    @endphp
                                    <div id="form-konten-{{ $content->id }}"
                                        class="form-group {{ $isSelected ? '' : 'hidden' }}">

                                        <div class="form-row d-flex gap-3 mt-2">
                                            <div class="form-col">
                                                <label class="form-label">Jumlah {{ $content->name }}</label>
                                                <input type="number" class="form-control jumlah-item"
                                                    data-id="{{ $content->id }}" data-name="{{ $content->name }}"
                                                    data-price="{{ $content->price }}" data-type="konten"
                                                    name="jumlah_konten[{{ $content->id }}]" min="1"
                                                    value="{{ $oldQty }}" {{-- Disabled jika tidak dipilih agar tidak terkirim --}}
                                                    {{ !$isSelected ? 'disabled' : '' }}>
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control"
                                                    name="tanggal_konten[{{ $content->id }}]"
                                                    value="{{ $oldDate }}" {{ !$isSelected ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <label for="keterangan_konten" class="form-label mt-3">Keterangan</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_konten[{{ $content->id }}]" value="{{ $oldKet }}"
                                            {{ !$isSelected ? 'disabled' : '' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form {{ in_array('reyal', $oldServices) ? '' : 'hidden' }}"
                            id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-currency-exchange"></i> Penukaran mata uang</h6>

                            {{-- Pilihan Tipe (Radio) --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tamis' ? 'selected' : '' }}"
                                        data-reyal-type="tamis">
                                        <h5>Tamis</h5>
                                        <p>Rupiah → Reyal</p>
                                        <input type="radio" name="tipe" value="tamis" class="d-none"
                                            {{ $oldReyalTipe == 'tamis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tumis' ? 'selected' : '' }}"
                                        data-reyal-type="tumis">
                                        <h5>Tumis</h5>
                                        <p>Reyal → Rupiah</p>
                                        <input type="radio" name="tipe" value="tumis" class="d-none"
                                            {{ $oldReyalTipe == 'tumis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @error('tipe')
                                <div class="validation-error-message mt-2 text-center">{{ $message }}</div>
                            @enderror

                            {{-- FORM TAMIS --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tamis' ? '' : 'hidden' }}"
                                id="form-tamis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Rupiah → Reyal</h6>
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number"
                                        class="form-control @error('jumlah_rupiah') is-invalid @enderror"
                                        id="rupiah-tamis" name="jumlah_rupiah" value="{{ old('jumlah_rupiah') }}"
                                        {{-- Hanya disabled jika Tipe BUKAN Tamis --}} {{ $oldReyalTipe != 'tamis' ? 'disabled' : '' }}>
                                    @error('jumlah_rupiah')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control @error('kurs_tamis') is-invalid @enderror"
                                        id="kurs-tamis" name="kurs_tamis" value="{{ old('kurs_tamis') }}"
                                        {{ $oldReyalTipe != 'tamis' ? 'disabled' : '' }}>
                                    @error('kurs_tamis')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis"
                                        readonly value="{{ old('hasil_tamis') }}">
                                </div>
                            </div>

                            {{-- FORM TUMIS --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tumis' ? '' : 'hidden' }}"
                                id="form-tumis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Reyal → Rupiah</h6>
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number"
                                        class="form-control @error('jumlah_reyal') is-invalid @enderror" id="reyal-tumis"
                                        name="jumlah_reyal" value="{{ old('jumlah_reyal') }}" {{-- Hanya disabled jika Tipe BUKAN Tumis --}}
                                        {{ $oldReyalTipe != 'tumis' ? 'disabled' : '' }}>
                                    @error('jumlah_reyal')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control @error('kurs_tumis') is-invalid @enderror"
                                        id="kurs-tumis" name="kurs_tumis" value="{{ old('kurs_tumis') }}"
                                        {{ $oldReyalTipe != 'tumis' ? 'disabled' : '' }}>
                                    @error('kurs_tumis')
                                        <div class="validation-error-message mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis"
                                        readonly value="{{ old('hasil_tumis') }}">
                                </div>
                            </div>

                            <label class="form-label mt-2">Tanggal penyerahan</label>
                            <input type="date" class="form-control @error('tanggal_penyerahan') is-invalid @enderror"
                                name="tanggal_penyerahan" value="{{ old('tanggal_penyerahan') }}">
                            @error('tanggal_penyerahan')
                                <div class="validation-error-message mt-1">{{ $message }}</div>
                            @enderror
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
                        {{-- <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button> --}}
                        <button type="submit" name="action" value="nego" class="btn btn-primary">Simpan
                            (Nego)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Matikan input di form yang tersembunyi saat load awal
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

            // Counter untuk ID elemen dinamis
            let hotelCounter = {{ is_array(old('nama_hotel')) ? count(old('nama_hotel')) : 1 }};
            let badalCounter = {{ is_array(old('nama_badal')) ? count(old('nama_badal')) : 1 }};
            let transportCounter = {{ is_array(old('transportation_id')) ? count(old('transportation_id')) : 1 }};
            let ticketCounter = {{ is_array(old('tanggal')) ? count(old('tanggal')) : 1 }};

            // --- UI UPDATE FUNCTIONS ---
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

            // --- BACK TO TOP BUTTON ---
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

            // --- DATA TRAVEL HELPER ---
            const travelSelect = document.getElementById('travel-select');
            const penanggungInput = document.getElementById('penanggung');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            function updateTravelInfo() {
                const option = travelSelect.options[travelSelect.selectedIndex];
                if (option && option.value) {
                    penanggungInput.value = option.dataset.penanggung || '';
                    emailInput.value = option.dataset.email || '';
                    phoneInput.value = option.dataset.telepon || '';
                } else {
                    if (!penanggungInput.value) penanggungInput.value = '';
                    if (!emailInput.value) emailInput.value = '';
                    if (!phoneInput.value) phoneInput.value = '';
                }
            }
            travelSelect.addEventListener('change', updateTravelInfo);
            if (!{{ old('travel') ? 'true' : 'false' }}) {
                updateTravelInfo();
            }

            // --- MASTER SERVICE SELECTION (Main Cards) ---
            document.querySelectorAll('.service-item').forEach(item => {
                item.addEventListener('click', () => {
                    const serviceType = item.dataset.service;
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    const detailForm = document.getElementById(`${serviceType}-details`);

                    item.classList.toggle('selected');
                    const isSelected = item.classList.contains('selected');
                    checkbox.checked = isSelected;

                    if (detailForm) {
                        detailForm.classList.toggle('hidden', !isSelected);

                        // Matikan/Hidupkan semua input di dalam section ini
                        detailForm.querySelectorAll('input, select, textarea, button').forEach(
                        el => {
                            if (!el.classList.contains('back-to-services-btn')) {
                                el.disabled = !isSelected;
                            }
                        });

                        // Jika di-uncheck, reset visual sub-item
                        if (!isSelected) {
                            detailForm.querySelectorAll('.selected').forEach(subItem => {
                                subItem.classList.remove('selected');
                                const subCheck = subItem.querySelector(
                                    'input[type="checkbox"], input[type="radio"]');
                                if (subCheck) subCheck.checked = false;
                            });
                            // Sembunyikan sub-form
                            detailForm.querySelectorAll(
                                    'div[id$="-form"], .document-child-form, .document-base-form')
                                .forEach(subForm => {
                                    subForm.classList.add('hidden');
                                });
                        } else {
                            detailForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // --- DYNAMIC FORMS ADD/REMOVE ---
            document.getElementById("addTicket").addEventListener("click", () => {
                const ticketWrapper = document.getElementById("ticketWrapper");
                const newForm = document.createElement('div');
                newForm.classList.add("ticket-form", "bg-white", "p-3", "border", "mb-3");
                newForm.innerHTML =
                    `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Keberangkatan</label><input type="date" class="form-control" name="tanggal[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text" class="form-control" name="maskapai[]" placeholder="Nama maskapai"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan_tiket[]" placeholder="Keterangan"></div>
                <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number" class="form-control" name="jumlah[]"></div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button></div>`;
                ticketWrapper.appendChild(newForm);
                ticketCounter++;
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
                <div class="route-select"><label class="form-label mt-2">Dari tanggal:</label><input type="date" name="tanggal_transport[${transportCounter}][dari]" class="form-control"></div>
                <div class="route-select"><label class="form-label mt-2">Sampai tanggal:</label><input type="date" name="tanggal_transport[${transportCounter}][sampai]" class="form-control"></div>
                <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button></div>
            </div>`;
                wrapper.insertAdjacentHTML('beforeend', template);
                transportCounter++;
            });

            document.getElementById("addHotel").addEventListener("click", () => {
                const hotelWrapper = document.getElementById("hotelWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("hotel-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = hotelCounter;
                newForm.innerHTML =
                    `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkin</label><input type="date" class="form-control" name="tanggal_checkin[${hotelCounter}]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkout</label><input type="date" class="form-control" name="tanggal_checkout[${hotelCounter}]"></div>
                <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[${hotelCounter}]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                <div class="col-12"><label class="form-label fw-semibold">Tipe Kamar</label><div class="service-grid">
                    @foreach ($types as $type)
                        <div class="type-item" data-type-id="{{ $type->id }}" data-price="{{ $type->jumlah }}" data-name="{{ $type->nama_tipe }}"><div class="service-name">{{ $type->nama_tipe }}</div><input type="checkbox" name="type[]" value="{{ $type->nama_tipe }}" class="d-none"></div>
                    @endforeach
                </div><div class="type-input-container"></div></div>
            </div>
            <div class="form-group mt-2"><label class="form-label">Total kamar</label><input type="number" class="form-control" name="jumlah_kamar[${hotelCounter}]" min="0"></div>
            <div class="form-group mt-2"><label class="form-label">Keterangan</label><input type="text" class="form-control" name="keterangan[${hotelCounter}]" min="0"></div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>`;
                hotelWrapper.appendChild(newForm);
                hotelCounter++;
            });

            document.getElementById("addBadal").addEventListener("click", () => {
                const badalWrapper = document.getElementById("badalWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("badal-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = badalCounter;
                newForm.innerHTML =
                    `
            <div class="form-group mb-2"><label class="form-label">Nama yang dibadalkan</label><input type="text" class="form-control nama_badal" name="nama_badal[${badalCounter}]"></div>
            <div class="form-group mb-2"><label class="form-label">Harga</label><input type="number" class="form-control harga_badal" name="harga_badal[${badalCounter}]" min="0"></div>
            <div class="form-group mb-2"><label class="form-label">Tanggal pelaksanaan</label><input type="date" class="form-control" name="tanggal_pelaksanaan_badal[${badalCounter}]"></div>
            <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>`;
                badalWrapper.appendChild(newForm);
                badalCounter++;
            });


            // --- MAIN EVENT DELEGATION (PENGGANTI toggleCheckboxOnClick) ---
            document.body.addEventListener('click', function(e) {

                // 1. Transportasi Darat - Mobil
                const carItem = e.target.closest('.service-car');
                if (carItem) {
                    const transportSet = carItem.closest('.transport-set');
                    const radioButton = carItem.querySelector('input[type="radio"]');

                    transportSet.querySelectorAll('.service-car').forEach(car => {
                        car.classList.remove('selected');
                        const rb = car.querySelector('input[type="radio"]');
                        if (rb) rb.checked = false;
                    });

                    carItem.classList.add('selected');
                    if (radioButton) radioButton.checked = true;

                    const routes = JSON.parse(carItem.dataset.routes || '[]');
                    const select = transportSet.querySelector('select[name^="rute_id"]');
                    const routeSelectDiv = transportSet.querySelector('.route-select');

                    select.innerHTML = `<option value="">-- Pilih Rute --</option>`;
                    routes.forEach(route => {
                        select.insertAdjacentHTML('beforeend',
                            `<option value="${route.id}" data-price="${route.price}" data-car-name="${carItem.dataset.name}">${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`
                            );
                    });
                    if (routeSelectDiv) routeSelectDiv.classList.remove('hidden');
                }

                // 2. Dokumen Induk
                const documentItem = e.target.closest('.document-item');
                if (documentItem) {
                    const docId = documentItem.dataset.documentId;
                    const hasChildren = documentItem.dataset.hasChildren === 'true';

                    documentItem.classList.toggle('selected');
                    const isSelected = documentItem.classList.contains('selected');

                    const parentCheckbox = documentItem.querySelector('input[type="checkbox"]');
                    if (parentCheckbox) parentCheckbox.checked = isSelected;

                    const formElement = document.querySelector(
                            `.document-child-form[data-parent-id="${docId}"]`) ||
                        document.querySelector(`.document-base-form[data-document-id="${docId}"]`);

                    if (formElement) {
                        formElement.classList.toggle('hidden', !isSelected);

                        formElement.querySelectorAll('input, select').forEach(input => {
                            if (input.type !== 'checkbox') input.disabled = !isSelected;
                        });

                        if (isSelected && !hasChildren) {
                            const qtyInput = formElement.querySelector('input[type="number"]');
                            if (qtyInput) qtyInput.value = 1;
                            updateItemInCart(`doc-base-${docId}`, `Dokumen - ${documentItem.dataset.name}`,
                                1, parseInt(documentItem.dataset.price) || 0);
                        } else if (!isSelected) {
                            Object.keys(cart).forEach(key => {
                                if (key.startsWith(`doc-base-${docId}`) || key.startsWith(
                                        `doc-child-${docId}`)) {
                                    delete cart[key];
                                }
                            });

                            if (hasChildren) {
                                formElement.querySelectorAll('.child-item').forEach(child => {
                                    child.classList.remove('selected');
                                    const cb = child.querySelector('input');
                                    if (cb) cb.checked = false;
                                });
                                formElement.querySelectorAll('.form-group.mt-2').forEach(cf => {
                                    cf.classList.add('hidden');
                                    cf.querySelectorAll('input').forEach(i => i.disabled = true);
                                });
                            }
                        }
                    }
                    updateCartUI();
                }

                // 3. Dokumen Anak (Child)
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const parentId = childItem.closest('.document-child-form').dataset.parentId;
                    const childId = childItem.dataset.childId;
                    const name = childItem.dataset.name;
                    const price = parseInt(childItem.dataset.price) || 0;

                    childItem.classList.toggle('selected');
                    const isSelected = childItem.classList.contains('selected');

                    const childCheckbox = childItem.querySelector('input[type="checkbox"]');
                    if (childCheckbox) childCheckbox.checked = isSelected;

                    const formContainer = childItem.closest('.document-child-form');
                    let existingForm = formContainer.querySelector(`#doc-child-form-${childId}`);

                    if (!existingForm && isSelected) {
                        const newForm = document.createElement('div');
                        newForm.id = `doc-child-form-${childId}`;
                        newForm.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border', 'rounded');
                        newForm.innerHTML = `<label class="form-label">Jumlah ${name}</label>
                        <input type="number" class="form-control jumlah-child-doc"
                        data-parent-id="${parentId}" data-child-id="${childId}"
                        data-name="${name}" data-price="${price}"
                        min="1" value="1" name="jumlah_child_doc[${childId}]">`;
                        formContainer.appendChild(newForm);
                        existingForm = newForm;
                    }

                    if (existingForm) {
                        existingForm.classList.toggle('hidden', !isSelected);
                        const inputQty = existingForm.querySelector('input');
                        if (inputQty) {
                            inputQty.disabled = !isSelected;
                            if (isSelected && (inputQty.value == 0 || inputQty.value == '')) {
                                inputQty.value = 1;
                            }
                        }
                    }

                    const cartId = `doc-child-${parentId}-${childId}`;
                    if (isSelected) {
                        updateItemInCart(cartId, `Dokumen - ${name}`, 1, price);
                    } else {
                        delete cart[cartId];
                    }
                    updateCartUI();
                }

                // 4. ITEM UMUM (KONTEN, PENDAMPING, MEAL, DORONGAN, WAKAF, TOUR)
                const toggleItem = e.target.closest(
                    '.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item, .service-tour'
                    );

                if (toggleItem) {
                    toggleItem.classList.toggle('selected');
                    const isSelected = toggleItem.classList.contains('selected');

                    const checkbox = toggleItem.querySelector('input[type="checkbox"]');
                    if (checkbox) checkbox.checked = isSelected;

                    const type = toggleItem.dataset.type || (toggleItem.classList.contains('service-tour') ?
                        'tour' : null);
                    const id = toggleItem.dataset.id;

                    if (type && id) {
                        const form = document.getElementById(`form-${type}-${id}`) || document
                            .getElementById(`${type}-${id}-form`);

                        if (form) {
                            form.classList.toggle('hidden', !isSelected);

                            form.querySelectorAll('input, select, textarea').forEach(input => {
                                if (input.type === 'radio' && !isSelected) {
                                    input.checked = false;
                                    input.closest('.transport-option')?.classList.remove(
                                    'selected');
                                }
                                input.disabled = !isSelected;
                            });

                            const qtyInput = form.querySelector('input[type="number"].jumlah-item');
                            if (qtyInput && isSelected) {
                                if (qtyInput.value == 0 || qtyInput.value == '') qtyInput.value = 1;
                            }

                            const name = toggleItem.dataset.name;
                            const price = parseInt(toggleItem.dataset.price) || 0;
                            const cartKey = `${type}-${id}`;

                            if (isSelected && qtyInput) {
                                updateItemInCart(cartKey, name, parseInt(qtyInput.value), price);
                            } else {
                                delete cart[cartKey];
                            }
                        }
                    }
                    updateCartUI();
                }

                // 5. Handling
                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    handlingItem.classList.toggle('selected');
                    const isSelected = handlingItem.classList.contains('selected');

                    const chk = handlingItem.querySelector('input');
                    if (chk) chk.checked = isSelected;

                    const form = document.getElementById(`${type}-handling-form`);
                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        form.querySelectorAll('input').forEach(i => i.disabled = !isSelected);
                    }
                }

                // 6. Transportasi Pilihan
                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    transportItem.classList.toggle('selected');
                    const isSelected = transportItem.classList.contains('selected');

                    const chk = transportItem.querySelector('input');
                    if (chk) chk.checked = isSelected;

                    const form = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        form.querySelectorAll('input, select, textarea, button').forEach(el => {
                            if (!el.classList.contains('removeTicket') && !el.classList.contains(
                                    'remove-transport') && !el.id.includes('add')) {
                                el.disabled = !isSelected;
                            }
                        });
                    }
                }

                // 7. Reyal
                const reyalCard = e.target.closest('.card-reyal');
                if (reyalCard) {
                    document.querySelectorAll('.card-reyal').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('.card-reyal input[type="radio"]').forEach(r => r.checked =
                        false);

                    reyalCard.classList.add('selected');
                    const rb = reyalCard.querySelector('input[type="radio"]');
                    if (rb) rb.checked = true;

                    const type = reyalCard.dataset.reyalType;
                    const formTamis = document.getElementById('form-tamis');
                    const formTumis = document.getElementById('form-tumis');

                    formTamis.classList.toggle('hidden', type !== 'tamis');
                    formTamis.querySelectorAll('input').forEach(i => i.disabled = (type !== 'tamis'));

                    formTumis.classList.toggle('hidden', type !== 'tumis');
                    formTumis.querySelectorAll('input').forEach(i => i.disabled = (type !== 'tumis'));
                }

                // 8. Tour Transport Option
                const tourTransOption = e.target.closest('.transport-option');
                if (tourTransOption) {
                    const tourForm = tourTransOption.closest('.tour-form');
                    const rb = tourTransOption.querySelector('input[type="radio"]');

                    tourForm.querySelectorAll('.transport-option').forEach(opt => {
                        opt.classList.remove('selected');
                        const r = opt.querySelector('input[type="radio"]');
                        if (r) r.checked = false;
                    });

                    tourTransOption.classList.add('selected');
                    if (rb) rb.checked = true;

                    const tourId = tourTransOption.dataset.tourId;
                    const transId = tourTransOption.dataset.transId;
                    const price = parseInt(tourTransOption.dataset.price) || 0;
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`tour-${tourId}-`)) delete cart[key];
                    });
                    updateItemInCart(`tour-${tourId}-${transId}`,
                        `Tour ${tourTransOption.dataset.tourName} - ${tourTransOption.dataset.transName}`,
                        1, price);
                    updateCartUI();
                }

                // 9. REMOVE BUTTONS
                if (e.target.matches('.removeTicket')) {
                    e.target.closest('.ticket-form').remove();
                }
                if (e.target.matches('.remove-transport')) {
                    const set = e.target.closest('.transport-set');
                    set.remove();
                }
                if (e.target.matches('.removeHotel')) {
                    e.target.closest('.hotel-form').remove();
                }
                if (e.target.matches('.removeBadal')) {
                    e.target.closest('.badal-form').remove();
                }
            });

            // --- HOTEL SPECIFIC LOGIC ---
            function updateJumlahKamarTotal(hotelForm) {
                let totalKamar = 0;
                hotelForm.querySelectorAll('.qty-input-hotel[data-is-qty="true"]').forEach(input => {
                    totalKamar += parseInt(input.value) || 0;
                });
                const target = hotelForm.querySelector('input[name^="jumlah_kamar"]');
                if (target) target.value = totalKamar;
            }

            function addQtyChangeListener(input, hotelForm) {
                input.addEventListener('input', function() {
                    updateJumlahKamarTotal(hotelForm);
                });
            }

            document.querySelectorAll('.hotel-form').forEach(form => {
                form.querySelectorAll('.qty-input-hotel').forEach(inp => addQtyChangeListener(inp, form));
                updateJumlahKamarTotal(form);
            });

            // HOTEL WRAPPER CLICK (Menangani Tipe Kamar)
            const hotelWrapper = document.getElementById('hotelWrapper');
            if (hotelWrapper) {
                hotelWrapper.addEventListener('click', function(e) {
                    const typeItem = e.target.closest('.type-item');
                    if (typeItem) {
                        const hotelForm = typeItem.closest('.hotel-form');
                        const container = hotelForm.querySelector('.type-input-container');
                        const typeId = typeItem.dataset.typeId;
                        const name = typeItem.dataset.name;
                        const price = parseInt(typeItem.dataset.price) || 0;
                        const index = hotelForm.dataset.index;

                        // Handle Checkbox Manual
                        const chk = typeItem.querySelector('input[type="checkbox"]');
                        const existing = container.querySelector(`[data-type-id="${typeId}"]`);

                        if (existing) {
                            // Logika Unselect
                            existing.remove();
                            typeItem.classList.remove('selected');
                            if (chk) chk.checked = false; // Uncheck
                            delete cart[`hotel-${index}-type-${typeId}`];
                        } else {
                            // Logika Select
                            typeItem.classList.add('selected');
                            if (chk) chk.checked = true; // Check

                            const div = document.createElement('div');
                            div.className = 'form-group mt-2 bg-white p-3 border rounded';
                            div.dataset.typeId = typeId;
                            div.innerHTML = `
                            <label class="form-label">Jumlah Kamar (${name})</label>
                            <input type="number" class="form-control qty-input-hotel" name="hotel_data[${index}][${typeId}][jumlah]" min="1" data-is-qty="true" data-type-id="${typeId}" value="1">
                            <label class="form-label mt-2">Harga</label>
                            <input type="text" class="form-control" name="hotel_data[${index}][${typeId}][harga]" value="${price.toLocaleString('id-ID')}" readonly>
                            <input type="hidden" name="hotel_data[${index}][${typeId}][type_name]" value="${name}">
                        `;
                            container.appendChild(div);

                            const newInp = div.querySelector('.qty-input-hotel');
                            addQtyChangeListener(newInp, hotelForm);
                            updateItemInCart(`hotel-${index}-type-${typeId}`, `Hotel - ${name}`, 1, price);
                        }
                        updateJumlahKamarTotal(hotelForm);
                        updateCartUI();
                    }
                });
            }

            // --- INPUT DELEGATION ---
            document.body.addEventListener('input', function(e) {
                const input = e.target;

                // Badal
                if (input.matches('.nama_badal, .harga_badal')) {
                    const form = input.closest('.badal-form');
                    const idx = form.dataset.index;
                    const n = form.querySelector('.nama_badal').value;
                    const p = parseFloat(form.querySelector('.harga_badal').value) || 0;
                    if (n && p > 0) updateItemInCart(`badal-${idx}`, `Badal: ${n}`, 1, p);
                    else delete cart[`badal-${idx}`];
                    updateCartUI();
                }

                // Reyal Calculation
                if (input.id === 'rupiah-tamis' || input.id === 'kurs-tamis') {
                    const r = parseFloat(document.getElementById('rupiah-tamis').value);
                    const k = parseFloat(document.getElementById('kurs-tamis').value);
                    document.getElementById('hasil-tamis').value = (!isNaN(r) && !isNaN(k) && k > 0) ? (r /
                        k).toFixed(2) : '';
                }
                if (input.id === 'reyal-tumis' || input.id === 'kurs-tumis') {
                    const r = parseFloat(document.getElementById('reyal-tumis').value);
                    const k = parseFloat(document.getElementById('kurs-tumis').value);
                    document.getElementById('hasil-tumis').value = (!isNaN(r) && !isNaN(k)) ? (r * k)
                        .toFixed(2) : '';
                }

                // Qty Updates for General Items
                if (input.classList.contains('jumlah-item')) {
                    updateCartUI();
                }
            });
        });
    </script>
    <button type="button" id="backToServicesBtn" class="btn btn-primary" title="Kembali ke Pilihan Layanan">
        <i class="bi bi-arrow-up"></i>
    </button>
@endsection
