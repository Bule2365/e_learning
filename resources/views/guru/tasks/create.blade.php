@extends('guru.layouts.app')

@section('content')
<div class="container">
    <h1>Form Tugas Baru</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Judul Tugas</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="subject_id">Mata Pelajaran</label>
            <select class="form-control" id="subject_id" name="subject_id" required>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="class_id">Kelas</label>
            <select class="form-control" id="class_id" name="class_id" required>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Tanggal Deadline</label>
            <input type="date" class="form-control" id="due_date" name="due_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Buat Tugas</button>
    </form>
</div>
@endsection