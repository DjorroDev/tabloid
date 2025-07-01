<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Tabloid Editor</title>
    <meta name="description" content="Tabloid Editor" />
    <base href="{{ url('') }}">
    <link rel="icon" href="https://demikita.id/frontend/img/header-demikita.png">
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/fonts/boxicons.css') }}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Page CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/8.23.3/video-js.min.css" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.css"
        rel="stylesheet">
    <style>
        .tabloid-sidebar {
            width: 220px;
            background: #f8f9fa;
            min-height: 100vh;
            float: left;
        }

        .tabloid-main {
            margin-left: 0px;
        }

        .swal2-container {
            z-index: 9999 !important;
        }

        .drag-drop-area {
            min-height: 400px;
            border: 2px dashed #ccc;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
        }
    </style>
    <script src="{{ asset('bs5/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/config.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.tabloid.partials.sidebar')
            <div class="layout-page tabloid-main">
                @include('layouts.tabloid.partials.header')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS Scripts (same as management) -->
    <script src="{{ asset('bs5/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/main.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('js/custom-common-management.js?v=') . time() }}"></script>
    <script src="https://vjs.zencdn.net/8.23.3/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.js">
    </script>
    <script src="{{ asset('bs5/assets/js/dataTable.js') }}"></script>
</body>

</html>
