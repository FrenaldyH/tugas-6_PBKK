# Secure Academic Portal Database — Tugas 6 PBKK

Portal portofolio akademik (Laravel 12 + Breeze) yang menyimpan profil mahasiswa dan proposal ide
proyek **Agentic AI** di MySQL.

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
php artisan migrate --seed    # buat tabel + 15 mahasiswa x 2 project + akun demo

npm install && npm run build
php artisan serve
```

Reset ulang database kapan saja: `php artisan migrate:fresh --seed`.

## Akun demo


| Akun                  | Email                          | Password   |
| --------------------- | ------------------------------ | ---------- |
| Demo penguji (dosen)  | `dosenpbkk@its.ac.id`          | `password` |
| Pemilik portofolio    | `5025241156@student.its.ac.id` | `password` |

15 akun mahasiswa acak hasil seeder juga memakai password `password`.

## Pengujian & standar kode

```bash
php artisan test          # memakai SQLite in-memory, tidak menyentuh MySQL
vendor/bin/pint --test    # cek PSR-12
```
