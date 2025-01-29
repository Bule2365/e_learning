@extends('admin.layouts.app')

@section('title', 'Data Pengguna')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Pengguna</h1>

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Pengguna
            </a>

            <!-- Tombol Export -->
            <a href="{{ route('users.export') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-download"></i> Export Data
            </a>

            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-secondary btn-lg">
                    <i class="bi bi-upload"></i> Import Data
                </button>
            </form>            
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge @if ($user->role == 'admin') bg-danger @elseif($user->role == 'guru') bg-warning @else bg-info @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Anda yakin ingin menghapus pengguna ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
