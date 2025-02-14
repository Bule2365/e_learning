@extends('guru.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Daftar Kelas Anda</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($classes as $class)
        <div class="col">
            <div class="card shadow-sm rounded-3 border-light" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">{{ $class->name }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Deskripsi:</strong> {{ $class->deskripsi }}</p>
                    <p><strong>Daftar Siswa yang Bergabung:</strong></p>
                    @if($class->siswa->isEmpty())
                    <p>Belum ada siswa yang bergabung.</p>
                    @else
                    <ul>
                        @foreach($class->siswa as $murid)
                        <li>{{ $murid->name }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <a href="{{ route('guru.exams.create', ['class_id' => $class->id]) }}" class="btn btn-primary mt-3"><i class="bi bi-file-plus-fill fs-4"></i> Buat Ujian</a>
                    <a href="{{ route('tasks.create', ['class_id' => $class->id]) }}" class="btn btn-primary mt-3"><i class="bi bi-clipboard-plus-fill fs-4"></i> Buat Tugas</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection