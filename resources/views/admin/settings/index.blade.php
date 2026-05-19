@extends('admin.layout')

@section('title', 'Settings')

@section('body')
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="text-xl font-bold" style="color:var(--text)">Settings</h1>
        <p class="text-sm mt-1" style="color:var(--muted)">Branding and default website configuration</p>
    </div>

    {{-- Page Content --}}
    <div class="page-content">
        <div class="max-w-4xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            {{-- Brand Name --}}
                            <div class="field">
                                <label class="label">Brand Name</label>
                                <input type="text" name="brand_name" value="{{ old('brand_name', $settings['brand_name'] ?? '') }}" class="input">
                            </div>

                            {{-- Default Theme --}}
                            <div class="field">
                                <label class="label">Default Theme</label>
                                <select name="default_theme" class="input">
                                    <option value="dark" @selected(old('default_theme', $settings['default_theme'] ?? 'dark') === 'dark')>Dark</option>
                                    <option value="light" @selected(old('default_theme', $settings['default_theme'] ?? 'dark') === 'light')>Light</option>
                                </select>
                            </div>

                            {{-- Default Language --}}
                            <div class="field">
                                <label class="label">Default Language</label>
                                <select name="default_lang" class="input">
                                    <option value="en" @selected(old('default_lang', $settings['default_lang'] ?? 'en') === 'en')>English</option>
                                    <option value="ar" @selected(old('default_lang', $settings['default_lang'] ?? 'en') === 'ar')>Arabic</option>
                                </select>
                            </div>

                            {{-- Brand Logo --}}
                            <div class="field">
                                <label class="label">Brand Logo</label>
                                <input type="file" name="brand_logo" class="input">
                            </div>

                            {{-- Orbit Center Logo --}}
                            <div class="field">
                                <label class="label">Orbit Center Logo</label>
                                <input type="file" name="orbit_center_logo" class="input">
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection