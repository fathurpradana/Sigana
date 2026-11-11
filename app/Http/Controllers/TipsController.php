<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Support\DisasterCategoryScope;

class TipsController extends Controller
{
    public function index()
    {
        $tipsQuery = DB::table('mitigations as m')
            ->leftJoin('disaster_categories as c', 'c.id', '=', 'm.category_id')
            ->select('m.id', 'm.title', 'm.phase', 'm.content', 'm.image', 'c.name as category');
        $tipsQuery->where(function ($query) {
            $query->whereNull('m.category_id')
                ->orWhere(function ($focusedCategories) {
                    DisasterCategoryScope::apply($focusedCategories, 'c.name');
                });
        });
        $tips = $tipsQuery
            ->orderBy('m.phase')
            ->orderBy('m.id')
            ->get();

        $contacts = DB::table('emergency_contacts')
        ->where('phone', '<>', '112')
        ->orderBy('name')
        ->get();

        return view('tips.index', compact('tips', 'contacts'));
    }
}
