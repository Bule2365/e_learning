@extends('guru.layouts.app')

@section('content')

<div class="container my-5">
    <h1 class="display-4 text-center mb-4">Daftar Tugas</h1>

    <div class="row">
        @if ($tasks->isEmpty())
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada tugas yang tersedia.
            </div>
        </div>
        @else
        @foreach ($tasks->sortByDesc('created_at') as $task)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $task->mataPelajaran->name }}</h6>
                    <p class="card-text">Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary w-100"><i class="bi bi-view-list"></i> Lihat Tugas</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection