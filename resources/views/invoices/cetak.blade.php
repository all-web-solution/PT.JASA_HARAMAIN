<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($service->id, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #e38d00;
            margin: 0;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info div {
            width: 45%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        table th {
            background: #f5f5f5;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PT JASA HARAMAIN GRUP</h2>
        <p>
            Jl. Mesjid Taqwa, No. 57 <br>
            Desa Seutui, Kec. Baiturrahman, Kota Banda Aceh, 23243 <br>
            (+62) 823 6462 3556
        </p>
    </div>

    <p><strong>Invoice #{{ str_pad($service->id, 3, '0', STR_PAD_LEFT) }}</strong></p>
    <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>

    <div class="info">
        <div>
            <strong>BILL TO</strong><br>
            {{ $service->pelanggan->nama_travel ?? '-' }} <br>
            {{ $service->pelanggan->alamat ?? 'Alamat tidak tersedia' }}
        </div>
        <div>
            <strong>FOR</strong><br>
            Hotel Reservation: <br>
            {{ $service->tanggal_keberangkatan }} to {{ $service->tanggal_kepulangan }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>DETAIL</th>
                <th>QTY</th>
                <th>UNIT</th>
                <th>PRICE</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp

            {{-- Hotels --}}
            @foreach ($service->hotels as $hotel)
                @php
                    $amount = ($hotel->durasi ?? 1) * $hotel->harga_per_malam;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[H] Hotel: {{ $hotel->nama_hotel }} - {{ $hotel->alamat }}</td>
                    <td>{{ $hotel->durasi ?? 1 }}</td>
                    <td>Days</td>
                    <td>SAR {{ number_format($hotel->harga_per_malam, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Flights --}}
            @foreach ($service->planes as $plane)
                @php
                    $amount = ($plane->qty ?? 1) * $plane->harga;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[TIK] Flight: {{ $plane->maskapai }} ({{ $plane->rute }})</td>
                    <td>{{ $plane->qty ?? 1 }}</td>
                    <td>Ticket</td>
                    <td>SAR {{ number_format($plane->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            @foreach ($service->transportationItem as $t)
                <tr>
                    <td>{{ $t->transportation->nama ?? '-' }}</td>
                    <td>{{ $t->qty ?? 'NULL' }}</td>
                    <td>{{ $t->harga ?? 'NULL' }}</td>
                    <td>{{ $t->transportation->harga ?? 'NULL' }}</td>
                </tr>
            @endforeach

            {{-- Meals --}}
            @foreach ($service->meals as $meal)
                @php
                    $amount = ($meal->qty ?? 1) * $meal->harga;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[M] Meal: {{ $meal->nama_menu }}</td>
                    <td>{{ $meal->qty ?? 1 }}</td>
                    <td>Porsi</td>
                    <td>SAR {{ number_format($meal->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Guides (Pendamping) --}}
            @foreach ($service->guides as $g)
                @php
                    $amount = ($g->hari ?? 1) * $g->harga;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[P] Guide: {{ $g->nama }}</td>
                    <td>{{ $g->hari ?? 1 }}</td>
                    <td>Days</td>
                    <td>SAR {{ number_format($g->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Wakaf --}}
            @foreach ($service->wakafs as $w)
                @php
                    $amount = $w->jumlah ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[W] Wakaf</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Badal --}}
            @foreach ($service->badals as $b)
                @php
                    $amount = $b->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[BD] Badal: {{ $b->nama ?? '-' }}</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($b->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Documents --}}


            {{-- Handling --}}
            @foreach ($service->handlings as $hdl)
                @php
                    $amount = $hdl->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[HDL] Handling</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($hdl->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Tours --}}
            @foreach ($service->tours as $tour)
                @php
                    $amount = $tour->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[TO] Tour: {{ $tour->nama }}</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($tour->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Dorongan --}}
            @foreach ($service->dorongans as $dr)
                @php
                    $amount = $dr->jumlah * $dr->dorongan->price;
                    $grandTotal += $amount;

                @endphp
                <tr>
                    <td>[DR] {{ $dr->dorongan->name }}</td>
                    <td>{{ $dr->jumlah }}</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($dr->dorongan->price, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Konten --}}
            @foreach ($service->contents as $c)
                @php
                    $amount = $c->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[K] Konten</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($c->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Reyal (Currency Exchange) --}}
            @foreach ($service->reyals as $r)
                @php
                    $amount = $r->jumlah ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[R] Tukar Riyal</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- TOTAL --}}
    <div class="total">
        <p>SUBTOTAL: SAR {{ number_format($grandTotal, 2, ',', '.') }}</p>
        <h3>TOTAL: SAR {{ number_format($grandTotal, 2, ',', '.') }}</h3>
    </div>

    <p>Make all checks payable to <strong>PT JASA HARAMAIN GRUP</strong></p>
    <p>Contact: Ali Ridha, (+62) 811 6814 994, jasaharamainagrup@gmail.com</p>
    <p><strong>THANK YOU FOR YOUR BUSINESS!</strong></p>

</body>

</html>
