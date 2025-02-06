@extends('admin.layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Page Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary py-3">
                        <h3 class="h4 mb-0 text-white fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Mata Pelajaran
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Nama Mata Pelajaran -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-medium">Nama Mata Pelajaran</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <i class="bi bi-journal-bookmark-fill"></i>
                                    </span>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $subject->name) }}" required placeholder="Contoh: Matematika">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pilih Guru -->
                            <div class="mb-4">
                                <label for="user_id" class="form-label fw-medium">Pilih Guru</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </span>
                                    <select name="user_id" id="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $subject->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary py-2 px-4 d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    <span>Perbarui Mata Pelajaran</span>
                                </button>
                                <button type="reset" class="btn btn-outline-secondary py-2 px-4">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-side Validation Script -->
    @push('scripts')
        <script>
            (() => {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
    @endpush
@endsection
