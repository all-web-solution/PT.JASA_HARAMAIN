@extends('admin.master')
@section('content')
<style>
:root {
    --haramain-primary: #1a4b8c;
    --haramain-secondary: #2a6fdb;
    --haramain-light: #e6f0fa;
    --text-primary: #2d3748;
    --text-secondary: #4a5568;
    --border-color: #d1e0f5;
    --hover-bg: #f0f7ff;
    --danger-color: #dc3545;
}

.service-list-container {
    max-width: 100vw;
    margin: 0 auto;
    padding: 2rem;
    background-color: #f8fafd;
}

/* --- CARD --- */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
    overflow: hidden;
}

/* --- HEADER --- */
.card-header {
    background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.card-title {
    font-weight: 700;
    color: var(--haramain-primary);
    margin: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* --- BUTTON TAMBAH --- */
.btn-add-new {
    background-color: var(--haramain-secondary);
    color: white;
    border-radius: 8px;
    padding: 0.625rem 1.5rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
}
.btn-add-new:hover {
    background-color: var(--haramain-primary);
    transform: translateY(-2px);
}

/* --- FILTER DAN SEARCH --- */
.search-filter-container {
    display: flex;
    justify-content: space-between;
    padding: 1.5rem;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
    flex-wrap: wrap;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex-grow: 1;
    min-width: 250px;
}
.search-box input {
    padding-left: 2.5rem;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    height: 40px;
    width: 100%;
}
.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

.filter-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.filter-select {
    height: 40px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    padding: 0 1rem;
    background-color: #fff;
}

/* --- TABLE --- */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    padding: 1rem;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.5rem;
}

.table thead th {
    background-color: var(--haramain-light);
    color: var(--haramain-primary);
    font-weight: 600;
    padding: 1rem 1.25rem;
    text-align: left;
    border-bottom: 2px solid var(--border-color);
}

.table tbody tr {
    background-color: white;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.table tbody tr:hover {
    background-color: var(--hover-bg);
}

.table tbody td {
    padding: 1rem;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

/* --- ACTION BUTTONS --- */
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    background-color: transparent;
    cursor: pointer;
}
.btn-action:hover {
    background-color: var(--haramain-light);
}
.btn-action i {
    font-size: 1rem;
}
.btn-edit { color: var(--haramain-secondary); }
.btn-delete { color: var(--danger-color); }
.btn-view { color: var(--text-secondary); }

/* --- PAGINATION --- */
.pagination-container {
    display: flex;
    justify-content: flex-end;
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
}

/* --- RESPONSIVE --- */
@media (max-width: 992px) {
    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border: none;
        border-bottom: 1px solid var(--border-color);
    }

    .table tbody td:before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--haramain-primary);
        text-transform: capitalize;
    }

    .table tbody tr td:last-child {
        border-bottom: none;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }
}

@media (max-width: 480px) {
    .card-header,
    .search-filter-container {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="service-list-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-list-check"></i>Daftar Kendaraan
            </h5>
            <a href="{{ route('transportation.car.create') }}" class="btn-add-new">
                <i class="bi bi-plus-circle"></i> Tambah Kendaraan
            </a>
        </div>

        <div class="search-filter-container">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari kendaraan...">
            </div>
            <div class="filter-group">
                <select class="filter-select">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kapasitas</th>
                        <th>Fasilitas</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Transportations as $car)
                    <tr>
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Nama">{{ $car->nama }}</td>
                        <td data-label="Kapasitas">{{ $car->kapasitas }}</td>
                        <td data-label="Fasilitas">{{ $car->fasilitas }}</td>
                        <td data-label="Harga">{{ $car->harga }}</td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                <a href="{{ route('transportation.car.edit', $car->id) }}" class="btn-action btn-edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('transportation.car.delete', $car->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                                <a href="{{ route('transportation.car.detail', $car->id) }}" class="btn-action btn-view" title="Detail"><i class="bi bi-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

