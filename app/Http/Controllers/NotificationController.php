<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        DB::table('notifications')
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', Auth::id());
            })
            ->update(['is_read' => true, 'updated_at' => now()]);

        return back();
    }

    public function open(int $id)
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', Auth::id());
            })
            ->first();

        abort_if(! $notification, 404);

        DB::table('notifications')
            ->where('id', $notification->id)
            ->update(['is_read' => true, 'updated_at' => now()]);

        $disasterId = null;
        if (preg_match('/^(.+?) dilaporkan di (.+)$/u', trim((string) $notification->message), $matches)) {
            $category = trim($matches[1]);
            $location = rtrim(trim($matches[2]), '.');

            $query = DB::table('disasters as d')
                ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
                ->where('c.name', $category)
                ->where('d.location', $location);

            if ($notification->created_at) {
                $query->where('d.created_at', $notification->created_at);
            }

            $disasterId = $query->orderByDesc('d.id')->value('d.id');

            if (! $disasterId) {
                $disasterId = DB::table('disasters as d')
                    ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
                    ->where('c.name', $category)
                    ->where('d.location', $location)
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