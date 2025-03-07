@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <a href="{{ route('guru.exams.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>

        <h1>Nilai Siswa untuk Ujian: {{ $exam->title }}</h1>
        <a href="{{ route('guru.exams.export', $exam->id) }}" class="btn btn-success mb-3">
            <i class="bi bi-file-earmark-excel"></i> Export ke Excel
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nilai</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Durasi Pengerjaan</th> <!-- Kolom baru untuk durasi dalam format jam, menit, detik -->
                </tr>
            </thead>
            <tbody>
                @foreach ($examAttempts as $attempt)
                    <tr>
                        <td>{{ $attempt->user->name }}</td>
                        <!-- Mengambil kelas pertama dari koleksi kelas -->
                        <td>{{ $attempt->user->kelas->first()->name ?? 'Tidak Ditemukan' }}</td>
                        <td>{{ $attempt->score }}</td>
                        <td>{{ $attempt->started_at }}</td>
                        <td>{{ $attempt->submitted_at }}</td>
                        <!-- Durasi Waktu dalam Jam:Menit:Detik -->
                        <td>
                            @if ($attempt->started_at && $attempt->submitted_at)
                                @php
                                    // Menghitung perbedaan waktu dalam detik
                                    $diffInSeconds = $attempt->started_at->diffInSeconds($attempt->submitted_at);

                                    // Menghitung jam, menit, dan detik
                                    $hours = floor($diffInSeconds / 3600);
                                    $minutes = floor(($diffInSeconds % 3600) / 60);
                                    $seconds = $diffInSeconds % 60;
                                @endphp

                                <!-- Menampilkan durasi dalam format jam:menit:detik -->
                                {{ sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds) }}
                            @else
                                Tidak tersedia
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
