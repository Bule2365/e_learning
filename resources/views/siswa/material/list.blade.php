@extends('siswa.layouts.app')

@push('styles')
    <style>
        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
            overflow: hidden;
            border-radius: 10px;
            background: black;
        }

        .video-container video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Menyesuaikan ukuran video */
            transform: translate(-50%, -50%);
        }

        .video-thumbnail {
            position: relative;
            display: inline-block;
        }

        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 10px 15px;
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Tombol Kembali ke Beranda -->
        <a href="{{ route('siswa.material.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-house-door"></i> Kembali ke Beranda
        </a>

        <h2 class="mb-4">Materi</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($materials as $material)
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <a href="{{ route('siswa.material.detail', $material->id) }}" class="text-decoration-none">
                            @php
                                $thumbnail = asset('default-thumbnail.jpg'); // Default thumbnail
                                $isVideo = false;
                                $isPDF = false;
                                $videoPath = null;

                                if (!empty($material->file_paths)) {
                                    foreach ($material->file_paths as $filePath) {
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                            $thumbnail = Storage::url($filePath);
                                            break;
                                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                            $videoPath = Storage::url($filePath);
                                            $isVideo = true;
                                            break;
                                        } elseif ($extension === 'pdf') {
                                            $thumbnail = asset('default-pdf-thumbnail.jpg'); // Gunakan gambar default untuk PDF
                                            $isPDF = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if ($isVideo && $videoPath)
                                <!-- Video dengan ukuran proporsional -->
                                <div class="video-container">
                                    <video controls>
                                        <source src="{{ $videoPath }}" type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif ($isPDF)
                                <!-- PDF -->
                                <img src="{{ $thumbnail }}" class="card-img-top img-fluid rounded" alt="PDF Preview">
                            @else
                                <!-- Gambar -->
                                <img src="{{ $thumbnail }}" class="card-img-top img-fluid rounded"
                                    alt="{{ $material->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('default-thumbnail.jpg') }}';">
                            @endif
                        </a>

                        <div class="card-body">
                            <h5 class="card-title text-truncate">
                                <a href="{{ route('siswa.material.detail', $material->id) }}"
                                    class="text-dark text-decoration-none">
                                    {{ $material->title }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
