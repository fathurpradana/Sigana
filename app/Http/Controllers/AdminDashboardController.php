<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => DB::table('users')->count(),
            'disasters' => DB::table('disasters')->count(),
            'pending_reports' => DB::table('disasters')->where('verification_status', 'Menunggu')->count(),
            'categories' => DB::table('disaster_categories')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
