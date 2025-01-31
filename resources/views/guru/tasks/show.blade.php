@extends('guru.layouts.app')

@section('content')
<div class="container">
    <h1>{{ $task->title }}</h1>

    <p><strong>Deskripsi:</strong> {{ $task->description }}</p>
    <p><strong>Mata Pelajaran:</strong> {{ $task->subject->name }}</p>
    <p><strong>Kelas:</strong> {{ $task->class->name }}</p>
    <p><strong>Tanggal Deadline:</strong> {{ $task->due_date }}</p>

    <h2>Siswa yang Mengumpulkan</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>
                    <form action="{{ route('tasks.updateScore', ['task' => $task->id, 'user' => $student->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="score" value="{{ $student->pivot->score }}" class="form-control" required>
                        <button type="submit" class="btn btn-success mt-2">Update Nilai</button>
                    </form>
                </td>
                <td>
                    <a href="#" class="btn btn-warning">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection