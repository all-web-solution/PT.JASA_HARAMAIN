@extends('admin.master')

@section('content')
    <div class="container text-center" style="margin-top: 100px;">
        <h1 style="font-size: 72px;">403</h1>
        <h2>Akses Ditolak!</h2>
        <p>{{ $exception->getMessage() ?: 'Hanya role tertentu yang bisa mengakses halaman ini.' }}</p>

        @auth
            @php
                $role = auth()->user()->role;
                $targetRoute = 'login';

                if ($role == 'admin') {
                    $targetRoute = 'admin.dashboard';
                } elseif ($role == 'hotel') {
                    $targetRoute = 'hotel.index';
                } elseif ($role == 'handling') {
                    $targetRoute = 'handling.handling.index';
                } elseif ($role == 'visa dan acara') {
                    $targetRoute = 'visa.document.index';
                } elseif ($role == 'reyal') {
                    $targetRoute = 'reyal.index';
                } elseif ($role == 'palugada') {
                    $targetRoute = 'palugada.badal';
                } elseif ($role == 'konten dan dokumentasi') {
                    $targetRoute = 'content.index';
                } elseif ($role == 'transportasi & tiket') {
                    $targetRoute = 'plane.index';
                } elseif ($role == 'keuangan') {
                    $targetRoute = 'keuangan.index';
                }
            @endphp

            <a href="{{ route($targetRoute) }}" class="btn btn-primary">
                Kembali ke Dashboard Saya
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Kembali ke Login</a>
        @endauth
    </div>
@endsection
