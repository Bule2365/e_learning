<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($attempt->exam->title); ?> - Ujian</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            padding: 20px;
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            border-radius: 50px;
            font-weight: bold;
        }

        #exam-timer {
            font-size: 20px;
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center"><?php echo e($attempt->exam->title); ?></h2>
        <p class="text-center text-muted"><?php echo e($attempt->exam->description); ?></p>

        <!-- Timer Countdown -->
        <div id="exam-timer" class="text-center bg-danger text-white py-2 rounded mb-3">
            ⏳ Sisa Waktu: 60:00
        </div>

        <form id="exam-form" action="<?php echo e(route('siswa.exams.submit', $attempt->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php $__currentLoopData = $soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $studentAnswer = $attempt->upayaUjian->where('question_id', $question->id)->first();
                ?>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6><?php echo e($loop->iteration); ?>. <?php echo e($question->question_text); ?></h6>

                        <?php if($question->image_path): ?>
                            <div class="text-center">
                                <img src="<?php echo e(asset('storage/' . $question->image_path)); ?>" alt="Gambar Soal"
                                    class="img-fluid rounded mb-2" style="max-width: 100%; height: auto;">
                            </div>
                        <?php endif; ?>


                        <div class="mb-4">
                            <?php if($question->type == 'multiple_choice'): ?>
                                <?php $__currentLoopData = json_decode($question->options, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input class="form-check-input answer-input" type="radio"
                                            name="answers[<?php echo e($question->id); ?>]" value="<?php echo e($key); ?>"
                                            id="option<?php echo e($question->id); ?>_<?php echo e($key); ?>"
                                            data-question-id="<?php echo e($question->id); ?>"
                                            data-attempt-id="<?php echo e($attempt->id); ?>"
                                            <?php echo e($studentAnswer && $studentAnswer->answer == $key ? 'checked' : ''); ?>>
                                        <label class="form-check-label"
                                            for="option<?php echo e($question->id); ?>_<?php echo e($key); ?>">
                                            <?php echo e($key); ?>. <?php echo e($option); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <textarea name="answers[<?php echo e($question->id); ?>]" rows="3" class="form-control answer-input"
                                    data-question-id="<?php echo e($question->id); ?>" data-attempt-id="<?php echo e($attempt->id); ?>"><?php echo e($studentAnswer ? $studentAnswer->answer : ''); ?></textarea>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <button type="button" id="submit-exam" class="btn btn-success btn-block">Kumpulkan Ujian</button>
        </form>
    </div>

    <script>
        let examKey = "exam_timer_<?php echo e($attempt->id); ?>";
        let timeLimit = localStorage.getItem(examKey) ? parseInt(localStorage.getItem(examKey)) :
            300; // 5 menit (300 detik)
        let timerElement = document.getElementById("exam-timer")

        function updateTimerDisplay() {
            let minutes = Math.floor(timeLimit / 60);
            let seconds = timeLimit % 60;
            timerElement.innerHTML = `⏳ Sisa Waktu: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        function countdown() {
            if (timeLimit <= 0) {
                Swal.fire({
                    title: "⏳ Waktu Habis!",
                    text: "Ujian akan dikumpulkan otomatis.",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 2000,
                    willClose: () => {
                        document.getElementById("exam-form").submit();
                    }
                });
                return;
            }
            timeLimit--;
            localStorage.setItem(examKey, timeLimit); // Simpan waktu ke LocalStorage
            updateTimerDisplay();
            setTimeout(countdown, 1000);
        }

        updateTimerDisplay();
        countdown();

        document.getElementById("exam-form").addEventListener("submit", function() {
            localStorage.removeItem(examKey); // Hapus waktu setelah submit
        });


        document.getElementById("submit-exam").addEventListener("click", function() {
            Swal.fire({
                title: "Yakin ingin mengumpulkan?",
                text: "Pastikan semua jawaban sudah diisi dengan benar.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Kumpulkan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Mengumpulkan Ujian...",
                        text: "Mohon tunggu sebentar.",
                        icon: "info",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            setTimeout(() => {
                                document.getElementById("exam-form").submit();
                            }, 2000);
                        }
                    });
                }
            });
        });

        document.querySelectorAll('.answer-input').forEach(input => {
            input.addEventListener('change', function() {
                let attemptId = this.dataset.attemptId;
                let questionId = this.dataset.questionId;
                let answer = this.value;

                fetch(`/siswa/exams/answer/${attemptId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            answer: answer
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: "Jawaban tersimpan",
                                showConfirmButton: false,
                                timer: 1000
                            });
                        } else {
                            Swal.fire("Gagal!", data.message, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Kesalahan!", "Gagal menyimpan jawaban.", "error");
                    });
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/show.blade.php ENDPATH**/ ?>