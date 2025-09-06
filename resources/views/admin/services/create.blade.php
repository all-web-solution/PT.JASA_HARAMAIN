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

        /* Form Styles */
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

        /* Service Selection */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .service-item,
        .transport-item,
        .service-car,
        .document-item,
        .child-item
        .content-item,
        .visa-item,
        .vaksin-item,
        .service-tour,
        .service-tour-makkah,
        .service-tour-madinah,
        .service-tour-al-ula,
        .service-tour-thoif {
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
        .service-car:hover,
        .document-item:hover,
        .child-item:hover,
        .content-item:hover,
        .visa-item:hover,
        .vaksin-item:hover,
        .service-tour:hover,
        .service-tour-makkah:hover,
        .service-tour-madinah:hover,
        .service-tour-al-ula:hover,
        .service-tour-thoif:hover {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-item.selected,
        .transport-item.selected,
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
        .service-tour-thoif.selected {
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

        /* Detail Form */
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

        /* Buttons */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .transportasi-item {
            display: flex
        }

        #pesawat,
        #bis,
        #visa,
        #vaksin,
        #sikopatur,
        #bandara,
        #hotel,
        #pendamping-details,
        #konten-details,
        #reyal-details,
        #tour-details,
        #meals-details,
        #dorongan-details,
        #waqaf-details,
        #badal-details {
            display: none;
            margin-top: 20px;
        }

        .cars,
        .tours {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .hidden {
            display: none;
        }

        .document-item,
        .child-item {
            border: 1px solid #ccc;
            padding: 12px;
            cursor: pointer;
            border-radius: 10px;
            text-align: center;
            transition: 0.2s;
        }

        .document-item.active,
        .child-item.active {
            border-color: #28a745;
            background: #f0fff4;
        }

        .service-desc {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }



        .visa-item,
        .vaksin-item {
            display: block;
            border: 2px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .service-vaksin-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .service-vaksin-item {
            display: block;
            border: 2px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .visa-item.active,
        .vaksin-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .pendamping-wrapper {
            display: block;
            /* full width */
            margin-bottom: 10px;
        }

        .pendamping-item {
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
        }

        .pendamping-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .pendamping-form {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border-left: 3px solid #1a4b8c;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .hidden {
            display: none;
        }

        .content-item.active {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            background: #f0f8ff;
        }

        .service-tour,
        .transport-option {
            display: block;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .service-tour.active,
        .transport-option.active {
            border-color: #0d6efd;
            background: #e9f2ff;
        }

        .hidden {
            display: none;
        }

        #meal-item,
        .content-item {
            background-color: #fff;
            margin: 10px 0px;
            padding: 10px;
            border-radius: 7px;

        }
    </style>

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

                    <!-- Data Travel Section -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-control" name="travel" id="travel-select">
                                        <option value="" disabled selected>Pilih Travel</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                                data-email="{{ $pelanggan->email }}" data-telepon="{{ $pelanggan->phone }}">
                                                {{ $pelanggan->nama_travel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly required id="penanggung">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required id="email">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" required id="phone">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required>
                        </div>
                    </div>

                    <!-- Pilih Layanan Section -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                        </h6>

                        <div class="service-grid">
                            <div class="service-item" data-service="transportasi">
                                <div class="service-icon">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <div class="service-name">Transportasi</div>
                                <div class="service-desc">Tiket & Transport</div>
                                <input type="checkbox" name="services[]" value="transportasi" hidden>
                            </div>

                            <div class="service-item" data-service="hotel">
                                <div class="service-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="service-name">Hotel</div>
                                <div class="service-desc">Akomodasi</div>
                                <input type="checkbox" name="services[]" value="hotel" hidden>
                            </div>

                            <div class="service-item" data-service="dokumen">
                                <div class="service-icon">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="service-name">Dokumen</div>
                                <div class="service-desc">Visa & Administrasi</div>
                                <input type="checkbox" name="services[]" value="dokumen" hidden>
                            </div>

                            <div class="service-item" data-service="handling">
                                <div class="service-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div class="service-name">Handling</div>
                                <div class="service-desc">Bandara & Hotel</div>
                                <input type="checkbox" name="services[]" value="handling" hidden>
                            </div>

                            <div class="service-item" data-service="pendamping">
                                <div class="service-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="service-name">Pendamping</div>
                                <div class="service-desc">Tour Leader & Mutawwif</div>
                                <input type="checkbox" name="services[]" value="pendamping" hidden>
                            </div>

                            <div class="service-item" data-service="konten">
                                <div class="service-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <div class="service-name">Konten</div>
                                <div class="service-desc">Dokumentasi</div>
                                <input type="checkbox" name="services[]" value="konten" hidden>
                            </div>

                            <div class="service-item" data-service="reyal">
                                <div class="service-icon">
                                    <i class="bi bi-currency-exchange"></i>
                                </div>
                                <div class="service-name">Reyal</div>
                                <div class="service-desc">Penukaran Mata Uang</div>
                                <input type="checkbox" name="services[]" value="reyal" hidden>
                            </div>

                            <div class="service-item" data-service="tour">
                                <div class="service-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="service-name">Tour</div>
                                <div class="service-desc">City Tour & Ziarah</div>
                                <input type="checkbox" name="services[]" value="tour" hidden>
                            </div>

                            <div class="service-item" data-service="meals">
                                <div class="service-icon">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                                <div class="service-name">Meals</div>
                                <div class="service-desc">Makanan</div>
                                <input type="checkbox" name="services[]" value="meals" hidden>
                            </div>

                            <div class="service-item" data-service="dorongan">
                                <div class="service-icon">
                                    <i class="bi bi-basket"></i>
                                </div>
                                <div class="service-name">Dorongan</div>
                                <div class="service-desc">Bagi penyandang disabilitas</div>
                                <input type="checkbox" name="services[]" value="dorongan" hidden>
                            </div>

                            <div class="service-item" data-service="waqaf">
                                <div class="service-icon">
                                    <i class="bi bi-gift"></i>
                                </div>
                                <div class="service-name">Waqaf</div>
                                <div class="service-desc">Sedekah & Waqaf</div>
                                <input type="checkbox" name="services[]" value="waqaf" hidden>
                            </div>
                            <div class="service-item" data-service="badal">
                                <div class="service-icon">
                                    <i class="bi bi-gift"></i>
                                </div>
                                <div class="service-name">Badal umrah</div>
                                <div class="service-desc">Sedekah & Waqaf</div>
                                <input type="checkbox" name="services[]" value="waqaf" hidden>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Layanan Section -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>
                        <!-- Transportasi -->
                        <div class="detail-form" id="transportasi-details">
                            <h6 class="detail-title">
                                <i class="bi bi-airplane"></i> Transportasi
                            </h6>

                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="transport-item" data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" hidden>
                                    </div>

                                    <div class="transport-item" data-transportasi="bus">
                                        <div class="service-name">Transportasi darat</div>
                                        <input type="checkbox" name="transportation[]" value="bus" hidden>
                                    </div>
                                </div>
                                <div class="form-group" data-transportasi="airplane" id="pesawat">
                                    <div class="flex justify-between mb-2">
                                        <label class="form-label">Tiket Pesawat</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="addTicket">Tambah
                                            Tiket</button>
                                    </div>

                                    <div id="ticketWrapper">
                                        <!-- Form Tiket Template -->
                                        <div class="ticket-form bg-white p-3 border mb-3">
                                            <div class="row align-items-center">
                                                <!-- Tanggal -->
                                                <div class="col-5">
                                                    <label class="form-label fw-semibold">Tanggal Keberangkatan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-airplane"></i></span>
                                                        <input type="date" class="form-control" name="tanggal[]">
                                                    </div>
                                                </div>

                                                <!-- Rute -->
                                                <div class="col-5">
                                                    <label class="form-label fw-semibold">Rute</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-airplane-fill"></i></span>
                                                        <input type="text" class="form-control" name="rute[]"
                                                            placeholder="Contoh: CGK - JED">
                                                    </div>
                                                </div>

                                                <!-- Maskapai -->
                                                <div class="col-5 mt-3">
                                                    <label class="form-label fw-semibold">Maskapai</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-airplane"></i></span>
                                                        <input type="text" class="form-control" name="maskapai[]"
                                                            placeholder="Nama maskapai">
                                                    </div>
                                                </div>

                                                <!-- Harga -->
                                                <div class="col-5 mt-3">
                                                    <label class="form-label fw-semibold">Harga</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-cash"></i></span>
                                                        <input type="number" class="form-control" name="harga[]"
                                                            placeholder="Harga tiket">
                                                    </div>
                                                </div>
                                                <div class="col-5 mt-3">
                                                    <label class="form-label fw-semibold">Tiket pesawat pergi</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-cash"></i></span>
                                                        <input type="file" class="form-control"
                                                            name="tiket_berangkat[]" placeholder="Harga tiket">
                                                    </div>
                                                </div>
                                                <div class="col-5 mt-3">
                                                    <label class="form-label fw-semibold">Tiket pesawat pulang</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-cash"></i></span>
                                                        <input type="file" class="form-control" name="tiket_pulang[]"
                                                            placeholder="Harga tiket">
                                                    </div>
                                                </div>

                                                <!-- Keterangan -->
                                                <div class="col-5 mt-3">
                                                    <label class="form-label fw-semibold">Keterangan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i
                                                                class="bi bi-info-circle"></i></span>
                                                        <input type="text" class="form-control" name="keterangan[]"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol hapus -->
                                            <div class="mt-3 text-end">
                                                <button type="button" class="btn btn-danger btn-sm removeTicket">Hapus
                                                    Tiket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" data-transportasi="bus" id="bis">
                                    <label class="form-label">Transportasi darat</label>
                                    <button type="button" class="btn btn-submit" id="add-transport-btn">Tambah
                                        Transportasi</button>

                                    <div id="new-transport-forms">
                                        <div class="transport-set">
                                            <div class="cars mt-3">
                                                {{-- @foreach ($transportations as $data)
                                                    <div class="service-car"
                                                        data-id="{{ $data->id }}"
                                                        data-routes='@json($data->routes)'>

                                                        <div class="service-name">{{ $data->nama }}</div>
                                                        <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                        <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                        <div class="service-desc">Rp. {{ number_format($data->harga) }}/hari</div>

                                                        <input type="radio" name="transportation_id[]" value="{{ $data->id }}" class="d-none">
                                                    </div>
                                                @endforeach --}}
                                                @foreach ($transportations as $i => $data)
                                                    <div class="service-car" data-id="{{ $data->id }}"
                                                        data-routes='@json($data->routes)'>

                                                        <div class="service-name">{{ $data->nama }}</div>
                                                        <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                        <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                        <div class="service-desc">Rp.
                                                            {{ number_format($data->harga) }}/hari</div>

                                                        <input type="radio"
                                                            name="transportation_id[{{ $i }}]"
                                                            value="{{ $data->id }}" class="d-none">
                                                    </div>
                                                @endforeach

                                            </div>


                                            <div class="route-select hidden" id="route-select">
                                                <label class="form-label mt-2">Pilih Rute:</label>
                                                <select name="rute_id[]" class="form-control">
                                                    <option value="">-- Pilih Rute --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                            </div>


                        </div>
                    </div>

                    <!-- Hotel -->
                    <div class="detail-form" id="hotel-details">
                        <h6 class="detail-title">
                            <i class="bi bi-building"></i> Hotel
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary mb-2" id="addHotel">Tambah
                            Hotel</button>

                        <div id="hotelWrapper">
                            <!-- Form Hotel Template -->
                            <div class="hotel-form bg-white p-3 border mb-3">
                                <div class="row align-items-center">
                                    <!-- Checkin -->
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkin</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-calendar-check"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkin[]">
                                        </div>
                                    </div>

                                    <!-- Checkout -->
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkout</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-calendar-x"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkout[]">
                                        </div>
                                    </div>

                                    <!-- Nama Hotel -->
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Nama Hotel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="nama_hotel[]"
                                                placeholder="Nama hotel">


                                        </div>
                                    </div>

                                    <!-- Type Kamar -->
                                    <!-- Type Kamar (Checkbox + Jumlah) -->
                                    <!-- Type Kamar (Checkbox + Jumlah dinamis) -->
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-semibold">Tipe Kamar</label>
                                        <div class="row">
                                            <!-- Double -->
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input tipe-kamar" type="checkbox"
                                                        id="doubleCheck0" data-target="doubleJumlah0"
                                                        name="tipe_kamar[0][nama][]" value="Double">
                                                    <label class="form-check-label" for="doubleCheck0">Double</label>
                                                </div>
                                                <input type="number" class="form-control mt-1 jumlah-input d-none"
                                                    id="doubleJumlah0" name="tipe_kamar[0][jumlah][]"
                                                    placeholder="Jumlah" min="0">
                                            </div>

                                            <!-- Triple -->
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input tipe-kamar" type="checkbox"
                                                        id="tripleCheck0" data-target="tripleJumlah0"
                                                        name="tipe_kamar[0][nama][]" value="Triple">
                                                    <label class="form-check-label" for="tripleCheck0">Triple</label>
                                                </div>
                                                <input type="number" class="form-control mt-1 jumlah-input d-none"
                                                    id="tripleJumlah0" name="tipe_kamar[0][jumlah][]"
                                                    placeholder="Jumlah" min="0">
                                            </div>

                                            <!-- Kuard -->
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input tipe-kamar" type="checkbox"
                                                        id="kuardCheck0" data-target="kuardJumlah0"
                                                        name="tipe_kamar[0][nama][]" value="Kuard">
                                                    <label class="form-check-label" for="kuardCheck0">Kuard</label>
                                                </div>
                                                <input type="number" class="form-control mt-1 jumlah-input d-none"
                                                    id="kuardJumlah0" name="tipe_kamar[0][jumlah][]" placeholder="Jumlah"
                                                    min="0">
                                            </div>

                                            <!-- Kuint -->
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input tipe-kamar" type="checkbox"
                                                        id="kuintCheck0" data-target="kuintJumlah0"
                                                        name="tipe_kamar[0][nama][]" value="Kuint">
                                                    <label class="form-check-label" for="kuintCheck0">Kuint</label>
                                                </div>
                                                <input type="number" class="form-control mt-1 jumlah-input d-none"
                                                    id="kuintJumlah0" name="tipe_kamar[0][jumlah][]" placeholder="Jumlah"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Jumlah Kamar -->
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah Kamar</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-grid"></i></span>
                                            <input type="number" class="form-control" name="jumlah_kamar[]"
                                                placeholder="Jumlah kamar">
                                        </div>
                                    </div>

                                    <!-- Harga Per Kamar -->
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga per Kamar</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-cash"></i></span>
                                            <input type="number" class="form-control" name="harga_per_kamar[]"
                                                placeholder="Harga per kamar">
                                        </div>
                                    </div>

                                    <!-- Catatan -->
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol hapus -->
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                                        Hotel</button>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Dokumen -->
                    <div class="detail-form" id="dokumen-details">
                        <h6 class="detail-title">
                            <i class="bi bi-file-text"></i> Dokumen
                        </h6>

                        {{-- List parent document --}}
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($documents as $document)
                                    <div class="document-item" data-document="{{ $document->id }}">
                                        <div class="service-name">{{ $document->name }}</div>
                                        <input type="checkbox" name="documents[]" value="{{ $document->id }}" hidden>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Loop parent --}}
                        @foreach ($documents as $document)
                            @if ($document->childrens && $document->childrens->isNotEmpty())
                                {{-- Parent with children --}}
                                <div class="form-group hidden" id="doc-{{ $document->id }}-details">
                                    <label class="form-label">{{ $document->name }}</label>
                                    <div class="cars">
                                        @foreach ($document->childrens as $child)
                                            <div class="child-item" data-parent="doc-{{ $document->id }}"
                                                data-child="child-{{ $child->id }}">
                                                <div class="child-name">{{ $child->name }}</div>
                                                <input type="checkbox" name="child_documents[]"
                                                    value="{{ $child->id }}" hidden>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Loop form children --}}
                                    @foreach ($document->childrens as $child)
                                        <div class="child-form hidden" id="child-{{ $child->id }}-form">
                                            <h3>Form {{ $child->name }}</h3>
                                            <input type="text" class="form-control" name="jumlah_{{ $child->id }}"
                                                placeholder="Jumlah {{ $child->name }}">
                                            <input type="text" class="form-control" name="harga_{{ $child->id }}"
                                                placeholder="Harga {{ $child->name }}">
                                            <input type="text" class="form-control"
                                                name="keterangan_{{ $child->id }}"
                                                placeholder="Keterangan {{ $child->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="form-group hidden" id="doc-{{ $document->id }}-form">
                                    <h3>Form {{ $document->name }}</h3>
                                    <input type="text" class="form-control" name="jumlah_{{ $document->id }}"
                                        placeholder="Jumlah {{ $document->name }}">
                                    <input type="text" class="form-control" name="harga_{{ $document->id }}"
                                        placeholder="Harga {{ $document->name }}">
                                    <input type="text" class="form-control" name="keterangan_{{ $document->id }}"
                                        placeholder="Keterangan {{ $document->name }}">
                                </div>
                            @endif
                        @endforeach
                    </div>



                    <!-- Handling -->
                    <div class="detail-form" id="handling-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Handling
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                <!-- Handling Hotel -->
                                <div class="document-item" data-handling="hotel">

                                    <div class="service-name">Hotel</div>
                                    <input type="checkbox" name="handlings[]" value="hotel" hidden>
                                </div>

                                <!-- Handling Bandara -->
                                <div class="document-item" data-handling="bandara">

                                    <div class="service-name">Bandara</div>
                                    <input type="checkbox" name="handlings[]" value="bandara" hidden>
                                </div>
                            </div>
                        </div>
                        <!-- Form Hotel -->
                        <div class="form-group" data-handling="hotel" id="hotel" style="display: none;">
                            <label class="form-label">Hotel</label>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Hotel</label>
                                    <input type="text" class="form-control" name="nama_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control" name="harga_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Pax</label>
                                    <input type="text" class="form-control" name="pax_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Kode booking</label>
                                    <input type="file" class="form-control" name="kode_booking_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Rumlis</label>
                                    <input type="file" class="form-control" name="rumlis_hotel_handling">
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Identitas koper</label>
                                    <input type="file" class="form-control" name="identitas_hotel_handling">
                                </div>
                            </div>
                        </div> <!-- Tutup Form Hotel -->

                        <!-- Form Bandara -->
                        <div class="form-group" data-handling="bandara" id="bandara" style="display: none;">
                            <label class="form-label">Bandara</label>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Bandara</label>
                                    <input type="text" class="form-control" name="nama_bandara_handling">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jumlah Jamaah</label>
                                    <input type="text" class="form-control" name="jumlah_jamaah_handling">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control" name="harga_bandara_handling">
                                </div>
                                <div class="form-group"> <label class="form-label">Kedatangan Jamaah</label>
                                    <input type="date" class="form-control" name="kedatangan_jamaah_handling">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Paket info</label>
                                    <input type="file" class="form-control" name="paket_info">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Sopir</label>
                                    <input type="text" class="form-control" name="nama_supir">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Identitas koper</label>
                                    <input type="file" class="form-control" name="identitas_koper_bandara_handling">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pendamping -->
                    <div class="detail-form" id="pendamping-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Pendamping
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($guides as $guide)
                                    <div class="pendamping-wrapper">
                                        <div class="pendamping-item" data-pendamping="guide-{{ $guide->id }}"
                                            data-price="{{ $guide->harga }}">
                                            <div class="service-name">{{ $guide->nama }}</div>
                                            <div class="service-desc">Rp {{ number_format($guide->harga, 0, ',', '.') }}
                                            </div>
                                            <input type="checkbox" name="pendamping[]" value="{{ $guide->id }}"
                                                hidden>
                                        </div>
                                        <div class="pendamping-form hidden" id="form-guide-{{ $guide->id }}">
                                            <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                            <input type="number" class="form-control jumlah-pendamping"
                                                data-name="{{ $guide->nama }}" data-price="{{ $guide->harga }}"
                                                name="jumlah_{{ $guide->id }}" min="1">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <textarea class="form-control" name="ket_{{ $guide->id }}"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- content -->
                    <div class="detail-form" id="konten-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Content
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">

                                <!-- UMRAH -->
                                <div class="content-wrapper">
                                    <div class="content-item meal-item" data-content="umrah">
                                        <div class="service-name">Moment Umrah</div>
                                        <div class="service-desc">Rp. 120.000.000</div>
                                        <input type="checkbox" name="content[]" value="umrah" hidden>
                                    </div>
                                    <div class="content-form hidden" id="form-umrah">
                                        <label class="form-label">Jumlah Umrah</label>
                                        <input type="number" class="form-control" name="jumlah_umrah" min="1">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control" name="ket_umrah"></textarea>
                                    </div>
                                </div>

                                <!-- MEKKAH -->
                                <div class="content-wrapper">
                                    <div class="content-item" data-content="mekkah">

                                        <div class="service-name">Moment Mekkah</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="content[]" value="mekkah" hidden>
                                    </div>
                                    <div class="content-form hidden" id="form-mekkah">
                                        <label class="form-label">Jumlah Mekkah</label>
                                        <input type="number" class="form-control" name="jumlah_mekkah" min="1">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control" name="ket_mekkah"></textarea>
                                    </div>
                                </div>

                                <!-- MADINAH -->
                                <div class="content-wrapper">
                                    <div class="content-item" data-content="madinah">

                                        <div class="service-name">Moment Madinah</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="madinah" hidden>
                                    </div>
                                    <div class="content-form hidden" id="form-madinah">
                                        <label class="form-label">Jumlah Madinah</label>
                                        <input type="number" class="form-control" name="jumlah_madinah" min="1">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control" name="ket_madinah"></textarea>
                                    </div>
                                </div>

                                <!-- FULL CONTENT -->
                                <div class="content-wrapper">
                                    <div class="content-item" data-content="full-content">

                                        <div class="service-name">Full content</div>
                                        <div class="service-desc">Rp. 100.000.000</div>
                                        <input type="checkbox" name="content[]" value="full-content" hidden>
                                    </div>
                                    <div class="content-form hidden" id="form-full-content">
                                        <label class="form-label">Jumlah Full Content</label>
                                        <input type="number" class="form-control" name="jumlah_full_content"
                                            min="1">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control" name="ket_full_content"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="detail-form" id="reyal-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Penukaran mata uang
                        </h6>
                        <div class="detail-section">
                            <div class="form-group">
                                <label class="form-label">Jumlah Rupiah yang akan di tukarkan</label>
                                <input type="text" class="form-control" name="nama_bandara">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kurs (1 reyal = ... Rupiah)</label>
                                <input type="text" class="form-control" name="jumlah_jamaah">
                            </div>
                        </div>
                    </div>
                    <div class="detail-form" id="tour-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Tour
                        </h6>
                        <div class="detail-section">
                            <div class="tours">
                                @foreach ($tours as $tour)
                                    <label class="service-tour"
                                        data-tour="{{ strtolower(str_replace(' ', '-', $tour->name)) }}">
                                        <div class="service-name">{{ $tour->name }}</div>
                                        <input type="checkbox" name="tours[]" value="{{ $tour->id }}"
                                            class="d-none">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- FORM TRANSPORTASI --}}
                    @foreach ($tours as $tour)
                        @php
                            $slug = strtolower(str_replace(' ', '-', $tour->name));
                        @endphp
                        <div id="tour-{{ $slug }}-form" class="tour-form hidden">
                            <h4>Transportasi {{ $tour->name }}</h4>
                            <div class="transport-options">
                                @foreach ($transportations as $trans)
                                    <label class="transport-option">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas: {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas: {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga: {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_{{ $slug }}"
                                            value="{{ $trans->id }}" class="d-none">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach


                    <div class="detail-form" id="meals-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Makanan
                        </h6>
                        <div class="">
                            @foreach ($meals as $meal)
                                <div class="meal-item" data-meal="{{ strtolower(str_replace(' ', '-', $meal->name)) }}"
                                    data-price="{{ $meal->price }}" id="meal-item">
                                    <div class="service-name">{{ $meal->name }}</div>
                                    <div class="service-desc">{{ number_format($meal->price, 0, ',', '.') }}</div>
                                    <input type="checkbox" name="meals[]" value="{{ $meal->id }}" hidden>

                                </div>
                                <!-- form jumlah hidden -->
                                <div id="form-{{ strtolower(str_replace(' ', '-', $meal->name)) }}"
                                    class="form-jumlah hidden mt-2">
                                    <input type="number" class="jumlah-meal form-control" min="0" value="0"
                                        name="jumlah_meals[{{ $meal->name }}]" data-name="{{ $meal->name }}"
                                        data-price="{{ $meal->price }}">
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div id="premium-form" class="form-group hidden">
                        <label class="form-label">Jumlah Nasi Box</label>
                        <input type="text" class="form-control" name="jumlah_nasi_box">
                    </div>

                    <div id="standard-form" class="form-group hidden">
                        <label class="form-label">Jumlah Buffle Hotel</label>
                        <input type="text" class="form-control" name="jumlah_buffle_hotel">
                    </div>

                    <div id="muthawifah-form" class="form-group hidden">
                        <label class="form-label">Jumlah Snack</label>
                        <input type="text" class="form-control" name="jumlah_snack">
                    </div>
                    <div class="detail-form" id="dorongan-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Dorongan
                        </h6>
                        <div class="service-grid">
                            <div class="meal-item" data-content="umrah">

                                <div class="service-name">Umrah</div>
                                <div class="service-desc">Rp. 120.000.000</div>
                                <input type="checkbox" name="dorongan[]" value="umrah" hidden>
                            </div>

                            <div class="meal-item" data-content="makkah">

                                <div class="service-name">Makkah</div>
                                <div class="service-desc">Rp. 80.000.000</div>
                                <input type="checkbox" name="dorongan[]" value="makkah" hidden>
                            </div>

                            <div class="meal-item" data-content="tawaf">

                                <div class="service-name">Tawaf</div>
                                <div class="service-desc">Rp. 70.000.000</div>
                                <input type="checkbox" name="dorongan[]" value="tawaf" hidden>
                            </div>

                            <div class="meal-item" data-content="dorongan-sel">

                                <div class="service-name">Dorongan sel</div>
                                <div class="service-desc">Rp. 70.000.000</div>
                                <input type="checkbox" name="dorongan[]" value="dorongan-sel" hidden>
                            </div>
                        </div>
                    </div>

                    <div id="umrah-form" class="form-group hidden">
                        <label class="form-label">Jumlah Umrah</label>
                        <input type="text" class="form-control" name="jumlah_umrah_dorongan">
                    </div>

                    <div id="makkah-form" class="form-group hidden">
                        <label class="form-label">Jumlah Makkah</label>
                        <input type="text" class="form-control" name="jumlah_makkah">
                    </div>

                    <div id="tawaf-form" class="form-group hidden">
                        <label class="form-label">Jumlah Tawaf</label>
                        <input type="text" class="form-control" name="jumlah_tawaf">
                    </div>

                    <div id="dorongan-sel-form" class="form-group hidden">
                        <label class="form-label">Jumlah Dorongan sel</label>
                        <input type="text" class="form-control" name="jumlah_dorongan_sel">
                    </div>
                    <div class="detail-form" id="waqaf-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Wakaf
                        </h6>
                        <div class="service-grid">
                            <div class="wakaf-item" data-content="berbagi-air">

                                <div class="service-name">Berbagi Air</div>
                                <input type="checkbox" name="wakaf[]" value="berbagi-air" hidden>
                            </div>

                            <div class="wakaf-item" data-content="berbagi-nasi">

                                <div class="service-name">Berbagi nasi kotak</div>
                                <div class="service-desc">Rp. 80.000.000</div>
                                <input type="checkbox" name="wakaf[]" value="berbagi-nasi" hidden>
                            </div>

                            <div class="wakaf-item" data-content="mushaf">

                                <div class="service-name">Mushaf al quran</div>
                                <div class="service-desc">Rp. 70.000.000</div>
                                <input type="checkbox" name="wakaf[]" value="mushaf" hidden>
                            </div>
                        </div>
                    </div>

                    <div id="berbagi-air-form" class="form-group hidden">
                        <label class="form-label">Jumlah Berbagi Air</label>
                        <input type="text" class="form-control" name="jumlah_berbagi_air">
                    </div>

                    <div id="berbagi-nasi-form" class="form-group hidden">
                        <label class="form-label">Jumlah Berbagi Nasi Kotak</label>
                        <input type="text" class="form-control" name="jumlah_berbagi_nasi">
                    </div>

                    <div id="mushaf-form" class="form-group hidden">
                        <label class="form-label">Jumlah Mushaf al-Quran</label>
                        <input type="text" class="form-control" name="jumlah_mushaf">
                    </div>
                    <div class="detail-form" id="badal-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Badal
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary mb-2" id="addBadal">Tambah
                            Badal</button>

                        <div id="badalWrapper">
                            <!-- Form Badal Template -->
                            <div class="badal-form bg-white p-3 border mb-3">
                                <div class="form-group mb-2">
                                    <label class="form-label">Nama yang dibadalkan</label>
                                    <input type="text" class="form-control" name="nama_badal[]">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="harga_badal[]">
                                </div>

                                <!-- Tombol hapus -->
                                <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                        Badal</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Tambahkan detail untuk divisi lainnya di sini -->

            </div>
            <div class="form-section p-3" id="cart-total-price" style="display: none;">
                <h6 class="form-section-title">
                    <i class="bi bi-card-checklist"></i> Detail product yang dipilih
                </h6>
                <ul id="cart-items" class="list-group mt-2"></ul>
                <div class="mt-3 text-end">
                    <strong>Total:
                        <input type="hidden" name="total_amount" id="cart-total" value="0">
                        <span id="cart-total-text">Rp. 0</span>
                    </strong>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" name="action" value="save" class="btn btn-primary">
                    Simpan
                </button>

                <button type="submit" name="action" value="nego" class="btn btn-warning">
                    Nego
                </button>
            </div>
            </form>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/transportasi_transportasi.js') }}"></script>
    <script src="{{ asset('js/document.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Toggle seleksi service item
            const serviceItems = document.querySelectorAll('.service-item');
            serviceItems.forEach(item => {
                item.addEventListener('click', () => {
                    item.classList.toggle('selected');
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;

                    // Toggle tampilan detail form
                    const serviceType = item.getAttribute('data-service');
                    const detailForm = document.getElementById(`${serviceType}-details`);
                    if (detailForm) {
                        detailForm.style.display = checkbox.checked ? 'block' : 'none';
                    }

                    console.log(serviceType);

                });
            });





            // Toggle seleksi transport item
            const transportItems = document.querySelectorAll('.transport-item');
            transportItems.forEach(item => {
                item.addEventListener('click', () => {
                    item.classList.toggle('selected');
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    // Toggle tampilan detail form
                    const transportType = item.getAttribute('data-transportasi');
                    if (transportType === 'airplane') {
                        document.getElementById('pesawat').style.display = checkbox.checked ?
                            'block' : 'none';
                    } else if (transportType === 'bus') {
                        document.getElementById('bis').style.display = checkbox.checked ? 'block' :
                            'none';
                    }
                });
            });



            const serviceTour = document.querySelectorAll(".service-tour");

            serviceTour.forEach(tour => {
                tour.addEventListener("click", (event) => {
                    event.preventDefault(); // cegah toggle radio default
                    const typeTour = tour.getAttribute('data-tour');
                    const detailForm = document.getElementById(`tour-${typeTour}-form`);
                    const radioTour = tour.querySelector('input[type="checkbox"]');

                    // toggle class selected
                    const isSelected = tour.classList.toggle('selected');

                    // toggle radio checked sesuai selected
                    radioTour.checked = isSelected;

                    // tampilkan atau sembunyikan form sesuai toggle
                    if (detailForm) {
                        detailForm.style.display = isSelected ? 'block' : 'none';
                    }
                });
            });




            // Validasi form sebelum submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = 'var(--danger-color)';
                    } else {
                        field.style.borderColor = '';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Harap isi semua field yang wajib diisi!');
                }
            });
        });


        document.getElementById('travel-select').addEventListener('change', function() {
            let option = this.options[this.selectedIndex];

            document.getElementById('penanggung').value = option.getAttribute('data-penanggung');
            document.getElementById('email').value = option.getAttribute('data-email');
            document.getElementById('phone').value = option.getAttribute('data-telepon');


        });


        document.addEventListener("click", function(e) {
            // Tambah form pesawat
            if (e.target.closest(".add-plane")) {
                const wrapper = document.getElementById("plane-wrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("d-flex", "gap-2", "mb-2");
                newForm.innerHTML = `
            <select name="plane[]" class="form-control">
                <option value="" disabled selected>Pilih Tiket Pesawat</option>
                <option value="jakarta-jeddah">Jakarta - Jeddah (transit Malaysia), tanggalnya, maskapai</option>
                <option value="surabaya-jeddah">Surabaya - Jeddah (transit Malaysia), tanggalnya, maskapai</option>
                <option value="medan-jeddah">Medan - Jeddah (transit Malaysia), tanggalnya, maskapai</option>
                <option value="bali-jeddah">Bali - Jeddah (transit Malaysia), tanggalnya, maskapai</option>
                <option value="makassar-jeddah">Makassar - Jeddah (transit Malaysia), tanggalnya, maskapai</option>
            </select>
            <button type="button" class="btn btn-danger remove-plane">Hapus</button>
        `;
                wrapper.appendChild(newForm);
            }

            // Hapus form pesawat
            if (e.target.closest(".remove-plane")) {
                const formItem = e.target.closest(".d-flex");
                if (formItem) {
                    formItem.remove();
                }
            }
        });


        const handlings = document.querySelectorAll(".document-item[data-handling]");

        handlings.forEach(item => {
            item.addEventListener("click", () => {
                item.classList.toggle("selected");

                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;

                const handlingType = item.getAttribute("data-handling").toLowerCase();
                const target = document.getElementById(handlingType);

                if (target) {
                    target.style.display = checkbox.checked ? "block" : "none";
                }
            });
        });


        const addBtn = document.getElementById("addTicket");
        const wrapper = document.getElementById("ticketWrapper");

        addBtn.addEventListener("click", function() {
            // clone form pertama
            const newTicket = wrapper.firstElementChild.cloneNode(true);

            // reset input value
            newTicket.querySelectorAll("input").forEach(input => input.value = "");

            wrapper.appendChild(newTicket);
        });

        // Event Delegation untuk hapus
        wrapper.addEventListener("click", function(e) {
            if (e.target.classList.contains("removeTicket")) {
                if (wrapper.children.length > 1) {
                    e.target.closest(".ticket-form").remove();
                } else {
                    alert("Minimal harus ada 1 tiket!");
                }
            }
        });


        let hotelIndex = 0;

        document.getElementById('addHotel').addEventListener('click', function() {
            hotelIndex++;
            let wrapper = document.getElementById('hotelWrapper');

            // Clone template
            let newHotel = document.querySelector('.hotel-form').cloneNode(true);

            // Reset semua input
            newHotel.querySelectorAll('input').forEach(input => {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            });

            // Update name attribute sesuai index hotelIndex
            newHotel.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('[0]', `[${hotelIndex}]`);
            });

            // Update id unik biar ga bentrok
            newHotel.querySelectorAll('[id]').forEach(el => {
                el.id = el.id + '_' + hotelIndex;
            });

            wrapper.appendChild(newHotel);
        });

        // Hapus hotel
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeHotel')) {
                e.target.closest('.hotel-form').remove();
            }
        });

        // Toggle jumlah kamar saat checkbox dicentang
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('tipe-kamar')) {
                let targetId = e.target.getAttribute('data-target');
                let jumlahInput = document.getElementById(targetId);
                if (jumlahInput) {
                    jumlahInput.classList.toggle('d-none', !e.target.checked);
                }
            }
        });




        const addBadalBtn = document.getElementById("addBadal");
        const badalWrapper = document.getElementById("badalWrapper");

        // Tambah badal
        addBadalBtn.addEventListener("click", function() {
            const newBadal = badalWrapper.firstElementChild.cloneNode(true);

            // reset value input
            newBadal.querySelectorAll("input").forEach(input => input.value = "");

            badalWrapper.appendChild(newBadal);
        });

        // Hapus badal
        badalWrapper.addEventListener("click", function(e) {
            if (e.target.classList.contains("removeBadal")) {
                if (badalWrapper.children.length > 1) {
                    e.target.closest(".badal-form").remove();
                } else {
                    alert("Minimal harus ada 1 form badal!");
                }
            }
        });


        document.querySelectorAll('.visa-item').forEach(car => {
            car.addEventListener('click', function() {
                // hapus active di semua
                document.querySelectorAll('.visa-item').forEach(el => el.classList.remove(
                    'active'));

                // kasih active ke yg diklik
                this.classList.add('active');

                // set radio checked
                this.querySelector('input[type="radio"]').checked = true;

                // ambil value
                let val = this.querySelector('input[type="radio"]').value;
                console.log(val)
            });
        });


        const items = document.querySelectorAll('.pendamping-item');

        items.forEach(item => {
            item.addEventListener('click', () => {
                const form = item.nextElementSibling; // form berada tepat setelah item
                const checkbox = item.querySelector('input[type="checkbox"]');

                const isActive = item.classList.toggle('active');
                checkbox.checked = isActive;
                form.style.display = isActive ? 'block' : 'none';
            });
        });



        const visaItems = document.querySelectorAll('.visa-item');
        const formDetails = {
            umrah: document.getElementById('umrah-detail'),
            haji: document.getElementById('haji-detail'),
            ziarah: document.getElementById('ziarah-detail')
        };

        // Tambahkan event listener untuk setiap item visa
        visaItems.forEach(item => {
            item.addEventListener('click', () => {
                // Dapatkan jenis visa dari atribut data
                const visaType = item.dataset.visa;
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Toggle class 'active' untuk styling
                item.classList.toggle('active');

                // Toggle status 'checked' pada checkbox
                checkbox.checked = !checkbox.checked;

                // Tampilkan atau sembunyikan form yang sesuai berdasarkan status checkbox
                if (checkbox.checked) {
                    if (formDetails[visaType]) {
                        formDetails[visaType].classList.remove('hidden');
                    }
                } else {
                    if (formDetails[visaType]) {
                        formDetails[visaType].classList.add('hidden');
                    }
                }
            });
        });


        const vaksinItems = document.querySelectorAll('.vaksin-item');
        const formDetailsVaksin = {
            polio: document.getElementById('polio'),
            meningtis: document.getElementById('meningtis')
        };

        // Tambahkan event listener untuk setiap item vaksin
        vaksinItems.forEach(item => {
            item.addEventListener('click', () => {
                // Dapatkan jenis vaksin dari atribut data
                const vaksinType = item.dataset.vaksin;
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Toggle class 'active' untuk styling
                item.classList.toggle('selected');

                // Toggle status 'checked' pada checkbox
                checkbox.checked = !checkbox.checked;

                // Tampilkan atau sembunyikan form yang sesuai berdasarkan status checkbox
                if (checkbox.checked) {
                    if (formDetailsVaksin[vaksinType]) {
                        formDetailsVaksin[vaksinType].classList.remove('hidden');
                    }
                } else {
                    if (formDetailsVaksin[vaksinType]) {
                        formDetailsVaksin[vaksinType].classList.add('hidden');
                    }
                }
            });
        });



        const tourOptions = document.querySelectorAll('.service-car');
        const tourForms = document.querySelectorAll('.tour-form');

        tourOptions.forEach(option => {
            option.addEventListener('click', () => {
                const tourType = option.dataset.tour;

                // Sembunyikan semua form terlebih dahulu
                tourForms.forEach(form => {
                    form.classList.add('hidden');
                });

                // Tampilkan form yang sesuai
                const selectedForm = document.getElementById(`tour-${tourType}-form`);
                if (selectedForm) {
                    selectedForm.classList.remove('hidden');
                }
            });
        });

        // Dapatkan semua item makanan
        const mealItems = document.querySelectorAll('.meal-item');
        // Buat objek untuk memetakan jenis makanan ke ID form
        const formDetailMeals = {
            premium: document.getElementById('premium-form'),
            standard: document.getElementById('standard-form'),
            muthawifah: document.getElementById('muthawifah-form')
        };

        // Tambahkan event listener untuk setiap item makanan
        mealItems.forEach(item => {
            item.addEventListener('click', () => {
                // Dapatkan jenis makanan dari atribut data
                const mealType = item.dataset.content;
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Toggle class 'active' untuk styling
                item.classList.toggle('active');

                // Toggle status 'checked' pada checkbox
                checkbox.checked = !checkbox.checked;

                // Tampilkan atau sembunyikan form yang sesuai berdasarkan status checkbox
                if (checkbox.checked) {
                    if (formDetailMeals[mealType]) {
                        formDetailMeals[mealType].classList.remove('hidden');
                    }
                } else {
                    if (formDetailMeals[mealType]) {
                        formDetailMeals[mealType].classList.add('hidden');
                    }
                }
            });
        });

        // Dapatkan semua item dorongan
        const doronganItems = document.querySelectorAll('#dorongan-details .dorongan-item');
        // Buat objek untuk memetakan jenis dorongan ke ID form
        const formDetailDorongans = {
            umrah: document.getElementById('umrah-form'),
            makkah: document.getElementById('makkah-form'),
            tawaf: document.getElementById('tawaf-form'),
            'dorongan-sel': document.getElementById('dorongan-sel-form')
        };

        // Tambahkan event listener untuk setiap item dorongan
        doronganItems.forEach(item => {
            item.addEventListener('click', () => {
                // Dapatkan jenis dorongan dari atribut data
                const doronganType = item.dataset.content;
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Toggle class 'active' untuk styling
                item.classList.toggle('active');

                // Toggle status 'checked' pada checkbox
                checkbox.checked = !checkbox.checked;

                // Tampilkan atau sembunyikan form yang sesuai berdasarkan status checkbox
                if (checkbox.checked) {
                    if (formDetailDorongans[doronganType]) {
                        formDetailDorongans[doronganType].classList.remove('hidden');
                    }
                } else {
                    if (formDetailDorongans[doronganType]) {
                        formDetailDorongans[doronganType].classList.add('hidden');
                    }
                }
            });
        });


        // Dapatkan semua item wakaf
        const waqafItems = document.querySelectorAll('#waqaf-details .wakaf-item');
        // Buat objek untuk memetakan jenis wakaf ke ID form
        const formDetailWakaf = {
            'berbagi-air': document.getElementById('berbagi-air-form'),
            'berbagi-nasi': document.getElementById('berbagi-nasi-form'),
            'mushaf': document.getElementById('mushaf-form')
        };

        // Tambahkan event listener untuk setiap item wakaf
        waqafItems.forEach(item => {
            item.addEventListener('click', () => {
                // Dapatkan jenis wakaf dari atribut data
                const waqafType = item.dataset.content;
                const checkbox = item.querySelector('input[type="checkbox"]');

                // Toggle class 'active' untuk styling
                item.classList.toggle('active');

                // Toggle status 'checked' pada checkbox
                checkbox.checked = !checkbox.checked;

                // Tampilkan atau sembunyikan form yang sesuai berdasarkan status checkbox
                if (checkbox.checked) {
                    if (formDetailWakaf[waqafType]) {
                        formDetailWakaf[waqafType].classList.remove('hidden');
                    }
                } else {
                    if (formDetailWakaf[waqafType]) {
                        formDetailWakaf[waqafType].classList.add('hidden');
                    }
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".tipe-kamar").forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    const targetId = this.getAttribute("data-target");
                    const inputJumlah = document.getElementById(targetId);

                    if (this.checked) {
                        inputJumlah.classList.remove("d-none");
                    } else {
                        inputJumlah.classList.add("d-none");
                        inputJumlah.value = ""; // reset biar ga terkirim angka kosong
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const cartSection = document.getElementById("cart-total-price");
            const cartList = document.getElementById("cart-items");

            function formatRupiah(angka) {
                return "Rp. " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function hitungTotal() {
                let total = 0;
                cartList.querySelectorAll("li").forEach(li => {
                    total += parseInt(li.dataset.price || 0);
                });

                document.getElementById('cart-total').value = total;
                document.getElementById('cart-total-text').innerText = formatRupiah(total);
            }

            function toggleCartItem(name, unitPrice, jumlah) {
                const existingItem = cartList.querySelector(`[data-name="${name}"]`);
                if (existingItem) existingItem.remove();

                if (jumlah > 0) {
                    const totalHarga = unitPrice * jumlah;
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
                    li.setAttribute("data-name", name);
                    li.setAttribute("data-price", totalHarga);
                    li.innerHTML = `
                <span>${name} <small class="text-muted">x${jumlah}</small></span>
                <span class="fw-bold">${formatRupiah(totalHarga)}</span>
            `;
                    cartList.appendChild(li);
                }

                cartSection.style.display = cartList.children.length > 0 ? "block" : "none";
                hitungTotal();
            }

            // toggle form ketika klik item pendamping
            document.querySelectorAll(".pendamping-item").forEach(item => {
                item.addEventListener("click", () => {
                    const key = item.dataset.pendamping;
                    const form = document.getElementById("form-" + key);
                    form.classList.toggle("hidden");

                    if (form.classList.contains("hidden")) {
                        const jumlahInput = form.querySelector("input[type='number']");
                        if (jumlahInput) {
                            toggleCartItem(item.querySelector(".service-name").innerText, parseInt(
                                item.dataset.price), 0);
                            jumlahInput.value = "";
                        }
                    }
                });
            });

            // update cart ketika jumlah diubah
            document.querySelectorAll(".jumlah-pendamping").forEach(input => {
                input.addEventListener("input", function() {
                    const qty = parseInt(this.value || 0);
                    const name = this.dataset.name;
                    const price = parseInt(this.dataset.price);
                    toggleCartItem(name, price, qty);
                });
            });


            // toggle cart ketika klik meal item
            // document.querySelectorAll(".meal-item").forEach(item => {
            //     item.addEventListener("click", () => {
            //         const name = item.querySelector(".service-name").innerText;
            //         const price = parseInt(item.querySelector(".service-desc").innerText);

            //         // cek apakah sudah ada di cart
            //         const existingItem = cartList.querySelector(`[data-name="${name}"]`);
            //         if (existingItem) {
            //             // kalau ada, hapus
            //             existingItem.remove();
            //         } else {
            //             // kalau belum, tambahkan qty default = 1
            //             toggleCartItem(name, price, 1);
            //         }

            //         cartSection.style.display = cartList.children.length > 0 ? "block" : "none";
            //         hitungTotal();
            //     });
            // });
            // toggle form ketika klik meal
            document.querySelectorAll(".meal-item").forEach(item => {
                item.addEventListener("click", () => {
                    const key = item.dataset.meal;
                    const form = document.getElementById("form-" + key);

                    form.classList.toggle("hidden");

                    if (form.classList.contains("hidden")) {
                        // reset qty dan hapus dari cart
                        const jumlahInput = form.querySelector("input[type='number']");
                        if (jumlahInput) {
                            toggleCartItem(item.querySelector(".service-name").innerText, parseInt(
                                item.dataset.price), 0);
                            jumlahInput.value = 0;
                        }
                    }
                });
            });

            // update cart ketika jumlah meal diubah
            document.querySelectorAll(".jumlah-meal").forEach(input => {
                input.addEventListener("input", function() {
                    const qty = parseInt(this.value || 0);
                    const name = this.dataset.name;
                    const price = parseInt(this.dataset.price);

                    toggleCartItem(name, price, qty);
                });
            });

        });











        document.querySelectorAll('.form-group').forEach(form => {
            const input = form.querySelector('input');
            if (form.classList.contains('hidden')) {
                input.removeAttribute('required');
            } else {
                // kalau form ditampilkan, bisa tambahkan required sesuai kebutuhan
                input.setAttribute('required', 'required');
            }
        });




        document.getElementById('my-form').addEventListener('submit', function(e) {
            document.querySelectorAll('.form-group').forEach(form => {
                const input = form.querySelector('input');
                if (form.classList.contains('hidden')) {
                    input.removeAttribute('required');
                }
            });
        });









        document.addEventListener("DOMContentLoaded", () => {
            const tourItems = document.querySelectorAll(".service-tour");

            tourItems.forEach(item => {
                item.addEventListener("click", () => {
                    const checkbox = item.querySelector("input[type='checkbox']");
                    const tourSlug = item.getAttribute("data-tour");
                    const form = document.getElementById(`tour-${tourSlug}-form`);

                    // toggle aktif / nonaktif
                    const isActive = item.classList.toggle("active");
                    checkbox.checked = isActive;
                    form.classList.toggle("hidden", !isActive);
                });
            });

            // transportasi radio toggle
            const transportOptions = document.querySelectorAll(".transport-option");
            transportOptions.forEach(option => {
                option.addEventListener("click", () => {
                    const input = option.querySelector("input[type='radio']");
                    const groupName = input.getAttribute("name");

                    // reset semua dalam group
                    document.querySelectorAll(`input[name='${groupName}']`).forEach(radio => {
                        radio.checked = false;
                        radio.closest(".transport-option").classList.remove("active");
                    });

                    // set aktif yg dipilih
                    input.checked = true;
                    option.classList.add("active");
                });
            });
        });
    </script>
@endsection
