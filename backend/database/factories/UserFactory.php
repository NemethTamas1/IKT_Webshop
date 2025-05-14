<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'role' => "user",
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'shipping_country' => 'Hungary',
            'shipping_city' => fake()->randomElement(['Budapest', 'Győr', 'Békéscsaba', 'Felcsút', 'Csád', 'Ózd']),
            'shipping_zip' => fake()->numberBetween(1000, 2000),
            'shipping_street' => fake()->randomElement(['Mészáros utca', 'Felcsút Köz', 'Kastély utca', 'Köztévé tér', 'Szabadsajtó útja', 'Tisza út', 'Áradás tér']),
            'shipping_street_number' => fake()->numberBetween(1, 200),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
