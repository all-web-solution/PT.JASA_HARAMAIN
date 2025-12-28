@extends('admin.master')
@section('title', 'Detail Order')
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
            --success-color: #198754;
        }

        .payment-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd;
        }

        /* ===== Card Styling ===== */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            background-color: #fff;
            overflow: hidden;
            /* Ensures child elements respect border radius */
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            font-size: 1.4rem;
            color: var(--haramain-secondary);
        }

        /* ===== Table Styling ===== */
        .table-responsive {
            padding: 1rem 1.5rem 1.5rem;
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
            padding: 1rem;
            border-bottom: 2px solid var(--border-color);
            text-align: left;
            font-size: 0.85rem;
        }

        .table tbody tr {
            background-color: #fff;
            transition: background-color 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .table tbody td {
            padding: 1.1rem;
            vertical-align: top;
            /* Changed to top for better alignment of long content */
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

        .service-details strong {
            color: var(--haramain-primary);
            display: inline-block;
            margin-top: 0.5rem;
        }

        .service-details strong:first-child {
            margin-top: 0;
        }

        /* ===== Payment Form Styling ===== */
        .payment-form-container {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--haramain-secondary);
            box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.15);
        }

        .btn-submit {
            background-color: var(--success-color);
            color: #fff;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #157347;
            transform: translateY(-2px);
        }


        /* ===== Responsiveness ===== */
        @media (max-width: 992px) {
            .payment-container {
                padding: 1rem;
            }

            .card-title .full-text {
                display: none;
            }

            .card-title .short-text {
                display: inline;
            }

            .table thead {
                display: none;
            }

            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1.5rem;
                border: 1px solid var(--border-color);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 0.8rem 1rem;
                border: none;
                border-bottom: 1px solid #e9ecef;
            }

            .table tr td:last-child {
                border-bottom: none;
            }

            .table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                text-align: left;
                margin-right: 1rem;
            }

            /* Special handling for the long service details column */
            .table td.service-details {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .table td.service-details:before {
                margin-bottom: 0.75rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid var(--border-color);
                width: 100%;
            }
        }
    </style>
@endpush
@section('content')
    <div class="payment-container">
        <!-- Order Details Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span class="full-text">Detail Order: {{ $order->invoice }}</span>
                    <span class="short-text" style="display: none;">#{{ $order->invoice }}</span>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Unik</th>
                            <th>Customer/Travel</th>
                            <th>Keberangkatan</th>
                            <th>Kepulangan</th>
                            <th>Jamaah</th>
                            <th>Layanan Dipilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->service)
                            <tr>
                                <td data-label="Kode Unik">{{ $order->service->unique_code }}</td>
                                <td data-label="Customer">{{ $order->service->pelanggan->nama_travel }}</td>
                                <td data-label="Berangkat">
                                    {{ \Carbon\Carbon::parse($order->service->tanggal_keberangkatan)->format('d M Y') }}
                                </td>
                                <td data-label="Pulang">
                                    {{ \Carbon\Carbon::parse($order->service->tanggal_kepulangan)->format('d M Y') }}</td>
                                <td data-label="Jamaah">{{ $order->service->total_jamaah }}</td>
                                <td data-label="Layanan Dipilih" class="service-details"
                                    style="text-align: left; white-space: normal; min-width: 250px;">
                                    @php $hasContent = false; @endphp

                                    @if ($order->service->planes->count() > 0 || $order->service->transportationItem->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Transportasi:</strong><br>
                                        @foreach ($order->service->planes as $plane)
                                            - (Udara) {{ $plane->maskapai }} [{{ $plane->rute }}]<br>
                                        @endforeach
                                        @foreach ($order->service->transportationItem as $item)
                                            - (Darat) {{ $item->transportation->nama }} [{{ $item->route->route }}]<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->hotels->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Hotel:</strong><br>
                                        @foreach ($order->service->hotels as $hotel)
                                            - {{ $hotel->nama_hotel }}
                                            @if ($hotel->type)
                                                ({{ $hotel->type }} - {{ $hotel->jumlah_type ?? 0 }} kamar)
                                            @endif
                                            <br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->documents->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Dokumen:</strong><br>
                                        @foreach ($order->service->documents as $doc)
                                            -
                                            @if ($doc->documentChild)
                                                {{ $doc->documentChild->name }}
                                            @elseif ($doc->document)
                                                {{ $doc->document->name }}
                                            @endif
                                            ({{ $doc->jumlah }} Pax)
                                            <br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->handlings->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Handling:</strong><br>
                                        @foreach ($order->service->handlings as $handling)
                                            - Handling {{ ucfirst($handling->name) }}
                                            {{ $handling->handlingHotels?->first()?->nama ?? ($handling->handlingPlanes?->first()?->nama_bandara ?? 'N/A') }})
                                            <br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->guides->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Pendamping:</strong><br>
                                        @foreach ($order->service->guides as $guide)
                                            - {{ $guide->guideItem->nama ?? 'N/A' }} ({{ $guide->jumlah }} Orang)<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->contents->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Konten:</strong><br>
                                        @foreach ($order->service->contents as $content)
                                            - {{ $content->content->name ?? 'N/A' }} ({{ $content->jumlah }} Pax)<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->exchanges->count() > 0)
                                        @php
                                            $hasContent = true;
                                            $reyal = $order->service->exchanges->first();
                                        @endphp
                                        <strong>Reyal:</strong><br>
                                        - Penukaran {{ $reyal->tipe }}
                                        ({{ $reyal->tipe == 'tamis' ? 'SAR → SAR' : 'SAR → SAR' }})<br>
                                    @endif

                                    @if ($order->service->tours->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Tour:</strong><br>
                                        @foreach ($order->service->tours as $tour)
                                            - {{ $tour->tourItem->name ?? 'N/A' }}
                                            @if ($tour->transportation)
                                                (Transport: {{ $tour->transportation->nama }})
                                            @endif
                                            <br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->meals->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Makanan:</strong><br>
                                        @foreach ($order->service->meals as $meal)
                                            - {{ $meal->mealItem->name }} (SAR.
                                            {{ number_format($meal->mealItem->price, 0, ',', '.') }})<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->dorongans->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Dorongan:</strong><br>
                                        @foreach ($order->service->dorongans as $item)
                                            - {{ $item->dorongan->name ?? 'N/A' }} ({{ $item->jumlah }} Pax)<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->wakafs->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Waqaf:</strong><br>
                                        @foreach ($order->service->wakafs as $item)
                                            - {{ $item->wakaf->nama ?? 'N/A' }} ({{ $item->jumlah }} Unit)<br>
                                        @endforeach
                                    @endif

                                    @if ($order->service->badals->count() > 0)
                                        @php $hasContent = true; @endphp
                                        <strong>Badal Umrah:</strong><br>
                                        @foreach ($order->service->badals as $item)
                                            - Atas Nama: {{ $item->name }}<br>
                                        @endforeach
                                    @endif

                                    @if (!$hasContent)
                                        <span>Tidak ada detail layanan.</span>
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="6" class="text-center" style="text-align: center;">Tidak ada layanan yang
                                    terkait dengan order ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Form Card -->
        @if ($order->status_pembayaran === 'belum_bayar')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-credit-card"></i>
                        <span>Input Pembayaran</span>
                    </h5>
                </div>
                <div class="payment-form-container">
                    <form action="{{ route('orders.payment', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="jumlah_dibayarkan" class="form-label">Jumlah yang Dibayarkan (SAR)</label>
                            <input type="number" step="any" class="form-control" id="jumlah_dibayarkan"
                                name="jumlah_dibayarkan" placeholder="Contoh: 1500.50" required>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle"></i> Simpan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        @endif
        <a href="{{ route('invoice.show', $order->service->id) }}">
            <button class="btn btn-primary mt-3">
                Cetak Invoice
            </button>
        </a>
    </div>
@endsection
