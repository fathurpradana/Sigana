<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisasterController extends Controller
{
    public function index(Request $request)
    {
        $categories = DB::table('disaster_categories')->orderBy('name')->get();

        $disasters = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
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
        $disaster = DB::table('disasters as d')
            ->join('disaster_categories as c', 'c.id', '=', 'd.category_id')
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