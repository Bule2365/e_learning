

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <a href="<?php echo e(route('guru.materials.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>

        <h1 class="mb-4 text-center"><?php echo e($material->title); ?></h1>

        <p><strong>Deskripsi:</strong> <?php echo e($material->description); ?></p>
        <p><strong>Mata Pelajaran:</strong> <?php echo e($material->subject->name); ?></p>
        <p><strong>Kelas:</strong> <?php echo e(optional($material->ClassModel)->name); ?></p>

        <h4 class="mt-5 mb-3">File Materi</h4>

        <div class="row g-4">
            <?php $__currentLoopData = json_decode($material->file_path, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $fileUrl = asset('storage/' . $file);
                ?>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-light rounded-3">
                        <div class="card-body text-center">
                            <?php if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])): ?>
                                <!-- Gambar -->
                                <img src="<?php echo e($fileUrl); ?>" alt="Materi Gambar" class="img-fluid rounded mb-3"
                                    style="max-height: 200px; object-fit: cover;">
                                <p class="mt-2"><?php echo e(ucfirst($fileExtension)); ?> Image</p>
                            <?php elseif(in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'mkv'])): ?>
                                <!-- Video -->
                                <video class="img-fluid rounded mb-3" controls style="max-height: 200px;">
                                    <source src="<?php echo e($fileUrl); ?>" type="video/<?php echo e($fileExtension); ?>">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="mt-2"><?php echo e(ucfirst($fileExtension)); ?> Video</p>
                            <?php else: ?>
                                <!-- Jika bukan gambar atau video, tampilkan link -->
                                <a href="<?php echo e($fileUrl); ?>" class="btn btn-link" target="_blank">Unduh File</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/show.blade.php ENDPATH**/ ?>