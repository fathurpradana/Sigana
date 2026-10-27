<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class DisasterReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:disaster_categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'occurred_at' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
        ]);

        $occurredAt = Carbon::parse($validated['occurred_at'], 'Asia/Jakarta')
        ->utc()
        ->format('Y-m-d H:i:s');
        $photoPath = $request->file('photo')?->store('disasters', 'public');
        $now = now();

        DB::transaction(function () use ($validated, $now, $occurredAt, $photoPath) {
            DB::table('disasters')->insert([
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'location' => $validated['location'],
                'occurred_at' => $occurredAt,
                'status' => 'Dilaporkan',
                'verification_status' => 'Menunggu',
                'description' => $validated['description'],
                'photo' => $photoPath,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        });

        return redirect()->route('bantuan.report.form')
    ->with('report_status', 'Laporan berhasil dikirim. Laporan akan tampil setelah diverifikasi admin.');
    }
}