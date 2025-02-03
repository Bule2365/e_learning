@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Mata Pelajaran</h1>

        <!-- Tombol Tambah Mata Pelajaran -->
        <div class="mb-3">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Mata Pelajaran
            </a>
        </div>

        @if ($subjects->isEmpty())
            <div class="alert alert-info" role="alert">
                Belum ada mata pelajaran yang diajarkan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Mata Pelajaran</th>
                            <th>Pengajar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->user->name }}</td> <!-- Menampilkan nama pengajar -->
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
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
