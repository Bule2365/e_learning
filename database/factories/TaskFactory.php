<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        // Generate file acak (2-5 file)
        $fileCount = rand(2, 5);
        $files = [];
        for ($i = 0; $i < $fileCount; $i++) {
            $files[] = Storage::url('tasks/' . uniqid() . '.pdf');
        }

        return [
            'title' => $this->faker->randomElement([
                'Tugas Matematika',
                'Tugas Bahasa Indonesia',
                'Tugas IPA',
                'Tugas IPS',
                'Tugas Agama'
            ]),
            'description' => $this->faker->paragraph(2),
            'file_path' => json_encode($files), // Simpan dalam format JSON
            'subject_id' => Subject::factory(),
            'class_id' => ClassModel::factory(),
            'user_id' => User::factory(),
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
