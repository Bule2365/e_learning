<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        // Buat 10 kelas
        $classes = ClassModel::factory()->count(3)->create();

        // Hubungkan siswa ke kelas
        $students = User::where('role', 'siswa')->get();
        foreach ($classes as $class) {
            $class->siswa()->attach($students->random(rand(5, 15))->pluck('id')); // Random 5-15 siswa per kelas
        }
    }
}
