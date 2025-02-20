@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Daftar Ujian</h2>
        <div class="row">
            @foreach ($exams as $exam)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $exam->title }}</h5>
                            <p class="text-muted">{{ $exam->description }}</p>
                            <a href="{{ route('siswa.exams.start', $exam->id) }}" class="btn btn-primary btn-block">
                                Mulai Ujian
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
