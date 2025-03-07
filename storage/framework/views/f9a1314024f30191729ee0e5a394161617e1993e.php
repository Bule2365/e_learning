

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <a href="<?php echo e(route('guru.exams.index')); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>

        <h1 class="display-4 text-center mb-4">Detail Ujian</h1>

        <!-- Informasi Ujian -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo e($exam->nama_ujian); ?></h5>
            </div>
            <div class="card-body">
                <p class="lead"><strong>Kelas:</strong> <?php echo e($exam->kelas->name); ?></p>
                <p class="lead"><strong>Mata Pelajaran:</strong> <?php echo e($exam->mataPelajaran->name); ?></p>
                <p class="lead"><strong>Jumlah Soal:</strong> <?php echo e($exam->soal->count()); ?></p>
                <p class="lead"><strong>Tanggal Ujian:</strong>
                    <?php echo e(\Carbon\Carbon::parse($exam->tanggal)->format('d M Y')); ?></p>
                <a href="<?php echo e(route('guru.exams.add_questions', $exam->id)); ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Soal
                </a>
            </div>
        </div>

        <!-- Daftar Soal -->
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Daftar Soal</h5>
            </div>
            <div class="card-body">
                <?php if($exam->soal->isEmpty()): ?>
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-circle"></i> Belum ada soal yang ditambahkan.
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php $__currentLoopData = $exam->soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $soal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between align-items-start soal-item"
                                id="soal-<?php echo e($soal->id); ?>">
                                <div class="flex-grow-1">
                                    <h5><?php echo e($loop->iteration); ?></h5>

                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <?php if($soal->image_path): ?>
                                            <!-- Gambar soal sudah ada, bisa diklik untuk mengedit -->
                                            <a href="<?php echo e(route('guru.exams.image', $soal->id)); ?>">
                                                <img src="<?php echo e(asset('storage/' . $soal->image_path)); ?>" alt="Gambar Soal"
                                                    class="img-fluid" style="max-width: 300px;" />
                                                    <p class="text-muted text-center">Klik gambar untuk mengubahnya.</p>
                                            </a>
                                        <?php else: ?>
                                            <!-- Jika soal belum ada gambar, tampilkan tombol untuk menambah gambar -->
                                            <a href="<?php echo e(route('guru.exams.image', $soal->id)); ?>"
                                                class="btn btn-primary">Tambah Gambar</a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Edit Soal -->
                                    <input type="text" class="form-control soal-text mb-2" data-id="<?php echo e($soal->id); ?>"
                                        value="<?php echo e($soal->question_text); ?>" placeholder="Tulis soal di sini..." />

                                    <!-- Pilihan Ganda -->
                                    <?php if($soal->type === 'multiple_choice'): ?>
                                        <?php
                                            $options = json_decode($soal->options, true);
                                        ?>
                                        <ul class="list-unstyled mt-2">
                                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="mb-2">
                                                    <strong><?php echo e($key); ?>:</strong>
                                                    <input type="text" class="form-control option-text"
                                                        data-id="<?php echo e($soal->id); ?>" data-key="<?php echo e($key); ?>"
                                                        value="<?php echo e($option); ?>"
                                                        placeholder="Tulis pilihan jawaban di sini..." />
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <p class="text-success">
                                            <strong>Jawaban Benar:</strong>
                                            <input type="text" class="form-control correct-answer"
                                                data-id="<?php echo e($soal->id); ?>" value="<?php echo e($soal->correct_answer); ?>"
                                                placeholder="Tulis jawaban benar di sini..." />
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Hapus Soal -->
                                <button class="btn btn-danger btn-sm delete-question" data-id="<?php echo e($soal->id); ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Edit Soal
            document.querySelectorAll(".soal-text").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let newText = this.value;

                    fetch(`/questions/update/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                        },
                        body: JSON.stringify({
                            question_text: newText,
                        })
                    });
                });
            });

            // Edit Opsi Jawaban
            document.querySelectorAll(".option-text").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let optionKey = this.getAttribute("data-key");
                    let newText = this.value;

                    fetch(`/questions/update-option/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        },
                        body: JSON.stringify({
                            key: optionKey,
                            value: newText
                        })
                    });
                });
            });

            // Edit Jawaban Benar
            document.querySelectorAll(".correct-answer").forEach(input => {
                input.addEventListener("change", function() {
                    let soalId = this.getAttribute("data-id");
                    let newText = this.value;

                    fetch(`/questions/update-correct-answer/${soalId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        },
                        body: JSON.stringify({
                            correct_answer: newText
                        })
                    });
                });
            });

            // Hapus Soal
            document.querySelectorAll(".delete-question").forEach(button => {
                button.addEventListener("click", function() {
                    let soalId = this.getAttribute("data-id");

                    fetch(`/questions/delete/${soalId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                        }
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            document.getElementById(`soal-${soalId}`).remove();
                        }
                    });
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/show.blade.php ENDPATH**/ ?>