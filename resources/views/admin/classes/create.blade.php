@extends('admin.layouts.app')
@section('title', 'Buat Kelas Baru')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Page Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <a href="{{ route('admin.classes.index') }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary py-3">
                        <h3 class="h4 mb-0 text-white fw-bold">
                            <i class="bi bi-file-plus me-2"></i>Tambah Kelas Baru
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.classes.store') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf

                            <!-- Nama Kelas -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-medium">Nama Kelas</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </span>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        required placeholder="Contoh: Kelas X IPA 1">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi Kelas -->
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-medium">Deskripsi Kelas</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <i class="bi bi-card-text"></i>
                                    </span>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4"
                                        placeholder="Deskripsikan kelas ini...">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary py-2 px-4 d-flex align-items-center gap-2">
                                    <i class="bi bi-save me-1"></i>
                                    <span>Buat Kelas</span>
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
