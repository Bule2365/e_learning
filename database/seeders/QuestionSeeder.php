<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Buat 100 pertanyaan
        $questions = Question::factory()->count(100)->create();

        // Hubungkan pertanyaan dengan ujian
        $exams = Exam::all();

        foreach ($questions as $question) {
            $question->exam_id = $exams->random()->id; // Random ujian
            $question->save();
        }
    }
}
