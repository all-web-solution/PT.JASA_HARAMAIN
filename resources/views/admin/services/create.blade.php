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
        .content-item
        {
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
        .content-item:hover
         {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-item.selected,
        .transport-item.selected,
        .service-car.selected,
        .document-item.selected,
        .content-item.selected
        {
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
        #waqaf-details{
            display: none;
            margin-top: 20px;
        }

        .cars {
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
                <form action="{{ route('services.store') }}" method="POST">
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
                                    <select class="form-control" name="travel_id" id="travel-select">
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
                                    <input type="text" class="form-control" name="contact_person" readonly required
                                        id="penanggung">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required id="email">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" name="phone" required id="phone">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="departure_date" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="return_date" required>
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
                                <input type="checkbox" name="services[]" value="transportasi" checked hidden>
                            </div>

                            <div class="service-item" data-service="hotel">
                                <div class="service-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="service-name">Hotel</div>
                                <div class="service-desc">Akomodasi</div>
                                <input type="checkbox" name="services[]" value="hotel" checked hidden>
                            </div>

                            <div class="service-item" data-service="dokumen">
                                <div class="service-icon">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="service-name">Dokumen</div>
                                <div class="service-desc">Visa & Administrasi</div>
                                <input type="checkbox" name="services[]" value="dokumen" checked hidden>
                            </div>

                            <div class="service-item" data-service="handling">
                                <div class="service-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div class="service-name">Handling</div>
                                <div class="service-desc">Bandara & Hotel</div>
                                <input type="checkbox" name="services[]" value="handling" checked hidden>
                            </div>

                            <div class="service-item" data-service="pendamping">
                                <div class="service-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="service-name">Pendamping</div>
                                <div class="service-desc">Tour Leader & Mutawwif</div>
                                <input type="checkbox" name="services[]" value="pendamping" checked hidden>
                            </div>

                            <div class="service-item" data-service="konten">
                                <div class="service-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <div class="service-name">Konten</div>
                                <div class="service-desc">Dokumentasi</div>
                                <input type="checkbox" name="services[]" value="konten" checked hidden>
                            </div>

                            <div class="service-item" data-service="reyal">
                                <div class="service-icon">
                                    <i class="bi bi-currency-exchange"></i>
                                </div>
                                <div class="service-name">Reyal</div>
                                <div class="service-desc">Penukaran Mata Uang</div>
                                <input type="checkbox" name="services[]" value="reyal" checked hidden>
                            </div>

                            <div class="service-item" data-service="tour">
                                <div class="service-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="service-name">Tour</div>
                                <div class="service-desc">City Tour & Ziarah</div>
                                <input type="checkbox" name="services[]" value="tour" checked hidden>
                            </div>

                            <div class="service-item" data-service="meals">
                                <div class="service-icon">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                                <div class="service-name">Meals</div>
                                <div class="service-desc">Makanan</div>
                                <input type="checkbox" name="services[]" value="meals" checked hidden>
                            </div>

                            <div class="service-item" data-service="dorongan">
                                <div class="service-icon">
                                    <i class="bi bi-basket"></i>
                                </div>
                                <div class="service-name">Dorongan</div>
                                <div class="service-desc">Bagi penyandang disabilitas</div>
                                <input type="checkbox" name="services[]" value="dorongan" checked hidden>
                            </div>

                            <div class="service-item" data-service="waqaf">
                                <div class="service-icon">
                                    <i class="bi bi-gift"></i>
                                </div>
                                <div class="service-name">Waqaf</div>
                                <div class="service-desc">Sedekah & Waqaf</div>
                                <input type="checkbox" name="services[]" value="waqaf" checked hidden>
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
                                        <div class="service-icon">
                                            <i class="bi bi-airplane"></i>
                                        </div>
                                        <div class="service-name">Pesawat</div>
                                        <div class="service-desc">Tiket Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" checked hidden>
                                    </div>

                                    <div class="transport-item" data-transportasi="bus">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Bus</div>
                                        <div class="service-desc">Bus Transportasi</div>
                                        <input type="checkbox" name="transportation[]" value="bus" checked hidden>
                                    </div>
                                </div>
                                <div class="form-group" data-transportasi="airplane" id="pesawat">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <div id="plane-wrapper">
                                        <div class="d-flex gap-2 mb-2">
                                            <select name="plane[]" class="form-control">
                                                <option value="" disabled selected>Pilih Tiket Pesawat</option>
                                                <option value="jakarta-jeddah">Jakarta - Jeddah (transit Malaysia),
                                                    tanggalnya, maskapai</option>
                                                <option value="surabaya-jeddah">Surabaya - Jeddah (transit Malaysia),
                                                    tanggalnya, maskapai</option>
                                                <option value="medan-jeddah">Medan - Jeddah (transit Malaysia), tanggalnya,
                                                    maskapai</option>
                                                <option value="bali-jeddah">Bali - Jeddah (transit Malaysia), tanggalnya,
                                                    maskapai</option>
                                                <option value="makassar-jeddah">Makassar - Jeddah (transit Malaysia),
                                                    tanggalnya, maskapai</option>
                                            </select>
                                            <button type="button" class="btn btn-primary add-plane">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-plus-circle-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" data-transportasi="bus" id="bis">
                                    <label class="form-label">Bus</label>
                                    <div class="cars">
                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-egg-fried"></i>
                                            </div>
                                            <div class="service-name">Meals</div>
                                            <div class="service-desc">Makanan</div>
                                            <input type="radio" name="services" value="meals" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-bus-front"></i>
                                            </div>
                                            <div class="service-name">Transport</div>
                                            <div class="service-desc">Transportasi</div>
                                            <input type="radio" name="services" value="transport" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <div class="service-name">Hotel</div>
                                            <div class="service-desc">Penginapan</div>
                                            <input type="radio" name="services" value="hotel" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-map"></i>
                                            </div>
                                            <div class="service-name">Tour</div>
                                            <div class="service-desc">Wisata</div>
                                            <input type="radio" name="services" value="tour" class="d-none">
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Hotel -->
                        <div class="detail-form" id="hotel-details">
                            <h6 class="detail-title">
                                <i class="bi bi-building"></i> Hotel
                            </h6>

                            <div class="detail-section">
                                <div class="form-group">
                                    <label class="form-label">Makkah</label>
                                    <select name="makkah_hotel" id="" class="form-control">
                                        <option value="" disabled selected>Pilih Hotel</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Madinah</label>
                                    <select name="" id="madinah_hotel" class="form-control">
                                        <option value="" disabled selected>Pilih Hotel</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                        <option value="jakarta-jeddah">Checkin : 10 januari, Checkout : 17 januari, type :
                                            4 quad + 1 queen, Bintang : 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <div class="detail-form" id="dokumen-details">
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
                                <div class="visas">
                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-egg-fried"></i>
                                        </div>
                                        <div class="service-name">Meals</div>
                                        <div class="service-desc">Makanan</div>
                                        <input type="radio" name="services" value="meals" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Transport</div>
                                        <div class="service-desc">Transportasi</div>
                                        <input type="radio" name="services" value="transport" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="service-name">Hotel</div>
                                        <div class="service-desc">Penginapan</div>
                                        <input type="radio" name="services" value="hotel" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-map"></i>
                                        </div>
                                        <div class="service-name">Tour</div>
                                        <div class="service-desc">Wisata</div>
                                        <input type="radio" name="services" value="tour" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group hidden" data-document="vaksin" id="vaksin-details">
                                <label class="form-label">Vaksin</label>
                                <div class="visas">
                                    <label class="service-car">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-passport-fill" viewBox="0 0 16 16">
                                                <path d="M8 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                                <path
                                                    d="M2 3.252a1.5 1.5 0 0 1 1.232-1.476l8-1.454A1.5 1.5 0 0 1 13 1.797v.47A2 2 0 0 1 14 4v10a2 2 0 0 1-2 2H4a2 2 0 0 1-1.51-.688 1.5 1.5 0 0 1-.49-1.11V3.253ZM5 8a3 3 0 1 0 6 0 3 3 0 0 0-6 0m0 4.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Meals</div>
                                        <div class="service-desc">Makanan</div>
                                        <input type="radio" name="services" value="vaksin" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Transport</div>
                                        <div class="service-desc">Transportasi</div>
                                        <input type="radio" name="services" value="transport" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="service-name">Hotel</div>
                                        <div class="service-desc">Penginapan</div>
                                        <input type="radio" name="services" value="hotel" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-map"></i>
                                        </div>
                                        <div class="service-name">Tour</div>
                                        <div class="service-desc">Wisata</div>
                                        <input type="radio" name="services" value="tour" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group hidden" data-document="sikopatur" id="sikopatur-details">
                                <label class="form-label">Sikopatur</label>
                                <div class="visas">
                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-egg-fried"></i>
                                        </div>
                                        <div class="service-name">Meals</div>
                                        <div class="service-desc">Makanan</div>
                                        <input type="radio" name="services" value="meals" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Transport</div>
                                        <div class="service-desc">Transportasi</div>
                                        <input type="radio" name="services" value="transport" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="service-name">Hotel</div>
                                        <div class="service-desc">Penginapan</div>
                                        <input type="radio" name="services" value="hotel" class="d-none">
                                    </label>

                                    <label class="service-car">
                                        <div class="service-icon">
                                            <i class="bi bi-map"></i>
                                        </div>
                                        <div class="service-name">Tour</div>
                                        <div class="service-desc">Wisata</div>
                                        <input type="radio" name="services" value="tour" class="d-none">
                                    </label>
                                </div>
                            </div>
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
                                        <input type="text" class="form-control" name="nama_hotel">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_hotel">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label class="form-label">Harga</label>
                                        <input type="text" class="form-control" name="harga_hotel">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label class="form-label">Pax</label>
                                        <input type="text" class="form-control" name="pax_hotel">
                                    </div>
                                </div>
                            </div>

                            <!-- Form Bandara -->
                            <div class="form-group" data-handling="bandara" id="bandara" style="display: none;">
                                <label class="form-label">Bandara</label>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label class="form-label">Nama Bandara</label>
                                        <input type="text" class="form-control" name="nama_bandara">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Jumlah Jamaah</label>
                                        <input type="text" class="form-control" name="jumlah_jamaah">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Harga</label>
                                        <input type="text" class="form-control" name="harga_bandara">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kedatangan Jamaah</label>
                                        <input type="date" class="form-control" name="kedatangan_jamaah">
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
                                    <div class="content-item" data-pendamping="premium">
                                        <div class="service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                                <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                                <path
                                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zm2 3v10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4zM3 3h10V1H3z" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Muthwif kelas premium</div>
                                        <div class="service-desc">Rp. 120.000.000</div>
                                        <input type="checkbox" name="pendamping[]" value="premium" hidden>
                                    </div>

                                    <div class="content-item" data-pendamping="standard">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Muthwif kelas standard</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="pendamping[]" value="standard" hidden>
                                    </div>

                                    <div class="content-item" data-pendamping="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Muthwifah</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="pendamping[]" value="muthawifah" hidden>
                                    </div>

                                    <div class="content-item" data-pendamping="leader">
                                        <div class="service-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="service-name">Team Leader</div>
                                        <div class="service-desc">Rp. 100.000.000</div>
                                        <input type="checkbox" name="pendamping[]" value="leader" hidden>
                                    </div>
                                </div>

                                <!-- Form Jumlah -->
                                <div class="form-group" style="margin-top:15px;">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah_pendamping" min="1">
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
                                <div class="cars">
                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-egg-fried"></i>
                                            </div>
                                            <div class="service-name">City tour</div>
                                            <div class="service-desc">Makkah</div>
                                            <input type="radio" name="services" value="meals" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-bus-front"></i>
                                            </div>
                                            <div class="service-name">City tour</div>
                                            <div class="service-desc">Madinah</div>
                                            <input type="radio" name="services" value="transport" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <div class="service-name">City tour</div>
                                            <div class="service-desc">Al Ula</div>
                                            <input type="radio" name="services" value="hotel" class="d-none">
                                        </label>

                                        <label class="service-car">
                                            <div class="service-icon">
                                                <i class="bi bi-map"></i>
                                            </div>
                                            <div class="service-name">City Tour</div>
                                            <div class="service-desc">Thoif</div>
                                            <input type="radio" name="services" value="tour" class="d-none">
                                        </label>
                                    </div>
                            </div>
                         </div>
                         <div class="detail-form" id="meals-details">
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
                                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zm2 3v10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4zM3 3h10V1H3z" />
                                            </svg>
                                        </div>
                                        <div class="service-name">Nasi Box</div>
                                        <div class="service-desc">Rp. 120.000.000</div>
                                        <input type="checkbox" name="content[]" value="premium" hidden>
                                    </div>

                                    <div class="content-item" data-content="standard">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Buffle Hotel</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="content[]" value="standard" hidden>
                                    </div>

                                    <div class="content-item" data-content="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Snack</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="muthawifah" hidden>
                                    </div>


                                </div>
                         </div>
                         <div class="detail-form" id="dorongan-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Dorongan
                            </h6>
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
                                        <div class="service-name">Umrah </div>
                                        <div class="service-desc">Rp. 120.000.000</div>
                                        <input type="checkbox" name="content[]" value="premium" hidden>
                                    </div>

                                    <div class="content-item" data-content="standard">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Makkah</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="content[]" value="standard" hidden>
                                    </div>

                                    <div class="content-item" data-content="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Tawaf</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="muthawifah" hidden>
                                    </div>
                                    <div class="content-item" data-content="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Dorongan sel</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="muthawifah" hidden>
                                    </div>


                                </div>
                         </div>
                         <div class="detail-form" id="waqaf-details">
                            <h6 class="detail-title">
                                <i class="bi bi-briefcase"></i> Wakaf
                            </h6>
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
                                        <div class="service-name">Berbagi Air</div>
                                        <input type="checkbox" name="content[]" value="premium" hidden>
                                    </div>

                                    <div class="content-item" data-content="standard">
                                        <div class="service-icon">
                                            <i class="bi bi-bus-front"></i>
                                        </div>
                                        <div class="service-name">Berbagi nasi kotak</div>
                                        <div class="service-desc">Rp. 80.000.000</div>
                                        <input type="checkbox" name="content[]" value="standard" hidden>
                                    </div>

                                    <div class="content-item" data-content="muthawifah">
                                        <div class="service-icon">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="service-name">Mushaf al quran</div>
                                        <div class="service-desc">Rp. 70.000.000</div>
                                        <input type="checkbox" name="content[]" value="muthawifah" hidden>
                                    </div>

                                </div>


                                </div>
                         </div>


                        <!-- Tambahkan detail untuk divisi lainnya di sini -->

                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check-circle"></i> Simpan Permintaan
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
                        detailForm.style.display = checkbox.checked ? 'none' : 'block';
                    }

                    console.log(serviceType);

                });
            });

            const documentItems = document.querySelectorAll("#document-item")
            documentItems.forEach(doc => {
                doc.addEventListener("click", function(){
                    doc.classList.toggle("selected")
                    const checkboxDocument = doc.querySelector("input[type='checkbox']")
                    checkboxDocument.checked = !checkboxDocument.checked

                    const documentType = doc.getAttribute("data-document");
                    const detailFormDocument = document.getElementById(`${documentType}-details`)
                    if(detailFormDocument){
                        detailFormDocument.style.display = checkboxDocument.checked ? 'none' : 'block'
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
                            'none' : 'block';
                    } else if (transportType === 'bus') {
                        document.getElementById('bis').style.display = checkbox.checked ? 'none' :
                            'block';
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
            const contentItem = document.querySelectorAll(".content-item");
            contentItem.forEach(content =>{
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
    </script>
@endsection
