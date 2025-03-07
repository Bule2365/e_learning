<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // public function run(): void
    // {
    //     for ($i = 1; $i <= 6; $i++) {
    //         User::create([
    //             'name' => 'Guru ' . $i,
    //             'email' => 'guru' . $i . '@example.com',
    //             'password' => Hash::make('password'),
    //             'role' => 'guru',
    //         ]);
    //     }

    //     // Buat 60 siswa
    //     for ($i = 1; $i <= 60; $i++) {
    //         User::create([
    //             'name' => 'Siswa ' . $i,
    //             'email' => 'siswa' . $i . '@example.com',
    //             'password' => Hash::make('password'),
    //             'role' => 'siswa',
    //         ]);
    //     }
    // }

    public function run(): void
    {
        // Buat 5 admin
        // User::factory()->count(3)->create(['role' => 'admin']);

        // // Buat 100 guru
        // User::factory()->count(18)->create(['role' => 'guru']);

        // // Buat 500 siswa
        // User::factory()->count(156)->create(['role' => 'siswa']);
    }
}
