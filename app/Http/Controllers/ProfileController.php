<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $hasProfilePhoto = Auth::check()
            && DB::table('users')->where('id', Auth::id())->whereNotNull('profile_photo')->exists();

        return view('profil', compact('hasProfilePhoto'));
    }

    public function edit()
    {
        $hasProfilePhoto = DB::table('users')->where('id', Auth::id())->whereNotNull('profile_photo')->exists();

        return view('profil-edit', compact('hasProfilePhoto'));
    }

    public function photo(Request $request)
    {
        $photo = DB::table('users')
            ->where('id', $request->user()->id)
            ->first(['profile_photo', 'profile_photo_mime']);

        abort_unless($photo && $photo->profile_photo, 404);

        return response($photo->profile_photo, 200, [
            'Content-Type' => $photo->profile_photo_mime ?: 'image/jpeg',
            'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:120'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($validated['profile_photo']);
        $uploadedPhoto = $request->file('profile_photo');

        DB::transaction(function () use ($user, $validated, $uploadedPhoto) {
            $user->update($validated);

            if ($uploadedPhoto) {
                DB::table('users')->where('id', $user->id)->update([
                    'profile_photo' => file_get_contents($uploadedPhoto->getRealPath()),
                    'profile_photo_mime' => $uploadedPhoto->getMimeType(),
                    'update_at' => now(),
                ]);
            }
        });

        if ($uploadedPhoto) {
            $request->session()->put('profile_photo_version', Str::uuid()->toString());
        }

        return redirect()->route('profil.index')->with('status', 'Profil berhasil disimpan.');
    }

    public function updateNotificationPreference(Request $request)
{
    $validated = $request->validate([
        'notifications_enabled' => ['required', 'boolean'],
    ]);

    DB::table('users')
        ->where('id', $request->user()->id)
        ->update([
            'notifications_enabled' => (bool) $validated['notifications_enabled'],
            'update_at' => now(),
        ]);

    return response()->json([
        'message' => $validated['notifications_enabled']
            ? 'Notifikasi peringatan diaktifkan.'
            : 'Notifikasi peringatan dimatikan.',
    ]);
}
}