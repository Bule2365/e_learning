@extends('admin.layouts.app')
@section('title', 'Daftar Ujian Siswa')
@push('styles')
    <style>
        .hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-custom {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: none;
            border-radius: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .bi-arrow-right-circle {
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .hover-effect:hover .bi-arrow-right-circle {
            transform: translateX(5px);
            color: #0d6efd;
        }

        .no-data {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
@endpush
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Ujian Siswa</h2>
        </div>

        @if (isset($message))
            <div class="no-data">
                {{ $message }}
            </div>
        @else
            <div class="row">
                @foreach ($classes as $class)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('admin.exams.byClass', $class->id) }}" class="text-decoration-none">
                            <div class="card card-custom shadow-lg hover-effect">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">{{ $class->name }}</h5>
                                        <p class="text-muted small mb-0">Klik untuk melihat ujian</p>
                                        <small class="text-muted">
                                            <i class="bi bi-file-earmark-text"></i>
                                            {{ $class->ujian_count }} Ujian
                                        </small>
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
        @endif
    </div>
@endsection
