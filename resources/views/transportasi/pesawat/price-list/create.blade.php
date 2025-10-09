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
        --checked-color: #2a6fdb;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
    }

    /* Pastikan tidak ada overflow horizontal */
    body {
        overflow-x: hidden;
    }

    .service-create-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 1rem;
        background-color: #f8fafd;
        box-sizing: border-box;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #fff;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
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

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
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
        margin-bottom: 1rem;
    }

    .form-col {
        flex: 1;
        min-width: 240px;
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
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--haramain-secondary);
        box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
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

    .btn-primary {
        background-color: var(--haramain-secondary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--haramain-primary);
    }

    .btn-secondary {
        background-color: white;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-submit {
        background-color: var(--success-color);
        color: white;
        width: 100%;
        justify-content: center;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .form-row {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .card-body {
            padding: 1rem;
        }

        .service-create-container {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .form-col {
            min-width: 100%;
        }
    }
</style>

<div class="service-create-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-plus-circle"></i> Tambah Hotel
            </h5>
            <a href="{{ route('price.list.ticket') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('price.list.ticket.post') }}" method="POST">
                @csrf

                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data harga tiket
                    </h6>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Tanggal berangkat</label>
                            <input type="date" class="form-control" name="tanggal_berangkat" required>
                        </div>

                        <div class="form-col">
                            <label class="form-label">Jam berangkat</label>
                            <input type="time" class="form-control" name="jam_berangkat" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" required>
                        </div>

                        <div class="form-col">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-circle"></i> Simpan data hotel
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
