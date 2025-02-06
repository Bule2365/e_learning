@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Page Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <a href="{{ route('users.index') }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary py-3">
                        <h3 class="h4 mb-0 text-white fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Data Pengguna
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('users.update', $user) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Name Input -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person-badge me-1"></i>Nama Lengkap
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Input -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-1"></i>Alamat Email
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password">
                                        <label for="password" class="form-label">
                                            <i class="bi bi-lock me-1"></i>Password Baru
                                        </label>
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Konfirmasi Password">
                                        <label for="password_confirmation" class="form-label">
                                            <i class="bi bi-shield-lock me-1"></i>Konfirmasi Password
                                        </label>
                                    </div>
                                </div>

                                <!-- Role Selection -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select name="role" id="role"
                                            class="form-select @error('role') is-invalid @enderror" required>
                                            <option value="admin"
                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="guru"
                                                {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>
                                                Guru
                                            </option>
                                            <option value="siswa"
                                                {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>
                                                Siswa
                                            </option>
                                        </select>
                                        <label for="role" class="form-label">
                                            <i class="bi bi-person-rolodex me-1"></i>Jenis Pengguna
                                        </label>
                                        @error('role')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3">
                                    <button type="submit"
                                        class="btn btn-primary py-2 px-4 d-flex align-items-center gap-2">
                                        <i class="bi bi-arrow-repeat me-1"></i>Perbarui Data
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary py-2 px-4">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .form-floating label {
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus~label {
            color: var(--bs-primary);
            opacity: 0.8;
        }

        .rounded-3 {
            border-radius: 1rem !important;
        }
    </style>
@endpush
