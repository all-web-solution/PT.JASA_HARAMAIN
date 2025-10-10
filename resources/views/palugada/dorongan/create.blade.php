@extends('admin.master')
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
        }

        .service-create-container {
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

        /* Form Styles */
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

        .form-section-title i {
            color: var(--haramain-secondary);
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
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--haramain-secondary);
            box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
        }

        .form-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-col {
            flex: 1;
        }

        /* Service Selection */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .service-item,
        .transport-item,
        .service-car,
        .document-item,
        .child-item .content-item,
        .visa-item,
        .vaksin-item,
        .service-tour,
        .service-tour-makkah,
        .service-tour-madinah,
        .service-tour-al-ula,
        .service-tour-thoif {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: white;
        }

        .service-item:hover,
        .transport-item:hover,
        .service-car:hover,
        .document-item:hover,
        .child-item:hover,
        .content-item:hover,
        .visa-item:hover,
        .vaksin-item:hover,
        .service-tour:hover,
        .service-tour-makkah:hover,
        .service-tour-madinah:hover,
        .service-tour-al-ula:hover,
        .service-tour-thoif:hover {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-item.selected,
        .transport-item.selected,
        .service-car.selected,
        .document-item.selected,
        .child-item.selected,
        .content-item.selected,
        .visa-item.selected,
        .vaksin-item.selected,
        .service-tour.selected,
        .service-tour-makkah.selected,
        .service-tour-madinah.selected,
        .service-tour-al-ula.selected,
        .service-tour-thoif.selected {
            border-color: var(--haramain-secondary);
            background-color: var(--haramain-light);
        }

        .service-icon {
            font-size: 2rem;
            color: var(--haramain-secondary);
            margin-bottom: 0.75rem;
        }

        .service-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .service-desc {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Detail Form */
        .detail-form {
            background-color: var(--haramain-light);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .detail-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-title {
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-title i {
            color: var(--haramain-secondary);
        }

        /* Buttons */
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
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
        }

        .btn-submit {
            background-color: var(--success-color);
            color: white;
        }

        .btn-submit:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .transportasi-item {
            display: flex
        }

        #pesawat,
        #bis,
        #visa,
        #vaksin,
        #sikopatur,
        #bandara,
        #hotel,
        #pendamping-details,
        #konten-details,
        #reyal-details,
        #tour-details,
        #meals-details,
        #dorongan-details,
        #waqaf-details,
        #badal-details {
            display: none;
            margin-top: 20px;
        }

        .cars,
        .tours {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .hidden {
            display: none;
        }

        .document-item,
        .child-item {
            border: 1px solid #ccc;
            padding: 12px;
            cursor: pointer;
            border-radius: 10px;
            text-align: center;
            transition: 0.2s;
        }

        .document-item.active,
        .child-item.active {
            border-color: #28a745;
            background: #f0fff4;
        }

        .service-desc {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }



        .visa-item,
        .vaksin-item {
            display: block;
            border: 2px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .service-vaksin-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .service-vaksin-item {
            display: block;
            border: 2px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .visa-item.active,
        .vaksin-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .pendamping-wrapper {
            display: block;
            /* full width */
            margin-bottom: 10px;
        }

        .pendamping-item {
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
        }

        .pendamping-item.active {
            border-color: #1a4b8c;
            background-color: #e6f0fa;
        }

        .pendamping-form {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border-left: 3px solid #1a4b8c;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .hidden {
            display: none;
        }

        .content-item.active {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            background: #f0f8ff;
        }

        .service-tour,
        .transport-option {
            display: block;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .service-tour.active,
        .transport-option.active {
            border-color: #0d6efd;
            background: #e9f2ff;
        }

        .hidden {
            display: none;
        }

        #meal-item,
        .content-item {
            background-color: #fff;
            margin: 10px 0px;
            padding: 10px;
            border-radius: 7px;

        }
    </style>
@endpush
@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle"></i>Tambah Dorongan
                </h5>
                <a href="{{ route('dorongan.index') }}" class="btn btn-secondary">
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
                <form method="POST" action="{{ route('dorongan.store') }}">
                    @csrf
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control" name="price" required>
                                </div>
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
