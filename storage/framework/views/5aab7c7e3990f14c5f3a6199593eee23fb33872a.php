
<?php $__env->startPush('styles'); ?>
    <style>
        .hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-custom {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: none;
            border-radius: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .bi-arrow-right-circle {
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .hover-effect:hover .bi-arrow-right-circle {
            transform: translateX(5px);
            color: #0d6efd;
        }

        .no-data {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Ujian di Kelas <?php echo e($class->name); ?></h2>
            <a href="<?php echo e(route('admin.exams.index')); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali Ke Daftar Kelas
            </a>
        </div>

        <?php if($class->ujian->isEmpty()): ?>
            <div class="no-data">
                Belum ada ujian tersedia di kelas ini.
            </div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $class->ujian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <a href="<?php echo e(route('admin.exams.studentsByExam', $exam->id)); ?>" class="text-decoration-none">
                            <div class="card card-custom shadow-lg hover-effect">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1"><?php echo e($exam->title); ?></h5>
                                        <p class="text-muted small mb-0">Klik untuk melihat siswa</p>
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
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/exams/exams_by_class.blade.php ENDPATH**/ ?>