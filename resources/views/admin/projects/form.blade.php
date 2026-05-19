@extends('admin.layout')
@section('title', $project->exists ? 'Edit Project' : 'Create Project')

@section('body')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-800 text-slate-100">{{ $project->exists ? 'Modify Project Record' : 'Deploy Portfolio Project' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Configure layout localization strings, system endpoints, and dynamic assets.</p>
        </div>
    </div>
</div>

<div class="page-content fade-in">
    <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf @if($project->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- حقول المحتوى الأساسي --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- العناوين ثنائية اللغة --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Localization & Identification</span></div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="field">
                                <label class="label">Project Title (EN)</label>
                                <input type="text" name="title_en" value="{{ old('title_en', $project->title_en) }}" class="input" placeholder="e.g. Enterprise Cloud Hub" required>
                                @error('title_en')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="field">
                                <label class="label text-right">اسم المشروع (AR)</label>
                                <input type="text" name="title_ar" value="{{ old('title_ar', $project->title_ar) }}" class="input text-right font-medium" placeholder="مثال: منصة السحابية للمؤسسات" dir="rtl" required>
                                @error('title_ar')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- الوصف الإنجليزي --}}
                        <div class="field mt-6">
                            <label class="label">Detailed Summary Description (EN)</label>
                            <textarea name="desc_en" rows="4" class="input py-3" placeholder="Describe scope, problems solved, and structural architecture..." required>{{ old('desc_en', $project->desc_en) }}</textarea>
                            @error('desc_en')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        {{-- الوصف العربي --}}
                        <div class="field mt-6">
                            <label class="label text-right">تفاصيل شرح المشروع (AR)</label>
                            <textarea name="desc_ar" rows="4" class="input py-3 text-right" placeholder="..." dir="rtl" required>{{ old('desc_ar', $project->desc_ar) }}</textarea>
                            @error('desc_ar')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- الروابط والتقنيات --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Tech Stack & Deployment Links</span></div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="field">
                                <label class="label">Live Production URL</label>
                                <input type="url" name="live_url" value="{{ old('live_url', $project->live_url) }}" class="input font-mono text-xs text-slate-300" placeholder="https://example.com">
                                @error('live_url')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="field">
                                <label class="label">Source Code URL</label>
                                <input type="url" name="code_url" value="{{ old('code_url', $project->code_url) }}" class="input font-mono text-xs text-slate-300" placeholder="https://github.com/...">
                                @error('code_url')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div class="field">
                                <label class="label">Technologies Stack (Comma Separated)</label>
                                <input type="text" name="stack_raw" value="{{ old('stack_raw', isset($project->stack) && is_array($project->stack) ? implode(', ', $project->stack) : '') }}" class="input" placeholder="Vue, Tailwind, Node.js">
                                @error('stack_raw')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="field">
                                <label class="label">Project Index Abbreviation</label>
                                <input type="text" name="abbr" value="{{ old('abbr', $project->abbr) }}" class="input font-mono uppercase" placeholder="ECH">
                                @error('abbr')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- الجانب الأيمن للميديا والإعدادات العامة --}}
            <div class="space-y-6">
                
                {{-- إعدادات العرض والحالة --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Publish Settings</span></div>
                    <div class="card-body space-y-4">
                        <div class="p-4 bg-surface2 rounded-xl border border-border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-600 text-slate-300">Visibility Status</span>
                                <input type="hidden" name="is_active" value="0">
                                <div @click="active = !active" class="toggle" :class="active ? 'on' : ''" x-data="{ active: {{ old('is_active', $project->is_active ?? 1) }} }">
                                    <input type="checkbox" name="is_active" value="1" x-model="active" class="hidden">
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Display Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" class="input">
                            @error('sort_order')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- الجماليات والتصميم والميديا --}}
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Visual Layout Assets</span></div>
                    <div class="card-body space-y-6">
                        <div class="field">
                            <label class="label">Background Gradient Tailwind Classes</label>
                            <input type="text" name="bg_gradient" value="{{ old('bg_gradient', $project->bg_gradient ?? 'from-slate-900 to-slate-800') }}" class="input font-mono text-xs" placeholder="from-slate-900 to-slate-700">
                            @error('bg_gradient')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label class="label">Upload Display Graphic Cover</label>
                            <input type="file" name="image" class="input py-2.5 text-xs text-slate-400 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-600 file:bg-accent file:text-slate-950 hover:file:bg-sky-400">
                            @error('image')<span class="text-xs text-rose-500 font-500 mt-1 block">{{ $message }}</span>@enderror

                            @if($project->exists && $project->image)
                                <div class="mt-4 p-2 bg-surface2 border border-border2 rounded-xl overflow-hidden aspect-video relative group">
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="" class="w-full h-full object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-slate-950/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-[10px] font-mono tracking-wider text-slate-400">Active Media Frame</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- أزرار الحفظ النهائي --}}
                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn btn-primary py-4 w-full text-md font-700">
                        {{ $project->exists ? 'Update Project Assignment' : 'Publish Project Profile' }}
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost py-4 w-full">Cancel</a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection