

<?php $__env->startPush('styles'); ?>
    <style>
        .media-container {
            width: 100%;
            height: 200px;
            /* Ukuran tetap */
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
        }

        .media-container img,
        .media-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Jika tidak ada file */
        .no-file-container {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            text-align: center;
            padding: 10px;
        }

        .no-file-container i {
            font-size: 40px;
            margin-bottom: 5px;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Tombol Kembali ke Beranda -->
        <a href="<?php echo e(route('siswa.material.index')); ?>" class="btn btn-secondary mb-3">
            <i class="bi bi-house-door"></i> Kembali ke Beranda
        </a>

        <h2 class="mb-4">Materi</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <a href="<?php echo e(route('siswa.material.detail', $material->id)); ?>" class="text-decoration-none">
                            <?php
                                $thumbnail = null;
                                $isVideo = false;
                                $isPDF = false;
                                $videoPath = null;

                                if (!empty($material->file_paths)) {
                                    foreach ($material->file_paths as $filePath) {
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                                        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                            $thumbnail = Storage::url($filePath);
                                            break;
                                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                            $videoPath = Storage::url($filePath);
                                            $isVideo = true;
                                            break;
                                        } elseif ($extension === 'pdf') {
                                            $thumbnail = asset('default-pdf-thumbnail.jpg');
                                            $isPDF = true;
                                            break;
                                        }
                                    }
                                }
                            ?>

                            <div class="media-container">
                                <?php if($isVideo && $videoPath): ?>
                                    <video controls>
                                        <source src="<?php echo e($videoPath); ?>" type="video/<?php echo e($extension); ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php elseif($isPDF): ?>
                                    <img src="<?php echo e($thumbnail); ?>" alt="PDF Preview">
                                <?php elseif($thumbnail): ?>
                                    <img src="<?php echo e($thumbnail); ?>" alt="<?php echo e($material->title); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e(asset('default-thumbnail.jpg')); ?>';">
                                <?php else: ?>
                                    <!-- Jika tidak ada file -->
                                    <div class="no-file-container">
                                        <i class="bi bi-file-earmark-text"></i>
                                        <p>Materi Tersedia</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="card-body">
                            <h5 class="card-title text-truncate">
                                <a href="<?php echo e(route('siswa.material.detail', $material->id)); ?>"
                                    class="text-dark text-decoration-none">
                                    <?php echo e($material->title); ?>

                                </a>
                            </h5>
                            <p class="text-muted text-truncate-2"><?php echo e(Str::limit($material->description, 100)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/list.blade.php ENDPATH**/ ?>