@extends('siswa.layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Tugas</h1>

    @foreach ($tasks->sortByDesc('due_date') as $task) <!-- Sorting tasks by due_date in descending order -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $task->title }}</h5>
            <p class="card-text">{{ $task->description }}</p>
            <p class="card-text"><strong>Batas Waktu:</strong> {{ $task->due_date->format('d M Y H:i') }}</p>

            <!-- Menampilkan nilai yang diberikan guru, jika ada -->
            @if ($task->users->isNotEmpty() && $task->users->first()->pivot->score !== null)
            <p class="card-text"><strong>Nilai:</strong> {{ $task->users->first()->pivot->score }}</p>
            @else
            <p class="card-text"><strong>Nilai Belum Diberikan</strong></p>
            @endif

            <a href="{{ route('student.tasks.show', $task->id) }}" class="btn btn-primary">Lihat Detail</a>
        </div>
    </div>
    @endforeach
</div>
@endsection