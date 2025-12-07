@extends('admin.master')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
@section('title', 'Edit Permintaan Service')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/services/edit.css') }}">
@endpush
@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-pencil-square"></i> Edit Permintaan Service
                </h5>
                <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div
                            style="background-color: #fde8e8; border: 1px solid var(--danger-color); color: #9b1c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            <h6 style="color: #9b1c1c; margin-top: 0; margin-bottom: 0.75rem; font-weight: 700;">
                                <i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan
                            </h6>
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SECTION: DATA TRAVEL --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Travel</label>
                                    <select class="form-select" name="travel" id="travel-select">
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                data-penanggung="{{ $pelanggan->penanggung_jawab }}"
                                                data-email="{{ $pelanggan->email }}" data-telepon="{{ $pelanggan->phone }}"
                                                {{ old('travel', $service->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_travel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control" readonly id="penanggung"
                                        value="{{ $service->pelanggan->penanggung_jawab }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" readonly id="email"
                                        value="{{ $service->pelanggan->email }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Telepon</label>
                                    <input type="tel" class="form-control" name="phone" readonly id="phone"
                                        value="{{ $service->pelanggan->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" name="tanggal_keberangkatan" required
                                        value="{{ old('tanggal_keberangkatan', $service->tanggal_keberangkatan) }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" class="form-control" name="tanggal_kepulangan" required
                                        value="{{ old('tanggal_kepulangan', $service->tanggal_kepulangan) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Jamaah</label>
                            <input type="number" class="form-control" name="total_jamaah" min="1" required
                                value="{{ old('total_jamaah', $service->total_jamaah) }}">
                        </div>
                    </div>

                    {{-- PHP LOGIC TO PREPARE DATA --}}
                    @php
                        $oldOrSelectedServices = old('services', $selectedServices);

                        $existingPlanes = $service->planes;
                        $existingTransports = $service->transportationItem;
                        $existingHotels = $service->hotels;
                        $existingBadals = $service->badals;

                        $oldTransportTypes = old('transportation');
                        $isAirplaneSelected = !is_null($oldTransportTypes)
                            ? in_array('airplane', $oldTransportTypes)
                            : !$existingPlanes->isEmpty();
                        $isBusSelected = !is_null($oldTransportTypes)
                            ? in_array('bus', $oldTransportTypes)
                            : !$existingTransports->isEmpty();

                        // Siapkan data lama (jika ada) untuk item yang bisa dipilih (checkbox/radio)
                        $oldPendampingQty = old('jumlah_pendamping');
                        $oldMealsQty = old('jumlah_meals');
                        $oldDoronganQty = old('jumlah_dorongan');
                        $oldWakafQty = old('jumlah_wakaf');
                        $oldContentsQty = old('jumlah_konten');
                        $oldTourIds = old('tour_id'); // Untuk tour
                        $oldTourTransports = old('tour_transport'); // Untuk transport tour

                        // Siapkan data yang sudah ada (existing) dari controller
                        $selectedGuides = $service->guides?->keyBy('guide_id') ?? collect();
                        $selectedMeals = $service->meals?->keyBy('meal_id') ?? collect();
                        $selectedDorongan = $service->dorongans?->keyBy('dorongan_id') ?? collect();
                        $selectedWakaf = $service->wakafs?->keyBy('wakaf_id') ?? collect();
                        $selectedContents = $service->contents?->keyBy('content_id') ?? collect();
                        $selectedTours = $service->tours?->keyBy('tour_id') ?? collect();

                        // Data Dokumen (ini rumit, kita gunakan data dari controller sebagai fallback)
                        $customerDocs = $service->documents;
                        $selectedDocParents = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->pluck('document_id')
                            ->unique()
                            ->toArray();
                        $selectedDocChildren = $customerDocs
                            ->whereNotNull('document_children_id')
                            ->mapWithKeys(
                                fn($item) => [
                                    $item->document_children_id => ['jumlah' => $item->jumlah, 'id' => $item->id],
                                ],
                            )
                            ->all();
                        $selectedBaseDocs = $customerDocs
                            ->whereNull('document_children_id')
                            ->mapWithKeys(
                                fn($item) => [$item->document_id => ['jumlah' => $item->jumlah, 'id' => $item->id]],
                            )
                            ->all();
                        $allSelectedDocItems = array_merge($selectedDocParents, array_keys($selectedBaseDocs));

                        // Handling
                        $oldHandlingTypes = old('handlings');
                        $isHandlingHotelSelected = !is_null($oldHandlingTypes)
                            ? in_array('hotel', $oldHandlingTypes)
                            : !is_null($service->handlingHotel);
                        $isHandlingPlaneSelected = !is_null($oldHandlingTypes)
                            ? in_array('bandara', $oldHandlingTypes)
                            : !is_null($service->handlingPlanes);

                        $existingReyal = $service->exchanges->first();
                        $oldReyalTipe = old('tipe', $existingReyal?->tipe);

                    @endphp

                    <div class="form-section" id="service-selection-grid">
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
        ] as $key => $item)
                                <div class="service-item {{ in_array($key, $oldOrSelectedServices) ? 'selected' : '' }}"
                                    data-service="{{ $key }}">
                                    <div class="service-icon"><i class="bi {{ $item['icon'] }}"></i></div>
                                    <div class="service-name">{{ $item['name'] }}</div>
                                    <div class="service-desc">{{ $item['desc'] }}</div>
                                    <input type="checkbox" name="services[]" value="{{ $key }}" class="d-none"
                                        {{ in_array($key, $oldOrSelectedServices) ? 'checked' : '' }}>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SECTION: DETAIL FORMS --}}
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                        </h6>

                        {{-- TRANSPORTASI FORM --}}
                        <div class="detail-form {{ in_array('transportasi', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="transportasi-details">
                            <h6 class="detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="transport-item {{ $isAirplaneSelected ? 'selected' : '' }}"
                                        data-transportasi="airplane">
                                        <div class="service-name">Pesawat</div>
                                        <input type="checkbox" name="transportation[]" value="airplane" class="d-none"
                                            {{ $isAirplaneSelected ? 'checked' : '' }}>
                                    </div>
                                    <div class="transport-item {{ $isBusSelected ? 'selected' : '' }}"
                                        data-transportasi="bus">
                                        <div class="service-name">Transportasi Darat</div>
                                        <input type="checkbox" name="transportation[]" value="bus" class="d-none"
                                            {{ $isBusSelected ? 'checked' : '' }}>
                                    </div>
                                </div>

                                {{-- FORM PESAWAT --}}
                                <div class="form-group {{ $isAirplaneSelected ? '' : 'hidden' }}" id="pesawat"
                                    data-transportasi="airplane">
                                    <label class="form-label">Tiket Pesawat</label>
                                    <button type="button" class="btn btn-sm btn-primary mb-3" id="addTicket">Tambah
                                        Tiket</button>
                                    <div id="ticketWrapper">
                                        @php
                                            $isOld = is_array(old('plane_id'));
                                            $planeData = $isOld ? old('plane_id') : $existingPlanes;
                                        @endphp

                                        @forelse($planeData as $index => $data)
                                            @php
                                                $plane = $isOld ? null : $data;
                                                $currentId = $isOld ? $data : $plane->id;
                                            @endphp

                                            <div class="ticket-form bg-white p-3 border mb-3">
                                                {{-- Hidden ID dengan Index --}}
                                                <input type="hidden" name="plane_id[{{ $index }}]"
                                                    value="{{ $currentId }}">

                                                <div class="row g-3">
                                                    {{-- Tanggal --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Tanggal</label>
                                                        <input type="date"
                                                            class="form-control @error('tanggal.' . $index) is-invalid @enderror"
                                                            name="tanggal[{{ $index }}]"
                                                            value="{{ $isOld ? old('tanggal.' . $index) : $plane->tanggal_keberangkatan }}">
                                                        @error('tanggal.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Rute --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Rute</label>
                                                        <input type="text"
                                                            class="form-control @error('rute.' . $index) is-invalid @enderror"
                                                            name="rute[{{ $index }}]"
                                                            placeholder="Contoh: CGK - JED"
                                                            value="{{ $isOld ? old('rute.' . $index) : $plane->rute }}">
                                                        @error('rute.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Maskapai --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Maskapai</label>
                                                        <input type="text"
                                                            class="form-control @error('maskapai.' . $index) is-invalid @enderror"
                                                            name="maskapai[{{ $index }}]"
                                                            value="{{ $isOld ? old('maskapai.' . $index) : $plane->maskapai }}">
                                                        @error('maskapai.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- Keterangan (Gunakan 'keterangan_tiket' agar tidak bentrok) --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Keterangan</label>
                                                        <input type="text" class="form-control"
                                                            name="keterangan_tiket[{{ $index }}]"
                                                            value="{{ $isOld ? old('keterangan_tiket.' . $index) : $plane->keterangan }}">
                                                    </div>

                                                    {{-- Jumlah Jamaah --}}
                                                    <div class="col-12">
                                                        <label class="form-label">Jumlah (Jamaah)</label>
                                                        <input type="number"
                                                            class="form-control @error('jumlah.' . $index) is-invalid @enderror"
                                                            name="jumlah[{{ $index }}]"
                                                            value="{{ $isOld ? old('jumlah.' . $index) : $plane->jumlah_jamaah }}">
                                                        @error('jumlah.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mt-3 text-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeTicket">Hapus</button>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>

                                {{-- FORM TRANSPORTASI DARAT --}}
                                <div class="form-group {{ $isBusSelected ? '' : 'hidden' }}" id="bis"
                                    data-transportasi="bus">
                                    <label class="form-label">Transportasi darat</label>

                                    {{-- Error Global Transportasi --}}
                                    @error('transportation_id')
                                        <div class="alert alert-danger py-2">{{ $message }}</div>
                                    @enderror

                                    <button type="button" class="btn btn-primary btn-sm mb-3"
                                        id="add-transport-btn">Tambah Transportasi</button>

                                    <div id="new-transport-forms">
                                        @if (is_array(old('item_id')))
                                            @foreach (old('item_id') as $index => $oldItemIdValue)
                                                @php
                                                    // 1. Ambil data lama
                                                    $oldTransportId = old('transportation_id.' . $index);
                                                    $oldRouteId = old('rute_id.' . $index);

                                                    // 2. Cek apakah harus menampilkan form detail (Mobil dipilih ATAU tanggal sudah diisi)
                                                    // Ini mencegah form hilang/tertutup jika user lupa pilih mobil tapi sudah isi tanggal
                                                    $hasOldDate =
                                                        old('tanggal_transport.' . $index . '.dari') ||
                                                        old('tanggal_transport.' . $index . '.sampai');
                                                    $selectedTransport = $transportations->firstWhere(
                                                        'id',
                                                        $oldTransportId,
                                                    );
                                                    $showDetails = $selectedTransport || $hasOldDate;

                                                    // 3. Cek data DB (untuk edit data lama)
                                                    $transport = $oldItemIdValue
                                                        ? \App\Models\TransportationItem::find($oldItemIdValue)
                                                        : null;
                                                @endphp

                                                <div class="transport-set card p-3 mt-3"
                                                    data-index="{{ $index }}">
                                                    {{-- PENTING: Index pada name harus eksplisit --}}
                                                    <input type="hidden" name="item_id[{{ $index }}]"
                                                        value="{{ $oldItemIdValue }}">

                                                    {{-- PILIHAN MOBIL --}}
                                                    <div class="cars">
                                                        @foreach ($transportations as $data)
                                                            <div class="service-car {{ $data->id == $oldTransportId ? 'selected' : '' }}"
                                                                data-id="{{ $data->id }}"
                                                                data-routes='@json($data->routes)'
                                                                data-name="{{ $data->nama }}"
                                                                data-price="{{ $data->harga }}">
                                                                <div class="service-name">{{ $data->nama }}</div>
                                                                <div class="service-desc">Kapasitas:
                                                                    {{ $data->kapasitas }}</div>
                                                                <div class="service-desc">Fasilitas:
                                                                    {{ $data->fasilitas }}</div>
                                                                <div class="service-desc">Harga:
                                                                    {{ number_format($data->harga) }}/hari</div>
                                                                <input type="radio"
                                                                    name="transportation_id[{{ $index }}]"
                                                                    value="{{ $data->id }}"
                                                                    {{ $data->id == $oldTransportId ? 'checked' : '' }}>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @error("transportation_id.$index")
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror

                                                    {{-- FORM DETAIL (Rute & Tanggal) --}}
                                                    {{-- Gunakan variabel $showDetails agar form tidak tertutup --}}
                                                    <div
                                                        class="transport-details-wrapper {{ $showDetails ? '' : 'hidden' }}">

                                                        <div class="route-select mt-3">
                                                            <label class="form-label">Pilih Rute:</label>
                                                            <select name="rute_id[{{ $index }}]"
                                                                class="form-select @error("rute_id.$index") is-invalid @enderror">
                                                                <option value="">-- Pilih Rute --</option>
                                                                @if ($selectedTransport)
                                                                    @foreach ($selectedTransport->routes as $route)
                                                                        <option value="{{ $route->id }}"
                                                                            {{ $route->id == $oldRouteId ? 'selected' : '' }}>
                                                                            {{ $route->route }} - Rp.
                                                                            {{ number_format($route->price) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error("rute_id.$index")
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-row mt-3">
                                                            <div class="form-col">
                                                                <label class="form-label">Dari Tanggal</label>
                                                                <input type="date"
                                                                    class="form-control @error("tanggal_transport.$index.dari") is-invalid @enderror"
                                                                    name="tanggal_transport[{{ $index }}][dari]"
                                                                    value="{{ old('tanggal_transport.' . $index . '.dari', $transport?->dari_tanggal ? \Carbon\Carbon::parse($transport->dari_tanggal)->format('Y-m-d') : '') }}">
                                                                @error("tanggal_transport.$index.dari")
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-col">
                                                                <label class="form-label">Sampai Tanggal</label>
                                                                <input type="date"
                                                                    class="form-control @error("tanggal_transport.$index.sampai") is-invalid @enderror"
                                                                    name="tanggal_transport[{{ $index }}][sampai]"
                                                                    value="{{ old('tanggal_transport.' . $index . '.sampai', $transport?->sampai_tanggal ? \Carbon\Carbon::parse($transport->sampai_tanggal)->format('Y-m-d') : '') }}">
                                                                @error("tanggal_transport.$index.sampai")
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- LOGIKA 2: DATA EXISTING (Tidak ada error validasi) --}}
                                            @forelse($existingTransports as $index => $transport)
                                                <div class="transport-set card p-3 mt-3"
                                                    data-index="{{ $index }}">
                                                    <input type="hidden" name="item_id[{{ $index }}]"
                                                        value="{{ $transport->id }}">

                                                    <div class="cars">
                                                        @foreach ($transportations as $data)
                                                            <div class="service-car {{ $data->id == $transport->transportation_id ? 'selected' : '' }}"
                                                                data-id="{{ $data->id }}"
                                                                data-routes='@json($data->routes)'
                                                                data-name="{{ $data->nama }}"
                                                                data-price="{{ $data->harga }}">
                                                                <div class="service-name">{{ $data->nama }}</div>
                                                                <div class="service-desc">Kapasitas:
                                                                    {{ $data->kapasitas }}</div>
                                                                <div class="service-desc">Fasilitas:
                                                                    {{ $data->fasilitas }}</div>
                                                                <div class="service-desc">Harga:
                                                                    {{ number_format($data->harga) }}/hari</div>
                                                                <input type="radio"
                                                                    name="transportation_id[{{ $index }}]"
                                                                    value="{{ $data->id }}"
                                                                    {{ $data->id == $transport->transportation_id ? 'checked' : '' }}>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="transport-details-wrapper">
                                                        <div class="route-select mt-3">
                                                            <label class="form-label">Pilih Rute:</label>
                                                            <select name="rute_id[{{ $index }}]"
                                                                class="form-select">
                                                                @if ($transport->transportation)
                                                                    @foreach ($transport->transportation->routes as $route)
                                                                        <option value="{{ $route->id }}"
                                                                            {{ $route->id == $transport->route_id ? 'selected' : '' }}>
                                                                            {{ $route->route }} - Rp.
                                                                            {{ number_format($route->price) }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">-- Pilih Tipe Transportasi Dulu
                                                                        --</option>
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-row mt-3">
                                                            <div class="form-col">
                                                                <label class="form-label">Dari Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    name="tanggal_transport[{{ $index }}][dari]"
                                                                    value="{{ $transport->dari_tanggal ? \Carbon\Carbon::parse($transport->dari_tanggal)->format('Y-m-d') : '' }}">
                                                            </div>
                                                            <div class="form-col">
                                                                <label class="form-label">Sampai Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    name="tanggal_transport[{{ $index }}][sampai]"
                                                                    value="{{ $transport->sampai_tanggal ? \Carbon\Carbon::parse($transport->sampai_tanggal)->format('Y-m-d') : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-transport">Hapus</button>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HOTEL FORM --}}
                        <div class="detail-form {{ in_array('hotel', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="hotel-details">
                            <h6 class="detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            <div style="clear: both;"></div>

                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addHotel">Tambah
                                Hotel</button>

                            <div id="hotelWrapper">
                                @php
                                    $types = $types ?? collect();
                                    // Prioritas Data:
                                    // 1. Data Input Lama (old) -> Muncul saat validasi error / reload
                                    // 2. Data Database ($existingHotels) -> Muncul saat pertama kali edit

                                    $sourceData = [];
                                    $isOldData = false;

                                    if (old('nama_hotel')) {
                                        // Skenario 1: Ada data lama (old)
                                        $isOldData = true;
                                        // Kita meloop berdasarkan array 'nama_hotel' karena itu field wajib
                                        $sourceData = old('nama_hotel');
                                    } else {
                                        // Skenario 2: Data dari Database
                                        // Grouping logic sama seperti sebelumnya
                                        $sourceData = $service->hotels->groupBy(
                                            fn($item) => $item->nama_hotel .
                                                '|' .
                                                $item->tanggal_checkin .
                                                '|' .
                                                $item->tanggal_checkout,
                                        );
                                    }
                                @endphp

                                @foreach ($sourceData as $key => $data)
                                    @php
                                        // Tentukan index loop.
                                        // Jika old data, $key adalah index (0, 1, 2...).
                                        // Jika DB data, $key adalah string grouping, jadi kita pakai $loop->index.
                                        $currentIndex = $isOldData ? $key : $loop->index;

                                        // Variabel Helper untuk Value
                                        if ($isOldData) {
                                            $valCheckin = old('tanggal_checkin.' . $currentIndex);
                                            $valCheckout = old('tanggal_checkout.' . $currentIndex);
                                            $valNama = old('nama_hotel.' . $currentIndex);
                                            $valJmlKamar = old('jumlah_kamar.' . $currentIndex);
                                            $valKet = old('keterangan.' . $currentIndex);
                                            $valId = old('hotel_id.' . $currentIndex);
                                            // Tipe Kamar (Array Keys)
                                            $selectedTypes = array_keys(old('hotel_data.' . $currentIndex, []));
                                        } else {
                                            $firstItem = $data->first();
                                            $valCheckin = $firstItem->tanggal_checkin;
                                            $valCheckout = $firstItem->tanggal_checkout;
                                            $valNama = $firstItem->nama_hotel;
                                            $valJmlKamar = $firstItem->jumlah_kamar;
                                            $valKet = $firstItem->catatan;
                                            $valId = $firstItem->id; // ID salah satu item grup
                                            $selectedTypes = $data
                                                ->pluck('type')
                                                ->map(fn($t) => $types->firstWhere('nama_tipe', $t)?->id)
                                                ->filter()
                                                ->toArray();
                                        }
                                    @endphp

                                    <div class="hotel-form bg-white p-3 border mb-3" data-index="{{ $currentIndex }}">
                                        <input type="hidden" name="hotel_id[{{ $currentIndex }}]"
                                            value="{{ $valId }}">

                                        <div class="row g-3">
                                            {{-- TANGGAL CHECKIN --}}
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Tanggal Checkin</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_checkin.' . $currentIndex) is-invalid @enderror"
                                                    name="tanggal_checkin[{{ $currentIndex }}]"
                                                    value="{{ $valCheckin }}">
                                                @error('tanggal_checkin.' . $currentIndex)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- TANGGAL CHECKOUT --}}
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Tanggal Checkout</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_checkout.' . $currentIndex) is-invalid @enderror"
                                                    name="tanggal_checkout[{{ $currentIndex }}]"
                                                    value="{{ $valCheckout }}">
                                                @error('tanggal_checkout.' . $currentIndex)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- NAMA HOTEL --}}
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Nama Hotel</label>
                                                <input type="text"
                                                    class="form-control @error('nama_hotel.' . $currentIndex) is-invalid @enderror"
                                                    name="nama_hotel[{{ $currentIndex }}]" placeholder="Nama hotel"
                                                    value="{{ $valNama }}">
                                                @error('nama_hotel.' . $currentIndex)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- TIPE KAMAR & JUMLAH (Validasi bersarang biasanya global atau per item) --}}
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Tipe Kamar</label>
                                                <div class="service-grid">
                                                    @foreach ($types as $type)
                                                        <div class="type-item {{ in_array($type->id, $selectedTypes) ? 'selected' : '' }}"
                                                            data-type-id="{{ $type->id }}"
                                                            data-price="{{ $type->jumlah }}"
                                                            data-name="{{ $type->nama_tipe }}">
                                                            <div class="service-name">{{ $type->nama_tipe }}</div>
                                                            <input type="checkbox" name="type[]"
                                                                value="{{ $type->nama_tipe }}" class="d-none"
                                                                {{ in_array($type->id, $selectedTypes) ? 'checked' : '' }}>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="type-input-container">
                                                    @if ($isOldData)
                                                        @foreach ($selectedTypes as $typeId)
                                                            @php
                                                                $typeMaster = $types->firstWhere('id', $typeId);
                                                                $oldDetail = old(
                                                                    'hotel_data.' . $currentIndex . '.' . $typeId,
                                                                );
                                                            @endphp
                                                            @if ($typeMaster && $oldDetail)
                                                                <div class="form-group mt-2 bg-white p-3 border rounded"
                                                                    data-type-id="{{ $typeId }}">
                                                                    <label class="form-label">Jumlah Kamar
                                                                        ({{ $typeMaster->nama_tipe }})
                                                                    </label>

                                                                    {{-- Validasi Jumlah Kamar per Tipe --}}
                                                                    <input type="number"
                                                                        class="form-control qty-input-hotel @error('hotel_data.' . $currentIndex . '.' . $typeId . '.jumlah') is-invalid @enderror"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeId }}][jumlah]"
                                                                        min="1"
                                                                        value="{{ $oldDetail['jumlah'] }}"
                                                                        data-is-qty="true"
                                                                        data-type-id="{{ $typeId }}">
                                                                    @error('hotel_data.' . $currentIndex . '.' . $typeId .
                                                                        '.jumlah')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror

                                                                    <label class="form-label mt-2">Harga</label>
                                                                    <input type="text" class="form-control"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeId }}][harga]"
                                                                        value="{{ $oldDetail['harga'] }}" readonly>
                                                                    <input type="hidden"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeId }}][type_name]"
                                                                        value="{{ $typeMaster->nama_tipe }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{-- Render Input Detail Tipe Kamar dari DATABASE --}}
                                                        @foreach ($data as $item)
                                                            @php $typeMaster = $types->firstWhere('nama_tipe', $item->type); @endphp
                                                            @if ($typeMaster)
                                                                <div class="form-group mt-2 bg-white p-3 border rounded"
                                                                    data-type-id="{{ $typeMaster->id }}">
                                                                    <label class="form-label">Jumlah Kamar
                                                                        ({{ $item->type }})
                                                                    </label>
                                                                    <input type="number"
                                                                        class="form-control qty-input-hotel"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeMaster->id }}][jumlah]"
                                                                        min="1" value="{{ $item->jumlah_type }}"
                                                                        data-is-qty="true"
                                                                        data-type-id="{{ $typeMaster->id }}">
                                                                    <label class="form-label mt-2">Harga</label>
                                                                    <input type="text" class="form-control"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeMaster->id }}][harga]"
                                                                        value="{{ number_format($item->harga_perkamar, 0, ',', '.') }}"
                                                                        readonly>
                                                                    <input type="hidden"
                                                                        name="hotel_data[{{ $currentIndex }}][{{ $typeMaster->id }}][type_name]"
                                                                        value="{{ $item->type }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TOTAL KAMAR --}}
                                        <div class="form-group mt-2">
                                            <label class="form-label">Total kamar</label>
                                            <input type="number"
                                                class="form-control @error('jumlah_kamar.' . $currentIndex) is-invalid @enderror"
                                                name="jumlah_kamar[{{ $currentIndex }}]" min="0"
                                                value="{{ $valJmlKamar }}" readonly>
                                            @error('jumlah_kamar.' . $currentIndex)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- KETERANGAN --}}
                                        <div class="form-group mt-2">
                                            <label class="form-label">Keterangan</label>
                                            <input type="text" class="form-control"
                                                name="keterangan[{{ $currentIndex }}]" value="{{ $valKet }}">
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                                                Hotel</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DOKUMEN FORM --}}
                        <div class="detail-form {{ in_array('dokumen', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="dokumen-details">
                            <h6 class="detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <div style="clear: both;"></div>

                            @error('dokumen_parent_id')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <div class="detail-section">
                                <div class="service-grid">
                                    @php
                                        $oldDocParentsChecked = old('dokumen_parent_id', $allSelectedDocItems);
                                    @endphp
                                    @foreach ($documents as $document)
                                        <div class="document-item {{ in_array($document->id, $oldDocParentsChecked) ? 'selected' : '' }}"
                                            data-document-id="{{ $document->id }}"
                                            data-has-children="{{ $document->childrens->isNotEmpty() ? 'true' : 'false' }}"
                                            data-name="{{ $document->name }}" data-price="{{ $document->price }}">
                                            <div class="service-name">{{ $document->name }}</div>
                                            <input type="checkbox" name="dokumen_parent_id[]"
                                                value="{{ $document->id }}"
                                                {{ in_array($document->id, $oldDocParentsChecked) ? 'checked' : '' }}
                                                class="d-none">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="document-forms-container">
                                @php
                                    // 1. Helper Variables untuk Persistensi Data (Agar data tidak hilang saat error)
                                    $oldBaseDocs = old('base_documents');
                                    $oldChildDocs = old('child_documents');

                                    // 2. LOGIKA SORTING (SOLUSI URUTAN TAMPILAN)
                                    $sortedDocuments = $documents->sortBy(function ($doc) {
                                        return $doc->childrens->isEmpty();
                                    });
                                @endphp

                                @foreach ($sortedDocuments as $document)
                                    {{-- KONDISI 1: DOKUMEN DENGAN TURUNAN (CONTOH: VISA/VAKSIN) --}}
                                    @if ($document->childrens->isNotEmpty())
                                        <div class="form-group {{ in_array($document->id, $oldDocParentsChecked) ? '' : 'hidden' }} document-child-form"
                                            data-parent-id="{{ $document->id }}">

                                            <label class="form-label fw-bold mt-3">{{ $document->name }} (Pilih
                                                Jenis)</label>

                                            <div class="cars">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        // Logika Selected Child
                                                        if (!is_null($oldChildDocs)) {
                                                            $isChildSelected = in_array($child->id, $oldChildDocs);
                                                        } else {
                                                            $isChildSelected = array_key_exists(
                                                                $child->id,
                                                                $selectedDocChildren,
                                                            );
                                                        }
                                                    @endphp
                                                    <div class="child-item {{ $isChildSelected ? 'selected' : '' }}"
                                                        data-child-id="{{ $child->id }}"
                                                        data-price="{{ $child->price }}"
                                                        data-name="{{ $child->name }}">
                                                        <div class="service-name">{{ $child->name }}</div>
                                                        <div class="service-desc">Rp. {{ number_format($child->price) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="child-forms-wrapper mt-3">
                                                @foreach ($document->childrens as $child)
                                                    @php
                                                        // Hitung ulang status selected
                                                        if (!is_null($oldChildDocs)) {
                                                            $isChildSelected = in_array($child->id, $oldChildDocs);
                                                        } else {
                                                            $isChildSelected = array_key_exists(
                                                                $child->id,
                                                                $selectedDocChildren,
                                                            );
                                                        }

                                                        // Ambil Value Jumlah (Database atau Old Input)
                                                        $dbQty = $selectedDocChildren[$child->id]['jumlah'] ?? 1;
                                                        $valQty = old('jumlah_child_doc.' . $child->id, $dbQty);
                                                    @endphp

                                                    <div id="doc-child-form-{{ $child->id }}"
                                                        class="form-group mt-2 bg-white p-3 border rounded {{ $isChildSelected ? '' : 'hidden' }}">

                                                        {{-- Input Hidden ID --}}
                                                        <input type="hidden" class="dokumen_id_input"
                                                            name="child_documents[]" value="{{ $child->id }}"
                                                            {{ !$isChildSelected ? 'disabled' : '' }}>

                                                        <label class="form-label">Jumlah {{ $child->name }}</label>

                                                        {{-- Input Jumlah --}}
                                                        <input type="number"
                                                            class="form-control jumlah_doc_child_input @error('jumlah_child_doc.' . $child->id) is-invalid @enderror"
                                                            name="jumlah_child_doc[{{ $child->id }}]" min="1"
                                                            value="{{ $valQty }}"
                                                            {{ !$isChildSelected ? 'disabled' : '' }}>

                                                        {{-- Error Message --}}
                                                        @error('jumlah_child_doc.' . $child->id)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- KONDISI 2: DOKUMEN TANPA TURUNAN / BASE (CONTOH: SISKOPATUH) --}}
                                    @else
                                        @php
                                            // Logika Selected Base
                                            if (!is_null($oldBaseDocs)) {
                                                $isBaseSelected = in_array($document->id, $oldBaseDocs);
                                            } else {
                                                $isBaseSelected = array_key_exists($document->id, $selectedBaseDocs);
                                            }

                                            // Ambil Value Jumlah
                                            $dbQty = $selectedBaseDocs[$document->id]['jumlah'] ?? 1;
                                            $valQty = old('jumlah_base_doc.' . $document->id, $dbQty);
                                        @endphp

                                        <div class="form-group {{ $isBaseSelected ? '' : 'hidden' }} document-base-form mt-3 bg-white p-3 border rounded"
                                            id="doc-{{ $document->id }}-form" data-document-id="{{ $document->id }}">

                                            {{-- Input Hidden ID --}}
                                            <input type="hidden" class="dokumen_id_input" name="base_documents[]"
                                                value="{{ $document->id }}" {{ !$isBaseSelected ? 'disabled' : '' }}>

                                            <label class="form-label fw-bold">Jumlah {{ $document->name }}</label>

                                            {{-- Input Jumlah --}}
                                            <input type="number"
                                                class="form-control jumlah_doc_child_input @error('jumlah_base_doc.' . $document->id) is-invalid @enderror"
                                                name="jumlah_base_doc[{{ $document->id }}]" min="1"
                                                value="{{ $valQty }}" {{ !$isBaseSelected ? 'disabled' : '' }}>

                                            {{-- Error Message --}}
                                            @error('jumlah_base_doc.' . $document->id)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- HANDLING FORM --}}
                        <div class="detail-form {{ in_array('handling', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="handling-details">
                            @php
                                $hotelHandling = $service->handlings->firstWhere('name', 'hotel');
                                $existingHotelHandling = $hotelHandling?->handlingHotels;
                                $planeHandling = $service->handlings->firstWhere('name', 'bandara');
                                $existingPlaneHandling = $planeHandling?->handlingPlanes;
                                $oldHandlingTypes = old('handlings');

                                if (!is_null($oldHandlingTypes)) {
                                    $isHandlingHotelSelected = in_array('hotel', $oldHandlingTypes);
                                    $isHandlingPlaneSelected = in_array('bandara', $oldHandlingTypes);
                                } else {
                                    $isHandlingHotelSelected = !is_null($existingHotelHandling);
                                    $isHandlingPlaneSelected = !is_null($existingPlaneHandling);
                                }
                            @endphp

                            <h6 class="detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            <div style="clear: both;"></div>
                            @error('handlings')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <div class="detail-section">
                                <div class="service-grid">
                                    <div class="handling-item {{ $isHandlingHotelSelected ? 'selected' : '' }}"
                                        data-handling="hotel">
                                        <div class="service-name">Hotel</div>
                                        <input type="checkbox" name="handlings[]" value="hotel" class="d-none"
                                            {{ $isHandlingHotelSelected ? 'checked' : '' }}>
                                    </div>
                                    <div class="handling-item {{ $isHandlingPlaneSelected ? 'selected' : '' }}"
                                        data-handling="bandara">
                                        <div class="service-name">Bandara</div>
                                        <input type="checkbox" name="handlings[]" value="bandara" class="d-none"
                                            {{ $isHandlingPlaneSelected ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            {{-- HOTEL HANDLING FORM --}}
                            <div class="form-group {{ $isHandlingHotelSelected ? '' : 'hidden' }}"
                                id="hotel-handling-form">
                                <input type="hidden" name="handling_hotel_id"
                                    value="{{ $existingHotelHandling?->id }}">

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Nama Hotel</label>
                                        <input type="text"
                                            class="form-control @error('nama_hotel_handling') is-invalid @enderror"
                                            name="nama_hotel_handling"
                                            value="{{ old('nama_hotel_handling', $existingHotelHandling?->nama) }}">
                                        @error('nama_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_hotel_handling') is-invalid @enderror"
                                            name="tanggal_hotel_handling"
                                            value="{{ old('tanggal_hotel_handling', $existingHotelHandling?->tanggal?->format('Y-m-d')) }}">
                                        @error('tanggal_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Harga</label>
                                        <input type="number"
                                            class="form-control @error('harga_hotel_handling') is-invalid @enderror"
                                            name="harga_hotel_handling"
                                            value="{{ old('harga_hotel_handling', $existingHotelHandling?->harga) }}">
                                        @error('harga_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Pax</label>
                                        <input type="number"
                                            class="form-control @error('pax_hotel_handling') is-invalid @enderror"
                                            name="pax_hotel_handling" min="1"
                                            value="{{ old('pax_hotel_handling', $existingHotelHandling?->pax) }}">
                                        @error('pax_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Kode Booking</label>
                                        <input type="file"
                                            class="form-control @error('kode_booking_hotel_handling') is-invalid @enderror"
                                            name="kode_booking_hotel_handling">
                                        @error('kode_booking_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($existingHotelHandling?->kode_booking)
                                            <small class="d-block mt-1">File saat ini: <a
                                                    href="{{ Storage::url($existingHotelHandling->kode_booking) }}"
                                                    target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Rumlis</label>
                                        <input type="file"
                                            class="form-control @error('rumlis_hotel_handling') is-invalid @enderror"
                                            name="rumlis_hotel_handling">
                                        @error('rumlis_hotel_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($existingHotelHandling?->rumlis)
                                            <small class="d-block mt-1">File saat ini: <a
                                                    href="{{ Storage::url($existingHotelHandling->rumlis) }}"
                                                    target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label class="form-label">Identitas Koper</label>
                                    <input type="file"
                                        class="form-control @error('identitas_hotel_handling') is-invalid @enderror"
                                        name="identitas_hotel_handling">
                                    @error('identitas_hotel_handling')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($existingHotelHandling?->identitas_koper)
                                        <small class="d-block mt-1">File saat ini: <a
                                                href="{{ Storage::url($existingHotelHandling->identitas_koper) }}"
                                                target="_blank">Lihat File</a></small>
                                    @endif
                                </div>
                            </div>

                            {{-- BANDARA HANDLING FORM --}}
                            <div class="form-group {{ $isHandlingPlaneSelected ? '' : 'hidden' }}"
                                id="bandara-handling-form">
                                <input type="hidden" name="handling_bandara_id"
                                    value="{{ $existingPlaneHandling?->id }}">

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Nama Bandara</label>
                                        <input type="text"
                                            class="form-control @error('nama_bandara_handling') is-invalid @enderror"
                                            name="nama_bandara_handling"
                                            value="{{ old('nama_bandara_handling', $existingPlaneHandling?->nama_bandara) }}">
                                        @error('nama_bandara_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Jumlah Jamaah</label>
                                        <input type="number"
                                            class="form-control @error('jumlah_jamaah_handling') is-invalid @enderror"
                                            name="jumlah_jamaah_handling" min="1"
                                            value="{{ old('jumlah_jamaah_handling', $existingPlaneHandling?->jumlah_jamaah) }}">
                                        @error('jumlah_jamaah_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Harga</label>
                                        <input type="number"
                                            class="form-control @error('harga_bandara_handling') is-invalid @enderror"
                                            name="harga_bandara_handling"
                                            value="{{ old('harga_bandara_handling', $existingPlaneHandling?->harga) }}">
                                        @error('harga_bandara_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Kedatangan Jamaah</label>
                                        <input type="date"
                                            class="form-control @error('kedatangan_jamaah_handling') is-invalid @enderror"
                                            name="kedatangan_jamaah_handling"
                                            value="{{ old('kedatangan_jamaah_handling', $existingPlaneHandling?->kedatangan_jamaah?->format('Y-m-d')) }}">
                                        @error('kedatangan_jamaah_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Nama Sopir</label>
                                        <input type="text"
                                            class="form-control @error('nama_supir') is-invalid @enderror"
                                            name="nama_supir"
                                            value="{{ old('nama_supir', $existingPlaneHandling?->nama_supir) }}">
                                        @error('nama_supir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label">Paket Info</label>
                                        <input type="file"
                                            class="form-control @error('paket_info') is-invalid @enderror"
                                            name="paket_info">
                                        @error('paket_info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($existingPlaneHandling?->paket_info)
                                            <small class="d-block mt-1">File saat ini: <a
                                                    href="{{ Storage::url($existingPlaneHandling->paket_info) }}"
                                                    target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                    <div class="form-col">
                                        <label class="form-label">Identitas Koper</label>
                                        <input type="file"
                                            class="form-control @error('identitas_koper_bandara_handling') is-invalid @enderror"
                                            name="identitas_koper_bandara_handling">
                                        @error('identitas_koper_bandara_handling')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($existingPlaneHandling?->identitas_koper)
                                            <small class="d-block mt-1">File saat ini: <a
                                                    href="{{ Storage::url($existingPlaneHandling->identitas_koper) }}"
                                                    target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PENDAMPING (MUTHOWIF) FORM --}}
                        <div class="detail-form {{ in_array('pendamping', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="pendamping-details">
                            <h6 class="detail-title"><i class="bi bi-people"></i> Pendamping / Muthowif</h6>
                            <div style="clear: both;"></div>

                            {{-- Global Error --}}
                            @error('jumlah_pendamping')
                                <div class="alert alert-danger py-2 mb-2">{{ $message }}</div>
                            @enderror

                            {{-- GRID PILIHAN --}}
                            <div class="service-grid">
                                @foreach ($guides as $guide)
                                    @php
                                        // LOGIKA PERSISTENCE:
                                        // 1. Jika ada 'old' session (habis submit & error), gunakan data itu.
                                        // 2. Jika tidak, gunakan data dari database ($selectedGuides).
                                        if (old('jumlah_pendamping')) {
                                            // Cek apakah di input sebelumnya guide ini memiliki jumlah > 0
                                            $oldQty = old("jumlah_pendamping.{$guide->id}");
                                            $isGuideSelected = !empty($oldQty) && $oldQty > 0;
                                        } else {
                                            $isGuideSelected = $selectedGuides->has($guide->id);
                                        }
                                    @endphp
                                    <div class="pendamping-item {{ $isGuideSelected ? 'selected' : '' }}"
                                        data-id="{{ $guide->id }}" data-type="pendamping">
                                        <div class="service-name">{{ $guide->nama }}</div>
                                        <div class="service-desc">Rp {{ number_format($guide->harga) }}</div>
                                        {{-- Checkbox Helper --}}
                                        <input type="checkbox" class="d-none" {{ $isGuideSelected ? 'checked' : '' }}>
                                    </div>
                                @endforeach
                            </div>

                            {{-- FORM INPUT DETAIL --}}
                            <div class="detail-section">
                                @foreach ($guides as $guide)
                                    @php
                                        // Hitung ulang status selected untuk Form
                                        if (old('jumlah_pendamping')) {
                                            $oldQty = old("jumlah_pendamping.{$guide->id}");
                                            $isGuideSelected = !empty($oldQty) && $oldQty > 0;
                                        } else {
                                            $isGuideSelected = $selectedGuides->has($guide->id);
                                        }

                                        $selectedGuide = $selectedGuides->get($guide->id);

                                        // Ambil Value (Prioritas: Old Input -> Database -> Default 0)
                                        $valQty = old(
                                            "jumlah_pendamping.{$guide->id}",
                                            $selectedGuide ? $selectedGuide->jumlah : 0,
                                        );
                                        $valDari = old(
                                            "tanggal_pendamping.{$guide->id}.dari",
                                            $selectedGuide ? $selectedGuide->muthowif_dari : '',
                                        );
                                        $valSampai = old(
                                            "tanggal_pendamping.{$guide->id}.sampai",
                                            $selectedGuide ? $selectedGuide->muthowif_sampai : '',
                                        );
                                    @endphp

                                    <div id="form-pendamping-{{ $guide->id }}"
                                        class="form-group {{ $isGuideSelected ? '' : 'hidden' }} bg-white p-3 border rounded mt-2">

                                        <label class="form-label fw-bold">Jumlah {{ $guide->nama }}</label>

                                        {{-- INPUT JUMLAH --}}
                                        <input type="number"
                                            class="form-control @error('jumlah_pendamping.' . $guide->id) is-invalid @enderror"
                                            name="jumlah_pendamping[{{ $guide->id }}]" min="0"
                                            value="{{ $valQty }}" {{ !$isGuideSelected ? 'disabled' : '' }}>

                                        {{-- PESAN ERROR PER ITEM --}}
                                        @error("jumlah_pendamping.{$guide->id}")
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <div class="form-row mt-3">
                                            {{-- INPUT TANGGAL DARI --}}
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_pendamping.' . $guide->id . '.dari') is-invalid @enderror"
                                                    name="tanggal_pendamping[{{ $guide->id }}][dari]"
                                                    value="{{ $valDari }}"
                                                    {{ !$isGuideSelected ? 'disabled' : '' }}>

                                                {{-- PESAN ERROR SPESIFIK --}}
                                                @error("tanggal_pendamping.{$guide->id}.dari")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- INPUT TANGGAL SAMPAI --}}
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_pendamping.' . $guide->id . '.sampai') is-invalid @enderror"
                                                    name="tanggal_pendamping[{{ $guide->id }}][sampai]"
                                                    value="{{ $valSampai }}"
                                                    {{ !$isGuideSelected ? 'disabled' : '' }}>

                                                {{-- PESAN ERROR SPESIFIK --}}
                                                @error("tanggal_pendamping.{$guide->id}.sampai")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- KONTEN FORM --}}
                        <div class="detail-form {{ in_array('konten', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="konten-details">
                            <h6 class="detail-title"><i class="bi bi-camera"></i> Konten</h6>
                            <div style="clear: both;"></div>

                            {{-- Global Error --}}
                            @error('jumlah_konten')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            {{-- GRID PILIHAN (CHECKBOX VISUAL) --}}
                            <div class="service-grid">
                                @foreach ($contents as $content)
                                    @php
                                        // LOGIKA PERSISTENCE (Sama seperti Pendamping):
                                        // 1. Cek old data (jika validasi error) -> Cek jumlah > 0
                                        // 2. Jika tidak ada old, cek database
                                        if (old('jumlah_konten')) {
                                            $oldQty = old("jumlah_konten.{$content->id}");
                                            $isContentSelected = !empty($oldQty) && $oldQty > 0;
                                        } else {
                                            $isContentSelected = $selectedContents->has($content->id);
                                        }
                                    @endphp
                                    <div class="content-item {{ $isContentSelected ? 'selected' : '' }}"
                                        data-id="{{ $content->id }}" data-type="konten">
                                        <div class="service-name">{{ $content->name }}</div>
                                        <div class="service-desc">Rp {{ number_format($content->price) }}</div>
                                        {{-- Checkbox Helper --}}
                                        <input type="checkbox" class="d-none" {{ $isContentSelected ? 'checked' : '' }}>
                                    </div>
                                @endforeach
                            </div>

                            {{-- FORM INPUT DETAIL --}}
                            <div class="detail-section">
                                @foreach ($contents as $content)
                                    @php
                                        $selectedContent = $selectedContents->get($content->id);

                                        // Hitung ulang status selected untuk Form
                                        if (old('jumlah_konten')) {
                                            $oldQty = old("jumlah_konten.{$content->id}");
                                            $isContentSelected = !empty($oldQty) && $oldQty > 0;
                                        } else {
                                            $isContentSelected = $selectedContents->has($content->id);
                                        }

                                        // Ambil Value
                                        $valQty = old(
                                            "jumlah_konten.{$content->id}",
                                            $selectedContent ? $selectedContent->jumlah : 0,
                                        );
                                        $valDate = old(
                                            "tanggal_konten.{$content->id}",
                                            $selectedContent ? $selectedContent->tanggal_pelaksanaan : '',
                                        );
                                        $valKet = old(
                                            "keterangan_konten.{$content->id}",
                                            $selectedContent ? $selectedContent->keterangan : '',
                                        );
                                    @endphp

                                    <div id="form-konten-{{ $content->id }}"
                                        class="form-group {{ $isContentSelected ? '' : 'hidden' }} bg-white p-3 border rounded mt-2">

                                        <label class="form-label fw-bold">Jumlah {{ $content->name }}</label>

                                        {{-- INPUT JUMLAH --}}
                                        <input type="number"
                                            class="form-control @error('jumlah_konten.' . $content->id) is-invalid @enderror"
                                            name="jumlah_konten[{{ $content->id }}]" min="0"
                                            value="{{ $valQty }}" {{ !$isContentSelected ? 'disabled' : '' }}>

                                        @error("jumlah_konten.{$content->id}")
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <div class="form-row mt-3">
                                            {{-- INPUT TANGGAL --}}
                                            <div class="form-col">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_konten.' . $content->id) is-invalid @enderror"
                                                    name="tanggal_konten[{{ $content->id }}]"
                                                    value="{{ $valDate }}"
                                                    {{ !$isContentSelected ? 'disabled' : '' }}>

                                                @error("tanggal_konten.{$content->id}")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- KETERANGAN --}}
                                        <div class="form-group mt-2">
                                            <label class="form-label">Keterangan</label>
                                            <input type="text" class="form-control"
                                                name="keterangan_konten[{{ $content->id }}]"
                                                value="{{ $valKet }}"
                                                placeholder="Contoh: Dokumentasi Video di Jabal Rahmah"
                                                {{ !$isContentSelected ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- REYAL FORM --}}
                        <div class="detail-form {{ in_array('reyal', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="reyal-details">
                            <h6 class="detail-title"><i class="bi bi-currency-exchange"></i> Reyal</h6>
                            <div style="clear: both;"></div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tamis' ? 'selected' : '' }}"
                                        data-reyal-type="tamis">
                                        <h5>Tamis (Rupiah → Reyal)</h5>
                                        <input type="radio" name="tipe" value="tamis" class="d-none"
                                            {{ $oldReyalTipe == 'tamis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center p-3 card-reyal {{ $oldReyalTipe == 'tumis' ? 'selected' : '' }}"
                                        data-reyal-type="tumis">
                                        <h5>Tumis (Reyal → Rupiah)</h5>
                                        <input type="radio" name="tipe" value="tumis" class="d-none"
                                            {{ $oldReyalTipe == 'tumis' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Tamis --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tamis' ? '' : 'hidden' }}"
                                id="form-tamis">
                                <div class="form-group">
                                    <label>Jumlah Rupiah</label>
                                    <input type="number" class="form-control" id="rupiah-tamis" name="jumlah_rupiah"
                                        value="{{ old('jumlah_rupiah', $oldReyalTipe == 'tamis' ? $existingReyal?->jumlah_input : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tamis" name="kurs_tamis"
                                        value="{{ old('kurs_tamis', $oldReyalTipe == 'tamis' ? $existingReyal?->kurs : '') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Reyal</label>
                                    <input type="text" class="form-control" id="hasil-tamis" name="hasil_tamis"
                                        readonly
                                        value="{{ old('hasil_tamis', $oldReyalTipe == 'tamis' ? $existingReyal?->hasil : '') }}">
                                </div>
                            </div>

                            {{-- Form Tumis --}}
                            <div class="detail-form mt-3 {{ $oldReyalTipe == 'tumis' ? '' : 'hidden' }}"
                                id="form-tumis">
                                <div class="form-group">
                                    <label>Jumlah Reyal</label>
                                    <input type="number" class="form-control" id="reyal-tumis" name="jumlah_reyal"
                                        value="{{ old('jumlah_reyal', $oldReyalTipe == 'tumis' ? $existingReyal?->jumlah_input : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Kurs (1 Reyal = ... Rupiah)</label>
                                    <input type="number" class="form-control" id="kurs-tumis" name="kurs_tumis"
                                        value="{{ old('kurs_tumis', $oldReyalTipe == 'tumis' ? $existingReyal?->kurs : '') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Hasil dalam Rupiah</label>
                                    <input type="text" class="form-control" id="hasil-tumis" name="hasil_tumis"
                                        readonly
                                        value="{{ old('hasil_tumis', $oldReyalTipe == 'tumis' ? $existingReyal?->hasil : '') }}">
                                </div>
                            </div>

                            <label class="form-label mt-2">Tanggal penyerahan</label>
                            <input type="date" class="form-control" name="tanggal_penyerahan"
                                value="{{ old('tanggal_penyerahan', $existingReyal?->tanggal_penyerahan) }}">
                        </div>

                        {{-- TOUR FORM --}}
                        <div class="detail-form {{ in_array('tour', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="tour-details">
                            <h6 class="detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            <div style="clear: both;"></div>

                            <div class="detail-section">
                                <div class="tours service-grid">
                                    @foreach ($tours as $tour)
                                        @php
                                            $isTourSelected = !is_null($oldTourIds)
                                                ? in_array($tour->id, $oldTourIds)
                                                : $selectedTours->has($tour->id);
                                        @endphp
                                        <div class="service-tour {{ $isTourSelected ? 'selected' : '' }}"
                                            data-id="{{ $tour->id }}">
                                            <div class="service-name">{{ $tour->name }}</div>
                                            <input type="checkbox" name="tour_id[]" value="{{ $tour->id }}"
                                                class="d-none" {{ $isTourSelected ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tours as $tour)
                                @php
                                    $isTourSelected = !is_null($oldTourIds)
                                        ? in_array($tour->id, $oldTourIds)
                                        : $selectedTours->has($tour->id);
                                    $selectedTourData = $selectedTours->get($tour->id);
                                    // Tentukan transport yang dipilih
                                    $selectedTourTransportId = old(
                                        'tour_transport.' . $tour->id,
                                        $selectedTourData?->transportation_id,
                                    );
                                @endphp
                                <div id="tour-{{ $tour->id }}-form"
                                    class="tour-form detail-section {{ $isTourSelected ? '' : 'hidden' }}">
                                    <h6 class="fw-bold mb-3">Detail untuk {{ $tour->name }}</h6>

                                    {{-- Input Tanggal Tour --}}
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Tour</label>
                                        <input type="date" class="form-control"
                                            name="tour_tanggal[{{ $tour->id }}]"
                                            value="{{ old('tour_tanggal.' . $tour->id, $selectedTourData?->tanggal_keberangkatan) }}">
                                    </div>

                                    <h6 class="fw-bold mb-2">Transportasi</h6>
                                    <div class="transport-options service-grid">
                                        @foreach ($transportations as $trans)
                                            <div class="transport-option {{ $selectedTourTransportId == $trans->id ? 'selected' : '' }}"
                                                data-tour-id="{{ $tour->id }}"
                                                data-trans-id="{{ $trans->id }}">
                                                <div class="service-name">{{ $trans->nama }}</div>
                                                <div class="service-desc">Kapasitas: {{ $trans->kapasitas ?? 'N/A' }}
                                                </div>
                                                <div class="service-desc">Fasilitas: {{ $trans->fasilitas ?? 'N/A' }}
                                                </div>
                                                <div class="service-desc">Harga: Rp {{ number_format($trans->harga) }}
                                                </div>
                                                <input type="radio" name="tour_transport[{{ $tour->id }}]"
                                                    value="{{ $trans->id }}" class="d-none"
                                                    {{ $selectedTourTransportId == $trans->id ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- MEALS FORM --}}
                        <div class="detail-form {{ in_array('meals', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="meals-details">
                            <h6 class="detail-title"><i class="bi bi-egg-fried"></i> Makanan</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($meals as $meal)
                                    @php
                                        $isMealSelected = !is_null($oldMealsQty)
                                            ? array_key_exists($meal->id, $oldMealsQty)
                                            : $selectedMeals->has($meal->id);
                                    @endphp
                                    <div class="meal-item {{ $isMealSelected ? 'selected' : '' }}"
                                        data-id="{{ $meal->id }}" data-type="meal">
                                        <div class="service-name">{{ $meal->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($meal->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($meals as $meal)
                                    @php
                                        $selectedMeal = $selectedMeals->get($meal->id);
                                        $isMealSelected = !is_null($oldMealsQty)
                                            ? array_key_exists($meal->id, $oldMealsQty)
                                            : $selectedMeals->has($meal->id);
                                    @endphp
                                    <div id="form-meal-{{ $meal->id }}"
                                        class="form-group {{ $isMealSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $meal->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_meals[{{ $meal->id }}]" min="0"
                                            value="{{ old('jumlah_meals.' . $meal->id, $selectedMeal ? $selectedMeal->jumlah : 0) }}">

                                        <div class="form-row mt-3">
                                            <div class="form-col">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_dari[{{ $meal->id }}]"
                                                    value="{{ old('meals_dari.' . $meal->id, $selectedMeal ? $selectedMeal->dari_tanggal : '') }}">
                                            </div>
                                            <div class="form-col">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control"
                                                    name="meals_sampai[{{ $meal->id }}]"
                                                    value="{{ old('meals_sampai.' . $meal->id, $selectedMeal ? $selectedMeal->sampai_tanggal : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DORONGAN FORM --}}
                        <div class="detail-form {{ in_array('dorongan', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="dorongan-details">
                            <h6 class="detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($dorongan as $item)
                                    @php
                                        $isDoronganSelected = !is_null($oldDoronganQty)
                                            ? array_key_exists($item->id, $oldDoronganQty)
                                            : $selectedDorongan->has($item->id);
                                    @endphp
                                    <div class="dorongan-item {{ $isDoronganSelected ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="dorongan">
                                        <div class="service-name">{{ $item->name }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->price) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($dorongan as $item)
                                    @php
                                        $selectedItem = $selectedDorongan->get($item->id);
                                        $isDoronganSelected = !is_null($oldDoronganQty)
                                            ? array_key_exists($item->id, $oldDoronganQty)
                                            : $selectedDorongan->has($item->id);
                                    @endphp
                                    <div id="form-dorongan-{{ $item->id }}"
                                        class="form-group {{ $isDoronganSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->name }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_dorongan[{{ $item->id }}]" min="0"
                                            value="{{ old('jumlah_dorongan.' . $item->id, $selectedItem ? $selectedItem->jumlah : 0) }}">

                                        <label class="form-label mt-2">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control"
                                            name="dorongan_tanggal[{{ $item->id }}]"
                                            value="{{ old('dorongan_tanggal.' . $item->id, $selectedItem ? $selectedItem->tanggal_pelaksanaan : '') }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WAQAF FORM --}}
                        <div class="detail-form {{ in_array('waqaf', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="waqaf-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Waqaf</h6>
                            <div style="clear: both;"></div>

                            <div class="service-grid">
                                @foreach ($wakaf as $item)
                                    @php
                                        $isWakafSelected = !is_null($oldWakafQty)
                                            ? array_key_exists($item->id, $oldWakafQty)
                                            : $selectedWakaf->has($item->id);
                                    @endphp
                                    <div class="wakaf-item {{ $isWakafSelected ? 'selected' : '' }}"
                                        data-id="{{ $item->id }}" data-type="wakaf">
                                        <div class="service-name">{{ $item->nama }}</div>
                                        <div class="service-desc">Rp. {{ number_format($item->harga) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="detail-section">
                                @foreach ($wakaf as $item)
                                    @php
                                        $selectedItem = $selectedWakaf->get($item->id);
                                        $isWakafSelected = !is_null($oldWakafQty)
                                            ? array_key_exists($item->id, $oldWakafQty)
                                            : $selectedWakaf->has($item->id);
                                    @endphp
                                    <div id="form-wakaf-{{ $item->id }}"
                                        class="form-group {{ $isWakafSelected ? '' : 'hidden' }} bg-white p-3 border rounded">
                                        <label class="form-label fw-bold">Jumlah {{ $item->nama }}</label>
                                        <input type="number" class="form-control"
                                            name="jumlah_wakaf[{{ $item->id }}]" min="0"
                                            value="{{ old('jumlah_wakaf.' . $item->id, $selectedItem ? $selectedItem->jumlah : 0) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- BADAL UMRAH FORM --}}
                        <div class="detail-form {{ in_array('badal', $oldOrSelectedServices) ? '' : 'hidden' }}"
                            id="badal-details">
                            <h6 class="detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                            <div style="clear: both;"></div>

                            <button type="button" class="btn btn-sm btn-primary mb-3" id="addBadal">Tambah
                                Badal</button>
                            <div id="badalWrapper">
                                {{-- PERBAIKAN: Logika untuk memuat 'old' ATAU data 'existing' --}}
                                @if (is_array(old('nama_badal')))
                                    {{-- Jika ada data 'old' (validasi gagal), render dari 'old' --}}
                                    @foreach (old('nama_badal') as $index => $oldNamaBadal)
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]"
                                                value="{{ old('badal_id.' . $index) }}">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal" name="nama_badal[]"
                                                    value="{{ $oldNamaBadal }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0"
                                                    value="{{ old('harga_badal.' . $index) }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]" value="{{ old('tanggal_badal.' . $index) }}">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Jika tidak ada data 'old', render dari database ($existingBadals) --}}
                                    @forelse($existingBadals as $index => $badal)
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]" value="{{ $badal->id }}">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal" name="nama_badal[]"
                                                    value="{{ $badal->name }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0" value="{{ $badal->price }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]" value="{{ $badal->tanggal_pelaksanaan }}">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @empty
                                        {{-- Jika tidak ada 'old' dan 'existing', tampilkan 1 form kosong --}}
                                        <div class="badal-form bg-white p-3 border mb-3">
                                            <input type="hidden" name="badal_id[]" value="">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Nama yang dibadalkan</label>
                                                <input type="text" class="form-control nama_badal"
                                                    name="nama_badal[]">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" class="form-control harga_badal"
                                                    name="harga_badal[]" min="0">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control tanggal_badal"
                                                    name="tanggal_badal[]">
                                            </div>
                                            <div class="mt-2 text-end"><button type="button"
                                                    class="btn btn-danger btn-sm removeBadal">Hapus Badal</button></div>
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        // Ambil order terbaru yang terkait dengan service ini
                        $latestOrder = $service->orders->last();

                        // Cek apakah total_amount_final sudah terisi (lebih dari 0)
                        // Jika order tidak ada, atau total_amount_final kosong/0, maka dianggap belum final
                        $isHargaFinal = $latestOrder && $latestOrder->total_amount_final > 0;
                    @endphp

                    {{-- Tombol Aksi --}}
                    <div class="form-actions">
                        <button type="submit" name="action" value="nego" class="btn btn-primary">Simpan
                            (Nego)</button>
                        <button type="submit" name="action" value="deal" class="btn btn-success">Simpan
                            (Deal)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TEMPLATE UNTUK CLONE/DUPLIKAT --}}
    <template id="ticket-template">
        <div class="ticket-form bg-white p-3 border mb-3">
            <input type="hidden" name="plane_id[]" value=""> {{-- Pastikan ada plane_id kosong --}}
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal</label><input type="date"
                        class="form-control" name="tanggal[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Rute</label><input type="text"
                        class="form-control" name="rute[]" placeholder="Contoh: CGK - JED"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Maskapai</label><input type="text"
                        class="form-control" name="maskapai[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Keterangan</label><input type="text"
                        class="form-control" name="keterangan_tiket[]"></div>
                <div class="col-12"><label class="form-label">Jumlah (Jamaah)</label><input type="number"
                        class="form-control" name="jumlah[]"></div>
            </div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeTicket">Hapus</button>
            </div>
        </div>
    </template>

    <template id="hotel-template">
        <div class="hotel-form bg-white p-3 border mb-3" data-index="0">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkin</label><input type="date"
                        class="form-control" name="tanggal_checkin[]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Checkout</label><input type="date"
                        class="form-control" name="tanggal_checkout[]"></div>
                <div class="col-12"><label class="form-label fw-semibold">Nama Hotel</label><input type="text"
                        class="form-control" name="nama_hotel[]" placeholder="Nama hotel"></div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Tipe Kamar</label>
                    <div class="service-grid">
                        @foreach ($types as $type)
                            <div class="type-item" data-type-id="{{ $type->id }}"
                                data-price="{{ $type->jumlah }}" data-name="{{ $type->nama_tipe }}">
                                <div class="service-name">{{ $type->nama_tipe }}</div>
                                <input type="checkbox" name="type[]" value="{{ $type->nama_tipe }}" class="d-none">
                            </div>
                        @endforeach
                    </div>
                    <div class="type-input-container"></div>
                </div>
            </div>
            <div class="form-group mt-2"><label class="form-label">Total kamar</label><input type="number"
                    class="form-control" name="jumlah_kamar[]" min="0"></div>
            <div class="form-group mt-2"><label class="form-label">Keterangan</label><input type="text"
                    class="form-control" name="keterangan[]" min="0"></div>
            <div class="mt-3 text-end"><button type="button" class="btn btn-danger btn-sm removeHotel">Hapus
                    Hotel</button></div>
        </div>
    </template>

    <template id="badal-template">
        <div class="badal-form bg-white p-3 border mb-3">
            <input type="hidden" name="badal_id[]" value=""> {{-- Pastikan ada badal_id kosong --}}
            <div class="form-group mb-2"><label class="form-label">Nama yang dibadalkan</label><input type="text"
                    class="form-control nama_badal" name="nama_badal[]"></div>
            <div class="form-group mb-2"><label class="form-label">Harga</label><input type="number"
                    class="form-control harga_badal" name="harga_badal[]" min="0"></div>
            <div class="form-group mb-2"><label class="form-label">Tanggal Pelaksanaan</label><input type="date"
                    class="form-control tanggal_badal" name="tanggal_badal[]"></div>
            <div class="mt-2 text-end"><button type="button" class="btn btn-danger btn-sm removeBadal">Hapus
                    Badal</button></div>
        </div>
    </template>

    <template id="transport-set-template">
        <div class="transport-set card p-3 mt-3" data-index="0">
            <input type="hidden" name="item_id[]" value="">
            <div class="cars">
                @foreach ($transportations as $data)
                    <div class="service-car" data-id="{{ $data->id }}"
                        data-routes='@json($data->routes)' data-name="{{ $data->nama }}"
                        data-price="{{ $data->harga }}">
                        <div class="service-name">{{ $data->nama }}</div>
                        <div class="service-desc">Kapasitas: {{ $data->kapasitas }}</div>
                        <div class="service-desc">Fasilitas: {{ $data->fasilitas }}</div>
                        <div class="service-desc">Harga: {{ number_format($data->harga) }}/hari</div>
                        <input type="radio" name="transportation_id[0]" value="{{ $data->id }}">
                    </div>
                @endforeach
            </div>
            <div class="transport-details-wrapper hidden">
                <div class="route-select mt-3">
                    <label class="form-label">Pilih Rute:</label>
                    <select name="rute_id[0]" class="form-select">
                        <option value="">-- Pilih Rute --</option>
                    </select>
                </div>
                <div class="form-row mt-3">
                    <div class="form-col"><label class="form-label">Dari Tanggal</label><input type="date"
                            class="form-control" name="transport_dari[]"></div>
                    <div class="form-col"><label class="form-label">Sampai Tanggal</label><input type="date"
                            class="form-control" name="transport_sampai[]"></div>
                </div>
            </div>
            <div class="mt-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-transport">Hapus</button>
            </div>
        </div>
    </template>

    <button type="button" id="backToServicesBtn" class="btn btn-primary" title="Kembali ke Pilihan Layanan">
        <i class="bi bi-arrow-up"></i>
    </button>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ▼▼▼ JS UNTUK TOMBOL BACK TO TOP ▼▼▼
            const backToServicesBtn = document.getElementById('backToServicesBtn');
            const targetServiceGrid = document.getElementById('service-selection-grid');
            if (backToServicesBtn && targetServiceGrid) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > targetServiceGrid.offsetTop) {
                        backToServicesBtn.classList.add('show');
                    } else {
                        backToServicesBtn.classList.remove('show');
                    }
                });
                backToServicesBtn.addEventListener('click', function() {
                    targetServiceGrid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }
            // ▲▲▲ AKHIR JS BACK TO TOP ▲▲▲

            // Tombol "Kembali ke Pilihan Layanan" di dalam form
            document.querySelectorAll('.back-to-services-btn').forEach(button => {
                button.addEventListener('click', function() {
                    targetServiceGrid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // PERBAIKAN: Inisialisasi counter berdasarkan jumlah data 'old' ATAU 'existing'
            let hotelCounter = document.querySelectorAll('.hotel-form').length;
            let transportCounter =
                {{ old('item_id') ? count(old('item_id')) : ($existingTransports->count() > 0 ? $existingTransports->count() : 0) }};
            let ticketCounter =
                {{ is_array(old('plane_id')) ? count(old('plane_id')) : $existingPlanes->count() }};
            let badalCounter =
                {{ old('nama_badal') ? count(old('nama_badal')) : ($existingBadals->count() > 0 ? $existingBadals->count() : 1) }};


            // --- FUNGSI UPDATE INFO TRAVEL ---
            const travelSelect = document.getElementById('travel-select');
            const penanggungInput = document.getElementById('penanggung');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            function updateTravelInfo() {
                const selectedOption = travelSelect.options[travelSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    penanggungInput.value = selectedOption.dataset.penanggung || '';
                    emailInput.value = selectedOption.dataset.email || '';
                    phoneInput.value = selectedOption.dataset.telepon || '';
                }
            }
            travelSelect.addEventListener('change', updateTravelInfo);

            document.getElementById('addTicket').addEventListener('click', function() {
                const template = document.getElementById('ticket-template').content.cloneNode(true);
                const container = template.querySelector('.ticket-form');

                container.querySelectorAll('input, select, textarea').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace('[]', `[${ticketCounter}]`));
                    }
                });

                document.getElementById('ticketWrapper').appendChild(template);
                ticketCounter++;
            });

            document.getElementById('addHotel').addEventListener('click', function() {
                const template = document.getElementById('hotel-template').content.cloneNode(true);
                const hotelForm = template.querySelector('.hotel-form');
                hotelForm.dataset.index = hotelCounter;
                // Update name attributes for arrays
                hotelForm.querySelector('[name="hotel_id[]"]').name =
                    `hotel_id[${hotelCounter}]`;
                hotelForm.querySelector('[name="tanggal_checkin[]"]').name =
                    `tanggal_checkin[${hotelCounter}]`;
                hotelForm.querySelector('[name="tanggal_checkout[]"]').name =
                    `tanggal_checkout[${hotelCounter}]`;
                hotelForm.querySelector('[name="nama_hotel[]"]').name = `nama_hotel[${hotelCounter}]`;
                hotelForm.querySelector('[name="type_hotel[]"]').name = `type_hotel[${hotelCounter}]`;
                hotelForm.querySelector('[name="jumlah_type[]"]').name = `jumlah_type[${hotelCounter}]`;
                hotelForm.querySelector('[name="jumlah_kamar[]"]').name = `jumlah_kamar[${hotelCounter}]`;
                hotelCounter++;
                document.getElementById('hotelWrapper').appendChild(template);
            });

            document.getElementById('addBadal').addEventListener('click', function() {
                const template = document.getElementById('badal-template').content.cloneNode(true);
                const badalForm = template.querySelector('.badal-form');

                badalForm.querySelector('[name="badal_id[]"]').name = `badal_id[${badalCounter}]`;
                badalForm.querySelector('[name="nama_badal[]"]').name = `nama_badal[${badalCounter}]`;
                badalForm.querySelector('[name="harga_badal[]"]').name = `harga_badal[${badalCounter}]`;
                badalForm.querySelector('[name="tanggal_badal[]"]').name = `tanggal_badal[${badalCounter}]`;

                document.getElementById('badalWrapper').appendChild(template);
                badalCounter++;
            });

            document.getElementById('add-transport-btn').addEventListener('click', function() {
                const template = document.getElementById('transport-set-template').content.cloneNode(true);
                const transportSet = template.querySelector('.transport-set');

                const newIndex = transportCounter;
                transportSet.dataset.index = newIndex;

                transportSet.querySelector('[name="item_id[]"]').name = `item_id[${newIndex}]`;

                transportSet.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.name = `transportation_id[${newIndex}]`;
                });

                transportSet.querySelector('select').name = `rute_id[${newIndex}]`;

                // Perbaikan nama tanggal agar array multidimensi valid
                transportSet.querySelector('[name="transport_dari[]"]').name =
                    `tanggal_transport[${newIndex}][dari]`;
                transportSet.querySelector('[name="transport_sampai[]"]').name =
                    `tanggal_transport[${newIndex}][sampai]`;

                document.getElementById('new-transport-forms').appendChild(template);
                transportCounter++;
            });


            // --- EVENT LISTENER UTAMA (EVENT DELEGATION) ---
            document.body.addEventListener('click', function(e) {

                // --- 1. Klik Main Service Item ---
                const serviceItem = e.target.closest('.service-item');
                if (serviceItem) {
                    const serviceType = serviceItem.dataset.service;
                    const checkbox = serviceItem.querySelector('input[type="checkbox"]');
                    const detailForm = document.getElementById(`${serviceType}-details`);

                    // 1. Toggle Visual & Checkbox
                    serviceItem.classList.toggle('selected');
                    const isSelected = serviceItem.classList.contains('selected');
                    checkbox.checked = isSelected;

                    // 2. Toggle Form Visibility & Disabled State
                    if (detailForm) {
                        detailForm.classList.toggle('hidden', !isSelected);

                        // Logic disable/enable input (seperti kode sebelumnya)
                        detailForm.querySelectorAll('input, select, textarea, button').forEach(el => {
                            if (!el.classList.contains('back-to-services-btn')) {

                                // ▼▼▼ PERBAIKAN DIMULAI DI SINI ▼▼▼

                                // Pengecualian KHUSUS untuk service 'dokumen'
                                if (serviceType === 'dokumen' && isSelected) {
                                    // Saat MENGAKTIFKAN 'dokumen', JANGAN aktifkan
                                    // input-input spesifik ini secara paksa.
                                    // Biarkan mereka 'disabled' sampai dipilih manual.
                                    const name = el.getAttribute('name');
                                    if (name && (
                                            name.startsWith('child_documents') ||
                                            name.startsWith('jumlah_child_doc') ||
                                            name.startsWith('base_documents') ||
                                            name.startsWith('jumlah_base_doc') ||
                                            name.startsWith('customer_document_id')
                                        )) {
                                        // Lewati (return), jangan ubah status 'disabled'.
                                        // Biarkan Event 7 & 8 yang mengaturnya.
                                        return;
                                    }
                                }

                                // ▲▲▲ PERBAIKAN SELESAI ▲▲▲

                                // Logika normal:
                                // - Untuk service non-dokumen, ini akan toggle enable/disable.
                                // - Untuk service 'dokumen' saat di-UNCHECK, ini akan disable semua.
                                el.disabled = !isSelected;
                            }
                        });

                        // Scroll to view
                        if (isSelected) {
                            detailForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }

                    // PERBAIKAN 2: AUTO ADD HOTEL FORM
                    // Logika: Jika tipe Hotel dipilih, DAN wrapper masih kosong -> Klik Tambah
                    if (serviceType === 'hotel' && isSelected) {
                        const wrapper = document.getElementById('hotelWrapper');
                        if (wrapper && wrapper.children.length === 0) {
                            document.getElementById('addHotel').click();
                        }
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 2. Klik Pilihan Transportasi (Pesawat / Bus) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const transportItem = e.target.closest('.transport-item');
                if (transportItem) {
                    const type = transportItem.dataset.transportasi;
                    const form = document.getElementById(type === 'airplane' ? 'pesawat' : 'bis');
                    const checkbox = transportItem.querySelector('input');

                    transportItem.classList.toggle('selected');
                    const isSelected = transportItem.classList.contains('selected'); // Dapatkan status baru
                    checkbox.checked = isSelected;

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalam sub-form
                        form.querySelectorAll('input, select, textarea, button').forEach(el => {
                            // Jangan disable tombol "Tambah" atau "Hapus"
                            if (!el.classList.contains('removeTicket') && !el.classList.contains(
                                    'remove-transport') && !el.id.includes('addTicket') && !el.id
                                .includes('add-transport-btn')) {
                                el.disabled = !isSelected;
                            }
                        });

                        if (isSelected) {
                            // AUTO ADD FORM Jika Kosong (Fitur Baru)
                            if (type === 'bus') {
                                const wrapper = document.getElementById('new-transport-forms');
                                // Cek jika wrapper kosong (belum ada form input)
                                if (wrapper.querySelectorAll('.transport-set').length === 0) {
                                    document.getElementById('add-transport-btn').click();
                                }
                            }
                            if (type === 'airplane') {
                                const wrapper = document.getElementById('ticketWrapper');
                                if (wrapper.querySelectorAll('.ticket-form').length === 0) {
                                    document.getElementById('addTicket').click();
                                }
                            }
                        }
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 3. Klik Pilihan Handling (Hotel / Bandara) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const handlingItem = e.target.closest('.handling-item');
                if (handlingItem) {
                    const type = handlingItem.dataset.handling;
                    const form = document.getElementById(type === 'hotel' ? 'hotel-handling-form' :
                        'bandara-handling-form');
                    const checkbox = handlingItem.querySelector('input');

                    handlingItem.classList.toggle('selected');
                    const isSelected = handlingItem.classList.contains('selected'); // Dapatkan status baru
                    checkbox.checked = isSelected;

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalamnya
                        form.querySelectorAll('input, select, textarea').forEach(el => {
                            el.disabled = !isSelected;
                        });
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 4. Klik Item Pilihan (Pendamping, Konten, Meal, dll) ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const toggleItem = e.target.closest(
                    '.pendamping-item, .content-item, .meal-item, .dorongan-item, .wakaf-item, .service-tour'
                );
                if (toggleItem) {
                    const type = toggleItem.dataset.type || (toggleItem.classList.contains('service-tour') ?
                        'tour' : null);
                    const id = toggleItem.dataset.id;

                    if (type && id) {
                        const form = document.getElementById(`form-${type}-${id}`) || document
                            .getElementById(`${type}-${id}-form`);
                        const isSelected = toggleItem.classList.toggle('selected');

                        if (form) {
                            form.classList.toggle('hidden', !isSelected);
                            // 💡 PERBAIKAN UTAMA: Nonaktifkan input di dalamnya
                            form.querySelectorAll('input, select, textarea').forEach(el => {
                                el.disabled = !isSelected;
                            });

                            const qtyInput = form.querySelector('input[type="number"]');
                            if (qtyInput) {
                                if (isSelected && (qtyInput.value === '0' || qtyInput.value === '')) {
                                    qtyInput.value = 1;
                                }
                            }
                        }

                        if (type === 'tour') {
                            const tourCheckbox = toggleItem.querySelector('input[type="checkbox"]');
                            if (tourCheckbox) tourCheckbox.checked = isSelected;
                        }
                    }
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲

                // --- 5. Klik Pilihan Transportasi untuk Tour ---
                const tourTransportOption = e.target.closest('.transport-option');
                if (tourTransportOption) {
                    const group = tourTransportOption.closest('.transport-options');
                    group.querySelectorAll('.transport-option').forEach(opt => {
                        if (opt !== tourTransportOption) {
                            opt.classList.remove('selected');
                            opt.querySelector('input[type="radio"]').checked = false;
                        }
                    });

                    tourTransportOption.classList.add('selected');
                    tourTransportOption.querySelector('input[type="radio"]').checked = true;
                }

                // --- 6. Klik Pilihan Transportasi Darat (Bus/Mobil) ---
                const serviceCar = e.target.closest('.service-car');
                if (serviceCar) {
                    const transportSet = serviceCar.closest('.transport-set');
                    // Ganti routeSelectDiv agar menarget class wrapper yang baru kita buat
                    const detailsWrapper = transportSet.querySelector(
                        '.transport-details-wrapper'); // Wrapper baru
                    const routeSelectDiv = transportSet.querySelector(
                        '.route-select'); // Select lama (opsional jika wrapper sudah ada)
                    const routeSelect = transportSet.querySelector('select[name^="rute_id"]');

                    transportSet.querySelectorAll('.service-car').forEach(car => {
                        if (car !== serviceCar) {
                            car.classList.remove('selected');
                            car.querySelector('input[type="radio"]').checked = false;
                        }
                    });

                    serviceCar.classList.add('selected');
                    serviceCar.querySelector('input[type="radio"]').checked = true;

                    const routes = JSON.parse(serviceCar.dataset.routes || '[]');
                    routeSelect.innerHTML = '<option value="">-- Pilih Rute --</option>';
                    routes.forEach(route => {
                        routeSelect.innerHTML +=
                            `<option value="${route.id}" data-price="${route.price}">${route.route} - Rp. ${parseInt(route.price).toLocaleString('id-ID')}</option>`;
                    });
                    if (detailsWrapper) detailsWrapper.classList.remove('hidden');
                    if (routeSelectDiv) routeSelectDiv.classList.remove('hidden');
                }

                // --- 7. Klik Pilihan Dokumen (Parent) ---
                const documentItem = e.target.closest('.document-item');
                if (documentItem) {
                    const docId = documentItem.dataset.documentId;
                    const hasChildren = documentItem.dataset.hasChildren === 'true';
                    const checkbox = documentItem.querySelector('input');

                    documentItem.classList.toggle('selected');
                    const isSelected = documentItem.classList.contains('selected');
                    checkbox.checked = isSelected;

                    let form;
                    if (hasChildren) {
                        form = document.querySelector(`.document-child-form[data-parent-id="${docId}"]`);
                    } else {
                        form = document.getElementById(`doc-${docId}-form`);
                    }

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);

                        // ▼▼▼ PERBAIKAN DIMULAI DI SINI ▼▼▼
                        form.querySelectorAll('input, select').forEach(input => {

                            // Pengecualian KHUSUS untuk parent yang punya 'children' (e.g. Visa)
                            if (hasChildren && isSelected) {
                                // Saat MENGAKTIFKAN parent ('Visa'), JANGAN aktifkan
                                // input-input child-nya secara paksa.
                                const name = input.getAttribute('name');
                                if (name && (
                                        name.startsWith('child_documents') ||
                                        name.startsWith('jumlah_child_doc') ||
                                        name.startsWith('customer_document_id')
                                    )) {
                                    // Lewati (return), biarkan 'disabled'.
                                    // Event 8 (klik child) yang akan mengaturnya.
                                    return;
                                }
                            }

                            // Logika normal:
                            // - Untuk 'base' doc (Siskopatuh), ini akan toggle enable/disable (INI BENAR).
                            // - Untuk 'parent' doc (Visa) saat di-UNCHECK, ini akan disable semua (INI BENAR).
                            input.disabled = !isSelected;
                        });
                        // ▲▲▲ AKHIR PERBAIKAN ▲▲▲
                    }
                }

                // --- 8. Klik Pilihan Dokumen (Anak) ---
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const childId = childItem.dataset.childId;
                    const form = document.getElementById(`doc-child-form-${childId}`);

                    childItem.classList.toggle('selected');
                    const isSelected = childItem.classList.contains('selected');

                    if (form) {
                        form.classList.toggle('hidden', !isSelected);
                        form.querySelectorAll('input, select').forEach(input => {
                            input.disabled = !isSelected;
                        });
                    }
                }

                // --- 9. Tombol Hapus Dinamis ---
                const removeAction = (e, wrapperId, itemClass, minItems = 0, alertMsg =
                    'Minimal harus ada 1 form.') => {
                    const wrapper = e.target.closest(wrapperId);
                    if (wrapper.querySelectorAll(itemClass).length > minItems) {
                        e.target.closest(itemClass).remove();
                    } else {
                        if (minItems > 0) alert(alertMsg);
                        else e.target.closest(itemClass).remove();
                    }
                };

                if (e.target.matches('.removeTicket')) {
                    removeAction(e, '#ticketWrapper', '.ticket-form', 0);
                }
                if (e.target.matches('.remove-transport')) {
                    removeAction(e, '#new-transport-forms', '.transport-set', 0);
                }
                if (e.target.matches('.removeHotel')) {
                    removeAction(e, '#hotelWrapper', '.hotel-form', 0);
                }
                if (e.target.matches('.removeBadal')) {
                    removeAction(e, '#badalWrapper', '.badal-form', 0);
                }

                // --- 10. Klik Reyal ---
                // ▼▼▼ BLOK INI TELAH DIPERBAIKI ▼▼▼
                const reyalCard = e.target.closest('.card-reyal');
                if (reyalCard) {
                    document.querySelectorAll('.card-reyal').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('.card-reyal input[type="radio"]').forEach(radio => radio
                        .checked = false);
                    reyalCard.classList.add('selected');
                    const type = reyalCard.dataset.reyalType;
                    const radioInput = reyalCard.querySelector('input[type="radio"]');
                    if (radioInput) radioInput.checked = true;

                    const formTamis = document.getElementById('form-tamis');
                    const formTumis = document.getElementById('form-tumis');
                    formTamis.classList.toggle('hidden', type !== 'tamis');
                    formTumis.classList.toggle('hidden', type !== 'tumis');

                    // 💡 PERBAIKAN UTAMA: Nonaktifkan input di form yang tersembunyi
                    formTamis.querySelectorAll('input').forEach(el => el.disabled = (type !== 'tamis'));
                    formTumis.querySelectorAll('input').forEach(el => el.disabled = (type !== 'tumis'));
                }
                // ▲▲▲ AKHIR BLOK PERBAIKAN ▲▲▲
            });

            // --- Kalkulasi Reyal (Sama seperti create) ---
            document.body.addEventListener('input', function(e) {
                const input = e.target;
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
            // --- HOTEL LOGIC (Disalin dari Create) ---

            // Fungsi hitung total kamar
            function updateJumlahKamarTotal(hotelForm) {
                let totalKamar = 0;
                hotelForm.querySelectorAll('.qty-input-hotel[data-is-qty="true"]').forEach(input => {
                    totalKamar += parseInt(input.value) || 0;
                });
                const target = hotelForm.querySelector('input[name^="jumlah_kamar"]');
                if (target) target.value = totalKamar;
            }

            function addQtyChangeListener(input, hotelForm) {
                input.addEventListener('input', function() {
                    updateJumlahKamarTotal(hotelForm);
                });
            }

            // Inisialisasi listener untuk input yang sudah ada saat halaman dimuat
            document.querySelectorAll('.hotel-form').forEach(form => {
                form.querySelectorAll('.qty-input-hotel').forEach(inp => addQtyChangeListener(inp, form));
                // Hitung ulang total saat load (opsional, jika data DB belum sinkron)
                updateJumlahKamarTotal(form);
            });

            // Event Listener untuk Grid Tipe Kamar
            const hotelWrapper = document.getElementById('hotelWrapper');
            if (hotelWrapper) {
                hotelWrapper.addEventListener('click', function(e) {
                    const typeItem = e.target.closest('.type-item');

                    // Cek jika yang diklik adalah type-item dan form induknya sedang aktif (tidak disabled/hidden)
                    // Di halaman Edit, form hotel mungkin hidden jika service 'hotel' tidak dicentang.
                    // Namun karena kita pakai event delegation di body untuk toggle disable, kita asumsikan jika bisa diklik maka aktif.

                    if (typeItem) {
                        const hotelForm = typeItem.closest('.hotel-form');

                        // Cek apakah input di dalam form ini disabled? Jika ya, hentikan interaksi
                        if (hotelForm.closest('.detail-form').classList.contains('hidden')) return;

                        const container = hotelForm.querySelector('.type-input-container');
                        const typeId = typeItem.dataset.typeId;
                        const name = typeItem.dataset.name;
                        const price = parseInt(typeItem.dataset.price) || 0;
                        const index = hotelForm.dataset.index; // Pastikan data-index ada di .hotel-form

                        const chk = typeItem.querySelector('input[type="checkbox"]');
                        const existing = container.querySelector(`[data-type-id="${typeId}"]`);

                        if (existing) {
                            // UNSELECT: Hapus input
                            existing.remove();
                            typeItem.classList.remove('selected');
                            if (chk) chk.checked = false;
                        } else {
                            // SELECT: Tambah input
                            typeItem.classList.add('selected');
                            if (chk) chk.checked = true;

                            const div = document.createElement('div');
                            div.className = 'form-group mt-2 bg-white p-3 border rounded';
                            div.dataset.typeId = typeId;

                            // Generate HTML Input
                            div.innerHTML = `
                        <label class="form-label">Jumlah Kamar (${name})</label>
                        <input type="number" class="form-control qty-input-hotel"
                            name="hotel_data[${index}][${typeId}][jumlah]"
                            min="1" value="1" data-is-qty="true" data-type-id="${typeId}">

                        <label class="form-label mt-2">Harga</label>
                        <input type="text" class="form-control"
                            name="hotel_data[${index}][${typeId}][harga]"
                            value="${price.toLocaleString('id-ID')}" readonly>

                        <input type="hidden" name="hotel_data[${index}][${typeId}][type_name]" value="${name}">
                    `;
                            container.appendChild(div);

                            const newInp = div.querySelector('.qty-input-hotel');
                            addQtyChangeListener(newInp, hotelForm);
                        }
                        updateJumlahKamarTotal(hotelForm);
                    }
                });
            }

            // Update logika tombol "Tambah Hotel" agar menggunakan data-index yang benar
            const addHotelBtn = document.getElementById('addHotel');
            if (addHotelBtn) {
                // Clone button untuk clear event listener lama (best practice jika ada duplikasi script)
                const newBtn = addHotelBtn.cloneNode(true);
                addHotelBtn.parentNode.replaceChild(newBtn, addHotelBtn);

                newBtn.addEventListener('click', function() {
                    const template = document.getElementById('hotel-template').content.cloneNode(true);
                    const hotelForm = template.querySelector('.hotel-form');

                    // Gunakan Counter yang sudah disinkronkan dengan DOM
                    hotelForm.dataset.index = hotelCounter;

                    // Update attribut name
                    hotelForm.querySelector('[name="tanggal_checkin[]"]').name =
                        `tanggal_checkin[${hotelCounter}]`;
                    hotelForm.querySelector('[name="tanggal_checkout[]"]').name =
                        `tanggal_checkout[${hotelCounter}]`;
                    hotelForm.querySelector('[name="nama_hotel[]"]').name = `nama_hotel[${hotelCounter}]`;
                    hotelForm.querySelector('[name="jumlah_kamar[]"]').name =
                        `jumlah_kamar[${hotelCounter}]`;
                    hotelForm.querySelector('[name="keterangan[]"]').name = `keterangan[${hotelCounter}]`;

                    // Tambahkan hidden ID untuk row baru (agar konsisten dengan loop Blade)
                    const hiddenId = document.createElement('input');
                    hiddenId.type = 'hidden';
                    hiddenId.name = `hotel_id[${hotelCounter}]`;
                    hiddenId.value = ''; // Kosong karena baru
                    hotelForm.prepend(hiddenId);

                    document.getElementById('hotelWrapper').appendChild(template);

                    // Increment counter
                    hotelCounter++;
                });
            }
        });
    </script>
@endpush
