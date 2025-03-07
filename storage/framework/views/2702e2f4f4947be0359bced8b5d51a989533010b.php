

<?php $__env->startSection('title', 'Data Pengguna'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Custom Table Styling */
        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .table-custom thead th {
            background-color: #f8f9fc;
            color: #333;
            font-weight: bold;
        }

        .table-custom tbody tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.3s ease-in-out;
        }

        /* Button Styling */
        .btn-action {
            padding: 5px 10px;
            font-size: 14px;
            transition: transform 0.3s ease-in-out;
        }

        .btn-action:hover {
            transform: scale(1.03);
        }

        /* Pagination Styling */
        .pagination {
            justify-content: center;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .pagination .page-link {
            color: #4e73df;
            transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: #4e73df;
        }

        /* Alert Styling */
        .empty-alert {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        .pagination {
            flex-wrap: wrap;
        }

        .pagination .page-item {
            margin: 2px;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Menyesuaikan modal agar pas di layar kecil */
        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 90%;
                margin: auto;
            }
        }

        /* Pastikan tabel tetap dalam ukuran yang bisa digulir */
        .table-responsive {
            overflow-x: auto;
        }

        /* Menghindari pemotongan teks di layar kecil */
        @media (max-width: 768px) {

            .table th,
            .table td {
                white-space: nowrap;
                /* Hindari pemotongan teks */
            }
        }

        /* Tambahkan efek hover untuk pengalaman lebih baik */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Data Pengguna</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary shadow-sm btn-action">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Pengguna
                </a>
                <button type="button" class="btn btn-success shadow-sm btn-action" data-bs-toggle="modal"
                    data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i> Import Data
                </button>
                <a href="<?php echo e(route('users.export')); ?>" class="btn btn-secondary shadow-sm btn-action">
                    <i class="bi bi-download me-2"></i> Export Data
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="input-group">
                    <form action="<?php echo e(route('users.index')); ?>" method="GET" class="d-flex justify-content-between gap-3">
                        <!-- Search Input -->
                        <div class="input-group w-75">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 shadow-sm"
                                placeholder="Cari pengguna..." value="<?php echo e(request()->search); ?>"
                                aria-label="Cari pengguna...">
                        </div>

                        <!-- Role Dropdown with Smooth Transition -->
                        <select name="role" class="form-select w-25 shadow-sm border-start-0"
                            onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="guru" <?php echo e(request()->role == 'guru' ? 'selected' : ''); ?>>Guru</option>
                            <option value="siswa" <?php echo e(request()->role == 'siswa' ? 'selected' : ''); ?>>Siswa</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="card shadow table-custom">
            <div class="card-body">
                <?php if($users->isEmpty()): ?>
                    <div class="alert alert-warning text-center">
                        Tidak ada pengguna yang tersedia.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td class="text-nowrap"><?php echo e($user->name); ?></td>
                                        <td class="text-nowrap"><?php echo e($user->email); ?></td>
                                        <td class="text-nowrap"><?php echo e(ucfirst($user->role)); ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                <a href="<?php echo e(route('users.edit', $user)); ?>"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?php echo e($user->id); ?>">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="deleteModal<?php echo e($user->id); ?>" tabindex="-1"
                                        aria-labelledby="deleteModalLabel<?php echo e($user->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo e($user->id); ?>">
                                                        Konfirmasi Penghapusan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus pengguna
                                                    <strong><?php echo e($user->name); ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                <!-- Previous Button -->
                <?php if($users->onFirstPage()): ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo; Previous</span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($users->previousPageUrl()); ?>" rel="prev">&laquo; Previous</a>
                    </li>
                <?php endif; ?>

                <!-- First Page Link -->
                <?php if($users->currentPage() > 3): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($users->url(1)); ?>">1</a>
                    </li>
                    <?php if($users->currentPage() > 4): ?>
                        <li class="page-item disabled d-none d-sm-block">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Middle Pages -->
                <?php for($i = max(1, $users->currentPage() - 2); $i <= min($users->lastPage(), $users->currentPage() + 2); $i++): ?>
                    <li class="page-item <?php echo e($users->currentPage() == $i ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e($users->url($i)); ?>"><?php echo e($i); ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Last Page Link -->
                <?php if($users->currentPage() < $users->lastPage() - 2): ?>
                    <?php if($users->currentPage() < $users->lastPage() - 3): ?>
                        <li class="page-item disabled d-none d-sm-block">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($users->url($users->lastPage())); ?>"><?php echo e($users->lastPage()); ?></a>
                    </li>
                <?php endif; ?>

                <!-- Next Button -->
                <?php if($users->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($users->nextPageUrl()); ?>" rel="next">Next &raquo;</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next &raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('users.import')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize Bootstrap Tooltips -->
    <?php $__env->startPush('scripts'); ?>
        <script>
            // Optional: Prevent form submission if no change in dropdown
            document.querySelector('.form-select').addEventListener('change', function() {
                if (this.value) {
                    this.form.submit();
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/users/index.blade.php ENDPATH**/ ?>