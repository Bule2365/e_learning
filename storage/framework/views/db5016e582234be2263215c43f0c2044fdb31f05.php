

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            /* Typography Improvements */
            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1a237e;
            }

            .task-card {
                transition: all 0.3s ease;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                border: none;
            }

            .task-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            /* Task Status Badge */
            .status-badge {
                font-size: 0.8rem;
                padding: 0.35rem 0.75rem;
                border-radius: 20px;
                font-weight: 500;
            }

            /* Button Group */
            .action-buttons {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
                margin-top: 1rem;
            }

            .action-buttons .btn {
                flex: 1 1 auto;
                min-width: 120px;
                padding: 0.5rem 1rem;
                border-radius: 8px;
                transition: all 0.2s ease;
            }

            .action-buttons .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

            /* Mobile Optimization */
            @media (max-width: 768px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .task-card {
                    margin-bottom: 1rem;
                }

                .action-buttons .btn {
                    flex: 1 1 100%;
                    min-width: 100%;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="container-lg my-4">
        <div class="text-center mb-4">
            <h1 class="h2 fw-bold text-primary">Daftar Tugas</h1>
            <p class="lead text-muted">Kelola tugas untuk kelas Anda dengan mudah.</p>
        </div>

        <?php if($tasks->isEmpty()): ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i> Belum ada tugas yang tersedia.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $tasks->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="task-card card h-100">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo e($task->title); ?></h3>
                                <h6 class="text-muted mb-2"><?php echo e($task->mataPelajaran->name); ?></h6>
                                <p class="text-dark mb-2">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Deadline: <strong><?php echo e(\Carbon\Carbon::parse($task->due_date)->format('d M Y')); ?></strong>
                                </p>

                                <div class="action-buttons">
                                    <a href="<?php echo e(route('tasks.show', $task->id)); ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i> Lihat
                                    </a>
                                    <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil me-2"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-task-id="<?php echo e($task->id); ?>"
                                        data-task-title="<?php echo e($task->title); ?>">
                                        <i class="bi bi-trash me-2"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus tugas <strong id="taskTitle"></strong>? Tindakan ini tidak dapat
                        dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Mengatur data pada modal saat tombol hapus diklik
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Tombol yang diklik
                var taskId = button.getAttribute('data-task-id'); // ID tugas
                var taskTitle = button.getAttribute('data-task-title'); // Judul tugas

                // Update isi modal
                var taskTitleElement = document.getElementById('taskTitle');
                taskTitleElement.textContent = taskTitle;

                // Update action pada form hapus
                var form = document.getElementById('deleteForm');
                form.action = '/tasks/' + taskId;
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/tasks/index.blade.php ENDPATH**/ ?>