# Kontrak API Mobile SIGANA (v1)

Dokumen ini menjadi kontrak integrasi yang disiapkan untuk aplikasi mobile. **Endpoint belum diimplementasikan** pada backend saat ini. Implementasi API membutuhkan route `/api/v1`, autentikasi token (disarankan Laravel Sanctum), dan response JSON sesuai spesifikasi ini.

## Keputusan alur laporan

- Hanya pengguna yang sudah login yang boleh mengirim laporan. Endpoint mobile wajib memerlukan Bearer token; permintaan tanpa token dibalas HTTP 401.
- Setiap laporan baru berstatus `Menunggu` dan tidak masuk daftar publik, pencarian, atau peta sebelum diverifikasi admin.
- Admin menyetujui atau menolak laporan melalui web. Hanya laporan `Disetujui` yang dikirim endpoint publik.
- Request laporan memakai `multipart/form-data`. Foto wajib JPG/JPEG/PNG/WebP, maksimum 4 MB.
- Endpoint laporan perlu rate limit. Jangan terima role/status persetujuan dari aplikasi client.

## Konvensi umum

- Base path: `/api/v1`; JSON memakai UTF-8.
- Tanggal/waktu response ISO 8601 UTC, contoh `2026-10-28T10:30:00Z`. Aplikasi dapat menampilkan dalam zona waktu perangkat.
- Foto bencana disimpan di disk public; response berisi URL absolut `photo_url`, bukan path lokal.
- Daftar menggunakan pagination Laravel: `data`, `links`, dan `meta`.
- Validasi gagal: HTTP 422 dengan `{ "message": "...", "errors": { "field": ["..."] } }`.
- Token dikirim dengan header `Authorization: Bearer <token>`. Login web berbasis cookie tidak dipakai oleh aplikasi mobile.

## Endpoint

| Method dan path | Akses | Hasil/aturan |
|---|---|---|
| `POST /auth/register` | Publik | Daftar akun role `users`; jangan menerima role dari client. |
| `POST /auth/login` | Publik | Email/password; balas user aman dan token API. |
| `POST /auth/logout` | Token | Cabut token perangkat yang sedang dipakai. |
| `GET /me` | Token | Profil akun sendiri; tidak pernah menyertakan password/hash atau blob foto. |
| `PUT /me` | Token | Perbarui profil sendiri; foto via multipart jika dikirim. |
| `GET /categories` | Publik | `{data:[{id,name,description}]}`. |
| `GET /disasters?q=&category_id=&page=` | Publik | Hanya `verification_status=Disetujui`; urut unggahan terbaru. |
| `GET /disasters/{id}` | Publik | Detail hanya jika disetujui; 404 untuk laporan menunggu/ditolak. Sertakan waktu kejadian dan unggah. |
| `GET /map/disasters` | Publik | Hanya laporan disetujui dengan koordinat dan disetujui dalam 7 hari terakhir. |
| `POST /reports` | Bearer token wajib | Isi wajib `category_id`, `title`, `location`, `description`, `occurred_at`, `photo`; `latitude` dan `longitude` opsional tetapi harus dikirim berpasangan. Balas 201 dengan status `Menunggu`, tanpa mempublikasikan laporan. |
| `GET /mitigations?category_id=&phase=` | Publik | Tips keselamatan; filter kategori dan tahap opsional. |
| `GET /emergency-contacts` | Publik | Daftar kontak darurat. |
| `GET /information` | Publik | Informasi yang sudah diterbitkan saja. |
| `GET /notifications` | Token | Notifikasi global dan milik user tersebut saja. |
| `POST /notifications/{id}/read` | Token | Tandai notifikasi milik user sebagai dibaca. |
| `POST /notifications/read-all` | Token | Tandai seluruh notifikasi yang boleh dilihat user sebagai dibaca. |
| `PUT /me/notification-preference` | Token | Body `{ "enabled": true }`; simpan preferensi akun. |

## Bentuk data inti

`GET /disasters` dan `GET /disasters/{id}` mengembalikan field publik berikut:

```json
{
  "id": 12,
  "title": "[SIMULASI] Banjir area uji Padang",
  "category": { "id": 1, "name": "Banjir" },
  "location": "Area simulasi, Padang",
  "latitude": -0.9471,
  "longitude": 100.4172,
  "occurred_at": "2026-10-28T07:30:00Z",
  "uploaded_at": "2026-10-28T10:30:00Z",
  "status": "Dipantau",
  "description": "...",
  "photo_url": null,
  "approved_at": "2026-10-28T10:30:00Z",
  "marker_expires_at": "2026-11-04T10:30:00Z"
}
```

Request `POST /reports` menggunakan nama field yang sama, tanpa `status`, `verification_status`, atau `approved_at`. Server mengambil identitas dari token dan menyimpan `verification_status=Menunggu`. Skema saat ini belum memiliki kolom reporter; tambahkan `reporter_id` nullable dengan foreign key ke `users.id` sebelum implementasi bila identitas pelapor perlu disimpan.

## Contoh response laporan

```json
{
  "message": "Laporan diterima dan menunggu verifikasi admin.",
  "data": {
    "id": 18,
    "title": "Banjir di ...",
    "verification_status": "Menunggu",
    "uploaded_at": "2026-10-28T10:30:00Z"
  }
}
```

## Catatan skema yang harus ditangani saat implementasi

- `disasters` pada schema sekarang belum memiliki `reporter_id`. Endpoint laporan harus tetap mewajibkan autentikasi; tambahkan migration `reporter_id` nullable ke `users.id` jika admin perlu melihat akun pelapor atau pengguna perlu riwayat laporannya.
- Field update timestamp `users` di schema saat ini bernama `update_at`, sedangkan tabel lain memakai `updated_at`.
- Tabel `notifications` tidak memiliki `disaster_id` atau `url`; kalau mobile memerlukan tautan notifikasi langsung ke detail bencana, tambahkan kolom/mapping sebelum endpoint dibuat.
- Marker peta kedaluwarsa 7 hari setelah `approved_at`; berita yang disetujui tetap bisa tampil di daftar bencana setelah marker hilang dari peta.
- Login/token API, push notification FCM/APNs, dan seluruh endpoint di atas belum tersedia. Jangan menguji aplikasi mobile terhadap endpoint ini sebelum backend mengimplementasikannya.