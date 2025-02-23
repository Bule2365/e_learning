@extends('guru.layouts.app')

@section('content')
    @push('styles')
        <style>
            .form-section {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                margin: 1.5rem 0;
                transition: all 0.3s ease;
            }

            .form-toggle-btn {
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                transition: all 0.3s ease;
                min-width: 200px;
                border: 2px solid transparent;
            }

            .form-toggle-btn.active {
                background: #0d6efd;
                color: white;
                border-color: #0a58ca;
                transform: translateY(-2px);
            }

            .question-type-badge {
                font-size: 0.8rem;
                padding: 0.3rem 0.7rem;
                border-radius: 6px;
            }

            .dynamic-form-section {
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .file-upload-box {
                border: 2px dashed #dee2e6;
                border-radius: 8px;
                padding: 2rem;
                text-align: center;
                background: white;
                cursor: pointer;
            }

            .file-upload-box:hover {
                border-color: #0d6efd;
                background: #f8fbff;
            }

            @media (max-width: 768px) {
                .form-toggle-container {
                    flex-direction: column;
                    gap: 1rem;
                }

                .form-toggle-btn {
                    width: 100%;
                }
            }
        </style>
    @endpush

    <a href="{{ route('guru.exams.index') }}" class="btn btn-primary mb-3">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Daftar Ujian</span>
    </a>
    <div class="container-lg py-4 py-lg-5">
        <div class="text-center mb-4 mb-lg-5">
            <h1 class="h2 fw-bold text-primary mb-3">Tambah Soal Ujian</h1>
            <p class="lead text-muted">Kelas: {{ $exam->kelas->name }} | Mata Pelajaran: {{ $exam->mataPelajaran->name }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Toggle Buttons -->
                <div class="d-flex form-toggle-container justify-content-center mb-4">
                    <button id="manual-btn" class="btn form-toggle-btn active">
                        <i class="bi bi-pencil-square me-2"></i>Input Manual
                    </button>
                    <button id="upload-btn" class="btn form-toggle-btn">
                        <i class="bi bi-upload me-2"></i>Upload File
                    </button>
                </div>

                <!-- Manual Form -->
                <div id="manual-form" class="form-section">
                    <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Teks Pertanyaan</label>
                            <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text"
                                rows="4" placeholder="Masukkan pertanyaan lengkap disini..." required>{{ old('question_text') }}</textarea>
                            @error('question_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-semibold">Tambahkan Gambar</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jenis Soal</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>
                                    Pilihan Ganda
                                </option>
                                <option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>
                                    Essay
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="options-section" class="dynamic-form-section">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-semibold">Opsi Jawaban</label>
                                    <span class="question-type-badge bg-primary text-white">Pilihan Ganda</span>
                                </div>

                                <div class="row g-3">
                                    @foreach (['A', 'B', 'C', 'D'] as $option)
                                        <div class="col-12 col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $option }}.</span>
                                                <input type="text"
                                                    class="form-control @error('options.' . $option) is-invalid @enderror"
                                                    name="options[{{ $option }}]"
                                                    placeholder="Pilihan {{ $option }}"
                                                    value="{{ old('options.' . $option) }}">
                                                @error('options.' . $option)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Jawaban Benar</label>
                                <select class="form-select @error('correct_answer') is-invalid @enderror"
                                    name="correct_answer">
                                    <option value="">Pilih Jawaban Benar</option>
                                    @foreach (['A', 'B', 'C', 'D'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old('correct_answer') == $option ? 'selected' : '' }}>
                                            Pilihan {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('correct_answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Simpan Soal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Upload Form -->
                <div id="upload-form" class="form-section" style="display: none;">
                    <form action="{{ route('guru.exams.store_questions', $exam->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Upload File Soal</label>
                            <div class="file-upload-box" onclick="document.getElementById('file-input').click()">
                                <div class="mb-3">
                                    <i class="bi bi-file-earmark-arrow-up fs-1 text-muted"></i>
                                </div>
                                <p class="text-muted mb-2">Klik untuk memilih file</p>
                                <small class="text-muted">Format yang didukung: .docx, .xlsx</small>
                                <input type="file" class="form-control visually-hidden" id="file-input" name="file"
                                    accept=".docx, .xlsx" required>
                            </div>
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Pastikan format file sesuai dengan template yang telah ditentukan
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-upload me-2"></i>Upload File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle Form Visibility
            const toggleForms = (activeForm) => {
                document.querySelectorAll('.form-toggle-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.getElementById(`${activeForm}-btn`).classList.add('active');

                document.querySelectorAll('.form-section').forEach(form => {
                    form.style.display = 'none';
                });
                document.getElementById(`${activeForm}-form`).style.display = 'block';
            };

            document.getElementById('manual-btn').addEventListener('click', () => toggleForms('manual'));
            document.getElementById('upload-btn').addEventListener('click', () => toggleForms('upload'));

            // Dynamic Form Handling
            const typeSelect = document.getElementById('type');
            const optionsSection = document.getElementById('options-section');

            const toggleOptions = () => {
                const isMultipleChoice = typeSelect.value === 'multiple_choice';
                optionsSection.style.maxHeight = isMultipleChoice ? `${optionsSection.scrollHeight}px` : '0';
                optionsSection.style.opacity = isMultipleChoice ? '1' : '0';
            };

            typeSelect.addEventListener('change', toggleOptions);

            // Initial check
            toggleOptions();
        </script>
    @endpush
@endsection
