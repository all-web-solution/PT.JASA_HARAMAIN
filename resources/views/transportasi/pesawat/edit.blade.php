@extends('admin.master')
@section('title', 'Edit Penerbangan')

@push('styles')
    <style>
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --border-color: #d1e0f5;
            --background-light: #f8fafd;
        }

        .service-list-container {
            padding: 2rem;
            background-color: var(--background-light);
        }

        .card {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            background: #fff;
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #fff 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            gap: 10px;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
        }

        .btn-secondary {
            background: #fff;
            border: 1px solid var(--border-color);
            color: #6c757d;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-submit {
            background: var(--haramain-secondary);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: var(--haramain-primary);
        }

        .alert-danger {
            border-radius: 8px;
            padding: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-airplane-engines"></i> Edit Data Penerbangan</h5>
                <a href="{{ route('plane.show', $plane->service_id) }}" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- HAPUS enctype karena tidak ada upload file --}}
            <form action="{{ route('plane.update', $plane->id) }}" method="POST">
                @csrf
                @method('PUT')

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

                    {{-- Baris 1: Info Utama --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Travel / Pelanggan</label>
                            <select name="service_id" class="form-select"
                                style="background-color: #e9ecef; pointer-events: none;">
                                <option value="{{ $plane->service_id }}">{{ $plane->service->pelanggan->nama_travel }}
                                </option>
                            </select>
                            <input type="hidden" name="service_id" value="{{ $plane->service_id }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Maskapai</label>
                            <input type="text" name="maskapai" class="form-control"
                                value="{{ old('maskapai', $plane->maskapai) }}" required>
                        </div>
                    </div>

                    {{-- Baris 2: Rute & Tanggal --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Rute</label>
                            <input type="text" name="rute" class="form-control"
                                value="{{ old('rute', $plane->rute) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Keberangkatan</label>
                            <input type="date" name="tanggal_keberangkatan" class="form-control"
                                value="{{ old('tanggal_keberangkatan', $plane->tanggal_keberangkatan) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" name="jumlah_jamaah" class="form-control"
                                value="{{ old('jumlah_jamaah', $plane->jumlah_jamaah) }}" required>
                        </div>
                    </div>

                    {{-- Baris 3: Info Tambahan (Tiket & Supplier) --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            {{-- INPUT TEXT UNTUK TIKET --}}
                            <label class="form-label">Tiket</label>
                            <input type="text" name="tiket" class="form-control"
                                value="{{ old('tiket', $plane->tiket) }}" placeholder="LinkGdrive">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach (['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $plane->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris 4: Keuangan --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Supplier</label>
                            <input type="text" name="supplier" class="form-control"
                                value="{{ old('supplier', $plane->supplier) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Dasar</label>
                            <input type="number" name="harga_dasar" class="form-control"
                                value="{{ old('harga_dasar', $plane->harga_dasar) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control"
                                value="{{ old('harga_jual', $plane->harga_jual) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $plane->keterangan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
