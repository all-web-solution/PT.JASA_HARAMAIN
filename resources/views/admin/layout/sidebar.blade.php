<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center">
        <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">JH</div>
        <h5 class="mb-1 fw-bold" style="font-size: 1rem;">PT JASA HARAMAIN</h5>
        <small class="opacity-75">{{ auth()->user()->role }}</small>
    </div>

    @if (auth()->user()->role === 'admin')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <i class="bi bi-speedometer2"></i> DASHBOARD
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pelanggan*') ? 'active' : '' }}"
                    href="{{ route('admin.pelanggan') }}">
                    <i class="bi bi-airplane-engines"></i> DATA CUSTOMER
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}"
                    href="{{ route('admin.services') }}">
                    <i class="bi bi-box-seam"></i> SERVICES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.service.file*') ? 'active' : '' }}"
                    href="{{ route('admin.service.file') }}">
                    <i class="bi bi-file-earmark-text"></i> BERKAS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.order*') ? 'active' : '' }}"
                    href="{{ route('admin.order') }}">
                    <i class="bi bi-credit-card-2-back"></i> ORDER
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index*') ? 'active' : '' }}"
                    href="{{ route('user.index') }}">
                    <i class="bi bi-people-fill"></i> USERS
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role === 'hotel')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hotel.index') || request()->routeIs('hotel.edit') ? 'active' : '' }}"
                    href="{{ route('hotel.index') }}">
                    <i class="bi bi-building"></i> HOTEL
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hotel.price.*') ? 'active' : '' }}"
                    href="{{ route('hotel.price.index') }}">
                    <i class="bi bi-cash-stack"></i> Price List Hotel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hotel.type.*') ? 'active' : '' }}"
                    href="{{ route('hotel.type.index') }}">
                    <i class="bi bi-tags"></i> Type Hotel
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role === 'handling')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('catering.index*') || request()->routeIs('catering.edit') || request()->routeIs('catering.create') || request()->routeIs('catering.show') ? 'active' : '' }}"
                    href="{{ route('catering.index') }}">
                    <i class="bi bi-egg-fried"></i> Catering
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('catering.customer*') ? 'active' : '' }}"
                    href="{{ route('catering.customer') }}">
                    <i class="bi bi-person-check"></i> Catering Customer
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('handling.handling.index*') ? 'active' : '' }}"
                    href="{{ route('handling.handling.index') }}">
                    <i class="bi bi-airplane"></i> Handling Pesawat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('handling.handling.hotel*') ? 'active' : '' }}"
                    href="{{ route('handling.handling.hotel') }}">
                    <i class="bi bi-hospital"></i> Handling Hotel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('handling.pendamping.index*') ? 'active' : '' }}"
                    href="{{ route('handling.pendamping.index') }}">
                    <i class="bi bi-person-plus"></i> Pendamping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('handling.pendamping.customer*') ? 'active' : '' }}"
                    href="{{ route('handling.pendamping.customer') }}">
                    <i class="bi bi-people"></i> Pendamping Customer
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('handling.tour.index*') ? 'active' : '' }}"
                    href="{{ route('handling.tour.index') }}">
                    <i class="bi bi-map"></i> Tour
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role === 'transportasi & tiket')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transportation.plane.index*') ? 'active' : '' }}"
                    href="{{ route('transportation.plane.index') }}">
                    <i class="bi bi-airplane-fill"></i> Pesawat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transportation.car.index*') ? 'active' : '' }}"
                    href="{{ route('transportation.car.index') }}">
                    <i class="bi bi-car-front-fill"></i> Kendaraan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transportation.customer*') ? 'active' : '' }}"
                    href="{{ route('transportation.customer') }}">
                    <i class="bi bi-person-lines-fill"></i> Customer Kendaraan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('price.list.ticket*') ? 'active' : '' }}"
                    href="{{ route('price.list.ticket') }}">
                    <i class="bi bi-ticket-perforated-fill"></i> Price list tiket
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role === 'visa dan acara')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('visa.document.index*') ? 'active' : '' }}"
                    href="{{ route('visa.document.index') }}">
                    <i class="bi bi-file-richtext"></i> Dokumen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('visa.document.customer*') ? 'active' : '' }}"
                    href="{{ route('visa.document.customer') }}">
                    <i class="bi bi-person-badge"></i> Daftar Customer
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role === 'palugada')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wakaf.index*') ? 'active' : '' }}"
                    href="{{ route('wakaf.index') }}">
                    <i class="bi bi-gem"></i> Wakaf
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wakaf.customer*') ? 'active' : '' }}"
                    href="{{ route('wakaf.customer') }}">
                    <i class="bi bi-person-heart"></i> Customer Wakaf
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dorongan.index*') ? 'active' : '' }}"
                    href="{{ route('dorongan.index') }}">
                    <i class="bi bi-cart3"></i> Dorongan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dorongan.customer*') ? 'active' : '' }}"
                    href="{{ route('dorongan.customer') }}">
                    <i class="bi bi-person-bounding-box"></i> Customer dorongan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('palugada.badal*') ? 'active' : '' }}"
                    href="{{ route('palugada.badal') }}">
                    <i class="bi bi-arrow-repeat"></i> Badal
                </a>
            </li>
        </ul>
    @elseif (auth()->user()->role == 'konten dan dokumentasi')
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('content.index*') ? 'active' : '' }}"
                    href="{{ route('content.index') }}">
                    <i class="bi bi-images"></i> Daftar Konten
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('content.customer*') ? 'active' : '' }}"
                    href="{{ route('content.customer') }}">
                    <i class="bi bi-people-fill"></i> Customer
                </a>
            </li>
        </ul>
    @endif
</div>
