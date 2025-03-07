<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        static $index = 0; // Agar tidak membuat lebih dari 10 mata pelajaran

        $subjects = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Agama', 'Seni Budaya', 'Fisika', 'Kimia', 'Biologi', 'Sejarah'];

        return [
            'name' => $subjects[$index++ % count($subjects)], // Pastikan hanya ada 10
            'user_id' => User::where('role', 'guru')->inRandomOrder()->first()->id, // Pastikan ada guru
        ];
    }
}
