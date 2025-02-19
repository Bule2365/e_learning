@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="display-4 text-center mb-4">Edit Soal Ujian</h1>

        <form action="{{ route('guru.exams.updateQuestions', $exam->id) }}" method="POST" class="shadow p-4 rounded bg-light">
            @csrf
            @method('PUT')

            @foreach ($exam->soal as $question)
                <div class="mb-4">
                    <label for="question_text_{{ $question->id }}" class="form-label">Soal {{ $loop->iteration }}</label>
                    <textarea name="questions[{{ $loop->index }}][question_text]" id="question_text_{{ $question->id }}"
                        class="form-control @error('questions.*.question_text') is-invalid @enderror" rows="3" required>{{ old('questions.' . $loop->index . '.question_text', $question->question_text) }}</textarea>
                    @error('questions.*.question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type_{{ $question->id }}" class="form-label">Tipe Soal</label>
                    <select name="questions[{{ $loop->index }}][type]" id="type_{{ $question->id }}"
                        class="form-select @error('questions.*.type') is-invalid @enderror" required>
                        <option value="multiple_choice" {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>
                            Pilihan Ganda</option>
                        <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>Essay</option>
                    </select>
                    @error('questions.*.type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($question->type == 'multiple_choice')
                    <div class="mb-3">
                        <label class="form-label">Opsi Pilihan Ganda</label>
                        @foreach (json_decode($question->options, true) as $key => $option)
                            <input type="text" name="questions[{{ $loop->parent->index }}][options][]"
                                value="{{ $option }}" class="form-control mb-2"
                                placeholder="Opsi {{ $key + 1 }}" required>
                        @endforeach
                    </div>
                @endif

                <div class="mb-3">
                    <label for="correct_answer_{{ $question->id }}" class="form-label">Jawaban Benar</label>
                    <input type="text" name="questions[{{ $loop->index }}][correct_answer]"
                        id="correct_answer_{{ $question->id }}"
                        value="{{ old('questions.' . $loop->index . '.correct_answer', $question->correct_answer) }}"
                        class="form-control @error('questions.*.correct_answer') is-invalid @enderror" required>
                    @error('questions.*.correct_answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
                <a href="{{ route('guru.exams.show', $exam->id) }}" class="btn btn-secondary btn-lg w-100 ms-3">Batal</a>
            </div>
        </form>
    </div>
@endsection
