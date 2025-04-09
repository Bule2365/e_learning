@extends('guru.layouts.app')

@section('content')
    <!-- Tambahkan Bootstrap 5.4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container my-5">
        <!-- Tombol Kembali -->
        <a href="{{ route('guru.exams.index') }}" class="btn btn-outline-primary mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>

        <!-- Judul Halaman -->
        <h1 class="fw-bold text-primary mb-4 text-center">Nilai Siswa untuk Ujian: {{ $exam->title }}</h1>

        <!-- Tombol Export -->
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('guru.exams.export', $exam->id) }}" class="btn btn-success d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i> Export ke Excel
            </a>
        </div>

        <!-- Tabel Nilai Siswa -->
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Durasi Pengerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examAttempts as $attempt)
                                <tr>
                                    <td class="fw-semibold">{{ $attempt->user->name }}</td>
                                    <td>{{ $attempt->user->kelas->first()->name ?? 'Tidak Ditemukan' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attempt->score >= 70 ? 'success' : 'danger' }} fs-6 p-2">
                                            {{ $attempt->score }}
                                        </span>
                                    </td>
                                    <td>{{ $attempt->started_at }}</td>
                                    <td>{{ $attempt->submitted_at }}</td>
                                    <td>
                                        @if ($attempt->started_at && $attempt->submitted_at)
                                            @php
                                                $diffInSeconds = $attempt->started_at->diffInSeconds(
                                                    $attempt->submitted_at,
                                                );
                                                $hours = floor($diffInSeconds / 3600);
                                                $minutes = floor(($diffInSeconds % 3600) / 60);
                                                $seconds = $diffInSeconds % 60;
                                            @endphp
                                            <span
                                                class="badge bg-info text-dark">{{ sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds) }}</span>
                                        @else
                                            <span class="text-muted">Tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.exams.scores.edit', ['exam' => $exam->id, 'attempt' => $attempt->id]) }}"
                                            class="btn btn-warning btn-sm d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-pencil-square"></i> Edit Nilai
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
