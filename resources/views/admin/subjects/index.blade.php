@extends('admin.layouts.app')

@section('content')
<h1>Daftar Mata Pelajaran</h1>

@if ($subjects->isEmpty())
<p>Belum ada mata pelajaran yang diajarkan.</p>
@else
<table class="table">
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
                <!-- Bisa menambahkan tombol aksi, misalnya Edit atau Hapus -->
                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection