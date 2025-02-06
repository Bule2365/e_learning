@extends('guru.layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('guru.classes.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>
                Kembali ke Daftar Kelas
            </span>
        </a>

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

            <!-- Pilihan Mata Pelajaran -->
            <div class="mb-3">
                <label for="subject_id" class="form-label">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-control" required>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Menyembunyikan input class_id jika ada di URL -->
            <input type="hidden" name="class_id" value="{{ $classes->id }}">

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy2-fill"></i>
                    <span>Simpan Tugas</span>
                </button>
            </div>
        </form>
    </div>
@endsection
