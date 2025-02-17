@extends('guru.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Improved Typography */
            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                line-height: 1.3;
                color: #1a237e;
            }

            .card-subtitle {
                font-size: 0.9rem;
                color: #546e7a;
                letter-spacing: 0.03em;
            }

            .exam-description {
                font-size: 0.95rem;
                color: #455a64;
                line-height: 1.6;
                white-space: pre-line;
                margin-bottom: 1.5rem;
            }

            /* Responsive Card Design */
            .exam-card {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.08);
                border-radius: 12px;
                overflow: hidden;
            }

            .exam-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            /* Status Badge */
            .status-badge {
                font-size: 0.8rem;
                padding: 0.35rem 0.75rem;
                border-radius: 20px;
                font-weight: 500;
            }

            /* Responsive Button Group */
            .action-buttons {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
                margin-top: 1.25rem;
            }

            .action-buttons .btn {
                flex: 1 1 auto;
                min-width: 140px;
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                border-radius: 8px;
                transition: all 0.2s ease;
            }

            /* Mobile Optimization */
            @media (max-width: 768px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .exam-card {
                    margin-bottom: 1rem;
                }

                .card-title {
                    font-size: 1.1rem;
                }

                .card-subtitle {
                    font-size: 0.85rem;
                }

                .action-buttons .btn {
                    flex: 1 1 100%;
                    min-width: 100%;
                }
            }
        </style>
    @endpush

    <div class="container-lg my-4 my-lg-5">
        <div class="text-center mb-4 mb-lg-5">
            <h1 class="h2 fw-bold text-primary mb-3">Daftar Ujian</h1>
            <p class="lead text-muted">Kelola ujian untuk kelas yang Anda ajar</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($exams->isEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center py-5">
                <div class="alert alert-info w-100 text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada ujian untuk mata pelajaran yang Anda ajar
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach ($exams as $exam)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="exam-card h-100">
                            <div class="card-body p-3 p-lg-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h3 class="card-title mb-1">{{ $exam->title }}</h3>
                                        <div class="card-subtitle mb-2">
                                            <span class="d-block">{{ $exam->kelas->name }}</span>
                                            <span class="d-block">{{ $exam->mataPelajaran->name }}</span>
                                        </div>
                                    </div>
                                    <span
                                        class="status-badge bg-{{ $exam->status == 'active' ? 'success' : 'warning' }} text-white">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </div>

                                @if ($exam->description)
                                    <div class="exam-description bg-light p-3 rounded-2 mb-3">
                                        {{ $exam->description }}
                                    </div>
                                @endif

                                <div class="action-buttons">
                                    <a href="{{ route('guru.exams.show', $exam->id) }}"
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-eye me-2"></i>Detail
                                    </a>
                                    <a href="{{ route('guru.exams.add_questions', $exam->id) }}"
                                        class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Soal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
