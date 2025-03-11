@extends('siswa.layouts.app')

@push('styles')
    <style>
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
                                $thumbnail = null;
                                $isVideo = false;

                                if (!empty($material->file_paths)) {
                                    foreach ($material->file_paths as $filePath) {
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                            $thumbnail = Storage::url($filePath);
                                            break;
                                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                            $thumbnail = asset('default-video-thumbnail.jpg'); // Gunakan gambar default untuk video
                                            $isVideo = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if ($thumbnail)
                                @if ($isVideo)
                                    <!-- Video -->
                                    <div class="video-thumbnail">
                                        <img src="{{ $thumbnail }}" class="card-img-top img-fluid rounded"
                                            alt="Video Thumbnail">
                                        <div class="play-icon">▶</div>
                                    </div>
                                @else
                                    <!-- Gambar -->
                                    <img src="{{ $thumbnail }}" class="card-img-top img-fluid rounded"
                                        alt="{{ $material->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('default-thumbnail.jpg') }}';">
                                @endif
                            @else
                                <!-- Jika tidak ada gambar atau video -->
                                <img src="{{ asset('default-thumbnail.jpg') }}" class="card-img-top img-fluid rounded"
                                    alt="Default Thumbnail">
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
