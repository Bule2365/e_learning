
<?php $__env->startSection('content'); ?>
    <h2>Materi</h2>
    <div class="row">
        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php echo e(route('siswa.material.detail', $material->id)); ?>"
                                class="text-decoration-none text-dark">
                                <?php echo e($material->title); ?>

                            </a>
                        </h5>

                        <!-- Tampilkan file sesuai tipe -->
                        <?php if(isset($material->file_paths)): ?>
                            <?php $__currentLoopData = $material->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                ?>

                                <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                    <img src="<?php echo e(Storage::url($filePath)); ?>" alt="<?php echo e($material->title); ?>"
                                        class="img-fluid rounded">
                                <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" controls>
                                            <source src="<?php echo e(Storage::url($filePath)); ?>" type="video/<?php echo e($extension); ?>">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/list.blade.php ENDPATH**/ ?>