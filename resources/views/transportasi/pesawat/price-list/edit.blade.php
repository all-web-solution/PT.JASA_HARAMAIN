@extends('admin.master')
@section('title', 'Edit Harga Tiket')

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
            min-height: 100vh;
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

        .form-control:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 219, 0.25);
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
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-pencil-square"></i> Edit Harga Tiket</h5>
                <a href="{{ route('price.list.ticket') }}" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            <form action="{{ route('price.list.ticket.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', $ticket->tanggal) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jam Berangkat</label>
                                <input type="time" name="jam_berangkat"
                                    class="form-control @error('jam_berangkat') is-invalid @enderror"
                                    value="{{ old('jam_berangkat', $ticket->jam_berangkat) }}" required>
                                @error('jam_berangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach (['Ekonomi', 'Bisnis', 'First Class', 'Promo'] as $kelas)
                                        <option value="{{ $kelas }}"
                                            {{ old('kelas', $ticket->kelas) == $kelas ? 'selected' : '' }}>
                                            {{ $kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Harga (SAR)</label>
                                <input type="number" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga', $ticket->harga) }}" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-submit"><i class="bi bi-save"></i> Update Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
