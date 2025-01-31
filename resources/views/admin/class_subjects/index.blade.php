@extends('admin.layouts.app')

@section('content')
<h1>Daftar Relasi Kelas dan Mata Pelajaran</h1>

<table class="table">
    <thead>
        <tr>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classSubjects as $classSubject)
        <tr>
            <td>{{ $classSubject->class->name }}</td>
            <td>{{ $classSubject->subject->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection