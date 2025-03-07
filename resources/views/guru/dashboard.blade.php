@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')

@push('styles')
    <style>
        /* Styling untuk card hover effect */
        .hover-shadow-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease-in-out;
            border-radius: 16px;
        }

        .hover-shadow-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.1);
        }

        /* Gradients for card header */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        /* Custom font sizes and paddings */
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-body h3 {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-lg my-4 my-lg-5">
        <h1 class="text-center mb-4 text-primary fw-bold">Selamat Datang, {{ Auth::user()->name }}</h1>

        <!-- Row for stats -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Kartu Tugas -->
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 bg-light hover-shadow-card">
                    <div class="card-header bg-gradient-primary text-white rounded-4 p-3">
                        <h5 class="card-title mb-0">Jumlah Tugas</h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <h3 class="text-primary">{{ $jumlahTugas }}</h3>
                        <p class="text-muted">Tugas yang telah Anda buat</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Ujian -->
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 bg-light hover-shadow-card">
                    <div class="card-header bg-gradient-success text-white rounded-4 p-3">
                        <h5 class="card-title mb-0">Jumlah Ujian</h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <h3 class="text-success">{{ $jumlahUjian }}</h3>
                        <p class="text-muted">Ujian yang telah Anda buat</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Materi -->
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 bg-light hover-shadow-card">
                    <div class="card-header bg-gradient-info text-white rounded-4 p-3">
                        <h5 class="card-title mb-0">Jumlah Materi</h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <h3 class="text-info">{{ $jumlahMateri }}</h3>
                        <p class="text-muted">Materi yang telah Anda buat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
