<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ITS student number: 5025 (Informatics) + 2-digit intake year + 4 digits.
        // Intake 2021-2023 only, so a fake student can never collide with a real 2024 NRP.
        $year = fake()->randomElement(['21', '22', '23']);
        // ponytail: unique() only holds within one run; a second db:seed without fresh has a ~0.75%
        // chance of reusing an NRP. migrate:fresh --seed is always safe.
        $nrp = fake()->unique()->numerify("5025{$year}####");

        return [
            'name' => fake()->name(),
            'email' => "{$nrp}@student.its.ac.id",
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
