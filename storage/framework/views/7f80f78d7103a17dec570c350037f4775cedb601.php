

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="mb-4">Detail Ujian Siswa</h1>

        <div class="card">
            <div class="card-body">
                <h4>Nama Siswa: <?php echo e($examAttempt->user->name); ?></h4>
                <h5>Nama Ujian: <?php echo e($examAttempt->exam->title); ?></h5>
                <p><strong>Waktu Mulai:</strong> <?php echo e($examAttempt->started_at); ?></p>
                <p><strong>Waktu Selesai:</strong> <?php echo e($examAttempt->submitted_at ?? 'Belum selesai'); ?></p>
                <p><strong>Nilai:</strong> <?php echo e($examAttempt->score ?? 'Belum dinilai'); ?></p>
            </div>
        </div>

        <h3 class="mt-4">Jawaban Siswa</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $examAttempt->upayaUjian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($answer->soal->question_text); ?></td>
                        <td><?php echo e($answer->answer); ?></td>
                        <td>
                            <?php if($answer->is_correct): ?>
                                <span class="badge bg-success">Benar</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Salah</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <a href="<?php echo e(route('admin.exams.index')); ?>" class="btn btn-secondary mt-3">Kembali</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/exams/show.blade.php ENDPATH**/ ?>