<?php

namespace Database\Factories;

use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class ExamAttemptFactory extends Factory
{
    protected $model = ExamAttempt::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'exam_id' => Exam::factory(),
            'user_id' => User::factory(),
            'started_at' => $faker->dateTimeThisMonth(), // Waktu mulai ujian
            'submitted_at' => $faker->dateTimeThisMonth(), // Waktu selesai ujian
            'score' => $faker->numberBetween(0, 100), // Skor ujian
        ];
    }
}
