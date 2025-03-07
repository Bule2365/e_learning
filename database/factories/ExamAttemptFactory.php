<?php

namespace Database\Factories;

use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamAttemptFactory extends Factory
{
    protected $model = ExamAttempt::class;

    public function definition()
    {
        return [
            'exam_id' => Exam::inRandomOrder()->first() ? Exam::inRandomOrder()->first()->id : Exam::factory()->create()->id,
            'user_id' => User::where('role', 'siswa')->inRandomOrder()->first() ? User::where('role', 'siswa')->inRandomOrder()->first()->id : User::factory()->create(['role' => 'siswa'])->id,
            'started_at' => now(),
            'submitted_at' => now()->addMinutes(30),
            'score' => rand(50, 100),
        ];
    }
}
