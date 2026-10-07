<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Builds realistic Agentic AI proposal ideas from a few domain/skill building blocks.
 *
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    // What the agent does for its users.
    private const ROLES = [
        'Asisten Penjadwalan Praktikum',
        'Tutor Pemrograman Adaptif',
        'Analis Sentimen Ulasan UMKM',
        'Pemantau Kualitas Udara Kampus',
        'Penyusun Ringkasan Jurnal Ilmiah',
        'Konsultan Akademik Mahasiswa Baru',
        'Detektor Plagiarisme Kode',
        'Pengelola Inventaris Laboratorium',
        'Asisten Triase Keluhan Layanan Publik',
        'Perencana Rute Logistik Desa',
    ];

    // The technique that makes it "agentic".
    private const TECHNIQUES = [
        'berbasis RAG',
        'dengan Multi-Agent Orchestration',
        'menggunakan Tool Calling',
        'dengan Memori Jangka Panjang',
        'berbasis ReAct Reasoning',
        'dengan Human-in-the-Loop',
    ];

    // Possible values for tema_agent (the LLM / framework the agent runs on).
    private const THEMES = ['Ollama', 'OpenAI', 'Claude', 'Gemini', 'LangChain', 'CrewAI'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->randomElement(self::ROLES);
        $technique = fake()->randomElement(self::TECHNIQUES);
        $theme = fake()->randomElement(self::THEMES);

        return [
            'user_id' => User::factory(),
            'judul' => "Agent {$role} {$technique}",
            // Roughly 1 in 5 ideas has no description yet, exercising the nullable column.
            'deskripsi' => fake()->boolean(80)
                ? "Agent ini berperan sebagai {$role} yang berjalan di atas {$theme}. "
                    ."Pendekatan {$technique} dipakai agar agent mampu {$this->goal()}. "
                    .'Target pengguna: '.fake()->randomElement(['mahasiswa', 'dosen', 'staf tendik', 'masyarakat umum']).'.'
                : null,
            'tema_agent' => $theme,
            'api_key_secure' => 'sk-'.Str::random(40),
        ];
    }

    /**
     * Pick a concrete outcome sentence for the description.
     */
    private function goal(): string
    {
        return fake()->randomElement([
            'merencanakan langkah kerja sendiri sebelum memanggil API eksternal',
            'mengambil dokumen relevan dari basis pengetahuan kampus',
            'berkolaborasi dengan agent lain untuk memecah tugas kompleks',
            'meminta konfirmasi manusia sebelum mengambil keputusan penting',
            'mengingat preferensi pengguna dari sesi sebelumnya',
        ]);
    }
}
