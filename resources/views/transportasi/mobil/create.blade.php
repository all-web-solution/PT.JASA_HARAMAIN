@extends('admin.master')
@section('title', 'Tambah Hotel')
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
        --danger-color: #dc3545;
    }

    .service-create-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 1.5rem;
        background-color: #f8fafd;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
        background-color: #fff;
    }

    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .card-title {
        font-weight: 700;
        color: var(--haramain-primary);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-section-title {
        font-size: 1.1rem;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-col {
        flex: 1;
        min-width: 250px;
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
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: var(--haramain-secondary);
        box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-primary {
        background-color: var(--haramain-secondary);
        color: #fff;
    }

    .btn-primary:hover {
        background-color: var(--haramain-primary);
    }

    .btn-secondary {
        background-color: #fff;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background-color: var(--haramain-light);
    }

    .btn-submit {
        background-color: var(--success-color);
        color: white;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    /* ✅ RESPONSIVE FIX */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .form-col {
            min-width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .service-create-container {
            padding: 1rem;
        }

        .card-header {
            padding: 1rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.9rem;
        }

        button, .btn {
            font-size: 0.9rem;
        }
    }
</style>

<div class="service-create-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="bi bi-plus-circle"></i> Tambah Hotel</h5>
            <a href="{{ route('transportation.car.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('transportation.car.store') }}" method="POST">
                @csrf
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Kendaraan
                    </h6>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="form-col">
                            <label class="form-label">Kapasitas</label>
                            <input type="text" class="form-control" name="kapasitas" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" class="form-control" name="fasilitas" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit w-100">
                    <i class="bi bi-check-circle"></i> Simpan Data Kendaraan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
