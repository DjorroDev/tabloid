<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo text-center">
        <a href="{{ url('management/dashboard') }}" class="app-brand-link">
            <img src="{{ url('images/logo/logo-wskt-precast.png') }}" alt="WSBP Assets" class="w-75">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-1 mt-3">

        {{-- BANNER DATA --}}
        <li class="menu-item">
            <a href="{{ url('management/dashboard') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-home'></i>
                <div data-i18n="dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Request::segment(2) == 'banner' ? 'active' : '' }}">
            <a href="{{ url('management/banner') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-images'></i>
                <div data-i18n="banner">Banner</div>
            </a>
        </li>

        {{-- INSAN WSBP --}}
        <li class="menu-item {{ Request::segment(2) == 'insan-wsbp' ? 'active' : '' }}">
            <a href="{{ url('management/insan-wsbp') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div data-i18n="insan-wsbp">Insan WSBP</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ Request::segment(2) == 'insan-story' ? 'active' : '' }}">
            <a href="{{ url('management/insan-story') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-blanket"></i>
                <div data-i18n="insan-story">Cerita Insan WSBP</div>
            </a>
        </li> --}}

        <li class="menu-item {{ Request::segment(2) == 'insan-story' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-widget"></i>
                <div data-i18n="Dashboards">Cerita Insan WSBP</div>
            </a>
            {{-- SUB-MENU --}}
            <ul class="menu-sub">
                {{-- Kategroi bertia --}}
                <li class="menu-item {{ Request::segment(3) == 'confirmation' ? 'active' : '' }}">
                    <a href="{{ url('management/insan-story/confirmation') }}" class="menu-link">
                        <div data-i18n="kategori-Berita-Internal">Konfirmasi</div>
                    </a>
                </li>
                {{-- Berita Internal --}}
                <li class="menu-item {{ Request::segment(3) == 'insan-story' ? 'active' : '' }}">
                    <a href="{{ url('management/insan-story/insan-story') }}" class="menu-link">
                        <div data-i18n="Berita-Internal">Cerita Insan</div>
                    </a>
                </li>


            </ul>

        </li>
        {{-- Berita Internal --}}
        <li class="menu-item {{ Request::segment(2) == 'berita-internal' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Dashboards">Berita Internal</div>
            </a>
            {{-- SUB-MENU --}}
            <ul class="menu-sub">
                {{-- Kategroi bertia --}}
                <li class="menu-item {{ Request::segment(3) == 'kategori-berita-internal' ? 'active' : '' }}">
                    <a href="{{ url('management/berita-internal/kategori-berita-internal') }}" class="menu-link">
                        <div data-i18n="kategori-Berita-Internal">Kategori Berita Internal</div>
                    </a>
                </li>
                {{-- Berita Internal --}}
                <li class="menu-item {{ Request::segment(3) == 'berita-internal' ? 'active' : '' }}">
                    <a href="{{ url('management/berita-internal/berita-internal') }}" class="menu-link">
                        <div data-i18n="Berita-Internal">Berita Internal</div>
                    </a>
                </li>


            </ul>

        </li>


        {{-- Surat Edaran --}}
        {{-- <li class="menu-item {{ Request::segment(2) == 'surat-edaran' ? 'active' : '' }}">
            <a href="{{ url('management/surat-edaran') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-envelope"></i>
                <div data-i18n="surat-edaran">Surat Edaran</div>
            </a>
        </li> --}}
        <li class="menu-item {{ Request::segment(2) == 'surat-edaran' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div data-i18n="Dashboards">Surat Edaran</div>
            </a>
            <ul class="menu-sub">
                {{-- <li class="menu-item {{ Request::segment(3) == 'kategori-surat-edaran' ? 'active' : '' }}">
                    <a href="{{ url('management/surat-edaran/kategori-surat-edaran') }}" class="menu-link">
                        <div data-i18n="kategori-surat-edaran">Kategori Surat Edaran</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ Request::segment(3) == 'surat-edaran' ? 'active' : '' }}">
                    <a href="{{ url('management/surat-edaran/surat-edaran') }}" class="menu-link">
                        <div data-i18n="surat-edaran">Surat Edaran</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::segment(2) == 'banner-qhse' ? 'active' : '' }}">
            <a href="{{ url('management/banner-qhse') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-image"></i>
                <div data-i18n="banner-qhse">Banner QHSE</div>
            </a>
        </li>
        <li class="menu-item {{ Request::segment(2) == 'instagram-corporate' ? 'active' : '' }}">
            <a href="{{ url('management/instagram-corporate') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxl-instagram-alt"></i>
                <div data-i18n="instagram-corporate">Instagram Corporate</div>
            </a>
        </li>
        {{-- Video Internal --}}
        <li class="menu-item {{ Request::segment(2) == 'video-internal' ? 'active' : '' }}">
            <a href="{{ url('management/video-internal') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-videos"></i>
                <div data-i18n="video-internal">Video Internal WSBP</div>
            </a>
        </li>

        {{-- Video Internal --}}
        {{-- <li class="menu-item {{ Request::segment(2) == 'video-internal' ? 'active' : '' }}">
            <a href="{{ url('management/video-internal') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-videos"></i>
                <i class='menu-icon tf-icons bx  bxs-movie-play'></i>
                <div data-i18n="video-internal">WSBP Flix</div>
            </a>
        </li> --}}
        {{-- WSBP FLIX --}}
        <li class="menu-item {{ Request::segment(2) == 'wsbp-flix' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx  bxs-movie-play'></i>
                <div data-i18n="video-internal">WSBP Flix</div>
            </a>
            {{-- SUB-MENU --}}
            <ul class="menu-sub">
                {{-- Kategori --}}
                <li class="menu-item {{ Request::segment(3) == 'kategori-flix' ? 'active' : '' }}">
                    <a href="{{ url('management/wsbp-flix/kategori-flix') }}" class="menu-link">
                        <div data-i18n="Video-Flix-Category">Kategori</div>
                    </a>
                </li>

                {{-- Video List --}}
                <li class="menu-item {{ Request::segment(3) == 'wsbp-flix' ? 'active' : '' }}">
                    <a href="{{ url('management/wsbp-flix/wsbp-flix') }}" class="menu-link">
                        <div data-i18n="Video-Flix">Video</div>
                    </a>
                </li>
            </ul>

        </li>

        {{-- MENU TABLOID --}}
        <li class="menu-item active">
            <a href="{{ url('/tabloids') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-book-content"></i>
                <div data-i18n="tabloid">Tabloid</div>
            </a>
        </li>

        {{-- Video Youtube
        <li class="menu-item {{ Request::segment(2) == 'video-youtube' ? 'active' : '' }}">
            <a href="{{ url('management/video-youtube') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-blanket"></i>
                <div data-i18n="video-youtube">Video Youtube WSBP</div>
            </a>
        </li>
        --}}
        <li class="menu-item {{ Request::segment(2) == 'video-youtube-short' ? 'active' : '' }}">
            <a href="{{ url('management/video-youtube-short') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxl-youtube"></i>
                <div data-i18n="video-youtube-short">Youtube Short</div>
            </a>
        </li>
        <li class="menu-item {{ Request::segment(2) == 'widget-spotify' ? 'active' : '' }}">
            <a href="{{ url('management/widget-spotify') }}" class="menu-link">
                <i class='menu-icon bx bxl-spotify'></i>
                <div data-i18n="widget-spotify">Widget Spotify</div>
            </a>
        </li>
        <li class="menu-item {{ Request::segment(2) == 'popup-banner' ? 'active' : '' }}">
            <a href="{{ url('management/popup-banner') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-image"></i>
                <div data-i18n="popup-banner">Popup Banner</div>
            </a>
        </li>

        {{-- Kalender Acara --}}
        <li class="menu-item {{ Request::segment(2) == 'kalender-acara' ? 'active' : '' }}">
            <a href="{{ url('management/kalender-acara') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-calendar"></i>
                <div data-i18n="kalender-acara">Kalender Acara</div>
            </a>
        </li>

    </ul>



</aside>
