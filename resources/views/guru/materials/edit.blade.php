@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <a href="{{ route('guru.materials.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="display-4 text-center mb-4">Edit Materi</h1>

        <form action="{{ route('guru.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" name="title" id="title" value="{{ old('title', $material->title) }}"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $material->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Menampilkan file saat ini jika ada --}}
            @php
                $files = json_decode($material->file_path, true) ?? [];
            @endphp

            <div class="mb-3">
                <label class="form-label">File Saat Ini:</label>
                <ul id="current-files">
                    @foreach ($files as $file)
                        <li>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Lihat File</a>
                            <input type="checkbox" name="delete_old_files[]" value="{{ $file }}"
                                class="delete-file-checkbox"> Hapus
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah File Baru</label>
                <div id="file-inputs">
                    <div class="input-group mb-2">
                        <input type="file" name="files[]" class="form-control file-input"
                            accept="application/pdf, image/*, video/*">
                        <button type="button" class="btn btn-success add-file">+</button>
                    </div>
                </div>
                <small class="text-muted">Maksimal 5 file, masing-masing maksimal 100MB.</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInputsContainer = document.getElementById('file-inputs');
                const addFileButton = document.querySelector('.add-file');
                const maxFiles = 4; // Sesuai dengan batasan pada backend
                let existingFiles = {{ count($files) }};
                let fileInputsCount = 0;

                function updateAddButtonState() {
                    if ((existingFiles + fileInputsCount) >= maxFiles) {
                        addFileButton.disabled = true;
                    } else {
                        addFileButton.disabled = false;
                    }
                }

                addFileButton.addEventListener('click', function() {
                    if ((existingFiles + fileInputsCount) < maxFiles) {
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

                        fileInputsCount++;
                        updateAddButtonState();

                        removeButton.addEventListener('click', function() {
                            newInputGroup.remove();
                            fileInputsCount--;
                            updateAddButtonState();
                        });
                    }
                });

                document.querySelectorAll('.delete-file-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            existingFiles--;
                        } else {
                            existingFiles++;
                        }
                        updateAddButtonState();
                    });
                });

                updateAddButtonState();
            });
        </script>
    @endpush
@endsection
