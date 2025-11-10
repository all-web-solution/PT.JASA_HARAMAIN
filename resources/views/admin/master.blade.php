<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT JASA HARAMAIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Favicon Placeholders -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @stack('styles')
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const sidebar=document.querySelector('#sidebar');const sidebarOverlay=document.getElementById('sidebarOverlay');const toggleBtn=document.getElementById('sidebarToggle');toggleBtn.addEventListener('click',()=>{sidebar.classList.toggle('show');sidebarOverlay.classList.toggle('show')});sidebarOverlay.addEventListener('click',()=>{sidebar.classList.remove('show');sidebarOverlay.classList.remove('show')})
    </script>
    @stack('scripts')
</body>

</html>
