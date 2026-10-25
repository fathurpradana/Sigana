<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisasterReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:disaster_categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $category = DB::table('disaster_categories')->where('id', $validated['category_id'])->value('name');
        $now = now();

        DB::transaction(function () use ($validated, $category, $now) {
            DB::table('disasters')->insert([
                'category_id' => $validated['category_id'],
                'title' => 'Laporan ' . $category . ' - ' . \Illuminate\Support\Str::limit($validated['location'], 120, ''),
                'location' => $validated['location'],
                'occurred_at' => $now,
                'status' => 'Dilaporkan',
                'description' => $validated['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('notifications')->insert([
                'user_id' => Auth::id(),
                'title' => 'Laporan bencana baru',
                'message' => $category . ' dilaporkan di ' . $validated['location'] . '.',
                'type' => 'Laporan',
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });

        return redirect()->route('bantuan.index')->with('report_status', 'Laporan berhasil disimpan dan akan tampil pada halaman bencana.');
    }
}