<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</title>
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

    <p><strong>Invoice #{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</strong></p>
    <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>

    <div class="info">
        <div>
            <strong>BILL TO</strong><br>
            {{ $pelanggan->nama_travel ?? '-' }} <br>
            {{ $pelanggan->alamat ?? 'Alamat tidak tersedia' }}
        </div>
        <div>
            <strong>FOR</strong><br>
            Hotel Reservation: <br>
            {{ $pelanggan->tanggal_keberangkatan }} to {{ $pelanggan->tanggal_kepulangan }}
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
                @foreach ($pelanggan->services as $service)
                    @foreach ($service->hotels as $hotel)
                        @php
                            // total harga hotel (basic: durasi * harga per kamar)
                            $amount = ($hotel->durasi ?? 1) * ($hotel->harga_perkamar ?? 0);
                            $grandTotal += $amount;
                        @endphp
                        <tr>
                            <td>[H] Hotel: {{ $hotel->nama_hotel }} - {{ $hotel->type }}</td>
                            <td>{{ $hotel->durasi ?? 1 }}</td>
                            <td>Days</td>
                            <td>SAR {{ number_format($hotel->harga_perkamar ?? 0, 2, ',', '.') }}</td>
                            <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                        </tr>

                        {{-- Detail tipe kamar --}}
                        {{-- @foreach ($hotel->typeHotels as $type)
                            @php
                                $typeAmount = ($type->jumlah ?? 1) * ($hotel->harga_perkamar ?? 0);
                                $grandTotal += $typeAmount;
                            @endphp
                            <tr>
                                <td class="ps-4">↳ Type: {{ $type->nama_tipe }}</td>
                                <td>{{ $type->jumlah ?? 1 }}</td>
                                <td>Room(s)</td>
                                <td>SAR {{ number_format($hotel->harga_perkamar ?? 0, 2, ',', '.') }}</td>
                                <td>SAR {{ number_format($typeAmount, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach --}}
                    @endforeach
                @endforeach



            {{-- Flights --}}
            @foreach ($pelanggan->services as $service)
                @foreach($service->planes as $plane)
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
            @endforeach

            {{-- Transportasi --}}
            @foreach($pelanggan->services as $service)
                @foreach ($service->transportationItem as $t)
                    @php
                        $amount = ($t->qty ?? 1) * $t->harga;
                        $grandTotal += $amount;
                    @endphp
                    <tr>
                        <td>[T] Transport: {{ $t->Transportation->nama }}</td>
                        <td>1</td>
                        <td>Unit</td>
                        <td>SAR {{$t->Transportation->harga}}</td>
                        <td>SAR {{$t->Transportation->kapasitas}}</td>
                    </tr>
                @endforeach
            @endforeach

            {{-- Meals --}}
            @foreach($pelanggan->services as $service)
                @foreach ($service->meals as $meal)
                    @php
                        $amount = ($meal->qty ?? 1) * $meal->mealItem->price;
                        $grandTotal += $amount;
                    @endphp
                    <tr>
                        <td>[M] Meal: {{ $meal->mealItem->name}}</td>
                        <td>{{ $meal->qty ?? 1 }}</td>
                        <td>Porsi</td>
                        <td>SAR {{ number_format($meal->mealItem->price, 2, ',', '.') }}</td>
                        <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach


            {{-- Guides (Pendamping) --}}
           {{-- Guides (Pendamping) --}}
                @foreach($pelanggan->services as $service)
                    @foreach ($service->guides as $g)
                        @php
                            $amount = ($g->jumlah ?? 1) * ($g->guideItem->harga ?? 0);
                            $grandTotal += $amount;
                        @endphp
                        <tr>
                            <td>[P] Guide: {{ $g->guideItem->nama ?? '-' }}</td>
                            <td>{{ $g->jumlah ?? 1 }}</td>
                            <td>Days</td>
                            <td>SAR {{ number_format($g->guideItem->harga ?? 0, 2, ',', '.') }}</td>
                            <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach

            {{-- Wakaf --}}
             @foreach($pelanggan->services as $service)
             @foreach ($service->wakafs as $w)
                @php
                    $amount = $w->jumlah * $w->Wakaf->harga;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[W] Wakaf - {{$w->Wakaf->nama}}</td>
                    <td>{{$w->jumlah}}</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($w->Wakaf->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @endforeach


            {{-- Badal --}}
             @foreach($pelanggan->services as $service)
             @foreach ($service->badals as $b)
                @php
                    $amount = $b->price ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[BD] Badal: {{ $b->name }}</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($b->price, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            @endforeach

           {{-- Documents --}}
           @foreach($pelanggan->services as $service)
            {{-- Documents --}}
            @foreach ($service->documents as $cd)
                @php
                    $amount = ($cd->jumlah ?? 1) * ($cd->harga ?? 0);
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[D] Dokumen: {{ $cd->documents->name ?? '-' }}
                        @if($cd->DocumentChildren)
                            ({{ $cd->DocumentChildren->name }})
                        @endif
                    </td>
                    <td>{{ $cd->jumlah }}</td>
                    <td>Paket</td>
                    <td>SAR {{$cd->harga}}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach

           @endforeach



            {{-- Handling --}}
             @foreach($pelanggan->services as $service)
             @foreach ($service->handlings as $hdl)
                @php
                    $amount = $hdl->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[HDL] Handling - {{$hdl->name}}</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($hdl->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @endforeach


            {{-- Tours --}}
             @foreach($pelanggan->services as $service)
             @foreach ($service->tours as $tour)
                @php
                    $amount = $tour->transportation->harga ?? 0;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[TO] Tour: {{ $tour->transportation->nama }}</td>
                    <td>1</td>
                    <td>Paket</td>
                    <td>SAR {{ number_format($tour->transportation->harga, 2, ',', '.') }}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @endforeach


            {{-- Dorongan --}}
             @foreach($pelanggan->services as $service)
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
            @endforeach


            {{-- Konten --}}
             @foreach($pelanggan->services as $service)
             @foreach ($service->contents as $c)
                @php
                    $amount = $c->content->price;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>[K] Konten - {{$c->content->name}}</td>
                    <td>{{$c->jumlah}}</td>
                    <td>Paket</td>
                    <td>SAR {{number_format($c->content->price, 2,',','.')}}</td>
                    <td>SAR {{ number_format($amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @endforeach


            {{-- Reyal (Currency Exchange) --}}
             @foreach($pelanggan->services as $service)
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
