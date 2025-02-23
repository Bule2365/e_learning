

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .progress-hover {
            transition: width 0.8s ease-in-out;
        }

        .tooltip-text {
            z-index: 10;
            font-size: 12px;
            white-space: nowrap;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Efek Hover pada Card */
        .card-hover {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Gradient Border untuk Card */
        .border-left-primary {
            border-left: 5px solid #4e73df !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-success {
            border-left: 5px solid #1cc88a !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-info {
            border-left: 5px solid #36b9cc !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        .border-left-warning {
            border-left: 5px solid #f6c23e !important;
            background: linear-gradient(to right, #f8f9fc, #ffffff);
        }

        /* Ikon dengan Efek Hover */
        .bi:hover {
            animation: pulse 1s infinite;
        }

        /* Animasi Pulse untuk Ikon */
        @keyframes  pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Jumlah Siswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahSiswa); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Guru -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Guru</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahGuru); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-person-badge fs-1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Kelas -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kelas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahKelas); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-door-open fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Mata Pelajaran -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Mata Pelajaran
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahMapel); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-book fs-1 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Sources Section -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Data Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <!-- Jumlah Siswa -->
                        <div class="mb-4 position-relative">
                            <p class="text-sm font-weight-bold text-dark">Jumlah Siswa</p>
                            <div class="progress rounded-pill" style="height: 12px;">
                                <div class="progress-bar bg-primary progress-hover" role="progressbar"
                                    style="width: <?php echo e(($jumlahSiswa / ($jumlahSiswa + $jumlahGuru + $jumlahKelas)) * 100); ?>%;"
                                    aria-valuenow="<?php echo e($jumlahSiswa); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div
                                class="tooltip-text d-none position-absolute bg-dark text-white px-2 py-1 rounded shadow-sm">
                                <?php echo e($jumlahSiswa); ?>

                            </div>
                        </div>

                        <!-- Jumlah Guru -->
                        <div class="mb-4 position-relative">
                            <p class="text-sm font-weight-bold text-dark">Jumlah Guru</p>
                            <div class="progress rounded-pill" style="height: 12px;">
                                <div class="progress-bar bg-success progress-hover" role="progressbar"
                                    style="width: <?php echo e(($jumlahGuru / ($jumlahSiswa + $jumlahGuru + $jumlahKelas)) * 100); ?>%;"
                                    aria-valuenow="<?php echo e($jumlahGuru); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div
                                class="tooltip-text d-none position-absolute bg-dark text-white px-2 py-1 rounded shadow-sm">
                                <?php echo e($jumlahGuru); ?>

                            </div>
                        </div>

                        <!-- Jumlah Kelas -->
                        <div class="mb-4 position-relative">
                            <p class="text-sm font-weight-bold text-dark">Jumlah Kelas</p>
                            <div class="progress rounded-pill" style="height: 12px;">
                                <div class="progress-bar bg-warning progress-hover" role="progressbar"
                                    style="width: <?php echo e(($jumlahKelas / ($jumlahSiswa + $jumlahGuru + $jumlahKelas)) * 100); ?>%;"
                                    aria-valuenow="<?php echo e($jumlahKelas); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div
                                class="tooltip-text d-none position-absolute bg-dark text-white px-2 py-1 rounded shadow-sm">
                                <?php echo e($jumlahKelas); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dropdown and Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Pilih Grafik</h6>
                    </div>
                    <div class="card-body">
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownChart"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Grafik
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownChart">
                                <li><a class="dropdown-item" href="#" onclick="showChart('siswa')">Grafik Siswa</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="showChart('guru')">Grafik Guru</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="showChart('kelas')">Grafik Kelas</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="showChart('mapel')">Grafik Mata
                                        Pelajaran</a></li>
                            </ul>
                        </div>
                        <canvas id="chartCanvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let chart;

            function showChart(type) {
                console.log("Menampilkan grafik:", type);

                // Data untuk grafik
                const data = {
                    siswa: <?php echo json_encode($jumlahSiswa); ?>,
                    guru: <?php echo json_encode($jumlahGuru); ?>,
                    kelas: <?php echo json_encode($jumlahKelas); ?>,
                    mapel: <?php echo json_encode($jumlahMapel); ?>

                };

                // Hancurkan grafik sebelumnya jika ada
                if (chart) chart.destroy();

                // Konfigurasi Chart.js
                const ctx = document.getElementById('chartCanvas').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Array.from({
                            length: data[type]
                        }, (_, i) => i + 1), // Label dari 1 hingga jumlah data
                        datasets: [{
                            label: 'Jumlah',
                            data: Array.from({
                                length: data[type]
                            }, () => 0), // Mulai dari 0
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            tension: 0.4, // Efek kurva smooth
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e7eb',
                                }
                            }
                        },
                        animation: {
                            duration: 2000, // Durasi animasi dalam milidetik
                            easing: 'easeInOutBounce', // Efek bouncing
                        }
                    }
                });

                // Animasi memantul untuk menampilkan data
                setTimeout(() => {
                    chart.data.datasets[0].data = Array.from({
                        length: data[type]
                    }, (_, i) => i + 1); // Isi data sesuai ID
                    chart.update(); // Perbarui grafik
                }, 500);
            }

            // Efek hover untuk progress bar
            document.querySelectorAll('.progress-hover').forEach((progressBar) => {
                const tooltip = progressBar.parentElement.nextElementSibling;

                progressBar.addEventListener('mouseenter', (e) => {
                    tooltip.classList.remove('d-none');
                    tooltip.style.opacity = "1";
                    tooltip.style.transform = "translateY(-10px)";
                    tooltip.style.left = `${e.target.offsetWidth / 2 - tooltip.offsetWidth / 2}px`;
                });

                progressBar.addEventListener('mouseleave', () => {
                    tooltip.style.opacity = "0";
                    tooltip.style.transform = "translateY(0px)";
                    setTimeout(() => tooltip.classList.add('d-none'), 300);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>