@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">{{ $attempt->exam->title }}</h2>
        <p class="text-center text-muted">{{ $attempt->exam->description }}</p>

        <form id="exam-form" action="{{ route('siswa.exams.submit', $attempt->id) }}" method="POST">
            @csrf
            @foreach ($soal as $question)
                @php
                    // Ambil jawaban siswa jika ada
                    $studentAnswer = $attempt->upayaUjian->where('question_id', $question->id)->first();
                @endphp

                <div class="card mb-3">
                    <div class="card-body">
                        <h6>{{ $loop->iteration }}. {{ $question->question_text }}</h6>

                        @if ($question->image_path)
                            <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal"
                                class="img-fluid mb-2" style="max-width: 400px;">
                        @endif

                        <div class="mb-4">
                            @if ($question->type == 'multiple_choice')
                                @foreach (json_decode($question->options, true) as $key => $option)
                                    <div class="form-check">
                                        <input class="form-check-input answer-input" type="radio"
                                            name="answers[{{ $question->id }}]" value="{{ $key }}"
                                            id="option{{ $question->id }}_{{ $key }}"
                                            data-question-id="{{ $question->id }}" data-attempt-id="{{ $attempt->id }}"
                                            {{ $studentAnswer && $studentAnswer->answer == $key ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="option{{ $question->id }}_{{ $key }}">
                                            {{ $key }}. {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <textarea name="answers[{{ $question->id }}]" rows="3" class="form-control answer-input"
                                    data-question-id="{{ $question->id }}" data-attempt-id="{{ $attempt->id }}">{{ $studentAnswer ? $studentAnswer->answer : '' }}</textarea>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-success btn-block">Kumpulkan Ujian</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.answer-input').forEach(input => {
            input.addEventListener('change', function() {
                let attemptId = this.dataset.attemptId;
                let questionId = this.dataset.questionId;
                let answer = this.value;

                fetch(`/siswa/exams/answer/${attemptId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            answer: answer
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Jawaban berhasil disimpan.');
                        } else {
                            console.error('Gagal menyimpan jawaban:', data.message);
                            alert(data.message); // Tampilkan error ke pengguna
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
