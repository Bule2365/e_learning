<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Guru - SMK Informatika Utama')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styleGuru.css') }}">
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside>
            <div class="school-brand">
                <h3>SMK Informatika Utama</h3>
                <p>Kejuruan Teknologi Informasi</p>
                <button class="close-sidebar" id="closeSidebar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-house"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.classes.index') }}">
                            <i class="bi bi-mortarboard"></i>
                            Kelas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.index') }}">
                            <i class="bi bi-clipboard2"></i>
                            Tugas Siswa
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Header -->
            <header>
                <nav class="header-nav">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="profile-dropdown">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="profileMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-arrow-down-square-fill"></i>
                                <!-- Profile button content here -->
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileMenuButton">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        onclick="event.preventDefault(); showLogoutModal();">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Content Area -->
            <div class="content-wrapper">
                @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
                @endif

                <div class="content-card">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle & Close
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('aside').classList.add('active');
            document.getElementById('sidebarOverlay').classList.add('active');
        });

        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.querySelector('aside').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        });

        // Profile Dropdown
        document.getElementById('profileDropdown').addEventListener('click', function() {
            document.getElementById('profileMenu').classList.toggle('show');
        });

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileMenu');

            if (!profileDropdown?.contains(event.target) && !profileMenu?.contains(event.target)) {
                profileMenu?.classList.remove('show');
            }
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.querySelector('aside').classList.remove('active');
            this.classList.remove('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 992) {
                const sidebar = document.querySelector('aside');
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarOverlay = document.getElementById('sidebarOverlay');

                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            }
        });

        // Function to show logout confirmation modal
        function showLogoutModal() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }
    </script>
</body>

</html>