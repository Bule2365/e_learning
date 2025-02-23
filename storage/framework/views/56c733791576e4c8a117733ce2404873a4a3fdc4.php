
<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="my-4"><?php echo e($material->title); ?></h2>

        <!-- Tampilkan materi sesuai tipe -->
        <?php if(isset($material->file_paths)): ?>
            <?php $__currentLoopData = $material->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                ?>

                <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                    <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($material->title); ?>" class="img-fluid rounded">
                <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="embed-responsive-item" controls>
                            <source src="<?php echo e(Storage::url($filePath)); ?>" type="video/<?php echo e($extension); ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php elseif($extension == 'pdf'): ?>
                    <iframe src="<?php echo e(Storage::url($filePath)); ?>" width="100%" height="500px"></iframe>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <!-- Link download materi -->
        <br>
        <?php if(isset($material->file_paths[0])): ?>
            <a href="<?php echo e(Storage::url($material->file_paths[0])); ?>" download class="btn btn-primary mb-4">Download Materi</a>
        <?php endif; ?>

        <h3 class="mt-5">Rekomendasi Materi</h3>
        <div class="row">
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
                            <?php if(isset($recMaterial->file_paths)): ?>
                                <?php $__currentLoopData = $recMaterial->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    ?>

                                    <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($recMaterial->title); ?>"
                                            class="img-fluid rounded">
                                    <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video class="embed-responsive-item" controls>
                                                <source src="<?php echo e(Storage::url($filePath)); ?>"
                                                    type="video/<?php echo e($extension); ?>">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    <?php elseif($extension == 'pdf'): ?>
                                        <iframe src="<?php echo e(Storage::url($filePath)); ?>" width="100%" height="200px"></iframe>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/detail.blade.php ENDPATH**/ ?>