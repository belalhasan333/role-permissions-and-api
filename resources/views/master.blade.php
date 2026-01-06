<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- Layout CSS -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.png') }}" />

    <style>
        /* ===== GLOBAL BACKGROUND FIX ===== */
        body {
            background-color: #f4f6f9 !important;
        }

        .container-scroller,
        .page-body-wrapper,
        .main-panel {
            background-color: #f4f6f9 !important;
            min-height: 100vh;
        }

        .content-wrapper {
            background-color: #f4f6f9 !important;
            padding: 20px;
        }

        /* ===== CARD FIX ===== */
        .card {
            background-color: #ffffff !important;
            color: #212529 !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card-title,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        label,
        .fw-bold {
            color: #212529 !important;
        }

        /* ===== TAB FIX ===== */
        .nav-tabs .nav-link {
            color: #495057 !important;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffffff !important;
            color: #0d6efd !important;
            border-bottom: 2px solid #0d6efd;
        }

        /* ===== PROFILE PAGE ONLY ===== */
        .profile-card h2,
        .profile-card h3 {
            color: #212529 !important;
        }

        .social-links a {
            color: #0d6efd;
            margin: 0 5px;
        }
    </style>


    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        @include('backend.partials.sidebar')

        <div class="container-fluid page-body-wrapper">
            @include('backend.partials.navbar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('backend.partials.footer')
            </div>
        </div>
    </div>

    <!-- Vendor bundle (jQuery, Bootstrap) -->
    <script src="{{ asset('Backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>


    <!-- Bootstrap JS bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- CSRF setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    </script>

    <!-- Template JS -->
    <script src="{{ asset('Backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/misc.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/settings.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/todolist.js') }}"></script>
    {{-- ckeditor --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/43.1.0/classic/ckeditor.js"></script> --}}
    <!-- Page-specific push -->
    @stack('scripts')

</body>

</html>
