<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'admin'];
        });
    }

    public function guru()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'guru'];
        });
    }

    public function siswa()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'siswa'];
        });
    }
}