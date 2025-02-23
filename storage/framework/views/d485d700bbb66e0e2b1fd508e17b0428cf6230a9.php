

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="mb-4">Detail Tugas: <?php echo e($task->title); ?></h1>

        <!-- Menampilkan Deskripsi Tugas -->
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Deskripsi:</strong> <?php echo e($task->description); ?></p>
                <p><strong>Batas Waktu:</strong> <?php echo e($task->due_date->format('d M Y H:i')); ?></p>
            </div>
        </div>

        <!-- Menampilkan File Tugas dari Guru (Jika Ada) -->
        <?php if($task->file_path): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5><strong>File Tugas dari Guru:</strong></h5>
                    <p>Anda dapat melihat file tugas yang diberikan oleh guru di bawah ini:</p>

                    <!-- Mengambil dan mendecode JSON dari file_path -->
                    <?php
                        $filePaths = json_decode($task->file_path);
                    ?>

                    <!-- Looping melalui semua file yang di-upload oleh guru -->
                    <?php $__currentLoopData = $filePaths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                        ?>

                        <?php if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <!-- Untuk Gambar -->
                            <div class="mb-3">
                                <img src="<?php echo e(asset('storage/' . $filePath)); ?>" alt="File Tugas" class="img-fluid">
                            </div>
                        <?php elseif(in_array($fileExtension, ['pdf'])): ?>
                            <!-- Untuk PDF -->
                            <div class="mb-3">
                                <iframe src="<?php echo e(asset('storage/' . $filePath)); ?>" width="100%" height="500px"></iframe>
                            </div>
                        <?php elseif(in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])): ?>
                            <!-- Untuk Video -->
                            <div class="mb-3">
                                <video width="100%" height="500px" controls>
                                    <source src="<?php echo e(asset('storage/' . $filePath)); ?>" type="video/<?php echo e($fileExtension); ?>">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php else: ?>
                            <!-- Untuk Format File Lainnya, tampilkan link -->
                            <div class="mb-3">
                                <p>Format file tidak didukung untuk tampilan langsung. Anda dapat mengunduhnya untuk melihat
                                    lebih lanjut.</p>
                                <a href="<?php echo e(asset('storage/' . $filePath)); ?>" class="btn btn-secondary" download>Unduh File
                                    Tugas</a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Status Pengumpulan Tugas -->
        <div class="alert alert-info mb-4">
            <h5><strong>Status Pengumpulan:</strong></h5>
            <?php if($submission): ?>
                <?php if($submission->submission): ?>
                    <p>Tugas Sudah Dikirim pada <strong><?php echo e($submission->created_at->format('d M Y H:i')); ?></strong></p>
                <?php else: ?>
                    <p>Tugas Belum Dikirim. Silakan kirim tugas Anda sebelum batas waktu.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>Belum Mengumpulkan Tugas. Silakan upload tugas Anda di bawah ini.</p>
            <?php endif; ?>
        </div>

        <!-- Form untuk mengumpulkan tugas -->
        <?php if(!$submission || !$submission->submission): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Tugas Anda</h5>
                    <form action="<?php echo e(route('student.tasks.submit', $task->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Tugas</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            <small class="form-text text-muted">Pastikan file Anda dalam format yang tepat dan tidak lebih
                                dari 10MB.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Tugas</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-success mt-4" role="alert">
                <strong>Tugas Sudah Dikirim!</strong> Anda tidak dapat mengupload ulang tugas setelah mengirim.
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/tasks/show.blade.php ENDPATH**/ ?>