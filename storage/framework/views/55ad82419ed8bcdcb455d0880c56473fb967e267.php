<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="SMK Informatika Utama - Pendidikan Berkualitas dalam Teknologi Informasi" />
    <meta name="author" content="SMK Informatika Utama" />
    <title>SMK Informatika Utama</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" />

    <style>
        body {
            background-color: #ffffff;
            /* White background for the entire page */
        }

        /* Transparansi pada navbar */
        #mainNav {
            background-color: rgba(255, 255, 255, 0.8);
            /* Putih dengan transparansi */
            transition: background-color 0.3s ease;
        }

        /* Menambahkan sedikit padding untuk navbar */
        .navbar-nav .nav-link {
            padding: 0.5rem 1rem;
        }

        /* Membuat navbar tetap responsif dan menampilkan semua tombol */
        @media (max-width: 991px) {
            .navbar-collapse {
                background-color: rgba(255, 255, 255, 0.9);
                /* Putih dengan transparansi pada navbar responsif */
            }

            .navbar-nav {
                width: 100%;
                text-align: center;
            }

            .navbar-nav .nav-item {
                width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 1rem 0;
                width: 100%;
            }
        }

        .btn-primary,
        .btn-light {
            background-color: #0066cc;
            /* Light blue for buttons */
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-light:hover {
            background-color: #0057b8;
        }

        .page-section.bg-primary {
            background-color: #0056b3;
            /* Dark blue background for sections */
        }

        .page-section.bg-dark {
            background-color: #333;
            /* Dark background for footer */
        }

        .page-section.bg-white {
            background-color: white;
        }

        .page-section.text-dark {
            color: black;
        }

        .page-section .divider {
            border-color: #333;
        }

        /* Hover effect for portfolio images */
        .portfolio-box {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .portfolio-img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .portfolio-box:hover .portfolio-img {
            filter: blur(5px) brightness(0.6);
            transform: scale(1.05);
        }

        .portfolio-box-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s ease-in-out;
        }

        .portfolio-box:hover .portfolio-box-caption {
            visibility: visible;
            opacity: 1;
        }

        /* Gradient background for masthead */
        .bg-gradient-primary {
            background: linear-gradient(180deg, #003366 0%, #1a237e 100%);
        }

        /* Text shadow for masthead */
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        /* Hover effects for service icons */
        .service-item:hover .service-icon {
            color: #007bff;
            transform: scale(1.2);
            transition: color 0.3s, transform 0.3s;
        }

        .service-item:hover h3 {
            color: #007bff;
        }

        .service-item:hover p {
            color: #333;
        }

        .btn-light {
            color: #fff;
            border: 1px solid #0066cc;
        }

        .btn-light:hover {
            background-color: #0057b8;
            border-color: #0057b8;
        }

        /* Transisi untuk modal dialog */
        .modal-dialog {
            transform: translateY(-50%);
            transition: transform 0.3s ease-out;
        }

        /* Animasi ketika modal tampil */
        .modal-fade-in {
            transform: translateY(0%);
        }

        /* Smooth fade-out saat modal hilang */
        .modal.fade .modal-dialog {
            transform: translateY(-50%);
            opacity: 0;
            transition: transform 0.3s ease-in, opacity 0.3s ease-out;
        }

        .modal.fade.show .modal-dialog {
            transform: translateY(0%);
            opacity: 1;
        }

        /* Menambahkan sedikit efek untuk ikon */
        .modal-header .bi-exclamation-circle-fill {
            margin-right: 10px;
        }

        .modal-body .bi-question-circle {
            margin-right: 10px;
        }

        /* Animasi dan transisi untuk modal-footer */
        .modal-footer {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        /* Modal footer tampil dengan transisi */
        .modal.fade.show .modal-footer {
            opacity: 1;
            transform: translateY(0);
        }

        /* Menambahkan sedikit efek pada tombol */
        .modal-footer .btn {
            transition: background-color 0.2s ease-in-out;
        }

        .modal-footer .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#" data-bs-toggle="modal" data-bs-target="#confirmationModal">Login</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Program Studi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        <i class="bi bi-exclamation-circle-fill text-warning"></i> Konfirmasi Tindakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><i class="bi bi-question-circle text-primary"></i> Apakah Anda yakin ingin melanjutkan? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="continueBtn">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

    <header class="masthead bg-gradient-primary text-white">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-shadow font-weight-bold">Selamat Datang di SMK Informatika Utama</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">SMK Informatika Utama adalah lembaga pendidikan yang menyediakan pendidikan berkualitas di bidang Teknologi Informasi. Kami berkomitmen untuk mencetak lulusan yang siap bersaing di dunia industri.</p>
                    <a class="btn btn-light btn-xl" href="#about">Temukan Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </header>

    <section class="page-section bg-dark text-white" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Tentang SMK Informatika Utama</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4">SMK Informatika Utama, yang didirikan pada 25 Juni 2007, berfokus pada pendidikan di bidang teknologi informasi dan komunikasi. Kami menyediakan kurikulum yang relevan dengan kebutuhan industri, mengutamakan keterampilan praktis untuk memastikan para siswa siap memasuki dunia kerja. Dengan fasilitas lengkap dan pengajaran berstandar tinggi, kami berkomitmen untuk menjadi sekolah terdepan di bidang teknologi di Indonesia.</p>
                    <a class="btn btn-light btn-xl" href="#services">Pelajari Program Kami</a>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-white text-dark" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Program Studi Kami</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center service-item">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-laptop fs-1 text-primary service-icon"></i></div>
                        <h3 class="h4 mb-2">Teknik Komputer dan Jaringan</h3>
                        <p class="mb-0">Mengembangkan keterampilan dalam instalasi, perawatan, dan pengelolaan jaringan komputer.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center service-item">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-display fs-1 text-primary service-icon"></i></div>
                        <h3 class="h4 mb-2">Rekayasa Perangkat Lunak</h3>
                        <p class="mb-0">Mengajarkan cara merancang dan mengembangkan perangkat lunak untuk berbagai aplikasi industri.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center service-item">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-server fs-1 text-primary service-icon"></i></div>
                        <h3 class="h4 mb-2">Administrasi Sistem Jaringan</h3>
                        <p class="mb-0">Mempelajari cara mengelola dan mengatur server serta infrastruktur jaringan dalam perusahaan.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center service-item">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-code fs-1 text-primary service-icon"></i></div>
                        <h3 class="h4 mb-2">Desain Grafis dan Multimedia</h3>
                        <p class="mb-0">Mengembangkan keterampilan dalam desain grafis, video editing, dan multimedia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="portfolio">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?php echo e(asset('images/smk-1.jpg')); ?>" title="Gambar Sekolah">
                        <img class="img-fluid portfolio-img" src="<?php echo e(asset('images/smk-1.jpg')); ?>" alt="Sekolah Informatika Utama" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Galeri</div>
                            <div class="project-name">Siswa Prakerin Tahun 2024</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?php echo e(asset('images/smk-2.jpg')); ?>" title="Gambar Sekolah">
                        <img class="img-fluid portfolio-img" src="<?php echo e(asset('images/smk-2.jpg')); ?>" alt="Sekolah Informatika Utama" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Galeri</div>
                            <div class="project-name">Siswa Prakerin Tahun 2024</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?php echo e(asset('images/smk-3.jpg')); ?>" title="Gambar Sekolah">
                        <img class="img-fluid portfolio-img" src="<?php echo e(asset('images/smk-3.jpg')); ?>" alt="Sekolah Informatika Utama" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Galeri</div>
                            <div class="project-name">Siswa Prakerin Tahun 2024</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="page-section bg-dark text-light">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4 text-white">Kami Siap Membantu Anda!</h2>
            <a class="btn btn-light btn-xl" href="https://startbootstrap.com/theme/creative/">Hubungi Kami</a>
        </div>
    </section>

    <section class="page-section bg-white text-dark" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">Hubungi Kami</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">Siap untuk memulai perjalanan pendidikan bersama kami? Kirimkan pesan Anda dan kami akan segera menghubungi Anda!</p>
                </div>
            </div>

            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-light rounded">
                        <div class="card-body text-center">
                            <i class="bi bi-geo-alt fs-2 text-primary"></i>
                            <h5 class="my-3">Alamat Kami</h5>
                            <p class="text-muted mb-0">Jl. Pendidikan No. 20, Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-light rounded">
                        <div class="card-body text-center">
                            <i class="bi bi-phone fs-2 text-primary"></i>
                            <h5 class="my-3">Telepon Kami</h5>
                            <p class="text-muted mb-0">+62 123 456 789</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-light rounded">
                        <div class="card-body text-center">
                            <i class="bi bi-envelope fs-2 text-primary"></i>
                            <h5 class="my-3">Email Kami</h5>
                            <p class="text-muted mb-0">info@smk-informatikautama.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer bg-dark text-light">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-4 mb-4 mb-md-0">
                    <p class="text-center mb-0">© 2025 SMK Informatika Utama. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Mengatur animasi modal untuk smooth transition
        const modalElement = document.getElementById('confirmationModal');
        modalElement.addEventListener('show.bs.modal', function() {
            const modalDialog = modalElement.querySelector('.modal-dialog');
            modalDialog.classList.add('modal-fade-in');
        });

        modalElement.addEventListener('hidden.bs.modal', function() {
            const modalDialog = modalElement.querySelector('.modal-dialog');
            modalDialog.classList.remove('modal-fade-in');
        });

        // Fungsi untuk menangani tombol "Lanjut"
        document.getElementById('continueBtn').addEventListener('click', function() {
            // Redirect ke halaman login atau aksi lainnya
            window.location.href = '<?php echo e(route("login")); ?>'; // Ganti dengan URL yang diinginkan
        });
    </script>

</body>

</html><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/welcome.blade.php ENDPATH**/ ?>