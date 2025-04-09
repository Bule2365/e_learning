

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary-blue: #0d6efd;
            --light-blue: #e6f2ff;
        }

        .material-container {
            max-width: 1400px;
        }

        .video-player {
            background-color: #000;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .recommended-playlist {
            background-color: var(--light-blue);
            border-radius: 12px;
            padding: 15px;
        }

        .playlist-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .playlist-item:hover {
            background-color: rgba(13, 110, 253, 0.1);
            transform: translateY(-5px);
        }

        .playlist-thumbnail {
            border-radius: 8px;
            overflow: hidden;
        }

        .playlist-thumbnail img {
            transition: transform 0.3s ease;
        }

        .playlist-item:hover .playlist-thumbnail img {
            transform: scale(1.05);
        }

        .media-toggle-buttons .btn {
            transition: all 0.3s ease;
        }

        @media (max-width: 992px) {
            .recommended-playlist {
                max-height: none;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid material-container py-4">
        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="<?php echo e(route('siswa.material.list', ['subject_id' => $material->subject_id])); ?>"
                        class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Materi
                    </a>
                </div>

                <!-- Material Title -->
                <h2 class="display-6 mb-4 text-primary"><?php echo e($material->title); ?></h2>

                <!-- Media Format Toggle Buttons -->
                <div class="media-toggle-buttons mb-4">
                    <button class="btn btn-primary me-2" onclick="tampilkanFormat('gambar')">
                        <i class="bi bi-image me-2"></i>Gambar
                    </button>
                    <button class="btn btn-outline-primary me-2" onclick="tampilkanFormat('video')">
                        <i class="bi bi-play-btn me-2"></i>Video
                    </button>
                    <button class="btn btn-outline-primary" onclick="tampilkanFormat('pdf')">
                        <i class="bi bi-file-pdf me-2"></i>PDF
                    </button>
                </div>

                <!-- Media Container -->
                <div id="media-container" class="mb-4">
                    <?php
                        $imagePaths = [];
                        $videoPaths = [];
                        $pdfPaths = [];

                        if (!empty($material->file_paths)) {
                            foreach ($material->file_paths as $filePath) {
                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                    $imagePaths[] = Storage::url($filePath);
                                } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                    $videoPaths[] = Storage::url($filePath);
                                } elseif ($extension == 'pdf') {
                                    $pdfPaths[] = Storage::url($filePath);
                                }
                            }
                        }
                    ?>

                    <!-- Image Container -->
                    <div id="gambar-container" class="media-format">
                        <?php if(!empty($imagePaths)): ?>
                            <div class="row g-3">
                                <?php $__currentLoopData = $imagePaths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6">
                                        <img src="<?php echo e($image); ?>" alt="<?php echo e($material->title); ?>"
                                            class="img-fluid rounded shadow-sm">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">Tidak ada gambar tersedia.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Video Container -->
                    <div id="video-container" class="media-format" style="display: none;">
                        <?php if(!empty($videoPaths)): ?>
                            <?php $__currentLoopData = $videoPaths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="video-player ratio ratio-16x9 mb-3">
                                    <video controls class="w-100">
                                        <source src="<?php echo e($video); ?>" type="video/mp4">
                                        Browser Anda tidak mendukung pemutar video.
                                    </video>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="alert alert-info">Tidak ada video tersedia.</div>
                        <?php endif; ?>
                    </div>

                    <!-- PDF Container -->
                    <div id="pdf-container" class="media-format" style="display: none;">
                        <?php if(!empty($pdfPaths)): ?>
                            <?php $__currentLoopData = $pdfPaths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <iframe src="<?php echo e($pdf); ?>" class="w-100 border-0 rounded shadow-sm"
                                    style="height: 500px;"></iframe>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="alert alert-info">Tidak ada PDF tersedia.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="card border-primary mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Deskripsi</h5>
                        <?php
                            $deskripsiPenuh = $material->description ?? 'Tidak ada deskripsi yang tersedia.';
                            $deskripsiPendek = implode(
                                ' ',
                                array_slice(explode(' ', strip_tags($deskripsiPenuh)), 0, 10),
                            );
                        ?>

                        <p class="card-text" id="deskripsi-<?php echo e($material->id); ?>">
                            <span id="deskripsi-singkat-<?php echo e($material->id); ?>">
                                <?php echo nl2br(e($deskripsiPendek)); ?>...
                            </span>
                            <span id="deskripsi-penuh-<?php echo e($material->id); ?>" style="display: none;">
                                <?php echo nl2br(e($deskripsiPenuh)); ?>

                            </span>

                            <?php if(str_word_count($deskripsiPenuh) > 10): ?>
                                <br>
                                <a href="javascript:void(0);" onclick="toggleDeskripsi(<?php echo e($material->id); ?>)"
                                    class="text-primary" id="toggle-deskripsi-<?php echo e($material->id); ?>">
                                    Lihat Selengkapnya
                                </a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recommended Materials Sidebar -->
            <div class="col-lg-4">
                <div id="gambar-container" class="bg-secondary bg-opacity-10 rounded p-3">
                    <h4 class="mb-3 text-dark">Playlist Materi</h4>

                    <?php if($recommendedMaterials->isEmpty()): ?>
                        <p class="text-muted text-center">Belum ada rekomendasi materi.</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $recommendedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recMaterial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $thumbnail = null; // Default tanpa thumbnail
                                $fileType = 'text-muted';
                            ?>

                            <?php if(!empty($recMaterial->file_paths)): ?>
                                <?php $__currentLoopData = $recMaterial->file_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    ?>

                                    <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                        <?php $thumbnail = Storage::url($filePath); ?>
                                    <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                        <?php $thumbnail = asset('default-video-thumbnail.jpg'); ?>
                                        <?php $fileType = 'text-primary'; ?>
                                    <?php elseif($extension === 'pdf'): ?>
                                        <?php $thumbnail = asset('default-pdf-thumbnail.jpg'); ?>
                                        <?php $fileType = 'text-danger'; ?>
                                    <?php endif; ?>
                                <?php break; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <!-- Seluruh Box Dijadikan Link -->
                        <a href="<?php echo e(route('siswa.material.detail', $recMaterial->id)); ?>"
                            class="d-flex mb-3 border-bottom pb-2 align-items-center rounded bg-light p-2 shadow-sm text-decoration-none text-dark w-100">

                            <?php if($thumbnail): ?>
                                <!-- Jika Ada Thumbnail -->
                                <img src="<?php echo e($thumbnail); ?>" alt="<?php echo e($recMaterial->title); ?>"
                                    class="img-fluid rounded shadow-sm me-3"
                                    style="width: 120px; height: 80px; object-fit: cover;">
                            <?php endif; ?>

                            <!-- Detail Materi -->
                            <div class="w-100">
                                <h6 class="mb-1"><?php echo e(Str::limit($recMaterial->title, 50, '...')); ?></h6>
                                <p class="text-muted small mb-0"><?php echo e(Str::limit($recMaterial->description, 80, '...')); ?>

                                </p>
                            </div>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function tampilkanFormat(format) {
            // Reset semua tombol
            document.querySelectorAll('.media-toggle-buttons .btn').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            // Aktifkan tombol yang dipilih
            const activeButton = document.querySelector(`.media-toggle-buttons button[onclick*="${format}"]`);
            if (activeButton) {
                activeButton.classList.remove('btn-outline-primary');
                activeButton.classList.add('btn-primary');
            }

            // Sembunyikan semua container
            document.querySelectorAll('.media-format').forEach(el => el.style.display = 'none');

            // Tampilkan yang sesuai
            const selectedContainer = document.getElementById(`${format}-container`);
            if (selectedContainer) {
                selectedContainer.style.display = 'block';
            }
        }

        function toggleDeskripsi(id) {
            let singkat = document.getElementById(`deskripsi-singkat-${id}`);
            let penuh = document.getElementById(`deskripsi-penuh-${id}`);
            let tombol = document.getElementById(`toggle-deskripsi-${id}`);

            if (singkat.style.display === "none") {
                singkat.style.display = "inline";
                penuh.style.display = "none";
                tombol.innerText = "Lihat Selengkapnya";
            } else {
                singkat.style.display = "none";
                penuh.style.display = "inline";
                tombol.innerText = "Lihat Lebih Sedikit";
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/material/detail.blade.php ENDPATH**/ ?>