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
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
        }

        body {
            min-height: 100vh;
            background-color: #f8f9fc;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-logo {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo a {
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            font-weight: bold;
        }

        .sidebar-nav {
            padding: 1rem 0;
            list-style: none;
        }

        .sidebar-item {
            padding: 0.5rem 1rem;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-link i {
            margin-right: 0.75rem;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer button {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 0.35rem;
            transition: all 0.2s ease;
        }

        .sidebar-footer button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content Styles */
        .main {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s ease;
        }

        /* Alert Styles */
        .alert {
            margin-bottom: 1rem;
            border-radius: 0.35rem;
        }

        .alert-success {
            background-color: var(--success-color);
            color: white;
            border: none;
        }

        .alert-danger {
            background-color: #e74a3b;
            color: white;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            .main {
                margin-left: 0;
            }

            .main.active {
                margin-left: var(--sidebar-width);
            }
        }

        /* Toggle Button for Mobile */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 0.35rem;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
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
