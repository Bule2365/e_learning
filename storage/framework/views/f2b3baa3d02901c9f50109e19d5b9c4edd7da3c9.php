

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Materi</h1>

        <form action="<?php echo e(route('guru.materials.update', $material->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Menyembunyikan input class_id jika ada di URL -->
            <input type="hidden" name="class_id" value="<?php echo e(optional($classes->first())->id); ?>">

            <!-- Input hidden untuk subject_id -->
            <input type="hidden" name="subject_id" value="<?php echo e(optional($subjects->first())->id); ?>">

            <!-- Pilihan Mata Pelajaran -->
            <div class="mb-3">
                <label for="class_name" class="form-label">Kelas</label>
                <input type="text" id="class_name" class="form-control"
                    value="<?php echo e(optional($material->ClassModel)->name); ?>" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="subject_name" class="form-label">Mata Pelajaran</label>
                <input type="text" id="subject_name" class="form-control"
                    value="<?php echo e(optional($material->subject)->name); ?>" readonly disabled>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title"
                    name="title" value="<?php echo e(old('title', $material->title)); ?>" required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Materi</label>
                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                    rows="4" required><?php echo e(old('description', $material->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Unggah File Materi</label>
                <input type="file" class="form-control <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="files"
                    name="files[]" multiple>
                <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <!-- Menampilkan file yang sudah ada -->
                <?php if($material->file_path): ?>
                    <div class="mt-3">
                        <h5>File yang sudah ada:</h5>
                        <?php $__currentLoopData = json_decode($material->file_path, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION); // Ambil ekstensi file
                                $fileUrl = asset('storage/' . $file); // URL file
                            ?>

                            <div class="mb-3">
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
                                    <small class="text-muted"> (File ini tidak akan diubah kecuali Anda mengunggah file
                                        baru)</small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Update Materi</button>
            <a href="<?php echo e(route('guru.materials.index')); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/edit.blade.php ENDPATH**/ ?>