<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $disasters = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
            ->select('d.id', 'd.title', 'd.location', 'd.latitude', 'd.longitude', 'd.occurred_at', 'd.created_at', 'd.status', 'd.description', 'd.photo', 'd.updated_at', 'c.name as category')
            ->orderByRaw('COALESCE(d.created_at, d.occurred_at) DESC')
            ->get();

        $hasProfilePhoto = Auth::check() && DB::table('users')->where('id', Auth::id())->whereNotNull('profile_photo')->exists();

        $mapDisasters = $disasters->filter(fn ($disaster) => $disaster->latitude !== null && $disaster->longitude !== null)->map(fn ($disaster) => ['id' => $disaster->id, 'title' => $disaster->title, 'location' => $disaster->location, 'latitude' => (float) $disaster->latitude, 'longitude' => (float) $disaster->longitude])->values();

        $stats = [
            'active' => DB::table('disasters')->whereRaw('LOWER(status) IN (?, ?)', ['aktif', 'dilaporkan'])->count(),
            'monitored' => DB::table('disasters')->whereRaw('LOWER(status) = ?', ['dipantau'])->count(),
            'areas' => DB::table('disasters')->whereNotNull('location')->distinct()->count('location'),
        ];

        $latest = DB::table('disasters')
            ->selectRaw('MAX(COALESCE(created_at, occurred_at)) as latest_update')
            ->value('latest_update');
        $stats['latest'] = $latest ? Carbon::parse($latest, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y') : '—';

        $notificationsEnabled = Auth::check()
        ? (bool) DB::table('users')
            ->where('id', Auth::id())
            ->value('notifications_enabled')
        : true;

        $notificationsQuery = DB::table('notifications');
        if (Auth::check()) {
            $notificationsQuery->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', Auth::id());
            });
        } else {
            $notificationsQuery->whereNull('user_id');
        }

        if (! $notificationsEnabled) {
        $notificationsQuery->whereRaw('1 = 0');
    }

        $notifications = (clone $notificationsQuery)->orderByDesc('created_at')->limit(5)->get();
        $unreadNotifications = (clone $notificationsQuery)->where('is_read', false)->count();

        // Kejadian lama tanpa baris notifikasi ditampilkan sebagai riwayat yang sudah dibaca.
        $knownMessages = $notifications->pluck('message')->all();
        $historyNotifications = ($notificationsEnabled ? $disasters : collect())
            ->reject(fn ($disaster) => in_array($disaster->category . ' dilaporkan di ' . $disaster->location . '.', $knownMessages, true))
            ->take(max(0, 5 - $notifications->count()))
            ->map(fn ($disaster) => (object) [
                'title' => $disaster->title,
                'disaster_id' => $disaster->id,
                'message' => $disaster->location . ($disaster->description ? ' · ' . $disaster->description : ''),
                'is_read' => true,
                'created_at' => $disaster->created_at ?? $disaster->occurred_at,
            ]);

        $notifications = $notifications->concat($historyNotifications)->take(5);

        return view('dashboard', compact('disasters', 'mapDisasters', 'stats', 'notifications', 'unreadNotifications', 'hasProfilePhoto'));
    }
}
