<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'type' => $this->faker->randomElement(['video', 'image', 'text']), // Sesuaikan dengan batasan kolom
            'file_path' => $this->faker->imageUrl(640, 480, 'nature', true), // Pastikan URL tidak terlalu panjang
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
            'class_id' => ClassModel::factory(),
        ];
    }
}
