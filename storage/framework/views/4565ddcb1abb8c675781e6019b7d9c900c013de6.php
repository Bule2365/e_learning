<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persiapan Ujian</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            font-weight: 700;
        }

        h4 {
            font-weight: 600;
        }

        .btn-success {
            border-radius: 50px;
            font-weight: bold;
        }

        .text-primary {
            color: #007bff !important;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        ul li {
            padding: 5px 0;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="text-center">
            <h2 class="fw-bold">⏳ Persiapan Ujian</h2>
            <p class="text-muted">Pastikan Anda siap sebelum memulai ujian ini.</p>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <h4 class="text-primary fw-bold"><?php echo e($exam->title); ?></h4>
            <p><?php echo e($exam->description); ?></p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">📄 Jumlah Soal: <strong><?php echo e($exam->soal->count()); ?></strong></li>
                <li class="list-group-item">⏳ Waktu: <strong>60 menit</strong>
                </li>
            </ul>

            <a href="<?php echo e(route('siswa.exams.start', $exam->id)); ?>" class="btn btn-success w-100 mt-3">
                🚀 Mulai Ujian
            </a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/preparation.blade.php ENDPATH**/ ?>