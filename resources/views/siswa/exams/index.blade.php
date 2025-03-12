@extends('siswa.layouts.app')

@push('styles')
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">📚 Daftar Ujian</h2>

        <div class="row g-4">
            @foreach ($exams as $exam)
                @if ($exam->status !== 'draft')
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold">{{ $exam->title }}</h5>
                                <p class="text-muted flex-grow-1">{{ Str::limit($exam->description, 100) }}</p>

                                @php
                                    $attempts = $exam
                                        ->upayaUjian()
                                        ->where('user_id', auth()->id())
                                        ->get();
                                    $latestAttempt = $attempts->last();
                                    $totalAttempts = $attempts->count();
                                @endphp

                                @if ($latestAttempt && $latestAttempt->submitted_at)
                                    <p class="fw-bold">🎯 Nilai: <span class="text-success">{{ $latestAttempt->score }}</span>
                                    </p>

                                    @if ($latestAttempt->score < 75)
                                        @if ($totalAttempts < 3)
                                            <a href="{{ route('siswa.exams.remedial', $exam->id) }}"
                                                class="btn btn-warning w-100">
                                                🔄 Remedial ({{ $totalAttempts }}/3)
                                            </a>
                                        @else
                                            <p class="text-danger">❌ Maksimal remedial tercapai (3/3)</p>
                                        @endif
                                    @else
                                        <p class="text-success fw-bold">✅ Lulus</p>
                                    @endif
                                @else
                                    <a href="{{ route('siswa.exams.preparation', $exam->id) }}"
                                        class="btn btn-primary w-100">
                                        🚀 Persiapan Ujian
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
