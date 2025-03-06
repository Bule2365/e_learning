@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">

        <a href="{{ route('tasks.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Tugas</span>
        </a>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h1 class="display-4 text-center mb-4">Edit Tugas</h1>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Judul Tugas</label>
                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">File Saat Ini:</label>
                <ul>
                    @foreach (json_decode($task->file_path, true) ?? [] as $file)
                        <li>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Lihat File</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Unggah File Baru (Opsional, Maks 5)</label>
                <input type="file" name="files[]" id="files" class="form-control" multiple
                    accept="application/pdf, image/*, video/mp4, video/quicktime, video/x-msvideo">
                @error('files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Batas Pengumpulan</label>
                <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date) }}"
                    class="form-control @error('due_date') is-invalid @enderror" required>
                @error('due_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
