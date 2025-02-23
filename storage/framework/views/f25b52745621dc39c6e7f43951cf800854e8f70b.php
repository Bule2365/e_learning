

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="text-center"><?php echo e($attempt->exam->title); ?></h2>
        <p class="text-center text-muted"><?php echo e($attempt->exam->description); ?></p>

        <form id="exam-form" action="<?php echo e(route('siswa.exams.submit', $attempt->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php $__currentLoopData = $soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Ambil jawaban siswa jika ada
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
                                            data-question-id="<?php echo e($question->id); ?>" data-attempt-id="<?php echo e($attempt->id); ?>"
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

    <script>
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
                            console.log('Jawaban berhasil disimpan.');
                        } else {
                            console.error('Gagal menyimpan jawaban:', data.message);
                            alert(data.message); // Tampilkan error ke pengguna
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\e_learning\resources\views/siswa/exams/show.blade.php ENDPATH**/ ?>