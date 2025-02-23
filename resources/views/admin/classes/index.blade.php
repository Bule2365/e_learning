@extends('admin.layouts.app')

@section('title', 'Daftar Kelas')

@push('styles')
    <style>
        /* Custom Table Styling */
        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .table-custom thead th {
            background-color: #f8f9fc;
            color: #333;
            font-weight: bold;
        }

        .table-custom tbody tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.3s ease-in-out;
        }

        /* Button Styling */
        .btn-action {
            padding: 8px 12px;
            font-size: 14px;
            transition: transform 0.3s ease-in-out;
        }

        .btn-action:hover {
            transform: scale(1.05);
        }

        /* Alert Styling */
        .alert-info {
            background-color: #e6f4ff;
            border-color: #b3d7ff;
            color: #004085;
            border-radius: 10px;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .btn-lg {
                font-size: 1rem;
            }

            .table-custom thead th {
                font-size: 12px;
            }

            .table-custom tbody td {
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <!-- Header -->
        <h1 class="text-center mb-4 text-primary fw-bold">Daftar Kelas</h1>

        <!-- Button Tambah Kelas -->
        <div class="col-12 col-md-4 mb-3 mx-auto">
            <a href="{{ route('admin.classes.create') }}" class="btn btn-success w-100 btn-lg shadow-sm btn-action"
                data-bs-toggle="tooltip" title="Tambah Kelas">
                <i class="bi bi-plus-circle me-2"></i> <span class="d-none d-md-inline">Tambah Kelas</span>
            </a>
        </div>

        <!-- Alert Jika Tidak Ada Data -->
        @if ($classes->isEmpty())
            <div class="alert alert-info mt-4 text-center" role="alert">
                Belum ada kelas yang tersedia.
            </div>
        @else
            <!-- Table Daftar Kelas -->
            <div class="card shadow table-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 5%">#</th>
                                    <th scope="col" style="width: 30%">Nama Kelas</th>
                                    <th scope="col" style="width: 35%">Deskripsi</th>
                                    <th scope="col" style="width: 20%">Jumlah Siswa</th>
                                    <th scope="col" class="text-center" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ Str::limit($class->deskripsi, 50) }}</td>
                                        <td>{{ $class->siswa->count() }} Siswa</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Tombol Detail -->
                                                <a href="{{ route('admin.classes.show', $class->id) }}"
                                                    class="btn btn-outline-info btn-sm btn-action" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.classes.edit', $class) }}"
                                                    class="btn btn-outline-primary btn-sm btn-action" title="Edit Kelas">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <!-- Tombol Hapus dengan Modal -->
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-action"
                                                    title="Hapus Kelas" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $class->id }}">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $class->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $class->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $class->id }}">
                                                        Konfirmasi Penghapusan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus kelas
                                                    <strong>{{ $class->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.classes.destroy', $class) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
