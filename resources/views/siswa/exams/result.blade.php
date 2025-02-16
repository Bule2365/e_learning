@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Hasil Ujian: {{ $attempt->exam->title }}</h2>
    <p><strong>Mata Pelajaran:</strong> {{ $attempt->exam->mataPelajaran->name }}</p>
    <p><strong>Nilai Akhir:</strong> {{ $attempt->score ?? 'Belum dinilai' }}</p>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban Anda</th>
                    <th>Benar/Salah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attempt->answers as $index => $answer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $answer->question->question_text }}</td>
                    <td>{{ $answer->answer }}</td>
                    <td>
                        @if($answer->is_correct === null)
                            <span class="badge bg-warning">Belum Dinilai</span>
                        @elseif($answer->is_correct)
                            <span class="badge bg-success">Benar</span>
                        @else
                            <span class="badge bg-danger">Salah</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('siswa.exams.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Ujian</a>
</div>
@endsection
