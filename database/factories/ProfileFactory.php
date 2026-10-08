<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     * NRP and intake year are derived from the owner's email (NRP@student.its.ac.id),
     * so the profile always matches the login account.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = ['PHP', 'Laravel', 'Python', 'JavaScript', 'MySQL', 'Docker', 'Git', 'Tailwind CSS', 'LangChain'];

        return [
            'user_id' => User::factory(),
            // ponytail: one lookup per profile; fine for seeding a few dozen rows.
            'nrp' => fn (array $attributes) => Str::before(User::find($attributes['user_id'])->email, '@'),
            'angkatan' => fn (array $attributes) => 2000 + (int) substr($attributes['nrp'], 4, 2),
            'departemen' => 'Teknik Informatika',
            'bio' => fake()->boolean(70)
                ? 'Mahasiswa Informatika yang tertarik pada '.fake()->randomElement([
                    'rekayasa perangkat lunak', 'kecerdasan buatan', 'keamanan siber', 'sistem terdistribusi',
                ]).'.'
                : null,
            'github' => fake()->boolean(60) ? 'https://github.com/'.fake()->unique()->userName() : null,
            'linkedin' => null,
            'keahlian' => fake()->randomElements($skills, fake()->numberBetween(2, 5)),
        ];
    }
}
