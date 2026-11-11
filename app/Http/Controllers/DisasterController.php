<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Support\DisasterCategoryScope;

class DisasterController extends Controller
{
    public function damageScan()
    {
        return view('bencana.scan');
    }

    public function analyzeDamage(Request $request)
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hazard_type' => ['required', 'in:Banjir,Gempa Bumi'],
        ], [
            'photo.required' => 'Pilih foto bangunan terlebih dahulu.',
            'photo.image' => 'File yang dipilih harus berupa gambar.',
            'photo.mimes' => 'Gunakan foto JPG, PNG, atau WebP.',
            'photo.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $imageBytes = file_get_contents($validated['photo']->getRealPath());
        $previewData = 'data:' . $validated['photo']->getMimeType() . ';base64,' . base64_encode($imageBytes);
        if (! config('services.gemini.key')) {
            return view('bencana.scan', [
                'previewData' => $previewData,
                'hazardType' => $validated['hazard_type'],
                'scanError' => 'Pemindai AI belum dikonfigurasi. Tambahkan GEMINI_API_KEY di file .env, lalu jalankan php artisan config:clear.',
            ]);
        }

        $model = config('services.gemini.model', 'gemini-3.8-flash');
        $prompt = <<<'PROMPT'
Periksa foto untuk membantu pengguna mengenali tanda kerusakan bangunan yang terlihat setelah banjir atau gempa. Ini hanya pengamatan visual awal, bukan inspeksi teknik dan bukan penilaian keamanan struktur. Jangan pernah menyatakan bangunan aman untuk dihuni. Jika foto bukan bangunan, terlalu buram, atau tanda tidak dapat dipastikan, nyatakan tidak dapat dinilai dan minta foto yang lebih jelas atau pemeriksaan petugas.
Balas hanya JSON valid dengan bentuk tepat: {"is_building_photo":true,"severity":"Ringan|Sedang|Berat|Tidak dapat dinilai","summary":"maksimal 2 kalimat","signs":["tanda yang benar-benar terlihat"],"actions":["langkah aman yang disarankan"]}. Jangan mengarang kerusakan yang tidak terlihat. Maksimal 4 tanda dan 4 langkah. Untuk tanda bahaya seperti bangunan miring, retakan besar, bagian runtuh, atau kabel terbuka, sarankan menjauh dan menghubungi petugas/112.
PROMPT;
        $prompt = "Konteks bencana yang dipilih pengguna: {$validated['hazard_type']}. Sesuaikan tanda visual dan saran keselamatan hanya jika relevan dengan konteks ini.\n" . $prompt;

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent';
        $payload = [
            'contents' => [[
                'parts' => [
                    ['text' => $prompt],
                    ['inline_data' => [
                        'mime_type' => $validated['photo']->getMimeType(),
                        'data' => base64_encode($imageBytes),
                    ]],
                ],
            ]],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature' => 0.2,
                'maxOutputTokens' => 900,
            ],
        ];

        try {
            $response = null;
            $retryableStatuses = [500, 502, 503, 504];

            // Retry only transient provider/network failures, at most twice.
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                try {
                    $response = Http::connectTimeout(10)
                        ->timeout(45)
                        ->withHeaders(['x-goog-api-key' => config('services.gemini.key')])
                        ->post($url, $payload);
                } catch (ConnectionException $exception) {
                    if ($attempt === 3) {
                        throw $exception;
                    }

                    usleep(500_000 * (2 ** ($attempt - 1)));
                    continue;
                }

                if (! in_array($response->status(), $retryableStatuses, true) || $attempt === 3) {
                    break;
                }

                usleep((600_000 * (2 ** ($attempt - 1))) + random_int(0, 250_000));
            }

            if (! $response->successful()) {
                $status = $response->status();
                Log::warning('SIGANA damage scan provider returned an unsuccessful response.', [
                    'status' => $status,
                    'attempts' => in_array($status, $retryableStatuses, true) ? 3 : 1,
                ]);

                $scanError = match ($status) {
                    503 => 'Layanan Gemini masih penuh setelah dicoba ulang otomatis. Tunggu sebentar, lalu coba analisis lagi.',
                    500, 502, 504 => 'Layanan analisis sedang mengalami gangguan sementara setelah dicoba ulang otomatis. Silakan coba lagi sebentar lagi.',
                    429 => 'Batas permintaan Gemini sedang tercapai (429). Tunggu beberapa saat sebelum mencoba lagi.',
                    default => 'Analisis belum berhasil. Periksa konfigurasi Gemini dan koneksi internet, lalu coba lagi.',
                };

                return view('bencana.scan', [
                    'previewData' => $previewData,
                    'hazardType' => $validated['hazard_type'],
                    'scanError' => $scanError,
                ]);
            }

            $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
            $result = is_string($text) ? json_decode($text, true) : null;
            if (! is_array($result)) {
                return view('bencana.scan', [
                    'previewData' => $previewData,
                    'hazardType' => $validated['hazard_type'],
                    'scanError' => 'Hasil analisis tidak dapat dibaca. Silakan coba lagi dengan foto yang lebih jelas.',
                ]);
            }

            $result = [
                'is_building_photo' => (bool) ($result['is_building_photo'] ?? false),
                'hazard_type' => $validated['hazard_type'],
                'severity' => in_array($result['severity'] ?? '', ['Ringan', 'Sedang', 'Berat', 'Tidak dapat dinilai'], true)
                    ? $result['severity'] : 'Tidak dapat dinilai',
                'summary' => mb_substr(strip_tags((string) ($result['summary'] ?? '')), 0, 500),
                'signs' => $this->cleanScanList($result['signs'] ?? []),
                'actions' => $this->cleanScanList($result['actions'] ?? []),
            ];

            return view('bencana.scan', [
                'previewData' => $previewData,
                'hazardType' => $validated['hazard_type'],
                'result' => $result,
            ]);
        } catch (ConnectionException $exception) {
            Log::warning('SIGANA damage scan could not connect to the AI provider.');
            return view('bencana.scan', [
                'previewData' => $previewData,
                'hazardType' => $validated['hazard_type'],
                'scanError' => 'Layanan analisis tidak dapat dijangkau saat ini. Periksa internet dan coba kembali.',
            ]);
        }
    }

    private function cleanScanList(mixed $items): array
    {
        if (! is_array($items)) return [];

        return collect($items)
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_substr(strip_tags(trim($item)), 0, 240))
            ->take(4)
            ->values()
            ->all();
    }

    public function index(Request $request)
    {
        $categories = DisasterCategoryScope::query()->orderBy('name')->get();

        $disasterQuery = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id');
        DisasterCategoryScope::apply($disasterQuery, 'c.name');

        $disasters = $disasterQuery
            ->where('d.verification_status', 'Disetujui')
            ->select('d.id', 'd.title', 'd.location', 'd.occurred_at', 'd.created_at', 'd.status', 'd.description', 'd.photo', 'c.name as category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . trim($request->input('q')) . '%';
                $query->where(function ($subquery) use ($term) {
                    $subquery->where('d.title', 'like', $term)->orWhere('d.location', 'like', $term);
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('c.id', $request->integer('category')))
            ->orderByRaw('COALESCE(d.created_at, d.occurred_at) DESC')
            ->get();

        return view('bencana.index', compact('categories', 'disasters'));
    }

    public function show(int $id)
    {
        $disasterQuery = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id');
        DisasterCategoryScope::apply($disasterQuery, 'c.name');

        $disaster = $disasterQuery
            ->where('d.id', $id)
            ->where('d.verification_status', 'Disetujui')
            ->select('d.*', 'c.name as category')
            ->first();

        abort_if(! $disaster, 404);

        $mitigations = DB::table('mitigations')
            ->where('category_id', $disaster->category_id)
            ->orderBy('phase')
            ->orderBy('id')
            ->get();

        return view('bencana.detail', compact('disaster', 'mitigations'));
    }
}
