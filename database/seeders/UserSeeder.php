<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'bule2365@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'galadi',
                'email' => 'galadi@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'kala',
                'email' => 'kalaaa@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Agus',
                'email' => 'agus187@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'Guru',
            ],
            [
                'name' => 'maula',
                'email' => 'maula012@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
