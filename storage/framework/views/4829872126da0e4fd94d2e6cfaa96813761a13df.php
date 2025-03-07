

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <a href="<?php echo e(route('guru.classes.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>

        <h1 class="display-4 text-center mb-4">Form Materi Baru</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('guru.materials.store')); ?>" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="class_id" value="<?php echo e($classes->id); ?>">
            <input type="hidden" name="subject_id" value="<?php echo e($subjects->first()->id); ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Judul Materi</label>
                <input type="text" name="title" id="title"
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

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
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

            <!-- Input File Dinamis -->
            <div class="mb-3">
                <label class="form-label">Unggah Materi (Maksimal 5 file, 100MB per file)</label>
                <div id="file-inputs">
                    <div class="input-group mb-2">
                        <input type="file" name="files[]" class="form-control file-input"
                            accept="application/pdf, image/*, video/*">
                        <button type="button" class="btn btn-success add-file">+</button>
                    </div>
                </div>
                <small class="text-muted">Maksimal 5 file, masing-masing maksimal 100MB.</small>
                <?php $__errorArgs = ['files.*'];
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
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-floppy2-fill"></i>
                    <span>Simpan Materi</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputsContainer = document.getElementById('file-inputs');
            const addFileButton = document.querySelector('.add-file');

            addFileButton.addEventListener('click', function() {
                const fileInputs = document.querySelectorAll('.file-input');

                if (fileInputs.length < 5) {
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

                    // Cek apakah sudah 5 file, jika ya nonaktifkan tombol "+"
                    if (fileInputs.length + 1 >= 5) {
                        addFileButton.disabled = true;
                    }

                    // Hapus file jika tombol "−" ditekan
                    removeButton.addEventListener('click', function() {
                        newInputGroup.remove();
                        addFileButton.disabled = false;
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/materials/create.blade.php ENDPATH**/ ?>