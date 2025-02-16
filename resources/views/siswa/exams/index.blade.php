@extends('siswa.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Ujian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Judul</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->mataPelajaran->name }}</td>
                    <td>
                        <span class="badge bg-{{ $exam->status == 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($exam->status) }}
                        </span>
                    </td>
                    <td>
                        @if($exam->status == 'published')
                            <a href="{{ route('siswa.exams.start', $exam->id) }}" class="btn btn-primary btn-sm">
                                Mulai Ujian
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Belum Tersedia</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
