@extends('admin.master')
@section('title', 'Detail Menu')
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
            --background-light: #f8fafd;
        }

        .service-show-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
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
            padding: 2rem;
        }

        /* Form Display Styles */
        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--border-color);
        }

        .form-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            color: var(--haramain-secondary);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        .form-col {
            flex: 1;
            min-width: 250px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        p.form-control {
            background-color: var(--haramain-light);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin: 0;
            color: var(--text-primary);
            word-wrap: break-word;
            min-height: 44px;
            /* Samakan tinggi dengan input form biasa */
        }
    </style>
@endpush

@section('content')
    <div class="service-show-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-eye"></i> Detail Menu Makanan
                </h5>
                <a href="{{ route('catering.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Menu
                    </h6>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Nama Menu</label>
                                <p class="form-control">{{ $meal->mealItem->name }}</p>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Harga</label>
                                <p class="form-control">{{ $meal->mealItem->price }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Layanan Section -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Layanan
                    </h6>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Pilih Travel (Service)</label>
                                <p class="form-control">{{ $meal->service->pelanggan->nama_travel }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Tambahan Section -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-person"></i> Data Tambahan
                    </h6>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Penanggung Jawab (PJ)</label>
                                <p class="form-control">{{ $meal->service->pelanggan->penanggung_jawab }}</p>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Jumlah Kebutuhan</label>
                                <p class="form-control">{{ $meal->jumlah }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kebutuhan Section -->
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Catatan Kebutuhan</label>
                                <p class="form-control">{{ $meal->kebutuhan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <p class="form-control">{{ $meal->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
