@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Siswa yang Mengikuti Ujian</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Nama Ujian</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examAttempts as $key => $attempt)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $attempt->user->name }}</td>
                        <td>{{ $attempt->exam->title }}</td>
                        <td>{{ $attempt->started_at }}</td>
                        <td>{{ $attempt->submitted_at ?? 'Belum selesai' }}</td>
                        <td>{{ $attempt->score ?? 'Belum dinilai' }}</td>
                        <td>
                            <a href="{{ route('admin.exams.show', $attempt->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
