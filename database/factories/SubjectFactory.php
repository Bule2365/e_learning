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
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk bahasa Indonesia

        return [
            'name' => $faker->randomElement([
                'Matematika',
                'Bahasa Indonesia',
                'IPA',
                'IPS',
                'Agama',
                'Seni Budaya',
            ]),
            'user_id' => User::factory(),
        ];
    }
}
