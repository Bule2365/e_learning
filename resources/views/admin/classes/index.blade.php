@extends('admin.layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Daftar Kelas</h1>

    <!-- Button Tambah Kelas -->
    <div class="col-12 col-md-4 mb-3">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-success w-100 btn-lg" data-bs-toggle="tooltip" title="Tambah Kelas">
            <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Kelas</span>
        </a>
    </div>

    @if ($classes->isEmpty())
    <div class="alert alert-info mt-4" role="alert">
        Belum ada kelas yang tersedia.
    </div>
    @else
    <div class="table-responsive mt-4">
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
                    <td>{{ $class->deskripsi }}</td>
                    <td>{{ $class->siswa->count() }} Siswa</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Tombol Detail -->
                            <a href="{{ route('admin.classes.show', $class->id) }}" class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-outline-primary btn-sm" title="Edit Kelas">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <!-- Form Hapus -->
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Kelas">
                                    <i class="bi bi-trash3"></i> Hapus
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