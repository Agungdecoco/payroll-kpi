<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/NiceAdmin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/NiceAdmin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/NiceAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/NiceAdmin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/NiceAdmin/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/NiceAdmin/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">Payroll</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/NiceAdmin/img/profile-img.jpg') }}" alt="Profile"
                            class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->name }}</h6>
                            <span>{{ auth()->user()->segment->segment }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        {{-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> --}}

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{ route('home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-database"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->level_id == 1 || auth()->user()->segment->division_id == 2)
                        <li>
                            <a href="{{ route('karyawan.index') }}">
                                <i class="bi bi-circle"></i><span>Karyawan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('level.index') }}">
                                <i class="bi bi-circle"></i><span>Level</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('divisi.index') }}">
                                <i class="bi bi-circle"></i><span>Divisi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('segmen.index') }}">
                                <i class="bi bi-circle"></i><span>Segmen</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('parameter.index') }}">
                                <i class="bi bi-circle"></i><span>Parameter KPI</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->level_id == 1 || auth()->user()->segment->division_id == 3)
                        <li>
                            <a href="{{ route('tunjangan.index') }}">
                                <i class="bi bi-circle"></i><span>Tunjangan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pajak.index') }}">
                                <i class="bi bi-circle"></i><span>Pajak</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li><!-- End Components Nav -->

            @if (in_array(auth()->user()->level_id, [1, 2]))
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('kpi.index') }}">
                        <i class="bi bi-clipboard2-data"></i>
                        <span>KPI</span>
                    </a>
                </li><!-- End KPI Page Nav -->
            @endif

            @if (auth()->user()->level_id == 1 || auth()->user()->segment->division_id == 3)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('payroll.index') }}">
                        <i class="bi bi-cash-coin"></i>
                        <span>Penggajian</span>
                    </a>
                </li><!-- End Salary Page Nav -->
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('report.index') }}">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Laporan</span>
                </a>
            </li><!-- End Report Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>2024</span></strong>.
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ asset('assets/NiceAdmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/NiceAdmin/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/NiceAdmin/js/main.js') }}"></script>
    @yield('script')
</body>

</html>
