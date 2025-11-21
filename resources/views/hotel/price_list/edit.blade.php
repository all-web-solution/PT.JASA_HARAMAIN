@extends('admin.master')
@section('title', 'Edit Price')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--checked-color:#2a6fdb;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545}.service-create-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:#f8fafd}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:1.5rem}.form-section{margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color)}.form-section-title{font-size:1.1rem;color:var(--haramain-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px}.form-section-title i{color:var(--haramain-secondary)}.form-group{margin-bottom:1.25rem}.form-label{display:block;margin-bottom:.5rem;font-weight:600;color:var(--text-primary)}.select2-container--default .select2-selection--single{height:48px;padding:.75rem 1rem;border:1px solid var(--border-color);border-radius:8px;font-size:1rem;transition:border-color 0.3s ease}.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:24px;padding-left:0}.select2-container--default.select2-container--focus .select2-selection--single,.select2-container--default .select2-selection--single:focus{outline:none;border-color:var(--haramain-secondary);box-shadow:0 0 0 3px rgb(42 111 219 / .1)}.select2-container--default .select2-selection--single .select2-selection__arrow{height:46px;right:8px}.form-control{width:100%;padding:.75rem 1rem;border:1px solid var(--border-color);border-radius:8px;font-size:1rem;transition:border-color 0.3s ease}.form-control:focus{outline:none;border-color:var(--haramain-secondary);box-shadow:0 0 0 3px rgb(42 111 219 / .1)}.form-text{font-size:.875rem;color:var(--text-secondary);margin-top:.25rem}.form-row{display:flex;gap:1rem;margin-bottom:1rem}.form-col{flex:1}.detail-form{background-color:var(--haramain-light);border-radius:8px;padding:1.5rem;margin-top:1.5rem}.btn{padding:.75rem 1.5rem;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;cursor:pointer}.btn-secondary{background-color:#fff;color:var(--text-secondary);border:1px solid var(--border-color)}.btn-secondary:hover{background-color:#f8f9fa}.btn-submit{background-color:var(--success-color);color:#fff}.btn-submit:hover{background-color:#218838;transform:translateY(-2px);box-shadow:0 4px 8px rgb(40 167 69 / .3)}.form-actions{display:flex;justify-content:flex-end;gap:1rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border-color)}@media (max-width:768px){.form-row{flex-direction:column;gap:0}.form-actions{flex-direction:column}.btn{width:100%;justify-content:center}}
    </style>
@endpush

@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-plus-circle"></i> Edit Harga Hotel: {{ $priceList->nama_hotel }}</h5>
                <a href="{{ route('hotel.price.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('hotel.price.update', $priceList->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <h6 class="form-section-title"><i class="bi bi-building"></i> Data Harga Tiket</h6>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                                        value="{{ old('tanggal', $priceList->tanggal) }}" required>
                                    @error('tanggal')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="nama_hotel_select" class="form-label">Nama Hotel</label>

                                    <select name="nama_hotel" class="form-control" id="nama_hotel_select" required>
                                        @if (!$hotels->contains($priceList->nama_hotel))
                                            <option value="{{ $priceList->nama_hotel }}" selected>
                                                {{ $priceList->nama_hotel }}
                                            </option>
                                        @endif

                                        @foreach ($hotels as $namaHotel)
                                            <option value="{{ $namaHotel }}"
                                                {{ old('nama_hotel', $priceList->nama_hotel) == $namaHotel ? 'selected' : '' }}>
                                                {{ $namaHotel }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('nama_hotel')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                                    <select name="tipe_kamar" class="form-control" required>
                                        @foreach ($roomTypes as $tipe)
                                            <option value="{{ $tipe }}"
                                                {{ old('tipe_kamar', $priceList->tipe_kamar) == $tipe ? 'selected' : '' }}>
                                                {{ $tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipe_kamar')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="harga" id="harga"
                                        value="{{ old('harga', $priceList->harga) }}" required>
                                    @error('harga')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit"><i class="bi bi-check-circle"></i> Simpan Perubahan
                            Hotel</button>
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
                tags: true,
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

            var currentHotelName = '{{ $priceList->nama_hotel }}';
            var hotelExists = false;

            $('#nama_hotel_select option').each(function() {
                if ($(this).val() === currentHotelName) {
                    hotelExists = true;
                    return false;
                }
            });
        });
    </script>
@endpush
