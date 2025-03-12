

<?php $__env->startPush('styles'); ?>
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">📚 Daftar Ujian</h2>

        <div class="row g-4">
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($exam->status !== 'draft'): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-shadow">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold"><?php echo e($exam->title); ?></h5>
                                <p class="text-muted flex-grow-1"><?php echo e(Str::limit($exam->description, 100)); ?></p>

                                <?php
                                    $attempts = $exam
                                        ->upayaUjian()
                                        ->where('user_id', auth()->id())
                                        ->get();
                                    $latestAttempt = $attempts->last();
                                    $totalAttempts = $attempts->count();
                                ?>

                                <?php if($latestAttempt && $latestAttempt->submitted_at): ?>
                                    <p class="fw-bold">🎯 Nilai: <span class="text-success"><?php echo e($latestAttempt->score); ?></span>
                                    </p>

                                    <?php if($latestAttempt->score < 75): ?>
                                        <?php if($totalAttempts < 3): ?>
                                            <a href="<?php echo e(route('siswa.exams.remedial', $exam->id)); ?>"
                                                class="btn btn-warning w-100">
                                                🔄 Remedial (<?php echo e($totalAttempts); ?>/3)
                                            </a>
                                        <?php else: ?>
                                            <p class="text-danger">❌ Maksimal remedial tercapai (3/3)</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-success fw-bold">✅ Lulus</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('siswa.exams.preparation', $exam->id)); ?>"
                                        class="btn btn-primary w-100">
                                        🚀 Persiapan Ujian
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