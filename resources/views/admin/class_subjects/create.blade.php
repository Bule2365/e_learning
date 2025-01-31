@extends('admin.layouts.app')

@section('content')
<h1>Tambah Relasi Kelas dan Mata Pelajaran</h1>

<form action="{{ route('class_subjects.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="class_id">Kelas</label>
        <select name="class_id" id="class_id" class="form-control" required>
            @foreach ($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="subject_id">Mata Pelajaran</label>
        <select name="subject_id" id="subject_id" class="form-control" required>
            @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Tambah Relasi</button>
</form>
@endsection