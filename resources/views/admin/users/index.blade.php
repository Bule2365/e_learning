@extends('admin.layouts.app')

@section('title', 'Data Pengguna')

@section('content')
<div class="container mt-3 mt-md-5">
    <h1 class="text-center mb-4">Daftar Pengguna</h1>

    <!-- Action Buttons Section -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <a href="{{ route('users.create') }}" class="btn btn-success w-100 btn-lg">
                <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Pengguna</span>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('users.export') }}" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-download"></i> <span class="d-none d-md-inline">Export Data</span>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                @csrf
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-secondary w-100 btn-lg">
                    <i class="bi bi-upload"></i> <span class="d-none d-md-inline">Import Data</span>
                </button>
            </form>
        </div>
    </div>

    @if ($users->isEmpty())
    <div class="alert alert-warning" role="alert">
        Tidak ada pengguna yang tersedia.
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th class="d-none d-md-table-cell">Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                    <td>
                        <span class="badge @if ($user->role == 'admin') bg-danger @elseif($user->role == 'guru') bg-warning @else bg-info @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm flex-grow-1">
                                <i class="bi bi-pencil"></i> <span class="d-none d-md-inline">Edit</span>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Anda yakin ingin menghapus pengguna ini?')">
                                    <i class="bi bi-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection