

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <a href="<?php echo e(route('guru.materials.index')); ?>" class="btn btn-primary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas
        </a>

        <h1 class="mb-3 text-center"><?php echo e($material->title); ?></h1>

        <p><strong>Mata Pelajaran:</strong> <?php echo e($material->subject->name); ?></p>
        <p><strong>Kelas:</strong> <?php echo e(optional($material->ClassModel)->name); ?></p>

        <div class="mb-4">
            <p><strong>Deskripsi:</strong></p>
            <p class="text-muted" style="white-space: pre-wrap;"><?php echo e($material->description); ?></p>
        </div>


        <h4 class="mt-5 mb-3">File Materi</h4>

        <div class="row g-3">
            <?php $__currentLoopData = json_decode($material->file_path, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $fileUrl = asset('storage/' . $file);
                ?>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-light rounded-3">
                        <div class="card-body text-center">
                            <?php if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])): ?>
                                <img src="<?php echo e($fileUrl); ?>" alt="Materi Gambar" class="img-fluid rounded mb-3"
                                    style="max-height: 200px; object-fit: cover; width: 100%;">
                                <p class="mt-2 text-muted"><?php echo e(strtoupper($fileExtension)); ?> Image</p>
                            <?php elseif(in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'mkv'])): ?>
                                <video class="img-fluid rounded mb-3" controls style="max-height: 250px;">
                                    <source src="<?php echo e($fileUrl); ?>" type="video/<?php echo e($fileExtension); ?>">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="mt-2 text-muted"><?php echo e(strtoupper($fileExtension)); ?> Video</p>
                            <?php else: ?>
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                    <a href="<?php echo e($fileUrl); ?>" class="btn btn-outline-primary mt-2" target="_blank">
                                        <i class="bi bi-download"></i> Unduh File
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/show.blade.php ENDPATH**/ ?>