@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <!-- Tombol Kembali ke Daftar Materi -->
        <a href="{{ route('siswa.material.list', ['subject_id' => $material->subject_id]) }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Materi
        </a>

        <h2 class="my-4">{{ $material->title }}</h2>

        <!-- Tampilkan materi sesuai tipe -->
        @if (!empty($material->file_paths))
            @foreach ($material->file_paths as $filePath)
                @php
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ Storage::url($filePath) }}" alt="{{ $material->title }}" class="img-fluid rounded mb-3">
                @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                    <div class="ratio ratio-16x9 mb-3">
                        <video controls>
                            <source src="{{ Storage::url($filePath) }}" type="video/{{ $extension }}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @elseif ($extension == 'pdf')
                    <iframe src="{{ Storage::url($filePath) }}" width="100%" height="500px" class="mb-3"></iframe>
                @endif
            @endforeach
        @else
            <p class="text-muted">Tidak ada file materi yang tersedia.</p>
        @endif

        <!-- Tombol Download Semua File -->
        @if (!empty($material->file_paths))
            <div class="mt-3">
                <h5>Download Materi:</h5>
                @foreach ($material->file_paths as $filePath)
                    <a href="{{ Storage::url($filePath) }}" download class="btn btn-primary me-2 mb-2">
                        <i class="bi bi-download"></i> Unduh {{ basename($filePath) }}
                    </a>
                @endforeach
            </div>
        @endif

        <h3 class="mt-5">Rekomendasi Materi</h3>
        <div class="row">
            @if ($recommendedMaterials->isEmpty())
                <p class="text-muted">Belum ada rekomendasi materi.</p>
            @else
                @foreach ($recommendedMaterials as $recMaterial)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('siswa.material.detail', $recMaterial->id) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $recMaterial->title }}
                                    </a>
                                </h5>

                                <!-- Tampilkan file sesuai tipe -->
                                @if (!empty($recMaterial->file_paths))
                                    @foreach ($recMaterial->file_paths as $filePath)
                                        @php
                                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <img src="{{ Storage::url($filePath) }}" alt="{{ $recMaterial->title }}"
                                                class="img-fluid rounded mb-2">
                                        @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                                            <div class="ratio ratio-16x9 mb-2">
                                                <video controls>
                                                    <source src="{{ Storage::url($filePath) }}"
                                                        type="video/{{ $extension }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @elseif ($extension == 'pdf')
                                            <iframe src="{{ Storage::url($filePath) }}" width="100%" height="200px"
                                                class="mb-2"></iframe>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
