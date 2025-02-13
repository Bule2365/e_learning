@extends('guru.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tambah Soal untuk Ujian: {{ $exam->title }}</h1>

    <!-- Display success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('guru.exams.storeQuestions', $exam->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="question_text" class="form-label">Teks Soal</label>
            <input type="text" name="question_text" id="question_text" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="options" class="form-label">Pilihan</label>
            <input type="text" name="options[]" class="form-control" placeholder="Pilihan 1" required>
            <input type="text" name="options[]" class="form-control" placeholder="Pilihan 2" required>
            <input type="text" name="options[]" class="form-control" placeholder="Pilihan 3" required>
            <input type="text" name="options[]" class="form-control" placeholder="Pilihan 4" required>
        </div>

        <div class="mb-3">
            <label for="correct_answer" class="form-label">Jawaban Benar</label>
            <input type="text" name="correct_answer" id="correct_answer" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipe Soal</label>
            <select name="type" id="type" class="form-control" required>
                <option value="multiple_choice">Pilihan Ganda</option>
                <option value="essay">Essay</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Soal</button>
    </form>
</div>
@endsection