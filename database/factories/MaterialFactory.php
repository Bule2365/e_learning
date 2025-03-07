<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        // Generate file acak (2-5 file)
        $fileCount = rand(2, 5);
        $files = [];
        for ($i = 0; $i < $fileCount; $i++) {
            $files[] = Storage::url('materials/' . uniqid() . '.pdf');
        }

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'type' => $this->faker->randomElement(['video', 'image', 'text']),
            'file_path' => json_encode($files), // Simpan dalam format JSON
            'subject_id' => Subject::inRandomOrder()->first() ? Subject::inRandomOrder()->first()->id : Subject::factory()->create()->id,
            'user_id' => User::inRandomOrder()->first() ? User::inRandomOrder()->first()->id : User::factory()->create()->id,
            'class_id' => ClassModel::inRandomOrder()->first() ? ClassModel::inRandomOrder()->first()->id : ClassModel::factory()->create()->id,
        ];
    }
}
