@extends('admin.master')
@section('title', 'Edit Handling Pesawat')

@push('styles')
    <style>
        /* == SEMUA CSS DARI TEMPLATE ANDA == */
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

        .service-list-container {
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
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text-secondary);
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control[type="file"] {
            padding: 0.6rem 1rem;
        }

        .form-control[type="file"]:focus {
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 219, 0.25);
        }

        .form-control[readonly],
        .form-select[disabled] {
            background-color: #e9ecef;
            opacity: 1;
            cursor: not-allowed;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            margin-top: 2rem;
        }

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
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-submit:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger-color);
        }

        /* Preview Gambar */
        .image-preview {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            margin-top: 0.5rem;
        }

        .image-preview-placeholder {
            width: 120px;
            height: 90px;
            border-radius: 8px;
            background-color: var(--hover-bg);
            border: 1px dashed var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-airplane-fill"></i> Edit Handling Pesawat
                </h5>
                {{-- Arahkan kembali ke detail handling pesawat --}}
                <a href="{{ route('handling.handling.plane.show', $plane->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Controller mengirim: $plane, $handlings, $statuses --}}
            <form action="{{ route('handling.pesawat.update', $plane->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger"
                            style="background-color: rgba(220, 53, 69, 0.1); color: var(--danger-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- BARIS 1: HANDLING ID & NAMA BANDARA --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="handling_id" class="form-label">Travel</label>
                                <select id="handling_id" name="handling_id"
                                    class="form-select @error('handling_id') is-invalid @enderror" disabled>
                                    <option value="">Pilih Order Handling</option>
                                    @foreach ($handlings as $handling)
                                        <option value="{{ $handling->id }}"
                                            {{ old('handling_id', $plane->handling_id) == $handling->id ? 'selected' : '' }}>
                                            {{ $handling->service?->pelanggan?->nama_travel ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="handling_id" value="{{ $plane->handling_id }}">
                                @error('handling_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_bandara" class="form-label">Nama Bandara</label>
                                <input type="text" id="nama_bandara" name="nama_bandara"
                                    class="form-control @error('nama_bandara') is-invalid @enderror" disabled
                                    value="{{ old('nama_bandara', $plane->nama_bandara) }}">
                                @error('nama_bandara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BARIS 2: TANGGAL KEDATANGAN, JUMLAH JAMAAH, NAMA SUPIR --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kedatangan_jamaah" class="form-label">Tanggal Kedatangan Jamaah</label>
                                <input type="date" id="kedatangan_jamaah" name="kedatangan_jamaah"
                                    class="form-control @error('kedatangan_jamaah') is-invalid @enderror" disabled
                                    value="{{ old('kedatangan_jamaah', \Carbon\Carbon::parse($plane->kedatangan_jamaah)->format('Y-m-d')) }}">
                                @error('kedatangan_jamaah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_jamaah" class="form-label">Jumlah Jamaah</label>
                                <input type="number" id="jumlah_jamaah" name="jumlah_jamaah"
                                    class="form-control @error('jumlah_jamaah') is-invalid @enderror" disabled
                                    value="{{ old('jumlah_jamaah', $plane->jumlah_jamaah) }}">
                                @error('jumlah_jamaah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_supir" class="form-label">Nama Supir</label>
                                <input type="text" id="nama_supir" name="nama_supir"
                                    class="form-control @error('nama_supir') is-invalid @enderror"
                                    value="{{ old('nama_supir', $plane->nama_supir) }}">
                                @error('nama_supir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BARIS 3: FINANSIAL & SUPPLIER --}}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="supplier" class="form-label">Supplier</label>
                                <input type="text" id="supplier" name="supplier"
                                    class="form-control @error('supplier') is-invalid @enderror"
                                    value="{{ old('supplier', $plane->supplier) }}">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="harga_dasar" class="form-label">Harga Dasar</label>
                                <input type="number" step="0.01" id="harga_dasar" name="harga_dasar"
                                    class="form-control @error('harga_dasar') is-invalid @enderror"
                                    value="{{ old('harga_dasar', $plane->harga_dasar) }}">
                                @error('harga_dasar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <input type="number" step="0.01" id="harga_jual" name="harga_jual"
                                    class="form-control @error('harga_jual') is-invalid @enderror"
                                    value="{{ old('harga_jual', $plane->harga_jual) }}">
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga (Lama/Estimasi)</label>
                                <input type="number" step="0.01" id="harga" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga', $plane->harga) }}">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BARIS 4: STATUS & FILE UPLOADS --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="paket_info" class="form-label">Ganti Foto Paket Info</label>
                                <input type="file" id="paket_info" name="paket_info"
                                    class="form-control @error('paket_info') is-invalid @enderror">
                                @error('paket_info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($plane->paket_info)
                                    <a href="{{ url('storage/' . $plane->paket_info) }}" target="_blank">
                                        <img src="{{ url('storage/' . $plane->paket_info) }}" alt="Paket Info"
                                            class="image-preview">
                                    </a>
                                @else
                                    <div class="image-preview-placeholder">No Image</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="identitas_koper" class="form-label">Ganti Identitas Koper</label>
                                <input type="file" id="identitas_koper" name="identitas_koper"
                                    class="form-control @error('identitas_koper') is-invalid @enderror">
                                @error('identitas_koper')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($plane->identitas_koper)
                                    <a href="{{ url('storage/' . $plane->identitas_koper) }}" target="_blank">
                                        <img src="{{ url('storage/' . $plane->identitas_koper) }}" alt="Identitas Koper"
                                            class="image-preview">
                                    </a>
                                @else
                                    <div class="image-preview-placeholder">No Image</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $plane->status) == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="btn-container">
                        <a href="{{ route('handling.handling.plane.show', $plane->id) }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
