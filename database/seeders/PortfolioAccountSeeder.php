<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Hand-written accounts with a complete, ready-to-present portfolio.
 * Every write is an updateOrCreate / firstOrCreate, so running db:seed again never duplicates rows.
 */
class PortfolioAccountSeeder extends Seeder
{
    /**
     * Seed the portal owner's real portfolio and the lecturer's demo account.
     */
    public function run(): void
    {
        $this->seedOwner();
        $this->seedDemo();
    }

    /**
     * The portal owner: data moved out of the static profile page of last week's assignment.
     */
    private function seedOwner(): void
    {
        $this->seedPortfolio(
            $this->account('5025241156@student.its.ac.id', 'Frenaldy Bestabba Hasugian'),
            profile: [
                'nrp' => '5025241156',
                'departemen' => 'Teknik Informatika',
                'angkatan' => 2024,
                'bio' => 'Mahasiswa Teknik Informatika ITS angkatan 2024. Sedang merancang TokenPilot, '
                    .'agent yang membantu AI coding bekerja lebih terarah dan hemat token.',
                'github' => 'https://github.com/FrenaldyH',
                'linkedin' => 'https://linkedin.com/in/frenaldyh',
                'keahlian' => ['PHP', 'Laravel', 'JavaScript', 'Tailwind CSS', 'MySQL', 'Git'],
            ],
            assignments: [
                [
                    'judul' => 'Tugas 1 - Sistem Informasi Statik Profil Kelompok',
                    'deskripsi' => 'Website profil akademik enam anggota Kelompok 1 dengan Laravel, Bootstrap 5, dan Vite.',
                    'link_repo' => 'https://github.com/PBKK-B1/sistem-informasi-statistik-profil',
                    'dikumpulkan_pada' => '2026-09-08',
                ],
                [
                    'judul' => 'Tugas 2 - Profil Akademis ITS',
                    'deskripsi' => 'Aplikasi profil akademis statis dengan fokus pada routing Laravel.',
                    'link_repo' => 'https://github.com/FrenaldyH/profil-akademis',
                    'dikumpulkan_pada' => '2026-09-13',
                ],
                [
                    'judul' => 'Tugas 4 - Aplikasi Multi-View Profil Akademik',
                    'deskripsi' => 'Satu master layout Blade, integrasi Tailwind lewat Vite, dan formulir ide riset.',
                    'link_repo' => 'https://github.com/FrenaldyH/tugas-4-PBKK',
                    'dikumpulkan_pada' => '2026-09-27',
                ],
                [
                    'judul' => 'Tugas Microservices - E-Commerce Sederhana',
                    'deskripsi' => 'Tiga service domain, API Gateway, dan service discovery Consul dengan Docker Compose.',
                    'link_repo' => 'https://github.com/FrenaldyH/tugas-microservices-pbkk',
                    'dikumpulkan_pada' => '2026-09-27',
                ],
                [
                    'judul' => 'Tugas 6 - Secure Academic Portal Database',
                    'deskripsi' => 'Migration, relasi, $fillable, factory, dan seeder portal portofolio di MySQL.',
                    'link_repo' => null,
                    'dikumpulkan_pada' => null, // still in progress
                ],
            ],
            projects: [
                [
                    'judul' => 'TokenPilot - Agent Pengatur Konteks untuk AI Coding',
                    'deskripsi' => 'Website Laravel untuk memberi tugas coding. Di belakangnya, agent (local LLM via Ollama) '
                        .'memilih file dan catatan lama yang relevan, mengirim instruksi ke coding AI (Codex/Claude), '
                        .'menjalankan test, lalu memutuskan mencoba lagi atau berhenti. Target: penggunaan token lebih '
                        .'efisien tanpa menurunkan keberhasilan tugas.',
                    'tema_agent' => 'Ollama',
                ],
            ],
        );
    }

    /**
     * Demo account for the lecturer (required by the assignment).
     */
    private function seedDemo(): void
    {
        $this->seedPortfolio(
            $this->account('dosenpbkk@its.ac.id', 'Dosen PBKK'),
            profile: [
                'nrp' => '5025240000',
                'angkatan' => 2024,
                'bio' => 'Akun demo penguji untuk presentasi Tugas 6 PBKK.',
                'keahlian' => ['Laravel', 'MySQL', 'Agentic AI'],
            ],
            assignments: [
                [
                    'judul' => 'Routing dan Controller Laravel',
                    'deskripsi' => 'Contoh riwayat tugas untuk akun demo.',
                    'dikumpulkan_pada' => '2026-09-15',
                ],
                [
                    'judul' => 'Migration dan Seeder Portal Akademik',
                    'deskripsi' => null,
                    'dikumpulkan_pada' => '2026-10-07',
                ],
            ],
            projects: [
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
            ],
        );
    }

    /**
     * Create or refresh a verified login account (password: "password").
     */
    private function account(string $email, string $name): User
    {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => 'password', // hashed by the User model's 'hashed' cast
                'email_verified_at' => now(),
            ],
        );
    }

    /**
     * Attach profile, assignment history and proposal ideas to a user without duplicating them.
     *
     * @param  array<string, mixed>  $profile
     * @param  list<array<string, mixed>>  $assignments
     * @param  list<array<string, mixed>>  $projects
     */
    private function seedPortfolio(User $user, array $profile, array $assignments, array $projects): void
    {
        // hasOne()->updateOrCreate([]) matches on user_id only: one profile per user.
        $user->profile()->updateOrCreate([], $profile);

        foreach ($assignments as $data) {
            $user->assignments()->firstOrCreate(['judul' => $data['judul']], $data);
        }

        // Back-date ideas a day apart so "newest first" ordering is visible on the dashboard.
        foreach ($projects as $i => $data) {
            $project = $user->projects()->firstOrCreate(
                ['judul' => $data['judul']],
                $data + ['api_key_secure' => 'sk-'.Str::random(40)],
            );

            if ($project->wasRecentlyCreated) {
                $project->forceFill(['created_at' => now()->subDays(count($projects) - $i)])->save();
            }
        }
    }
}
