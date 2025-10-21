@extends('admin.master')
@section('title', 'Detail Handling Hotel')
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
            --background-light: #f8fafd;
        }

        /* Using the class from the container div for scope */
        .container.mt-4 {
            background-color: var(--background-light);
            padding: 2rem;
            max-width: 100vw;
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
        }

        /* Form & Detail Display Styles */
        .form-section {
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--border-color);
            margin-bottom: 1.5rem;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            color: var(--haramain-secondary);
        }

        .form-section p {
            font-size: 1rem;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .form-section p strong {
            color: var(--text-secondary);
            font-weight: 600;
            margin-right: 8px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .form-col {
            flex: 1;
            min-width: 200px;
        }

        .form-group .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .form-group img {
            border-radius: 8px;
            border: 2px solid var(--border-color);
            padding: 4px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 100%;
            height: auto;
        }

        .form-group img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 150px;
            background-color: var(--haramain-light);
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            color: var(--text-secondary);
            font-style: italic;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-eye"></i> Detail Handling Hotel
                </h5>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Detail Hotel
                    </h6>

                    <p><strong>Nama Hotel:</strong> {{ $hotel->nama }}</p>
                    <p><strong>Tanggal Check-in:</strong> {{ \Carbon\Carbon::parse($hotel->tanggal)->format('d F Y') }}</p>
                    <p><strong>Harga:</strong> Rp {{ $hotel->harga }}</p>
                    <p><strong>Pax:</strong> {{ $hotel->pax }}</p>

                    <div class="form-row" style="margin-top: 2rem;">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Foto Kode Booking</label>
                                @if ($hotel->kode_booking)
                                    <img src="{{ url('storage/' . $hotel->kode_booking) }}" alt="Kode Booking"
                                        class="img-fluid">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Foto Rumlis</label>
                                @if ($hotel->rumlis)
                                    <img src="{{ url('storage/' . $hotel->rumlis) }}" alt="Rumlis" class="img-fluid">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Identitas Koper</label>
                                @if ($hotel->identitas_koper)
                                    <img src="{{ url('storage/' . $hotel->identitas_koper) }}" alt="Identitas Koper"
                                        class="img-fluid">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
