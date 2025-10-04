<!DOCTYPE html>
<html lang="id">
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
            overflow-x: hidden;
        }

        /* Sidebar Styling - Diperbarui */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--haramain-primary) 0%, var(--haramain-secondary) 100%);
            color: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--haramain-accent), var(--haramain-primary));
            color: white;
            font-size: 2rem;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1.5rem;
            margin: 0.15rem 0;
            border-radius: 0 50px 50px 0;
            transition: all 0.2s;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            opacity: 0.9;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        .sidebar .submenu {
            background-color: rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--haramain-accent);
            margin-left: 1.5rem;
            border-radius: 8px 0 0 8px;
        }

        .sidebar .submenu .nav-link {
            padding: 0.6rem 1.25rem 0.6rem 2.5rem;
            font-size: 0.85rem;
        }

        /* Main Content Styling */
        .main-content {
            background-color: var(--haramain-light);
            flex: 1;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 100;
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
        }

        /* Mobile menu toggle */
        .sidebar-toggle {
            display: none;
            background: var(--haramain-primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 0.8rem;
            margin-right: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Overlay for mobile when sidebar is open */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .sidebar-overlay.show {
            display: block;
        }

        /* Card Styling */
        .card-stat {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.08);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .card-stat .card-title {
                font-size: 1.1rem;
            }
            
            .topbar {
                padding: 0.8rem 1rem;
            }
            #text-title{
                display:none;
            }
        }

        @media (max-width: 768px) {
            .user-info {
                display: none;
            }
            
            .sidebar-header {
                padding: 1.25rem 1rem;
            }
            
            .sidebar .nav-link {
                padding: 0.7rem 1.25rem;
                font-size: 0.85rem;
            }
            
            .sidebar .nav-link i {
                font-size: 1rem;
                margin-right: 10px;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 0.75rem;
            }
            
            .card-stat .card-title {
                font-size: 1rem;
            }
            
            .h4, h1.h4 {
                font-size: 1.1rem;
            }
            
            .sidebar {
                width: 240px;
            }
            
            .user-avatar {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }
        }

        /* Animasi untuk sidebar */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .sidebar.show {
            animation: slideIn 0.3s ease forwards;
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
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
  
</body>
</html>