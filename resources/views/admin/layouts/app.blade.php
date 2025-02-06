<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styleAdmin.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Toggle Button for Mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="wrapper">
        <aside id="sidebar">
            <div>
                <div class="sidebar-logo">
                    <a href="{{ route('dashboard') }}">Dashboard Admin</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <!-- Data Pengguna -->
                <li class="sidebar-item">
                    <a href="{{ route('users.index') }}" class="sidebar-link">
                        <i class="bi bi-people"></i> Data Pengguna
                    </a>
                </li>

                <!-- Data Kelas -->
                <li class="sidebar-item">
                    <a href="{{ route('admin.classes.index') }}" class="sidebar-link">
                        <i class="bi bi-book"></i> Data Kelas
                    </a>
                </li>

                <!-- Data Mata Pelajaran -->
                <li class="sidebar-item">
                    <a href="{{ route('subjects.index') }}" class="sidebar-link">
                        <i class="bi bi-journal-bookmark"></i> Data Mata Pelajaran
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </aside>
        <div class="main">
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            @yield('content')
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
</body>

</html>
