<?php

namespace Database\Factories;

use App\Models\TaskUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskUserFactory extends Factory
{
    protected $model = TaskUser::class;

    public function definition()
    {
        return [
            'task_id' => Task::inRandomOrder()->first()->id ?? Task::factory()->create()->id,
            'user_id' => User::where('role', 'siswa')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'siswa'])->id,
            'submission' => $this->faker->sentence(),
            'score' => rand(50, 100),
        ];
    }
}
