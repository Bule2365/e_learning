@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">{{ $attempt->exam->title }}</h2>
        <p class="text-center text-muted">{{ $attempt->exam->description }}</p>

        @foreach ($questions as $question)
            <div class="card mb-3">
                <h6>{{ $loop->iteration }}. {{ $question->question_text }}</h6>
                <div class="mb-4">
                    @if ($question->type == 'multiple_choice')
                        @foreach (json_decode($question->options, true) as $key => $option)
                            <div class="form-check">
                                <input class="form-check-input answer-input" type="radio" name="answers[{{ $question->id }}]"
                                    value="{{ $key }}" id="option{{ $question->id }}_{{ $key }}"
                                    data-question-id="{{ $question->id }}" data-attempt-id="{{ $attempt->id }}">
                                <label class="form-check-label" for="option{{ $question->id }}_{{ $key }}">
                                    {{ $key }}. {{ $option }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        <textarea name="answers[{{ $question->id }}]" rows="3" class="form-control answer-input"
                            data-question-id="{{ $question->id }}" data-attempt-id="{{ $attempt->id }}"></textarea>
                    @endif
                </div>
            </div>
        @endforeach

        <button type="button" class="btn btn-success btn-block" onclick="confirmSubmit()">Kumpulkan Ujian</button>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengumpulan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda sudah yakin telah menjawab semua pertanyaan?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('siswa.exams.index') }}" class="btn btn-danger">Ya, Selesai</a>
                </div>
            </div>
        </div>
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
                    .then(data => console.log(data.message))
                    .catch(error => console.error('Error:', error));
            });
        });

        function confirmSubmit() {
            $('#confirmSubmitModal').modal('show');
        }
    </script>
@endsection
