<?php

namespace Database\Factories;

use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class ClassModelFactory extends Factory
{
    protected $model = ClassModel::class;

    public function definition()
    {
        static $index = 1; // Gunakan index untuk memastikan nama unik

        return [
            'name' => 'Kelas ' . $index++, // Pastikan tidak ada kelas ganda
            'deskripsi' => $this->faker->sentence(6),
        ];
    }
}
