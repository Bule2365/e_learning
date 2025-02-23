

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            .form-section {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                margin: 1.5rem 0;
                transition: all 0.3s ease;
            }

            .form-toggle-btn {
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                transition: all 0.3s ease;
                min-width: 200px;
                border: 2px solid transparent;
            }

            .form-toggle-btn.active {
                background: #0d6efd;
                color: white;
                border-color: #0a58ca;
                transform: translateY(-2px);
            }

            .question-type-badge {
                font-size: 0.8rem;
                padding: 0.3rem 0.7rem;
                border-radius: 6px;
            }

            .dynamic-form-section {
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .file-upload-box {
                border: 2px dashed #dee2e6;
                border-radius: 8px;
                padding: 2rem;
                text-align: center;
                background: white;
                cursor: pointer;
            }

            .file-upload-box:hover {
                border-color: #0d6efd;
                background: #f8fbff;
            }

            @media (max-width: 768px) {
                .form-toggle-container {
                    flex-direction: column;
                    gap: 1rem;
                }

                .form-toggle-btn {
                    width: 100%;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <a href="<?php echo e(route('guru.exams.index')); ?>" class="btn btn-primary mb-3">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Daftar Ujian</span>
    </a>
    <div class="container-lg py-4 py-lg-5">
        <div class="text-center mb-4 mb-lg-5">
            <h1 class="h2 fw-bold text-primary mb-3">Tambah Soal Ujian</h1>
            <p class="lead text-muted">Kelas: <?php echo e($exam->kelas->name); ?> | Mata Pelajaran: <?php echo e($exam->mataPelajaran->name); ?></p>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Toggle Buttons -->
                <div class="d-flex form-toggle-container justify-content-center mb-4">
                    <button id="manual-btn" class="btn form-toggle-btn active">
                        <i class="bi bi-pencil-square me-2"></i>Input Manual
                    </button>
                    <button id="upload-btn" class="btn form-toggle-btn">
                        <i class="bi bi-upload me-2"></i>Upload File
                    </button>
                </div>

                <!-- Manual Form -->
                <div id="manual-form" class="form-section">
                    <form action="<?php echo e(route('guru.exams.store_questions', $exam->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Teks Pertanyaan</label>
                            <textarea class="form-control <?php $__errorArgs = ['question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="question_text" name="question_text"
                                rows="4" placeholder="Masukkan pertanyaan lengkap disini..." required><?php echo e(old('question_text')); ?></textarea>
                            <?php $__errorArgs = ['question_text'];
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-semibold">Tambahkan Gambar</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jenis Soal</label>
                            <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type" name="type"
                                required>
                                <option value="multiple_choice" <?php echo e(old('type') == 'multiple_choice' ? 'selected' : ''); ?>>
                                    Pilihan Ganda
                                </option>
                                <option value="essay" <?php echo e(old('type') == 'essay' ? 'selected' : ''); ?>>
                                    Essay
                                </option>
                            </select>
                            <?php $__errorArgs = ['type'];
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

                        <!-- Multiple Choice Options -->
                        <div id="options-section" class="dynamic-form-section">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-semibold">Opsi Jawaban</label>
                                    <span class="question-type-badge bg-primary text-white">Pilihan Ganda</span>
                                </div>

                                <div class="row g-3">
                                    <?php $__currentLoopData = ['A', 'B', 'C', 'D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12 col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text"><?php echo e($option); ?>.</span>
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['options.' . $option];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="options[<?php echo e($option); ?>]"
                                                    placeholder="Pilihan <?php echo e($option); ?>"
                                                    value="<?php echo e(old('options.' . $option)); ?>">
                                                <?php $__errorArgs = ['options.' . $option];
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
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Jawaban Benar</label>
                                <select class="form-select <?php $__errorArgs = ['correct_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="correct_answer">
                                    <option value="">Pilih Jawaban Benar</option>
                                    <?php $__currentLoopData = ['A', 'B', 'C', 'D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($option); ?>"
                                            <?php echo e(old('correct_answer') == $option ? 'selected' : ''); ?>>
                                            Pilihan <?php echo e($option); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['correct_answer'];
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

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Simpan Soal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Upload Form -->
                <div id="upload-form" class="form-section" style="display: none;">
                    <form action="<?php echo e(route('guru.exams.store_questions', $exam->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Upload File Soal</label>
                            <div class="file-upload-box" onclick="document.getElementById('file-input').click()">
                                <div class="mb-3">
                                    <i class="bi bi-file-earmark-arrow-up fs-1 text-muted"></i>
                                </div>
                                <p class="text-muted mb-2">Klik untuk memilih file</p>
                                <small class="text-muted">Format yang didukung: .docx, .xlsx</small>
                                <input type="file" class="form-control visually-hidden" id="file-input" name="file"
                                    accept=".docx, .xlsx" required>
                            </div>
                            <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Pastikan format file sesuai dengan template yang telah ditentukan
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-upload me-2"></i>Upload File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Toggle Form Visibility
            const toggleForms = (activeForm) => {
                document.querySelectorAll('.form-toggle-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.getElementById(`${activeForm}-btn`).classList.add('active');

                document.querySelectorAll('.form-section').forEach(form => {
                    form.style.display = 'none';
                });
                document.getElementById(`${activeForm}-form`).style.display = 'block';
            };

            document.getElementById('manual-btn').addEventListener('click', () => toggleForms('manual'));
            document.getElementById('upload-btn').addEventListener('click', () => toggleForms('upload'));

            // Dynamic Form Handling
            const typeSelect = document.getElementById('type');
            const optionsSection = document.getElementById('options-section');

            const toggleOptions = () => {
                const isMultipleChoice = typeSelect.value === 'multiple_choice';
                optionsSection.style.maxHeight = isMultipleChoice ? `${optionsSection.scrollHeight}px` : '0';
                optionsSection.style.opacity = isMultipleChoice ? '1' : '0';
            };

            typeSelect.addEventListener('change', toggleOptions);

            // Initial check
            toggleOptions();
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('guru.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/guru/exams/add_questions.blade.php ENDPATH**/ ?>