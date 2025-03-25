

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <a href="<?php echo e(route('guru.materials.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <h1 class="display-4 text-center mb-4">Edit Materi</h1>

        <form action="<?php echo e(route('guru.materials.update', $material->id)); ?>" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" name="title" id="title" value="<?php echo e(old('title', $material->title)); ?>"
                    class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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

            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <div class="form-floating">
                            <textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Deskripsikan materi secara detail..." style="min-height: 200px;"><?php echo e(old('description', $material->description)); ?></textarea>
                            <label for="description">Deskripsikan materi secara detail...</label>
                        </div>
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
                </div>
            </div>

            
            <?php
                $files = json_decode($material->file_path, true) ?? [];
            ?>

            <div class="mb-3">
                <label class="form-label">File Saat Ini:</label>
                <ul id="current-files">
                    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank">Lihat File</a>
                            <input type="checkbox" name="delete_old_files[]" value="<?php echo e($file); ?>"
                                class="delete-file-checkbox"> Hapus
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah File Baru</label>
                <div id="file-inputs">
                    <div class="input-group mb-2">
                        <input type="file" name="files[]" class="form-control file-input"
                            accept="application/pdf, image/*, video/*">
                        <button type="button" class="btn btn-success add-file">+</button>
                    </div>
                </div>
                <small class="text-muted">Maksimal 5 file, masing-masing maksimal 100MB.</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInputsContainer = document.getElementById('file-inputs');
                const addFileButton = document.querySelector('.add-file');
                const maxFiles = 4; // Sesuai dengan batasan pada backend
                let existingFiles = <?php echo e(count($files)); ?>;
                let fileInputsCount = 0;

                function updateAddButtonState() {
                    if ((existingFiles + fileInputsCount) >= maxFiles) {
                        addFileButton.disabled = true;
                    } else {
                        addFileButton.disabled = false;
                    }
                }

                addFileButton.addEventListener('click', function() {
                    if ((existingFiles + fileInputsCount) < maxFiles) {
                        const newInputGroup = document.createElement('div');
                        newInputGroup.classList.add('input-group', 'mb-2');

                        const newFileInput = document.createElement('input');
                        newFileInput.type = 'file';
                        newFileInput.name = 'files[]';
                        newFileInput.classList.add('form-control', 'file-input');
                        newFileInput.accept = 'application/pdf, image/*, video/*';

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.classList.add('btn', 'btn-danger', 'remove-file');
                        removeButton.innerText = '−';

                        newInputGroup.appendChild(newFileInput);
                        newInputGroup.appendChild(removeButton);
                        fileInputsContainer.appendChild(newInputGroup);

                        fileInputsCount++;
                        updateAddButtonState();

                        removeButton.addEventListener('click', function() {
                            newInputGroup.remove();
                            fileInputsCount--;
                            updateAddButtonState();
                        });
                    }
                });

                document.querySelectorAll('.delete-file-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            existingFiles--;
                        } else {
                            existingFiles++;
                        }
                        updateAddButtonState();
                    });
                });

                updateAddButtonState();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/edit.blade.php ENDPATH**/ ?>