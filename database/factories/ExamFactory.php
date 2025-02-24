<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'user_id' => User::factory(),
            'class_id' => ClassModel::factory(),
            'subject_id' => Subject::factory(),
            'title' => $faker->randomElement([
                'Ujian Matematika',
                'Ujian Bahasa Indonesia',
                'Ujian IPA',
                'Ujian IPS',
                'Ujian Agama',
            ]),
            'description' => $faker->paragraph(2), // Deskripsi ujian dalam bahasa Indonesia
            'status' => $faker->randomElement(['draft', 'published']), // Status ujian
        ];
    }
}
