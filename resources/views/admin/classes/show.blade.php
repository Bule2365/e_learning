@extends('admin.layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="container mt-3 mt-md-5">
    <h1 class="text-center mb-4">Detail Kelas: {{ $class->name }}</h1>

    <!-- Kelas Info -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $class->name }}</h5>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $class->deskripsi }}</p>
            <p class="text-muted">Jumlah Siswa: {{ $class->siswa->count() }} Siswa</p>
        </div>
    </div>

    <!-- Daftar Siswa yang tergabung dalam kelas -->
    <h4 class="mb-3">Daftar Siswa</h4>
    @if($class->siswa->isEmpty())
    <div class="alert alert-warning">
        Tidak ada siswa yang tergabung dalam kelas ini.
    </div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($class->siswa as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>
                    <form action="{{ route('admin.classes.removeStudentFromClass', $class->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $student->id }}">
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini?')">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Menambahkan Siswa -->
    <div class="mt-4">
        <h5>Tambah Siswa ke Kelas</h5>
        <form action="{{ route('admin.classes.addStudentToClass', $class->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">Pilih Siswa</label>
                <select name="user_id" id="user_id" class="form-control">
                    @foreach($users->where('role', 'siswa') as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Tambah Siswa</button>
        </form>
    </div>
</div>
@endsection