<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Simpan text fields
        foreach ($request->except('_token', 'jumbotron_image', 'qris_image') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Upload Jumbotron Image
        if ($request->hasFile('jumbotron_image')) {
            $path = $request->file('jumbotron_image')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'jumbotron_image'], ['value' => $path]);
        }

        // Upload QRIS Image
        if ($request->hasFile('qris_image')) {
            $path = $request->file('qris_image')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'qris_image'], ['value' => $path]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan');
    }
}