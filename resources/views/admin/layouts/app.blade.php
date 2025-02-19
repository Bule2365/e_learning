<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('styleAdmin.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Toggle Button for Mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <ul class="sidebar-nav">
                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-trello"></i> Dashbaord
                    </a>
                </li>
                <!-- Data Pengguna -->
                <li class="sidebar-item">
                    <a href="{{ route('users.index') }}" class="sidebar-link">
                        <i class="bi bi-people-fill"></i> Data Pengguna
                    </a>
                </li>
                <!-- Data Pengguna -->
                <li class="sidebar-item">
                    <a href="{{ route('exams.index') }}" class="sidebar-link">
                        <i class="bi bi-people"></i> Data Siswa
                    </a>
                </li>
                <!-- Data Kelas -->
                <li class="sidebar-item">
                    <a href="{{ route('admin.classes.index') }}" class="sidebar-link">
                        <i class="bi bi-book-half"></i> Data Kelas
                    </a>
                </li>
                <!-- Data Mata Pelajaran -->
                <li class="sidebar-item">
                    <a href="{{ route('subjects.index') }}" class="sidebar-link">
                        <i class="bi bi-journal-text"></i> Data Mata Pelajaran
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light w-100">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main">
            <div class="container-fluid py-4">
                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle me-2"></i> Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i> Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Main Content Section -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.querySelector('.main').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>

</html>
