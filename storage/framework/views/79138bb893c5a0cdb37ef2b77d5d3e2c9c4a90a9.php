

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            .task-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: #1a237e;
                margin-bottom: 1rem;
            }

            .task-description {
                font-size: 1.2rem;
                color: #455a64;
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            .student-card {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                overflow: hidden;
                background-color: #ffffff;
            }

            .student-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            }

            .score-input {
                width: 100%;
            }

            .btn-update {
                width: 100%;
            }

            .alert {
                border-radius: 8px;
            }

            .file-preview {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
                margin-top: 10px;
            }

            @media (max-width: 768px) {
                .task-title {
                    font-size: 1.8rem;
                }

                .task-description {
                    font-size: 1rem;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add smooth hover effect for cards
                const cards = document.querySelectorAll('.student-card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.transform = 'scale(1.02)';
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'scale(1)';
                    });
                });

                // Handle file preview on click
                const fileLinks = document.querySelectorAll('.file-link');
                fileLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.href;
                        Swal.fire({
                            title: 'Pratinjau File',
                            html: `<iframe src="${url}" class="file-preview"></iframe>`,
                            showCloseButton: true,
                            showConfirmButton: false,
                            width: '80%',
                            height: '80%',
                        });
                    });
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

    <div class="container my-5">
        <!-- Back Button -->
        <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Tugas</span>
        </a>

        <!-- Task Details -->
        <h1 class="task-title"><?php echo e($task->title); ?></h1>
        <p class="task-description"><strong>Deskripsi:</strong> <?php echo e($task->description); ?></p>
        <p><strong>Mata Pelajaran:</strong> <?php echo e($task->mataPelajaran->name); ?></p>
        <p><strong>Kelas:</strong> <?php echo e($task->kelas->name); ?></p>
        <p><strong>Tanggal Deadline:</strong> <?php echo e($task->due_date->format('d-m-Y H:i')); ?></p>

        <!-- Student Submissions -->
        <h2 class="mt-4">Siswa yang Mengumpulkan</h2>
        <div class="row">
            <?php $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="student-card shadow-sm h-100 p-3 rounded border">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <!-- Header: Student Name -->
                            <h5 class="card-title mb-3 text-primary fw-semibold"
                                style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; letter-spacing: 0.5px;">
                                <?php echo e($siswa->name); ?>

                            </h5>

                            <!-- Score Section -->
                            <div class="mb-4">
                                <p class="fw-bold text-uppercase text-secondary small mb-2">
                                    Nilai:
                                </p>
                                <form action="<?php echo e(route('tasks.updateScore', ['task' => $task->id, 'user' => $siswa->id])); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="input-group">
                                        <input type="number" name="score" value="<?php echo e($siswa->pivot->score); ?>"
                                            class="form-control score-input" required
                                            <?php if(!$siswa->pivot->submission): ?> disabled <?php endif; ?>>
                                        <button type="submit" class="btn btn-success"
                                            <?php if(!$siswa->pivot->submission): ?> disabled <?php endif; ?>>
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- File Submission Section -->
                            <div>
                                <p class="fw-bold text-uppercase text-secondary small mb-2">
                                    File Jawaban:
                                </p>
                                <?php if($siswa->pivot->submission): ?>
                                    <a href="<?php echo e(asset('storage/' . $siswa->pivot->submission)); ?>" target="_blank"
                                        class="btn btn-info w-100 file-link">
                                        Lihat File
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted d-block">
                                        Tidak ada file
                                    </span>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/tasks/show.blade.php ENDPATH**/ ?>