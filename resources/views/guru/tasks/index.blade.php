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

            .task-description {
                font-size: 0.95rem;
                color: #455a64;
                line-height: 1.6;
                white-space: pre-line;
                margin-bottom: 1.5rem;
            }

            /* Responsive Card Design */
            .task-card {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.08);
                border-radius: 12px;
                overflow: hidden;
            }

            .task-card:hover {
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

                .task-card {
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
            <h1 class="h2 fw-bold text-primary mb-3">Daftar Tugas</h1>
            <p class="lead text-muted">Kelola tugas untuk kelas yang Anda ajar</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($tasks->isEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center py-5">
                <div class="alert alert-info w-100 text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada tugas yang tersedia.
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach ($tasks->sortByDesc('created_at') as $task)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="task-card h-100">
                            <div class="card-body p-3 p-lg-4">
                                <h3 class="card-title mb-1">{{ $task->title }}</h3>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $task->mataPelajaran->name }}</h6>
                                <p class="task-description">Deadline:
                                    <strong>{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</strong></p>
                                <div class="action-buttons">
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-eye me-2"></i> Lihat Tugas
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
