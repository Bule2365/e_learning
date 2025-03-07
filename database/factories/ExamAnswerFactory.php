<?php

namespace Database\Factories;

use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamAnswerFactory extends Factory
{
    protected $model = ExamAnswer::class;

    public function definition()
    {
        return [
            'exam_attempt_id' => ExamAttempt::inRandomOrder()->first() ? ExamAttempt::inRandomOrder()->first()->id : ExamAttempt::factory()->create()->id,
            'question_id' => Question::inRandomOrder()->first() ? Question::inRandomOrder()->first()->id : Question::factory()->create()->id,
            'answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
