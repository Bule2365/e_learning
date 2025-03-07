@extends('guru.layouts.app')

@push('styles')
    <style>
        /* Hover effect on cards */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Card body text styling */
        .card-body p {
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h1 class="mb-5 text-center text-primary fw-bold">Daftar Kelas Siswa</h1>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($classes as $class)
                <div class="col">
                    <div class="card shadow-lg rounded-3 border-light transition-transform"
                        style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h5 class="card-title text-center mb-0">{{ $class->name }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Deskripsi:</strong> {{ $class->deskripsi }}</p>

                            <p class="card-text"><strong>Daftar Siswa yang Bergabung:</strong></p>
                            @if ($class->siswa->isEmpty())
                                <p class="text-muted">Belum ada siswa yang bergabung.</p>
                            @else
                                <ul class="list-unstyled">
                                    @foreach ($class->siswa->take(10) as $murid)
                                        <li>{{ $murid->name }}</li>
                                    @endforeach
                                </ul>

                                <!-- Jika jumlah siswa lebih dari 10, tampilkan tombol -->
                                @if ($class->siswa->count() > 10)
                                    <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal"
                                        data-bs-target="#modalSiswa{{ $class->id }}">
                                        Lihat Semua
                                    </button>
                                @endif
                            @endif

                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('guru.exams.create', ['class_id' => $class->id]) }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-file-plus-fill"></i> Buat Ujian
                                </a>
                                <a href="{{ route('tasks.create', ['class_id' => $class->id]) }}" class="btn btn-warning">
                                    <i class="bi bi-clipboard-plus-fill"></i> Buat Tugas
                                </a>
                                <a href="{{ route('guru.materials.create', ['class_id' => $class->id]) }}"
                                    class="btn btn-success">
                                    <i class="bi bi-file-earmark-plus-fill"></i> Buat Materi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk melihat daftar siswa lengkap -->
                <div class="modal fade" id="modalSiswa{{ $class->id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $class->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalLabel{{ $class->id }}">Daftar Siswa di
                                    {{ $class->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    @foreach ($class->siswa as $murid)
                                        <li class="list-group-item">{{ $murid->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
