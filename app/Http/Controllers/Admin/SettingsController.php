<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::allKeyed();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'brand_name'        => 'required|string|max:60',
            'default_theme'     => 'required|in:dark,light',
            'default_lang'      => 'required|in:en,ar',
            'brand_logo'        => 'nullable|image|max:2048',
            'orbit_center_logo' => 'nullable|image|max:2048',
        ]);

        $skip = ['brand_logo', 'orbit_center_logo', '_token', '_method'];

        foreach ($request->except($skip) as $key => $value) {
            Setting::set($key, $value);
        }

        if ($request->hasFile('brand_logo')) {
            $old = Setting::get('brand_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('brand_logo')->store('logos', 'public');
            Setting::set('brand_logo', $path, 'brand');
        }

        if ($request->hasFile('orbit_center_logo')) {
            $old = Setting::get('orbit_center_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('orbit_center_logo')->store('logos', 'public');
            Setting::set('orbit_center_logo', $path, 'tech');
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}