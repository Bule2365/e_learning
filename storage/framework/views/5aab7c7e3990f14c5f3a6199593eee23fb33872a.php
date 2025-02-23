

<?php $__env->startPush('styles'); ?>
    <style>
        .hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Ujian di Kelas <?php echo e($class->name); ?></h2>
            <a href="<?php echo e(route('admin.exams.index')); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali Ke Daftar Kelas</a>
        </div>

        <div class="row">
            <?php $__currentLoopData = $class->ujian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <a href="<?php echo e(route('admin.exams.studentsByExam', $exam->id)); ?>" class="text-decoration-none">
                        <div class="card shadow-lg border-0 rounded-3 hover-effect">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0"><?php echo e($exam->title); ?></h5>
                                    <p class="text-muted small">Klik untuk melihat siswa</p>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-right-circle text-primary fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/exams/exams_by_class.blade.php ENDPATH**/ ?>