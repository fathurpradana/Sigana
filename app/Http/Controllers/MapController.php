<?php

namespace App\Http\Controllers;

use App\Support\DisasterCategoryScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        $query = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id');
        DisasterCategoryScope::apply($query, 'c.name');

        $cutoff = Carbon::now('UTC')->subDays(7);
        $disasters = $query
            ->where('d.verification_status', 'Disetujui')
            ->whereNotNull('d.latitude')
            ->whereNotNull('d.longitude')
            ->whereNotNull('d.approved_at')
            ->where('d.approved_at', '>=', $cutoff)
            ->select('d.id', 'd.title', 'd.location', 'd.latitude', 'd.longitude', 'd.occurred_at', 'd.created_at', 'd.status', 'd.photo', 'c.name as category')
            ->orderByDesc('d.approved_at')
            ->get()
            ->map(fn ($disaster) => [
                'id' => $disaster->id,
                'title' => $disaster->title,
                'category' => $disaster->category,
                'location' => $disaster->location,
                'status' => $disaster->status,
                'occurred_at' => $disaster->occurred_at
                    ? Carbon::parse($disaster->occurred_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB'
                    : null,
                'uploaded_at' => $disaster->created_at
                    ? Carbon::parse($disaster->created_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB'
                    : null,
                'photo_url' => $disaster->photo ? asset('storage/' . ltrim($disaster->photo, '/')) : null,
                'latitude' => (float) $disaster->latitude,
                'longitude' => (float) $disaster->longitude,
                'url' => route('bencana.detail', $disaster->id),
            ])
            ->values();

        return view('peta.index', compact('disasters'));
    }
}
