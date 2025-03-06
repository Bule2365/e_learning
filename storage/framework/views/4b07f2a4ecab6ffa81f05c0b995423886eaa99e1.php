

<?php $__env->startPush('styles'); ?>
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease-in-out;
        }

        .table-primary {
            background-color: #4e73df;
            color: white;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Siswa yang Mengikuti <?php echo e($exam->title); ?></h2>
            <a href="<?php echo e(route('admin.exams.byClass', $exam->class_id)); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $exam->upayaUjian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold text-dark"><?php echo e($attempt->user->name); ?></td>
                            <td><?php echo e($attempt->started_at); ?></td>
                            <td><?php echo e($attempt->submitted_at); ?></td>
                            <td>
                                <span
                                    class="badge <?php echo e($attempt->score >= 75 ? 'bg-success' : ($attempt->score >= 70 ? 'bg-warning' : 'bg-danger')); ?>">
                                    <?php echo e($attempt->score); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/exams/students_by_exam.blade.php ENDPATH**/ ?>