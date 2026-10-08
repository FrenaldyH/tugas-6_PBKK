<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    // Course name => assignment titles that fit that course.
    private const COURSES = [
        'PBKK' => ['Routing dan Controller Laravel', 'Blade Layout dan Vite', 'Migration dan Seeder', 'REST API Sederhana'],
        'Basis Data' => ['Normalisasi Skema Perpustakaan', 'Query Agregasi Penjualan', 'Stored Procedure Nilai'],
        'Kecerdasan Buatan' => ['Pencarian A* pada Peta Kampus', 'Klasifikasi Teks Naive Bayes'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = fake()->randomElement(array_keys(self::COURSES));

        return [
            'user_id' => User::factory(),
            'mata_kuliah' => $course,
            'judul' => fake()->randomElement(self::COURSES[$course]),
            'deskripsi' => fake()->boolean(70) ? fake()->sentence(12) : null,
            'link_repo' => fake()->boolean(60) ? 'https://github.com/'.fake()->userName().'/'.fake()->slug(2) : null,
            'dikumpulkan_pada' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
