<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail, // Pastikan email unik
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['admin', 'guru', 'siswa']),
        ];
    }
}
