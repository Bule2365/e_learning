@extends('guru.layouts.app')

@section('content')
@push('styles')
<style>
    .card { transition: transform 0.5s ease; }
    .card:hover { transform: scale(1.03); }
</style>
@endpush

<div class="container my-5">
    <h1 class="display-4 text-center mb-4">Tambah Soal Ujian</h1>

    <div class="d-flex justify-content-center mb-3">
        <button id="manual-btn" class="btn btn-primary mx-2">Masukkan Soal Manual</button>
        <button id="upload-btn" class="btn btn-secondary mx-2">Upload File</button>
    </div>

    <div id="manual-form">
        <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Soal</label>
                <textarea class="form-control" id="question_text" name="question_text" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Pilihan Jawaban</label>
                <input type="text" class="form-control" id="options" name="options">
            </div>

            <div class="mb-3">
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

    <div id="upload-form" style="display: none;">
        <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih File Soal</label>
                <input type="file" class="form-control" name="file" accept=".docx, .pdf, .xlsx" required>
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
</script>
@endpush

@endsection
