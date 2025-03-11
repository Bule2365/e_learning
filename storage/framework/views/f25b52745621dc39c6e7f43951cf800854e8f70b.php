<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($attempt->exam->title); ?> - Ujian</title>

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

        .form-check-label {
            font-weight: 500;
        }

        .btn-success {
            border-radius: 50px;
            font-weight: bold;
        }

        #exam-timer {
            font-size: 20px;
            font-weight: 700;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
        }

        .form-check {
            margin-bottom: 15px;
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
                            <img src="<?php echo e(asset('storage/' . $question->image_path)); ?>" alt="Gambar Soal"
                                class="img-fluid mb-2" style="max-width: 400px;">
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

            <button type="submit" class="btn btn-success btn-block">Kumpulkan Ujian</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Custom JS for Timer and Autosave -->
    <script>
        let timeLimit = 60 * 60; // 60 menit dalam detik
        let timerElement = document.getElementById("exam-timer");

        function updateTimerDisplay() {
            let minutes = Math.floor(timeLimit / 60);
            let seconds = timeLimit % 60;
            timerElement.innerHTML = `⏳ Sisa Waktu: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        function countdown() {
            if (timeLimit <= 0) {
                alert("⏳ Waktu habis! Ujian akan dikumpulkan otomatis.");
                document.getElementById("exam-form").submit();
                return;
            }
            timeLimit--;
            updateTimerDisplay();
            setTimeout(countdown, 1000);
        }

        updateTimerDisplay();
        countdown();

        // Auto-save jawaban siswa saat memilih opsi
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
                            console.log('✅ Jawaban berhasil disimpan.');
                        } else {
                            console.error('❌ Gagal menyimpan jawaban:', data.message);
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/show.blade.php ENDPATH**/ ?>