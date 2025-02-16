<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                        <i class="bi bi-house-door fs-5 me-2"></i>
                        Dashboard Siswa
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('student.tasks.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Tugas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('siswa.classes.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-school"></i>
                                </span>
                                <span class="hide-menu">Kelas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('siswa.exams.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-school"></i>
                                </span>
                                <span class="hide-menu">Ujian</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="btn btn-outline-primary mx-3 mt-2 d-block"
                                onclick="showLogoutModal()">Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div>
                            @if (session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                            @endif

                            @if (session('error'))
                            <div>
                                {{ session('error') }}
                            </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmation Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-card">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="logoutModalLabel">
                            <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Logout
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="bi bi-question-circle-fill text-warning" style="font-size: 50px;"></i>
                        <h5 class="mt-3">Apakah Anda yakin ingin keluar?</h5>
                        <p class="text-muted">Anda akan logout dari aplikasi ini.</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal" style="transition: 0.3s;">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <!-- Form Logout -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger me-2" style="transition: 0.3s;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script untuk menampilkan modal logout -->
    <script>
        function showLogoutModal() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }
    </script>
</body>

</html>