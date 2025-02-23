@extends('siswa.layouts.app')
@section('content')
    <h2>Materi</h2>
    <div class="row">
        @foreach ($materials as $material)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('siswa.material.detail', $material->id) }}"
                                class="text-decoration-none text-dark">
                                {{ $material->title }}
                            </a>
                        </h5>

                        <!-- Tampilkan file sesuai tipe -->
                        @if (isset($material->file_paths))
                            @foreach ($material->file_paths as $filePath)
                                @php
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($filePath) }}" alt="{{ $material->title }}"
                                        class="img-fluid rounded">
                                @elseif (in_array($extension, ['mp4', 'avi', 'mov']))
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" controls>
                                            <source src="{{ Storage::url($filePath) }}" type="video/{{ $extension }}">
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
@endsection
