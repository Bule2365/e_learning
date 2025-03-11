<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --bs-primary-rgb: 99, 102, 241;
            /* Biru Laut Muda */
            --bs-secondary-rgb: 255, 255, 255;
            /* Putih Susu */
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

        /* Modal Styling */
        .modal-content.modal-card {
            background-color: rgba(255, 255, 255, 0.9);
            /* Putih Susu */
            transition: transform 0.3s ease-out;
        }

        .modal-header {
            background-color: rgb(99, 102, 241);
            /* Biru Laut Muda */
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-header .btn-close {
            color: white;
        }

        .modal-footer button {
            transition: all 0.3s ease;
        }

        .modal-footer .btn-light {
            background-color: #f7f7f7;
            border: 1px solid rgba(99, 102, 241, 0.3);
            /* Border halus untuk tombol batal */
        }

        .modal-footer .btn-danger {
            background-color: rgb(99, 102, 241);
            /* Biru Laut Muda */
            border: none;
            color: white;
        }

        .modal-footer .btn-danger:hover {
            background-color: rgb(85, 89, 214);
            /* Warna lebih gelap untuk hover */
            transform: scale(1.05);
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

        /* Sidebar styling */
        .left-sidebar {
            background-color: #1a1a1a;
            /* Warna latar belakang sidebar */
            color: #fff;
            /* Warna teks sidebar */
            transition: transform 0.3s ease-in-out;
            height: 100vh;
            padding-top: 20px;
        }

        .sidebar-item {
            margin: 15px 0;
        }

        /* Sidebar Styling */
        .left-sidebar {
            background-color: rgb(99, 102, 241);
            /* Biru Laut Muda */
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin: 0 0.5rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Hover dengan warna transparan putih susu */
            transform: translateX(4px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.4);
            /* Active dengan efek transparan */
            color: rgb(99, 102, 241);
            /* Warna Biru Laut Muda */
        }

        .sidebar-item .sidebar-link:hover {
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar Icon */
        .sidebar-link i {
            font-size: 20px;
            margin-right: 10px;
        }

        /* Hover effects for active sidebar items */
        .sidebar-link.active:hover {
            background-color: rgba(255, 255, 255, 0.6);
            /* Hover active link */
            color: rgb(99, 102, 241);
            /* Biru Laut Muda */
        }

        /* Sidebar Brand Section */
        .brand-logo {
            background-color: #b0c9e5;
            /* Warna latar belakang logo */
            padding: 1rem;
            color: #f4b400;
            /* Warna teks logo */
            font-size: 18px;
            font-weight: bold;
        }

        .brand-logo .logo-img {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }

        .brand-logo .logo-img i {
            font-size: 25px;
        }

        /* Hover shadow for the sidebar links */
        .sidebar-item .sidebar-link:hover {
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Logout Button */
        .sidebar-item .btn-outline-light {
            color: #fff;
            border-color: #f4b400;
            transition: all 0.3s ease;
            border-radius: 30px;
            padding: 12px 18px;
            text-align: center;
            font-weight: 600;
        }

        .sidebar-item .btn-outline-light:hover {
            background-color: #f4b400;
            color: #1a1a1a;
            transform: translateY(-2px);
        }

        /* Sidebar Toggle (close button) */
        .sidebartoggler {
            display: inline-block;
            position: relative;
            font-size: 25px;
            color: white;
            cursor: pointer;
            z-index: 9999;
        }

        /* Sidebar Collapse Icon */
        .nav-link .ti-menu-2 {
            color: rgb(99, 102, 241);
            font-size: 24px;
        }

        /* Modal Icon Styling */
        .modal-body .bi-question-circle-fill {
            font-size: 50px;
            color: rgb(255, 221, 51);
            /* Warna kuning */
        }

        /* Scrollbar styling for sidebar */
        .scroll-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .scroll-sidebar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .scroll-sidebar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div class="sidebar-container">
                <!-- Brand Logo Section -->
                <div class="brand-logo d-flex align-items-center justify-content-between p-3">
                    <a href="{{ route('siswa.dashboard') }}"
                        class="logo-img d-flex align-items-center text-white text-decoration-none">
                        <i class="bi bi-house-door fs-5 me-2"></i>
                        <span class="fs-5">Dashboard Siswa</span>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="bi bi-x-lg fs-5 text-white"></i>
                    </div>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="sidebar-nav scroll-sidebar">
                    <ul id="sidebarnav" class="list-unstyled mb-0">
                        <!-- Tugas Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center px-3 py-2 rounded-3 text-white hover-shadow"
                                href="{{ route('student.tasks.index') }}" aria-expanded="false">
                                <i class="bi bi-check-circle me-2 fs-4"></i> <!-- Updated icon for Tugas -->
                                <span class="hide-menu">Tugas</span>
                            </a>
                        </li>
                        <!-- Materi Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center px-3 py-2 rounded-3 text-white hover-shadow"
                                href="{{ route('siswa.material.index') }}" aria-expanded="false">
                                <i class="bi bi-book me-2 fs-4"></i> <!-- Updated icon for Materi -->
                                <span class="hide-menu">Materi</span> <!-- Corrected "Tugas" to "Materi" -->
                            </a>
                        </li>
                        <!-- Ujian Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center px-3 py-2 rounded-3 text-white hover-shadow"
                                href="{{ route('siswa.exams.index') }}" aria-expanded="false">
                                <i class="bi bi-pencil-square me-2 fs-4"></i> <!-- Updated icon for Ujian -->
                                <span class="hide-menu">Ujian</span>
                            </a>
                        </li>
                        <!-- Logout Button -->
                        <li class="sidebar-item">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-light mx-3 mt-4 d-block shadow-sm hover-shadow"
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
                        <h5 class="modal-title text-white" id="logoutModalLabel">
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

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>


    <!-- Script untuk menampilkan modal logout -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var headerCollapse = document.getElementById('headerCollapse');
            if (headerCollapse) {
                headerCollapse.addEventListener('click', function() {
                    document.querySelector('.left-sidebar').classList.toggle('active');
                });
            }
        });

        function showLogoutModal() {
            var logoutModalElement = document.getElementById('logoutModal');
            if (logoutModalElement) {
                var logoutModal = new bootstrap.Modal(logoutModalElement);
                logoutModal.show();
            } else {
                console.error("Modal logout tidak ditemukan!");
            }
        }
    </script>
</body>

</html>
