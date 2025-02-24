<?php

namespace Database\Seeders;

use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Exam;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Seeder;

class ExamAttemptSeeder extends Seeder
{
    public function run()
    {
        // Buat 70 upaya ujian
        $attempts = ExamAttempt::factory()->count(70)->create();

        // Hubungkan upaya ujian dengan ujian dan siswa
        $exams = Exam::all();
        $students = User::where('role', 'siswa')->get();

        foreach ($attempts as $attempt) {
            $attempt->exam_id = $exams->random()->id; // Random ujian
            $attempt->user_id = $students->random()->id; // Random siswa
            $attempt->save();
        }

        // Buat 200 jawaban ujian
        $answers = ExamAnswer::factory()->count(200)->create();

        // Hubungkan jawaban ujian dengan upaya ujian dan pertanyaan
        $questions = Question::all();

        foreach ($answers as $answer) {
            $answer->exam_attempt_id = $attempts->random()->id; // Random upaya ujian
            $answer->question_id = $questions->random()->id; // Random pertanyaan
            $answer->save();
        }
    }
}
