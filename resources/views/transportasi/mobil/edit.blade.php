@extends('admin.master')
@section('title', 'Edit Data Mobil')
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
        --success-color: #28a745;
    }

    .service-create-container {
        max-width: 100vw;
        margin: 0 auto;
        padding: 1.5rem;
        background-color: #f8fafd;
    }

    .card {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .card-title {
        font-weight: 700;
        color: var(--haramain-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-col {
        flex: 1;
        min-width: 250px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.4rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: var(--haramain-secondary);
        box-shadow: 0 0 0 3px rgba(42,111,219,0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-secondary {
        background: white;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--hover-bg);
    }

    .btn-submit {
        background-color: var(--success-color);
        color: white;
    }

    .btn-submit:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40,167,69,0.3);
    }

    @media (max-width: 480px) {
        .service-create-container {
            padding: 1rem;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="service-create-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-pencil-square"></i> Edit Data Mobil
            </h5>
            <a href="{{ route('transportation.car.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('transportation.car.update', $Transportation->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $Transportation->nama }}" required>
                        </div>
                        <div class="form-col">
                            <label class="form-label">Kapasitas</label>
                            <input type="text" class="form-control" name="kapasitas" value="{{ $Transportation->kapasitas }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" class="form-control" name="fasilitas" value="{{ $Transportation->fasilitas }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" value="{{ $Transportation->harga }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
