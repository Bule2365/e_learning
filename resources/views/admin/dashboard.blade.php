@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        /* Hover Effect pada Kartu */
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-10px);
        }

        /* Menambahkan efek pada card-header */
        .card-header {
            font-weight: 600;
            border-radius: 15px 15px 0 0;
            padding: 1rem;
        }

        /* Gaya tambahan pada card title */
        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        /* Gradien pada background kartu */
        .bg-primary-gradient {
            background: linear-gradient(to bottom right, #4e73df, #224abe);
        }

        .bg-success-gradient {
            background: linear-gradient(to bottom right, #1cc88a, #17a673);
        }

        .bg-warning-gradient {
            background: linear-gradient(to bottom right, #f6c23e, #d9a42b);
        }

        .bg-info-gradient {
            background: linear-gradient(to bottom right, #36b9cc, #2c9faf);
        }

        /* Animasi ikon */
        .icon-hover {
            transition: transform 0.3s ease;
        }

        .icon-hover:hover {
            transform: scale(1.2);
        }

        /* Footer card */
        .card-footer {
            border-radius: 0 0 15px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
        }

        /* Responsive text */
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.5rem;
            }

            .card-header span {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <h1 class="display-4 fw-bold">Dashboard Admin</h1>
        <p class="lead text-muted">Ringkasan data sistem</p>

        <!-- Tampilkan data jumlah siswa, guru, kelas, dan mapel -->
        <div class="row gy-4">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="card bg-primary-gradient text-white shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jumlah Siswa</span>
                        <i class="fas fa-user-graduate fa-2x icon-hover" aria-label="Ikon jumlah siswa"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $jumlahSiswa }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="card bg-success-gradient text-white shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jumlah Guru</span>
                        <i class="fas fa-chalkboard-teacher fa-2x icon-hover" aria-label="Ikon jumlah guru"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $jumlahGuru }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="card bg-warning-gradient text-white shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jumlah Kelas</span>
                        <i class="fas fa-school fa-2x icon-hover" aria-label="Ikon jumlah kelas"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $jumlahKelas }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="card bg-info-gradient text-white shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jumlah Mata Pelajaran</span>
                        <i class="fas fa-book fa-2x icon-hover" aria-label="Ikon jumlah mata pelajaran"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $jumlahMapel }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('subjects.index') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
