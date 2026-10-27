<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => DB::table('users')->count(),
            'disasters' => DB::table('disasters')->count(),
            'pending_reports' => DB::table('disasters')->where('verification_status', 'Menunggu')->count(),
            'categories' => DB::table('disaster_categories')->count(),
        ];

        $categories = DB::table('disaster_categories')->orderBy('name')->get();
        $disasters = DB::table('disasters as d')->leftJoin('disaster_categories as c', 'c.id', '=', 'd.category_id')
            ->select('d.*', 'c.name as category_name')
            ->orderByRaw("CASE d.verification_status WHEN 'Menunggu' THEN 0 WHEN 'Ditolak' THEN 1 ELSE 2 END")
            ->orderByDesc('d.created_at')->get();
        $tips = DB::table('mitigations as m')->leftJoin('disaster_categories as c', 'c.id', '=', 'm.category_id')
            ->select('m.*', 'c.name as category_name')->orderBy('m.phase')->orderByDesc('m.id')->get();
        $contacts = DB::table('emergency_contacts')->orderBy('name')->get();
        $information = DB::table('general_information')->orderByDesc('published_at')->orderByDesc('id')->get();
        $users = DB::table('users')->select('id', 'name', 'email', 'role', 'created_at')->orderByDesc('id')->get();
        $notifications = DB::table('notifications')->orderByDesc('created_at')->get();

        return view('admin.manage', compact('stats', 'categories', 'disasters', 'tips', 'contacts', 'information', 'users', 'notifications'));
    }

    public function storeDisaster(Request $request)
    {
        $data = $this->validateDisaster($request);
        $data['occurred_at'] = Carbon::parse($data['occurred_at'], 'Asia/Jakarta')->utc();
        $data['photo'] = $request->file('photo')->store('disasters', 'public');
        $data['created_at'] = $data['updated_at'] = now();
        $data['approved_at'] = now();
        DB::table('disasters')->insert($data);
        return $this->back('Berita bencana berhasil ditambahkan.', 'bencana-admin');
    }

    public function updateDisaster(Request $request, int $id)
    {
        $data = $this->validateDisaster($request, false);
        $data['occurred_at'] = Carbon::parse($data['occurred_at'], 'Asia/Jakarta')->utc();
        $data['updated_at'] = now();
        if ($request->hasFile('photo')) {
            $old = DB::table('disasters')->where('id', $id)->value('photo');
            if ($old) Storage::disk('public')->delete($old);
            $data['photo'] = $request->file('photo')->store('disasters', 'public');
        }
        abort_unless(DB::table('disasters')->where('id', $id)->exists(), 404);
        DB::table('disasters')->where('id', $id)->update($data);
        return $this->back('Berita bencana berhasil diperbarui.', 'bencana-admin');
    }

    public function destroyDisaster(int $id)
    {
        $photo = DB::table('disasters')->where('id', $id)->value('photo');
        abort_unless(DB::table('disasters')->where('id', $id)->exists(), 404);
        DB::table('disasters')->where('id', $id)->delete();
        if ($photo) Storage::disk('public')->delete($photo);
        return $this->back('Berita bencana berhasil dihapus.', 'bencana-admin');
    }

    private function validateDisaster(Request $request, bool $photoRequired = true): array
    {
        return $request->validate([
            'category_id' => ['required', 'integer', 'exists:disaster_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'occurred_at' => ['required', 'date'],
            'status' => ['required', Rule::in(['Dilaporkan', 'Dipantau', 'Aktif', 'Selesai'])],
            'description' => ['required', 'string', 'max:10000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'photo' => [$photoRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }

    public function verifyDisaster(Request $request, int $id)
    {
        $data = $request->validate([
            'verification_status' => ['required', Rule::in(['Disetujui', 'Ditolak'])],
            'latitude' => [$request->input('verification_status') === 'Disetujui' ? 'required' : 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => [$request->input('verification_status') === 'Disetujui' ? 'required' : 'nullable', 'numeric', 'between:-180,180'],
        ]);

        $disaster = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
            ->where('d.id', $id)
            ->select('d.id', 'd.title', 'd.location', 'd.verification_status', 'd.approved_at', 'c.name as category')
            ->first();
        abort_unless($disaster, 404);

        $updates = [
            'verification_status' => $data['verification_status'],
            'updated_at' => now(),
        ];

        // Simpan titik yang dipilih admin agar dashboard dapat menampilkan marker.
        if ($data['verification_status'] === 'Disetujui') {
            $updates['latitude'] = $data['latitude'];
            $updates['longitude'] = $data['longitude'];

            if ($disaster->verification_status !== 'Disetujui' || ! $disaster->approved_at) {
                $updates['approved_at'] = now();
            }
        }

        DB::table('disasters')->where('id', $id)->update($updates);

        if ($data['verification_status'] === 'Disetujui' && $disaster->verification_status !== 'Disetujui') {
            DB::table('notifications')->insert([
                'user_id' => null,
                'title' => 'Laporan bencana diverifikasi',
                'message' => $disaster->category . ' dilaporkan di ' . $disaster->location . '.',
                'type' => 'Laporan',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $message = $data['verification_status'] === 'Disetujui'
            ? 'Laporan disetujui dan sekarang tampil kepada pengguna.'
            : 'Laporan ditolak dan tidak ditampilkan kepada pengguna.';

        return $this->back($message, 'bencana-admin');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:disaster_categories,name'], 'description' => ['nullable', 'string', 'max:2000']]);
        $data['created_at'] = $data['updated_at'] = now();
        DB::table('disaster_categories')->insert($data);
        return $this->back('Kategori berhasil ditambahkan.', 'kategori-admin');
    }

    public function updateCategory(Request $request, int $id)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('disaster_categories', 'name')->ignore($id)], 'description' => ['nullable', 'string', 'max:2000']]);
        abort_unless(DB::table('disaster_categories')->where('id', $id)->exists(), 404);
        $data['updated_at'] = now();
        DB::table('disaster_categories')->where('id', $id)->update($data);
        return $this->back('Kategori berhasil diperbarui.', 'kategori-admin');
    }

    public function destroyCategory(int $id)
    {
        if (DB::table('disasters')->where('category_id', $id)->exists() || DB::table('mitigations')->where('category_id', $id)->exists()) {
            return $this->back('Kategori masih dipakai oleh berita atau tips, jadi tidak dapat dihapus.', 'kategori-admin');
        }
        DB::table('disaster_categories')->where('id', $id)->delete();
        return $this->back('Kategori berhasil dihapus.', 'kategori-admin');
    }

    public function storeTip(Request $request)
    {
        $data = $this->validateTip($request);
        $data['created_at'] = $data['updated_at'] = now();
        DB::table('mitigations')->insert($data);
        return $this->back('Tips keselamatan berhasil ditambahkan.', 'tips-admin');
    }

    public function updateTip(Request $request, int $id)
    {
        $data = $this->validateTip($request);
        abort_unless(DB::table('mitigations')->where('id', $id)->exists(), 404);
        $data['updated_at'] = now();
        DB::table('mitigations')->where('id', $id)->update($data);
        return $this->back('Tips keselamatan berhasil diperbarui.', 'tips-admin');
    }

    private function validateTip(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:disaster_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'phase' => ['required', Rule::in(['Sebelum', 'Saat', 'Sesudah'])],
            'content' => ['required', 'string', 'max:10000'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);
    }

    public function destroyTip(int $id)
    {
        DB::table('mitigations')->where('id', $id)->delete();
        return $this->back('Tips keselamatan berhasil dihapus.', 'tips-admin');
    }

    public function storeContact(Request $request)
    {
        $data = $this->validateContact($request);
        $data['created_at'] = $data['updated_at'] = now();
        DB::table('emergency_contacts')->insert($data);
        return $this->back('Nomor darurat berhasil ditambahkan.', 'kontak-admin');
    }

    public function updateContact(Request $request, int $id)
    {
        $data = $this->validateContact($request);
        abort_unless(DB::table('emergency_contacts')->where('id', $id)->exists(), 404);
        $data['updated_at'] = now();
        DB::table('emergency_contacts')->where('id', $id)->update($data);
        return $this->back('Nomor darurat berhasil diperbarui.', 'kontak-admin');
    }

    private function validateContact(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'agency' => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
        ]);
    }

    public function destroyContact(int $id)
    {
        DB::table('emergency_contacts')->where('id', $id)->delete();
        return $this->back('Nomor darurat berhasil dihapus.', 'kontak-admin');
    }

    public function storeInformation(Request $request)
    {
        $data = $this->validateInformation($request);
        $data['created_at'] = $data['updated_at'] = now();
        DB::table('general_information')->insert($data);
        return $this->back('Informasi umum berhasil ditambahkan.', 'informasi-admin');
    }

    public function updateInformation(Request $request, int $id)
    {
        $data = $this->validateInformation($request);
        abort_unless(DB::table('general_information')->where('id', $id)->exists(), 404);
        $data['updated_at'] = now();
        DB::table('general_information')->where('id', $id)->update($data);
        return $this->back('Informasi umum berhasil diperbarui.', 'informasi-admin');
    }

    private function validateInformation(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:20000'],
            'image' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]);
        if (!empty($data['published_at'])) $data['published_at'] = Carbon::parse($data['published_at'], 'Asia/Jakarta')->utc();
        return $data;
    }

    public function destroyInformation(int $id)
    {
        DB::table('general_information')->where('id', $id)->delete();
        return $this->back('Informasi umum berhasil dihapus.', 'informasi-admin');
    }

    public function updateUserRole(Request $request, int $id)
    {
        abort_if((int) $request->user()->id === $id, 422, 'Role akun yang sedang digunakan tidak dapat diubah dari sini.');
        $data = $request->validate(['role' => ['required', Rule::in(['user', 'admin'])]]);
        abort_unless(DB::table('users')->where('id', $id)->exists(), 404);
        DB::table('users')->where('id', $id)->update(['role' => $data['role'], 'update_at' => now()]);
        return $this->back('Role pengguna berhasil diperbarui.', 'pengguna-admin');
    }

    public function destroyUser(Request $request, int $id)
    {
        abort_if((int) $request->user()->id === $id, 422, 'Akun yang sedang digunakan tidak dapat dihapus.');
        $target = DB::table('users')->where('id', $id)->first(['id', 'role']);
        abort_unless($target, 404);
        abort_if($target->role === 'admin', 422, 'Akun admin tidak dapat dihapus dari panel ini.');

        DB::table('users')->where('id', $id)->delete();
        return $this->back('Akun pengguna berhasil dihapus.', 'pengguna-admin');
    }

    public function storeAnnouncement(Request $request)
    {
        $data = $request->validate(['title' => ['required', 'string', 'max:255'], 'message' => ['required', 'string', 'max:5000'], 'type' => ['required', 'string', 'max:50']]);
        $data['user_id'] = null;
        $data['is_read'] = false;
        $data['created_at'] = $data['updated_at'] = now();
        DB::table('notifications')->insert($data);
        return $this->back('Pengumuman dikirim ke notifikasi seluruh pengguna.', 'pengumuman-admin');
    }

    public function destroyNotification(int $id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return $this->back('Notifikasi berhasil dihapus.', 'pengumuman-admin');
    }

    private function back(string $message, string $anchor)
    {
        return redirect()->to(route('admin.manage') . '#' . $anchor, 303)->with('status', $message);
    }
}
