# SIM Skripsi & Bimbingan - Laravel

Aplikasi web Laravel + Tailwind + MariaDB untuk pengajuan judul, bimbingan proposal/skripsi, pendaftaran seminar/sidang, monitoring, approval digital, notifikasi internal, arsip skripsi, dan manajemen pengguna.

## Instalasi

```bash
cd vitra-skripsi-laravel-fixed
composer install
copy .env.example .env
php artisan key:generate
```

Linux/macOS:

```bash
cp .env.example .env
php artisan key:generate
```

Buat database MariaDB:

```sql
CREATE DATABASE vitra_skripsi;
```

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vitra_skripsi
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan database dan storage:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Akun demo

- jurusan@unmus.ac.id / password
- dosen@unmus.ac.id / password
- mahasiswa@unmus.ac.id / password

## Fitur

- Login/register multi-role: mahasiswa, dosen, jurusan
- Dashboard monitoring
- Pengajuan judul dan review jurusan
- Penetapan dosen pembimbing
- Catatan bimbingan proposal/skripsi
- Review bimbingan oleh dosen
- Pendaftaran seminar proposal/sidang skripsi
- Verifikasi dan penjadwalan sidang oleh jurusan
- Arsip skripsi PDF dan pencarian referensi
- Notifikasi internal
- Manajemen pengguna oleh jurusan
