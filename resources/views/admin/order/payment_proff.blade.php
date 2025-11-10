@extends('admin.master')
@section('title', 'Bukti Pembayaran: ' . $order->service->pelanggan->nama_travel)

@push('styles')
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
            --background-light: #f8fafd;
            /* Ditambahkan dari style lain */
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
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
            flex-wrap: wrap;
            gap: 1rem;
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
            /* Style untuk form */
        }

        /* == Form Styles (Dari referensi edit) == */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control {
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
        }

        .form-control[type="file"] {
            padding: 0.6rem 1rem;
        }

        .form-control:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 219, 0.25);
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
            cursor: pointer;
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

        .form-control.is-invalid {
            border-color: var(--danger-color);
        }

        /* == Table Styles == */
        .table-responsive {
            padding: 0 1.5rem 1.5rem;
        }

        .table-card-body {
            padding: 0;
            /* Hapus padding untuk tabel */
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: left;
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .customer-info {
            display: flex;
            align-items: center;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--haramain-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--haramain-secondary);
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .customer-details {
            line-height: 1.4;
        }

        .customer-name {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        .customer-type {
            font-size: 0.75rem;
            color: var(--text-secondary);
            background-color: var(--haramain-light);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: var(--hover-bg);
            border-color: var(--haramain-secondary);
            color: var(--haramain-secondary);
        }

        /* ... [CSS Responsif dari file index Anda] ... */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
                justify-content: center;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid var(--border-color);
            }

            .table tbody td {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: center;
                text-align: left;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody tr td:last-child {
                border-bottom: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--haramain-primary);
                margin-bottom: 0.5rem;
                font-size: 0.8rem;
                text-transform: uppercase;
            }

            .table tbody td:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .table tbody td:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- Tampilkan Pesan Sukses atau Error --}}
        @if (session('success'))
            <div class="alert"
                style="background-color: var(--success-bg, #d1e7dd); border-color: var(--success-color, #a3cfbb); color: var(--success-color, #0f5132); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert"
                style="background-color: var(--danger-bg, #f8d7da); border-color: var(--danger-color, #f5c2c7); color: var(--danger-color, #842029); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle"></i> Tambah Bukti Pembayaran Baru
                </h5>
                <a href="{{ route('admin.order') }}" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Detail Payment
                </a>
            </div>
            <div class="card-body">
                {{-- Form dari file create --}}
                <form action="{{ route('payment.proff.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="foto" class="form-label">Upload Bukti Transfer</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                            name="foto" accept="image/*" required>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-save me-1"></i> Simpan Bukti
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-list-check"></i>
                    Daftar Bukti Transfer {{ $order->service->pelanggan->nama_travel ?? 'Customer' }}
                </h5>
                {{-- Tombol 'Tambah' di sini dihapus karena form sudah di atas --}}
            </div>

            <div class="card-body table-card-body"> {{-- Ganti class card-body --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Customer</th>
                                <th>Nomor Telepon</th>
                                <th>Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paymentPreff as $payment)
                                <tr>
                                    <td data-label="No.">{{ $loop->iteration }}</td>
                                    <td data-label="Customer">
                                        <div class="customer-info">
                                            <div class="customer-avatar">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div class="customer-details">
                                                <div class="customer-name">
                                                    {{ $order->service->pelanggan->nama_travel ?? '-' }}</div>
                                                <div class="customer-type">
                                                    {{ $order->service->pelanggan->penanggung_jawab ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Nomor telepon">{{ $order->service->pelanggan->phone ?? '-' }}</td>
                                    <td data-label="Bukti pembayaran">
                                        <a href="{{ url('storage/' . $payment->payment_proof) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $payment->payment_proof) }}"
                                                alt="Bukti Pembayaran"
                                                style="max-width: 100px; max-height: 100px; border-radius: 8px;">
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; border-radius: 8px;">
                                        Belum ada bukti pembayaran yang diupload.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
