<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <link rel="icon" href="{{ asset('images/logo/favicon.png') }}">

    <base href="{{ url('') }}">
    <title>Central WSBP</title>
    {{-- set meta description dan keywords disini --}}
    {{-- {!! _set_meta(request()->path()) !!} --}}
    <meta name="description"
        content="PT Waskita Beton Precast Tbk (WSBP) adalah perusahaan manufaktur beton precast, readymix, jasa konstruksi dan post tension terdepan di Indonesia.">

    <link rel="stylesheet" href="{{ asset('bs5/css/bootstrap.min.css?v=1') }}" crossorigin="anonymous">
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-6.min.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper.4.3.5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?v=x-') . time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css?v=x-') . time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.4.1.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fancybox.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap" rel="stylesheet">

    <script src="{{ asset('js/jquery.3.4.0.min.js') }}"></script>
    <script src="{{ asset('bs5/js/popper.min.js?v=1') }}"></script>
    <script src="{{ asset('bs5/js/bootstrap.min.js?v=1') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/lottie-player.js') }}"></script>
    <script src="{{ asset('js/lottie-interactivity.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/swiper.4.3.5.min.js') }}"></script>
    <script src="{{ asset('js/select2.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>

    {{-- Core Video js --}}
    <link href="https://vjs.zencdn.net/8.23.3/video-js.min.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/8.23.3/video.min.js"></script>

    {{-- Plugin: Quality menu video js --}}
    <link
        href="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-menu@1.0.4/dist/videojs-contrib-quality-menu.min.js">
    </script>
    {{-- Plugin Playlist video js --}}
    </script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-playlist@5.2.0/dist/videojs-playlist.min.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script nonce="{{ csp_nonce(base64_encode(time())) }}">
        // setup ajax global csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const _BASE_ASSET = "{{ asset('') }}";
    </script>

    <!-- Google tag (gtag.js) -->
    {{--
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1ZKL3TGQ0K"></script>
    {{--
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-1ZKL3TGQ0K');
    </script> --}}

    <!-- Google tag (gtag.js) -->
    {{-- PRODUCTION --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XDXCLR2BC8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-XDXCLR2BC8');
    </script>

    <!-- Google tag (gtag.js) -->
    {{-- DEVELOPMENT --}}
    {{--
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-736VKL757X"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-736VKL757X');
    </script> --}}
    <script type="text/javascript">
        $('.tooltip-test').tooltip();
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap');

        .show-pwd {
            position: absolute;
            right: 15px;
            top: 45px;
            z-index: 2;
        }

        .fancybox-button--thumbs {
            display: none
        }

        .cke_warning,
        .cke_notifications_area {
            display: none !important;
        }
    </style>


</head>

<body>
    @if (Auth::check())
        <header>
            <div class="navbar-progress">
                <div class="progress-navbar">
                    <div class="truck-navbar">
                        <lottie-player src="{{ asset('images/truck-navbar/data.json') }}" autoplay
                            loop></lottie-player>
                    </div>
                </div>
                <progress class="progress-bars" value="0" max="100">
                </progress>
            </div>
            <nav id="navigation">
                <div class="container-fluid container-nav relative">
                    <div class="nav-wrapper-left d-flex align-items-center me-auto">
                        <div class="nav-logo">
                            <a href="{{ url('/') }}" class="btn-ws btn-secondary gap-2">
                                <i class="fa-solid fa-house"></i> <span>Beranda</span>
                            </a>
                        </div>
                        {{-- <div class="li-logout-wrapper me-auto">
                            @if (Auth::check())
                            <a href="{{ url('sso/logout') }}"
                                class="li-logout d-flex align-items-center justify-content-center c-white ts-03">
                                <i class="fa-solid fa-power-off"></i>
                            </a>
                            @endif
                        </div> --}}
                    </div>
                    {{-- <button class="nav-toggle" type="button">
                        <span class=""></span>
                        <span class=""></span>
                        <span class=""></span>
                    </button> --}}
                    <div class="nav-menu">
                        <ul>

                            {{-- START OF LOGIN COMPONENT --}}

                            {{-- <li class="{{ Request::segment(1) == '' ? 'active' : '' }}">
                                <a href="{{ url('/') }}">
                                    Beranda
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == 'about' ? 'active' : '' }}">
                                <a href="{{ url('about') }}">
                                    Tentang Kami
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == 'kita_belajar' ? 'active' : '' }}">
                                <a href="{{ url('kita_belajar') }}">
                                    Kita Belajar
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == 'kita_bermain' ? 'active' : '' }}">
                                <a href="{{ url('kita_bermain') }}">
                                    Kita Bermain
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == 'portofolio' ? 'active' : '' }}">
                                <a href="{{ url('portofolio') }}">
                                    Portofolio
                                </a>
                            </li> --}}
                            {{-- <li class="">
                                <select class="form-control">
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="Role A">Role A</option>
                                    <option value="Role B">Role B</option>
                                </select>
                            </li>
                            <li class="">
                                <a href="{{ url('') }}" class="btn-ws btn-primary">
                                    Menuju E-office
                                </a>
                            </li> --}}

                            {{-- END OF LOGIN COMPONENT --}}
                            @if (!Auth::check())
                                <li class="">
                                    <a href="{{ url('sso/redirect') }}" class="btn-ws btn-primary">
                                        Sign in E-Office with SSO
                                    </a>
                                </li>
                            @else
                                <li class="li-select-role">
                                    <select class="form-control" id="role-id" onchange="fetch_myedesk()">
                                        @foreach (myroles() as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </li>
                                <li class="">
                                    <a href="https://e-office.waskitaprecast.co.id/apps/sso/refreshtoken.php"
                                        class="btn-ws btn-primary">
                                        Menuju E-Office
                                    </a>
                                </li>
                                <li class="dropdown-container">
                                    <div class="area-click-dropdown" onclick="toggleDropdown()">
                                        <i id="dropdown-icon"
                                            class="fa-solid fa-chevron-down d-flex align-items-center justify-content-center w-100 h-100 c-white"></i>
                                    </div>
                                    <div class="dropdown-link-menu">
                                        <ul class="dropdown-link-wrapper">
                                            <li class="dropdown-link-item"><a
                                                    href="https://e-office.waskitaprecast.co.id/apps/sso/refreshtoken.php"
                                                    target="blank">E-Office</a></li>
                                            <li class="dropdown-link-item divider"><a href="https://west.waskita.co.id/"
                                                    target="blank">WEST</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://weshare.waskita.co.id/" target="blank">WESHARE</a>
                                            </li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://wsbp-sync-ca.lemonsand-dd37d4ab.southeastasia.azurecontainerapps.io/central/qubisa/sso/{{ encrypt_email_sso_qubisa() }}"
                                                    target="blank">Learning Management System (LMS)</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://app.teamflect.com/getstarted"
                                                    target="blank">Teamflect</a>
                                            </li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://jdi.waskitaprecast.co.id" target="blank">Jaringan
                                                    Dokumen
                                                    & Informasi (JDI)</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://ia.waskitaprecast.co.id/" target="blank">Sistem
                                                    Informasi
                                                    Audit (SIA)</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://probis.waskitaprecast.co.id/"
                                                    target="blank">Enterprise
                                                    Architecture (Sparx)</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://waskitaprecast.amtiss.com/" target="blank">Asset
                                                    Management & Maintenance (AMTISS)</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://dk.waskitaprecast.co.id/" target="blank">Dana Kerja
                                                    Monitoring System</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://hk.waskitaprecast.co.id/" target="blank">Pembebanan
                                                    HK</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://helpdesk.waskitaprecast.co.id/"
                                                    target="blank">Helpdesk IT,
                                                    HCM, & GA</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://waskitaprecast.co.id/" target="blank">Website
                                                    Corporate</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://eproc.waskitaprecast.co.id/panitia/"
                                                    target="blank">E-Proc</a>
                                            </li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://investor.waskitaprecast.co.id/"
                                                    target="blank">Website
                                                    Investor Relations</a></li>
                                            <li class="dropdown-link-item divider"><a
                                                    href="https://free3dbim-produkwsbp.com/" target="blank">3D BIM
                                                    Catalogue</a></li>
                                            <li class="dropdown-link-item divider"><a href="https://belajarbeton.com/"
                                                    target="blank">Belajar Beton</a></li>
                                        </ul>
                                    </div>
                                </li>


                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

        </header>
    @endif

    @yield('content')
    @if (Auth::check())
        <footer class="d-flex flex-column align-items-center justify-content-center text-center mt80">
            <div class="footer-wrapper w-100 bg-grey-custom">
                <div class="container mt32 mb32">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <div class="footer-content-wrapper">
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Waskita Group</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://west.waskita.co.id/" target="blank">WEST</a>
                                        </p>
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="https://weshare.waskita.co.id/"
                                                target="blank">WESHARE</a>
                                        </p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Corporate Secretary</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://e-office.waskitaprecast.co.id/apps/sso/refreshtoken.php">
                                                E-Office
                                            </a></p>
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="https://waskitaprecast.co.id/"
                                                target="blank">Website
                                                Corporate</a>
                                        </p>
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="https://investor.waskitaprecast.co.id/"
                                                target="blank">Website
                                                Investor Relations</a>
                                        </p>
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="https://belajarbeton.com/"
                                                target="blank">Belajar Beton</a>
                                        </p>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <div class="footer-content-wrapper footer-content-margin">
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">HCM</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://wsbp-sync-ca.lemonsand-dd37d4ab.southeastasia.azurecontainerapps.io/central/qubisa/sso/{{ encrypt_email_sso_qubisa() }}"
                                                target="blank">Learning Management System (LMS)</a></p>
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://app.teamflect.com/getstarted"
                                                target="blank">Teamflect</a></p>
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://hk.waskitaprecast.co.id/" target="blank">Pembebanan
                                                HK</a></p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">CSRM</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://jdi.waskitaprecast.co.id" target="blank">Jaringan
                                                Dokumen
                                                & Informasi (JDI)</a></p>
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="https://probis.waskitaprecast.co.id/"
                                                target="blank">Enterprise
                                                Architecture (Sparx)</a>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Video WSBP</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body">
                                            <a class="ws-body c-small" href="{{ route('wsbp-flix') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                WSBP Insight
                                            </a>
                                        </p>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <div class="footer-content-wrapper footer-content-margin">
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">IT</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://helpdesk.waskitaprecast.co.id/" target="blank">Helpdesk
                                                IT, HCM, & GA</a></p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">FACC</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://dk.waskitaprecast.co.id/" target="blank">Dana
                                                Kerja
                                                Monitoring System</a></p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">SCM</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://eproc.waskitaprecast.co.id/panitia/"
                                                target="blank">E-Proc</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <div class="footer-content-wrapper footer-content-margin">
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Internal Audit</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://ia.waskitaprecast.co.id/" target="blank">Sistem
                                                Informasi
                                                Audit (SIA)</a></p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Equipment</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://waskitaprecast.amtiss.com/" target="blank">Asset
                                                Management & Maintenance (AMTISS)</a></p>

                                    </div>
                                </div>
                                <div class="footer-content">
                                    <div class="footer-header">
                                        <h6 class="ws-head c-primary">Engineering & Innovation</h6>
                                    </div>
                                    <div class="footer-body">
                                        <p class="ws-body"><a class="ws-body c-small"
                                                href="https://free3dbim-produkwsbp.com " target="blank">3D BIM
                                                Catalogue</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-bottom-wrapper">
                <p class="ws-body c-white bold">
                    Central - E-Office WSBP
                </p>
            </div>
        </footer>
    @endif

    <script src="{{ asset('js/gsap.min.js') }}"></script>
    <script src="{{ asset('js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('js/ScrollToPlugin.min.js') }}"></script>

    <script>
        gsap.to('.progress-navbar', {
            xPercent: 100,
            ease: "none",
            scrollTrigger: {
                trigger: "body",
                start: "top top",
                end: "bottom bottom",
                scrub: true,
            }
        });

        gsap.registerPlugin(ScrollTrigger);
        gsap.to('progress', {
            value: 100,
            ease: 'none',
            scrollTrigger: {
                trigger: "body",
                scrub: 1,
                start: 'top top',
                end: 'bottom bottom',
                // markers: true,
            }
        });
    </script>

    <script>
        function toggleDropdown() {
            const dropdownMenu = document.querySelector('.dropdown-link-menu');
            const dropdownIcon = document.getElementById('dropdown-icon');

            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
                dropdownIcon.classList.remove('fa-chevron-up');
                dropdownIcon.classList.add('fa-chevron-down');
            } else {
                dropdownMenu.style.display = 'block';
                dropdownIcon.classList.remove('fa-chevron-down');
                dropdownIcon.classList.add('fa-chevron-up');
            }
        }

        // Optional: To close the dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('#dropdown-icon')) {
                const dropdowns = document.getElementsByClassName("dropdown-link-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                        const dropdownIcon = document.getElementById('dropdown-icon');
                        dropdownIcon.classList.remove('fa-chevron-up');
                        dropdownIcon.classList.add('fa-chevron-down');
                    }
                }
            }
        }
    </script>
    <script src="{{ asset('js/custom-common.js') }}"></script>

    <script nonce="{{ csp_nonce(base64_encode(time())) }}">
        $(function() {
            $(document).scroll(function() {
                var $nav = $("#navigation");
                $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
            });
        });
        $('.nav-toggle').on('click', function() {
            $(".nav-menu, .nav-toggle").toggleClass('active');
        });

        function _submit(e) {
            const formName = $(e).data('form-id');
            const formId = document.getElementById(formName);
            var formData = new FormData(formId);
            var btn = $(e);
            var htmlBtn = btn.text();
            const _url = formId.getAttribute('url');
            $.ajax({
                url: _url,
                data: formData,
                type: 'POST',
                processData: false,
                dataType: 'json',
                cache: false,
                contentType: false,
                beforeSend: function() {
                    btn.attr('onclick', '');
                    btn.html(
                        '<span style="padding-right:15px">Loading...</span> <img src="{{ asset('images/loading-white.gif') }}" style="width: 30px;position: absolute;right: 10px;" alt="">'
                    );
                },
                complete: function() {
                    btn.attr('onclick', '_submit(this)');
                    btn.html(htmlBtn);
                },
                success: function(response) {
                    $('.form-group').removeClass('has-error');
                    $('.text-danger').remove();
                    if (response.error === true) {
                        if (response.validation === true) {
                            for (i in response.message) {
                                $('input[name=\'' + i + '\']').closest('.form-group').addClass(
                                    'has-error');
                                $('input[name=\'' + i + '\']').after(
                                    '<small class="text-danger"><i>' + response
                                    .message[i] + '</i></small>');
                                $('textarea[name=\'' + i + '\']').closest('.form-group').addClass('has-error');
                                $('textarea[name=\'' + i + '\']').after('<small class="text-danger"><i>' +
                                    response.message[i] + '</i></small>');
                                $('select[name=\'' + i + '\']').closest('.form-group').addClass('has-error');
                                $('select[name=\'' + i + '\']').after('<small class="text-danger"><i>' +
                                    response.message[i] + '</i></small>');
                            }
                        } else {
                            swal(
                                'Error',
                                response.message,
                                'error'
                            )
                        }
                    } else {
                        swal(
                            'Berhasil',
                            response.message,
                            'success'
                        ).then((x) => {
                            window.location.href = response.redirect;
                        })
                    }
                },

                error: function(response) {
                    btn.attr('onclick', '_submit(this)');
                    btn.html(htmlBtn);
                    swal(
                        'Error',
                        "Terjadi kesalahan",
                        'error'
                    )
                }
            });
        }

        function _submitHasArray(e) {
            const formName = $(e).data('form-id');
            const formId = document.getElementById(formName);
            var formData = new FormData(formId);
            var btn = $(e);
            var htmlBtn = btn.text();
            const _url = formId.getAttribute('url');
            $.ajax({
                url: _url,
                data: formData,
                type: 'POST',
                processData: false,
                dataType: 'json',
                cache: false,
                contentType: false,
                beforeSend: function() {
                    btn.attr('type', 'button');
                    btn.html(
                        '<span style="padding-right:15px">Loading...</span> <img src="{{ asset('images/loading-white.gif') }}" style="width: 30px;position: absolute;right: 10px;" alt="">'
                    );
                },
                complete: function() {
                    btn.attr('onclick', '_submitHasArray(this)');
                    btn.html(htmlBtn);
                },
                success: function(response) {
                    $('.form-group').removeClass('has-error');
                    $('.text-danger').remove();
                    if (response.error === true) {
                        if (response.validation === true) {
                            for (i in response.message) {
                                var message = response.message[i];
                                var key = i.split('.');
                                var k = key[0] + '[' + key[1] + ']';
                                var msg = message.join(',');
                                if (typeof key[1] === "undefined") {
                                    $('input[name=\'' + i + '\']').closest('.form-group')
                                        .addClass('has-error');
                                    $('input[name=\'' + i + '\']').after(
                                        '<small class="text-danger"><i>' + response.message[
                                            i] + '</i></small>');
                                    $('textarea[name=\'' + i + '\']').closest('.form-group')
                                        .addClass('has-error');
                                    $('textarea[name=\'' + i + '\']').after(
                                        '<small class="text-danger"><i>' + response.message[
                                            i] + '</i></small>');
                                    $('select[name=\'' + i + '\']').closest('.form-group')
                                        .addClass('has-error');
                                    $('select[name=\'' + i + '\']').after(
                                        '<small class="text-danger"><i>' + response.message[
                                            i] + '</i></small>');
                                } else {
                                    msg = msg.replaceAll(i, key[0]);
                                    console.log(k);
                                    $('span#warning-upload-' + key[0] + '-' + key[1]).closest('.form-group')
                                        .addClass('has-error');
                                    $('span#warning-upload-' + key[0] + '-' + key[1]).after(
                                        '<small class="text-danger"><i>' + msg + '</i></small>');
                                    $('input[type="text"][name=\'' + k + '\']').closest('.form-group').addClass(
                                        'has-error');
                                    $('input[type="text"][name=\'' + k + '\']').after(
                                        '<small class="text-danger"><i>' + msg + '</i></small>');
                                    $('input[type="email"][name=\'' + k + '\']').closest('.form-group')
                                        .addClass('has-error');
                                    $('input[type="email"][name=\'' + k + '\']').after(
                                        '<small class="text-danger"><i>' + msg + '</i></small>');
                                    $('input[type="datetime-local"][name=\'' + k + '\']').closest('.form-group')
                                        .addClass(
                                            'has-error');
                                    $('input[type="datetime-local"][name=\'' + k + '\']').after(
                                        '<small class="text-danger"><i>' + msg + '</i></small>');
                                    $('textarea[name=\'' + k + '\']').closest('.form-group').addClass(
                                        'has-error');
                                    $('textarea[name=\'' + k + '\']').after('<small class="text-danger"><i>' +
                                        msg +
                                        '</i></small>');
                                    $('select[name=\'' + k + '\']').closest('.form-group').addClass(
                                        'has-error');
                                    $('select[name=\'' + k + '\']').after('<small class="text-danger"><i>' +
                                        msg +
                                        '</i></small>');
                                    $('#menu-' + key[1]).addClass('has-error-custom');
                                }
                            }
                            swal(
                                'Error',
                                'Mohon cek kembali isi form Anda',
                                'error'
                            )
                        } else {
                            swal(
                                'Error',
                                response.message,
                                'error'
                            )
                            // console.log(response.message);
                        }
                        btn.attr('onclick', '_submitHasArray(this)');
                        btn.html(htmlBtn);
                    } else {
                        swal(
                            'Berhasil',
                            response.message,
                            'success'
                        ).then((x) => {
                            window.location.href = response.redirect;
                        });
                        btn.attr('onclick', '_submitHasArray(this)');
                        btn.html(htmlBtn);
                    }
                },
                error: function(response) {
                    btn.attr('onclick', '_submitHasArray(this)');
                    btn.html(htmlBtn);
                    swal(
                        'Error',
                        "Terjadi kesalahan",
                        'error'
                    )
                }
            });
        }
        // LINKS TO ANCHORS
        $('.menu-right li a[href^="#"]').on('click', function(event) {
            var $target = $(this.getAttribute('href'));

            if ($target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: $target.offset().top
                }, 500, 'easeInOut');
            }
        });

        function makeSlug(text) {
            return text
                .toString() // Convert to string
                .toLowerCase() // Convert to lowercase
                .trim() // Remove whitespace from both ends
                .replace(/[^a-z0-9 -]/g, '') // Remove non-alphanumeric characters (except spaces and hyphens)
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-'); // Remove multiple consecutive hyphens
        }

        function playVideo(e) {
            const id = $(e).attr('data-id');
            const title = $(e).attr('data-title');
            let slug = makeSlug(title);
            const source = $(e).attr('data-source');
            const thumbnail = $(e).attr('data-thumbnail');
            // BUAT EVENT TRACKER UNTUK VIDEO INTERNAL
            let url = '{{ url('video-internal') }}/' + id + '/' + slug;
            gtag('event', 'page_view', {
                'page_location': url, // URL virtual yang dikirim ke GA
                'page_title': title // Judul halaman virtual
            });

            $('#vi-video').attr("src", "");
            $('#modalVideoInternal').find('#vi-title').text(title);
            $('#vi-video').attr("src", source);
            $('#modalVideoInternal').modal('show');
            // return;
            // $.ajax({
            //     url: "{{ url('/component/video-internal-player') }}",
            //     type: 'post',
            //     data: {
            //         thumbnail: thumbnail,
            //         source: source,
            //     },
            //     beforeSend: function() {

            //     },
            //     success: function(response) {
            //         $('#render-video-internal-player').html(response.content);
            //         $('#modalVideoInternal').modal('show');
            //         $('#render-video-internal-player').onmouseleave = function() {
            //             console.log("Mouse pointer left the element");
            //         };
            //         const controls = $(".custom-video__control");
            //         const video = $(".custom-video__video");
            //         video.mouseenter(function() {
            //             controls.css("display", "flex");
            //         });
            //         video.mouseleave(function() {
            //             if (!$('#vi-poster')[0].paused) {
            //                 controls.css("display", "none");
            //             }
            //         });
            //     }
            // })
        }

        function checkVideoStatus(action) {
            const controls = $(".custom-video__control");
            if (action == 'blur') {
                $(".custom-video__loading-spinner").css("display", "flex");
                return;
            }
            if (typeof $('#vi-poster')[0] == 'undefined') {
                return;
            }


            if ($('#vi-poster')[0].paused) {
                controls.html('<img src="{{ asset('images/play-icon.png') }}" alt="WSBP assets"/>');
            } else {
                controls.html('<img src="{{ asset('images/pause-icon.png') }}" alt="WSBP assets"/>');
            }
            if (action == 'canplay') {
                $(".custom-video__loading-spinner").css("display", "none");
            }
        }
        $("#modalVideoInternal").on("hidden.bs.modal", function(e) {
            $("#modalVideoInternal iframe").attr("src", "");
        });


        function detailStory(e) {
            const id = $(e).data('id');
            $('#modalStory').modal('show');
            $.ajax({
                url: '{{ url('journal-insan/detail') }}',
                data: {
                    id: id
                },
                type: "POST",
                beforeSend: function() {
                    $('#modalStoryRender').html('Loading...');
                },
                success: function(response) {
                    // BUAT EVENT TRACKER UNTUK STORY DETAIL
                    let url = '{{ url('/journal-insan/detail') }}/' + id;
                    gtag('event', 'page_view', {
                        'page_location': url, // URL virtual yang dikirim ke GA
                        'page_title': response[0].title // Judul halaman virtual
                    });
                    $('#modalStoryRender').html(response.content);
                },
                error: function(response) {
                    $('#modalStoryRender').html('Gagal memuat data...');

                },
            });
        }
    </script>

    <!-- Contact Us Section -->
    <!-- End of Contact Us Section -->
