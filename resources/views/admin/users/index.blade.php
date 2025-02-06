@extends('admin.layouts.app')

@section('title', 'Data Pengguna')

@section('content')
    <div class="container mt-3 mt-md-5">
        <h1 class="text-center mb-4">Daftar Pengguna</h1>

        <!-- Action Buttons Section -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <a href="{{ route('users.create') }}" class="btn btn-success w-100 btn-lg" data-bs-toggle="tooltip"
                    title="Tambah Pengguna Baru">
                    <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Pengguna</span>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('users.export') }}" class="btn btn-primary w-100 btn-lg" data-bs-toggle="tooltip"
                    title="Export Data ke Excel">
                    <i class="bi bi-download"></i> <span class="d-none d-md-inline">Export Data</span>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column gap-2">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100 btn-lg" data-bs-toggle="tooltip"
                        title="Import Data dari Excel">
                        <i class="bi bi-upload"></i> <span class="d-none d-md-inline">Import Data</span>
                    </button>
                    <input type="file" name="file" class="form-control" required>
                </form>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="mb-4">
            <form action="{{ route('users.index') }}" method="GET" class="d-flex justify-content-between gap-3">
                <input type="text" name="search" class="form-control w-75" placeholder="Cari pengguna..."
                    value="{{ request()->search }}">
                <select name="role" class="form-select w-25" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ request()->role == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ request()->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
            </form>
        </div>

        @if ($users->isEmpty())
            <div class="alert alert-warning" role="alert">
                Tidak ada pengguna yang tersedia.
            </div>
        @else
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">#</th>
                            <th scope="col" style="width: 25%">Nama</th>
                            <th scope="col" style="width: 35%" class="d-none d-md-table-cell">Email</th>
                            <th scope="col" style="width: 20%">Role</th>
                            <th scope="col" class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge @if ($user->role == 'admin') bg-danger @elseif($user->role == 'guru') bg-warning @else bg-info @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="bi bi-trash3 me-1"></i> Hapus
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                            Konfirmasi Penghapusan</h5>
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
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        @endif
    </div>

    <!-- Initialize Bootstrap Tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
