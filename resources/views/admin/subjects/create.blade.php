@extends('admin.layouts.app')

@section('content')
<h1>Tambah Mata Pelajaran</h1>

<form action="{{ route('subjects.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nama Mata Pelajaran</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="user_id">Guru</label>
        <select name="user_id" id="user_id" class="form-control" required>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection