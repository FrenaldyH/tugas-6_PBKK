<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Hand-written accounts with a complete, ready-to-present portfolio:
 * every member of Kelompok 1 plus the lecturer's demo account.
 * Every write is an updateOrCreate / firstOrCreate, so running db:seed again never duplicates rows.
 */
class PortfolioAccountSeeder extends Seeder
{
    // The group's shared Agentic AI proposal; every member owns their own copy (projects.user_id is required).
    private const TOKENPILOT = [
        'judul' => 'TokenPilot - Agent Pengatur Konteks untuk AI Coding',
        'deskripsi' => 'Website Laravel untuk memberi tugas coding. Di belakangnya, agent (local LLM via Ollama) '
            .'memilih file dan catatan lama yang relevan, mengirim instruksi ke coding AI (Codex/Claude), '
            .'menjalankan test, lalu memutuskan mencoba lagi atau berhenti. Target: penggunaan token lebih '
            .'efisien tanpa menurunkan keberhasilan tugas.',
        'tema_agent' => 'Ollama',
    ];

    // Group assignments every member worked on.
    private const GROUP_ASSIGNMENTS = [
        [
            'judul' => 'Tugas 1 - Sistem Informasi Statik Profil Kelompok',
            'deskripsi' => 'Website profil akademik enam anggota Kelompok 1 dengan Laravel, Bootstrap 5, dan Vite.',
            'link_repo' => 'https://github.com/PBKK-B1/sistem-informasi-statistik-profil',
            'dikumpulkan_pada' => '2026-09-08',
        ],
        [
            'judul' => 'Tugas 6 - Secure Academic Portal Database',
            'deskripsi' => 'Migration, relasi, $fillable, factory, dan seeder portal portofolio kelompok di MySQL.',
            'link_repo' => null,
            'dikumpulkan_pada' => null, // still in progress
        ],
    ];

    // Kelompok 1 members; biodata taken from the group's Tugas 1 profile page.
    private const MEMBERS = [
        [
            'name' => 'Mitra Partogi',
            'nrp' => '5025241017',
            'bio' => 'Saya adalah mahasiswa semester 5 Program Studi Teknik Informatika ITS yang tertarik menjadi '
                .'programmer andal di bidang pemrograman kompetitif dan sains data.',
            'linkedin' => 'http://www.linkedin.com/in/mitra-partogi',
            'keahlian' => ['C/C++', 'Python', 'HTML', 'TypeScript', 'Next.js', 'React', 'Microsoft Office', 'Google Spreadsheets'],
        ],
        [
            'name' => 'Dimas Setiaji',
            'nrp' => '5025241056',
            'bio' => 'Motivated to contribute to interactive projects and continuously improving technical and creative skills.',
            'linkedin' => 'https://www.linkedin.com/in/dimas-setiaji-596b33335/',
            'keahlian' => ['C', 'C++', 'C#', 'HTML', 'CSS', 'UI/UX Design', 'Figma', 'Game Mechanics Design'],
        ],
        [
            'name' => 'Steven Alvin Christian',
            'nrp' => '5025241116',
            'bio' => 'Mahasiswa Teknik Informatika ITS yang tertarik pada bidang Data Science, Artificial Intelligence, '
                .'dan Machine Learning.',
            'linkedin' => 'http://www.linkedin.com/in/stevenalvinchristian',
            'keahlian' => ['Python', 'C/C++', 'SQL', 'Tableau', 'Microsoft Office'],
        ],
        [
            'name' => 'Frenaldy Bestabba Hasugian',
            'nrp' => '5025241156',
            'bio' => 'Mahasiswa Teknik Informatika ITS angkatan 2024. Sedang merancang TokenPilot, '
                .'agent yang membantu AI coding bekerja lebih terarah dan hemat token.',
            'github' => 'https://github.com/FrenaldyH',
            'linkedin' => 'https://linkedin.com/in/frenaldyh',
            'keahlian' => ['PHP', 'Laravel', 'JavaScript', 'Tailwind CSS', 'MySQL', 'Git'],
            // Individual assignments, on top of the group ones.
            'assignments' => [
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
            ],
        ],
        [
            'name' => 'Hoshida Ahmad Tsalatsu Fadlulloh',
            'nrp' => '5025241174',
            'bio' => 'Saya Adalah Mahasiswa Semester 5 Program Studi Teknik Informatika ITS yang tertarik di bidang '
                .'Game Development',
            'linkedin' => 'https://www.linkedin.com/in/hoshida-ahmad-tsalatsu-fadlulloh-328167323/',
            'keahlian' => ['C/C++', 'SQL', 'Canva', 'Microsoft Excel'],
        ],
        [
            'name' => 'Isabella Sienna Sulisthio',
            'nrp' => '5025241199',
            'bio' => 'Saya adalah mahasiswa semester 5 Program Studi Teknik Informatika ITS yang tertarik di bidang AI '
                .'khususnya Computer Vision.',
            'linkedin' => 'https://www.linkedin.com/in/isabellasienna',
            'keahlian' => ['C', 'C++', 'SQL', 'Python', 'Web Programming', 'Figma', 'Canva', 'Microsoft Office'],
        ],
    ];

    /**
     * Seed every group member's portfolio, then the lecturer's demo account.
     */
    public function run(): void
    {
        foreach (self::MEMBERS as $member) {
            $this->seedPortfolio(
                $this->account("{$member['nrp']}@student.its.ac.id", $member['name']),
                profile: [
                    'nrp' => $member['nrp'],
                    'departemen' => 'Teknik Informatika',
                    'angkatan' => 2000 + (int) substr($member['nrp'], 4, 2),
                    'bio' => $member['bio'],
                    'github' => $member['github'] ?? null,
                    'linkedin' => $member['linkedin'],
                    'keahlian' => $member['keahlian'],
                ],
                assignments: [...self::GROUP_ASSIGNMENTS, ...($member['assignments'] ?? [])],
                projects: [self::TOKENPILOT],
            );
        }

        $this->seedDemo();
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
