

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <a href="<?php echo e(route('guru.exams.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>

        <h1>Nilai Siswa untuk Ujian: <?php echo e($exam->title); ?></h1>
        <a href="<?php echo e(route('guru.exams.export', $exam->id)); ?>" class="btn btn-success mb-3">
            <i class="bi bi-file-earmark-excel"></i> Export ke Excel
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nilai</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Durasi Pengerjaan</th> <!-- Kolom baru untuk durasi dalam format jam, menit, detik -->
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $examAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($attempt->user->name); ?></td>
                        <!-- Mengambil kelas pertama dari koleksi kelas -->
                        <td><?php echo e($attempt->user->kelas->first()->name ?? 'Tidak Ditemukan'); ?></td>
                        <td><?php echo e($attempt->score); ?></td>
                        <td><?php echo e($attempt->started_at); ?></td>
                        <td><?php echo e($attempt->submitted_at); ?></td>
                        <!-- Durasi Waktu dalam Jam:Menit:Detik -->
                        <td>
                            <?php if($attempt->started_at && $attempt->submitted_at): ?>
                                <?php
                                    // Menghitung perbedaan waktu dalam detik
                                    $diffInSeconds = $attempt->started_at->diffInSeconds($attempt->submitted_at);

                                    // Menghitung jam, menit, dan detik
                                    $hours = floor($diffInSeconds / 3600);
                                    $minutes = floor(($diffInSeconds % 3600) / 60);
                                    $seconds = $diffInSeconds % 60;
                                ?>

                                <!-- Menampilkan durasi dalam format jam:menit:detik -->
                                <?php echo e(sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)); ?>

                            <?php else: ?>
                                Tidak tersedia
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/scores.blade.php ENDPATH**/ ?>