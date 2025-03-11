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
        <h2 class="text-center mb-4">Persiapan Ujian</h2>

        <div class="card shadow-sm p-4">
            <h4 class="text-primary">📌 Instruksi Ujian</h4>
            <ul>
                <li>Pastikan Anda berada di tempat yang nyaman dan tenang.</li>
                <li>Gunakan perangkat dengan koneksi internet yang stabil.</li>
                <li>Siapkan alat tulis jika diperlukan.</li>
                <li>Jangan keluar dari halaman ujian sebelum selesai.</li>
            </ul>

            <h4 class="text-primary mt-3">📄 Detail Ujian</h4>
            <p><strong>Nama Ujian:</strong> {{ $exam->title }}</p>
            <p><strong>Durasi:</strong> <span class="text-danger"><b>60 menit</b></span></p>
            <p><strong>Jumlah Soal:</strong> {{ $exam->questions_count }}</p>

            <div class="text-center mt-4">
                <a href="{{ route('siswa.exams.start', $exam->id) }}" class="btn btn-success btn-lg">
                    Saya Siap, Mulai Ujian 🚀
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
