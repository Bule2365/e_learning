@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
        <a href="{{ route('guru.exams.show', ['id' => $exam->id]) }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Soal Ujian</span>
        </a>

        <h1 class="display-4 text-center mb-4">Edit Gambar Soal</h1>

        <!-- Gambar Soal -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gambar Soal</h5>
            </div>
            <div class="card-body text-center">
                @if ($question->image_path)
                    <!-- Menampilkan gambar jika ada -->
                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal" class="img-fluid mb-3"
                        style="max-width: 300px;">
                @else
                    <!-- Jika tidak ada gambar -->
                    <p class="text-muted">Belum ada gambar. Upload gambar untuk soal ini.</p>
                @endif

                <!-- Tombol untuk memilih gambar baru -->
                <form action="{{ route('guru.exams.update_image', $question->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Gambar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
