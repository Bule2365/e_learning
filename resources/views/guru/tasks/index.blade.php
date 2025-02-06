@extends('guru.layouts.app')

@section('content')
    @push('styles')
        <style>
            .card {
                transition: transform 0.5s ease;
                /* Transisi halus saat masuk dan keluar */
            }

            .card:hover {
                transform: scale(1.03);
                /* Sedikit membesar saat hover */
            }
        </style>
    @endpush

    <div class="container">
        <h1 class="my-4">Daftar Tugas</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $task->mataPelajaran->name }}</h6>
                            <p class="card-text">Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">Lihat Tugas</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
