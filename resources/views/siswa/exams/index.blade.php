@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Daftar Ujian</h2>

        <div class="row">
            @foreach ($exams as $exam)
                @php
                    // Mendapatkan upaya ujian untuk pengguna yang sedang login
                    $attempt = $exam
                        ->upayaUjian()
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->first();
                @endphp

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $exam->title }}</h5>
                            <p class="text-muted">{{ $exam->description }}</p>

                            @if ($attempt && $attempt->submitted_at)
                                <p><strong>Nilai Anda: {{ $attempt->score }}</strong></p>
                                @if ($attempt->score < 75)
                                    <a href="{{ route('siswa.exams.remedial', $exam->id) }}"
                                        class="btn btn-warning btn-block">
                                        Remedial Ujian
                                    </a>
                                @else
                                    <p class="text-success">Lulus</p>
                                @endif
                            @else
                                <a href="{{ route('siswa.exams.start', $exam->id) }}" class="btn btn-primary btn-block">
                                    Mulai Ujian
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
