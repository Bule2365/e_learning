@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Daftar Mata Pelajaran</h1>

        <div class="col-12 col-mb-4">
            <a href="{{ route('subjects.create') }}" class="btn btn-success w-100 btn-lg" data-bs-toggle="tooltip"
                title="Tambah Pengguna Baru">
                <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Mata Pelajaran</span>
            </a>
        </div>

        @if ($subjects->isEmpty())
            <div class="alert alert-info mt-4" role="alert">
                Belum ada mata pelajaran yang diajarkan.
            </div>
        @else
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">#</th>
                            <th scope="col" style="width: 35%">Nama Mata Pelajaran</th>
                            <th scope="col" style="width: 35%">Pengajar</th>
                            <th scope="col" class="text-center" style="width: 25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->guru->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('subjects.edit', $subject->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
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
