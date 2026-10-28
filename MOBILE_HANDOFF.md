# Handoff Backend SIGANA untuk Aplikasi Mobile

Dokumen ini merangkum keadaan project Laravel untuk teman yang mengerjakan aplikasi mobile. Dokumen ini tidak menyertakan `.env`, password, token, atau data pengguna.

## Ringkasan status sekarang

- Repository: https://github.com/fathurpradana/Sigana
- Branch: `main`
- Commit terakhir yang tercatat: `59dedfc` (`Update SIGANA features and interface`)
- Versi dari project: PHP `^8.3`, Laravel Framework `v13.30.1` (terkunci di `composer.lock`). Lingkungan laptop web yang digunakan: PHP 8.3.16 dan MySQL 8.4.3.
- Project saat ini hanya menyediakan route web di `routes/web.php`. `routes/api.php` belum ada dan Laravel Sanctum belum terpasang. Jadi aplikasi mobile belum dapat memakai login sesi web sebagai autentikasi API.
- File skema aktual untuk dibagikan: `database/sigana_schema.sql`. File ini diekspor dari database MySQL Laragon pada 28 Oktober 2026, berisi struktur 8 tabel SIGANA tanpa baris data. Seeder bawaan membuat `test@example.com`; seeder khusus data demo SIGANA tersedia di `database/seeders/SiganaDemoSeeder.php` dan dijalankan dengan `php artisan db:seed --class=SiganaDemoSeeder`.
- Ada perubahan lokal yang belum masuk ke GitHub. Teman sebaiknya mengambil source setelah perubahan yang diperlukan sudah di-commit dan di-push.

## Skema database dan batasannya

Gunakan `database/sigana_schema.sql` sebagai file struktur terbaru. File `sigana.sql` lama yang sebelumnya diberikan di luar repository tidak cocok dengan database aktif. Database aktif telah diekspor dengan struktur terkini, termasuk kolom:

- `disasters.verification_status` dan `disasters.approved_at` (alur verifikasi admin dan masa tampil marker peta).
- Kolom profil pengguna seperti `city`, `address`, `birth_date`, `gender`, `notifications_enabled`, `profile_photo`, dan `profile_photo_mime`.
- Kode memakai `users.update_at` sebagai timestamp update; nama ini berbeda dari `updated_at` Laravel pada tabel lain.

Jangan gunakan `php artisan migrate:fresh` pada database yang berisi data karena perintah tersebut menghapus tabel. Gunakan `database/sigana_schema.sql` untuk membuat database development kosong. File tersebut berisi struktur aktual 8 tabel tanpa data, dan mencakup kolom verifikasi serta profil yang dibutuhkan kode. Jika database berubah, ekspor ulang schema-only dari database aktif. File `sigana.sql` lama jangan dianggap sebagai skema final.
## Tabel yang digunakan aplikasi

Nama dan kolom berikut diringkas dari schema-only dump database aktif dan pemakaian kode.

| Tabel | Kolom penting yang dipakai aplikasi | Aturan publik |
|---|---|---|
| `disaster_categories` | `id`, `name`, `description` | Bisa dibaca publik untuk filter/kategori laporan. |
| `disasters` | `id`, `category_id`, `title`, `location`, `latitude`, `longitude`, `occurred_at`, `status`, `description`, `photo`, `created_at`, `updated_at`, `verification_status`, `approved_at` | Publik hanya boleh menerima laporan dengan `verification_status = Disetujui`. Laporan Menunggu/Ditolak tidak boleh dikirim ke aplikasi umum. Marker peta aktif 7 hari sejak disetujui. |
| `mitigations` | `id`, `category_id`, `title`, `phase`, `content`, `image` | Bisa dibaca publik. |
| `emergency_contacts` | `id`, `name`, `agency`, `phone`, `address`, `description` | Bisa dibaca publik. |
| `general_information` | `id`, `title`, `content`, `image`, `published_at` | Publik hanya yang sudah dipublikasikan (`published_at` null atau tidak di masa depan, sesuai aturan web saat ini). |
| `users` | `id`, `name`, `email`, `password`, `role`, `phone`, `city`, `address`, `birth_date`, `gender`, `notifications_enabled`, `profile_photo`, `profile_photo_mime`, `created_at`, `update_at` | Data profil hanya untuk pemilik akun/admin berwenang. Jangan pernah kirim `password`, hash password, atau blob foto mentah dari endpoint JSON umum. |
| `notifications` | `id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at` | Hanya pengumuman global (`user_id` null) dan notifikasi yang memang boleh diterima pengguna. |

`*` Kolom ini dipakai kode saat ini, tetapi tidak ada di DDL `sigana.sql` lama yang diperiksa. Cocokkan dengan database terbaru.

Foto laporan bencana disimpan sebagai file di disk `public` (nilai `disasters.photo` adalah path), bukan blob database. Foto profil sebaliknya disimpan sebagai blob di kolom `users.profile_photo` dengan MIME di `profile_photo_mime`. API sebaiknya mengembalikan URL foto yang bisa diakses perangkat, bukan isi blob/file lokal.

## Setup development di komputer teman

1. Clone repository:
   ```bash
   git clone https://github.com/fathurpradana/Sigana.git
   cd Sigana
   ```
2. Pastikan PHP 8.3+, Composer, ekstensi PHP Laravel/MySQL, dan MySQL 8.x tersedia. Node.js hanya diperlukan bila teman juga membangun aset frontend Laravel.
3. Install dependency dan buat `.env` lokal:
   ```bash
   composer install
   copy .env.example .env
   php artisan key:generate
   ```
4. Buat database development bernama `sigana`, lalu isi `.env` lokal (jangan commit file ini):
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sigana
   DB_USERNAME=root
   DB_PASSWORD=
   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   ```
5. Import `database/sigana_schema.sql` ke database development yang kosong. File ini membuat database `sigana` bila belum ada dan membuat 8 tabel aplikasi; file tidak berisi data pengguna. Migration repository belum mencatat migration khusus SIGANA, jadi jangan jalankan `php artisan migrate` setelah import ini (migration bawaan akan bentrok dengan tabel yang sudah dibuat). Untuk sesi/cache/queue lokal, atur `SESSION_DRIVER=file`, `CACHE_STORE=file`, dan `QUEUE_CONNECTION=sync` di `.env`.
6. Untuk mencoba tampilan dengan data fiktif, jalankan `php artisan db:seed --class=SiganaDemoSeeder`. Seeder membuat panduan keselamatan dan tiga bencana berlabel `[SIMULASI]`; jalankan hanya di database development lokal.
7. Jalankan:
   ```bash
   php artisan storage:link
   php artisan serve --host=0.0.0.0 --port=8000
   ```

Jangan membagikan `.env` atau database production. Untuk development gunakan akun/data dummy dan schema-only dump.

## Alamat backend saat pengembangan mobile

- Android Emulator resmi: `http://10.0.2.2:8000` untuk mengakses server Laravel pada laptop yang sama.
- Ponsel fisik: jalankan server dengan `--host=0.0.0.0`, lalu gunakan IP LAN laptop, misalnya `http://192.168.x.x:8000` (ponsel dan laptop pada jaringan Wi-Fi yang sama; firewall Windows mungkin perlu mengizinkan port 8000).
- `127.0.0.1` atau `localhost` di ponsel menunjuk ke ponsel itu sendiri, bukan laptop.
- Untuk uji di luar jaringan lokal, gunakan server staging HTTPS. Jangan expose database MySQL langsung ke internet.

## API mobile

Kontrak integrasi yang sudah disiapkan ada di `MOBILE_API_CONTRACT.md`. Aturan laporan: hanya pengguna login yang boleh mengirim; laporan masuk sebagai `Menunggu`; hanya laporan yang disetujui admin dapat dibaca publik. Endpoint API masih belum dibuat. Backend memerlukan route `/api/v1`, autentikasi token (disarankan Sanctum), dan response JSON sesuai kontrak sebelum aplikasi mobile dapat disambungkan.

Perhatikan batas skema: tabel `disasters` belum memiliki `user_id`, dan tabel `notifications` belum memiliki `disaster_id` atau URL tujuan. Kontrak membahas dampaknya dan menghindari asumsi relasi yang belum ada.

## Checklist sebelum teman mulai integrasi

- [ ] Commit/push source terbaru agar perubahan lokal ikut tersedia di GitHub.
- [x] Schema-only dump aktual tersedia di `database/sigana_schema.sql`; tidak berisi data pengguna.
- [x] Skema sudah diekspor dari database aktif; kebutuhan dan batas kolom dicatat di atas.
- [x] Laporan wajib dari pengguna yang login; status awal Menunggu dan perlu persetujuan admin.
- [x] Kontrak API, format tanggal ISO 8601 UTC, URL foto, dan aturan publik ada di `MOBILE_API_CONTRACT.md`.
- [ ] Implementasikan API token (misalnya Sanctum) dan endpoint yang disetujui.
- [ ] Sediakan server staging atau instruksi IP lokal untuk pengujian.
- [x] Data contoh tersedia di `database/seeders/SiganaDemoSeeder.php`; hanya untuk development.

Kontak/repository diberikan oleh pemilik project; kredensial admin dan password database tidak dicantumkan di dokumen ini.
