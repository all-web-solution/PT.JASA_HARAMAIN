<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->invoice }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1a4b8c;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1a4b8c;
            text-align: center;
        }

        .company-info {
            text-align: center;
            font-size: 10px;
            line-height: 1.4;
        }

        .invoice-details {
            width: 100%;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Style untuk label dan value agar rapi */
        .info-label {
            font-weight: bold;
            width: 100px;
            vertical-align: top;
            /* Lebar label tetap */
            padding: 3px 0;
        }

        .info-value {
            padding: 3px 0;
        }

        .section-title {
            text-align: center;
            margin: 0 0 20px 0;
            color: #1a4b8c;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.items th {
            background-color: #f0f7ff;
            color: #1a4b8c;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-size: 11px;
            text-transform: uppercase;
        }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .total-section {
            width: 100%;
            text-align: right;
        }

        .grand-total {
            font-size: 16px;
            color: #1a4b8c;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        /* Helper */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 3px 8px;
            color: white;
            background: #28a745;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-warning {
            background: #ffc107;
            color: #000;
        }

        .badge-danger {
            background: #dc3545;
        }

        strong {
            color: #000;
        }

        small {
            color: #666;
            font-size: 11px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="logo">{{ $company['name'] }}</div>
        <div class="company-info">
            {{ $company['address'] }}<br>
            Telp: {{ $company['phone'] }} | Email: {{ $company['email'] }}
        </div>
        <div style="clear: both;"></div>
    </div>

    {{-- INFO CUSTOMER & INVOICE --}}
    <h2 class="section-title">INVOICE</h2>

    {{-- INFO CUSTOMER & INVOICE (Menggunakan Tabel Layout 2 Kolom) --}}
    <div class="invoice-details">
        <table width="100%">
            <tr>
                {{-- KOLOM KIRI: Info Customer --}}
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td class="info-label">Ditujukan Kepada</td>
                            <td class="info-value">: <strong>{{ $client->nama_travel }}</strong></td>
                        </tr>
                        <tr>
                            <td class="info-label">Attn</td>
                            <td class="info-value">: {{ $client->penanggung_jawab }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">No. Telepon</td>
                            <td class="info-value">: {{ $client->phone }}</td>
                        </tr>
                    </table>
                </td>

                {{-- KOLOM KANAN: Info Invoice --}}
                <td width="50%" valign="top">
                    <table align="right"> {{-- align right agar tabel anak mepet kanan --}}
                        <tr>
                            <td class="info-label">No. Invoice</td>
                            <td class="info-value">: {{ $order->invoice }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal</td>
                            <td class="info-value">: {{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Status</td>
                            <td class="info-value">
                                @php
                                    $statusLabel = strtoupper(str_replace('_', ' ', $order->status_pembayaran));
                                    $color = '#000'; // Default hitam
                                    if ($order->status_pembayaran == 'lunas') {
                                        $color = '#28a745';
                                    }
                                    // Hijau
                                    elseif ($order->status_pembayaran == 'belum_lunas') {
                                        $color = '#ffc107';
                                    }
                                    // Kuning/Oranye
                                    elseif ($order->status_pembayaran == 'belum_bayar') {
                                        $color = '#dc3545';
                                    } // Merah
                                @endphp
                                : <span
                                    style="font-weight: bold; color: {{ $color }};">{{ $statusLabel }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- TABEL ITEM --}}
    <table class="items">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="50%">Deskripsi Layanan</th>
                <th width="35%" class="text-center"></th>
                <th width="15%" class="text-right">Jumlah (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp

            {{-- 1. Hotel --}}
            @foreach ($service->hotels as $hotel)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Hotel: {{ $hotel->nama_hotel }}</strong><br>
                        <small>{{ $hotel->type }} | Checkin:
                            {{ \Carbon\Carbon::parse($hotel->tanggal_checkin)->format('d M') }} - Checkout:
                            {{ \Carbon\Carbon::parse($hotel->tanggal_checkout)->format('d M') }}</small>
                    </td>
                    <td class="text-center">
                        {{ $hotel->jumlah_type }} Kamar<br>
                    </td>
                    {{-- Rumus: (Harga * Jml Tipe) * Malam --}}
                    @php
                        $malam =
                            \Carbon\Carbon::parse($hotel->tanggal_checkin)->diffInDays($hotel->tanggal_checkout) ?: 1;
                        if ($hotel->harga_jual && $hotel->harga_jual > 0) {
                            $subtotal = $hotel->harga_jual * $hotel->jumlah_type * $malam;
                            $desc = 'Harga Final';
                        } else {
                            $subtotal = $hotel->harga_perkamar * $hotel->jumlah_type * $malam;
                            $desc = 'Harga Estimasi';
                        }
                        $subtotal = $hotel->harga_perkamar * $hotel->jumlah_type * $malam;
                    @endphp
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }} <br>
                        <small>{{ $desc }}</small>
                    </td>
                </tr>
            @endforeach

            {{-- 2. Pesawat --}}
            @foreach ($service->planes as $plane)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Tiket Pesawat: {{ $plane->maskapai }}</strong><br>
                        <small>Rute: {{ $plane->rute }} | Tgl:
                            {{ \Carbon\Carbon::parse($plane->tanggal_keberangkatan)->format('d M Y') }}</small>
                    </td>
                    <td class="text-center">{{ $plane->jumlah_jamaah }} Seat</td>
                    @if ($plane->harga_jual)
                        <td class="text-right">Rp
                            {{ number_format($plane->harga_jual * $plane->jumlah_jamaah, 0, ',', '.') }} <br>
                            <small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format($plane->harga * $plane->jumlah_jamaah, 0, ',', '.') }} <br> <small>Harga
                                Estimasi</small> </td>
                    @endif
                </tr>
            @endforeach

            {{-- 3. Transportasi Darat --}}
            @foreach ($service->transportationItem as $trans)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Transportasi Darat: {{ $trans->transportation->nama ?? 'Bus' }}</strong><br>
                        <small>
                            Rute: {{ $trans->route->route ?? '-' }} |
                            {{ \Carbon\Carbon::parse($trans->dari_tanggal)->format('d M') }} s/d
                            {{ \Carbon\Carbon::parse($trans->sampai_tanggal)->format('d M') }}
                        </small>
                    </td>
                    <td class="text-center">
                        @php $days = \Carbon\Carbon::parse($trans->dari_tanggal)->diffInDays($trans->sampai_tanggal) + 1; @endphp
                        {{ $days }} Hari
                    </td>
                    {{-- Rumus: ((Harga Harian * Hari) + Harga Rute) --}}
                    @php
                        if ($trans->harga_jual) {
                            $dailyPrice = $trans->harga_jual ?? 0;
                            $transDesc = 'Harga Final';
                        } else {
                            $dailyPrice = $trans->transportation->harga ?? 0;
                            $transDesc = 'Harga Estimasi';
                        }
                        $routePrice = $trans->route->price ?? 0;
                        $subtotal = $dailyPrice * $days + $routePrice;
                    @endphp
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }} <br>
                        <small>{{ $transDesc }}</small>
                    </td>
                </tr>
            @endforeach

            {{-- 4. Handling (Hotel & Bandara) --}}
            @foreach ($service->handlings as $handling)
                {{-- Handling Hotel --}}
                @if ($handling->handlingHotels)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            <strong>Handling Hotel: {{ $handling->handlingHotels->nama }}</strong><br>
                            <small>Tgl:
                                {{ \Carbon\Carbon::parse($handling->handlingHotels->tanggal)->format('d M Y') }}</small>
                        </td>
                        <td class="text-center">{{ $handling->handlingHotels->pax }} Pax</td>
                        @if ($handling->handlingHotels->harga_jual && $handling->handlingHotels->harga_jual > 0)
                            <td class="text-right">Rp
                                {{ number_format($handling->handlingHotels->harga_jual, 0, ',', '.') }} <br>
                                <small>Harga Final</small>
                            </td>
                        @else
                            <td class="text-right">Rp
                                {{ number_format($handling->handlingHotels->harga, 0, ',', '.') }} <br> <small>Harga
                                    Estimasi</small>
                            </td>
                        @endif
                    </tr>
                @endif

                {{-- Handling Bandara --}}
                @if ($handling->handlingPlanes)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            <strong>Handling Bandara: {{ $handling->handlingPlanes->nama_bandara }}</strong><br>
                            <small>Supir: {{ $handling->handlingPlanes->nama_supir }}</small>
                        </td>
                        <td class="text-center">{{ $handling->handlingPlanes->jumlah_jamaah }} Jamaah</td>
                        @if ($handling->handlingPlanes->harga_jual && $handling->handlingPlanes->harga_jual > 0)
                            <td class="text-right">Rp
                                {{ number_format($handling->handlingPlanes->harga_jual, 0, ',', '.') }} <br>
                                <small>Harga Final</small>
                            </td>
                        @else
                            <td class="text-right">Rp
                                {{ number_format($handling->handlingPlanes->harga, 0, ',', '.') }} <br> <small>Harga
                                    Estimasi</small>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach

            {{-- 5. Dokumen --}}
            @foreach ($service->documents as $doc)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Dokumen: {{ $doc->document->name ?? 'Dokumen' }}</strong>
                        @if ($doc->documentChild)
                            <br><small>({{ $doc->documentChild->name }})</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $doc->jumlah }} Pcs</td>
                    @if ($doc->harga_jual && $doc->harga_jual > 0)
                        <td class="text-right">Rp
                            {{ number_format($doc->harga_jual * $doc->jumlah, 0, ',', '.') }} <br>
                            <small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format($doc->harga * $doc->jumlah, 0, ',', '.') }} <br> <small>Harga
                                Estimasi</small>
                        </td>
                    @endif
                    {{-- <td class="text-right">Rp {{ number_format($doc->harga * $doc->jumlah, 0, ',', '.') }}</td> --}}
                </tr>
            @endforeach

            {{-- 6. Tour --}}
            @foreach ($service->tours as $tour)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Paket Tour: {{ $tour->tourItem->name ?? 'City Tour' }}</strong><br>
                        <small>Transport: {{ $tour->transportation->nama ?? '-' }} | Tgl:
                            {{ \Carbon\Carbon::parse($tour->tanggal_keberangkatan)->format('d M Y') }}</small>
                    </td>
                    <td class="text-center">1 Paket</td>
                    {{-- Rumus: Harga Tour + Harga Transport --}}
                    @php
                        if ($tour->harga_jual) {
                            $subtotal = $tour->harga_jual;
                            $tourDesc = 'Harga Final';
                        } else {
                            $subtotal = ($tour->tourItem->price ?? 0) + ($tour->transportation->harga ?? 0);
                            $tourDesc = 'Harga Estimasi';
                        }
                    @endphp
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }} <br>
                        <small>{{ $tourDesc }}</small>
                    </td>
                </tr>
            @endforeach

            {{-- 7. Meals --}}
            @foreach ($service->meals as $meal)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Meals: {{ $meal->mealItem->name ?? 'Menu' }}</strong></td>
                    <td class="text-center">{{ $meal->jumlah }} Pcs</td>
                    @if ($meal->harga_jual)
                        <td class="text-right">Rp
                            {{ number_format(($meal->harga_jual ?? 0) * $meal->jumlah, 0, ',', '.') }} <br>
                            <small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format(($meal->mealItem->price ?? 0) * $meal->jumlah, 0, ',', '.') }} <br>
                            <small>Harga Estimasi</small>
                        </td>
                    @endif
                </tr>
            @endforeach

            {{-- 8. Guides (Muthowif) --}}
            @foreach ($service->guides as $guide)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Muthowif: {{ $guide->guideItem->nama ?? 'Guide' }}</strong></td>
                    <td class="text-center">{{ $guide->jumlah }} Orang</td>
                    @if ($guide->harga_jual && $guide->harga_jual > 0)
                        <td class="text-right">Rp
                            {{ number_format(($guide->harga_jual ?? 0) * $guide->jumlah, 0, ',', '.') }} <br>
                            <small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format(($guide->guideItem->harga ?? 0) * $guide->jumlah, 0, ',', '.') }} <br>
                            <small>Harga Estimasi</small>
                        </td>
                    @endif
                </tr>
            @endforeach

            {{-- 9. Badal Umrah --}}
            @foreach ($service->badals as $badal)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <strong>Badal Umrah</strong><br>
                        <small>Tanggal: {{ $badal->tanggal_pelaksanaan }}</small>
                    </td>
                    <td class="text-center">1 Jiwa<br>
                        <small>Atas Nama: {{ $badal->name }}</small>
                    </td>
                    @if ($badal->harga_jual && $badal->harga_jual > 0)
                        <td class="text-right">Rp {{ number_format($badal->harga_jual, 0, ',', '.') }} <br>
                            <small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp {{ number_format($badal->price, 0, ',', '.') }} <br> <small>Harga
                                Estimasi</small></td>
                    @endif
                </tr>
            @endforeach

            {{-- 10. Wakaf --}}
            @foreach ($service->wakafs as $wakaf)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Wakaf: {{ $wakaf->wakaf->nama ?? 'Wakaf' }}</strong></td>
                    <td class="text-center">{{ $wakaf->jumlah }} Pcs</td>
                    @if ($wakaf->harga_jual && $wakaf->harga_jual > 0)
                        <td class="text-right">Rp
                            {{ number_format(($wakaf->harga_jual ?? 0) * $wakaf->jumlah, 0, ',', '.') }}
                            <br><small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format(($wakaf->wakaf->harga ?? 0) * $wakaf->jumlah, 0, ',', '.') }}
                            <br><small>Harga Estimasi</small>
                        </td>
                    @endif
                </tr>
            @endforeach

            {{-- 11. Dorongan (Kursi Roda) --}}
            @foreach ($service->dorongans as $dorongan)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Sewa Dorongan: {{ $dorongan->dorongan->name ?? 'Kursi Roda' }}</strong></td>
                    <td class="text-center">{{ $dorongan->jumlah }} Unit</td>
                    @if ($dorongan->harga_jual && $dorongan->harga_jual > 0)
                        <td class="text-right">
                            Rp{{ number_format(($dorongan->harga_jual ?? 0) * $dorongan->jumlah, 0, ',', '.') }}
                            <br><small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">
                            Rp{{ number_format(($dorongan->dorongan->price ?? 0) * $dorongan->jumlah, 0, ',', '.') }}
                            <br><small>Harga Estimasi</small>
                        </td>
                    @endif
                </tr>
            @endforeach

            {{-- 12. Konten --}}
            @foreach ($service->contents as $content)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Dokumentasi: {{ $content->content->name ?? 'Foto/Video' }}</strong>
                        <br><small>{{ $content->tanggal_pelaksanaan }}</small>
                    </td>
                    <td class="text-center">{{ $content->jumlah }} Pcs</td>
                    @if ($content->harga_jual && $content->harga_jual > 0)
                        <td class="text-right">Rp
                            {{ number_format(($content->harga_jual ?? 0) * $content->jumlah, 0, ',', '.') }}
                            <br><small>Harga Final</small>
                        </td>
                    @else
                        <td class="text-right">Rp
                            {{ number_format(($content->content->price ?? 0) * $content->jumlah, 0, ',', '.') }}
                            <br><small>Harga Estimasi</small>
                        </td>
                    @endif
                </tr>
            @endforeach

            {{-- 13. Reyal --}}
            @foreach ($service->exchanges as $reyal)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>Tipe: {{ $reyal->tipe ?? '' }}</strong></td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp
                        {{ $reyal->jumlah_input }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{-- TOTAL SECTION --}}
    <table width="100%">
        <tr>
            <td width="60%"></td> {{-- Spacer kiri --}}
            <td width="40%">
                <table width="100%">
                    <tr>
                        <td class="text-right" style="padding: 5px; vertical-align: top;"><strong>Total
                                Tagihan:</strong>
                        </td>
                        <td class="text-right grand-total" style="padding: 5px;">Rp
                            {{ number_format($order->total_amount_final ?? $order->total_estimasi, 0, ',', '.') }} <br>
                            <small>{{ $order->total_amount_final ? 'Harga Final' : 'Harga Estimasi' }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" style="padding: 5px;">Sudah Dibayar:</td>
                        <td class="text-right" style="padding: 5px;">Rp
                            {{ number_format($order->total_yang_dibayarkan, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="border-top: 1px dashed #ccc;">
                        <td class="text-right"
                            style="padding: 10px 5px; color: {{ $order->sisa_hutang > 0 ? '#dc3545' : '#28a745' }}">
                            <strong>Sisa Pembayaran:</strong>
                        </td>
                        <td class="text-right"
                            style="padding: 10px 5px; font-size: 14px; font-weight: bold; color: {{ $order->sisa_hutang > 0 ? '#dc3545' : '#28a745' }}">
                            Rp {{ number_format($order->sisa_hutang, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- FOOTER / INFO PEMBAYARAN --}}
    <div
        style="margin-top: 40px; border: 1px solid #ddd; background-color: #f9f9f9; padding: 15px; border-radius: 5px; font-size: 11px;">
        <strong>Silakan lakukan pembayaran ke:</strong><br>
        <table width="100%" style="margin-top: 5px;">
            <tr>
                <td width="15%">Nama Bank</td>
                <td>: <strong>Bank Syariah Indonesia (BSI)</strong></td>
            </tr>
            <tr>
                <td>No. Rekening</td>
                <td>: <strong>1234-5678-90</strong></td>
            </tr>
            <tr>
                <td>Atas Nama</td>
                <td>: <strong>PT Jasa Haramain</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Invoice ini sah dan diproses secara komputerisasi oleh sistem PT Jasa Haramain.</p>
        <p>Terima kasih atas kepercayaan Anda menggunakan jasa kami.</p>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
