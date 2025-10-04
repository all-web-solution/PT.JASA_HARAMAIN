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
        .content-item.selected,
        .visa-item.selected,
        .vaksin-item.selected,
        .service-tour.selected,
        .service-tour-makkah.selected,
        .service-tour-madinah.selected,
        .service-tour-al-ula.selected,
        .service-tour-thoif.selected,
        .selected {
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

        .document-item {
            border: 1px solid #ccc;
            padding: 12px;
            cursor: pointer;
            border-radius: 10px;
            text-align: center;
            transition: 0.2s;
        }

        .document-item.active {
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
                <form action="{{ route('update.nego.admin', $service->id) }}" method="POST">
                    @csrf
                    @method('put')
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
                                        <option value="{{ $service->pelanggan->id }}" name="pelanggan_id">
                                            {{ $service->pelanggan->nama_travel }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly required id="penanggung"
                                        value="{{ $service->pelanggan->penanggung_jawab }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required id="email"
                                        value="{{ $service->pelanggan->email }}" readonly>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" required id="phone"
                                        value="{{ $service->pelanggan->phone }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required
                                        value="{{ $service->tanggal_keberangkatan }}" readonly>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ $service->tanggal_kepulangan }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ $service->total_jamaah }}" readonly>
                        </div>
                    </div>

                    <!-- Pilih Layanan Section -->
                    @php
                        $selectedServices = $selectedServices ?? [];
                    @endphp

                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                        </h6>

                        <div class="service-grid">
                            <div class="service-item {{ in_array('transportasi', $selectedServices) ? 'selected' : '' }}"
                                data-service="transportasi">
                                <div class="service-icon"><i class="bi bi-airplane"></i></div>
                                <div class="service-name">Transportasi</div>
                                <div class="service-desc">Tiket & Transport</div>
                                <input type="checkbox" name="services[]" value="transportasi" hidden
                                    {{ in_array('transportasi', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('hotel', $selectedServices) ? 'selected' : '' }}"
                                data-service="hotel">
                                <div class="service-icon"><i class="bi bi-building"></i></div>
                                <div class="service-name">Hotel</div>
                                <div class="service-desc">Akomodasi</div>
                                <input type="checkbox" name="services[]" value="hotel" hidden
                                    {{ in_array('hotel', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('dokumen', $selectedServices) ? 'selected' : '' }}"
                                data-service="dokumen">
                                <div class="service-icon"><i class="bi bi-file-text"></i></div>
                                <div class="service-name">Dokumen</div>
                                <div class="service-desc">Visa & Administrasi</div>
                                <input type="checkbox" name="services[]" value="dokumen" hidden
                                    {{ in_array('dokumen', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('handling', $selectedServices) ? 'selected' : '' }}"
                                data-service="handling">
                                <div class="service-icon"><i class="bi bi-briefcase"></i></div>
                                <div class="service-name">Handling</div>
                                <div class="service-desc">Bandara & Hotel</div>
                                <input type="checkbox" name="services[]" value="handling" hidden
                                    {{ in_array('handling', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('pendamping', $selectedServices) ? 'selected' : '' }}"
                                data-service="pendamping">
                                <div class="service-icon"><i class="bi bi-people"></i></div>
                                <div class="service-name">Pendamping</div>
                                <div class="service-desc">Tour Leader & Mutawwif</div>
                                <input type="checkbox" name="services[]" value="pendamping" hidden
                                    {{ in_array('pendamping', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('konten', $selectedServices) ? 'selected' : '' }}"
                                data-service="konten">
                                <div class="service-icon"><i class="bi bi-camera"></i></div>
                                <div class="service-name">Konten</div>
                                <div class="service-desc">Dokumentasi</div>
                                <input type="checkbox" name="services[]" value="konten" hidden
                                    {{ in_array('konten', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('reyal', $selectedServices) ? 'selected' : '' }}"
                                data-service="reyal">
                                <div class="service-icon"><i class="bi bi-currency-exchange"></i></div>
                                <div class="service-name">Reyal</div>
                                <div class="service-desc">Penukaran Mata Uang</div>
                                <input type="checkbox" name="services[]" value="reyal" hidden
                                    {{ in_array('reyal', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('tour', $selectedServices) ? 'selected' : '' }}"
                                data-service="tour">
                                <div class="service-icon"><i class="bi bi-geo-alt"></i></div>
                                <div class="service-name">Tour</div>
                                <div class="service-desc">City Tour & Ziarah</div>
                                <input type="checkbox" name="services[]" value="tour" hidden
                                    {{ in_array('tour', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('meals', $selectedServices) ? 'selected' : '' }}"
                                data-service="meals">
                                <div class="service-icon"><i class="bi bi-egg-fried"></i></div>
                                <div class="service-name">Meals</div>
                                <div class="service-desc">Makanan</div>
                                <input type="checkbox" name="services[]" value="meals" hidden
                                    {{ in_array('meals', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('dorongan', $selectedServices) ? 'selected' : '' }}"
                                data-service="dorongan">
                                <div class="service-icon"><i class="bi bi-basket"></i></div>
                                <div class="service-name">Dorongan</div>
                                <div class="service-desc">Bagi penyandang disabilitas</div>
                                <input type="checkbox" name="services[]" value="dorongan" hidden
                                    {{ in_array('dorongan', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('wakaf', $selectedServices) ? 'selected' : '' }}"
                                data-service="wakaf">
                                <div class="service-icon"><i class="bi bi-gift"></i></div>
                                <div class="service-name">Wakaf</div>
                                <div class="service-desc">Sedekah & Wakaf</div>
                                <input type="checkbox" name="services[]" value="wakaf" hidden
                                    {{ in_array('wakaf', $selectedServices) ? 'checked' : '' }}>
                            </div>

                            <div class="service-item {{ in_array('badal', $selectedServices) ? 'selected' : '' }}"
                                data-service="badal">
                                <div class="service-icon"><i class="bi bi-gift"></i></div>
                                <div class="service-name">Badal Umrah</div>
                                <div class="service-desc">Layanan Badal Umrah</div>
                                <input type="checkbox" name="services[]" value="badal" hidden
                                    {{ in_array('badal', $selectedServices) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <!-- Detail Layanan Section -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>
                        <!-- Transportasi -->
                        <div class="detail-form {{ in_array('transportasi', $selectedServices) ? '' : 'hidden' }}" id="transportasi-details">
                            <h6 class="detail-title">
                                <i class="bi bi-airplane"></i> Transportasi
                            </h6>

                            <div class="detail-section ">
                                <div class="service-grid">
                                    <div class="transport-item" data-transportasi="airplane">
                                        <div class="service-icon">
                                            <i class="bi bi-airplane"></i>
                                        </div>
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" hidden>
                                    </div>

                                    <div class="transport-item" data-transportasi="bus">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
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
                                    <div class="cars">
                                        @foreach ($transportations as $data)
                                            <label class="service-car">
                                                <div class="service-name">{{ $data->nama }}</div>
                                                <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                <div class="service-desc">Rp. {{ $data->harga }}/hari</div>
                                                <input type="radio" name="transportation_id"
                                                    value="{{ $data->id }}" class="d-none">
                                            </label>
                                        @endforeach


                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Hotel -->
                        <div class="detail-form {{ in_array('hotel', $selectedServices) ? '' : 'hidden' }}" id="hotel-details">
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
                                                <span class="input-group-text bg-white"><i
                                                        class="bi bi-building"></i></span>
                                                <input type="text" class="form-control" name="nama_hotel[]"
                                                    placeholder="Nama hotel">

                                            </div>
                                        </div>

                                        <!-- Type Kamar -->
                                        <div class="col-5 mt-3">
                                            <label class="form-label fw-semibold">Tipe Kamar</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i
                                                        class="bi bi-door-closed"></i></span>
                                                <input type="text" class="form-control" name="tipe_kamar[]"
                                                    placeholder="Tipe kamar">
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
                        <div class="detail-form {{ in_array('dokumen', $selectedServices) ? '' : 'hidden' }}" id="dokumen-details">
                            <h6 class="detail-title">
                                <i class="bi bi-file-text"></i> Dokumen
                            </h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="document-item" data-document="visa" id="document-item">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-passport-fill" viewBox="0 0 16 16">
                                                <path d="M8 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                                <path
                                                    d="M2 3.252a1.5 1.5 0 0 1 1.232-1.476l8-1.454A1.5 1.5 0 0 1 13 1.797v.47A2 2 0 0 1 14 4v10a2 2 0 0 1-2 2H4a2 2 0 0 1-1.51-.688 1.5 1.5 0 0 1-.49-1.11V3.253ZM5 8a3 3 0 1 0 6 0 3 3 0 0 0-6 0m0 4.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Visa</div>
                                        <input type="checkbox" name="documents[]" value="visa" checked hidden>
                                    </div>
                                    <div class="document-item" data-document="vaksin" id="document-item">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                                <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                                <path
                                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zm2 3v10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4zM3 3h10V1H3z" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Vaksin</div>

                                        <input type="checkbox" name="documents[]" value="vaksin" checked hidden>
                                    </div>

                                    <div class="document-item" data-document="sikopatur" id="document-item">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Sikopatur</div>
                                        <input type="checkbox" name="documents[]" value="bus" checked hidden>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group hidden" data-document="visa" id="visa-details">
                                <label class="form-label">Visa</label>
                                <div class="cars">
                                    <div class="visa-item" data-visa="umrah">
                                        <div class="visa-name">Visa Umrah</div>
                                        <input type="checkbox" name="visa[]" value="umrah" hidden>
                                    </div>
                                    <div class="visa-item" data-visa="haji">
                                        <div class="visa-name">Visa Haji</div>
                                        <input type="checkbox" name="visa[]" value="haji" hidden>
                                    </div>
                                    <div class="visa-item" data-visa="ziarah">
                                        <div class="visa-name">Visa Ziarah</div>
                                        <input type="checkbox" name="visa[]" value="ziarah" hidden>
                                    </div>
                                </div>
                                <div id="umrah-detail" class="hidden">
                                    <h3>Form umrah</h3>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                </div>
                                <div id="haji-detail" class="hidden">
                                    <h3>Form haji</h3>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                </div>
                                <div id="ziarah-detail" class="hidden">
                                    <h3>Form ziarah</h3>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]"
                                                placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden" data-document="vaksin" id="vaksin-details">
                                <label class="form-label">Vaksin</label>
                                <div class="cars">
                                    <div class="vaksin-item" data-vaksin="polio">
                                        <div class="vaksin-name">Vaksin polio</div>
                                        <input type="checkbox" name="vaksin[]" value="polio" hidden>
                                    </div>
                                    <div class="vaksin-item" data-vaksin="meningtis">
                                        <div class="vaksin-name">Vaksin Meningtis</div>
                                        <input type="checkbox" name="vaksin[]" value="meningtis" hidden>
                                    </div>
                                </div>
                                <div id="polio" class="hidden">
                                    <h3>Form vaksin polio</h3>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="nama_hotel[]"
                                                placeholder="Nama hotel">
                                        </div>
                                    </div>

                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga per item</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-door-closed"></i></span>
                                            <input type="text" class="form-control" name="tipe_kamar[]"
                                                placeholder="Tipe kamar">
                                        </div>
                                    </div>

                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-grid"></i></span>
                                            <input type="number" class="form-control" name="jumlah_kamar[]"
                                                placeholder="Jumlah kamar">
                                        </div>
                                    </div>
                                </div>
                                <div id="meningtis" class="hidden">
                                    <h3>Form vaksin meningtis</h3>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Jumlah</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="nama_hotel[]"
                                                placeholder="Nama hotel">
                                        </div>
                                    </div>

                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Harga per item</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-door-closed"></i></span>
                                            <input type="text" class="form-control" name="tipe_kamar[]"
                                                placeholder="Tipe kamar">
                                        </div>
                                    </div>

                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-grid"></i></span>
                                            <input type="number" class="form-control" name="jumlah_kamar[]"
                                                placeholder="Jumlah kamar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden" data-document="sikopatur" id="sikopatur-details">
                                <label class="form-label">Sikopatur</label>
                                <div class="col-5 mt-3">
                                    <label class="form-label fw-semibold">Jumlah</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                        <input type="text" class="form-control" name="nama_hotel[]"
                                            placeholder="Nama hotel">
                                    </div>
                                </div>

                                <!-- Type Kamar -->
                                <div class="col-5 mt-3">
                                    <label class="form-label fw-semibold">Harga per item</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-door-closed"></i></span>
                                        <input type="text" class="form-control" name="tipe_kamar[]"
                                            placeholder="Tipe kamar">
                                    </div>
                                </div>

                                <!-- Jumlah Kamar -->
                                <div class="col-5 mt-3">
                                    <label class="form-label fw-semibold">Keterangan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-grid"></i></span>
                                        <input type="number" class="form-control" name="jumlah_kamar[]"
                                            placeholder="Jumlah kamar">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Handling -->
                        <div class="detail-form {{ in_array('handling', $selectedServices) ? '' : 'hidden' }}" id="handling-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Handling
                            </h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <!-- Handling Hotel -->
                                    <div class="document-item" data-handling="hotel">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                                <path d="M6.5 0v1h-2v14h7V1h-2V0h-3zM5 2v12h6V2H5z" />
                                                <path d="M7 5h2v2H7V5zm0 3h2v2H7V8zm0 3h2v2H7v-2z" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" hidden>
                                    </div>

                                    <!-- Handling Bandara -->
                                    <div class="document-item" data-handling="bandara">
                                        <div class="service-icon">
                                            <i class="bi bi-airplane"></i>
                                        </div>
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
                            </div>

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
                                    <div class="form-group">
                                        <label class="form-label">Kedatangan Jamaah</label>
                                        <input type="date" class="form-control" name="kedatangan_jamaah_handling">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pendamping -->
                        <div class="detail-form {{ in_array('pendamping', $selectedServices) ? '' : 'hidden' }}" id="pendamping-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Pendamping
                            </h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="pendamping-wrapper">
                                        <div class="pendamping-item" data-pendamping="premium">
                                            <div class="service-icon"><i class="bi bi-prescription2"></i></div>
                                            <div class="service-name">Muthwif kelas premium</div>
                                            <div class="service-desc">Rp. 120.000.000</div>
                                            <input type="checkbox" name="pendamping[]" value="premium" hidden>
                                        </div>
                                        <div class="pendamping-form" id="form-premium">
                                            <label class="form-label">Jumlah Premium</label>
                                            <input type="number" class="form-control" name="jumlah_premium"
                                                min="1">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <textarea class="form-control" name="ket_premium"></textarea>
                                        </div>
                                    </div>

                                    <div class="pendamping-wrapper">
                                        <div class="pendamping-item" data-pendamping="standard">
                                            <div class="service-icon"><i class="bi bi-bus-front"></i></div>
                                            <div class="service-name">Muthwif kelas standard</div>
                                            <div class="service-desc">Rp. 80.000.000</div>
                                            <input type="checkbox" name="pendamping[]" value="standard" hidden>
                                        </div>
                                        <div class="pendamping-form" id="form-standard">
                                            <label class="form-label">Jumlah Standard</label>
                                            <input type="number" class="form-control" name="jumlah_standard"
                                                min="1">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <textarea class="form-control" name="ket_standard"></textarea>
                                        </div>
                                    </div>


                                    <div class="pendamping-wrapper">
                                        <div class="pendamping-item" data-pendamping="muthawifah">
                                            <div class="service-icon"><i class="bi bi-person-standing"></i></div>
                                            <div class="service-name">Muthwifah</div>
                                            <div class="service-desc">Rp. 70.000.000</div>
                                            <input type="checkbox" name="pendamping[]" value="muthawifah" hidden>
                                        </div>
                                        <div class="pendamping-form" id="form-muthawifah">
                                            <label class="form-label">Jumlah Muthawifah</label>
                                            <input type="number" class="form-control" name="jumlah_muthawifah"
                                                min="1">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <textarea class="form-control" name="ket_muthawifah"></textarea>
                                        </div>
                                    </div>

                                    <div class="pendamping-wrapper">
                                        <div class="pendamping-item" data-pendamping="leader">
                                            <div class="service-icon"><i class="bi bi-people"></i></div>
                                            <div class="service-name">Team Leader</div>
                                            <div class="service-desc">Rp. 100.000.000</div>
                                            <input type="checkbox" name="pendamping[]" value="leader" hidden>
                                        </div>
                                        <div class="pendamping-form" id="form-leader">
                                            <label class="form-label">Jumlah Leader</label>
                                            <input type="number" class="form-control" name="jumlah_leader"
                                                min="1">
                                            <label class="form-label mt-2">Keterangan</label>
                                            <textarea class="form-control" name="ket_leader"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- content -->
                        <div class="detail-form {{ in_array('konten', $selectedServices) ? '' : 'hidden' }}" id="konten-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Content
                            </h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="content-item" data-content="premium">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                                <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                                <path
                                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zm2 3v10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4zM3 3h10V1H3z" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Umrah</div>
                                        <div class="service-desc">Rp. 120.000.000</div>
                                        <input type="checkbox" name="content[]" value="premium" hidden>
                                    </div>

                                    <div class="content-item" data-content="standard">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Mekkah</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="content[]" value="standard" hidden>
                                    </div>

                                    <div class="content-item" data-content="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Madinah</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="muthawifah" hidden>
                                    </div>

                                    <div class="content-item" data-content="leader">
                                        <div class="service-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="service-name">Full content</div>
                                        <div class="service-desc">Rp. 100.000.000</div>
                                        <input type="checkbox" name="content[]" value="leader" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-form {{ in_array('reyal', $selectedServices) ? '' : 'hidden' }}" id="reyal-details">
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
                        <div class="detail-form {{ in_array('tour', $selectedServices) ? '' : 'hidden' }}" id="tour-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Tour
                            </h6>
                            <div class="detail-section">
                                <div class="tours">
                                    <label class="service-tour" data-tour="makkah">
                                        <div class="service-icon">
                                            <i class="bi bi-egg-fried"></i>
                                        </div>
                                        <div class="service-name">City tour</div>
                                        <div class="service-desc">Makkah</div>
                                        <input type="checkbox" name="tours[]" value="makkah" class="d-none">
                                    </label>

                                    <label class="service-tour" data-tour="madinah">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">City tour</div>
                                        <div class="service-desc">Madinah</div>
                                        <input type="checkbox" name="tours[]" value="madinah" class="d-none">
                                    </label>

                                    <label class="service-tour" data-tour="alula">
                                        <div class="service-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="service-name">City tour</div>
                                        <div class="service-desc">Al Ula</div>
                                        <input type="checkbox" name="tours[]" value="al ula" class="d-none">
                                    </label>

                                    <label class="service-tour" data-tour="thoif">
                                        <div class="service-icon">
                                            <i class="bi bi-map"></i>
                                        </div>
                                        <div class="service-name">City Tour</div>
                                        <div class="service-desc">Thoif</div>
                                        <input type="checkbox" name="tours[]" value="thoif" class="d-none">
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div id="tour-makkah-form" class="tour-form hidden">
                            <h4>Transportasi Makkah</h4>
                            <div class="makkah-tour">
                                @foreach ($transportations as $trans)
                                    <label class="service-tour-makkah">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas : {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas : {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga : {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_makkah" value="{{ $trans->id }}"
                                            class="d-none">
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="tour-madinah-form" class="hidden tour-form">
                            <h3>Form Tour Madinah</h3>
                            <div class="madinah-tour">
                                @foreach ($transportations as $trans)
                                    <label class="service-tour-makkah">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas : {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas : {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga : {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_madinah" value="{{ $trans->id }}"
                                            class="d-none">
                                    </label>
                                @endforeach

                            </div>
                        </div>
                        <div id="tour-alula-form" class="hidden tour-form">
                            <h3>Form Tour Al Ula</h3>
                            <div class="al-ula-tour">
                                @foreach ($transportations as $trans)
                                    <label class="service-tour-makkah">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas : {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas : {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga : {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_al-ula" value="{{ $trans->id }}"
                                            class="d-none">
                                    </label>
                                @endforeach

                            </div>
                        </div>
                        <div id="tour-thoif-form" class="hidden tour-form">
                            <h3>Form Tour Thoif</h3>
                            <div class="thoif">
                                @foreach ($transportations as $trans)
                                    <label class="service-tour-makkah">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas : {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas : {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga : {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_thoif" value="{{ $trans->id }}"
                                            class="d-none">
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="detail-form {{ in_array('meals', $selectedServices) ? '' : 'hidden' }}" id="meals-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Makanan
                            </h6>
                            <div class="service-grid">
                                <div class="content-item" data-content="premium">
                                    <div class="service-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                            <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                            <path
                                                d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zM2 3h10V1H3z" />
                                        </svg>
                                    </div>
                                    <div class="service-name">Nasi Box</div>
                                    <div class="service-desc">Rp. 120.000.000</div>
                                    <input type="checkbox" name="meals[]" value="nasi box" hidden>
                                </div>

                                <div class="content-item" data-content="standard">
                                    <div class="service-icon">
                                        <i class="bi bi-bus-front"></i>
                                    </div>
                                    <div class="service-name">Buffle Hotel</div>
                                    <div class="service-desc">Rp. 80.000.000</div>
                                    <input type="checkbox" name="meals[]" value="Buffle Hotel" hidden>
                                </div>

                                <div class="content-item" data-content="muthawifah">
                                    <div class="service-icon">
                                        <i class="bi bi-person-standing"></i>
                                    </div>
                                    <div class="service-name">Snack</div>
                                    <div class="service-desc">Rp. 70.000.000</div>
                                    <input type="checkbox" name="meals[]" value="snack" hidden>
                                </div>
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
                        <div class="detail-form {{ in_array('dorongan', $selectedServices) ? '' : 'hidden' }}" id="dorongan-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Dorongan
                            </h6>
                            <div class="service-grid">
                                <div class="content-item" data-content="umrah">
                                    <div class="service-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                            <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                            <path
                                                d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zM2 3h10V1H3z" />
                                        </svg>
                                    </div>
                                    <div class="service-name">Umrah</div>
                                    <div class="service-desc">Rp. 120.000.000</div>
                                    <input type="checkbox" name="content[]" value="umrah" hidden>
                                </div>

                                <div class="content-item" data-content="makkah">
                                    <div class="service-icon">
                                        <i class="bi bi-bus-front"></i>
                                    </div>
                                    <div class="service-name">Makkah</div>
                                    <div class="service-desc">Rp. 80.000.000</div>
                                    <input type="checkbox" name="content[]" value="makkah" hidden>
                                </div>

                                <div class="content-item" data-content="tawaf">
                                    <div class="service-icon">
                                        <i class="bi bi-person-standing"></i>
                                    </div>
                                    <div class="service-name">Tawaf</div>
                                    <div class="service-desc">Rp. 70.000.000</div>
                                    <input type="checkbox" name="content[]" value="tawaf" hidden>
                                </div>

                                <div class="content-item" data-content="dorongan-sel">
                                    <div class="service-icon">
                                        <i class="bi bi-person-standing"></i>
                                    </div>
                                    <div class="service-name">Dorongan sel</div>
                                    <div class="service-desc">Rp. 70.000.000</div>
                                    <input type="checkbox" name="content[]" value="dorongan-sel" hidden>
                                </div>
                            </div>
                        </div>

                        <div id="umrah-form" class="form-group hidden">
                            <label class="form-label">Jumlah Umrah</label>
                            <input type="text" class="form-control" name="jumlah_umrah">
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
                        <div class="detail-form {{ in_array('wakaf', $selectedServices) ? '' : 'hidden' }}" id="waqaf-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Wakaf
                            </h6>
                            <div class="service-grid">
                                <div class="content-item" data-content="berbagi-air">
                                    <div class="service-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                            <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                            <path
                                                d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zM2 3h10V1H3z" />
                                        </svg>
                                    </div>
                                    <div class="service-name">Berbagi Air</div>
                                    <input type="checkbox" name="content[]" value="berbagi-air" hidden>
                                </div>

                                <div class="content-item" data-content="berbagi-nasi">
                                    <div class="service-icon">
                                        <i class="bi bi-bus-front"></i>
                                    </div>
                                    <div class="service-name">Berbagi nasi kotak</div>
                                    <div class="service-desc">Rp. 80.000.000</div>
                                    <input type="checkbox" name="content[]" value="berbagi-nasi" hidden>
                                </div>

                                <div class="content-item" data-content="mushaf">
                                    <div class="service-icon">
                                        <i class="bi bi-person-standing"></i>
                                    </div>
                                    <div class="service-name">Mushaf al quran</div>
                                    <div class="service-desc">Rp. 70.000.000</div>
                                    <input type="checkbox" name="content[]" value="mushaf" hidden>
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
                        <div class="detail-form {{ in_array('badal', $selectedServices) ? '' : 'hidden' }}" id="badal-details">
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
                    </div>


                    <!-- Tambahkan detail untuk divisi lainnya di sini -->

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
            const visaItem = document.querySelectorAll('.visa-item');
            visaItem.forEach(visa => {
                visa.classList.toggle('selected');
                const checkbox = visa.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;

            })
            const vaccineItem = document.querySelectorAll('.vaksin-item');
            vaccineItem.forEach(vaccine => {
                vaccine.classList.toggle('selected');
                const checkbox = vaccine.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
            })

            const documentItems = document.querySelectorAll("#document-item")
            documentItems.forEach(doc => {
                doc.addEventListener("click", function() {
                    doc.classList.toggle("selected")
                    const checkboxDocument = doc.querySelector("input[type='checkbox']")
                    checkboxDocument.checked = !checkboxDocument.checked

                    const documentType = doc.getAttribute("data-document");
                    const detailFormDocument = document.getElementById(`${documentType}-details`)
                    if (detailFormDocument) {
                        detailFormDocument.style.display = checkboxDocument.checked ? 'none' :
                            'block'
                    }
                })
            })

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

            const serviceCars = document.querySelectorAll('.service-car');
            serviceCars.forEach(car => {
                car.addEventListener('click', () => {
                    serviceCars.forEach(c => c.classList.remove('selected'));
                    car.classList.add('selected');
                    const radio = car.querySelector('input[type="radio"]');
                    radio.checked = true;
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




            const contentItem = document.querySelectorAll(".content-item");
            contentItem.forEach(content => {
                content.addEventListener("click", () => {
                    contentItem.forEach(con => con.classList.remove('selected'));
                    content.classList.add('selected')
                    const checkboxContent = content.querySelector('input[type="checkbox"]');
                    checkboxContent.checked = true;
                })
            })

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


        // HANDLE HANDLING ITEMS
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

        // SET DEFAULT STATE PAS PAGE LOAD
        handlings.forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const handlingType = item.getAttribute("data-handling").toLowerCase();
            const target = document.getElementById(handlingType);

            if (target) {
                target.style.display = checkbox.checked ? "block" : "none";
            }
        });
        document.querySelectorAll('#pendamping-details .document-item').forEach(item => {
            item.addEventListener('click', () => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                item.classList.toggle('active', checkbox.checked);
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



        const addHotelBtn = document.getElementById("addHotel");
        const hotelWrapper = document.getElementById("hotelWrapper");

        // tambah hotel
        addHotelBtn.addEventListener("click", function() {
            const newHotel = hotelWrapper.firstElementChild.cloneNode(true);

            // reset input value
            newHotel.querySelectorAll("input").forEach(input => input.value = "");

            hotelWrapper.appendChild(newHotel);
        });

        // hapus hotel
        hotelWrapper.addEventListener("click", function(e) {
            if (e.target.classList.contains("removeHotel")) {
                if (hotelWrapper.children.length > 1) {
                    e.target.closest(".hotel-form").remove();
                } else {
                    alert("Minimal harus ada 1 form hotel!");
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


        document.querySelectorAll('.service-visa-item').forEach(car => {
            car.addEventListener('click', function() {
                // hapus active di semua
                document.querySelectorAll('.service-visa-item').forEach(el => el.classList.remove(
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
                item.classList.toggle('active');

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
        const mealItems = document.querySelectorAll('.content-item');
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
        const doronganItems = document.querySelectorAll('#dorongan-details .content-item');
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
        const waqafItems = document.querySelectorAll('#waqaf-details .content-item');
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
    </script>
@endsection
