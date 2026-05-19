@extends('admin.layout')
@section('title', $ring->exists ? 'Edit Ring' : 'Create Ring')

@section('body')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.technologies.index') }}" class="btn btn-ghost btn-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-800 text-slate-100">{{ $ring->exists ? 'Edit Orbit Ring' : 'Create Orbit Ring' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Establish the vector geometric system parameters for the layout canvas.</p>
        </div>
    </div>
</div>

<div class="page-content fade-in">
    <form method="POST" action="{{ $ring->exists ? route('admin.technologies.rings.update', $ring) : route('admin.technologies.rings.store') }}">
        @csrf @if($ring->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- حقول هندسة الحلقة --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Geometric Core Dimensions</span></div>
                    <div class="card-body">
                        
                        <div class="form-grid">
                            <div class="field">
                                <label class="label">Unique Ring ID Number</label>
                                <input type="number" name="ring_number" value="{{ old('ring_number', $ring->ring_number) }}" class="input" min="1" placeholder="e.g. 1" required>
                                @error('ring_number')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="field">
                                <label class="label">Vector Tracking Radius (px)</label>
                                <input type="number" name="radius_px" value="{{ old('radius_px', $ring->radius_px) }}" class="input" min="80" max="800" placeholder="e.g. 240" required>
                                @error('radius_px')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-grid mt-6">
                            <div class="field">
                                <label class="label">Rotation Loop Period (Seconds)</label>
                                <input type="number" name="duration_seconds" value="{{ old('duration_seconds', $ring->duration_seconds) }}" class="input" min="5" max="200" placeholder="e.g. 40" required>
                                @error('duration_seconds')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="field">
                                <label class="label">Rotation Track Vector</label>
                                <select name="direction" class="input appearance-none cursor-pointer">
                                    <option value="cw" @selected(old('direction', $ring->direction) === 'cw')>Clockwise (CW)</option>
                                    <option value="ccw" @selected(old('direction', $ring->direction) === 'ccw')>Counter Clockwise (CCW)</option>
                                </select>
                                @error('direction')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- المظهر البصري --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Aesthetics & Layout</span></div>
                    <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="field mb-0">
                            <label class="label">Ring Track Theme Color</label>
                            <div class="flex gap-2">
                                <input type="color" class="w-12 h-10 bg-transparent border-none cursor-pointer p-0" value="{{ old('color', $ring->color ?? '#3b82f6') }}" oninput="hex_color_reader.value = this.value">
                                <input type="text" id="hex_color_reader" name="color" value="{{ old('color', $ring->color ?? '#3b82f6') }}" class="input font-mono" placeholder="#000000" required>
                            </div>
                            @error('color')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div class="field mb-0">
                            <label class="label">General Sort Sequence</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $ring->sort_order ?? 0) }}" class="input">
                            @error('sort_order')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- الجانب الأيمن --}}
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Configuration</span></div>
                    <div class="card-body">
                        <div class="p-4 bg-surface2 rounded-xl border border-border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-600 text-slate-300">Track Pipeline Status</span>
                                <input type="hidden" name="is_active" value="0">
                                <div @click="active = !active" class="toggle" :class="active ? 'on' : ''" x-data="{ active: {{ old('is_active', $ring->is_active ?? 1) }} }">
                                    <input type="checkbox" name="is_active" value="1" x-model="active" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn btn-primary py-4 w-full text-md font-700">
                        {{ $ring->exists ? 'Save Configuration' : 'Deploy Orbit Track' }}
                    </button>
                    <a href="{{ route('admin.technologies.index') }}" class="btn btn-ghost py-4 w-full">Cancel</a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection