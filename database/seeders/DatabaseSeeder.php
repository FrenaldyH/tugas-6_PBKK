<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed 15 random students (2 projects each) plus one demo account for the lecturer.
     */
    public function run(): void
    {
        // Random students; each one gets two dummy proposal ideas.
        User::factory(15)
            ->has(Project::factory()->count(2))
            ->create();

        $this->seedDemoAccount();
    }

    /**
     * Demo account with a ready-to-present portfolio.
     * updateOrCreate / firstOrCreate make re-running db:seed safe (no duplicate email error).
     */
    private function seedDemoAccount(): void
    {
        $demo = User::updateOrCreate(
            ['email' => 'dosenpbkk@its.ac.id'],
            [
                'name' => 'Dosen PBKK',
                'password' => 'password', // hashed by the User model's 'hashed' cast
                'email_verified_at' => now(),
            ],
        );

        $projects = [
            [
                'judul' => 'Agent Asisten Praktikum PBKK berbasis RAG',
                'deskripsi' => 'Menjawab pertanyaan mahasiswa tentang modul praktikum Laravel dengan mengambil '
                    .'potongan materi dari slide dan dokumentasi resmi sebelum menyusun jawaban.',
                'tema_agent' => 'Ollama',
            ],
            [
                'judul' => 'Agent Reviewer Kode Laravel Otomatis',
                'deskripsi' => 'Memeriksa pull request tugas mahasiswa terhadap standar PSR-12, keamanan mass '
                    .'assignment, dan migration yang tidak memakai foreign key.',
                'tema_agent' => 'Claude',
            ],
            [
                'judul' => 'Agent Perencana Proyek Akhir Kelompok',
                'deskripsi' => null, // still a draft: shows the nullable column in action
                'tema_agent' => 'CrewAI',
            ],
        ];

        // Back-date them a day apart so "newest first" ordering is visible on the dashboard.
        foreach ($projects as $i => $data) {
            $project = $demo->projects()->firstOrCreate(
                ['judul' => $data['judul']],
                $data + ['api_key_secure' => 'sk-demo-'.str_repeat((string) $i, 32)],
            );

            if ($project->wasRecentlyCreated) {
                $project->forceFill(['created_at' => now()->subDays(count($projects) - $i)])->save();
            }
        }
    }
}
