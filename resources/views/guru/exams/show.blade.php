@extends('guru.layouts.app')

@section('content')
    <div class="container my-5">
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
                <p class="lead"><strong>Kelas:</strong> {{ $exam->kelas->name }}</p>
                <p class="lead"><strong>Mata Pelajaran:</strong> {{ $exam->mataPelajaran->name }}</p>
                <p class="lead"><strong>Jumlah Soal:</strong> {{ $exam->soal->count() }}</p>
                <p class="lead"><strong>Tanggal Ujian:</strong>
                    {{ \Carbon\Carbon::parse($exam->tanggal)->format('d M Y') }}</p>
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
                @if ($exam->soal->isEmpty())
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-circle"></i> Belum ada soal yang ditambahkan.
                    </div>
                @else
                    <div class="list-group">
                        @foreach ($exam->soal as $soal)
                            <div class="list-group-item d-flex justify-content-between align-items-start soal-item"
                                id="soal-{{ $soal->id }}">
                                <div class="flex-grow-1">
                                    <h5>{{ $loop->iteration }}</h5>

                                    {{-- Edit Gambar --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        @if ($soal->image_path)
                                            <!-- Gambar soal sudah ada, bisa diklik untuk mengedit -->
                                            <a href="{{ route('guru.exams.image', $soal->id) }}">
                                                <img src="{{ asset('storage/' . $soal->image_path) }}" alt="Gambar Soal"
                                                    class="img-fluid" style="max-width: 300px;" />
                                            </a>
                                        @else
                                            <!-- Jika soal belum ada gambar, tampilkan tombol untuk menambah gambar -->
                                            <a href="{{ route('guru.exams.image', $soal->id) }}"
                                                class="btn btn-primary">Tambah Gambar</a>
                                        @endif
                                    </div>

                                    <!-- Edit Soal -->
                                    <input type="text" class="form-control soal-text mb-2" data-id="{{ $soal->id }}"
                                        value="{{ $soal->question_text }}" placeholder="Tulis soal di sini..." />

                                    <!-- Pilihan Ganda -->
                                    @if ($soal->type === 'multiple_choice')
                                        @php
                                            $options = json_decode($soal->options, true);
                                        @endphp
                                        <ul class="list-unstyled mt-2">
                                            @foreach ($options as $key => $option)
                                                <li class="mb-2">
                                                    <strong>{{ $key }}:</strong>
                                                    <input type="text" class="form-control option-text"
                                                        data-id="{{ $soal->id }}" data-key="{{ $key }}"
                                                        value="{{ $option }}"
                                                        placeholder="Tulis pilihan jawaban di sini..." />
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p class="text-success">
                                            <strong>Jawaban Benar:</strong>
                                            <input type="text" class="form-control correct-answer"
                                                data-id="{{ $soal->id }}" value="{{ $soal->correct_answer }}"
                                                placeholder="Tulis jawaban benar di sini..." />
                                        </p>
                                    @endif
                                </div>

                                <!-- Hapus Soal -->
                                <button class="btn btn-danger btn-sm delete-question" data-id="{{ $soal->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Edit Soal
            document.querySelectorAll(".soal-text").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let newText = this.value;

                    fetch(`/questions/update/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            question_text: newText,
                        })
                    });
                });
            });

            // Edit Opsi Jawaban
            document.querySelectorAll(".option-text").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let optionKey = this.getAttribute("data-key");
                    let newText = this.value;

                    fetch(`/questions/update-option/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            key: optionKey,
                            value: newText
                        })
                    });
                });
            });

            // Edit Jawaban Benar
            document.querySelectorAll(".correct-answer").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let newText = this.value;

                    fetch(`/questions/update-correct-answer/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            correct_answer: newText
                        })
                    });
                });
            });

            // Hapus Soal
            document.querySelectorAll(".delete-question").forEach(button => {
                button.addEventListener("click", function() {
                    let soalId = this.getAttribute("data-id");

                    fetch(`/questions/delete/${soalId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            document.getElementById(`soal-${soalId}`).remove();
                        }
                    });
                });
            });
        });
    </script>

@endsection
