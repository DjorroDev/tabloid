<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('bs5/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard </title>

    <meta name="description" content="" />

    <base href="{{ url('') }}">
    <!-- Favicon -->
    <link rel="icon" href="https://demikita.id/frontend/img/header-demikita.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" class="template-customizer-core-css" href="{{ asset('bs5/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" class="template-customizer-theme-css"
        href="{{ asset('bs5/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('bs5/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('bs5/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/config.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="{{ asset('bs5/assets/js/dataTable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CkEditor --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script> --}}

    {{-- Untuk Preview di Video flix di CMS (Hapus jika tidak butuh) --}}
    <link href="https://vjs.zencdn.net/8.23.3/video-js.min.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/8.23.3/video.min.js"></script>

    {{-- Plugin: Quality menu video js --}}
    <link
        href="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.js">
    </script>

    <style>
        .relative {
            position: relative !important;
        }

        .absolute {
            position: absolute !important;
        }

        .z-2 {
            z-index: 2;
        }

        .mt--10 {
            margin-top: -10px;
        }

        .swal2-container {
            z-index: 9999 !important;
        }

        table.table {
            width: 100% !important;
        }

        .delete-collapse {
            border: 1px solid;
            position: absolute;
            z-index: 10;
            font-size: 14px;
            left: -10px;
            top: -10px;
            border-radius: 17px;
            background-color: #fb0505;
            color: #fbf9f9;
            padding: 4px 10px;
        }

        .wrap-card-header {
            display: flex;
        }

        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px !important;
        }

        .text-rute {
            font-weight: 100;
        }

        .accordion-header-error,
        .accordion-button.accordion-header-error:not(.collapsed) {
            background-color: #ffd6d6;
        }

        .cke_warning,
        .cke_notifications_area {
            display: none !important;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
    <!-- Layout wrapper -->
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.management.partials.sidebar')

            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.management.partials.header')



                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.management.partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- / Layout wrapper -->
    {{-- <script src="{{ asset('bs5/assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
    <script src="{{ asset('bs5/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


    <script src="{{ asset('bs5/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('bs5/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/main.js') }}"></script>
    <script src="{{ asset('bs5/assets/js/dashboards-analytics.js') }}"></script>
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
    <script>
        // ClassicEditor
        //     .create(document.querySelector('#description-textarea'))
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>
    <script src="{{ asset('js/custom-common-management.js?v=') . time() }}"></script>
    <script>
        function _delete_data(e) {
            Swal.fire({
                title: "Do you want to delete this data?",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                confirmButton: "btn btn-danger",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let id = $(e).attr("data-id");
                    let uri = $(e).attr("data-uri");
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: {
                            id: id,
                            _method: "delete",
                        },
                        success: function(res) {
                            if (res.error == false) {
                                Swal.fire("Deleted!", res.message, "success").then(
                                    () => {
                                        // if (res.reload == false) {
                                        //     $(this).closest('tr').remove();
                                        // } else {
                                        window.location.reload();
                                        // }
                                    }
                                );
                            } else {
                                Swal.fire("Error", res.message, "error");
                            }
                        },
                    });
                }
            });
        }
    </script>
</body>

</html>
