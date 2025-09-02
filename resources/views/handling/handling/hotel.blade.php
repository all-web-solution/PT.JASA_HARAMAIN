@extends('admin.master')
@section('title', 'Catering List')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Handling hotel</h2>

        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama customer</th>
                    <th>Nama Hotel</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Pax</th>
                    <th>Foto kode booking</th>
                    <th>Foto rumlis</th>
                    <td>Identitas koper</td>


                </tr>
            </thead>
            <tbody>
                @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$hotel->handling->service->pelanggan->nama_travel}}</td>
                        <td>{{$hotel->nama}}</td>
                        <td>{{ \Carbon\Carbon::parse($hotel->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td>{{$hotel->harga}}</td>
                        <td>{{$hotel->pax}}</td>
                        <td><img src="{{ url('storage/' . $hotel->kode_booking) }}" alt="" width="100" height="100"></td>
                        <td><img src="{{ url('storage/' . $hotel->rumlis) }}" alt="" width="100" height="100"></td>
                        <td><img src="{{ url('storage/' . $hotel->identitas_koper) }}" alt="" width="100" height="100"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
