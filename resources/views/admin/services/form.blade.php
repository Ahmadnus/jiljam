@extends('admin.layout')
@section('title', $service->exists ? 'Edit Service' : 'New Service')

@section('body')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.services.index') }}" class="btn btn-ghost btn-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-800 text-slate-100">{{ $service->exists ? 'Edit Service' : 'Create New Service' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Configure your agency service details and dynamic vector icons.</p>
        </div>
    </div>
</div>

{{-- تهيئة بيانات الأيقونات بواسطة Alpine.js للتحكم التفاعلي --}}
<div class="page-content fade-in" x-data="{ 
    iconText: `{{ old('icon_path', $service->icon_path) }}`,
    icons: [
        { name: 'UI/UX Design', svg: '<path d=\'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z\'/><path d=\'M8 11l3 3 5-5\'/>' },
        { name: 'Web Dev', svg: '<polyline points=\'16 18 22 12 16 6\'></polyline><polyline points=\'8 6 2 12 8 18\'></polyline>' },
        { name: 'Mobile Apps', svg: '<rect x=\'5\' y=\'2\' width=\'14\' height=\'20\' rx=\'2\' ry=\'2\'></rect><line x1=\'12\' y1=\'18\' x2=\'12.01\' y2=\'18\'></line>' },
        { name: 'Cloud Computing', svg: '<path d=\'M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z\'></path>' },
        { name: 'Data Analytics', svg: '<line x1=\'18\' y1=\'20\' x2=\'18\' y2=\'10\'></line><line x1=\'12\' y1=\'20\' x2=\'12\' y2=\'4\'></line><line x1=\'6\' y1=\'20\' x2=\'6\' y2=\'14\'></line>' },
        { name: 'Cyber Security', svg: '<rect x=\'3\' y=\'11\' width=\'18\' height=\'11\' rx=\'2\' ry=\'2\'></rect><path d=\'M7 11V7a5 5 0 0 1 10 0v4\'></path>' },
        { name: 'Digital Marketing', svg: '<path d=\'M11 5L6 9H2v6h4l5 4V5z\'></path><path d=\'M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07\'></path>' },
        { name: 'E-Commerce', svg: '<circle cx=\'9\' cy=\'21\' r=\'1\'></circle><circle cx=\'20\' cy=\'21\' r=\'1\'></circle><path d=\'M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6\'></path>' },
        { name: 'AI Solutions', svg: '<path d=\'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z\'></path><circle cx=\'12\' cy=\'12\' r=\'3\'></circle>' },
        { name: 'SEO Systems', svg: '<circle cx=\'11\' cy=\'11\' r=\'8\'></circle><line x1=\'21\' y1=\'21\' x2=\'16.65\' y2=\'16.65\'></line><line x1=\'11\' y1=\'8\' x2=\'11\' y2=\'14\'></line><line x1=\'8\' y1=\'11\' x2=\'14\' y2=\'11\'></line>' },
        { name: 'Branding & Identity', svg: '<path d=\'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z\'></path>' },
        { name: 'IT Support', svg: '<path d=\'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z\'></path>' },
        { name: 'CMS Deployment', svg: '<rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><path d=\'M3 9h18M9 21V9\'/>' },
        { name: 'API Integrations', svg: '<path d=\'M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71\'></path><path d=\'M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71\'></path>' },
        { name: 'Tech Consulting', svg: '<path d=\'M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3z\'></path>' },
        { name: 'Game Architecture', svg: '<path d=\'M6 12h4M8 10v4M15 11h.01M18 13h.01\'/><rect x=\'2\' y=\'6\' width=\'20\' height=\'12\' rx=\'2\'/>' },
        { name: 'Quality Testing', svg: '<path d=\'M22 11.08V12a10 10 0 1 1-5.93-9.14\'></path><polyline points=\'22 4 12 14.01 9 11.01\'></polyline>' },
        { name: 'IoT Infrastructure', svg: '<path d=\'M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9\'></path><path d=\'M13.73 21a2 2 0 0 1-3.46 0\'></path>' },
        { name: 'Blockchain Dev', svg: '<path d=\'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z\'></path><polyline points=\'3.27 6.96 12 12.01 20.73 6.96\'></polyline><line x1=\'12\' y1=\'22.08\' x2=\'12\' y2=\'12\'></line>' },
        { name: 'DevOps & Servers', svg: '<rect x=\'2\' y=\'2\' width=\'20\' height=\'8\' rx=\'2\' ry=\'2\'></rect><rect x=\'2\' y=\'14\' width=\'20\' height=\'8\' rx=\'2\' ry=\'2\'></rect><line x1=\'6\' y1=\'6\' x2=\'6.01\' y2=\'6\'></line><line x1=\'6\' y1=\'18\' x2=\'6.01\' y2=\'18\'></line>' }
    ]
}">
    <form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
        @csrf @if($service->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- العمود الأيسر: الحقول النصية --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">General Information</span></div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="field">
                                <label class="label">Title (English)</label>
                                <input type="text" name="title_en" value="{{ old('title_en', $service->title_en) }}" class="input" placeholder="e.g. Software Engineering">
                            </div>
                            <div class="field">
                                <label class="label">Title (Arabic)</label>
                                <input type="text" name="title_ar" value="{{ old('title_ar', $service->title_ar) }}" class="input" dir="rtl" placeholder="مثال: هندسة البرمجيات">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Description (English)</label>
                            <textarea name="desc_en" class="input" rows="4">{{ old('desc_en', $service->desc_en) }}</textarea>
                        </div>
                        <div class="field">
                            <label class="label">Description (Arabic)</label>
                            <textarea name="desc_ar" class="input" rows="4" dir="rtl">{{ old('desc_ar', $service->desc_ar) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- قسم الأيقونات المحدث مع لوحة الاختيار السريعة --}}
                <div class="card">
                    <div class="card-header flex justify-between items-center">
                        <span class="text-sm font-700 uppercase tracking-wider text-accent">Icon Setup</span>
                        <span class="text-xs text-slate-500 italic">Click any icon to select it instantly</span>
                    </div>
                    <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- مدخل النص اليدوي --}}
                        <div class="field mb-0">
                            <label class="label">Active SVG Path Data</label>
                            <textarea name="icon_path" x-model="iconText" class="input font-mono text-xs text-emerald-400 bg-slate-950" rows="8" placeholder="Paste path here or pick from the right side..."></textarea>
                            <div class="mt-3 p-3 bg-surface2 border border-border rounded-xl flex items-center gap-3">
                                <span class="text-xs text-slate-400">Live Preview:</span>
                                <div class="w-8 h-8 rounded-lg bg-bg border border-border2 flex items-center justify-center text-accent">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5" x-html="iconText"></svg>
                                </div>
                            </div>
                        </div>

                        {{-- شبكة منتقي الأيقونات (20 اقتراح) --}}
                        <div>
                            <label class="label mb-2">Preset Agency Icons (20 Options)</label>
                            <div class="icon-picker-grid border border-border2 p-2 rounded-xl bg-bg">
                                <template x-for="item in icons" :key="item.name">
                                    <div class="icon-opt" 
                                         :class="iconText === item.svg ? 'selected' : ''" 
                                         @click="iconText = item.svg"
                                         :data-tip="item.name">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-html="item.svg"></svg>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- العمود الأيمن: الخصائص والحالة --}}
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header"><span class="text-sm font-700 uppercase tracking-wider text-accent">Attributes</span></div>
                    <div class="card-body">
                        <div class="field">
                            <label class="label">Number Display</label>
                            <input type="text" name="number_display" value="{{ old('number_display', $service->number_display) }}" class="input" placeholder="01">
                        </div>
                        
                        <div class="field">
                            <label class="label">Accent Color Theme</label>
                            <div class="flex gap-2">
                                <input type="color" class="w-12 h-10 bg-transparent border-none cursor-pointer" value="{{ old('color', $service->color ?? '#3b82f6') }}" oninput="hex_val.value = this.value">
                                <input type="text" id="hex_val" name="color" value="{{ old('color', $service->color ?? '#3b82f6') }}" class="input font-mono">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Sort Order Index</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="input">
                        </div>

                        <div class="field mt-6 p-4 bg-surface2 rounded-xl border border-border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-600 text-slate-300">Service Status</span>
                                <input type="hidden" name="is_active" value="0">
                                <div @click="active = !active" class="toggle" :class="active ? 'on' : ''" x-data="{ active: {{ old('is_active', $service->is_active ?? 1) }} }">
                                    <input type="checkbox" name="is_active" value="1" x-model="active" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn btn-primary py-4 w-full text-md font-700">
                        {{ $service->exists ? 'Save Changes' : 'Publish Service' }}
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-ghost py-4 w-full">Cancel</a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection