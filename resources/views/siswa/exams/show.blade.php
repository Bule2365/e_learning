@extends('siswa.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ $attempt->exam->title ?? 'Ujian Tidak Ditemukan' }}</h2>

        @if ($attempt->exam)
            <p class="lead">Deskripsi: {{ $attempt->exam->description }}</p>

            <form action="{{ route('siswa.exams.answer', $attempt->id) }}" method="POST">
                @csrf
                @foreach ($questions as $question)
                    <div class="mb-4">
                        <h4>{{ $question->question_text }}</h4>

                        @if ($question->type == 'multiple_choice')
                            <div class="form-check">
                                @foreach (json_decode($question->options, true) as $key => $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $key }}" id="option{{ $question->id }}_{{ $key }}">
                                        <label class="form-check-label" for="option{{ $question->id }}_{{ $key }}">
                                            {{ $key }}. {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <textarea name="answers[{{ $question->id }}]" rows="3" class="form-control" placeholder="Jawaban..."></textarea>
                        @endif
                    </div>
                @endforeach

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                    <form action="{{ route('siswa.exams.submit', $attempt->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Kumpulkan Ujian</button>
                    </form>
                </div>
            </form>
        @else
            <p class="text-danger">Ujian tidak ditemukan.</p>
        @endif
    </div>
@endsection
