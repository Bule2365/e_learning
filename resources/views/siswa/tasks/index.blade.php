@extends('siswa.layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Tugas</h1>

        <!-- Form pencarian -->
        <form method="GET" action="{{ route('student.tasks.index') }}">
            <div class="input-group mb-4">
                <input type="text" name="search" class="form-control" placeholder="Cari tugas..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        @foreach ($tasks->sortByDesc('due_date') as $task)
            <!-- Sorting tasks by due_date in descending order -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    <p class="card-text">{{ $task->description }}</p>
                    <p class="card-text"><strong>Batas Waktu:</strong> {{ $task->due_date->format('d M Y H:i') }}</p>

                    <!-- Menampilkan nilai yang diberikan guru, jika ada -->
                    @php
                        // Mencari siswa terkait di collection users
                        $user = $task->users->firstWhere('id', Auth::id());
                    @endphp
                    @if ($user && $user->pivot->score !== null)
                        <p class="card-text"><strong>Nilai:</strong> {{ $user->pivot->score }}</p>
                    @else
                        <p class="card-text"><strong>Nilai Belum Diberikan</strong></p>
                    @endif

                    <a href="{{ route('student.tasks.show', $task->id) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
