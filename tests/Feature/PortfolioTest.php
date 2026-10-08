<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Profile;
use App\Models\User;
use Database\Seeders\PortfolioAccountSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    // The dashboard shows the logged-in user's own profile and assignment history only.
    public function test_dashboard_shows_own_profile_and_assignments(): void
    {
        $me = Profile::factory()->create()->user;
        Assignment::factory()->for($me)->create(['judul' => 'Tugas Saya']);
        $other = Profile::factory()->create();
        Assignment::factory()->create(['judul' => 'Tugas Orang Lain']);

        $this->actingAs($me)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee($me->profile->nrp)
            ->assertSee('Tugas Saya')
            ->assertDontSee($other->nrp)
            ->assertDontSee('Tugas Orang Lain');
    }

    // Profile NRP mirrors the login email, and a user cannot own two profiles.
    public function test_profile_matches_email_and_is_one_per_user(): void
    {
        $profile = Profile::factory()->create();
        $this->assertSame($profile->nrp.'@student.its.ac.id', $profile->user->email);

        $this->expectException(QueryException::class);
        $profile->user->profile()->create(['nrp' => '5025999999', 'angkatan' => 2099]);
    }

    // Every group member gets their own TokenPilot copy, and re-seeding adds no duplicates.
    public function test_group_seeder_gives_each_member_tokenpilot_and_is_idempotent(): void
    {
        $this->seed(PortfolioAccountSeeder::class);
        $this->seed(PortfolioAccountSeeder::class);

        $members = User::where('email', 'like', '%@student.its.ac.id')->with('profile', 'projects')->get();

        $this->assertCount(6, $members);
        foreach ($members as $member) {
            $this->assertSame($member->profile->nrp.'@student.its.ac.id', $member->email);
            $this->assertSame(['TokenPilot - Agent Pengatur Konteks untuk AI Coding'], $member->projects->pluck('judul')->all());
        }
        $this->assertDatabaseCount('users', 7); // 6 members + lecturer demo account
        $this->assertDatabaseCount('projects', 6 + 3);
    }

    // Deleting a user removes their profile and assignment history too (cascade).
    public function test_user_delete_cascades_to_profile_and_assignments(): void
    {
        $user = Profile::factory()->create()->user;
        Assignment::factory()->for($user)->count(2)->create();

        $user->delete();

        $this->assertDatabaseCount('profiles', 0);
        $this->assertDatabaseCount('assignments', 0);
    }
}
