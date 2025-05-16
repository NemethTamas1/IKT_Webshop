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
            "name" => fake()->name(),
            'username' => fake()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            "city" => fake()->randomElement(['Csád', 'Felcsút', 'Szilvásvárad', 'Festetics', 'Kiskőrös']),
            "zip" => fake()->regexify('[0-9]{4}'),
            "phone" => fake()->phoneNumber(),
            "country" => "Magyarország",
            'street_name' => fake()->randomElement(['Mészáros utca', 'Felcsút Köz', 'Kastély utca', 'Köztévé tér', 'Szabadsajtó útja', 'Tisza út', 'Áradás tér']),
            "street_type" => fake()->randomElement(['út', 'utca', 'köz', 'tér', 'park', 'dűlő']),
            'street_number' => fake()->numberBetween(1, 200),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
