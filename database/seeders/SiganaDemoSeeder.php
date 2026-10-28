<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Safe, repeatable development fixtures for the SIGANA web/mobile clients.
 * Run only against a local development database.
 */
class SiganaDemoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $categories = [
            'Banjir' => 'Simulasi panduan untuk kejadian banjir.',
            'Gempa Bumi' => 'Simulasi panduan untuk kejadian gempa bumi.',
            'Gunung Api' => 'Simulasi panduan untuk aktivitas gunung api.',
            'Tsunami' => 'Simulasi panduan untuk kesiapsiagaan tsunami.',
        ];

        $categoryIds = [];
        foreach ($categories as $name => $description) {
            DB::table('disaster_categories')->insertOrIgnore([
                'name' => $name,
                'description' => $description,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $categoryIds[$name] = DB::table('disaster_categories')->where('name', $name)->value('id');
        }

        $guides = [
            'Banjir' => [
                'Sebelum' => ['[SIMULASI] Siapkan tas siaga', 'Simpan dokumen penting dan kebutuhan dasar dalam tas yang mudah dibawa.'],
                'Saat' => ['[SIMULASI] Pindah ke tempat lebih tinggi', 'Hindari berjalan atau berkendara menerjang arus banjir.'],
                'Sesudah' => ['[SIMULASI] Periksa keamanan rumah', 'Jangan menyalakan listrik sebelum instalasi dinyatakan aman.'],
            ],
            'Gempa Bumi' => [
                'Sebelum' => ['[SIMULASI] Kenali tempat berlindung', 'Tentukan lokasi aman dan jalur keluar bersama keluarga.'],
                'Saat' => ['[SIMULASI] Merunduk, berlindung, dan bertahan', 'Lindungi kepala dan jauhi kaca atau benda yang mudah jatuh.'],
                'Sesudah' => ['[SIMULASI] Waspadai gempa susulan', 'Keluar melalui jalur aman dan ikuti arahan petugas.'],
            ],
            'Gunung Api' => [
                'Sebelum' => ['[SIMULASI] Kenali zona bahaya', 'Pelajari jalur evakuasi resmi dan siapkan masker serta kacamata pelindung.'],
                'Saat' => ['[SIMULASI] Ikuti arahan evakuasi', 'Jauhi kawah, lembah, dan aliran sungai yang berhulu di gunung.'],
                'Sesudah' => ['[SIMULASI] Waspadai lahar dan abu', 'Gunakan pelindung pernapasan dan hindari zona yang belum dinyatakan aman.'],
            ],
            'Tsunami' => [
                'Sebelum' => ['[SIMULASI] Kenali jalur evakuasi tsunami', 'Ketahui rute menuju tempat tinggi atau lokasi evakuasi resmi.'],
                'Saat' => ['[SIMULASI] Segera menjauh dari pantai', 'Setelah gempa kuat atau peringatan resmi, bergerak ke tempat tinggi tanpa menunggu air surut.'],
                'Sesudah' => ['[SIMULASI] Jangan cepat kembali ke pantai', 'Tunggu pengumuman resmi bahwa ancaman tsunami telah berakhir.'],
            ],
        ];

        foreach ($guides as $category => $phases) {
            foreach ($phases as $phase => [$title, $content]) {
                DB::table('mitigations')->updateOrInsert(
                    ['category_id' => $categoryIds[$category], 'title' => $title, 'phase' => $phase],
                    ['content' => $content, 'image' => null, 'updated_at' => $now, 'created_at' => $now],
                );
            }
        }

        // Clearly labeled fixtures, not real incident reports. They are useful for
        // exercising public list/detail/map views without importing personal data.
        $demoDisasters = [
            ['category' => 'Banjir', 'title' => '[SIMULASI] Banjir area uji Padang', 'location' => 'Area simulasi, Padang', 'latitude' => -0.9471, 'longitude' => 100.4172, 'hours_ago' => 3],
            ['category' => 'Gempa Bumi', 'title' => '[SIMULASI] Gempa bumi area uji Bandung', 'location' => 'Area simulasi, Bandung', 'latitude' => -6.9175, 'longitude' => 107.6191, 'hours_ago' => 8],
            ['category' => 'Gunung Api', 'title' => '[SIMULASI] Aktivitas gunung api area uji', 'location' => 'Area simulasi, Selat Sunda', 'latitude' => -6.1020, 'longitude' => 105.4230, 'hours_ago' => 12],
        ];

        foreach ($demoDisasters as $fixture) {
            $categoryId = $categoryIds[$fixture['category']];
            $occurredAt = $now->copy()->subHours($fixture['hours_ago']);
            DB::table('disasters')->updateOrInsert(
                ['title' => $fixture['title']],
                [
                    'category_id' => $categoryId,
                    'location' => $fixture['location'],
                    'latitude' => $fixture['latitude'],
                    'longitude' => $fixture['longitude'],
                    'occurred_at' => $occurredAt->utc()->format('Y-m-d H:i:s'),
                    'status' => 'Dipantau',
                    'verification_status' => 'Disetujui',
                    'approved_at' => $now,
                    'description' => 'Data simulasi untuk pengembangan dan pengujian aplikasi. Ini bukan kejadian nyata.',
                    'photo' => null,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }
}