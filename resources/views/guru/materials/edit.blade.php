@extends('guru.layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Materi</h1>

        <form action="{{ route('guru.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Menyembunyikan input class_id jika ada di URL -->
            <input type="hidden" name="class_id" value="{{ optional($classes->first())->id }}">

            <!-- Input hidden untuk subject_id -->
            <input type="hidden" name="subject_id" value="{{ optional($subjects->first())->id }}">

            <!-- Pilihan Mata Pelajaran -->
            <div class="mb-3">
                <label for="class_name" class="form-label">Kelas</label>
                <input type="text" id="class_name" class="form-control"
                    value="{{ optional($material->ClassModel)->name }}" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="subject_name" class="form-label">Mata Pelajaran</label>
                <input type="text" id="subject_name" class="form-control"
                    value="{{ optional($material->subject)->name }}" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{ old('title', $material->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Materi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="4" required>{{ old('description', $material->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Unggah File Materi</label>
                <input type="file" class="form-control @error('files') is-invalid @enderror" id="files"
                    name="files[]" multiple>
                @error('files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <!-- Menampilkan file yang sudah ada -->
                @if ($material->file_path)
                    <div class="mt-3">
                        <h5>File yang sudah ada:</h5>
                        @foreach (json_decode($material->file_path, true) as $file)
                            @php
                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION); // Ambil ekstensi file
                                $fileUrl = asset('storage/' . $file); // URL file
                            @endphp

                            <div class="mb-3">
                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                    <!-- Gambar -->
                                    <img src="{{ $fileUrl }}" alt="Materi Gambar" class="img-fluid rounded mb-3"
                                        style="max-height: 200px; object-fit: cover;">
                                    <p class="mt-2">{{ ucfirst($fileExtension) }} Image</p>
                                @elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'mkv']))
                                    <!-- Video -->
                                    <video class="img-fluid rounded mb-3" controls style="max-height: 200px;">
                                        <source src="{{ $fileUrl }}" type="video/{{ $fileExtension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p class="mt-2">{{ ucfirst($fileExtension) }} Video</p>
                                @else
                                    <!-- Jika bukan gambar atau video, tampilkan link -->
                                    <a href="{{ $fileUrl }}" class="btn btn-link" target="_blank">Unduh File</a>
                                    <small class="text-muted"> (File ini tidak akan diubah kecuali Anda mengunggah file
                                        baru)</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Materi</button>
            <a href="{{ route('guru.materials.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
