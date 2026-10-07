<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    // The dashboard lists only the logged-in user's projects, newest first.
    public function test_dashboard_shows_only_own_projects_newest_first(): void
    {
        $me = User::factory()->create();
        Project::factory()->for($me)->create(['judul' => 'Ide Lama', 'created_at' => now()->subDay()]);
        Project::factory()->for($me)->create(['judul' => 'Ide Baru']);
        Project::factory()->create(['judul' => 'Ide Orang Lain']);

        $this->actingAs($me)
            ->get('/dashboard')
            ->assertOk()
            ->assertSeeInOrder(['Ide Baru', 'Ide Lama'])
            ->assertDontSee('Ide Orang Lain');
    }

    // Deleting a user cascades to their projects; the API key is stored encrypted.
    public function test_projects_cascade_on_user_delete_and_key_is_encrypted(): void
    {
        $project = Project::factory()->create(['api_key_secure' => 'sk-rahasia']);

        $raw = $project->getConnection()->table('projects')->value('api_key_secure');
        $this->assertNotSame('sk-rahasia', $raw);
        $this->assertSame('sk-rahasia', $project->fresh()->api_key_secure);

        $project->user->delete();
        $this->assertDatabaseCount('projects', 0);
    }

    // user_id is not fillable, so it cannot be mass assigned from request data.
    public function test_user_id_is_guarded_from_mass_assignment(): void
    {
        $this->assertNotContains('user_id', (new Project())->getFillable());
    }
}
