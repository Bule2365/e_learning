

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
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

            .card-body p {
                font-size: 1rem;
                color: #455a64;
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            /* Responsive Card Design */
            .material-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .material-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            /* Card Header */
            .card-header {
                background-color: #007bff;
                color: white;
                padding: 1.25rem;
            }

            /* Button Group */
            .action-buttons .btn {
                flex: 1 1 auto;
                min-width: 140px;
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .action-buttons .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            /* Layout and Spacing */
            .container {
                padding-top: 4rem;
                padding-bottom: 4rem;
            }

            /* Mobile Optimization */
            @media (max-width: 768px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .material-card {
                    margin-bottom: 1.5rem;
                }

                .card-title {
                    font-size: 1.1rem;
                }

                .card-body p {
                    font-size: 0.95rem;
                }

                .action-buttons .btn {
                    flex: 1 1 100%;
                    min-width: 100%;
                    padding: 0.75rem;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="container-lg my-4 my-lg-5">
        <div class="text-center mb-4 mb-lg-5">
            <h1 class="h2 fw-bold text-primary mb-3">Daftar Materi</h1>
            <p class="lead text-muted">Kelola materi untuk kelas yang Anda ajar dengan mudah.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="task-card h-100">
                    <h3 class="card-title mb-1"><?php echo e($material->title); ?></h3>
                    <div class="card-body">
                        <p><strong>Deskripsi:</strong> <?php echo e($material->description); ?></p>
                        <p><strong>Mata Pelajaran:</strong> <?php echo e(optional($material->subject)->name); ?></p>
                        <p><strong>Kelas:</strong> <?php echo e(optional($material->ClassModel)->name); ?></p>

                        <div class="action-buttons">
                            <a href="<?php echo e(route('guru.materials.show', $material->id)); ?>" class="btn btn-info mt-3">
                                <i class="bi bi-eye me-2"></i> Lihat Materi
                            </a>
                            <a href="<?php echo e(route('guru.materials.edit', $material->id)); ?>" class="btn btn-warning mt-3">
                                <i class="bi bi-pencil-square me-2"></i> Edit
                            </a>
                            <form action="<?php echo e(route('guru.materials.destroy', $material->id)); ?>" method="POST"
                                style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger mt-3"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                    <i class="bi bi-trash me-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/index.blade.php ENDPATH**/ ?>