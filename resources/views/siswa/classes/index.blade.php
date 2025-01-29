@extends('siswa.layouts.app')

@section('content')
<h1>Daftar Kelas</h1>

@if($classes->isEmpty())
<p>Tidak ada kelas yang tersedia.</p>
@else
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kelas</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $index => $class)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $class->name }}</td>
            <td>{{ $class->deskripsi }}</td>
            <td>
                <form action="{{ route('siswa.classes.join', $class->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Bergabung</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection