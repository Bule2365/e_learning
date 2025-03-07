@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <a href="{{ route('guru.classes.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>

        <h1 class="display-4 text-center mb-4">Form Tugas Baru</h1>

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            @csrf

            <!-- Menyembunyikan input class_id jika ada di URL -->
            <input type="hidden" name="class_id" value="{{ $classes->id }}">

            <!-- Input hidden untuk subject_id -->
            <input type="hidden" name="subject_id" value="{{ $subjects->first()->id }}">

            <!-- Pilihan Mata Pelajaran -->
            <div class="mb-3">
                <label for="class_name" class="form-label">Kelas</label>
                <input type="text" id="class_name" class="form-control" value="{{ $classes->name }}" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="subject_name" class="form-label">Mata Pelajaran</label>
                <input type="text" id="subject_name" class="form-control" value="{{ $subjects->first()->name }}" readonly
                    disabled>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Tugas</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah Tugas (Maksimal 5 file, 100MB per file)</label>
                <div id="file-inputs">
                    <div class="input-group mb-2">
                        <input type="file" name="files[]" class="form-control file-input"
                            accept="application/pdf, image/*, video/*">
                        <button type="button" class="btn btn-success add-file">+</button>
                    </div>
                </div>
                <small class="text-muted">Maksimal 5 file, masing-masing maksimal 100MB.</small>
                @error('files.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Batas Pengumpulan</label>
                <input type="datetime-local" name="due_date" id="due_date"
                    class="form-control @error('due_date') is-invalid @enderror" required>
                @error('due_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-floppy2-fill"></i>
                    <span>Simpan Tugas</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputsContainer = document.getElementById('file-inputs');
            const addFileButton = document.querySelector('.add-file');

            addFileButton.addEventListener('click', function() {
                const fileInputs = document.querySelectorAll('.file-input');

                if (fileInputs.length < 5) {
                    const newInputGroup = document.createElement('div');
                    newInputGroup.classList.add('input-group', 'mb-2');

                    const newFileInput = document.createElement('input');
                    newFileInput.type = 'file';
                    newFileInput.name = 'files[]';
                    newFileInput.classList.add('form-control', 'file-input');
                    newFileInput.accept = 'application/pdf, image/*, video/*';

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.classList.add('btn', 'btn-danger', 'remove-file');
                    removeButton.innerText = '−';

                    newInputGroup.appendChild(newFileInput);
                    newInputGroup.appendChild(removeButton);
                    fileInputsContainer.appendChild(newInputGroup);

                    // Cek apakah sudah 5 file, jika ya nonaktifkan tombol "+"
                    if (fileInputs.length + 1 >= 5) {
                        addFileButton.disabled = true;
                    }

                    // Hapus input file jika tombol "−" ditekan
                    removeButton.addEventListener('click', function() {
                        newInputGroup.remove();
                        addFileButton.disabled = false;
                    });
                }
            });
        });
    </script>
@endpush
