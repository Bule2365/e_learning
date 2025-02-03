@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Tugas</h1>

        @foreach ($tasks as $task)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    <p class="card-text">{{ $task->description }}</p>
                    <p class="card-text"><strong>Batas Waktu:</strong> {{ $task->due_date->format('d M Y H:i') }}</p>

                    <a href="{{ route('student.tasks.show', $task->id) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
