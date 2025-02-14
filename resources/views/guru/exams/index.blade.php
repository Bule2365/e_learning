@extends('guru.layouts.app')

@section('content')
@push('styles')
<style>
    /* Styling for the title */
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Styling for the subtitle */
    .card-subtitle {
        font-size: 1rem;
        color: #6c757d;
        /* Muted color for better readability */
    }

    /* Description should have proper space and respect line breaks */
    .exam-description {
        white-space: pre-line;
        margin-bottom: 1.5rem;
    }

    /* Badge for status with different colors */
    .badge {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    /* Spacing between action buttons */
    .action-buttons .btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .action-buttons .btn:hover {
        background-color: #0056b3;
    }
</style>
@endpush

<div class="container my-5">
    <h1 class="display-4 text-center mb-4">Daftar Ujian</h1>

    <!-- Success message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($exams->isEmpty())
    <div class="col-12">
        <div class="alert alert-info text-center">
            Belum ada ujian untuk mata pelajaran yang Anda ajar.
        </div>
    </div>
    @else
    <div class="row">
        @foreach($exams as $exam)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <!-- Title of the exam -->
                    <h5 class="card-title mb-2">{{ $exam->title }}</h5>

                    <!-- Class Name -->
                    <h6 class="card-subtitle mb-2 text-muted">{{ $exam->kelas->name }}</h6>
                    
                    <!-- Subject Name -->
                    <h6 class="card-subtitle mb-3 text-muted">{{ $exam->mataPelajaran->name }}</h6>

                    <!-- Description with line breaks preserved -->
                    <p class="exam-description">{{ $exam->description }}</p>

                    <!-- Status Badge -->
                    <span class="badge bg-{{ $exam->status == 'active' ? 'success' : 'warning' }}">
                        {{ ucfirst($exam->status) }}
                    </span>

                    <!-- Action buttons: View and Add Questions -->
                    <div class="action-buttons mt-3">
                        <a href="{{ route('guru.exams.show', $exam->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-view-list"></i> Lihat Soal Ujian
                        </a>
                        <a href="{{ route('guru.exams.add_questions', $exam->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Soal Ujian
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection