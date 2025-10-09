@extends('admin.master')

@section('content')
<style>
    .table-container {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 10px;
    }

    .table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .table thead {
        background: #eaf1fc;
        color: #0d47a1;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table img {
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease;
    }

    .table img:hover {
        transform: scale(1.1);
    }

    /* RESPONSIVE MODE */
    @media (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1.5rem;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-radius: 10px;
            padding: 1rem;
        }

        .table td {
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: none;
            padding: 0.75rem 0;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #0d47a1;
            flex: 1;
        }

        .table img {
            width: 70px;
            height: 70px;
        }
    }

    @media (max-width: 400px) {
        .table img {
            width: 60px;
            height: 60px;
        }
    }
</style>

<div class="table-container">
    <h4 class="mb-3 text-primary fw-bold">Daftar Berkas Jamaah</h4>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama Customer</th>
                    <th>Pas Foto</th>
                    <th>Paspor</th>
                    <th>KTP</th>
                    <th>Visa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($files as $file)
                    <tr>
                        <td data-label="Nama Customer">{{ $file->service->pelanggan->nama_travel ?? '-' }}</td>
                        <td data-label="Pas Foto">
                            @if ($file->pas_foto)
                                <img src="{{ url('storage/' . $file->pas_foto) }}" alt="Pas Foto" width="100" height="100">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td data-label="Paspor">
                            @if ($file->paspor)
                                <img src="{{ url('storage/' . $file->paspor) }}" alt="Paspor" width="100" height="100">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td data-label="KTP">
                            @if ($file->ktp)
                                <img src="{{ url('storage/' . $file->ktp) }}" alt="KTP" width="100" height="100">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td data-label="Visa">
                            @if ($file->visa)
                                <img src="{{ url('storage/' . $file->visa) }}" alt="Visa" width="100" height="100">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data berkas jamaah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
