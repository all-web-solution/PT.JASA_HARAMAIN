@extends('admin.master')
@section('content')

    @push('styles')
        {{-- Salin SEMUA CSS dari <style>...</style> form Service ke sini --}}
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

            /* Container utama (copy dari .service-create-container) */
            .travel-create-container {
                /* Ganti nama class agar spesifik */
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

            /* Form Section (copy dari Service form) */
            .form-section {
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid var(--border-color);
            }

            .form-section:last-of-type {
                /* Hilangkan border di section terakhir */
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            .form-section-title {
                font-size: 1.1rem;
                color: var(--haramain-primary);
                margin-bottom: 1.5rem;
                /* Beri jarak lebih ke bawah */
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                /* Pertegas judul section */
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

            .form-control,
            .form-select {
                /* Tambahkan .form-select */
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                font-size: 1rem;
                transition: border-color 0.3s ease;
            }

            .form-control:focus,
            .form-select:focus {
                /* Tambahkan .form-select */
                outline: none;
                border-color: var(--haramain-secondary);
                box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
            }

            .form-text {
                font-size: 0.875rem;
                color: var(--text-secondary);
                margin-top: 0.25rem;
            }

            /* Form Row (copy dari Service form) */
            .form-row {
                display: flex;
                gap: 1.5rem;
                /* Beri jarak antar kolom */
                margin-bottom: 1.25rem;
                /* Konsisten dgn form-group */
            }

            .form-row:last-child {
                /* Hapus margin bawah di row terakhir section */
                margin-bottom: 0;
            }


            .form-col {
                flex: 1;
                /* Biarkan kolom membagi ruang */
            }

            /* Tombol (copy dari Service form) */
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
                text-decoration: none;
                /* Untuk link */
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

            /* Form Actions (copy dari Service form) */
            .form-actions {
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--border-color);
            }

            /* Responsive (copy dari Service form, sesuaikan jika perlu) */
            @media (max-width: 768px) {
                .form-row {
                    flex-direction: column;
                    gap: 0;
                    /* Hapus gap vertikal jika kolom tumpuk */
                    margin-bottom: 0;
                    /* Hapus margin bawah jika tumpuk */
                }

                .form-row .form-col {
                    margin-bottom: 1.25rem;
                    /* Beri jarak bawah antar input yg tumpuk */
                }

                .form-row .form-col:last-child {
                    margin-bottom: 0;
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
    @endpush

@section('content')
    <div class="travel-create-container"> {{-- Ganti class container --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"> {{-- Gunakan class card-title --}}
                    <i class="bi bi-plus-circle"></i>Tambah Travel/Pelanggan Baru
                </h5>
                {{-- Gunakan btn-secondary untuk tombol Kembali --}}
                <a href="{{ route('admin.pelanggan') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pelanggan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Gunakan Bootstrap Row untuk menampung kedua section --}}
                    <div class="row g-4"> {{-- g-4 memberikan gap antar kolom --}}

                        {{-- Kolom Kiri: Informasi Travel --}}
                        <div class="col-md-6">
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="bi bi-building"></i> Informasi Travel
                                </h6>

                                {{-- Baris Nama & Email --}}
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="nama_travel" class="form-label">Nama Travel</label>
                                            <input type="text" class="form-control" id="nama_travel" name="nama_travel"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Baris Status & Foto --}}
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="active" selected>Aktif</option>
                                                <option value="inactive">Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="foto" class="form-label">Logo/Foto Travel</label>
                                            <input type="file" class="form-control" id="foto" name="foto"
                                                accept="image/*">
                                            <small class="text-muted">Format: JPEG, PNG, JPG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div> {{-- Akhir Section Informasi Travel --}}
                        </div> {{-- Akhir Kolom Kiri --}}

                        {{-- Kolom Kanan: Informasi Penanggung Jawab --}}
                        <div class="col-md-6">
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="bi bi-person-badge"></i> Informasi Penanggung Jawab
                                </h6>

                                {{-- Baris Nama PJ & No KTP --}}
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                                            <input type="text" class="form-control" id="penanggung_jawab"
                                                name="penanggung_jawab" required>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="no_ktp" class="form-label">Nomor KTP</label>
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Baris Telepon & Alamat --}}
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Nomor Telepon/HP</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> {{-- Akhir Section Penanggung Jawab --}}
                        </div> {{-- Akhir Kolom Kanan --}}

                    </div> {{-- Akhir Row Utama --}}

                    {{-- Tombol Aksi (di luar row) --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Travel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
