@extends('siswa.layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="display-5 fw-semibold text-primary mb-1">Daftar Kelas</h1>
                        <p class="lead text-muted mb-0">Pilih kelas yang tersedia untuk bergabung</p>
                    </div>
                </div>

                @if ($classes->isEmpty())
                    <!-- Empty State -->
                    <div class="alert alert-info d-flex align-items-center animate__animated animate__fadeIn" role="alert">
                        <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Tidak ada kelas tersedia</h5>
                            <p class="mb-0">Silahkan hubungi administrator untuk informasi lebih lanjut</p>
                        </div>
                    </div>
                @else
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-nowrap">#</th>
                                    <th scope="col" class="text-nowrap">Nama Kelas</th>
                                    <th scope="col" class="d-none d-md-table-cell">Deskripsi</th>
                                    <th scope="col" class="text-nowrap text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $index => $class)
                                    <tr class="animate__animated animate__fadeInUp">
                                        <td class="fw-semibold">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                                <span class="fw-medium">{{ $class->name }}</span>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-secondary">
                                            {{ Str::limit($class->deskripsi, 50) }}
                                        </td>
                                        <td class="text-end">
                                            @if ($user->kelas->isEmpty())
                                                <form action="{{ route('siswa.classes.join', $class->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm px-3 px-sm-4 py-2 text-nowrap"
                                                        data-bs-toggle="tooltip"
                                                        title="Bergabung ke kelas {{ $class->name }}">
                                                        <i class="bi bi-plus-circle me-1"></i>Bergabung
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-outline-secondary btn-sm px-3 px-sm-4 py-2" disabled
                                                    data-bs-toggle="tooltip" title="Anda sudah terdaftar di kelas">
                                                    <i class="bi bi-check2-circle me-1"></i>Terdaftar
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Responsive Breakpoints */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.25rem;
            }

            .table-hover tr {
                border-bottom: 2px solid #f8f9fa;
                padding: 0.75rem 0;
            }

            .table-hover td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0;
            }

            .table-hover td:before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                color: #6c757d;
            }

            .table-hover td[data-label]:not(:first-child) {
                border-top: 1px solid #dee2e6;
            }
        }
    </style>
@endpush
