<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'exam_id' => Exam::factory(),
            'question_text' => $faker->sentence(8), // Pertanyaan dalam bahasa Indonesia
            'options' => json_encode($faker->randomElements(['A', 'B', 'C', 'D'], 4)), // Opsi jawaban
            'correct_answer' => $faker->randomElement(['A', 'B', 'C', 'D']), // Jawaban benar
            'type' => $faker->randomElement(['multiple_choice', 'essay']), // Tipe soal
            'image_path' => $faker->optional()->imageUrl(), // Gambar opsional
        ];
    }
}
