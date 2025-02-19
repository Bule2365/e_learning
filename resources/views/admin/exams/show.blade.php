@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Detail Ujian Siswa</h1>

        <div class="card">
            <div class="card-body">
                <h4>Nama Siswa: {{ $examAttempt->user->name }}</h4>
                <h5>Nama Ujian: {{ $examAttempt->exam->title }}</h5>
                <p><strong>Waktu Mulai:</strong> {{ $examAttempt->started_at }}</p>
                <p><strong>Waktu Selesai:</strong> {{ $examAttempt->submitted_at ?? 'Belum selesai' }}</p>
                <p><strong>Nilai:</strong> {{ $examAttempt->score ?? 'Belum dinilai' }}</p>
            </div>
        </div>

        <h3 class="mt-4">Jawaban Siswa</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examAttempt->upayaUjian as $key => $answer)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $answer->soal->question_text }}</td>
                        <td>{{ $answer->answer }}</td>
                        <td>
                            @if ($answer->is_correct)
                                <span class="badge bg-success">Benar</span>
                            @else
                                <span class="badge bg-danger">Salah</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
