@extends('admin.master')
@section('content')
<style>
    /* CSS Anda */
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
    .service-tour-thoif:hover {
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
        display: none !important;
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

    .meal-item,
    .content-item,
    .dorongan-item,
    .wakaf-item {
        background-color: #fff;
        margin: 10px 0px;
        padding: 10px;
        border-radius: 7px;

    }

    .wakaf-item {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }

    .wakaf-item.active {
        background-color: #e6f0fa;
        border-color: #1a4b8c;
    }
</style>

<div class="service-create-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title" id="text-title">
                <i class="bi bi-plus-circle"></i>Tambah Permintaan Service Baru
            </h5>
            <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("put")
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
                                                data-email="{{ $pelanggan->email }}"
                                                data-telepon="{{ $pelanggan->phone }}"
                                                @if($pelanggan->id === $service->pelanggan->id)
                                                    selected
                                                @endif>
                                            {{ $pelanggan->nama_travel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Penanggung Jawab</label>
                                <input type="text" class="form-control" readonly required id="penanggung" value="{{ $service->pelanggan->penanggung_jawab }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required id="email" value="{{ $service->pelanggan->email }}">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <input type="tel" class="form-control" required id="phone" value="{{ $service->pelanggan->phone }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Keberangkatan</label>
                                <input type="date" class="form-control" name="tanggal_keberangkatan" required value="{{$service->tanggal_keberangkatan}}">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Kepulangan</label>
                                <input type="date" class="form-control" name="tanggal_kepulangan" required value="{{$service->tanggal_kepulangan}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Jamaah</label>
                        <input type="text" class="form-control" name="total_jamaah" min="1" required value="{{$service->total_jamaah}}">
                    </div>
                </div>

                @php
                    $selectedServices = $service->services ?? [];
                    // Fetch existing related data
                    $existingHotels = $service->hotels;
                    $existingPlanes = $service->planes;
                    $existingTransports = $service->transportationItem;
                    $existingHandlings = $service->handlings;
                    $existingMeals = $service->meals;
                    $existingGuides = $service->guides;
                    $existingTours = $service->tours;
                    $existingDocuments = $service->documents;
                    $existingReyal = $service->reyals;
                    $existingWakaf = $service->wakafs;
                    $existingDorongans = $service->dorongans;
                    $existingContents = $service->contents;
                    $existingBadals = $service->badals;
                @endphp
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                    </h6>
                    <div class="service-grid">
                        <div class="service-item {{ in_array('transportasi', $selectedServices) ? 'selected' : '' }}" data-service="transportasi">
                            <div class="service-icon"><i class="bi bi-airplane"></i></div>
                            <div class="service-name">Transportasi</div>
                            <div class="service-desc">Tiket & Transport</div>
                            <input type="checkbox" name="services[]" value="transportasi" hidden {{ in_array('transportasi', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('hotel', $selectedServices) ? 'selected' : '' }}" data-service="hotel">
                            <div class="service-icon"><i class="bi bi-building"></i></div>
                            <div class="service-name">Hotel</div>
                            <div class="service-desc">Akomodasi</div>
                            <input type="checkbox" name="services[]" value="hotel" hidden {{ in_array('hotel', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('dokumen', $selectedServices) ? 'selected' : '' }}" data-service="dokumen">
                            <div class="service-icon"><i class="bi bi-file-text"></i></div>
                            <div class="service-name">Dokumen</div>
                            <div class="service-desc">Visa & Administrasi</div>
                            <input type="checkbox" name="services[]" value="dokumen" hidden {{ in_array('dokumen', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('handling', $selectedServices) ? 'selected' : '' }}" data-service="handling">
                            <div class="service-icon"><i class="bi bi-briefcase"></i></div>
                            <div class="service-name">Handling</div>
                            <div class="service-desc">Bandara & Hotel</div>
                            <input type="checkbox" name="services[]" value="handling" hidden {{ in_array('handling', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('pendamping', $selectedServices) ? 'selected' : '' }}" data-service="pendamping">
                            <div class="service-icon"><i class="bi bi-people"></i></div>
                            <div class="service-name">Pendamping</div>
                            <div class="service-desc">Tour Leader & Mutawwif</div>
                            <input type="checkbox" name="services[]" value="pendamping" hidden {{ in_array('pendamping', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('konten', $selectedServices) ? 'selected' : '' }}" data-service="konten">
                            <div class="service-icon"><i class="bi bi-camera"></i></div>
                            <div class="service-name">Konten</div>
                            <div class="service-desc">Dokumentasi</div>
                            <input type="checkbox" name="services[]" value="konten" hidden {{ in_array('konten', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('reyal', $selectedServices) ? 'selected' : '' }}" data-service="reyal">
                            <div class="service-icon"><i class="bi bi-currency-exchange"></i></div>
                            <div class="service-name">Reyal</div>
                            <div class="service-desc">Penukaran Mata Uang</div>
                            <input type="checkbox" name="services[]" value="reyal" hidden {{ in_array('reyal', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('tour', $selectedServices) ? 'selected' : '' }}" data-service="tour">
                            <div class="service-icon"><i class="bi bi-geo-alt"></i></div>
                            <div class="service-name">Tour</div>
                            <div class="service-desc">City Tour & Ziarah</div>
                            <input type="checkbox" name="services[]" value="tour" hidden {{ in_array('tour', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('meals', $selectedServices) ? 'selected' : '' }}" data-service="meals">
                            <div class="service-icon"><i class="bi bi-egg-fried"></i></div>
                            <div class="service-name">Meals</div>
                            <div class="service-desc">Makanan</div>
                            <input type="checkbox" name="services[]" value="meals" hidden {{ in_array('meals', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('dorongan', $selectedServices) ? 'selected' : '' }}" data-service="dorongan">
                            <div class="service-icon"><i class="bi bi-basket"></i></div>
                            <div class="service-name">Dorongan</div>
                            <div class="service-desc">Bagi penyandang disabilitas</div>
                            <input type="checkbox" name="services[]" value="dorongan" hidden {{ in_array('dorongan', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('wakaf', $selectedServices) ? 'selected' : '' }}" data-service="wakaf">
                            <div class="service-icon"><i class="bi bi-gift"></i></div>
                            <div class="service-name">Wakaf</div>
                            <div class="service-desc">Sedekah & Wakaf</div>
                            <input type="checkbox" name="services[]" value="wakaf" hidden {{ in_array('wakaf', $selectedServices) ? 'checked' : '' }}>
                        </div>
                        <div class="service-item {{ in_array('badal', $selectedServices) ? 'selected' : '' }}" data-service="badal">
                            <div class="service-icon"><i class="bi bi-gift"></i></div>
                            <div class="service-name">Badal Umrah</div>
                            <div class="service-desc">Layanan Badal Umrah</div>
                            <input type="checkbox" name="services[]" value="badal" hidden {{ in_array('badal', $selectedServices) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                    </h6>

                    <div class="detail-form {{ in_array('transportasi', $selectedServices) ? '' : 'hidden' }}" id="transportasi-details">
                        <h6 class="detail-title">
                            <i class="bi bi-airplane"></i> Transportasi
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                <div class="transport-item {{ !empty($existingPlanes->count()) ? 'selected' : '' }}" data-transportasi="airplane">
                                    <div class="service-name">Pesawat</div>
                                    <input type="checkbox" name="transportation[]" value="airplane" hidden {{ !empty($existingPlanes->count()) ? 'checked' : '' }}>
                                </div>
                                <div class="transport-item {{ !empty($existingTransports->count()) ? 'selected' : '' }}" data-transportasi="bus">
                                    <div class="service-name">Transportasi darat</div>
                                    <input type="checkbox" name="transportation[]" value="bus" hidden {{ !empty($existingTransports->count()) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="form-group {{ !empty($existingPlanes->count()) ? '' : 'hidden' }}" data-transportasi="airplane" id="pesawat">
                                <div class="flex justify-between mb-2">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary" id="addTicket">Tambah Tiket</button>
                                </div>
                                <div id="ticketWrapper">
                                    @forelse($existingPlanes as $plane)
                                    <div class="ticket-form bg-white p-3 border mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-5">
                                                <label class="form-label fw-semibold">Tanggal Keberangkatan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane"></i></span>
                                                    <input type="date" class="form-control" name="tanggal[]" value="{{ $plane->tanggal_keberangkatan }}">
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label fw-semibold">Rute</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane-fill"></i></span>
                                                    <input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED" value="{{ $plane->rute }}">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <label class="form-label fw-semibold">Maskapai</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane"></i></span>
                                                    <input type="text" class="form-control" name="maskapai[]" placeholder="Nama maskapai" value="{{ $plane->maskapai }}">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <label class="form-label fw-semibold">Keterangan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-info-circle"></i></span>
                                                    <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan" value="{{ $plane->keterangan }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Paspor</label>
                                                <input type="file" class="form-control" id="foto" name="paspor_tiket[]" accept="image/*">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengubah. Format: JPEG, PNG, JPG (Max: 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="ticket-form bg-white p-3 border mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-5">
                                                <label class="form-label fw-semibold">Tanggal Keberangkatan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane"></i></span>
                                                    <input type="date" class="form-control" name="tanggal[]">
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label fw-semibold">Rute</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane-fill"></i></span>
                                                    <input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <label class="form-label fw-semibold">Maskapai</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-airplane"></i></span>
                                                    <input type="text" class="form-control" name="maskapai[]" placeholder="Nama maskapai">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <label class="form-label fw-semibold">Keterangan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white"><i class="bi bi-info-circle"></i></span>
                                                    <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Paspor</label>
                                                <input type="file" class="form-control" id="foto" name="paspor_tiket[]" accept="image/*">
                                                <small class="text-muted">Format: JPEG, PNG, JPG (Max: 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="form-group {{ !empty($existingTransports->count()) ? '' : 'hidden' }}" data-transportasi="bus" id="bis">
                                <label class="form-label">Transportasi darat</label>
                                <button type="button" class="btn btn-submit" id="add-transport-btn">Tambah Transportasi</button>
                                <div id="new-transport-forms">
                                    @forelse($existingTransports as $transport)
                                    <div class="transport-set">
                                        <div class="cars mt-3">
                                            @foreach ($transportations as $i => $data)
                                            <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}" data-id="{{ $data->id }}" data-routes='@json($data->routes)'>
                                                <div class="service-name">{{ $data->nama }}</div>
                                                <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                <div class="service-desc">Rp. {{ number_format($data->harga) }}/hari</div>
                                                <input type="radio" name="transportation_id[]" value="{{ $data->id }}" class="d-none" {{ $data->id == $transport->transportation_id ? 'checked' : '' }}>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="route-select {{ $transport->route_id ? '' : 'hidden' }}" id="route-select">
                                            <label class="form-label mt-2">Pilih Rute:</label>
                                            <select name="rute_id[]" class="form-control">
                                                @if($transport->route_id)
                                                <option value="{{ $transport->route_id }}" selected>{{ $transport->route->route }} - Rp. {{ number_format($transport->route->price) }}</option>
                                                @else
                                                <option value="">-- Pilih Rute --</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mt-2 text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="transport-set">
                                        <div class="cars mt-3">
                                            @foreach ($transportations as $i => $data)
                                            <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)'>
                                                <div class="service-name">{{ $data->nama }}</div>
                                                <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                <div class="service-desc">Rp. {{ number_format($data->harga) }}/hari</div>
                                                <input type="radio" name="transportation_id[]" value="{{ $data->id }}" class="d-none">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="route-select hidden" id="route-select">
                                            <label class="form-label mt-2">Pilih Rute:</label>
                                            <select name="rute_id[]" class="form-control">
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

                    <div class="detail-form {{ in_array('hotel', $selectedServices) ? '' : 'hidden' }}" id="hotel-details">
                        <h6 class="detail-title">
                            <i class="bi bi-building"></i> Hotel
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary mb-2" id="addHotel">Tambah Hotel</button>
                        <div id="hotelWrapper">
                            @forelse($existingHotels as $hotel)
                            <div class="hotel-form bg-white p-3 border mb-3">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkin</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-check"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkin[]" value="{{ $hotel->tanggal_checkin }}">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkout</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-x"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkout[]" value="{{ $hotel->tanggal_checkout }}">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Nama Hotel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel" value="{{ $hotel->nama_hotel }}">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-semibold">Tipe Kamar</label>
                                        <div class="service-grid">
                                            @foreach ($types as $tIndex => $type)
                                                <div class="type-item {{ $type->nama_tipe == $hotel->type ? 'selected' : '' }}" data-type="kuint">
                                                    <div class="service-name">{{ $type->nama_tipe }}</div>
                                                    <div class="service-desc">Rp. {{ number_format($type->jumlah, 0, ',', '.') }}</div>
                                                    <input type="checkbox" name="tipe_kamar[]" value="{{ $type->nama_tipe }}" {{ $type->nama_tipe == $hotel->type ? 'checked' : '' }}>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group" data-type="kuint">
                                        <div id="ticketWrapper">
                                            <div class="ticket-form bg-white p-3 mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-5">
                                                        <label class="form-label fw-semibold">Jumlah</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="jumlah_kamar[]" value="{{ $hotel->jumlah_type }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]" placeholder="Catatan tambahan" value="{{ $hotel->catatan }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button>
                                </div>
                            </div>
                            @empty
                            <div class="hotel-form bg-white p-3 border mb-3">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkin</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-check"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkin[]">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label fw-semibold">Tanggal Checkout</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-x"></i></span>
                                            <input type="date" class="form-control" name="tanggal_checkout[]">
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Nama Hotel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control" name="nama_hotel[]" placeholder="Nama hotel">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-semibold">Tipe Kamar</label>
                                        <div class="service-grid">
                                            @foreach ($types as $tIndex => $type)
                                                <div class="type-item" data-type="kuint">
                                                    <div class="service-name">{{ $type->nama_tipe }}</div>
                                                    <div class="service-desc">Rp. {{ number_format($type->jumlah, 0, ',', '.') }}</div>
                                                    <input type="checkbox" name="tipe_kamar[]" value="{{ $type->nama_tipe }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group" data-type="kuint">
                                            <div id="ticketWrapper">
                                                <div class="ticket-form bg-white p-3 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            <label class="form-label fw-semibold">Jumlah</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="jumlah_kamar[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 mt-3">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-info-circle"></i></span>
                                            <input type="text" class="form-control" name="catatan[]" placeholder="Catatan tambahan">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('dokumen', $selectedServices) ? '' : 'hidden' }}" id="dokumen-details">
                        <h6 class="detail-title">
                            <i class="bi bi-file-text"></i> Dokumen
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($documents as $document)
                                <div class="document-item {{ $existingDocuments->pluck('document_id')->contains($document->id) ? 'active' : '' }}" data-document="{{ $document->id }}">
                                    <div class="service-name">{{ $document->name }}</div>
                                    <input type="checkbox" name="documents[]" value="{{ $document->id }}" {{ $existingDocuments->pluck('document_id')->contains($document->id) ? 'checked' : '' }}>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach ($documents as $document)
                            @if ($document->childrens && $document->childrens->isNotEmpty())
                                <div class="form-group {{ $existingDocuments->pluck('document_id')->contains($document->id) ? '' : 'hidden' }}" id="doc-{{ $document->id }}-details">
                                    <label class="form-label">{{ $document->name }}</label>
                                    <div class="cars">
                                        @foreach ($document->childrens as $child)
                                        <div class="child-item {{ $existingDocuments->pluck('document_children_id')->contains($child->id) ? 'active' : '' }}" data-parent="doc-{{ $document->id }}" data-child="child-{{ $child->id }}">
                                            <div class="child-name">{{ $child->name }}</div>
                                            <div class="child-name">{{ $child->price }}</div>
                                            <input type="checkbox" name="child_documents[]" value="{{ $child->id }}" {{ $existingDocuments->pluck('document_children_id')->contains($child->id) ? 'checked' : '' }}>
                                        </div>
                                        @endforeach
                                    </div>
                                    @foreach ($document->childrens as $child)
                                    <div class="child-form {{ $existingDocuments->pluck('document_children_id')->contains($child->id) ? '' : 'hidden' }}" id="child-{{ $child->id }}-form">
                                        <h3>Form {{ $child->name }}</h3>
                                        @php
                                            $docDetail = $existingDocuments->where('document_children_id', $child->id)->first();
                                        @endphp
                                        <input type="text" name="jumlah_{{ Str::slug($child->name, '_') }}" value="{{ $docDetail ? $docDetail->jumlah : '' }}">
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="form-group {{ $existingDocuments->pluck('document_id')->contains($document->id) ? '' : 'hidden' }}" id="doc-{{ $document->id }}-form">
                                    <h3>Form {{ $document->name }}</h3>
                                    @php
                                        $docDetail = $existingDocuments->where('document_id', $document->id)->first();
                                    @endphp
                                    <input type="text" class="form-control" name="jumlah_{{ $document->id }}" placeholder="Jumlah {{ $document->name }}" value="{{ $docDetail ? $docDetail->jumlah : '' }}">
                                    <input type="text" class="form-control" name="harga_{{ $document->id }}" placeholder="Harga {{ $document->name }}" value="{{ $docDetail ? $docDetail->harga : '' }}">
                                    <input type="text" class="form-control" name="keterangan_{{ $document->id }}" placeholder="Keterangan {{ $document->name }}" value="{{ $docDetail ? $docDetail->keterangan : '' }}">
                                </div>
                            @endif
                        @endforeach
                        <div class="mb-3">
                            <label for="foto" class="form-label">Paspor</label>
                            <input type="file" class="form-control" id="foto" name="paspor_dokumen" accept="image/*">
                            <small class="text-muted">Format: JPEG, PNG, JPG (Max: 2MB)</small>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Pas foto</label>
                            <input type="file" class="form-control" id="foto" name="pas_foto_dokumen" accept="image/*">
                            <small class="text-muted">Format: JPEG, PNG, JPG (Max: 2MB)</small>
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('handling', $selectedServices) ? '' : 'hidden' }}" id="handling-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Handling
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach (['hotel', 'bandara'] as $type)
                                    @php
                                        $selected = $existingHandlings->pluck('name')->contains($type);
                                    @endphp
                                    <div class="handling-item {{ $selected ? 'selected' : '' }}" data-handling="{{ $type }}">
                                        <div class="service-name">{{ ucfirst($type) }}</div>
                                        <input type="checkbox" name="handlings[]" value="{{ $type }}" hidden {{ $selected ? 'checked' : '' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if($existingHandlings->pluck('name')->contains('hotel'))
                            @php
                                $hotelHandling = $existingHandlings->where('name', 'hotel')->first();
                                $hotelHandlingDetail = $hotelHandling->handlingHotels->first();
                            @endphp
                        @endif
                        <div class="form-group {{ $existingHandlings->pluck('name')->contains('hotel') ? '' : 'hidden' }}" data-handling="hotel" id="hotel-handling-form">
                            <label class="form-label">Hotel</label>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Hotel</label>
                                    <input type="text" class="form-control" name="nama_hotel_handling" value="{{ $hotelHandlingDetail->nama ?? '' }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_hotel_handling" value="{{ $hotelHandlingDetail->tanggal ?? '' }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control" name="harga_hotel_handling" value="{{ $hotelHandlingDetail->harga ?? '' }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Pax</label>
                                    <input type="text" class="form-control" name="pax_hotel_handling" value="{{ $hotelHandlingDetail->pax ?? '' }}">
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
                                    <label class="form-label">Room List</label>
                                    <input type="file" class="form-control" name="rumlis_hotel_handling">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Identitas koper</label>
                                    <input type="file" class="form-control" name="identitas_hotel_handling">
                                </div>
                            </div>
                        </div>
                        @if($existingHandlings->pluck('name')->contains('bandara'))
                            @php
                                $bandaraHandling = $existingHandlings->where('name', 'bandara')->first();
                                $bandaraHandlingDetail = $bandaraHandling->handlingPlanes->first();
                            @endphp
                        @endif
                        <div class="form-group {{ $existingHandlings->pluck('name')->contains('bandara') ? '' : 'hidden' }}" data-handling="bandara" id="bandara-handling-form">
                            <label class="form-label">Bandara</label>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Bandara</label>
                                    <input type="text" class="form-control" name="nama_bandara_handling" value="{{ $bandaraHandlingDetail->nama_bandara ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jumlah Jamaah</label>
                                    <input type="text" class="form-control" name="jumlah_jamaah_handling" value="{{ $bandaraHandlingDetail->jumlah_jamaah ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control" name="harga_bandara_handling" value="{{ $bandaraHandlingDetail->harga ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kedatangan Jamaah</label>
                                    <input type="date" class="form-control" name="kedatangan_jamaah_handling" value="{{ $bandaraHandlingDetail->kedatangan_jamaah ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Paket info</label>
                                    <input type="file" class="form-control" name="paket_info">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Sopir</label>
                                    <input type="text" class="form-control" name="nama_supir" value="{{ $bandaraHandlingDetail->nama_supir ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Identitas koper</label>
                                    <input type="file" class="form-control" name="identitas_koper_bandara_handling">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('pendamping', $selectedServices) ? '' : 'hidden' }}" id="pendamping-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Pendamping
                        </h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($guides as $guide)
                                @php
                                    $selectedGuide = $existingGuides->firstWhere('guide_id', $guide->id);
                                @endphp
                                <div class="pendamping-wrapper">
                                    <div class="pendamping-item {{ $selectedGuide ? 'active' : '' }}" data-pendamping="guide-{{ $guide->id }}" data-price="{{ $guide->harga }}">
                                        <div class="service-name">{{ $guide->nama }}</div>
                                        <div class="service-desc">Rp {{ number_format($guide->harga, 0, ',', '.') }}</div>
                                        <input type="checkbox" name="pendamping[]" value="{{ $guide->id }}" hidden {{ $selectedGuide ? 'checked' : '' }}>
                                    </div>
                                    <div class="pendamping-form {{ $selectedGuide ? '' : 'hidden' }}" id="form-guide-{{ $guide->id }}">
                                        <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                        <input type="number" class="form-control jumlah-pendamping" data-name="{{ $guide->nama }}" data-price="{{ $guide->harga }}" name="jumlah_{{ $guide->id }}" min="1" value="{{ $selectedGuide->jumlah ?? 1 }}">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control" name="ket_{{ $guide->id }}">{{ $selectedGuide->keterangan ?? '' }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('konten', $selectedServices) ? '' : 'hidden' }}" id="konten-details">
                        <h6 class="detail-title"><i class="bi bi-briefcase"></i> Content</h6>
                        <div class="detail-section">
                            <div class="service-grid">
                                @foreach ($contents as $content)
                                @php
                                    $selectedContent = $existingContents->firstWhere('content_id', $content->id);
                                @endphp
                                <div class="content-wrapper">
                                    <div class="content-item {{ $selectedContent ? 'active' : '' }}" data-id="{{ $content->id }}" data-name="{{ $content->name }}" data-price="{{ $content->price }}">
                                        <div class="service-name">{{ $content->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($content->price, 0, ',', '.') }}</div>
                                        <input type="checkbox" name="content[]" value="{{ $content->id }}" {{ $selectedContent ? 'checked' : '' }}>
                                    </div>
                                    <div class="content-form {{ $selectedContent ? '' : 'hidden' }}" id="form-{{ $content->id }}">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" class="form-control jumlah-input" name="jumlah_{{ $content->id }}" value="{{ $selectedContent->jumlah ?? 1 }}">
                                        <label class="form-label mt-2">Keterangan</label>
                                        <textarea class="form-control ket-input" name="ket_{{ $content->id }}">{{ $selectedContent->keterangan ?? '' }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('reyal', $selectedServices) ? '' : 'hidden' }}" id="reyal-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Penukaran mata uang
                        </h6>
                        <div class="row">
                            @php
                                $isTamis = $existingReyal->where('tipe', 'tamis')->first();
                                $isTumis = $existingReyal->where('tipe', 'tumis')->first();
                            @endphp
                            <div class="col-md-6">
                                <div class="card text-center p-3 {{ $isTamis ? 'selected' : '' }}" id="card-tamis" style="cursor: pointer;">
                                    <h5>Tamis</h5>
                                    <p>Rupiah → Reyal</p>
                                    <input type="radio" name="tipe" value="tamis" id="radio-tamis" {{ $isTamis ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card text-center p-3 {{ $isTumis ? 'selected' : '' }}" id="card-tumis" style="cursor: pointer;">
                                    <h5>Tumis</h5>
                                    <p>Reyal → Rupiah</p>
                                    <input type="radio" name="tipe" value="tumis" id="radio-tumis" {{ $isTumis ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        @if($isTamis)
                            <div class="detail-form mt-3" id="form-tamis" style="display: block;">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Rupiah → Reyal</h6>
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah" value="{{ $isTamis->jumlah_input ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis" value="{{ $isTamis->kurs ?? '' }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis" readonly value="{{ $isTamis->hasil ?? '' }}">
                                </div>
                            </div>
                        @else
                            <div class="detail-form mt-3 hidden" id="form-tamis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Rupiah → Reyal</h6>
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis" readonly>
                                </div>
                            </div>
                        @endif

                        @if($isTumis)
                            <div class="detail-form mt-3" id="form-tumis" style="display: block;">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Reyal → Rupiah</h6>
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal" value="{{ $isTumis->jumlah_input ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis" value="{{ $isTumis->kurs ?? '' }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis" readonly value="{{ $isTumis->hasil ?? '' }}">
                                </div>
                            </div>
                        @else
                            <div class="detail-form mt-3 hidden" id="form-tumis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Reyal → Rupiah</h6>
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis" readonly>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="detail-form {{ in_array('tour', $selectedServices) ? '' : 'hidden' }}" id="tour-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Tour
                        </h6>
                        <div class="detail-section">
                            <div class="tours">
                                @foreach ($tours as $tour)
                                @php
                                    $selectedTour = $existingTours->firstWhere('tour_id', $tour->id);
                                @endphp
                                <label class="service-tour {{ $selectedTour ? 'active' : '' }}" data-tour="{{ strtolower(str_replace(' ', '-', $tour->name)) }}">
                                    <div class="service-name">{{ $tour->name }}</div>
                                    <input type="checkbox" name="tours[]" value="{{ $tour->id }}" class="d-none" {{ $selectedTour ? 'checked' : '' }}>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @foreach ($tours as $tour)
                            @php
                                $slug = strtolower(str_replace(' ', '-', $tour->name));
                                $selectedTour = $existingTours->firstWhere('tour_id', $tour->id);
                            @endphp
                            <div id="tour-{{ $slug }}-form" class="tour-form {{ $selectedTour ? '' : 'hidden' }}">
                                <h4>Transportasi {{ $tour->name }}</h4>
                                <div class="transport-options">
                                    @foreach ($transportations as $trans)
                                    <label class="transport-option {{ $selectedTour && $selectedTour->transportation_id == $trans->id ? 'active' : '' }}">
                                        <div class="service-name">{{ $trans->nama }}</div>
                                        <div class="service-desc">Kapasitas: {{ $trans->kapasitas }}</div>
                                        <div class="service-desc">Fasilitas: {{ $trans->fasilitas }}</div>
                                        <div class="service-desc">Harga: {{ $trans->harga }}</div>
                                        <input type="radio" name="select_car_{{ $slug }}" value="{{ $trans->id }}" class="d-none" data-price="{{ $trans->harga }}" {{ $selectedTour && $selectedTour->transportation_id == $trans->id ? 'checked' : '' }}>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="detail-form {{ in_array('meals', $selectedServices) ? '' : 'hidden' }}" id="meals-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Makanan
                        </h6>
                        <div class="">
                            @foreach ($meals as $meal)
                            @php
                                $selectedMeal = $existingMeals->firstWhere('meal_id', $meal->id);
                            @endphp
                            <div class="meal-item {{ $selectedMeal ? 'selected' : '' }}" data-meal="{{ strtolower(str_replace(' ', '-', $meal->name)) }}" data-price="{{ $meal->price }}" class="meal-item">
                                <div class="service-name">{{ $meal->name }}</div>
                                <div class="service-desc">{{ number_format($meal->price, 0, ',', '.') }}</div>
                                <input type="checkbox" name="meals[]" value="{{ $meal->id }}" hidden {{ $selectedMeal ? 'checked' : '' }}>
                            </div>
                            <div id="form-{{ strtolower(str_replace(' ', '-', $meal->name)) }}" class="form-jumlah {{ $selectedMeal ? '' : 'hidden' }} mt-2">
                                <input type="number" class="jumlah-meal form-control" min="0" value="{{ $selectedMeal->jumlah ?? 1 }}" name="jumlah_meals[{{ $meal->id }}]" data-name="{{ $meal->name }}" data-price="{{ $meal->price }}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('dorongan', $selectedServices) ? '' : 'hidden' }}" id="dorongan-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Dorongan
                        </h6>
                        <div class="service-grid">
                            @foreach ($dorongan as $item)
                            @php
                                $slug = Str::slug($item->name);
                                $selectedDorongan = $existingDorongans->firstWhere('dorongan_id', $item->id);
                            @endphp
                            <div class="dorongan-wrapper">
                                <div class="dorongan-item {{ $selectedDorongan ? 'active' : '' }}" data-dorongan="{{ $slug }}" data-price="{{ $item->price }}">
                                    <div class="service-name">{{ $item->name }}</div>
                                    <div class="service-desc">Rp. {{ $item->price }}</div>
                                    <input type="checkbox" name="dorongan[]" value="{{ $item->id }}" hidden {{ $selectedDorongan ? 'checked' : '' }}>
                                </div>
                                <div class="dorongan-form {{ $selectedDorongan ? '' : 'hidden' }}" id="form-{{ $slug }}">
                                    <label class="form-label">Jumlah {{ $item->name }}</label>
                                    <input type="number" class="form-control jumlah-dorongan" name="jumlah_dorongan[{{ $item->id }}]" min="1" value="{{ $selectedDorongan->jumlah ?? 1 }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="detail-form {{ in_array('wakaf', $selectedServices) ? '' : 'hidden' }}" id="waqaf-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Wakaf
                        </h6>
                        <div class="service-grid">
                            @foreach ($wakaf as $item)
                            @php
                                $slug = Str::slug($item->nama);
                                $selectedWakaf = $existingWakaf->firstWhere('wakaf_id', $item->id);
                            @endphp
                            <div class="wakaf-item {{ $selectedWakaf ? 'active' : '' }}" data-slug="{{ $slug }}" data-name="{{ $item->nama }}" data-price="{{ $item->harga }}">
                                <div class="service-name">{{ $item->nama }}</div>
                                <div class="service-desc">Rp. {{ number_format($item->harga, 0, ',', '.') }}</div>
                                <input type="checkbox" name="wakaf[]" value="{{ $item->id }}" hidden {{ $selectedWakaf ? 'checked' : '' }}>
                            </div>
                            @endforeach
                        </div>
                        @foreach ($wakaf as $item)
                            @php
                                $slug = Str::slug($item->nama);
                                $selectedWakaf = $existingWakaf->firstWhere('wakaf_id', $item->id);
                            @endphp
                            <div id="form-{{ $slug }}" class="form-group {{ $selectedWakaf ? '' : 'hidden' }}">
                                <label class="form-label">Jumlah {{ $item->nama }}</label>
                                <input type="number" class="form-control jumlah-wakaf" name="jumlah_wakaf[{{ $item->id }}]" data-slug="{{ $slug }}" data-name="{{ $item->nama }}" data-price="{{ $item->harga }}" value="{{ $selectedWakaf->jumlah ?? 1 }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="detail-form {{ in_array('badal', $selectedServices) ? '' : 'hidden' }}" id="badal-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Badal
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary mb-2" id="addBadal">Tambah Badal</button>
                        <div id="badalWrapper">
                            @forelse($existingBadals as $badal)
                            <div class="badal-form bg-white p-3 border mb-3">
                                <div class="form-group mb-2">
                                    <label class="form-label">Nama yang dibadalkan</label>
                                    <input type="text" class="form-control nama_badal" name="nama_badal[]" value="{{ $badal->name }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control harga_badal" name="harga_badal[]" value="{{ $badal->price }}">
                                </div>
                                <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button>
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
                                    <input type="number" class="form-control harga_badal" name="harga_badal[]">
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

                <div class="form-actions">
                    <button type="submit" name="action" value="save" class="btn btn-primary">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Objek untuk menyimpan item keranjang
        const cart = {};

        // DOM elements
        const travelSelect = document.getElementById('travel-select');
        const penanggungInput = document.getElementById('penanggung');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const cartSection = document.getElementById("cart-total-price");
        const cartItemsList = document.getElementById("cart-items");
        const cartTotalInput = document.getElementById("cart-total");
        const cartTotalText = document.getElementById("cart-total-text");
        const hotelWrapper = document.getElementById("hotelWrapper");
        const badalWrapper = document.getElementById("badalWrapper");
        const ticketWrapper = document.getElementById("ticketWrapper");
        const transportFormWrapper = document.getElementById("new-transport-forms");

        // --- Fungsi Utama untuk Update Keranjang ---
        function updateCartUI() {
            cartItemsList.innerHTML = "";
            let totalAll = 0;
            const itemsInCart = Object.values(cart);
            
            if (itemsInCart.length > 0) {
                cartSection.style.display = "block";
                itemsInCart.forEach(item => {
                    if (item.total) { // Hanya tambahkan item yang punya total harga
                        totalAll += item.total;
                        const li = document.createElement("li");
                        li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
                        li.innerHTML = `
                            <div>
                                ${item.name}
                                <small class="text-muted d-block">Rp ${item.price.toLocaleString()} / item</small>
                            </div>
                            <span>Rp ${item.total.toLocaleString()}</span>
                        `;
                        cartItemsList.appendChild(li);
                    }
                });
            } else {
                cartSection.style.display = "none";
            }
            
            cartTotalInput.value = totalAll;
            cartTotalText.textContent = "Rp " + totalAll.toLocaleString();
        }

        // --- Fungsi untuk Menginisialisasi Data Lama ke Cart ---
        function initializeCartFromPHP() {
            // Inisialisasi dari Hotel
            const existingHotels = @json($existingHotels);
            existingHotels.forEach((hotel, hIdx) => {
                const id = `hotel-${hIdx}-tipe-${hotel.type}`; // ID yang konsisten
                cart[id] = {
                    name: `${hotel.nama_hotel} - ${hotel.type}`,
                    qty: hotel.jumlah_type,
                    price: hotel.harga_perkamar,
                    total: hotel.jumlah_type * hotel.harga_perkamar
                };
            });

            // Inisialisasi dari Badal
            const existingBadals = @json($existingBadals);
            existingBadals.forEach((badal, bIdx) => {
                const id = `badal-${bIdx}`;
                cart[id] = {
                    name: `Badal - ${badal.name}`,
                    qty: 1,
                    price: badal.price,
                    total: badal.price
                };
            });
            
            // Inisialisasi dari Transportasi
            const existingTransports = @json($existingTransports);
            existingTransports.forEach((transport, tIdx) => {
                if (transport.route) {
                    const id = `transport-${transport.transportation_id}-${transport.route.id}`;
                    cart[id] = {
                        name: `Transportasi - ${transport.transportation.nama} - ${transport.route.route}`,
                        qty: 1,
                        price: transport.route.price,
                        total: transport.route.price
                    };
                }
            });

            // Inisialisasi dari Tours
            const existingTours = @json($existingTours);
            existingTours.forEach(tour => {
                const slug = tour.tour.name.toLowerCase().replace(/ /g, '-');
                const transName = tour.transportation ? tour.transportation.nama : 'Tanpa Transportasi';
                const price = tour.transportation ? tour.transportation.harga : 0;
                const id = `tour-${slug}`;
                cart[id] = {
                    name: `${tour.tour.name} - ${transName}`,
                    qty: 1,
                    price: price,
                    total: price
                };
            });

            // Inisialisasi dari Meals
            const existingMeals = @json($existingMeals);
            existingMeals.forEach(meal => {
                const slug = meal.meal.name.toLowerCase().replace(/ /g, '-');
                const id = `meal-${slug}`;
                cart[id] = {
                    name: `Makanan - ${meal.meal.name}`,
                    qty: meal.jumlah,
                    price: meal.meal.price,
                    total: meal.jumlah * meal.meal.price
                };
            });
            
            // Inisialisasi dari Dorongan
            const existingDorongans = @json($existingDorongans);
            existingDorongans.forEach(dorongan => {
                const slug = dorongan.dorongan.name.toLowerCase().replace(/ /g, '-');
                const id = `dorongan-${slug}`;
                cart[id] = {
                    name: `${dorongan.dorongan.name} (Dorongan)`,
                    qty: dorongan.jumlah,
                    price: dorongan.dorongan.price,
                    total: dorongan.jumlah * dorongan.dorongan.price
                };
            });

            // Inisialisasi dari Wakaf
            const existingWakaf = @json($existingWakaf);
            existingWakaf.forEach(wakaf => {
                const slug = wakaf.wakaf.nama.toLowerCase().replace(/ /g, '-');
                const id = `wakaf-${slug}`;
                cart[id] = {
                    name: `Wakaf - ${wakaf.wakaf.nama}`,
                    qty: wakaf.jumlah,
                    price: wakaf.wakaf.harga,
                    total: wakaf.jumlah * wakaf.wakaf.harga
                };
            });

            // Inisialisasi dari Content
            const existingContents = @json($existingContents);
            existingContents.forEach(content => {
                const id = `content-${content.content_id}`;
                cart[id] = {
                    name: content.content.name,
                    qty: content.jumlah,
                    price: content.content.price,
                    total: content.jumlah * content.content.price
                };
            });

            // Inisialisasi dari Reyal
            const existingReyal = @json($existingReyal);
            existingReyal.forEach(reyal => {
                const id = `reyal-${reyal.tipe}`;
                cart[id] = {
                    name: `Penukaran Reyal (${reyal.tipe})`,
                    qty: 1,
                    price: reyal.jumlah_input,
                    total: reyal.hasil
                };
            });

            // Inisialisasi dari Dokumen (asumsi harga sudah dihitung di backend)
            const existingDocuments = @json($existingDocuments);
            existingDocuments.forEach(doc => {
                if(doc.document_children_id){
                    const id = `child-doc-${doc.document_children_id}`;
                    cart[id] = {
                        name: doc.document_children.name,
                        qty: doc.jumlah,
                        price: doc.harga,
                        total: doc.jumlah * doc.harga
                    };
                } else {
                    const id = `doc-${doc.document_id}-form`;
                    cart[id] = {
                        name: doc.document.name,
                        qty: doc.jumlah,
                        price: doc.harga,
                        total: doc.jumlah * doc.harga
                    };
                }
            });

            updateCartUI();
        }
        
        // --- Delegasi Event untuk Menangani Klik pada Item Serbaguna ---
        document.body.addEventListener('click', function(e) {
            // Handle service-item clicks
            const serviceItem = e.target.closest('.service-item');
            if (serviceItem) {
                const serviceType = serviceItem.getAttribute('data-service');
                const detailForm = document.getElementById(`${serviceType}-details`);
                const checkbox = serviceItem.querySelector('input[type="checkbox"]');

                serviceItem.classList.toggle('selected');
                checkbox.checked = !checkbox.checked;

                if (detailForm) {
                    detailForm.classList.toggle("hidden", !checkbox.checked);
                }
            }
            
            // Handle transport-item clicks
            const transportItem = e.target.closest('.transport-item');
            if (transportItem) {
                const transportType = transportItem.getAttribute('data-transportasi');
                const formGroup = document.querySelector(`.form-group[data-transportasi="${transportType}"]`);
                const checkbox = transportItem.querySelector('input[type="checkbox"]');

                transportItem.classList.toggle('selected');
                checkbox.checked = !checkbox.checked;

                if (formGroup) {
                    formGroup.classList.toggle("hidden", !checkbox.checked);
                }
            }

            // Handle handling-item clicks
            const handlingItem = e.target.closest('.handling-item');
            if (handlingItem) {
                const handlingType = handlingItem.getAttribute('data-handling');
                const formGroup = document.querySelector(`.form-group[data-handling="${handlingType}"]`);
                const checkbox = handlingItem.querySelector('input[type="checkbox"]');

                handlingItem.classList.toggle('selected');
                checkbox.checked = !checkbox.checked;

                if (formGroup) {
                    formGroup.classList.toggle("hidden", !checkbox.checked);
                }
            }
            
            // Handle document-item clicks
            const documentItem = e.target.closest('.document-item');
            if (documentItem) {
                const docId = documentItem.dataset.document;
                const formGroup = document.getElementById(`doc-${docId}-form`);
                const childWrapper = document.getElementById(`doc-${docId}-details`);
                const checkbox = documentItem.querySelector("input[type='checkbox']");

                documentItem.classList.toggle("active");
                checkbox.checked = !checkbox.checked;

                if (childWrapper) {
                    childWrapper.classList.toggle("hidden");
                } else if (formGroup) {
                    formGroup.classList.toggle("hidden");
                }
            }

            // Handle child-item clicks
            const childItem = e.target.closest('.child-item');
            if (childItem) {
                const parentId = childItem.dataset.parent;
                const childId = childItem.dataset.child;
                const form = document.getElementById(`${childId}-form`);
                const checkbox = childItem.querySelector("input[type='checkbox']");

                document.querySelectorAll(`#${parentId} .child-form`).forEach(f => {
                    f.classList.add("hidden");
                });

                if (form) {
                    form.classList.remove("hidden");
                }
                
                document.querySelectorAll(`#${parentId} .child-item`).forEach(item => {
                    item.classList.remove('active');
                    item.querySelector('input[type="checkbox"]').checked = false;
                });
                childItem.classList.add("active");
                checkbox.checked = true;
            }

            // Handle tour clicks
            const tourItem = e.target.closest('.service-tour');
            if(tourItem) {
                const slug = tourItem.dataset.tour;
                const tourForm = document.getElementById(`tour-${slug}-form`);
                const checkbox = tourItem.querySelector("input[type='checkbox']");
                
                tourItem.classList.toggle('active');
                checkbox.checked = !checkbox.checked;
                
                if (tourForm) {
                    tourForm.classList.toggle('hidden');
                }
            }
            
            // Handle transport-option (tour) clicks
            const tourTransport = e.target.closest('.transport-option');
            if(tourTransport) {
                const name = tourTransport.querySelector('.service-name').textContent;
                const price = tourTransport.querySelector('input[type="radio"]').dataset.price;
                const parentForm = tourTransport.closest('.tour-form');
                const tourName = parentForm.querySelector('h4').textContent.split('Transportasi ')[1];
                const slug = parentForm.id.replace('tour-', '').replace('-form', '');
                
                document.querySelectorAll(`#tour-${slug}-form .transport-option`).forEach(opt => opt.classList.remove('active'));
                tourTransport.classList.add('active');

                const id = `tour-${slug}`;
                cart[id] = { name: `${tourName} - ${name}`, qty: 1, price: parseInt(price), total: parseInt(price) };
                updateCartUI();
            }

            // Handle meal-item clicks
            const mealItem = e.target.closest('.meal-item');
            if (mealItem) {
                const slug = mealItem.dataset.meal;
                const form = document.getElementById(`form-${slug}`);
                const checkbox = mealItem.querySelector("input[type='checkbox']");
                const qtyInput = form.querySelector('input[type="number"]');

                mealItem.classList.toggle('selected');
                checkbox.checked = !checkbox.checked;

                if (form) {
                    form.classList.toggle('hidden');
                    if (!form.classList.contains('hidden')) {
                        qtyInput.value = 1;
                        const id = `meal-${slug}`;
                        cart[id] = { name: `Makanan - ${mealItem.querySelector('.service-name').textContent}`, qty: 1, price: parseInt(mealItem.dataset.price), total: parseInt(mealItem.dataset.price) };
                    } else {
                        delete cart[`meal-${slug}`];
                    }
                    updateCartUI();
                }
            }
            
            // Handle dorongan-item clicks
            const doronganItem = e.target.closest('.dorongan-item');
            if (doronganItem) {
                const slug = doronganItem.dataset.dorongan;
                const form = document.getElementById(`form-${slug}`);
                const checkbox = doronganItem.querySelector("input[type='checkbox']");
                const qtyInput = form.querySelector('input[type="number"]');
                
                doronganItem.classList.toggle('active');
                checkbox.checked = !checkbox.checked;

                if (form) {
                    form.classList.toggle('hidden');
                    if (!form.classList.contains('hidden')) {
                        qtyInput.value = 1;
                        const id = `dorongan-${slug}`;
                        cart[id] = { name: `${doronganItem.querySelector('.service-name').textContent} (Dorongan)`, qty: 1, price: parseInt(doronganItem.dataset.price), total: parseInt(doronganItem.dataset.price) };
                    } else {
                        delete cart[`dorongan-${slug}`];
                    }
                    updateCartUI();
                }
            }

            // Handle wakaf-item clicks
            const wakafItem = e.target.closest('.wakaf-item');
            if (wakafItem) {
                const slug = wakafItem.dataset.slug;
                const form = document.getElementById(`form-${slug}`);
                const checkbox = wakafItem.querySelector("input[type='checkbox']");
                const qtyInput = form.querySelector('input[type="number"]');

                wakafItem.classList.toggle('active');
                checkbox.checked = !checkbox.checked;

                if (form) {
                    form.classList.toggle('hidden');
                    if (!form.classList.contains('hidden')) {
                        qtyInput.value = 1;
                        const id = `wakaf-${slug}`;
                        cart[id] = { name: `Wakaf - ${wakafItem.querySelector('.service-name').textContent}`, qty: 1, price: parseInt(wakafItem.dataset.price), total: parseInt(wakafItem.dataset.price) };
                    } else {
                        delete cart[`wakaf-${slug}`];
                    }
                    updateCartUI();
                }
            }

            // Handle content-item clicks
            const contentItem = e.target.closest('.content-item');
            if(contentItem) {
                const id = contentItem.dataset.id;
                const form = document.getElementById(`form-${id}`);
                const checkbox = contentItem.querySelector('input[type="checkbox"]');
                const qtyInput = form.querySelector('input[type="number"]');
                
                contentItem.classList.toggle('active');
                checkbox.checked = !checkbox.checked;

                if(form) {
                    form.classList.toggle('hidden');
                    if(!form.classList.contains('hidden')) {
                        qtyInput.value = 1;
                        const cartId = `content-${id}`;
                        cart[cartId] = { name: contentItem.dataset.name, qty: 1, price: parseInt(contentItem.dataset.price), total: parseInt(contentItem.dataset.price) };
                    } else {
                        delete cart[`content-${id}`];
                    }
                    updateCartUI();
                }
            }
            
            // Handle radio button for reyal
            const reyalCard = e.target.closest('.card[id^="card-"]');
            if (reyalCard) {
                const radio = reyalCard.querySelector('input[type="radio"]');
                if (radio) {
                    document.querySelectorAll('.card[id^="card-"]').forEach(card => card.classList.remove('selected'));
                    document.getElementById('form-tamis').style.display = 'none';
                    document.getElementById('form-tumis').style.display = 'none';
                    reyalCard.classList.add('selected');
                    radio.checked = true;

                    if (radio.value === 'tamis') {
                        document.getElementById('form-tamis').style.display = 'block';
                        delete cart['reyal-tumis'];
                    } else {
                        document.getElementById('form-tumis').style.display = 'block';
                        delete cart['reyal-tamis'];
                    }
                }
            }

            // Handle remove buttons
            if (e.target.classList.contains('removeBadal')) {
                const badalForm = e.target.closest('.badal-form');
                if (badalForm) {
                    const index = Array.from(badalWrapper.children).indexOf(badalForm);
                    delete cart[`badal-${index + 1}`];
                    badalForm.remove();
                    updateCartUI();
                }
            }
            if (e.target.classList.contains('removeTicket')) {
                const ticketForm = e.target.closest('.ticket-form');
                if (ticketForm && ticketWrapper.querySelectorAll('.ticket-form').length > 1) {
                    ticketForm.remove();
                } else {
                    alert("Minimal harus ada 1 tiket!");
                }
            }
            if (e.target.classList.contains('removeHotel')) {
                const hotelForm = e.target.closest('.hotel-form');
                if (hotelForm) {
                    // Cek apakah ini hotel satu-satunya
                    if (hotelWrapper.children.length > 1) {
                        hotelForm.remove();
                        // Hapus item dari keranjang
                        const index = Array.from(hotelWrapper.children).indexOf(hotelForm);
                        for (let key in cart) {
                            if (key.startsWith(`hotel-${index}`)) {
                                delete cart[key];
                            }
                        }
                    } else {
                        alert('Minimal harus ada 1 form hotel.');
                    }
                    updateCartUI();
                }
            }
            if (e.target.classList.contains('remove-transport')) {
                const sets = transportFormWrapper.querySelectorAll(".transport-set");
                if (sets.length > 1) {
                    const transportSet = e.target.closest(".transport-set");
                    const index = Array.from(transportFormWrapper.children).indexOf(transportSet);
                    for (let key in cart) {
                        if (key.startsWith(`transport-${index}`)) {
                            delete cart[key];
                        }
                    }
                    transportSet.remove();
                    updateCartUI();
                } else {
                    alert("Minimal 1 transportasi harus ada!");
                }
            }
        });

        // --- Event Listeners untuk Input (karena delegasi click tidak bekerja pada input) ---
        document.body.addEventListener('input', function(e) {
            // Reyal
            if (e.target.id === 'rupiah-tamis' || e.target.id === 'kurs-tamis') {
                const jumlahRupiah = parseInt(document.getElementById('rupiah-tamis').value) || 0;
                const kurs = parseFloat(document.getElementById('kurs-tamis').value) || 0;
                const hasil = kurs > 0 ? (jumlahRupiah / kurs).toFixed(2) : 0;
                document.getElementById('hasil-tamis').value = hasil;
                
                const id = 'reyal-tamis';
                cart[id] = { name: 'Penukaran Reyal (Tamis)', qty: 1, price: jumlahRupiah, total: hasil * kurs };
                updateCartUI();
            } else if (e.target.id === 'reyal-tumis' || e.target.id === 'kurs-tumis') {
                const jumlahReyal = parseInt(document.getElementById('reyal-tumis').value) || 0;
                const kurs = parseFloat(document.getElementById('kurs-tumis').value) || 0;
                const hasil = jumlahReyal * kurs;
                document.getElementById('hasil-tumis').value = hasil.toLocaleString();
                
                const id = 'reyal-tumis';
                cart[id] = { name: 'Penukaran Reyal (Tumis)', qty: 1, price: jumlahReyal, total: hasil };
                updateCartUI();
            }
            
            // Badal
            const badalForm = e.target.closest('.badal-form');
            if (badalForm && (e.target.classList.contains('nama_badal') || e.target.classList.contains('harga_badal'))) {
                const index = Array.from(badalWrapper.children).indexOf(badalForm);
                const nama = badalForm.querySelector('.nama_badal').value.trim();
                const harga = parseInt(badalForm.querySelector('.harga_badal').value) || 0;
                const id = `badal-${index + 1}`;
                if (nama && harga > 0) {
                    cart[id] = { name: `Badal - ${nama}`, qty: 1, price: harga, total: harga };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }
            
            // Tours
            const tourTransport = e.target.closest('.transport-option');
            if (tourTransport && e.target.type === 'radio') {
                const name = tourTransport.querySelector('.service-name').textContent;
                const price = e.target.dataset.price;
                const parentForm = tourTransport.closest('.tour-form');
                const tourName = parentForm.querySelector('h4').textContent.split('Transportasi ')[1];
                const slug = parentForm.id.replace('tour-', '').replace('-form', '');
                
                const id = `tour-${slug}`;
                cart[id] = { name: `${tourName} - ${name}`, qty: 1, price: parseInt(price), total: parseInt(price) };
                updateCartUI();
            }

            // Jumlah Dorongan
            if (e.target.classList.contains('jumlah-dorongan')) {
                const qtyInput = e.target;
                const slug = qtyInput.dataset.slug;
                const doronganItem = document.querySelector(`.dorongan-item[data-dorongan="${slug}"]`);
                if (!doronganItem || !doronganItem.querySelector('input').checked) return;

                const qty = parseInt(qtyInput.value) || 0;
                const name = qtyInput.dataset.name;
                const price = parseInt(qtyInput.dataset.price);
                const id = `dorongan-${slug}`;
                if (qty > 0) {
                    cart[id] = { name: `${name} (Dorongan)`, qty, price, total: qty * price };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }

            // Jumlah Wakaf
            if (e.target.classList.contains('jumlah-wakaf')) {
                const qtyInput = e.target;
                const slug = qtyInput.dataset.slug;
                const wakafItem = document.querySelector(`.wakaf-item[data-slug="${slug}"]`);
                if (!wakafItem || !wakafItem.querySelector('input').checked) return;

                const qty = parseInt(qtyInput.value) || 0;
                const name = qtyInput.dataset.name;
                const price = parseInt(qtyInput.dataset.price);
                const id = `wakaf-${slug}`;
                if (qty > 0) {
                    cart[id] = { name: `Wakaf - ${name}`, qty, price, total: qty * price };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }

            // Jumlah Content
            if (e.target.classList.contains('jumlah-input') && e.target.closest('.content-form')) {
                const qtyInput = e.target;
                const form = qtyInput.closest('.content-form');
                const contentId = form.id.replace('form-', '');
                const contentItem = document.querySelector(`.content-item[data-id="${contentId}"]`);
                if (!contentItem || !contentItem.querySelector('input').checked) return;

                const qty = parseInt(qtyInput.value) || 0;
                const name = contentItem.dataset.name;
                const price = parseInt(contentItem.dataset.price);
                const id = `content-${contentId}`;
                if (qty > 0) {
                    cart[id] = { name, qty, price, total: qty * price };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }

            // Jumlah Meals
            if (e.target.classList.contains('jumlah-meal')) {
                const qtyInput = e.target;
                const mealItem = document.querySelector(`.meal-item[data-meal="${qtyInput.dataset.name.toLowerCase().replace(/ /g, '-')}"]`);
                if (!mealItem || !mealItem.querySelector('input').checked) return;
                
                const qty = parseInt(qtyInput.value) || 0;
                const name = qtyInput.dataset.name;
                const price = parseInt(qtyInput.dataset.price);
                const id = `meal-${qtyInput.dataset.name.toLowerCase().replace(/ /g, '-')}`;
                if (qty > 0) {
                    cart[id] = { name: `Makanan - ${name}`, qty, price, total: qty * price };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }

            // Jumlah Pendamping
            if (e.target.classList.contains('jumlah-pendamping')) {
                const qtyInput = e.target;
                const guideId = qtyInput.name.replace('jumlah_', '');
                const pendampingItem = document.querySelector(`.pendamping-item[data-pendamping="guide-${guideId}"]`);
                if (!pendampingItem || !pendampingItem.querySelector('input').checked) return;
                
                const qty = parseInt(qtyInput.value) || 0;
                const name = qtyInput.dataset.name;
                const price = parseInt(qtyInput.dataset.price);
                const id = `pendamping-guide-${guideId}`;
                if (qty > 0) {
                    cart[id] = { name, qty, price, total: qty * price };
                } else {
                    delete cart[id];
                }
                updateCartUI();
            }
        });
        
        // --- Inisialisasi pada DOM Load ---
        initializeCartFromPHP();
        
        // --- Event Listener untuk Travel Select ---
        travelSelect.addEventListener('change', function() {
            let option = this.options[this.selectedIndex];
            penanggungInput.value = option.getAttribute('data-penanggung');
            emailInput.value = option.getAttribute('data-email');
            phoneInput.value = option.getAttribute('data-telepon');
        });
    });
</script>