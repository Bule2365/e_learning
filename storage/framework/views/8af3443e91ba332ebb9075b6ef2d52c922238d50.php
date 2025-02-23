

<?php $__env->startSection('title', 'Dashboard Siswa'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="mb-4 text-center">Dashboard Siswa</h1>

        <!-- Section Mata Pelajaran dan Tugas -->
        <div class="row mb-5">
            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-light rounded">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo e($subject->name); ?></h5>
                            <p class="card-text">
                                <strong>Guru:</strong> <?php echo e($subject->guru->name); ?><br>
                                <strong>Jumlah Tugas:</strong> <?php echo e($subject->tugas_count); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Section Grafik Nilai Tugas dan Ujian -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <h3 class="text-center">Grafik Nilai Tugas</h3>
                <canvas id="taskChart" width="400" height="200"></canvas>
            </div>

            <div class="col-md-6 mb-4">
                <h3 class="text-center">Grafik Nilai Ujian</h3>
                <canvas id="examChart" width="400" height="200"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Grafik Nilai Tugas
            var ctx1 = document.getElementById('taskChart').getContext('2d');
            var taskChart = new Chart(ctx1, {
                type: 'line', // Tipe grafik: line
                data: {
                    labels: [
                        '0', // Menambahkan 0 sebagai titik awal
                        <?php $__currentLoopData = $taskValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $taskValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            'Tugas <?php echo e($index + 1); ?>',
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ], // Label untuk tugas
                    datasets: [{
                        label: 'Nilai Tugas',
                        data: [0, // Menambahkan nilai 0 sebagai titik awal
                            <?php $__currentLoopData = $taskValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($taskValue); ?>,
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        ],
                        borderColor: 'rgba(255, 159, 64, 1)', // Warna garis tugas (oranye)
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'circle', // Menampilkan titik pada grafik
                        pointRadius: 5, // Ukuran titik
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari 0
                        }
                    }
                }
            });

            // Grafik Nilai Ujian
            var ctx2 = document.getElementById('examChart').getContext('2d');
            var examChart = new Chart(ctx2, {
                type: 'line', // Tipe grafik: line
                data: {
                    labels: [
                        '0', // Menambahkan 0 sebagai titik awal
                        <?php $__currentLoopData = $examValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $examValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            'Ujian <?php echo e($index + 1); ?>',
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ], // Label untuk ujian
                    datasets: [{
                        label: 'Nilai Ujian',
                        data: [0, // Menambahkan nilai 0 sebagai titik awal
                            <?php $__currentLoopData = $examValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($examValue); ?>,
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        ],
                        borderColor: 'rgba(54, 162, 235, 1)', // Warna garis ujian (biru)
                        borderWidth: 2,
                        fill: false,
                        pointStyle: 'circle', // Menampilkan titik pada grafik
                        pointRadius: 5, // Ukuran titik
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari 0
                        }
                    }
                }
            });
        </script>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>