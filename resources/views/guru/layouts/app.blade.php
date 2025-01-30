<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Guru - SMK Informatika Utama')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2b6cb0;
            --secondary-color: #3182ce;
            --accent-color: #63b3ed;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --sidebar-width: 280px;
            --header-height: 60px;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #edf2f7;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        aside {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .school-brand {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .school-brand h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .school-brand p {
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        nav ul {
            list-style: none;
            padding: 1rem 0;
            margin: 0;
        }

        nav ul li {
            padding: 0.5rem 1.5rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        nav ul li a i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--light-color);
            transition: all 0.3s ease;
        }

        /* Header Styles */
        header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-nav {
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            min-width: 200px;
            display: none;
        }

        .profile-menu.show {
            display: block;
        }

        .profile-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .profile-menu a:hover {
            background: var(--light-color);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
        }

        .content-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #c6f6d5;
            color: #2f855a;
        }

        .alert-danger {
            background: #fed7d7;
            color: #c53030;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            aside {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            aside.active {
                margin-left: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }

        /* Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            display: none;
        }

        @media (max-width: 992px) {
            .sidebar-toggle {
                display: block;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 992px) {
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside>
            <div class="school-brand">
                <h3>SMK Informatika Utama</h3>
                <p>Kejuruan Teknologi Informasi</p>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.classes.index') }}">
                            <i class="bi bi-mortarboard"></i>
                            Kelas Saya
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
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="profileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Profile
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileMenuButton">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('aside').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        // Profile Dropdown
        document.getElementById('profileDropdown').addEventListener('click', function() {
            document.getElementById('profileMenu').classList.toggle('show');
        });

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileMenu');

            if (!profileDropdown.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.remove('show');
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
    </script>
</body>

</html>