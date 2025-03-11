

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center mb-4">Daftar Ujian</h2>

        <div class="row g-4">
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($exam->status !== 'draft'): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo e($exam->title); ?></h5>
                                <p class="text-muted flex-grow-1"><?php echo e($exam->description); ?></p>

                                <?php
                                    $attempt = $exam
                                        ->upayaUjian()
                                        ->where('user_id', auth()->id())
                                        ->latest()
                                        ->first();
                                ?>

                                <?php if($attempt && $attempt->submitted_at): ?>
                                    <p><strong>Nilai Anda: <?php echo e($attempt->score); ?></strong></p>
                                    <?php if($attempt->score < 75): ?>
                                        <a href="<?php echo e(route('siswa.exams.remedial', $exam->id)); ?>"
                                            class="btn btn-warning w-100">
                                            Remedial Ujian
                                        </a>
                                    <?php else: ?>
                                        <p class="text-success">Lulus</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('siswa.exams.preparation', $exam->id)); ?>"
                                        class="btn btn-primary w-100">
                                        Persiapan Ujian
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/index.blade.php ENDPATH**/ ?>