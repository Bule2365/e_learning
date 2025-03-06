@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .progress-hover {
            transition: width 0.8s ease-in-out;
        }

        .tooltip-text {
            z-index: 10;
            font-size: 12px;
            white-space: nowrap;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Efek Hover pada Card */
        .card-hover {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Gradient Border untuk Card */
        .border-left-primary {
            border-left: 5px solid #4e73df !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-success {
            border-left: 5px solid #1cc88a !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-info {
            border-left: 5px solid #36b9cc !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-warning {
            border-left: 5px solid #f6c23e !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        /* Ikon dengan Efek Hover */
        .bi:hover {
            animation: pulse 1s infinite;
        }

        /* Animasi Pulse untuk Ikon */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Jumlah Siswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahSiswa }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Guru -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Guru</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahGuru }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-person-badge fs-1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Kelas -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kelas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKelas }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-door-open fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Mata Pelajaran -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Mata Pelajaran
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahMapel }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-book fs-1 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Perbandingan Jumlah Guru dan Siswa</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartComparison"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("chartComparison").getContext("2d");
            var labels = @json($years);
            var dataSiswa = @json($dataSiswa);
            var dataGuru = @json($dataGuru);

            new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                            label: "Jumlah Siswa",
                            data: dataSiswa,
                            borderColor: "#4e73df",
                            backgroundColor: "rgba(78, 115, 223, 0.1)",
                            fill: true,
                        },
                        {
                            label: "Jumlah Guru",
                            data: dataGuru,
                            borderColor: "#1cc88a",
                            backgroundColor: "rgba(28, 200, 138, 0.1)",
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
