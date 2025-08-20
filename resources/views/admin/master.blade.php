

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PT JASA HARAMAIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --haramain-primary: #0d47a1;
            --haramain-secondary: #1976d2;
            --haramain-light: #f8fafc;
            --haramain-accent: #42a5f5;
            --text-primary: #334155;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 0.875rem;
            color: var(--text-primary);
            background-color: var(--haramain-light);
            line-height: 1.5;
        }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--haramain-primary) 0%, var(--haramain-secondary) 100%);
            color: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .user-avatar {
            width: 70px;
            height: 70px;
            background-color: white;
            color: var(--haramain-primary);
            font-size: 1.75rem;
            font-weight: bold;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.65rem 1.25rem;
            margin: 0.1rem 0;
            border-radius: 0 50px 50px 0;
            transition: all 0.2s;
            font-size: 0.8125rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.12);
            transform: translateX(3px);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1rem;
            width: 20px;
            text-align: center;
            opacity: 0.9;
        }
        
        .sidebar .submenu {
            background-color: rgba(0, 0, 0, 0.08);
            border-left: 3px solid var(--haramain-accent);
        }
        
        .sidebar .submenu .nav-link {
            padding: 0.5rem 1.25rem 0.5rem 2.5rem;
            font-size: 0.7875rem;
        }
        
        /* Main Content Styling */
        .main-content {
            background-color: var(--haramain-light);
            flex: 1;
        }
        
        .topbar {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            z-index: 10;
            padding: 0.75rem 1.5rem;
        }
        
        /* Card Styling */
        .card-stat {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
            background: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }
        
        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .card-stat .card-body {
            position: relative;
            padding: 1.25rem;
        }
        
        .card-stat .card-body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(to bottom, var(--haramain-secondary), var(--haramain-accent));
        }
        
        .card-stat .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .card-stat .card-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            font-size: 0.6rem;
            background: linear-gradient(to bottom, #ff5252, #d32f2f);
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Buttons */
        .btn-haramain {
            background: linear-gradient(to right, var(--haramain-secondary), var(--haramain-accent));
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.45rem 1.25rem;
            font-weight: 500;
            font-size: 0.8125rem;
            box-shadow: 0 1px 2px rgba(25, 118, 210, 0.15);
        }
        
        .btn-haramain:hover {
            background: linear-gradient(to right, var(--haramain-primary), var(--haramain-secondary));
            color: white;
            box-shadow: 0 2px 4px rgba(25, 118, 210, 0.2);
        }
        
        /* Table Styling */
        .table-haramain {
            border-radius: 8px;
            overflow: hidden;
            font-size: 0.8125rem;
        }
        
        .table-haramain thead {
            background: linear-gradient(to right, var(--haramain-secondary), var(--haramain-accent));
            color: white;
        }
        
        .table-haramain th {
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table-haramain td {
            padding: 0.65rem 0.75rem;
            vertical-align: middle;
            color: var(--text-primary);
            border-top: 1px solid rgba(0, 0, 0, 0.03);
        }
        
        /* Status Badges */
        .badge {
            font-size: 0.6875rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 4px;
        }
        
        .badge-processing {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .badge-completed {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .badge-pending {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        /* Chart Container */
        .chart-container {
            background-color: white;
            border-radius: 8px;
            padding: 1.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }
        
        /* Text styles */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
        }
        
        .h4 {
            font-size: 1.125rem;
        }
        
        .fw-medium {
            font-weight: 500;
        }
        
        small, .small {
            font-size: 0.8125rem;
            color: var(--text-muted);
        }
        
        /* Form elements */
        .form-control, .form-select {
            font-size: 0.8125rem;
            padding: 0.375rem 0.75rem;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }
        
        /* Dropdown menu */
        .dropdown-menu {
            font-size: 0.8125rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
        }
        
        .dropdown-item {
            padding: 0.375rem 1rem;
        }
        
        /* Utility classes */
        .opacity-75 {
            opacity: 0.75;
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .border-light {
            border-color: rgba(0, 0, 0, 0.03) !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Enhanced Sidebar -->
        @include('admin.layout.sidebar')
        <!-- Main Content -->
        <div class="main-content">
            
            @include('admin.layout.header')
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aktifkan tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Animasi sidebar menu
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(3px)';
            });
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });
    </script>
</body>
</html>