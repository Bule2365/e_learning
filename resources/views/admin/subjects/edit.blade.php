@extends('admin.layouts.app')

@section('content')
<h1>Edit Mata Pelajaran</h1>

<form action="{{ route('subjects.update', $subject->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Nama Mata Pelajaran</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}" required>
    </div>

    <div class="form-group">
        <label for="user_id">Guru</label>
        <select name="user_id" id="user_id" class="form-control" required>
            @foreach ($users as $user)
            <option value="{{ $user->id }}"
                @if ($subject->user_id == $user->id) selected @endif>
                {{ $user->name }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection