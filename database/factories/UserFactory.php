<?php
// database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['user', 'mitra']),
            'phone' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'photo' => null,
            'is_active' => $this->faker->boolean(90),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'name' => 'Admin ' . $this->faker->name(),
            ];
        });
    }

    public function mitra()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'mitra',
                'name' => 'Mitra ' . $this->faker->name(),
                'alamat' => $this->faker->address(),
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
