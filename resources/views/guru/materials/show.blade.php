@extends('guru.layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('guru.materials.index') }}" class="btn btn-primary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas
        </a>

        <h1 class="mb-3 text-center">{{ $material->title }}</h1>

        <p><strong>Mata Pelajaran:</strong> {{ $material->subject->name }}</p>
        <p><strong>Kelas:</strong> {{ optional($material->ClassModel)->name }}</p>

        <div class="mb-4">
            <p><strong>Deskripsi:</strong></p>
            <p class="text-muted" style="white-space: pre-wrap;">{{ $material->description }}</p>
        </div>


        <h4 class="mt-5 mb-3">File Materi</h4>

        <div class="row g-3">
            @foreach (json_decode($material->file_path, true) as $file)
                @php
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $fileUrl = asset('storage/' . $file);
                @endphp

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-light rounded-3">
                        <div class="card-body text-center">
                            @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                <img src="{{ $fileUrl }}" alt="Materi Gambar" class="img-fluid rounded mb-3"
                                    style="max-height: 200px; object-fit: cover; width: 100%;">
                                <p class="mt-2 text-muted">{{ strtoupper($fileExtension) }} Image</p>
                            @elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'mkv']))
                                <video class="img-fluid rounded mb-3" controls style="max-height: 250px;">
                                    <source src="{{ $fileUrl }}" type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="mt-2 text-muted">{{ strtoupper($fileExtension) }} Video</p>
                            @else
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                    <a href="{{ $fileUrl }}" class="btn btn-outline-primary mt-2" target="_blank">
                                        <i class="bi bi-download"></i> Unduh File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
