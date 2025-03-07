<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'exam_id' => Exam::inRandomOrder()->first()->id ?? Exam::factory()->create()->id,
            'question_text' => $this->faker->sentence(10),
            'options' => json_encode(['A', 'B', 'C', 'D']),
            'correct_answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'type' => 'multiple_choice',
            'image_path' => $this->faker->optional()->imageUrl(),
        ];
    }
}
