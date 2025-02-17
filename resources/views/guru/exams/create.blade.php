@extends('guru.layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('guru.classes.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>
                Kembali ke Daftar Kelas
            </span>
        </a>

        <h1 class="mb-4">Form Ujian Baru</h1>

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guru.exams.store') }}" method="POST">
            @csrf

            <!-- Input hidden untuk class_id -->
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            <!-- Input hidden untuk subject_id -->
            <input type="hidden" name="subject_id" value="{{ $subjects->first()->id }}">

            <div class="mb-3">
                <label for="class_name" class="form-label">Kelas</label>
                <input type="text" id="class_name" class="form-control" value="{{ $class->name }}" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="subject_name" class="form-label">Mata Pelajaran</label>
                <input type="text" id="subject_name" class="form-control" value="{{ $subjects->first()->name }}" readonly
                    disabled>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Ujian</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Ujian</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Ujian</button>
        </form>
    </div>
@endsection
