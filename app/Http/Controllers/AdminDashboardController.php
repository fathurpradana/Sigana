<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Support\DisasterCategoryScope;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => DB::table('users')->count(),
            'disasters' => DisasterCategoryScope::apply(DB::table('disasters as d')->join('disaster_categories as c', 'c.id', '=', 'd.category_id'), 'c.name')->count(),
            'pending_reports' => DisasterCategoryScope::apply(DB::table('disasters as d')->join('disaster_categories as c', 'c.id', '=', 'd.category_id'), 'c.name')->where('d.verification_status', 'Menunggu')->count(),
            'categories' => DisasterCategoryScope::query()->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
