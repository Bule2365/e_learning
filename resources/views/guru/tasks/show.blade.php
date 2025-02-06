@extends('guru.layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('tasks.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>
                Kembali ke Daftar Tugas
            </span>
        </a>

        <h1>{{ $task->title }}</h1>

        <p><strong>Deskripsi:</strong> {{ $task->description }}</p>
        <p><strong>Mata Pelajaran:</strong> {{ $task->mataPelajaran->name }}</p>
        <p><strong>Kelas:</strong> {{ $task->kelas->name }}</p>
        <p><strong>Tanggal Deadline:</strong> {{ $task->due_date->format('d-m-Y H:i') }}</p>

        <h2>Siswa yang Mengumpulkan</h2>

        <div class="row">
            @foreach ($siswas as $siswa)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $siswa->name }}</h5>

                            <p><strong>Nilai:</strong></p>
                            <form action="{{ route('tasks.updateScore', ['task' => $task->id, 'user' => $siswa->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <input type="number" name="score" value="{{ $siswa->pivot->score }}" class="form-control"
                                    required @if (!$siswa->pivot->submission) disabled @endif>

                                <button type="submit" class="btn btn-success mt-2"
                                    @if (!$siswa->pivot->submission) disabled @endif>
                                    Update Nilai
                                </button>
                            </form>

                            <p><strong>File Jawaban:</strong></p>
                            @if ($siswa->pivot->submission)
                                <a href="{{ asset('storage/' . $siswa->pivot->submission) }}" target="_blank"
                                    class="btn btn-info">
                                    Lihat File
                                </a>
                            @else
                                <span>Tidak ada file</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
