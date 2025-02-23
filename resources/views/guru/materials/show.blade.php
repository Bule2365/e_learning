@extends('guru.layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">{{ $material->title }}</h1>

        <p><strong>Deskripsi:</strong> {{ $material->description }}</p>
        <p><strong>Mata Pelajaran:</strong> {{ $material->subject->name }}</p>
        <p><strong>Kelas:</strong> {{ optional($material->ClassModel)->name }}</p>

        <h4 class="mt-5 mb-3">File Materi</h4>

        <div class="row g-4">
            @foreach (json_decode($material->file_path, true) as $file)
                @php
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $fileUrl = asset('storage/' . $file);
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-light rounded-3">
                        <div class="card-body text-center">
                            @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                <!-- Gambar -->
                                <img src="{{ $fileUrl }}" alt="Materi Gambar" class="img-fluid rounded mb-3"
                                    style="max-height: 200px; object-fit: cover;">
                                <p class="mt-2">{{ ucfirst($fileExtension) }} Image</p>
                            @elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'mkv']))
                                <!-- Video -->
                                <video class="img-fluid rounded mb-3" controls style="max-height: 200px;">
                                    <source src="{{ $fileUrl }}" type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="mt-2">{{ ucfirst($fileExtension) }} Video</p>
                            @else
                                <!-- Jika bukan gambar atau video, tampilkan link -->
                                <a href="{{ $fileUrl }}" class="btn btn-link" target="_blank">Unduh File</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('guru.materials.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Materi</a>
    </div>
@endsection
