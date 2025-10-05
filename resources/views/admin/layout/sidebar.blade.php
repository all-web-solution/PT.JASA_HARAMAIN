<div class="sidebar">
    <div class="sidebar-header text-center">
        <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">JH</div>
        <h5 class="mb-1 fw-bold" style="font-size: 1rem;">PT JASA HARAMAIN</h5>
        <small class="opacity-75">{{auth()->user()->role}}</small>
    </div>
    @if (auth()->user()->role === 'admin')
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="/">
                <i class="bi bi-speedometer2"></i> DASHBOARD
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.pelanggan')}}">
                <i class="bi bi-airplane-engines"></i> DATA CUSTOMER
            </a>
        </li>

        <!-- Enhanced Menu lainnya -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.services')}}">
                <i class="bi bi-people-fill"></i> SERVICES
            </a>
        </li>
        <!-- Enhanced Menu lainnya -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.service.file') }}">
                <i class="bi bi-people-fill"></i> BERKAS
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order') }}">
                <i class="bi bi-credit-card-2-back"></i> ORDER
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="bi bi-people-fill"></i> USERS
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'hotel')
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('hotel.index') }}">
                <i class="bi bi-speedometer2"></i> HOTEL
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('hotel.price.index') }}">
                <i class="bi bi-speedometer2"></i> Price List Hotel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('hotel.type.index') }}">
                <i class="bi bi-speedometer2"></i>Type Hotel
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'handling')
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('catering.index') }}">
                <i class="bi bi-speedometer2"></i> Catering
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('catering.customer') }}">
                <i class="bi bi-speedometer2"></i> Catering Customer
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.handling.index') }}">
                <i class="bi bi-speedometer2"></i> Handling Pesawat
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.handling.hotel') }}">
                <i class="bi bi-speedometer2"></i> Handling Hotel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.pendamping.index') }}">
                <i class="bi bi-speedometer2"></i> Pendamping
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.pendamping.customer') }}">
                <i class="bi bi-speedometer2"></i> Pendamping Customer
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.tour.index') }}">
                <i class="bi bi-speedometer2"></i> Tour
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'transportasi & tiket')
        <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link" href="{{route('transportation.plane.index')}}">
                Pesawat
            </a>
        </li>

        <!-- Enhanced Menu lainnya -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('transportation.car.index')}}">
               Kendaraan
            </a>
        </li>
        <!-- Enhanced Menu lainnya -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transportation.customer') }}">
               Customer kendaraan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('price.list.ticket') }}">
                 Price list tiket
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'visa dan acara')
        <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('visa.document.index') }}">
               Dokumen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('visa.document.customer') }}">
               Daftar Customer
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'palugada')
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('wakaf.index') }}">
               Wakaf
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('wakaf.customer') }}">
                Customer Wakaf
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('dorongan.index') }}">
               Dorongan
            </a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" href="{{ route('dorongan.customer') }}">
               Customer dorongan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('palugada.badal') }}">
               Badal
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role == 'konten dan dokumentasi')
    <ul>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('content.index') }}">
                Daftar kontent
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('content.customer') }}">
                Customer
            </a>
        </li>
    </ul>
    @endif



</div>
