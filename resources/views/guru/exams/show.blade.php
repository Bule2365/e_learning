@extends('guru.layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('guru.exams.index') }}" class="btn btn-primary mb-3">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Daftar Ujian</span>
    </a>

    <h1 class="display-4 text-center mb-4">Detail Ujian</h1>

    <!-- Informasi Ujian -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $exam->nama_ujian }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Kelas:</strong> {{ $exam->kelas->name }}</p>
            <p><strong>Mata Pelajaran:</strong> {{ $exam->mataPelajaran->name }}</p>
            <p><strong>Jumlah Soal:</strong> {{ $exam->soal->count() }}</p>
            <p><strong>Tanggal Ujian:</strong> {{ \Carbon\Carbon::parse($exam->tanggal)->format('d M Y') }}</p>
            <a href="{{ route('guru.exams.add_questions', $exam->id) }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Soal
            </a>
        </div>
    </div>

    <!-- Daftar Soal -->
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Daftar Soal</h5>
        </div>
        <div class="card-body">
            @if($exam->soal->isEmpty())
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-circle"></i> Belum ada soal yang ditambahkan.
            </div>
            @else
            <div class="list-group">
                @foreach($exam->soal as $soal)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">#{{ $loop->iteration }} {{ $soal->question_text }}</h6>
                            <small class="text-muted">Tipe: {{ ucfirst($soal->type) }}</small>

                            @if($soal->type === 'multiple_choice' && $soal->options)
                            @php
                            $options = json_decode($soal->options, true); // Decode options from JSON
                            @endphp
                            @if(is_array($options) && count($options) > 0)
                            <ul class="list-unstyled mt-2">
                                @foreach($options as $option)
                                <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                            <p class="text-success"><strong>Jawaban Benar:</strong> {{ $soal->correct_answer }}</p>
                            @else
                            <p class="text-muted">Tidak ada opsi untuk soal ini.</p>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <pre>{{ dd($exam->soal) }}</pre>
            @endif
        </div>
    </div>
</div>
@endsection