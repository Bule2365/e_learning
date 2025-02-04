<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setiap kelas berisi 1 guru dan 10 murid
        $kelas = ClassModel::all();

        foreach ($kelas as $index => $class) {
            // Ambil guru untuk kelas ini (1 guru untuk setiap kelas)
            $guru = User::where('role', 'guru')->skip($index)->first();

            // Assign guru ke kelas
            $class->guru()->attach($guru->id);

            // Assign 10 siswa ke kelas
            $siswa = User::where('role', 'siswa')->skip($index * 10)->take(10)->get();
            foreach ($siswa as $s) {
                $class->siswa()->attach($s->id);
            }
        }
    }
}
