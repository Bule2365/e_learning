<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Material;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\File;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data agar tidak terjadi duplikasi
        foreach ([User::class, ClassModel::class, Subject::class, Exam::class, Question::class, ExamAttempt::class, ExamAnswer::class, Material::class, Task::class, TaskUser::class] as $model) {
            $model::truncate();
        }

        DB::table('class_user')->truncate();
        DB::table('subject_class')->truncate();

        DB::beginTransaction();
        try {
            // ✅ 1. Buat Admin (2 admin)
            User::factory(2)->create(['role' => 'admin']);

            // ✅ 2. Buat Guru (10 guru)
            $teachers = User::factory(10)->create(['role' => 'guru']);

            // ✅ 3. Buat Siswa (200 siswa)
            $students = User::factory(200)->create(['role' => 'siswa']);

            // ✅ 4. Buat Kelas (10 kelas, masing-masing 20 siswa)
            $classes = ClassModel::factory(10)->create();
            $classes->each(function ($class) use ($students) {
                $class->users()->attach($students->random(20)->pluck('id'));
            });

            // ✅ 5. Buat Mata Pelajaran (1 guru = 1 mata pelajaran)
            $subjects = $teachers->map(function ($teacher) {
                return Subject::factory()->create([
                    'user_id' => $teacher->id,
                ]);
            });

            // ✅ 6. Setiap mata pelajaran terkait dengan 1-3 kelas
            $subjects->each(function ($subject) use ($classes) {
                $subject->kelas()->attach($classes->random(rand(1, 3))->pluck('id'));
            });

            // ✅ 7. Buat 20 Ujian (1 guru = 2 ujian)
            $exams = collect();
            foreach ($teachers as $teacher) {
                for ($i = 0; $i < 2; $i++) {
                    $exams->push(Exam::factory()->create([
                        'user_id' => $teacher->id,
                        'subject_id' => $subjects->where('user_id', $teacher->id)->first()->id,
                        'class_id' => $classes->random()->id,
                        'status' => ['draft', 'published'][rand(0, 1)],
                    ]));
                }
            }

            // ✅ 8. Buat 200 Soal (10 soal per ujian)
            $questions = $exams->flatMap(function ($exam) {
                return Question::factory(10)->create([
                    'exam_id' => $exam->id,
                    'image_path' => $this->generateDummyFile('question_images'), // Generate file soal
                ]);
            });

            // ✅ 9. Buat 30 Materi (3 Materi per Guru) dengan file
            $teachers->each(function ($teacher) use ($subjects, $classes) {
                Material::factory(3)->create([
                    'user_id' => $teacher->id,
                    'subject_id' => $subjects->where('user_id', $teacher->id)->first()->id,
                    'class_id' => $classes->random()->id,
                    'file_path' => json_encode($this->generateMultipleFiles('materials')), // Generate file materi
                ]);
            });

            // ✅ 10. Buat 50 Tugas (5 Tugas per Guru) dengan file
            $teachers->each(function ($teacher) use ($subjects, $classes) {
                Task::factory(5)->create([
                    'user_id' => $teacher->id,
                    'subject_id' => $subjects->where('user_id', $teacher->id)->first()->id,
                    'class_id' => $classes->random()->id,
                    'file_path' => json_encode($this->generateMultipleFiles('tasks')), // Generate file tugas
                ]);
            });

            // ✅ 11. Buat 200 Jawaban Tugas (Setiap siswa mengerjakan 1 tugas)
            $taskUserInserts = $students->map(function ($student) {
                return [
                    'task_id' => Task::inRandomOrder()->first()->id,
                    'user_id' => $student->id,
                    'submission' => 'Submission for task',
                    'score' => rand(50, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            DB::table('task_user')->insert($taskUserInserts);

            DB::commit(); // ✅ Jika semua sukses, commit perubahan
        } catch (\Exception $e) {
            DB::rollBack(); // 🔴 Jika error, rollback semua perubahan
            throw $e;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Generate satu file dummy untuk storage
     */
    private function generateDummyFile($directory)
    {
        // Pilih format file secara random
        $extensions = ['jpg', 'png', 'pdf', 'mp4'];
        $extension = $extensions[array_rand($extensions)];
        $fileName = uniqid('file_') . '.' . $extension;

        // Simpan file ke storage
        Storage::put("public/{$directory}/{$fileName}", 'Dummy Content');

        return "storage/{$directory}/{$fileName}";
    }

    /**
     * Generate beberapa file dummy untuk storage (materi/tugas)
     */
    private function generateMultipleFiles($directory)
    {
        $files = [];
        for ($i = 0; $i < rand(1, 3); $i++) { // Maksimal 3 file
            $files[] = $this->generateDummyFile($directory);
        }
        return $files;
    }

    // public function run()
    // {
    //     DB::disableQueryLog(); // Matikan query log agar lebih cepat
    //     DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Matikan foreign key sementara
    //     DB::beginTransaction(); // Mulai transaksi untuk mencegah error jika ada gagal

    //     // 1️⃣ Buat Admin
    //     User::factory(2)->create(['role' => 'admin']);

    //     // 2️⃣ Buat Guru (10 orang)
    //     $teachers = User::factory(10)->create(['role' => 'guru']);

    //     // 3️⃣ Buat Siswa (200 orang)
    //     $students = User::factory(200)->create(['role' => 'siswa']);

    //     // 4️⃣ Buat Kelas (10 kelas, masing-masing 20 siswa)
    //     $classes = ClassModel::factory(10)->create();
    //     foreach ($classes as $class) {
    //         $class->siswa()->attach($students->random(20)->pluck('id'));
    //     }

    //     // 5️⃣ Buat Mata Pelajaran (10 mata pelajaran, setiap guru 1 mapel)
    //     $subjects = Subject::factory(10)->create();
    //     foreach ($subjects as $subject) {
    //         $subject->user_id = $teachers->random()->id; // Pastikan ada guru
    //         $subject->save();
    //     }

    //     // **Pastikan Guru Punya Mapel**
    //     $teacherSubjectsMap = $teachers->mapWithKeys(function ($teacher) use ($subjects) {
    //         return [$teacher->id => $subjects->where('user_id', $teacher->id)->pluck('id')];
    //     });

    //     // 6️⃣ Buat Ujian (20 ujian, setiap guru membuat 2 ujian)
    //     $exams = collect();
    //     foreach ($teachers as $teacher) {
    //         if ($teacherSubjectsMap[$teacher->id]->isNotEmpty()) {
    //             $teacherSubjects = $teacherSubjectsMap[$teacher->id];
    //             foreach ($teacherSubjects->random(min(2, $teacherSubjects->count())) as $subjectId) {
    //                 $exams->push(Exam::factory()->create([
    //                     'user_id' => $teacher->id,
    //                     'class_id' => $classes->random()->id,
    //                     'subject_id' => $subjectId,
    //                 ]));
    //             }
    //         }
    //     }

    //     // **Cek apakah exams sudah ada sebelum membuat questions**
    //     if ($exams->count() == 0) {
    //         throw new \Exception("Seeder Gagal: Tidak ada ujian yang tersedia untuk membuat soal.");
    //     }

    //     // 7️⃣ Buat 200 Soal (10 soal per ujian)
    //     $questions = collect();
    //     foreach ($exams as $exam) {
    //         $questions = $questions->merge(Question::factory(10)->create([
    //             'exam_id' => $exam->id,
    //         ]));
    //     }

    //     // 8️⃣ Buat 200 Percobaan Ujian (Setiap siswa ikut 1 ujian acak)
    //     $examAttempts = collect();
    //     foreach ($students as $student) {
    //         $exam = $exams->random();
    //         $examAttempts->push(ExamAttempt::factory()->create([
    //             'exam_id' => $exam->id,
    //             'user_id' => $student->id,
    //         ]));
    //     }

    //     // 9️⃣ Buat 2000 Jawaban Ujian (Setiap siswa menjawab semua soal ujian yang diikutinya)
    //     foreach ($examAttempts as $attempt) {
    //         $examQuestions = $questions->where('exam_id', $attempt->exam_id);
    //         foreach ($examQuestions as $question) {
    //             ExamAnswer::factory()->create([
    //                 'exam_attempt_id' => $attempt->id,
    //                 'question_id' => $question->id,
    //             ]);
    //         }
    //     }

    //     // 🔟 Buat 30 Materi (Setiap materi berisi 2-5 file acak)
    //     Material::factory(30)->create()->each(function ($material) {
    //         $files = [];
    //         for ($i = 0; $i < rand(2, 5); $i++) {
    //             $files[] = Storage::url('materials/' . uniqid() . '.pdf');
    //         }
    //         $material->file_path = json_encode($files);
    //         $material->save();
    //     });

    //     // 1️⃣1️⃣ Buat 50 Tugas (Setiap tugas berisi 2-5 file acak)
    //     Task::factory(50)->create()->each(function ($task) {
    //         $files = [];
    //         for ($i = 0; $i < rand(2, 5); $i++) {
    //             $files[] = Storage::url('tasks/' . uniqid() . '.pdf');
    //         }
    //         $task->file_path = json_encode($files);
    //         $task->save();
    //     });

    //     // 1️⃣2️⃣ Buat 200 Jawaban Tugas (Nilai antara 50-100)
    //     foreach ($students as $student) {
    //         foreach (Task::inRandomOrder()->limit(1)->get() as $task) {
    //             TaskUser::factory()->create([
    //                 'task_id' => $task->id,
    //                 'user_id' => $student->id,
    //                 'submission' => Storage::url('submissions/' . uniqid() . '.pdf'),
    //                 'score' => rand(50, 100),
    //             ]);
    //         }
    //     }

    //     DB::commit(); // Simpan semua data dengan aman
    //     DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Hidupkan kembali foreign key constraints
    // }
}
