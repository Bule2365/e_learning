

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Grid utama (Video + Rekomendasi) -->
        <div class="row">
            <!-- Kolom utama (Video & Deskripsi) -->
            <div class="col-lg-8">
                <!-- Tombol Kembali -->
                <a href="<?php echo e(route('siswa.material.list', ['subject_id' => $material->subject_id])); ?>"
                    class="btn btn-secondary mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Materi
                </a>

                <!-- Judul Materi -->
                <h2 class="mb-3"><?php echo e($material->title); ?></h2>

                <!-- Media (Video/Gambar/PDF) -->
                <?php if(!empty($material->file_paths)): ?>
                    <?php $__currentLoopData = $material->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                        ?>

                        <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                            <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($material->title); ?>"
                                class="img-fluid rounded mb-3">
                        <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                            <div class="ratio ratio-16x9 mb-3">
                                <video controls class="w-100">
                                    <source src="<?php echo e(Storage::url($filePath)); ?>" type="video/<?php echo e($extension); ?>">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php elseif($extension == 'pdf'): ?>
                            <iframe src="<?php echo e(Storage::url($filePath)); ?>" width="100%" height="500px"
                                class="mb-3"></iframe>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">Tidak ada file materi yang tersedia.</p>
                <?php endif; ?>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <h5>Deskripsi:</h5>
                    <?php
                        $deskripsiPenuh = $material->description ?? 'Tidak ada deskripsi yang tersedia.';
                        $deskripsiPendek = implode(' ', array_slice(explode(' ', strip_tags($deskripsiPenuh)), 0, 10));
                    ?>

                    <p class="text-muted" id="deskripsi-<?php echo e($material->id); ?>">
                        <?php echo nl2br(e($deskripsiPendek)); ?>...
                        <?php if(str_word_count($deskripsiPenuh) > 10): ?>
                            <a href="javascript:void(0);" onclick="tampilkanDeskripsi(<?php echo e($material->id); ?>)"
                                class="text-primary" id="lihat-selengkapnya-<?php echo e($material->id); ?>">
                                Lihat Selengkapnya
                            </a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Sidebar Rekomendasi (Seperti YouTube) -->
            <div class="col-lg-4">
                <h4 class="mb-3">Materi Rekomendasi</h4>

                <?php if($recommendedMaterials->isEmpty()): ?>
                    <p class="text-muted">Belum ada rekomendasi materi.</p>
                <?php else: ?>
                    <?php $__currentLoopData = $recommendedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recMaterial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex mb-3 border-bottom pb-2">
                            <?php if(!empty($recMaterial->file_paths)): ?>
                                <?php $__currentLoopData = $recMaterial->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    ?>

                                    <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($recMaterial->title); ?>"
                                            class="img-fluid rounded"
                                            style="width: 120px; height: 80px; object-fit: cover;">
                                    <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                        <div class="ratio ratio-16x9" style="width: 120px; height: 80px;">
                                            <video class="w-100">
                                                <source src="<?php echo e(Storage::url($filePath)); ?>"
                                                    type="video/<?php echo e($extension); ?>">
                                            </video>
                                        </div>
                                    <?php endif; ?>
                                <?php break; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <a href="<?php echo e(route('siswa.material.detail', $recMaterial->id)); ?>">
                            <div class="ms-3">
                                <h6>
                                    <div class="text-decoration-none text-dark">
                                        <?php echo e(Str::limit($recMaterial->title, 50, '...')); ?>

                                        <p class="text-muted small">
                                            <?php echo e(Str::limit($recMaterial->description, 80, '...')); ?>

                                        </p>
                                    </div>
                                </h6>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function tampilkanDeskripsi(id) {
        const fullDescription = `<?php echo nl2br(e($material->description)); ?>`;
        document.getElementById(`deskripsi-${id}`).innerHTML = fullDescription;
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/detail.blade.php ENDPATH**/ ?>