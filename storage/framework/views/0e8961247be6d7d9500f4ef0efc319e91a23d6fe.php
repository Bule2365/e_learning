

<?php $__env->startPush('styles'); ?>
    <style>
        /* Hover effect on cards */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Card body text styling */
        .card-body p {
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1 class="mb-5 text-center text-primary fw-bold">Daftar Kelas Anda</h1>

        <!-- Menggunakan grid system dengan kolom yang responsif -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card shadow-lg rounded-3 border-light transition-transform"
                        style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h5 class="card-title text-center mb-0"><?php echo e($class->name); ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Deskripsi:</strong> <?php echo e($class->deskripsi); ?></p>

                            <p class="card-text"><strong>Daftar Siswa yang Bergabung:</strong></p>
                            <?php if($class->siswa->isEmpty()): ?>
                                <p class="text-muted">Belum ada siswa yang bergabung.</p>
                            <?php else: ?>
                                <ul class="list-unstyled">
                                    <?php $__currentLoopData = $class->siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $murid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($murid->name); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>

                            <div class="d-grid gap-2 mt-3">
                                <!-- Link untuk buat ujian -->
                                <a href="<?php echo e(route('guru.exams.create', ['class_id' => $class->id])); ?>"
                                    class="btn btn-primary">
                                    <i class="bi bi-file-plus-fill"></i> Buat Ujian
                                </a>

                                <!-- Link untuk buat tugas -->
                                <a href="<?php echo e(route('tasks.create', ['class_id' => $class->id])); ?>" class="btn btn-warning">
                                    <i class="bi bi-clipboard-plus-fill"></i> Buat Tugas
                                </a>

                                <!-- Link untuk buat materi -->
                                <a href="<?php echo e(route('guru.materials.create', ['class_id' => $class->id])); ?>"
                                    class="btn btn-success">
                                    <i class="bi bi-file-earmark-plus-fill"></i> Buat Materi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/classes/index.blade.php ENDPATH**/ ?>