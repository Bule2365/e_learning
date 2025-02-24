<?php

namespace Database\Factories;

use App\Models\ExamAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamAnswerFactory extends Factory
{
    protected $model = ExamAnswer::class;

    public function definition()
    {
        return [
            'exam_attempt_id' => null, // Akan diisi di seeder
            'question_id' => null,    // Akan diisi di seeder
            'answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
