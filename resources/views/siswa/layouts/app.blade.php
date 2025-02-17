<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    @stack('styles')
    <style>
        :root {
            --bs-primary-rgb: 99, 102, 241;
            --bs-font-sans-serif: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            --bs-body-line-height: 1.6;
            --bs-body-color: #1f2937;
        }

        /* Typography */
        body {
            font-family: var(--bs-font-sans-serif);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: var(--bs-body-line-height);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #111827;
            font-weight: 600;
            letter-spacing: -0.025em;
        }

        /* Sidebar transitions */
        .left-sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin: 0 0.5rem;
        }

        .sidebar-link:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: rgb(var(--bs-primary-rgb));
        }

        /* Button transitions */
        .btn {
            transition: all 0.2s ease;
            letter-spacing: 0.025em;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Modal animation */
        .modal-card {
            transition: transform 0.3s ease-out;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem;
        }

        /* Notification messages */
        .alert {
            transition: opacity 0.3s ease;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
        }

        /* Scrollbar styling */
        .scroll-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-sidebar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .scroll-sidebar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }
    </style>
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
                            <a href="javascript:void(0);"
                                class="btn btn-outline-primary mx-3 mt-2 d-block shadow-sm hover-shadow"
                                onclick="showLogoutModal()">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
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
                                <div
                                    class="alert alert-success d-flex align-items-center animate__animated animate__fadeIn">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div
                                    class="alert alert-error d-flex align-items-center animate__animated animate__headShake">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
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
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal"
                            style="transition: 0.3s;">
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
