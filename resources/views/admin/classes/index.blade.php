@extends('admin.layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Daftar Kelas</h1>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Buat Kelas Baru
        </a>
    </div>

    @if($classes->isEmpty())
    <div class="alert alert-warning" role="alert">
        Tidak ada kelas yang tersedia.
    </div>
    @else
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $index => $class)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $class->name }}</td>
                    <td>
                        @foreach($class->guru as $guru)
                        <span class="badge bg-info text-dark">{{ $guru->name }}</span><br>
                        @endforeach
                    </td>
                    <td>{{ Str::limit($class->deskripsi, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus kelas ini?')">
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