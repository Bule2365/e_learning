@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Edit Pengguna</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation Input -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Input -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role:</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('role')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check2-circle"></i> Perbarui
                            </button>

                            <!-- Back Button -->
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection