@extends('admin.master')
@section('title', 'Detail Handling Pesawat') {{-- Changed title for better context --}}
@section('content')

    <div class="plane-handling-container p-4"> {{-- Added some padding class --}}
        <div class="card shadow-sm"> {{-- Added shadow for better visual separation --}}
            <div class="card-header bg-primary text-white"> {{-- Added color for a prominent header --}}
                <h2 class="card-title mb-0"> {{-- Removed bottom margin for tight fit --}}
                    <i class="fas fa-plane me-2"></i> {{-- Added margin to the right of the icon --}}
                    Detail Handling Pesawat - {{ $plane->handling->service->pelanggan->nama_pelanggan }}
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive"> {{-- Added responsive wrapper for better mobile view --}}
                    <table class="table table-bordered table-striped"> {{-- Added table-striped for better readability --}}
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama Bandara</th>
                                <td>{{ $plane->nama_bandara }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Jamaah</th>
                                <td>{{ number_format($plane->jumlah_jamaah, 0, ',', '.') }} orang</td> {{-- Formatted number --}}
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>
                                    Rp {{ $plane->harga }} {{-- Correctly formatted as Indonesian Rupiah --}}
                                </td>
                            </tr>
                            <tr>
                                <th>Kedatangan Jamaah</th>
                                {{-- Assuming Carbon is available and $plane->kedatangan_jamaah is a valid date/datetime --}}
                                <td>{{ \Carbon\Carbon::parse($plane->kedatangan_jamaah)->translatedFormat('l, d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Nama Supir</th>
                                <td>{{ $plane->nama_supir }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('handling.handling.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        ---

        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h3 class="card-title mb-0">Dokumentasi</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Foto Paket Info Section --}}
                    <div class="col-md-6 mb-3"> {{-- Use col-md-6 for two columns on medium screens and up --}}
                        <div class="form-group">
                            <label class="form-label fw-bold">Foto Paket Info</label> {{-- Added fw-bold for emphasis --}}
                            @if ($plane->paket_info)
                                <a href="{{ url('storage/' . $plane->paket_info) }}" target="_blank"> {{-- Made image a link to view full size --}}
                                    <img src="{{ url('storage/' . $plane->paket_info) }}" alt="Foto Paket Info" class="img-fluid border rounded" style="max-height: 300px; object-fit: cover; width: 100%;"> {{-- Added style for max height and border --}}
                                </a>
                            @else
                                <p class="text-muted">No Image Available</p> {{-- Changed to <p> for better styling --}}
                            @endif
                        </div>
                    </div>

                    {{-- Identitas Koper Section --}}
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label fw-bold">Identitas Koper</label>
                            @if ($plane->identitas_koper)
                                <a href="{{ url('storage/' . $plane->identitas_koper) }}" target="_blank"> {{-- Made image a link to view full size --}}
                                    <img src="{{ url('storage/' . $plane->identitas_koper) }}" alt="Identitas Koper" class="img-fluid border rounded" style="max-height: 300px; object-fit: cover; width: 100%;">
                                </a>
                            @else
                                <p class="text-muted">No Image Available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
