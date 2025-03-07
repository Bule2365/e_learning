

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <a href="<?php echo e(route('guru.exams.show', ['id' => $exam->id])); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Soal Ujian</span>
        </a>

        <h1 class="display-4 text-center mb-4">Edit Gambar Soal</h1>

        <!-- Gambar Soal -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gambar Soal</h5>
            </div>
            <div class="card-body text-center">
                <?php if($question->image_path): ?>
                    <!-- Menampilkan gambar jika ada -->
                    <img src="<?php echo e(asset('storage/' . $question->image_path)); ?>" alt="Gambar Soal" class="img-fluid mb-3"
                        style="max-width: 300px;">
                <?php else: ?>
                    <!-- Jika tidak ada gambar -->
                    <p class="text-muted">Belum ada gambar. Upload gambar untuk soal ini.</p>
                <?php endif; ?>

                <!-- Tombol untuk memilih gambar baru -->
                <form action="<?php echo e(route('guru.exams.update_image', $question->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Gambar</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/edit_image.blade.php ENDPATH**/ ?>