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
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order') }}">
                <i class="bi bi-credit-card-2-back"></i> ORDER
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.payment') }}">
                <i class="bi bi-credit-card-2-back"></i> PAYMENT
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
    </ul>
    @elseif (auth()->user()->role === 'handling')
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('catering.index') }}">
                <i class="bi bi-speedometer2"></i> CATERING
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.handling.index') }}">
                <i class="bi bi-speedometer2"></i> HANDLING
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.pendamping.index') }}">
                <i class="bi bi-speedometer2"></i> Pendamping
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('handling.tour.index') }}">
                <i class="bi bi-speedometer2"></i> Tour
            </a>
        </li>
    </ul>
    @elseif (auth()->user()->role === 'transportasi & tiket')
    <ul>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('transportation.plane.index') }}">
                <i class="bi bi-speedometer2"></i> Pesawat
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('transportation.car.index') }}">
                <i class="bi bi-speedometer2"></i> Kendaraan
            </a>
        </li>

    </ul>
    @elseif (auth()->user()->role === 'konten dan dokumentasi')
    <ul>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('transportation.plane.index') }}">
                <i class="bi bi-speedometer2"></i> Visa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('content.vaccine.index') }}">
                <i class="bi bi-speedometer2"></i> Vaksin
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('content.siskopatur.index') }}">
                <i class="bi bi-speedometer2"></i> Siskopatuh
            </a>
        </li>
    </ul>
    @endif

</div>
