@extends('guru.layouts.app')

@section('content')
    @push('styles')
        <style>
            .card {
                transition: transform 0.5s ease;
            }

            .card:hover {
                transform: scale(1.03);
            }
        </style>
    @endpush

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="container my-5">
        <h1 class="display-4 text-center mb-4">Tambah Soal Ujian</h1>

        <div class="d-flex justify-content-center mb-3">
            <button id="manual-btn" class="btn btn-primary mx-2">Masukkan Soal Manual</button>
            <button id="upload-btn" class="btn btn-secondary mx-2">Upload File</button>
        </div>

        {{-- Form Input Manual --}}
        <div id="manual-form">
            <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Soal</label>
                    <textarea class="form-control" id="question_text" name="question_text" rows="3" required></textarea>
                </div>

                <div class="mb-3" id="options-section">
                    <label class="form-label">Pilihan Jawaban</label>
                    <div id="options-container">
                        <input type="text" class="form-control mb-2" name="options[A]" placeholder="Pilihan A">
                        <input type="text" class="form-control mb-2" name="options[B]" placeholder="Pilihan B">
                        <input type="text" class="form-control mb-2" name="options[C]" placeholder="Pilihan C">
                        <input type="text" class="form-control mb-2" name="options[D]" placeholder="Pilihan D">
                    </div>
                </div>

                <div class="mb-3" id="correct-answer-section">
                    <label class="form-label">Jawaban Benar</label>
                    <input type="text" class="form-control" id="correct_answer" name="correct_answer">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Soal</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="multiple_choice">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Tambah Soal</button>
            </form>
        </div>

        {{-- Form Upload File --}}
        <div id="upload-form" style="display: none;">
            <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih File Soal</label>
                    <input type="file" class="form-control" name="file" accept=".docx, .xlsx" required>
                </div>
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('manual-btn').addEventListener('click', () => {
                document.getElementById('manual-form').style.display = 'block';
                document.getElementById('upload-form').style.display = 'none';
            });

            document.getElementById('upload-btn').addEventListener('click', () => {
                document.getElementById('manual-form').style.display = 'none';
                document.getElementById('upload-form').style.display = 'block';
            });

            // Menampilkan atau menyembunyikan pilihan ganda berdasarkan tipe soal
            document.getElementById('type').addEventListener('change', function() {
                let isMultipleChoice = this.value === 'multiple_choice';
                document.getElementById('options-section').style.display = isMultipleChoice ? 'block' : 'none';
                document.getElementById('correct-answer-section').style.display = isMultipleChoice ? 'block' : 'none';
            });
        </script>
    @endpush
@endsection
