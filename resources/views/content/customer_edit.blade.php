@extends('admin.master')
@section('title', 'Edit Order Dokumen')

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

        .form-control:focus,
        .form-select:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 219, 0.25);
        }

        /* Style untuk input disabled/readonly */
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
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-pencil-square"></i> Edit Order Dokumen
                </h5>
                {{-- Arahkan kembali ke index dokumen --}}
                <a href="{{ route('visa.document.customer') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Ganti $document dengan nama variabel Anda --}}
            <form action="{{ route('document.customer.update', $document->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger"
                            style="background-color: rgba(220, 53, 69, 0.1); color: var(--danger-color); border: 1px solid var(--danger-color); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- BARIS 1: SERVICE & DOKUMEN INDUK --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_id" class="form-label">Pelanggan (Travel)</label>
                                <select id="service_id" name="service_id"
                                    class="form-select @error('service_id') is-invalid @enderror" disabled>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id', $document->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->pelanggan?->nama_travel ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_id" class="form-label">Dokumen Induk</label>
                                <select id="document_id" name="document_id"
                                    class="form-select @error('document_id') is-invalid @enderror" disabled>
                                    <option value="">Pilih Dokumen Induk</option>
                                    @foreach ($documents as $doc)
                                        <option value="{{ $doc->id }}"
                                            {{ old('document_id', $document->document_id) == $doc->id ? 'selected' : '' }}>
                                            {{ $doc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('document_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BARIS 2: JENIS DOKUMEN (CHILD) & STATUS --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_children_id" class="form-label">Jenis Dokumen (Child)</label>
                                <select id="document_children_id" name="document_children_id"
                                    class="form-select @error('document_children_id') is-invalid @enderror" disabled>
                                    <option value="">Pilih Jenis Dokumen (Opsional)</option>
                                    @foreach ($documentChildrens as $child)
                                        <option value="{{ $child->id }}"
                                            {{ old('document_children_id', $document->document_children_id) == $child->id ? 'selected' : '' }}>
                                            {{ $child->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('document_children_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', $document->jumlah) }}" readonly>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BARIS 3: JUMLAH, HARGA (LAMA), SUPPLIER --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga" class="form-label">Estimasi Harga</label>
                                <input type="number" step="0.01" id="harga" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga', $document->harga) }}" readonly>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $document->status) == $status ? 'selected' : '' }}>
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

                    {{-- BARIS 4: HARGA DASAR & JUAL --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier" class="form-label">Supplier</label>
                                <input type="text" id="supplier" name="supplier"
                                    class="form-control @error('supplier') is-invalid @enderror"
                                    value="{{ old('supplier', $document->supplier) }}">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga_dasar" class="form-label">Harga Dasar</label>
                                <input type="number" step="0.01" id="harga_dasar" name="harga_dasar"
                                    class="form-control @error('harga_dasar') is-invalid @enderror"
                                    value="{{ old('harga_dasar', $document->harga_dasar) }}">
                                @error('harga_dasar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <input type="number" step="0.01" id="harga_jual" name="harga_jual"
                                    class="form-control @error('harga_jual') is-invalid @enderror"
                                    value="{{ old('harga_jual', $document->harga_jual) }}">
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="btn-container">
                        <a href="{{ route('visa.document.customer') }}" class="btn btn-secondary">
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
