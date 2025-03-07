

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center mb-4">Daftar Ujian</h2>

        <div class="row">
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Mendapatkan upaya ujian untuk pengguna yang sedang login
                    $attempt = $exam
                        ->upayaUjian()
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->first();
                ?>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($exam->title); ?></h5>
                            <p class="text-muted"><?php echo e($exam->description); ?></p>

                            <?php if($attempt && $attempt->submitted_at): ?>
                                <p><strong>Nilai Anda: <?php echo e($attempt->score); ?></strong></p>
                                <?php if($attempt->score < 75): ?>
                                    <a href="<?php echo e(route('siswa.exams.remedial', $exam->id)); ?>"
                                        class="btn btn-warning btn-block">
                                        Remedial Ujian
                                    </a>
                                <?php else: ?>
                                    <p class="text-success">Lulus</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('siswa.exams.start', $exam->id)); ?>" class="btn btn-primary btn-block">
                                    Mulai Ujian
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/index.blade.php ENDPATH**/ ?>