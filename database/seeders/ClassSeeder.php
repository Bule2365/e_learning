<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 6; $i++) {
            ClassModel::create([
                'name' => 'Kelas ' . $i,
                'deskripsi' => 'Deskripsi Kelas ' . $i,
            ]);
        }
    }
}
