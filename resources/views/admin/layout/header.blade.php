<header class="topbar sticky-top">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Judul Dashboard -->
        <div class="d-flex align-items-center">
            <h1 class="h4 mb-0 fw-bold" style="color: var(--haramain-primary);">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Overview
            </h1>
        </div>

        <!-- Notifikasi & User -->
        <div class="d-flex align-items-center">
            <!-- Bell Notification -->
            <div class="position-relative me-3">
                <button class="btn btn-sm position-relative">
                    <i class="bi bi-bell fs-5" style="color: var(--haramain-primary);"></i>
                    <span class="notification-badge badge rounded-circle">3</span>
                </button>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   style="color: var(--haramain-primary);" data-bs-toggle="dropdown">
                    <div class="user-avatar-sm rounded-circle d-flex align-items-center justify-content-center me-2"
                         style="width: 32px; height: 32px; background-color: var(--haramain-primary); color: white; font-size: 0.875rem;">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="me-1 fw-medium" style="font-size: 0.8125rem;">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('sign_out') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
