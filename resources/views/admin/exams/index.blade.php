@extends('admin.layouts.app')

@section('title', 'Daftar Ujian Siswa')

@push('styles')
    <style>
        .hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Kelas</h2>
        </div>

        <div class="row">
            @foreach ($classes as $class)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('admin.exams.byClass', $class->id) }}" class="text-decoration-none">
                        <div class="card shadow-lg border-0 rounded-3 hover-effect">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ $class->name }}</h5>
                                    <p class="text-muted small">Klik untuk melihat ujian</p>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-right-circle text-primary fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
