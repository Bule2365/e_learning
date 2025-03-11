@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Daftar Ujian</h2>

        <div class="row g-4">
            @foreach ($exams as $exam)
                @if ($exam->status !== 'draft')
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $exam->title }}</h5>
                                <p class="text-muted flex-grow-1">{{ $exam->description }}</p>

                                @php
                                    $attempt = $exam
                                        ->upayaUjian()
                                        ->where('user_id', auth()->id())
                                        ->latest()
                                        ->first();
                                @endphp

                                @if ($attempt && $attempt->submitted_at)
                                    <p><strong>Nilai Anda: {{ $attempt->score }}</strong></p>
                                    @if ($attempt->score < 75)
                                        <a href="{{ route('siswa.exams.remedial', $exam->id) }}"
                                            class="btn btn-warning w-100">
                                            Remedial Ujian
                                        </a>
                                    @else
                                        <p class="text-success">Lulus</p>
                                    @endif
                                @else
                                    <a href="{{ route('siswa.exams.preparation', $exam->id) }}"
                                        class="btn btn-primary w-100">
                                        Persiapan Ujian
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
