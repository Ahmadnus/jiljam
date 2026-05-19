@extends('admin.layout')
@section('title', $tech->exists ? 'Edit Technology' : 'Create Technology')

@section('body')
<div class="page-header" x-data="{ iconType: '{{ old('icon_type', $tech->icon_type ?? 'emoji') }}' }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.technologies.index') }}" class="btn btn-ghost btn-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <div>
                <h1 class="font-display text-2xl font-800 text-slate-100">{{ $tech->exists ? 'Edit Technology' : 'Create Technology' }}</h1>
                <p class="text-sm text-slate-500 mt-1">Add nodes to your frontend orbital animation canvas.</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-surface2 border border-border2 text-slate-400 font-mono text-xs rounded-xl tracking-wide">
            Parent Node: <span class="text-accent font-700">Ring #{{ $ring->ring_number }}</span>
        </div>
    </div>
</div>

<div class="page-content fade-in" x-data="{ iconType: '{{ old('icon_type', $tech->icon_type ?? 'emoji') }}' }">
    <form method="POST" action="{{ $tech->exists ? route('admin.technologies.techs.update', [$ring, $tech]) : route('admin.technologies.techs.store', $ring) }}" enctype="multipart/form-data">
        @csrf @if($tech->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- العمود الأساسي --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Identity Details</span></div>
                    <div class="card-body">
                        <div class="field">
                            <label class="label">Technology Name</label>
                            <input type="text" name="name" value="{{ old('name', $tech->name) }}" class="input" placeholder="e.g. Laravel, Next.js, Figma" required>
                            @error('name')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            {{-- اختيار نوع الأيقونة --}}
                            <div class="field">
                                <label class="label">Visual Type</label>
                                <select name="icon_type" x-model="iconType" class="input appearance-none cursor-pointer">
                                    <option value="emoji">Emoji / Short Text</option>
                                    <option value="image">Custom Graphic Image File</option>
                                </select>
                                @error('icon_type')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            {{-- الترتيب --}}
                            <div class="field">
                                <label class="label">Sort Sequence Order</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $tech->sort_order ?? 0) }}" class="input">
                                @error('sort_order')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- التبديل الديناميكي للأيقونات بحسب النوع المحدد --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Visual Assets</span></div>
                    <div class="card-body">
                        
                        {{-- حقل الإيموجي --}}
                        <div x-show="iconType === 'emoji'" x-transition.opacity.duration.250ms class="field mb-0">
                            <label class="label">Emoji character or acronym</label>
                            <input type="text" name="icon" value="{{ old('icon', $tech->icon) }}" class="input text-lg" placeholder="⚡ or JS">
                            <span class="text-xs text-slate-500 mt-2 block">Rendered inside a clean vector-supported text node context.</span>
                            @error('icon')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        {{-- حقل الصورة --}}
                        <div x-show="iconType === 'image'" x-transition.opacity.duration.250ms class="field mb-0" style="display:none;">
                            <label class="label">Upload Asset File</label>
                            <input type="file" name="icon_image" class="input py-2.5 text-xs text-slate-400 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-600 file:bg-accent file:text-slate-950 hover:file:bg-sky-400">
                            @error('icon_image')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror

                            @if($tech->exists && $tech->icon_image)
                                <div class="mt-4 p-4 bg-surface2 border border-border2 rounded-xl flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl bg-bg border border-border2 p-2 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/'.$tech->icon_image) }}" alt="{{ $tech->name }}" class="w-full h-full object-contain">
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-300 font-600">Active Asset Image</div>
                                        <div class="text-[10px] font-mono text-slate-500 mt-0.5">storage/{{ $tech->icon_image }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- العمود الجانبي للحالة والحفظ --}}
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Configuration</span></div>
                    <div class="card-body">
                        <div class="p-4 bg-surface2 rounded-xl border border-border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-600 text-slate-300">Orbit Node Status</span>
                                <input type="hidden" name="is_active" value="0">
                                <div @click="active = !active" class="toggle" :class="active ? 'on' : ''" x-data="{ active: {{ old('is_active', $tech->is_active ?? 1) }} }">
                                    <input type="checkbox" name="is_active" value="1" x-model="active" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn btn-primary py-4 w-full text-md font-700">
                        {{ $tech->exists ? 'Update Node Asset' : 'Publish Node Asset' }}
                    </button>
                    <a href="{{ route('admin.technologies.index') }}" class="btn btn-ghost py-4 w-full">Cancel</a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection