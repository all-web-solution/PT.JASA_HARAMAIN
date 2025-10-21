@extends('admin.master')

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

        .service-grid,
        .cars,
        .tours {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .service-option,
        .service-item,
        .transport-item,
        .type-item,
        .service-car,
        .handling-item,
        .document-item,
        .child-item,
        .content-item,
        .visa-item,
        .vaksin-item,
        .service-tour,
        .service-tour-makkah,
        .service-tour-madinah,
        .service-tour-al-ula,
        .service-tour-thoif,
        .pendamping-item,
        .meal-item,
        .dorongan-item,
        .wakaf-item,
        .transport-option {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: white;
        }

        .service-option:hover,
        .service-item:hover,
        .transport-item:hover,
        .type-item:hover,
        .service-car:hover,
        .handling-item:hover,
        .document-item:hover,
        .child-item:hover,
        .content-item:hover,
        .visa-item:hover,
        .vaksin-item:hover,
        .service-tour:hover,
        .service-tour-makkah:hover,
        .service-tour-madinah:hover,
        .service-tour-al-ula:hover,
        .service-tour-thoif:hover,
        .pendamping-item:hover,
        .meal-item:hover,
        .dorongan-item:hover,
        .wakaf-item:hover,
        .transport-option:hover {
            border-color: var(--haramain-secondary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-option.selected,
        .service-item.selected,
        .transport-item.selected,
        .type-item.selected,
        .handling-item.selected,
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
        .service-tour-thoif.selected,
        .pendamping-item.selected,
        .meal-item.selected,
        .dorongan-item.selected,
        .wakaf-item.selected,
        .transport-option.selected {
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
            color: var(--text-secondary);
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

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-grid,
            .cars,
            .tours {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .card-title {
                display: none;
            }
        }

        .hidden {
            display: none !important;
        }

        .card-reyal.selected {
            border: 2px solid var(--haramain-secondary);
            background-color: var(--haramain-light);
        }
    </style>

    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle"></i>Tambah Permintaan Service Baru
                </h5>
                <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-control" name="travel" id="travel-select" required>
                                        <option value="" disabled selected>Pilih Travel</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                                data-email="{{ $pelanggan->email }}" data-telepon="{{ $pelanggan->phone }}">
                                                {{ $pelanggan->nama_travel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly id="penanggung">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required id="email">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" required id="phone">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                        </h6>
                        <div class="service-grid">
                            @foreach ([
            'transportasi' => ['icon' => 'bi-airplane', 'name' => 'Transportasi', 'desc' => 'Tiket & Transport'],
            'hotel' => ['icon' => 'bi-building', 'name' => 'Hotel', 'desc' => 'Akomodasi'],
            'dokumen' => ['icon' => 'bi-file-text', 'name' => 'Dokumen', 'desc' => 'Visa & Administrasi'],
            'handling' => ['icon' => 'bi-briefcase', 'name' => 'Handling', 'desc' => 'Bandara & Hotel'],
            'pendamping' => ['icon' => 'bi-people', 'name' => 'Pendamping', 'desc' => 'Tour Leader & Mutawwif'],
            'konten' => ['icon' => 'bi-camera', 'name' => 'Konten', 'desc' => 'Dokumentasi'],
            'reyal' => ['icon' => 'bi-currency-exchange', 'name' => 'Reyal', 'desc' => 'Penukaran Mata Uang'],
            'tour' => ['icon' => 'bi-geo-alt', 'name' => 'Tour', 'desc' => 'City Tour & Ziarah'],
            'meals' => ['icon' => 'bi-egg-fried', 'name' => 'Meals', 'desc' => 'Makanan'],
            'dorongan' => ['icon' => 'bi-basket', 'name' => 'Dorongan', 'desc' => 'Bagi penyandang disabilitas'],
            'waqaf' => ['icon' => 'bi-gift', 'name' => 'Waqaf', 'desc' => 'Sedekah & Waqaf'],
            'badal' => ['icon' => 'bi-gift', 'name' => 'Badal Umrah', 'desc' => 'Umrah Badal'],
        ] as $key => $service)
                                <div class="service-item" data-service="{{ $key }}">
                                    <div class="service-icon"><i class="bi {{ $service['icon'] }}"></i></div>
                                    <div class="service-name">{{ $service['name'] }}</div>
                                    <div class="service-desc">{{ $service['desc'] }}</div>
                                    <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>

                        {{-- TRANSPORTASI FORM --}}
                        <div class="detail-form hidden" id="transportasi-details">
                            <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="transport-item" data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" class="d-none">
                                    </div>
                                    <div class="transport-item" data-transportasi="bus">
                                        <div class="service-name">Transportasi darat</div>
                                        <input type="checkbox" name="transportation[]" value="bus" class="d-none">
                                    </div>
                                </div>
                                <div class="form-group hidden" data-transportasi="airplane" id="pesawat">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        <div class="ticket-form bg-white p-3 border mb-3">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal Keberangkatan</label>
                                                    <input type="date" class="form-control" name="tanggal[]">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Rute</label>
                                                    <input type="text" class="form-control" name="rute[]"
                                                        placeholder="Contoh: CGK - JED">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Maskapai</label>
                                                    <input type="text" class="form-control" name="maskapai[]"
                                                        placeholder="Nama maskapai">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Keterangan</label>
                                                    <input type="text" class="form-control" name="keterangan[]"
                                                        placeholder="Keterangan">
                                                </div>
                                                <div class="col-12">
                                                    <label for="paspor-tiket-0" class="form-label">Jumlah (Jamaah)</label>
                                                    <input type="number" class="form-control" id="paspor-tiket-0"
                                                        name="jumlah[]">
                                                </div>
                                            </div>
                                            <div class="mt-3 text-end">
                                                <button type="button" class="btn btn-danger btn-sm removeTicket">Hapus
                                                    Tiket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden" data-transportasi="bus" id="bis">
                                    <label class="form-label">Transportasi darat</label>
                                    <button type="button" class="btn btn-submit" id="add-transport-btn">Tambah
                                        Transportasi</button>
                                    <div id="new-transport-forms">
                                        <div class="transport-set card p-3 mt-3" data-index="0">
                                            <div class="cars">
                                                @foreach ($transportations as $i => $data)
                                                    <div class="service-car" data-id="{{ $data->id }}"
                                                        data-routes='@json($data->routes)'
                                                        data-name="{{ $data->nama }}"
                                                        data-price="{{ $data->harga }}">
                                                        <div class="service-name">{{ $data->nama }}</div>
                                                        <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                                                        <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                                                        <div class="service-desc">Harga:
                                                            {{ number_format($data->harga) }}/hari</div>
                                                        {{-- <input type="radio" name="transportation_id[0]"
                                                            value="{{ $data->id }}"> --}}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="route-select hidden">
                                                <label class="form-label mt-2">Pilih Rute:</label>
                                                <select name="rute_id[0]" class="form-control">
                                                    <option value="">-- Pilih Rute --</option>
                                                </select>
                                            </div>
                                            <div class="mt-2 text-end">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HOTEL FORM --}}
                        <div class="detail-form hidden" id="hotel-details">
                            <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-2" id="addHotel">Tambah
                                Hotel</button>
                            <div id="hotelWrapper">
                                <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Tanggal Checkin</label>
                                            <input type="date" class="form-control" name="tanggal_checkin[0]">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Tanggal Checkout</label>
                                            <input type="date" class="form-control" name="tanggal_checkout[0]">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Nama Hotel</label>
                                            <input type="text" class="form-control" name="nama_hotel[0]"
                                                placeholder="Nama hotel" data-field="nama_hotel">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Tipe Kamar</label>
                                            <div class="service-grid">
                                                @foreach ($types as $type)
                                                    <div class="type-item" data-type-id="{{ $type->id }}"
                                                        data-price="{{ $type->jumlah }}"
                                                        data-name="{{ $type->nama_tipe }}">
                                                        <div class="service-name">{{ $type->nama_tipe }}</div>
                                                        <input type="checkbox" name="type[]"
                                                            value="{{ $type->nama_tipe }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="type-input-container"></div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label">Jumlah kamar</label>
                                        <input type="number" class="form-control" name="jumlah_kamar[0]"
                                            min="0">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label">Type custom special room</label>
                                        <input type="number" class="form-control" name="type_custom_special_room[0]"
                                            min="0">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label">Jumlah kasur</label>
                                        <input type="number" class="form-control" name="jumlah_kasur[0]"
                                            min="0">
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                                            Hotel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DOKUMEN FORM --}}
                        <div class="detail-form hidden" id="dokumen-details">
                            <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($documents as $document)
                                        <div class="document-item" data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}"
                                            data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                            <div class="service-name">{{ $document->name }}</div>
                                            <input type="checkbox" name="dokumen_id[]" id=""
                                                value="{{ $document->id }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="document-forms-container">
                                @foreach ($documents as $document)
                                    @if ($document->childrens->isNotEmpty())
                                        <div class="form-group hidden document-child-form"
                                            data-parent-id="{{ $document->id }}">
                                            <label class="form-label">{{ $document->name }}</label>
                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    <div class="child-item" data-child-id="{{ $child->id }}"
                                                        data-price="{{ $child->price }}"
                                                        data-name="{{ $child->name }}">
                                                        <div class="child-name">{{ $child->name }}</div>
                                                        <div class="child-name">Rp. {{ number_format($child->price) }}
                                                        </div>
                                                        <input type="checkbox" name="child_documents[]" id=""
                                                            value="{{ $child->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group hidden document-base-form"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}"
                                            data-price="{{ $document->price }}" data-name="{{ $document->name }}">
                                            <label class="form-label">Jumlah {{ $document->name }}</label>
                                            <input type="number" class="form-control"
                                                name="jumlah_doc_{{ $document->id }}" min="1">


                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- HANDLING FORM --}}
                        <div class="detail-form hidden" id="handling-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="handling-item" data-handling="hotel" data-name="Hotel Handling">
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" class="d-none">
                                    </div>
                                    <div class="handling-item" data-handling="bandara" data-name="Bandara Handling">
                                        <div class="service-name">Bandara</div>
                                        <input type="checkbox" name="handlings[]" value="bandara" class="d-none">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden" id="hotel-handling-form">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Hotel</label><input
                                            type="text" class="form-control" name="nama_hotel_handling"></div>
                                    <div class="form-col"><label class="form-label">Tanggal</label><input type="date"
                                            class="form-control" name="tanggal_hotel_handling"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_hotel_handling"></div>
                                    <div class="form-col"><label class="form-label">Pax</label><input type="text"
                                            class="form-control" name="pax_hotel_handling"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kode Booking</label><input type="file"
                                        class="form-control" name="kode_booking_hotel_handling">
                                    <label class="form-label">Room List</label><input type="file" class="form-control"
                                        name="rumlis_hotel_handling">
                                    <label class="form-label">Identitas Koper</label><input type="file"
                                        class="form-control" name="identitas_hotel_handling">
                                </div>
                            </div>
                            <div class="form-group hidden" id="bandara-handling-form">
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Bandara</label><input
                                            type="text" class="form-control" name="nama_bandara_handling"></div>
                                    <div class="form-col"><label class="form-label">Jumlah Jamaah</label><input
                                            type="text" class="form-control" name="jumlah_jamaah_handling"></div>
                                    <div class="form-col"><label class="form-label">Harga</label><input type="text"
                                            class="form-control" name="harga_bandara_handling"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Kedatangan Jamaah</label><input
                                            type="date" class="form-control" name="kedatangan_jamaah_handling"></div>
                                    <div class="form-col"><label class="form-label">Paket Info</label><input
                                            type="file" class="form-control" name="paket_info"></div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col"><label class="form-label">Nama Sopir</label><input
                                            type="text" class="form-control" name="nama_supir"></div>
                                    <div class="form-col"><label class="form-label">Identitas Koper</label><input
                                            type="file" class="form-control" name="identitas_koper_bandara_handling">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING FORM --}}
                        <div class="detail-form hidden" id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Pendamping</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($guides as $guide)
                                        <div class="pendamping-item" data-id="{{ $guide->id }}"
                                            data-price="{{ $guide->harga }}" data-name="{{ $guide->nama }}"
                                            data-type="pendamping">
                                            <div class="service-name">{{ $guide->nama }}</div>
                                            <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    <div id="form-pendamping-{{ $guide->id }}" class="form-group hidden">
                                        <label class="form-label">Jumlah {{ $guide->nama }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $guide->id }}" data-name="{{ $guide->nama }}"
                                            data-price="{{ $guide->harga }}" data-type="pendamping"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="1">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form hidden" id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Content</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($contents as $content)
                                        <div class="content-item" data-id="{{ $content->id }}"
                                            data-name="{{ $content->name }}" data-price="{{ $content->price }}"
                                            data-type="konten">
                                            <div class="service-name">{{ $content->name }}</div>
                                            <div class="service-desc">Rp. {{ number_format($content->price) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    <div id="form-konten-{{ $content->id }}" class="form-group hidden">
                                        <label class="form-label">Jumlah {{ $content->name }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $content->id }}" data-name="{{ $content->name }}"
                                            data-price="{{ $content->price }}" data-type="konten"
                                            name="jumlah_konten[{{ $content->id }}]" min="1">
                                        <label for="keterangan_konten" class="form-label mt-3">Keterangan</label>
                                        <input type="text" class="form-control"
                                            name="keterangan_konten[{{ $content->id }}]">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form hidden" id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Penukaran mata uang</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal" data-reyal-type="tamis">
                                        <h5>Tamis</h5>
                                        <p>Rupiah → Reyal</p>
                                        {{-- <input type="radio" name="tipe" value="tamis"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal" data-reyal-type="tumis">
                                        <h5>Tumis</h5>
                                        <p>Reyal → Rupiah</p>
                                        {{-- <input type="radio" name="tipe" value="tumis"> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="detail-form mt-3 hidden" id="form-tamis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Rupiah → Reyal</h6>
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis"
                                        readonly>
                                </div>
                            </div>
                            <div class="detail-form mt-3 hidden" id="form-tumis">
                                <h6><i class="bi bi-arrow-down-up"></i> Konversi Reyal → Rupiah</h6>
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis"
                                        readonly>
                                </div>
                            </div>
                        </div>


                        {{-- TOUR FORM --}}
                        <div class="detail-form hidden" id="tour-details">
                            <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            <div class="detail-section">
                                <div class="service-grid">
                                    @foreach ($tours as $tour)
                                        <div class="service-tour selectable-item" data-id="{{ $tour->id }}"
                                            data-name="{{ $tour->name }}">
                                            <div class="service-name">{{ $tour->name }}</div>
                                            <input type="checkbox" name="tour_ids[]" value="{{ $tour->id }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tours as $tour)
                                <div id="tour-{{ $tour->id }}-form" class="tour-form hidden">
                                    <h6 class="detail-title">Transportasi untuk Tour {{ $tour->name }}</h6>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Tour</label>
                                        <input type="date" class="form-control"
                                            name="tanggal_tour[{{ $tour->id }}]">
                                    </div>
                                    <div class="service-grid">
                                        @foreach ($transportations as $trans)
                                            <div class="transport-option selectable-item"
                                                data-tour-id="{{ $tour->id }}" data-trans-id="{{ $trans->id }}"
                                                data-price="{{ $trans->harga }}" data-tour-name="{{ $tour->name }}"
                                                data-trans-name="{{ $trans->nama }}">
                                                <div class="service-name">{{ $trans->nama }}</div>
                                                <div class="service-desc">Harga: Rp {{ number_format($trans->harga) }}
                                                </div>
                                                {{-- <input type="checkbox" name="tour_transport[{{ $tour->id }}]"
                                                    value="{{ $trans->id }}"> --}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- MEALS FORM --}}
                        <div class="detail-form hidden" id="meals-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Makanan</h6>
                            <div class="service-grid">
                                @foreach ($meals as $meal)
                                    <div class="meal-item" data-id="{{ $meal->id }}"
                                        data-name="{{ $meal->name }}" data-price="{{ $meal->price }}"
                                        data-type="meal">
                                        <div class="service-name">{{ $meal->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($meals as $meal)
                                    <div id="form-meal-{{ $meal->id }}" class="form-group hidden">
                                        <label class="form-label">Jumlah {{ $meal->name }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $meal->id }}" data-name="{{ $meal->name }}"
                                            data-price="{{ $meal->price }}" data-type="meal"
                                            name="jumlah_meals[{{ $meal->id }}]" min="1">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DORONGAN FORM --}}
                        <div class="detail-form hidden" id="dorongan-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Dorongan</h6>
                            <div class="service-grid">
                                @foreach ($dorongan as $item)
                                    <div class="dorongan-item" data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}" data-price="{{ $item->price }}"
                                        data-type="dorongan">
                                        <div class="service-name">{{ $item->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($dorongan as $item)
                                    <div id="form-dorongan-{{ $item->id }}" class="form-group hidden">
                                        <label class="form-label">Jumlah {{ $item->name }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                            data-price="{{ $item->price }}" data-type="dorongan"
                                            name="jumlah_dorongan[{{ $item->id }}]" min="1">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WAQAF FORM --}}
                        <div class="detail-form hidden" id="waqaf-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Waqaf</h6>
                            <div class="service-grid">
                                @foreach ($wakaf as $item)
                                    <div class="wakaf-item" data-id="{{ $item->id }}"
                                        data-name="{{ $item->nama }}" data-price="{{ $item->harga }}"
                                        data-type="wakaf">
                                        <div class="service-name">{{ $item->nama }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                                        <input type="checkbox" name="wakaf_id" value="{{ $item->id }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($wakaf as $item)
                                    <div id="form-wakaf-{{ $item->id }}" class="form-group hidden">
                                        <label class="form-label">Jumlah {{ $item->nama }}</label>
                                        <input type="number" class="form-control jumlah-item"
                                            data-id="{{ $item->id }}" data-name="{{ $item->nama }}"
                                            data-price="{{ $item->harga }}" data-type="wakaf"
                                            name="jumlah_wakaf[{{ $item->id }}]" min="1">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- BADAL UMRAH FORM --}}
                        <div class="detail-form hidden" id="badal-details">
                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Badal Umrah</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-2" id="addBadal">Tambah
                                Badal</button>
                            <div id="badalWrapper">
                                <div class="badal-form bg-white p-3 border mb-3" data-index="0">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Nama yang dibadalkan</label>
                                        <input type="text" class="form-control nama_badal" name="nama_badal[0]">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label">Harga</label>
                                        <input type="number" class="form-control harga_badal" name="harga_badal[0]"
                                            min="0">
                                    </div>
                                    <div class="mt-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                                            Badal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-section p-3" id="cart-total-price" style="display: none;">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail produk yang dipilih
                        </h6>
                        <ul id="cart-items" class="list-group mt-2"></ul>
                        <div class="mt-3 text-end">
                            <strong>Total:
                                <input type="hidden" name="total_amount" id="cart-total" value="0">
                                <span id="cart-total-text">Rp. 0</span>
                            </strong>
                        </div>
                    </div> --}}

                    <div class="form-actions">
                        <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <script> ... </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = {};
            const cartSection = document.getElementById("cart-total-price");
            const cartItemsList = document.getElementById("cart-items");
            const cartTotalInput = document.getElementById("cart-total");
            const cartTotalText = document.getElementById("cart-total-text");
            let hotelCounter = 0;
            let badalCounter = 0;
            let transportCounter = 0;
            let ticketCounter = 0;

            function updateCartUI() {
                cartItemsList.innerHTML = "";
                let totalAll = 0;
                const items = Object.values(cart).filter(item => item && item.total >= 0 && item.qty > 0);

                items.forEach(item => {
                    totalAll += item.total;
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "d-flex", "justify-content-between",
                        "align-items-center");
                    li.innerHTML = `
                    <div>
                        <strong>${item.name}</strong>
                        <small class="text-muted d-block">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</small>
                    </div>
                    <span>Rp ${item.total.toLocaleString('id-ID')}</span>
                `;
                    cartItemsList.appendChild(li);
                });

                cartTotalInput.value = totalAll;
                cartTotalText.textContent = `Rp ${totalAll.toLocaleString('id-ID')}`;
                cartSection.style.display = items.length > 0 ? "block" : "none";
            }

            function updateItemInCart(key, name, qty, price) {
                if (qty > 0 && price >= 0 && name) {
                    cart[key] = {
                        name: name,
                        qty: qty,
                        price: price,
                        total: qty * price
                    };
                } else {
                    delete cart[key];
                }
                updateCartUI();
            }

            // --- Data Travel Section ---
            document.getElementById('travel-select').addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                document.getElementById('penanggung').value = option.dataset.penanggung || '';
                document.getElementById('email').value = option.dataset.email || '';
                document.getElementById('phone').value = option.dataset.telepon || '';
            });

            // --- Master Service Selection ---
            document.querySelectorAll('.service-item').forEach(item => {
                item.addEventListener('click', () => {
                    const serviceType = item.dataset.service;
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    const detailForm = document.getElementById(`${serviceType}-details`);
                    item.classList.toggle('selected');
                    checkbox.checked = item.classList.contains('selected');
                    if (detailForm) {
                        detailForm.classList.toggle('hidden');
                        // ADDED: Smooth scroll when a service is selected and its form is shown
                        if (!detailForm.classList.contains('hidden')) {
                            detailForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // --- Add/Remove Dynamic Forms (Buttons) ---
            document.getElementById("addTicket").addEventListener("click", () => {
                ticketCounter++;
                const ticketWrapper = document.getElementById("ticketWrapper");
                const newForm = document.createElement('div');
                newForm.classList.add("ticket-form", "bg-white", "p-3", "border", "mb-3");
                newForm.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Keberangkatan</label><input type="date" class="form-control" name="tanggal[]"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text" class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text" class="form-control" name="maskapai[]" placeholder="Nama maskapai"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan"></div>
                    <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number" class="form-control" name="jumlah[]"></div>
                </div>
                <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus Tiket</button></div>
            `;
                ticketWrapper.appendChild(newForm);
            });

            document.getElementById("add-transport-btn").addEventListener("click", function() {
                transportCounter++;
                const wrapper = document.getElementById("new-transport-forms");
                const template = `
                <div class="transport-set card p-3 mt-3" data-index="${transportCounter}">
                    <div class="cars">
                        @foreach ($transportations as $data)
                            <div class="service-car" data-id="{{ $data->id }}" data-routes='@json($data->routes)' data-name="{{ $data->nama }}" data-price="{{ $data->harga }}"><div class="service-name">{{ $data->nama }}</div><div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div><div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div><div class="service-desc">Harga: {{ number_format($data->harga) }}/hari</div><input type="radio" name="transportation_id[${transportCounter}]" value="{{ $data->id }}" class="d-none"></div>
                        @endforeach
                    </div>
                    <div class="route-select hidden"><label class="form-label mt-2">Pilih Rute:</label><select name="rute_id[${transportCounter}]" class="form-control"><option value="">-- Pilih Rute --</option></select></div>
                    <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button></div>
                </div>
            `;
                wrapper.insertAdjacentHTML('beforeend', template);
            });

            document.getElementById("addHotel").addEventListener("click", () => {
                hotelCounter++;
                const hotelWrapper = document.getElementById("hotelWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("hotel-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = hotelCounter;
                newForm.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkin</label><input type="date" class="form-control" name="tanggal_checkin[${hotelCounter}]"></div>
                    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkout</label><input type="date" class="form-control" name="tanggal_checkout[${hotelCounter}]"></div>
                    <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text" class="form-control" name="nama_hotel[${hotelCounter}]" placeholder="Nama hotel" data-field="nama_hotel"></div>
                    <div class="col-12"><label class="form-label fw-semibold">Tipe Kamar</label><div class="service-grid">
                        @foreach ($types as $type)
                            <div class="type-item" data-type-id="{{ $type->id }}" data-price="{{ $type->jumlah }}" data-name="{{ $type->nama_tipe }}"><div class="service-name">{{ $type->nama_tipe }}</div></div>
                        @endforeach
                    </div><div class="type-input-container"></div></div>
                </div>
                <div class="form-group mt-2"><label class="form-label">Harga Total (untuk Divisi Hotel)</label><input type="number" class="form-control" name="harga_total_hotel[${hotelCounter}]" min="0"></div>
                <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus Hotel</button></div>
            `;
                hotelWrapper.appendChild(newForm);
            });

            document.getElementById("addBadal").addEventListener("click", () => {
                badalCounter++;
                const badalWrapper = document.getElementById("badalWrapper");
                const newForm = document.createElement("div");
                newForm.classList.add("badal-form", "bg-white", "p-3", "border", "mb-3");
                newForm.dataset.index = badalCounter;
                newForm.innerHTML = `
                <div class="form-group mb-2"><label class="form-label">Nama yang dibadalkan</label><input type="text" class="form-control nama_badal" name="nama_badal[${badalCounter}]"></div>
                <div class="form-group mb-2"><label class="form-label">Harga</label><input type="number" class="form-control harga_badal" name="harga_badal[${badalCounter}]" min="0"></div>
                <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
            `;
                badalWrapper.appendChild(newForm);
            });


            // --- Main Event Delegation for Clicks ---
            document.body.addEventListener('click', function(e) {

                // Transportasi Darat - Vehicle Click
                const carItem = e.target.closest('.service-car');
                if (carItem) {
                    const transportSet = carItem.closest('.transport-set');
                    transportSet.querySelectorAll('.service-car').forEach(car => car.classList.remove(
                        'selected'));
                    carItem.classList.add('selected');
                    const routes = JSON.parse(carItem.dataset.routes || '[]');
                    const select = transportSet.querySelector('select[name^="rute_id"]');
                    const routeSelectDiv = transportSet.querySelector('.route-select');
                    select.innerHTML = `<option value="">-- Pilih Rute --</option>`;
                    routes.forEach(route => {
                        select.insertAdjacentHTML('beforeend',
                            `<option value="${route.id}" data-price="${route.price}" data-car-name="${carItem.dataset.name}">${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`
                        );
                    });
                    routeSelectDiv.classList.remove('hidden');
                }

                // Hotel Type Click
                const typeItem = e.target.closest('.type-item');
                if (typeItem) {
                    const hotelForm = typeItem.closest('.hotel-form');
                    const dynamicContainer = hotelForm.querySelector('.type-input-container');
                    const typeId = typeItem.dataset.typeId;
                    const name = typeItem.dataset.name;
                    const price = parseInt(typeItem.dataset.price) || 0;
                    const cartId = `hotel-${hotelForm.dataset.index}-type-${typeId}`;
                    const existingInputDiv = dynamicContainer.querySelector(`[data-type-id="${typeId}"]`);

                    if (existingInputDiv) {
                        existingInputDiv.remove();
                        typeItem.classList.remove('selected');
                        delete cart[cartId];
                    } else {
                        typeItem.classList.add('selected');
                        const inputDiv = document.createElement('div');
                        inputDiv.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border',
                            'rounded');
                        inputDiv.dataset.typeId = typeId;
                        inputDiv.innerHTML =
                            `<label class="form-label">Jumlah Kamar (${name})</label><input type="number" class="form-control" name="jumlah_type[]" min="1" value="1" data-is-qty="true" data-type-id="${typeId}"><label class="form-label mt-2">Harga (${name})</label><input type="text" class="form-control" name="harga_kamar[${hotelForm.dataset.index}][${typeId}]" value="${price.toLocaleString('id-ID')}" readonly>`;
                        dynamicContainer.appendChild(inputDiv);
                        const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value
                            .trim() || `Hotel ${hotelForm.dataset.index}`;
                        updateItemInCart(cartId, `Hotel ${hotelName} - Tipe ${name}`, 1, price);
                    }
                    updateCartUI();
                }

                // === REVISI: Document Click (Multi-Choice) ===
                const documentItem = e.target.closest('.document-item');
                if (documentItem) {
                    const docId = documentItem.dataset.documentId;
                    const hasChildren = documentItem.dataset.hasChildren === 'true';

                    // Toggle selection for the clicked item
                    documentItem.classList.toggle('selected');

                    const formElement = document.querySelector(
                        `.document-child-form[data-parent-id="${docId}"]`) || document.querySelector(
                        `.document-base-form[data-document-id="${docId}"]`);

                    if (formElement) {
                        const isHidden = formElement.classList.toggle('hidden');
                        if (!isHidden && !hasChildren) {
                            // If shown and is a base item, add to cart
                            const qtyInput = formElement.querySelector('input[type="number"]');
                            if (qtyInput) qtyInput.value = 1;
                            const name = documentItem.dataset.name;
                            const price = parseInt(documentItem.dataset.price) || 0;
                            updateItemInCart(`doc-base-${docId}`, `Dokumen - ${name}`, 1, price);
                        } else if (isHidden) {
                            // If hidden, remove from cart
                            Object.keys(cart).forEach(key => {
                                if (key.startsWith(`doc-base-${docId}`) || key.startsWith(
                                        `doc-child-${docId}`)) {
                                    delete cart[key];
                                }
                            });
                        }
                    }
                    updateCartUI();
                }

                // Document Child Item Click
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const parentId = childItem.closest('.document-child-form').dataset.parentId;
                    const childId = childItem.dataset.childId;
                    const name = childItem.dataset.name;
                    const price = parseInt(childItem.dataset.price) || 0;
                    const cartId = `doc-child-${parentId}-${childId}`;
                    const isSelected = childItem.classList.toggle('selected');
                    const formContainer = childItem.closest('.document-child-form');
                    let existingForm = formContainer.querySelector(`#doc-child-form-${childId}`);
                    if (isSelected) {
                        if (!existingForm) {
                            const newForm = document.createElement('div');
                            newForm.id = `doc-child-form-${childId}`;
                            newForm.classList.add('form-group', 'mt-2', 'bg-white', 'p-3', 'border',
                                'rounded');
                            newForm.innerHTML =
                                `<label class="form-label">Jumlah ${name}</label>
             <input type="number"
                    class="form-control jumlah-child-doc"
                    data-parent-id="${parentId}"
                    data-child-id="${childId}"
                    data-name="${name}"
                    data-price="${price}"
                    min="1"
                    value="1"
                    name="jumlah_child_doc[${childId}]">`; // <-- TAMBAHKAN NAME ATTRIBUTE INI
                            formContainer.appendChild(newForm);
                        } else {
                            existingForm.classList.remove('hidden');
                            const inputNumber = existingForm.querySelector('input[type="number"]');
                            if (inputNumber && !inputNumber.hasAttribute('name')) {
                                inputNumber.setAttribute('name', `jumlah_child_doc[${childId}]`);
                            }
                        }
                        updateItemInCart(cartId, `Dokumen - ${name}`, 1, price);
                    } else {
                        if (existingForm) existingForm.classList.add('hidden');
                        delete cart[cartId];
                    }
                    updateCartUI();
                }

                // Generic Toggle Item Click (Pendamping, Konten, Meals, etc.)
                const toggleItem = e.target.closest(
                    '.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item');
                if (toggleItem) {
                    const isSelected = toggleItem.classList.toggle('selected');
                    const type = toggleItem.dataset.type;
                    const id = toggleItem.dataset.id;
                    const form = document.getElementById(`form-${type}-${id}`);
                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        const qtyInput = form.querySelector('input[type="number"]');
                        const name = toggleItem.dataset.name;
                        const price = parseInt(toggleItem.dataset.price) || 0;
                        if (isSelected) {
                            qtyInput.value = 1;
                            updateItemInCart(`${type}-${id}`, name, 1, price);
                        } else {
                            qtyInput.value = 0;
                            delete cart[`${type}-${id}`];
                        }
                    }
                    updateCartUI();
                }

                // Remove Buttons Logic
                if (e.target.classList.contains("removeTicket") && document.querySelectorAll(".ticket-form")
                    .length > 1) {
                    e.target.closest(".ticket-form").remove();
                }
                const removeTransportBtn = e.target.closest(".remove-transport");
                if (removeTransportBtn && document.querySelectorAll(".transport-set").length > 1) {
                    const transportSet = removeTransportBtn.closest('.transport-set');
                    const index = transportSet.dataset.index;
                    Object.keys(cart).forEach(key => {
                        if (key.includes(`tour-bus-${index}`)) delete cart[key];
                    });
                    transportSet.remove();
                    updateCartUI();
                }
                const removeHotelBtn = e.target.closest('.removeHotel');
                if (removeHotelBtn && document.querySelectorAll('.hotel-form').length > 1) {
                    const hotelForm = removeHotelBtn.closest('.hotel-form');
                    const formIndex = hotelForm.dataset.index;
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`hotel-${formIndex}`)) delete cart[key];
                    });
                    hotelForm.remove();
                    updateCartUI();
                }
                if (e.target.classList.contains("removeBadal")) {
                    const formEl = e.target.closest(".badal-form");
                    if (document.querySelectorAll(".badal-form").length > 1) {
                        const id = `badal-${formEl.dataset.index}`;
                        delete cart[id];
                        updateCartUI();
                        formEl.remove();
                    }
                }

                // Transport Type Selection (Airplane/Bus)
                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    const isSelected = transportItem.classList.toggle('selected');
                    transportItem.querySelector('input').checked = isSelected;
                    document.getElementById(type === 'airplane' ? 'pesawat' : 'bis').classList.toggle(
                        'hidden', !isSelected);
                }

                // Handling Selection
                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    const isSelected = handlingItem.classList.toggle('selected');
                    handlingItem.querySelector('input').checked = isSelected;
                    document.getElementById(`${type}-handling-form`).classList.toggle('hidden', !
                        isSelected);
                }

                // Tour Selection
                const tourItem = e.target.closest('.service-tour');
                if (tourItem) {
                    const tourId = tourItem.dataset.id;
                    const form = document.getElementById(`tour-${tourId}-form`);
                    const isSelected = tourItem.classList.toggle('selected');
                    form.classList.toggle('hidden', !isSelected);
                    if (!isSelected) {
                        Object.keys(cart).forEach(key => {
                            if (key.startsWith(`tour-${tourId}-`)) {
                                delete cart[key];
                            }
                        });
                        updateCartUI();
                    }
                }

                // Tour Transport Selection
                const tourTransOption = e.target.closest('.transport-option');
                if (tourTransOption) {
                    const tourId = tourTransOption.dataset.tourId;
                    const transId = tourTransOption.dataset.transId;
                    const tourName = tourTransOption.dataset.tourName;
                    const transName = tourTransOption.dataset.transName;
                    const price = parseInt(tourTransOption.dataset.price) || 0;

                    const uniqueKey = `tour-${tourId}-${transId}`;

                    // Toggle selected class
                    const isSelected = tourTransOption.classList.toggle('selected');

                    if (isSelected) {
                        // Jika baru dipilih, tambahkan ke cart
                        updateItemInCart(uniqueKey, `Tour ${tourName} - ${transName}`, 1, price);
                    } else {
                        // Jika di-unselect, hapus dari cart
                        delete cart[uniqueKey];
                        updateCartUI();
                    }
                }


                // Reyal Card Selection
                const reyalCard = e.target.closest('.card-reyal');
                if (reyalCard) {
                    document.querySelectorAll('.card-reyal').forEach(c => c.classList.remove('selected'));
                    reyalCard.classList.add('selected');
                    const type = reyalCard.dataset.reyalType;
                    const formTamis = document.getElementById('form-tamis');
                    const formTumis = document.getElementById('form-tumis');
                    formTamis.classList.toggle('hidden', type !== 'tamis');
                    formTumis.classList.toggle('hidden', type !== 'tumis');
                }
            });

            // --- Event Delegation for Inputs ---
            document.body.addEventListener('input', function(e) {
                const input = e.target;

                // Badal Umrah Input
                const badalInput = input.closest('.nama_badal, .harga_badal');
                if (badalInput) {
                    const badalForm = badalInput.closest('.badal-form');
                    const index = badalForm.dataset.index;
                    const namaInput = badalForm.querySelector('.nama_badal');
                    const hargaInput = badalForm.querySelector('.harga_badal');
                    const namaValue = namaInput.value.trim();
                    const hargaValue = parseFloat(hargaInput.value) || 0;
                    const key = `badal-${index}`;
                    const itemName = `Badal Umrah untuk: ${namaValue}`;
                    if (namaValue && hargaValue > 0) {
                        updateItemInCart(key, itemName, 1, hargaValue);
                    } else {
                        delete cart[key];
                        updateCartUI();
                    }
                }

                // Hotel Room Quantity Input
                const hotelQtyInput = input.closest('input[data-is-qty="true"]');
                if (hotelQtyInput) {
                    const hotelForm = hotelQtyInput.closest('.hotel-form');
                    const hotelIndex = hotelForm.dataset.index;
                    const typeId = hotelQtyInput.dataset.typeId;
                    const typeItem = hotelForm.querySelector(`.type-item[data-type-id="${typeId}"]`);
                    const hotelName = hotelForm.querySelector('input[data-field="nama_hotel"]').value
                        .trim() || `Hotel ${hotelIndex}`;
                    if (typeItem) {
                        const price = parseInt(typeItem.dataset.price) || 0;
                        updateItemInCart(`hotel-${hotelIndex}-type-${typeId}`,
                            `Hotel ${hotelName} - Tipe ${typeItem.dataset.name}`, parseInt(hotelQtyInput
                                .value) || 0, price);
                    }
                }

                // Reyal Conversion Input
                if (input.id === 'rupiah-tamis' || input.id === 'kurs-tamis') {
                    const rupiah = parseFloat(document.getElementById('rupiah-tamis').value);
                    const kurs = parseFloat(document.getElementById('kurs-tamis').value);
                    document.getElementById('hasil-tamis').value = (!isNaN(rupiah) && !isNaN(kurs) && kurs >
                        0) ? (rupiah / kurs).toFixed(2) : '';
                }
                if (input.id === 'reyal-tumis' || input.id === 'kurs-tumis') {
                    const reyal = parseFloat(document.getElementById('reyal-tumis').value);
                    const kurs = parseFloat(document.getElementById('kurs-tumis').value);
                    document.getElementById('hasil-tumis').value = (!isNaN(reyal) && !isNaN(kurs) && kurs >
                        0) ? (reyal * kurs).toFixed(2) : '';
                }
            });

            // --- Event Delegation for Change events ---
            document.body.addEventListener('change', e => {
                // Land Transport Route Selection
                const select = e.target.closest('select[name^="rute_id"]');
                if (select) {
                    const transportSet = select.closest('.transport-set');
                    const index = transportSet.dataset.index;

                    // Clear any previous selection for this transport set
                    Object.keys(cart).forEach(key => {
                        if (key.startsWith(`tour-bus-${index}-`)) delete cart[key];
                    });

                    const selected = select.options[select.selectedIndex];
                    if (selected.value) {
                        const carName = selected.dataset.carName;
                        const price = parseInt(selected.dataset.price) || 0;
                        const key = `tour-bus-${index}-${selected.value}`;
                        updateItemInCart(key,
                            `Transportasi Darat - ${carName} - ${selected.textContent.split(' - ')[0]}`,
                            1, price);
                    } else {
                        updateCartUI(); // Update UI if they de-select to "-- Pilih Rute --"
                    }
                }
            });
        });

        // Logic untuk dinamisasi checkbox
        function toggleCheckboxOnClick(selector) {
            const items = document.querySelectorAll(selector);
            items.forEach(function(item) {
                item.addEventListener("click", function(e) {
                    // Biar kalau yang diklik itu input-nya sendiri, gak dobel toggle
                    if (e.target.tagName.toLowerCase() === 'input') return;

                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });
        }

        // --- panggil di mana pun ---
        toggleCheckboxOnClick(".document-item");
        toggleCheckboxOnClick(".type-item");
        toggleCheckboxOnClick(".child-item");
        toggleCheckboxOnClick(".service-tour")
        toggleCheckboxOnClick(".wakaf-item")
    </script>
@endsection
