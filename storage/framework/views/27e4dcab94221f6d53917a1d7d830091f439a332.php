

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            /* Improved Typography */
            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1a237e;
            }

            .material-card {
                transition: all 0.3s ease;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                background: #fff;
                padding: 1.5rem;
            }

            .material-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
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
                .container {
                    padding: 0 1rem;
                }

                .material-card {
                    padding: 1rem;
                }

                .card-title {
                    font-size: 1.1rem;
                }

                .d-flex.gap-2 {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .d-flex.gap-2 .btn {
                    width: 100%;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="container-lg my-4">
        <div class="text-center mb-4">
            <h1 class="h2 fw-bold text-primary">Daftar Materi</h1>
            <p class="lead text-muted">Kelola materi yang Anda ajar dengan mudah.</p>
        </div>

        <?php if($materials->isEmpty()): ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i> Belum ada materi untuk mata pelajaran yang Anda ajar.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="material-card card h-100">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo e($material->title); ?></h3>
                                <p class="text-muted">
                                    <?php echo e(optional($material->ClassModel)->name); ?> -
                                    <?php echo e(optional($material->subject)->name); ?>

                                </p>

                                <!-- Batasi deskripsi hanya 15 kata -->
                                <p>
                                    <?php
                                        $words = explode(' ', $material->description);
                                        $shortDescription =
                                            count($words) > 15
                                                ? implode(' ', array_slice($words, 0, 15)) . '...'
                                                : $material->description;
                                    ?>
                                    <?php echo e($shortDescription); ?>

                                </p>

                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('guru.materials.show', $material->id)); ?>"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i> Lihat
                                    </a>
                                    <a href="<?php echo e(route('guru.materials.edit', $material->id)); ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil me-2"></i> Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        onclick="setDeleteForm('<?php echo e(route('guru.materials.destroy', $material->id)); ?>')">
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
                    <p class="mb-0">Apakah Anda yakin ingin menghapus materi ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
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
            function setDeleteForm(action) {
                document.getElementById('deleteForm').setAttribute('action', action);
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/index.blade.php ENDPATH**/ ?>