

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Tombol Kembali ke Daftar Materi -->
        <a href="<?php echo e(route('siswa.material.list', ['subject_id' => $material->subject_id])); ?>" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Materi
        </a>

        <h2 class="my-4"><?php echo e($material->title); ?></h2>

        <!-- Tampilkan materi sesuai tipe -->
        <?php if(!empty($material->file_paths)): ?>
            <?php $__currentLoopData = $material->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                ?>

                <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                    <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($material->title); ?>" class="img-fluid rounded mb-3">
                <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                    <div class="ratio ratio-16x9 mb-3">
                        <video controls>
                            <source src="<?php echo e(Storage::url($filePath)); ?>" type="video/<?php echo e($extension); ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php elseif($extension == 'pdf'): ?>
                    <iframe src="<?php echo e(Storage::url($filePath)); ?>" width="100%" height="500px" class="mb-3"></iframe>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p class="text-muted">Tidak ada file materi yang tersedia.</p>
        <?php endif; ?>

        <!-- Tombol Download Semua File -->
        <?php if(!empty($material->file_paths)): ?>
            <div class="mt-3">
                <h5>Download Materi:</h5>
                <?php $__currentLoopData = $material->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(Storage::url($filePath)); ?>" download class="btn btn-primary me-2 mb-2">
                        <i class="bi bi-download"></i> Unduh <?php echo e(basename($filePath)); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <h3 class="mt-5">Rekomendasi Materi</h3>
        <div class="row">
            <?php if($recommendedMaterials->isEmpty()): ?>
                <p class="text-muted">Belum ada rekomendasi materi.</p>
            <?php else: ?>
                <?php $__currentLoopData = $recommendedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recMaterial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo e(route('siswa.material.detail', $recMaterial->id)); ?>"
                                        class="text-decoration-none text-dark">
                                        <?php echo e($recMaterial->title); ?>

                                    </a>
                                </h5>

                                <!-- Tampilkan file sesuai tipe -->
                                <?php if(!empty($recMaterial->file_paths)): ?>
                                    <?php $__currentLoopData = $recMaterial->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        ?>

                                        <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                            <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($recMaterial->title); ?>"
                                                class="img-fluid rounded mb-2">
                                        <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                            <div class="ratio ratio-16x9 mb-2">
                                                <video controls>
                                                    <source src="<?php echo e(Storage::url($filePath)); ?>"
                                                        type="video/<?php echo e($extension); ?>">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        <?php elseif($extension == 'pdf'): ?>
                                            <iframe src="<?php echo e(Storage::url($filePath)); ?>" width="100%" height="200px"
                                                class="mb-2"></iframe>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/detail.blade.php ENDPATH**/ ?>