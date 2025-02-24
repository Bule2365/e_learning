<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        // Buat 55 materi
        $materials = Material::factory()->count(10)->create();

        // Hubungkan materi dengan kelas, mata pelajaran, dan guru
        $classes = ClassModel::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'guru')->get();

        foreach ($materials as $material) {
            $material->class_id = $classes->random()->id; // Random kelas
            $material->subject_id = $subjects->random()->id; // Random mata pelajaran
            $material->user_id = $teachers->random()->id; // Random guru
            $material->save();
        }
    }
}
