{{-- resources/views/admin/content/hero.blade.php --}}
@extends('admin.layout')

@section('title', 'Hero Content')

@section('body')
<div class="page-header">
    <div>
        <h1 class="font-display text-2xl font-bold">Hero Section</h1>
        <p class="text-sm" style="color:var(--muted)">Edit the main headline and call-to-action buttons.</p>
    </div>
</div>

<div class="page-content">
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card fade-in">
        <div class="card-header">
            <h2 class="text-sm font-semibold">Hero Content</h2>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.content.hero.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label class="label">Badge EN</label>
                        <input type="text" name="badge_en" class="input" value="{{ old('badge_en', $hero->badge_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Badge AR</label>
                        <input type="text" name="badge_ar" class="input" value="{{ old('badge_ar', $hero->badge_ar ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label class="label">Line 1 EN</label>
                        <input type="text" name="line1_en" class="input" value="{{ old('line1_en', $hero->line1_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Line 2 EN</label>
                        <input type="text" name="line2_en" class="input" value="{{ old('line2_en', $hero->line2_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Line 3 EN</label>
                        <input type="text" name="line3_en" class="input" value="{{ old('line3_en', $hero->line3_en ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label class="label">Line 1 AR</label>
                        <input type="text" name="line1_ar" class="input" value="{{ old('line1_ar', $hero->line1_ar ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Line 2 AR</label>
                        <input type="text" name="line2_ar" class="input" value="{{ old('line2_ar', $hero->line2_ar ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Line 3 AR</label>
                        <input type="text" name="line3_ar" class="input" value="{{ old('line3_ar', $hero->line3_ar ?? '') }}" required>
                    </div>

                    <div class="field md:col-span-2">
                        <label class="label">Description EN</label>
                        <textarea name="desc_en" class="input" rows="4" required>{{ old('desc_en', $hero->desc_en ?? '') }}</textarea>
                    </div>
                    <div class="field md:col-span-2">
                        <label class="label">Description AR</label>
                        <textarea name="desc_ar" class="input" rows="4" required>{{ old('desc_ar', $hero->desc_ar ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label class="label">CTA 1 EN</label>
                        <input type="text" name="cta1_en" class="input" value="{{ old('cta1_en', $hero->cta1_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">CTA 1 AR</label>
                        <input type="text" name="cta1_ar" class="input" value="{{ old('cta1_ar', $hero->cta1_ar ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label class="label">CTA 2 EN</label>
                        <input type="text" name="cta2_en" class="input" value="{{ old('cta2_en', $hero->cta2_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">CTA 2 AR</label>
                        <input type="text" name="cta2_ar" class="input" value="{{ old('cta2_ar', $hero->cta2_ar ?? '') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">Save Hero Content</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection