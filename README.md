# Secure Academic Portal Database — Tugas 6 PBKK

Portal portofolio akademik **Kelompok 1** (Laravel 12 + Breeze) yang menyimpan profil anggota, riwayat tugas
kuliah, dan proposal ide proyek **Agentic AI** kelompok — **TokenPilot** — di MySQL.

## Anggota Kelompok 1

| Nama                             | NRP        |
| -------------------------------- | ---------- |
| Mitra Partogi                    | 5025241017 |
| Dimas Setiaji                    | 5025241056 |
| Steven Alvin Christian           | 5025241116 |
| Frenaldy Bestabba Hasugian       | 5025241156 |
| Hoshida Ahmad Tsalatsu Fadlulloh | 5025241174 |
| Isabella Sienna Sulisthio        | 5025241199 |

Seluruh anggota berkontribusi pada rancangan TokenPilot.

## Skema

- `users` — tabel bawaan Breeze (kredensial login), email `unique()`.
- `profiles` — biodata akademik (NRP unik, departemen, angkatan, bio, keahlian), satu per user.
- `assignments` — riwayat tugas kuliah.
- `projects` — `judul`, `deskripsi` (nullable), `tema_agent` (default `Ollama`), `api_key_secure` (terenkripsi).
- Semua tabel anak terikat ke `users.id` dengan `ON DELETE CASCADE`.
- Dashboard menampilkan hanya profil, riwayat tugas, dan project milik user yang login, terurut terbaru.

## Setup database lokal

Prasyarat: PHP 8.2+ dengan ekstensi `pdo_mysql`, Composer, Node.js, dan MySQL 8 (atau Docker).

```bash
composer install
cp .env.example .env
php artisan key:generate

docker compose up -d          # MySQL 8.4 dengan kredensial dari .env (lewati jika sudah punya MySQL)
php artisan migrate --seed    # buat tabel + 15 mahasiswa acak x 2 project + 6 akun anggota + akun demo

npm install && npm run build
php artisan serve
```

Reset ulang database kapan saja: `php artisan migrate:fresh --seed`.

## Akun login

| Akun                 | Email                         | Password   |
| -------------------- | ----------------------------- | ---------- |
| Demo penguji (dosen) | `dosenpbkk@its.ac.id`         | `password` |
| Anggota kelompok     | `<NRP>@student.its.ac.id`     | `password` |

Contoh: `5025241156@student.its.ac.id`. Setiap anggota melihat profil, riwayat tugas, dan proposal TokenPilot
miliknya sendiri. 15 akun mahasiswa acak hasil seeder juga memakai password `password`.

## Pengujian & standar kode

```bash
php artisan test          # memakai SQLite in-memory, tidak menyentuh MySQL
vendor/bin/pint --test    # cek PSR-12
```
