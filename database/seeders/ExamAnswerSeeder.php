<?php

namespace Database\Seeders;

use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ExamAnswerSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ExamAttempt dan Question sudah ada
        $examAttempts = \App\Models\ExamAttempt::all();
        $questions = \App\Models\Question::all();

        if ($examAttempts->isEmpty() || $questions->isEmpty()) {
            throw new \Exception("Seeder gagal: Pastikan ExamAttempt dan Question sudah di-seed.");
        }

        // Buat data ExamAnswer
        foreach ($examAttempts as $attempt) {
            \App\Models\ExamAnswer::factory()->create([
                'exam_attempt_id' => $attempt->id,
                'question_id' => $questions->random()->id,
                'answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
                'is_correct' => $this->faker->boolean(),
            ]);
        }
    }
}
