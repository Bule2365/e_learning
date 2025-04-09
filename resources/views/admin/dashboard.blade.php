@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #2ec4b6;
            --info-color: #3a86ff;
            --warning-color: #ff9f1c;
            --danger-color: #e71d36;
            --dark-color: #011627;
            --light-color: #fdfffc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .dashboard-card {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dashboard-card .card-body {
            padding: 1.5rem;
        }

        .icon-container {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-stat {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0;
            letter-spacing: -0.5px;
        }

        /* Efek Hover pada Dropdown Item */
        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
        }

        /* Transisi Halus */
        .transition {
            transition: all 0.3s ease-in-out;
        }

        .stat-label {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        .content-card {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            height: 100%;
        }

        .content-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .progress-card {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .progress-bar-modern {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 1rem 1rem;
            animation: progress-bar-stripes 1s linear infinite;
        }

        @keyframes progress-bar-stripes {
            from {
                background-position: 1rem 0;
            }

            to {
                background-position: 0 0;
            }
        }

        .list-item-modern {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .list-item-modern:hover {
            background-color: rgba(0, 0, 0, 0.02);
            transform: translateX(5px);
            border-left: 4px solid var(--primary-color);
        }

        .avatar {
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb-modern {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-size: 0.9rem;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .badge-modern {
            padding: 0.5em 0.75em;
            font-weight: 500;
            border-radius: 30px;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .hover-bg-light:hover {
            transform: translateX(5px);
        }

        .icon-container {
            transition: all 0.3s ease;
        }

        .list-group-item:hover .icon-container {
            transform: scale(1.1);
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">Dashboard</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-muted me-2">{{ date('d M Y') }}</span>
                <button id="refreshBtn" class="btn btn-sm btn-outline-primary rounded-pill ms-2">
                    <i class="bi bi-arrow-repeat me-1"></i> Refresh Data
                </button>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card bg-white text-primary mb-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="stat-label text-primary">Total Siswa</p>
                                <h2 class="dashboard-stat">{{ $jumlahSiswa }}</h2>
                                <div class="mt-3 d-flex align-items-center">
                                    <i
                                        class="bi {{ $persenSiswa >= 0 ? 'bi-arrow-up-short text-success' : 'bi-arrow-down-short text-danger' }}"></i>
                                    <span class="small fw-medium {{ $persenSiswa >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ abs($persenSiswa) }}%
                                    </span>
                                    <span class="small text-muted ms-2">dari tahun lalu</span>
                                </div>
                            </div>
                            <div class="icon-container bg-primary bg-opacity-10">
                                <i class="bi bi-people fs-2 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card bg-white text-success mb-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="stat-label text-success">Total Guru</p>
                                <h2 class="dashboard-stat">{{ $jumlahGuru }}</h2>
                                <div class="mt-3 d-flex align-items-center">
                                    <i
                                        class="bi {{ $persenGuru >= 0 ? 'bi-arrow-up-short text-success' : 'bi-arrow-down-short text-danger' }}"></i>
                                    <span class="small fw-medium {{ $persenGuru >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ abs($persenGuru) }}%
                                    </span>
                                    <span class="small text-muted ms-2">dari tahun lalu</span>
                                </div>
                            </div>
                            <div class="icon-container bg-success bg-opacity-10">
                                <i class="bi bi-person-badge fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card bg-white text-info mb-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="stat-label text-info">Total Kelas</p>
                                <h2 class="dashboard-stat">{{ $jumlahKelas }}</h2>
                                <div class="mt-3 d-flex align-items-center">
                                    <i
                                        class="bi {{ $persenKelas >= 0 ? 'bi-arrow-up-short text-success' : 'bi-arrow-down-short text-danger' }}"></i>
                                    <span class="small fw-medium {{ $persenKelas >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ abs($persenKelas) }}%
                                    </span>
                                    <span class="small text-muted ms-2">dari tahun lalu</span>
                                </div>
                            </div>
                            <div class="icon-container bg-info bg-opacity-10">
                                <i class="bi bi-door-open fs-2 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card bg-white text-warning mb-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="stat-label text-warning">Mata Pelajaran</p>
                                <h2 class="dashboard-stat">{{ $jumlahMapel }}</h2>
                                <div class="mt-3 d-flex align-items-center">
                                    <i
                                        class="bi {{ $persenMapel >= 0 ? 'bi-arrow-up-short text-success' : 'bi-arrow-down-short text-danger' }}"></i>
                                    <span class="small fw-medium {{ $persenMapel >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ abs($persenMapel) }}%
                                    </span>
                                    <span class="small text-muted ms-2">dari tahun lalu</span>
                                </div>
                            </div>
                            <div class="icon-container bg-warning bg-opacity-10">
                                <i class="bi bi-book fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Statistik Utama -->
        <div class="row g-4 mt-2">
            <!-- Grafik Jumlah Siswa -->
            <div class="col-lg-6">
                <div class="card content-card mb-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2 text-primary"></i>
                            Statistik Jumlah Siswa
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartSiswa"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Jumlah Guru -->
            <div class="col-lg-6">
                <div class="card content-card mb-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2 text-danger"></i>
                            Statistik Jumlah Guru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartGuru"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Sections with enhanced styling -->
        <div class="row g-4 mt-5">
            <!-- Top 5 Productive Teachers Card -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-trophy-fill me-2 text-warning"></i>
                            Daftar nama-nama guru.
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach ($topGuruMateri as $index => $guru)
                                <div
                                    class="list-group-item border-start-0 border-end-0 d-flex justify-content-between align-items-center py-3 hover-bg-light transition-all">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="{{ $guru->profile_photo_url }}" alt="Avatar"
                                                class="rounded-circle avatar shadow-sm border-2 border-white" width="50"
                                                height="50">
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                                                style="font-size: 0.65rem; margin-left: -15px;">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark">{{ $guru->name }}</h6>
                                            <p class="text-muted small mb-0"><i
                                                    class="bi bi-envelope-fill me-1 opacity-50"></i>{{ $guru->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-normal">
                                            <i class="bi bi-file-earmark-text me-1"></i> {{ $guru->materials_count }}
                                            Materi
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-center py-3">
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                            <i class="bi bi-people me-1"></i> Lihat Semua Guru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Most Popular Materials Card -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-star-fill me-2 text-warning"></i>
                            Daftar Materi terbaru yang dibuat para guru.
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach ($topMateri->sortByDesc('created_at') as $index => $materi)
                                <div
                                    class="list-group-item border-start-0 border-end-0 d-flex justify-content-between align-items-center py-3 hover-bg-light transition-all">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-container d-flex align-items-center justify-content-center bg-success bg-opacity-10 me-3 rounded-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="bi bi-file-earmark-text text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark">{{ $materi->title }}</h6>
                                            <div class="d-flex align-items-center mt-1">
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary me-2 rounded-pill">
                                                    <i
                                                        class="bi bi-bookmark-fill me-1"></i>{{ $materi->classModel->name }}
                                                </span>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ ($materi->created_at ?? now())->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-normal">
                                            <i class="bi bi-door-open me-1"></i> {{ $materi->class_count }} Kelas
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-center py-3">
<<<<<<< HEAD
                        <a href="{{ route('subjects.index') }}" class="btn btn-success btn-sm rounded-pill px-4">
=======
                        {{-- <a href="{{ route('admin.classes.index') }}" class="btn btn-success btn-sm rounded-pill px-4">
>>>>>>> 2b9fc02c030efeccd88115baa6a489ef6d7870ae
                            <i class="bi bi-journal-text me-1"></i> Lihat Semua Materi
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var labels = {!! json_encode(array_keys($dataSiswa)) !!}; // Tahun Ajaran
            var dataSiswa = {!! json_encode(array_values($dataSiswa)) !!}; // Data siswa
            var dataGuru = {!! json_encode(array_values($dataGuru)) !!}; // Data guru

            // Opsi konfigurasi umum
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Jumlah",
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Tahun Ajaran",
                        },
                    },
                },
                plugins: {
                    legend: {
                        position: "top",
                    },
                },
            };

            // Grafik Jumlah Siswa
            var ctxSiswa = document.getElementById("chartSiswa").getContext("2d");
            new Chart(ctxSiswa, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Jumlah Siswa",
                        data: dataSiswa,
                        borderColor: "rgba(54, 162, 235, 1)",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderWidth: 2,
                        tension: 0.4, // Buat garis smooth
                        fill: true, // Warna transparan di bawah garis
                    }, ],
                },
                options: chartOptions,
            });

            // Grafik Jumlah Guru
            var ctxGuru = document.getElementById("chartGuru").getContext("2d");
            new Chart(ctxGuru, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Jumlah Guru",
                        data: dataGuru,
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderWidth: 2,
                        tension: 0.4, // Buat garis smooth
                        fill: true, // Warna transparan di bawah garis
                    }, ],
                },
                options: chartOptions,
            });
        });

        document.getElementById("refreshBtn").addEventListener("click", function() {
            let btn = this;

            // Tambahkan animasi loading
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
            btn.disabled = true;

            // Reload halaman setelah 1 detik
            setTimeout(() => {
                location.reload();
            }, 1000);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to list items
            const listItems = document.querySelectorAll('.hover-bg-light');
            listItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.classList.add('bg-light', 'bg-opacity-50');
                });
                item.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-light', 'bg-opacity-50');
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
