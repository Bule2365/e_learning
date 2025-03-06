@extends('guru.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Typography Enhancements */
            .card-title {
                font-size: 1.3rem;
                font-weight: 700;
                color: #1a237e;
            }

            .card-subtitle {
                font-size: 0.95rem;
                color: #546e7a;
            }

            .exam-description {
                font-size: 1rem;
                color: #37474f;
                line-height: 1.5;
                margin-bottom: 1.5rem;
            }

            /* Exam Card Design */
            .exam-card {
                transition: all 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
                background: white;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                border: none;
            }

            .exam-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            /* Status Badge */
            .status-badge {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-weight: 500;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-top: 1rem;
            }

            .action-buttons .btn {
                flex: 1 1 auto;
                padding: 0.6rem 1rem;
                border-radius: 8px;
                font-size: 0.9rem;
                transition: all 0.2s ease;
            }

            .action-buttons .btn:hover {
                transform: translateY(-2px);
            }

            /* Modal Styling */
            .modal-content {
                border-radius: 12px;
            }

            .modal-header {
                background: #ff6f61;
                color: white;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            .modal-footer button {
                min-width: 100px;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .exam-card {
                    margin-bottom: 1rem;
                }

                .action-buttons .btn {
                    flex: 1 1 100%;
                }
            }
        </style>
    @endpush

    <div class="container-lg my-4 my-lg-5">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold text-primary">Daftar Ujian</h1>
            <p class="lead text-muted">Kelola ujian untuk kelas Anda dengan mudah.</p>
        </div>

        @if ($exams->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada ujian yang tersedia.
            </div>
        @else
            <div class="row g-4">
                @foreach ($exams as $exam)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="exam-card card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h3 class="card-title mb-1">{{ $exam->title }}</h3>
                                        <p class="card-subtitle">{{ $exam->kelas->name }} - {{ $exam->mataPelajaran->name }}
                                        </p>
                                    </div>
                                    <span
                                        class="status-badge bg-{{ $exam->status == 'active' ? 'success' : 'warning' }} text-white">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </div>

                                <div class="action-buttons">
                                    <a href="{{ route('guru.exams.show', $exam->id) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i> Detail
                                    </a>
                                    <a href="{{ route('guru.exams.add_questions', $exam->id) }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Tambah Soal
                                    </a>
                                    <a href="{{ route('guru.exams.edit', $exam->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                    </a>
                                    <a href="{{ route('guru.exams.scores', $exam->id) }}" class="btn btn-info">
                                        <i class="bi bi-bar-chart-line me-2"></i> Lihat Nilai Siswa
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        onclick="setDeleteForm('{{ route('guru.exams.destroy', $exam->id) }}')">
                                        <i class="bi bi-trash me-2"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel"><i class="bi bi-exclamation-triangle"></i>
                        Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus ujian ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function setDeleteForm(action) {
                document.getElementById('deleteForm').setAttribute('action', action);
            }
        </script>
    @endpush
@endsection
