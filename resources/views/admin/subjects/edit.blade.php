@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Mata Pelajaran</h1>

        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}" required>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Guru</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if ($subject->user_id == $user->id) selected @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
