<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $qrisBaseString = Setting::get('qris_base_string');
        $qrisImage = Setting::get('qris_image');
        return view('admin.settings.index', compact('qrisBaseString', 'qrisImage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'qris_base_string' => 'nullable|string',
            'qris_image' => 'nullable|image|max:2048'
        ]);

        if ($request->has('qris_base_string')) {
            Setting::updateOrCreate(
                ['key' => 'qris_base_string'],
                ['value' => $request->qris_base_string]
            );
        }

        if ($request->hasFile('qris_image')) {
            $path = $request->file('qris_image')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'qris_image'],
                ['value' => $path]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan QRIS berhasil disimpan!');
    }
}
