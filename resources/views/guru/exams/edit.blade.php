@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="display-4 text-center mb-4">Edit Ujian</h1>

        <form action="{{ route('guru.exams.update', $exam->id) }}" method="POST" class="shadow p-4 rounded bg-light">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Judul Ujian</label>
                <input type="text" name="title" id="title" value="{{ old('title', $exam->title) }}"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    placeholder="Masukkan deskripsi ujian (optional)" rows="4">{{ old('description', $exam->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Pilih status ujian">
                    <option value="draft" {{ $exam->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $exam->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
                <a href="{{ route('guru.exams.index') }}" class="btn btn-secondary btn-lg w-100 ms-3">Batal</a>
            </div>
        </form>
    </div>
@endsection
