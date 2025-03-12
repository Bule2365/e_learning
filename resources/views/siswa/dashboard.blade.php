@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Dashboard Siswa</h1>

        <!-- Section Mata Pelajaran dan Tugas -->
        <div class="row mb-5">
            @foreach ($subjects as $subject)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-light rounded">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $subject->name }}</h5>
                            <p class="card-text">
                                <strong>Guru:</strong> {{ $subject->guru->name }}<br>
                                <strong>Jumlah Tugas:</strong> {{ $subject->tugas_count }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Section Grafik Nilai Tugas dan Ujian -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <h3 class="text-center">Grafik Nilai Tugas</h3>
                <canvas id="taskChart" width="400" height="200"></canvas>
            </div>

            <div class="col-md-6 mb-4">
                <h3 class="text-center">Grafik Nilai Ujian</h3>
                <canvas id="examChart" width="400" height="200"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Grafik Nilai Tugas
            var ctx1 = document.getElementById('taskChart').getContext('2d');
            var taskChart = new Chart(ctx1, {
                type: 'line', // Tipe grafik: line
                data: {
                    labels: [
                        '0', // Menambahkan 0 sebagai titik awal
                        @foreach ($taskValues as $index => $taskValue)
                            '{{ $index + 1 }}',
                        @endforeach
                    ], // Label untuk tugas
                    datasets: [{
                        label: 'Nilai Tugas',
                        data: [0, // Menambahkan nilai 0 sebagai titik awal
                            @foreach ($taskValues as $taskValue)
                                {{ $taskValue }},
                            @endforeach
                        ],
                        borderColor: 'rgba(255, 159, 64, 1)', // Warna garis tugas (oranye)
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'circle', // Menampilkan titik pada grafik
                        pointRadius: 5, // Ukuran titik
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari 0
                        }
                    }
                }
            });

            // Grafik Nilai Ujian
            var ctx2 = document.getElementById('examChart').getContext('2d');
            var examChart = new Chart(ctx2, {
                type: 'line', // Tipe grafik: line
                data: {
                    labels: [
                        '0', // Menambahkan 0 sebagai titik awal
                        @foreach ($examValues as $index => $examValue)
                            '{{ $index + 1 }}',
                        @endforeach
                    ], // Label untuk ujian
                    datasets: [{
                        label: 'Nilai Ujian',
                        data: [0, // Menambahkan nilai 0 sebagai titik awal
                            @foreach ($examValues as $examValue)
                                {{ $examValue }},
                            @endforeach
                        ],
                        borderColor: 'rgba(54, 162, 235, 1)', // Warna garis ujian (biru)
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'circle', // Menampilkan titik pada grafik
                        pointRadius: 5, // Ukuran titik
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari 0
                        }
                    }
                }
            });
        </script>
    </div>
@endsection
