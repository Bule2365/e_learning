@extends('guru.layouts.app')

@section('content')
<h1>Daftar Ujian</h1>

<!-- Display success message -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($exams->isEmpty())
<p>Belum ada ujian untuk mata pelajaran yang Anda ajar.</p>
@else

<!-- Tabel Daftar Ujian -->
<table class="table mt-3">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Mata Pelajaran</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($exams as $exam)
        <tr>
            <td>{{ $exam->title }}</td>
            <td>{{ $exam->description }}</td>
            <!-- Menampilkan nama mata pelajaran -->
            <td>{{ $exam->mataPelajaran->name }}</td>
            <td>{{ ucfirst($exam->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection