@extends('guru.layouts.app')

@section('content')
    <div class="container">
        <h1>Form Tugas Baru</h1>

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul Tugas</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Unggah Tugas (Opsional)</label>
                <input type="file" name="file" id="file" class="form-control" accept="application/pdf, image/*">
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Batas Pengumpulan</label>
                <input type="datetime-local" name="due_date" id="due_date" class="form-control" required>
            </div>

            <!-- Hidden input fields for subject and class IDs -->
            <input type="hidden" name="subject_id" value="{{ $subjects->first()->id ?? '' }}">
            <input type="hidden" name="class_id" value="{{ $classes->first()->id ?? '' }}">

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan Tugas</button>
            </div>
        </form>
    </div>
@endsection
