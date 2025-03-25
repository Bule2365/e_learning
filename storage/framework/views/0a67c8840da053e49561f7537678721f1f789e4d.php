

<?php $__env->startSection('content'); ?>
    <!-- Tambahkan Bootstrap 5.4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container my-5">
        <!-- Tombol Kembali -->
        <a href="<?php echo e(route('guru.exams.index')); ?>" class="btn btn-outline-primary mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>

        <!-- Judul Halaman -->
        <h1 class="fw-bold text-primary mb-4 text-center">Nilai Siswa untuk Ujian: <?php echo e($exam->title); ?></h1>

        <!-- Tombol Export -->
        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('guru.exams.export', $exam->id)); ?>" class="btn btn-success d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i> Export ke Excel
            </a>
        </div>

        <!-- Tabel Nilai Siswa -->
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Durasi Pengerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $examAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($attempt->user->name); ?></td>
                                    <td><?php echo e($attempt->user->kelas->first()->name ?? 'Tidak Ditemukan'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($attempt->score >= 70 ? 'success' : 'danger'); ?> fs-6 p-2">
                                            <?php echo e($attempt->score); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($attempt->started_at); ?></td>
                                    <td><?php echo e($attempt->submitted_at); ?></td>
                                    <td>
                                        <?php if($attempt->started_at && $attempt->submitted_at): ?>
                                            <?php
                                                $diffInSeconds = $attempt->started_at->diffInSeconds(
                                                    $attempt->submitted_at,
                                                );
                                                $hours = floor($diffInSeconds / 3600);
                                                $minutes = floor(($diffInSeconds % 3600) / 60);
                                                $seconds = $diffInSeconds % 60;
                                            ?>
                                            <span
                                                class="badge bg-info text-dark"><?php echo e(sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('guru.exams.scores.edit', ['exam' => $exam->id, 'attempt' => $attempt->id])); ?>"
                                            class="btn btn-warning btn-sm d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-pencil-square"></i> Edit Nilai
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/scores.blade.php ENDPATH**/ ?>