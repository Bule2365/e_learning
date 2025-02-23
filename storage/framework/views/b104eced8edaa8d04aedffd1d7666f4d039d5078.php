

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Daftar Tugas</h1>

        <!-- Form pencarian -->
        <form method="GET" action="<?php echo e(route('student.tasks.index')); ?>">
            <div class="input-group mb-4">
                <input type="text" name="search" class="form-control" placeholder="Cari tugas..."
                    value="<?php echo e(request('search')); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <?php $__currentLoopData = $tasks->sortByDesc('due_date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Sorting tasks by due_date in descending order -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($task->title); ?></h5>
                    <p class="card-text"><?php echo e($task->description); ?></p>
                    <p class="card-text"><strong>Batas Waktu:</strong> <?php echo e($task->due_date->format('d M Y H:i')); ?></p>

                    <!-- Menampilkan nilai yang diberikan guru, jika ada -->
                    <?php
                        // Mencari siswa terkait di collection users
                        $user = $task->users->firstWhere('id', Auth::id());
                    ?>
                    <?php if($user && $user->pivot->score !== null): ?>
                        <p class="card-text"><strong>Nilai:</strong> <?php echo e($user->pivot->score); ?></p>
                    <?php else: ?>
                        <p class="card-text"><strong>Nilai Belum Diberikan</strong></p>
                    <?php endif; ?>

                    <a href="<?php echo e(route('student.tasks.show', $task->id)); ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/tasks/index.blade.php ENDPATH**/ ?>