<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markAllRead(Request $request)
    {
        if (! Auth::check()) {
            $unreadIds = DB::table('notifications')
                ->whereNull('user_id')
                ->where('is_read', false)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all();

            $readIds = array_map('intval', $request->session()->get('guest_read_notifications', []));
            $request->session()->put(
                'guest_read_notifications',
                array_slice(array_values(array_unique(array_merge($readIds, $unreadIds))), -500)
            );
        } else {
            DB::table('notifications')
                ->where(function ($query) {
                    $query->whereNull('user_id')->orWhere('user_id', Auth::id());
                })
                ->update(['is_read' => true, 'updated_at' => now()]);
        }

        return $request->expectsJson()
            ? response()->json(['ok' => true])
            : back();
    }

    public function markRead(Request $request, int $id)
    {
        $notificationQuery = DB::table('notifications')->where('id', $id);
        if (Auth::check()) {
            $notificationQuery->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', Auth::id());
            });
        } else {
            $notificationQuery->whereNull('user_id');
        }

        $notification = $notificationQuery->first(['id']);
        abort_unless($notification, 404);

        if (Auth::check()) {
            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['is_read' => true, 'updated_at' => now()]);
        } else {
            $readIds = array_map('intval', $request->session()->get('guest_read_notifications', []));
            $readIds[] = (int) $notification->id;
            $request->session()->put('guest_read_notifications', array_slice(array_values(array_unique($readIds)), -500));
        }

        return $request->expectsJson()
            ? response()->json(['ok' => true])
            : back();
    }

    public function open(Request $request, int $id)
    {
        $notificationQuery = DB::table('notifications')->where('id', $id);
        if (Auth::check()) {
            $notificationQuery->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', Auth::id());
            });
        } else {
            $notificationQuery->whereNull('user_id');
        }

        $notification = $notificationQuery->first();
        abort_if(! $notification, 404);

        if (Auth::check()) {
            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['is_read' => true, 'updated_at' => now()]);
        } else {
            $readIds = array_map('intval', $request->session()->get('guest_read_notifications', []));
            $readIds[] = (int) $notification->id;
            $request->session()->put('guest_read_notifications', array_slice(array_values(array_unique($readIds)), -500));
        }

        $disasterId = null;
        if (preg_match('/^(.+?) dilaporkan di (.+)$/u', trim((string) $notification->message), $matches)) {
            $category = trim($matches[1]);
            $location = rtrim(trim($matches[2]), '.');

            $query = DB::table('disasters as d')
                ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
                ->where('c.name', $category)
                ->where('d.location', $location)
                ->where('d.verification_status', 'Disetujui');

            if ($notification->created_at) {
                $query->where('d.created_at', $notification->created_at);
            }

            $disasterId = $query->orderByDesc('d.id')->value('d.id');

            if (! $disasterId) {
                $disasterId = DB::table('disasters as d')
                    ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
                    ->where('c.name', $category)
                    ->where('d.location', $location)
                    ->where('d.verification_status', 'Disetujui')
                    ->orderByDesc('d.created_at')
                    ->orderByDesc('d.id')
                    ->value('d.id');
            }
        }

        return $disasterId
            ? redirect()->route('bencana.detail', $disasterId)
            : redirect()->route('bencana.index');
    }
}