@extends('admin.master')
@section('title', 'Tambah Harga Hotel')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --success-color: #28a745;
        }

        .service-create-container {
            max-width: 1000px;
            /* Lebar optimal untuk form panjang */
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            background-color: #fff;
            margin-bottom: 2rem;
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

        .card-body {
            padding: 2rem;
        }

        /* Form Layout */
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--border-color);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .form-section-title {
            font-size: 1.1rem;
            color: var(--haramain-primary);
            margin-bottom: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .form-col {
            flex: 1;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--haramain-secondary);
            box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
            border-color: var(--text-secondary);
        }

        .btn-submit {
            background-color: var(--success-color);
            color: #fff;
        }

        .btn-submit:hover {
            background-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: 45px !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 1rem !important;
            color: var(--text-primary) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
            right: 10px !important;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-create-container {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-plus-circle"></i> Tambah Harga Hotel</h5>
                <a href="{{ route('hotel.price.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('hotel.price.store') }}" method="POST">
                    @csrf

                    {{-- SECTION 1: DATA UTAMA --}}
                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-building"></i> Informasi Hotel & Kamar</h6>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="nama_hotel" class="form-label">Nama Hotel <span
                                            class="text-danger">*</span></label>
                                    {{-- Input Manual (Text) --}}
                                    <input type="text" class="form-control" name="nama_hotel" id="nama_hotel"
                                        {{-- Logic Value: Support untuk Create (old saja) dan Edit (old + data database) --}} value="{{ old('nama_hotel', $priceList->nama_hotel ?? '') }}"
                                        placeholder="Masukkan nama hotel" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="tipe_kamar" class="form-label">Tipe Kamar <span
                                            class="text-danger">*</span></label>
                                    <select name="tipe_kamar" class="form-control" required>
                                        <option value="">-- Pilih Tipe Kamar --</option>
                                        @foreach ($roomTypes as $tipe)
                                            <option value="{{ $tipe }}"
                                                {{ old('tipe_kamar') == $tipe ? 'selected' : '' }}>
                                                {{ $tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga (IDR) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="harga" id="harga"
                                    value="{{ old('harga') }}" placeholder="Contoh: 500000" required>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: PERIODE MENGINAP --}}
                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-calendar-range"></i> Periode Menginap</h6>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Tanggal Check-In</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                                        value="{{ old('tanggal') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="tanggal_checkOut" class="form-label">Tanggal Check-Out</label>
                                    <input type="date" class="form-control" name="tanggal_checkOut" id="tanggal_checkOut"
                                        value="{{ old('tanggal_checkOut') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Field Tanggal Lama (Hidden/Optional) --}}
                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                    </div>

                    {{-- SECTION 3: DETAIL SUPPLIER --}}
                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-people-fill"></i> Data Supplier (Vendor)</h6>

                        {{-- Supplier Utama --}}
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="supplier_utama" class="form-label">Supplier Utama</label>
                                    <input type="text" class="form-control" name="supplier_utama" id="supplier_utama"
                                        value="{{ old('supplier_utama') }}" placeholder="Nama PT / Vendor">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="kontak_supplier_utama" class="form-label">Kontak Supplier Utama</label>
                                    <input type="text" class="form-control" name="kontak_supplier_utama"
                                        id="kontak_supplier_utama" value="{{ old('kontak_supplier_utama') }}"
                                        placeholder="No. Telp / Email">
                                </div>
                            </div>
                        </div>

                        {{-- Supplier Cadangan --}}
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="supplier_cadangan" class="form-label">Supplier Cadangan (Opsional)</label>
                                    <input type="text" class="form-control" name="supplier_cadangan"
                                        id="supplier_cadangan" value="{{ old('supplier_cadangan') }}"
                                        placeholder="Nama PT / Vendor">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="kontak_supplier_cadangan" class="form-label">Kontak Supplier
                                        Cadangan</label>
                                    <input type="text" class="form-control" name="kontak_supplier_cadangan"
                                        id="kontak_supplier_cadangan" value="{{ old('kontak_supplier_cadangan') }}"
                                        placeholder="No. Telp / Email">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 4: KETERANGAN TAMBAHAN --}}
                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-file-text"></i> Informasi Tambahan</h6>

                        <div class="form-group">
                            <label for="add_on" class="form-label">Add-on (Fasilitas Tambahan)</label>
                            <input type="text" class="form-control" name="add_on" id="add_on"
                                value="{{ old('add_on') }}" placeholder="Contoh: Extra Bed, Breakfast, Shuttle">
                        </div>

                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" id="catatan" placeholder="Tulis catatan penting di sini...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check-circle"></i> Simpan Data Hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#nama_hotel_select').select2({
                placeholder: '-- Cari atau Tambah Hotel Baru --',
                allowClear: true,
                tags: true, // Membolehkan user mengetik nama baru
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term + ' (Baru)',
                        newTag: true
                    }
                }
            });
        });
    </script>
@endpush
