<header class="topbar sticky-top">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="h4 mb-0 fw-bold" style="color: var(--haramain-primary);" id="text-title">
                PT JASA HARAMAIN
            </h1>
        </div>

        <!-- User -->
        <div class="d-flex align-items-center">

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    style="color: var(--haramain-primary);" data-bs-toggle="dropdown">
                    <div class="user-avatar-sm rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 38px; height: 38px; background-color: var(--haramain-primary); color: white; font-size: 0.9rem;">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="me-1 fw-medium user-info" style="font-size: 0.9rem;">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <div class="dropdown-item-text">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->role }}</small>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('sign_out') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
