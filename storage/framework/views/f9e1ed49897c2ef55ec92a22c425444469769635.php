

<?php $__env->startSection('content'); ?>
    <!-- Tambahkan Bootstrap 5.4 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container my-5">
        <!-- Tombol Kembali -->
        <a href="<?php echo e(route('guru.exams.scores', $exam->id)); ?>"
            class="btn btn-outline-primary btn-sm mb-4 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Nilai
        </a>

        <!-- Card Utama -->
        <div class="card shadow-sm p-4 rounded-3 border-0">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Penilaian Ujian</h2>
                <h4 class="text-secondary"><?php echo e($exam->title); ?></h4>
            </div>

            <!-- Informasi Siswa -->
            <div class="alert alert-light border border-primary rounded-3 text-center">
                <strong>Nama Siswa:</strong> <?php echo e($attempt->user->name); ?>

            </div>

            <!-- Tabel Soal dan Jawaban -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border rounded-3">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="w-50">Pertanyaan</th>
                            <th scope="col" class="w-25">Jawaban Benar</th>
                            <th scope="col" class="w-25">Jawaban Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $exam->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $studentAnswer = $answers->where('question_id', $question->id)->first();
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($question->question_text); ?></strong>
                                    <?php if($question->image_path): ?>
                                        <br>
                                        <img src="<?php echo e(asset('storage/' . $question->image_path)); ?>" alt="Gambar Pertanyaan"
                                            class="img-thumbnail mt-2 rounded-3" style="max-width: 180px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success"><?php echo e($question->correct_answer ?? 'Tidak tersedia'); ?></span>
                                </td>
                                <td>
                                    <?php if($studentAnswer): ?>
                                        <span class="badge bg-<?php echo e($studentAnswer->is_correct ? 'success' : 'danger'); ?>">
                                            <?php echo e($studentAnswer->answer); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">Tidak dijawab</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Form Update Skor Total -->
            <div class="card bg-white border-0 shadow-sm p-4 mt-4 rounded-3">
                <form action="<?php echo e(route('guru.exams.scores.update', ['exam' => $exam->id, 'attempt' => $attempt->id])); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-4">
                        <label for="total_score" class="form-label fw-bold text-primary">Total Skor (0-100)</label>
                        <div class="d-flex align-items-center">
                            <input type="range" id="total_score" name="total_score" class="form-range me-3" min="0"
                                max="100" step="1" value="<?php echo e(old('total_score', $attempt->score)); ?>"
                                oninput="scoreOutput.value = total_score.value">
                            <output id="scoreOutput"
                                class="fs-5 fw-bold text-primary"><?php echo e(old('total_score', $attempt->score)); ?></output>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 shadow-sm fw-bold">
                        <i class="bi bi-check-circle-fill me-2"></i> Simpan Nilai
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk Slider -->
    <script>
        document.getElementById('total_score').addEventListener('input', function() {
            document.getElementById('scoreOutput').innerText = this.value;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/edit_score.blade.php ENDPATH**/ ?>