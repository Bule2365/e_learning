@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Detail Tugas: {{ $task->title }}</h1>

        <!-- Menampilkan Deskripsi Tugas -->
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Deskripsi:</strong> {{ $task->description }}</p>
                <p><strong>Batas Waktu:</strong> {{ $task->due_date->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Menampilkan File Tugas dari Guru (Jika Ada) -->
        @if ($task->file_path)
            <div class="card mb-4">
                <div class="card-body">
                    <h5><strong>File Tugas dari Guru:</strong></h5>
                    <p>Anda dapat melihat file tugas yang diberikan oleh guru di bawah ini:</p>

                    <!-- Mengambil dan mendecode JSON dari file_path -->
                    @php
                        $filePaths = json_decode($task->file_path);
                    @endphp

                    <!-- Looping melalui semua file yang di-upload oleh guru -->
                    @foreach ($filePaths as $filePath)
                        @php
                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                            <!-- Untuk Gambar -->
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $filePath) }}" alt="File Tugas" class="img-fluid">
                            </div>
                        @elseif (in_array($fileExtension, ['pdf']))
                            <!-- Untuk PDF -->
                            <div class="mb-3">
                                <iframe src="{{ asset('storage/' . $filePath) }}" width="100%" height="500px"></iframe>
                            </div>
                        @elseif (in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv']))
                            <!-- Untuk Video -->
                            <div class="mb-3">
                                <video width="100%" height="500px" controls>
                                    <source src="{{ asset('storage/' . $filePath) }}" type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <!-- Untuk Format File Lainnya, tampilkan link -->
                            <div class="mb-3">
                                <p>Format file tidak didukung untuk tampilan langsung. Anda dapat mengunduhnya untuk melihat
                                    lebih lanjut.</p>
                                <a href="{{ asset('storage/' . $filePath) }}" class="btn btn-secondary" download>Unduh File
                                    Tugas</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Status Pengumpulan Tugas -->
        <div class="alert alert-info mb-4">
            <h5><strong>Status Pengumpulan:</strong></h5>
            @if ($submission)
                @if ($submission->submission)
                    <p>Tugas Sudah Dikirim pada <strong>{{ $submission->created_at->format('d M Y H:i') }}</strong></p>
                @else
                    <p>Tugas Belum Dikirim. Silakan kirim tugas Anda sebelum batas waktu.</p>
                @endif
            @else
                <p>Belum Mengumpulkan Tugas. Silakan upload tugas Anda di bawah ini.</p>
            @endif
        </div>

        <!-- Form untuk mengumpulkan tugas -->
        @if (!$submission || !$submission->submission)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Tugas Anda</h5>
                    <form action="{{ route('student.tasks.submit', $task->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Tugas</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            <small class="form-text text-muted">Pastikan file Anda dalam format yang tepat dan tidak lebih
                                dari 10MB.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Tugas</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-success mt-4" role="alert">
                <strong>Tugas Sudah Dikirim!</strong> Anda tidak dapat mengupload ulang tugas setelah mengirim.
            </div>
        @endif
    </div>
@endsection
