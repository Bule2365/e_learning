@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Buat Kelas Baru</h1>

    <div class="card shadow-lg p-4 rounded">
        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf

            <!-- Nama Kelas -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kelas</label>
                <input type="text" id="name" name="name" class="form-control" required placeholder="Masukkan nama kelas">
            </div>

            <!-- Deskripsi Kelas -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Kelas</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required placeholder="Masukkan deskripsi kelas"></textarea>
            </div>

            <!-- Pilih Guru -->
            <div class="mb-3">
                <label for="guru_id" class="form-label">Pilih Guru</label>
                <select name="guru_id" id="guru_id" class="form-select" required>
                    <option value="">Pilih Guru</option>
                    @foreach($users as $user)
                    @if($user->role == 'guru')
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Buat Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection