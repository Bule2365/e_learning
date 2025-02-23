@extends('admin.layouts.app')

@section('title', 'Data Pengguna')

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
            padding: 5px 10px;
            font-size: 14px;
            transition: transform 0.3s ease-in-out;
        }

        .btn-action:hover {
            transform: scale(1.03);
        }

        /* Pagination Styling */
        .pagination {
            justify-content: center;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .pagination .page-link {
            color: #4e73df;
            transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: #4e73df;
        }

        /* Alert Styling */
        .empty-alert {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Data Pengguna</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('users.create')}}" class="btn btn-primary shadow-sm btn-action">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Pengguna
                </a>
                <button type="button" class="btn btn-success shadow-sm btn-action" data-bs-toggle="modal"
                    data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i> Import Data
                </button>
                <a href="{{ route('users.export') }}" class="btn btn-secondary shadow-sm btn-action">
                    <i class="bi bi-download me-2"></i> Export Data
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="input-group">
                    <form action="{{ route('users.index') }}" method="GET" class="d-flex justify-content-between gap-3">
                        <!-- Search Input -->
                        <div class="input-group w-75">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 shadow-sm"
                                placeholder="Cari pengguna..." value="{{ request()->search }}"
                                aria-label="Cari pengguna...">
                        </div>

                        <!-- Role Dropdown with Smooth Transition -->
                        <select name="role" class="form-select w-25 shadow-sm border-start-0"
                            onchange="this.form.submit()">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru" {{ request()->role == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ request()->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="card shadow table-custom">
            <div class="card-body">
                @if ($users->isEmpty())
                    <div class="empty-alert">
                        Tidak ada pengguna yang tersedia.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $user->id }}">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $user->id }}">
                                                                    Konfirmasi Penghapusan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus pengguna
                                                                <strong>{{ $user->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('users.destroy', $user) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus pengguna
                                                    <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                @endif
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo; Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&laquo;
                            Previous</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next &raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next &raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize Bootstrap Tooltips -->
    @push('scripts')
        <script>
            // Optional: Prevent form submission if no change in dropdown
            document.querySelector('.form-select').addEventListener('change', function() {
                if (this.value) {
                    this.form.submit();
                }
            });
        </script>
    @endpush
@endsection
