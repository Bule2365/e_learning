@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Tugas: {{ $task->title }}</h1>
        <p><strong>Deskripsi:</strong> {{ $task->description }}</p>
        <p><strong>Batas Waktu:</strong> {{ $task->due_date->format('d M Y H:i') }}</p>

        <!-- Cek apakah tugas sudah dikumpulkan -->
        @if ($submission)
            <p><strong>Status Pengumpulan:</strong>
                @if ($submission->submission)
                    Tugas Sudah Dikirim
                @else
                    Tugas Belum Dikirim
                @endif
            </p>
        @else
            <p><strong>Status Pengumpulan:</strong> Belum Mengumpulkan Tugas</p>
        @endif

        <!-- Form untuk upload tugas -->
        @if (!$submission || !$submission->submission)
            <!-- Cek jika tugas belum dikirim -->
            <form action="{{ route('student.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload Tugas</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Tugas</button>
            </form>
        @else
            <p class="text-muted">Tugas sudah dikumpulkan. Tidak dapat mengupload ulang.</p>
        @endif
    </div>
@endsection
