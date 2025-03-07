<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        return [
            'user_id' => User::where('role', 'guru')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'guru'])->id,
            'class_id' => ClassModel::inRandomOrder()->first()->id ?? ClassModel::factory()->create()->id,
            'subject_id' => Subject::inRandomOrder()->first()->id ?? Subject::factory()->create()->id,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
