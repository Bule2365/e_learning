<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'title' => $faker->randomElement([
                'Tugas Matematika',
                'Tugas Bahasa Indonesia',
                'Tugas IPA',
                'Tugas IPS',
                'Tugas Agama',
            ]),
            'description' => $faker->paragraph(2), // Deskripsi tugas dalam bahasa Indonesia
            'file_path' => $faker->imageUrl(), // Gambar dummy sebagai file path
            'subject_id' => Subject::factory(),
            'class_id' => ClassModel::factory(),
            'user_id' => User::factory(),
            'due_date' => $faker->dateTimeBetween('+1 week', '+1 month'), // Batas waktu tugas
        ];
    }
}
