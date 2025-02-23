@extends('siswa.layouts.app')
@section('content')
    <div class="container">
        <h2 class="my-4">{{ $material->title }}</h2>

        <!-- Tampilkan materi sesuai tipe -->
        @if (isset($material->file_paths))
            @foreach ($material->file_paths as $filePath)
                @php
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ Storage::url($filePath) }}" alt="{{ $material->title }}" class="img-fluid rounded">
                @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="embed-responsive-item" controls>
                            <source src="{{ Storage::url($filePath) }}" type="video/{{ $extension }}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @elseif ($extension == 'pdf')
                    <iframe src="{{ Storage::url($filePath) }}" width="100%" height="500px"></iframe>
                @endif
            @endforeach
        @endif

        <!-- Link download materi -->
        <br>
        @if (isset($material->file_paths[0]))
            <a href="{{ Storage::url($material->file_paths[0]) }}" download class="btn btn-primary mb-4">Download Materi</a>
        @endif

        <h3 class="mt-5">Rekomendasi Materi</h3>
        <div class="row">
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
                            @if (isset($recMaterial->file_paths))
                                @foreach ($recMaterial->file_paths as $filePath)
                                    @php
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($filePath) }}" alt="{{ $recMaterial->title }}"
                                            class="img-fluid rounded">
                                    @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video class="embed-responsive-item" controls>
                                                <source src="{{ Storage::url($filePath) }}"
                                                    type="video/{{ $extension }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @elseif ($extension == 'pdf')
                                        <iframe src="{{ Storage::url($filePath) }}" width="100%" height="200px"></iframe>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
