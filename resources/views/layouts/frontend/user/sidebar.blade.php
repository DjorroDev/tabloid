<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 col-mobile">
    <div class="dashboard-menu rd-20 max-320 mx-auto">
        <div class="dashboard-menu-wrapper">
            <div class="menu-logout position-absolute">
                <button onclick="window.location.href='{{ url('logout') }}'" class="ab-btn btn-primary c-white rd-50">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </div>
            <div class="dashboard-name w-100">
                <h6 class="ab-body c-white bold">
                    Hi, {{ Auth::user()->name }}!
                </h6>
            </div>
            <ul class="d-flex flex-column gap-3">
                <li class="{{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                    <a class="d-flex gap-2 align-items-center" href="{{ url('user/profile') }}">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-user"></i>
                        </div> Data Diri
                    </a>
                </li>
                <li>
                    <a class="d-flex gap-1 align-items-center c-default x-bold">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-money-check"></i>
                        </div> Transaksi
                    </a>
                    <ul class="d-flex flex-column gap-2">
                        <li class="{{ Request::segment(3) == 'order-ticket' ? 'active' : '' }}">
                            <a class="d-flex gap-2 align-items-center"
                                href="{{ url('user/transaction/order-ticket') }}">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-ticket"></i>
                                </div> Pembelian Tiket {!! badge_total_status('order-ticket') !!}
                            </a>
                        </li>
                        <li class="{{ Request::segment(3) == 'order-package' ? 'active' : '' }}">
                            {{-- <a class="d-flex gap-2 align-items-center menu-disabled"> --}}
                            <a class="d-flex gap-2 align-items-center"   href="{{ url('user/transaction/order-package') }}">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div> Kirim Paket
                                 {{-- <span class="text-center bg-primary c-white x-bold rd-20">Akan
                                    Hadir</span> --}}
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="d-flex gap-1 align-items-center c-default x-bold">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div> Riwayat Transaksi
                    </a>
                    <ul class="d-flex flex-column gap-2">
                        <li class="{{ Request::segment(3) == 'history-ticket' ? 'active' : '' }}">
                            <a class="d-flex gap-2 align-items-center"
                                href="{{ url('user/transaction/history-ticket') }}">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-ticket"></i>
                                </div> Riwayat Tiket
                            </a>
                        </li>
                        <li class="{{ Request::segment(3) == 'history-package' ? 'active' : '' }}">
                            {{-- <a class="d-flex gap-2 align-items-center menu-disabled"> --}}
                                <a class="d-flex gap-2 align-items-center"   href="{{ url('user/transaction/history-package') }}">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div> Riwayat Paket 
                                {{-- <span class="text-center bg-primary c-white x-bold rd-20">Akan
                                    Hadir</span> --}}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="menu-mobile">
    <button class="ab-btn btn-primary btn-mobile full">
        <span class="mobile-open"><i class="fa-solid fa-bars me-1"></i> Menu Dashboard</span>
        <span class="mobile-close"><i class="fa-solid fa-circle-xmark me-1"></i> Tutup Menu</span>
    </button>
</div>

<script>
    $('.btn-mobile').on('click', function() {
        $(".col-mobile, .menu-mobile").toggleClass('active');
    });
</script>
