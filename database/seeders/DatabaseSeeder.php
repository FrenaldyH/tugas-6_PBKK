<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed 15 random students, then the hand-written portfolio accounts.
     */
    public function run(): void
    {
        // Random students: each gets a profile, two proposal ideas and two past assignments.
        User::factory(15)
            ->has(Profile::factory())
            ->has(Project::factory()->count(2))
            ->has(Assignment::factory()->count(2))
            ->create();

        $this->call(PortfolioAccountSeeder::class);
    }
}
