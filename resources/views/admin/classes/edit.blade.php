@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Kelas</h1>

    <div class="card shadow-lg p-4 rounded">
        <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Kelas -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kelas</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $class->name }}" required placeholder="Masukkan nama kelas">
            </div>

            <!-- Deskripsi Kelas -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Kelas</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required placeholder="Masukkan deskripsi kelas">{{ $class->deskripsi }}</textarea>
            </div>

            <!-- Pilih Guru -->
            <div class="mb-3">
                <label for="guru_id" class="form-label">Pilih Wali Kelas (Guru)</label>
                <select name="guru_id[]" id="guru_id" class="form-select" multiple required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach($users as $user)
                    @if($user->role == 'guru')
                    <option value="{{ $user->id }}"
                        @if($class->guru->contains('id', $user->id)) selected @endif>
                        {{ $user->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
                <small class="form-text text-muted">Pilih satu atau lebih guru sebagai wali kelas.</small>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">Perbarui Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection