<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Material;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Buat Admin
        User::factory(2)->create(['role' => 'admin']);

        // 2. Buat Guru
        $teachers = User::factory(5)->create(['role' => 'guru']);

        // 3. Buat Siswa
        $students = User::factory(20)->create(['role' => 'siswa']);

        // 4. Buat Kelas
        $classes = ClassModel::factory(3)->create();

        // 5. Hubungkan Siswa ke Kelas secara merata
        foreach ($classes as $class) {
            $class->siswa()->attach($students->random(rand(5, 10))->pluck('id'));
        }

        // 6. Buat Mata Pelajaran dan Tetapkan ke Guru
        $subjects = collect(['PAI', 'PKN', 'DKV', 'IPA', 'MTK', 'TKJ'])->map(function ($name) use ($teachers) {
            return Subject::create([
                'name' => $name,
                'user_id' => $teachers->random()->id,
            ]);
        });

        // 7. Buat Ujian dan Hubungkan dengan Kelas, Mata Pelajaran, dan Guru
        $exams = Exam::factory(10)->create()->each(function ($exam) use ($classes, $subjects, $teachers) {
            $exam->class_id = $classes->random()->id;
            $exam->subject_id = $subjects->random()->id;
            $exam->user_id = $teachers->random()->id;
            $exam->save();
        });

        // 8. Buat Soal Ujian dan Hubungkan ke Ujian
        $questions = Question::factory(30)->create()->each(function ($question) use ($exams) {
            $question->exam_id = $exams->random()->id;
            $question->save();
        });

        // 9. Buat Upaya Ujian (Siswa yang mengikuti ujian)
        $examAttempts = collect();
        foreach ($exams as $exam) {
            $siswaDikelas = $exam->kelas->siswa()->inRandomOrder()->limit(3)->get();
            foreach ($siswaDikelas as $siswa) {
                $examAttempts->push(ExamAttempt::create([
                    'exam_id' => $exam->id,
                    'user_id' => $siswa->id,
                    'started_at' => now(),
                    'submitted_at' => now()->addMinutes(30),
                    'score' => rand(50, 100),
                ]));
            }
        }

        // 10. Buat Jawaban untuk Upaya Ujian (ExamAnswer)
        $examAttemptIds = ExamAttempt::pluck('id')->toArray();
        $questionIds = Question::pluck('id')->toArray();

        if (!empty($examAttemptIds) && !empty($questionIds)) {
            ExamAnswer::factory(50)->create()->each(function ($answer) use ($examAttemptIds, $questionIds) {
                $answer->exam_attempt_id = $examAttemptIds[array_rand($examAttemptIds)];
                $answer->question_id = $questionIds[array_rand($questionIds)];
                $answer->save();
            });
        } else {
            throw new \Exception("Seeder Gagal: Tidak ada data di ExamAttempt atau Question.");
        }

        // 11. Buat Materi
        Material::factory(10)->create()->each(function ($material) use ($classes, $subjects, $teachers) {
            $material->class_id = $classes->random()->id;
            $material->subject_id = $subjects->random()->id;
            $material->user_id = $teachers->random()->id;
            $material->save();
        });

        // 12. Buat Tugas
        Task::factory(20)->create()->each(function ($task) use ($classes, $subjects, $teachers) {
            $task->class_id = $classes->random()->id;
            $task->subject_id = $subjects->random()->id;
            $task->user_id = $teachers->random()->id;
            $task->save();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Hidupkan kembali foreign key checks
    }
}
