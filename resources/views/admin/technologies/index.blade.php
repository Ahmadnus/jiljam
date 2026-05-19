@extends('admin.layout')
@section('title', 'Technologies Orbit')

@section('body')
<div class="page-header">
    <div class="flex flex-col md:flex-row justify-between align-items-start md:items-center gap-4">
        <div>
            <h1 class="font-display text-2xl font-800 text-slate-100">Technologies Ecosystem</h1>
            <p class="text-sm text-slate-500 mt-1">Manage system interactive constellation nodes and layout tracking layers.</p>
        </div>
        <div>
            <a href="{{ route('admin.technologies.rings.create') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Create New Ring
            </a>
        </div>
    </div>
</div>

<div class="page-content fade-in">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-500">
            {{ session('success') }}
        </div>
    @endif

    @php
        $ringCount = $rings->count();
        $techCount = $rings->sum(fn($ring) => $ring->technologies->count());
    @endphp

    {{-- كروت الإحصائيات السريعة --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="card p-4 flex items-center gap-4 bg-surface/50">
            <div class="w-12 h-12 rounded-xl bg-accent/10 border border-accent/20 flex items-center justify-center text-accent">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle></svg>
            </div>
            <div>
                <div class="text-xs font-700 uppercase tracking-wider text-slate-500">Total Track Layers</div>
                <div class="text-2xl font-800 text-slate-200 mt-0.5">{{ $ringCount }}</div>
            </div>
        </div>
        <div class="card p-4 flex items-center gap-4 bg-surface/50">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            </div>
            <div>
                <div class="text-xs font-700 uppercase tracking-wider text-slate-500">Constellation Nodes</div>
                <div class="text-2xl font-800 text-slate-200 mt-0.5">{{ $techCount }}</div>
            </div>
        </div>
    </div>

    {{-- طبقات الحلقات والتقنيات --}}
    <div class="space-y-8">
        @forelse($rings as $ring)
            <div class="card border border-border/80 overflow-hidden">
                
                {{-- هيدر الحلقة --}}
                <div class="card-header bg-surface2/40 border-b border-border/60 py-4 px-5 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                    <div class="flex items-center flex-wrap gap-3">
                        <div class="w-4 h-4 rounded-full shadow-inner border border-white/10" style="background: {{ $ring->color }}"></div>
                        <div>
                            <h3 class="text-md font-800 text-slate-200">Orbit Level Ring #{{ $ring->ring_number }}</h3>
                            <p class="text-xs font-mono text-slate-500 mt-0.5">
                                Radius: <span class="text-slate-400">{{ $ring->radius_px }}px</span> &middot; 
                                Period: <span class="text-slate-400">{{ $ring->duration_seconds }}s</span> &middot; 
                                Direction: <span class="text-accent">{{ strtoupper($ring->direction) }}</span>
                            </p>
                        </div>
                        @if($ring->is_active)
                            <span class="text-[10px] font-700 uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                        @else
                            <span class="text-[10px] font-700 uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-500 border border-border2">Inactive</span>
                        @endif
                    </div>

                    {{-- إجراءات تعديل الحلقة --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.technologies.techs.create', $ring) }}" class="btn btn-ghost py-1.5 px-3 text-xs font-600 text-accent hover:bg-accent/5">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="mr-1.5 inline"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Add Technology
                        </a>
                        <a href="{{ route('admin.technologies.rings.edit', $ring) }}" class="p-2 text-slate-400 hover:text-amber-400 rounded-lg hover:bg-surface2 transition-colors">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <form action="{{ route('admin.technologies.rings.destroy', $ring) }}" method="POST" onsubmit="return confirm('Delete this ring and all its embedded technology items?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-500 rounded-lg hover:bg-surface2 transition-colors">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- شبكة التقنيات داخل الحلقة --}}
                <div class="card-body p-5 bg-bg/40">
                    @if($ring->technologies->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($ring->technologies->sortBy('sort_order') as $tech)
                                <div class="p-4 rounded-2xl bg-surface/40 border border-border2/60 flex items-center justify-between gap-4 group hover:border-border transition-colors">
                                    <div class="flex items-center gap-3.5 overflow-hidden">
                                        {{-- مربع عرض أيقونة التقنية الحالية --}}
                                        <div class="w-14 h-14 rounded-xl bg-bg border border-border2 flex items-center justify-center overflow-hidden flex-shrink-0 text-lg font-700 text-slate-300 shadow-inner">
                                            @if($tech->icon_type === 'image' && $tech->icon_image)
                                                <img src="{{ asset('storage/'.$tech->icon_image) }}" alt="{{ $tech->name }}" class="w-8 h-8 object-contain">
                                            @else
                                                <span>{{ $tech->icon ?: '•' }}</span>
                                            @endif
                                        </div>
                                        <div class="overflow-hidden">
                                            <h4 class="font-600 text-slate-200 truncate text-sm">{{ $tech->name }}</h4>
                                            <div class="text-[11px] font-mono text-slate-500 mt-1">Sequence Priority: {{ $tech->sort_order ?? '0' }}</div>
                                        </div>
                                    </div>

                                    {{-- خيارات تعديل التقنية --}}
                                    <div class="flex items-center gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.technologies.techs.edit', [$ring, $tech]) }}" class="p-2 text-slate-400 hover:text-amber-400 rounded-lg hover:bg-surface2 transition-colors">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.technologies.techs.destroy', [$ring, $tech]) }}" method="POST" onsubmit="return confirm('Delete this technology node Asset?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-500 rounded-lg hover:bg-surface2 transition-colors">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-xs text-slate-500 italic tracking-wide">
                            No functional cluster node modules assigned to this vector ring track layer yet.
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="card p-12 text-center bg-surface/30">
                <div class="w-16 h-16 bg-slate-950 border border-border2 text-slate-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                </div>
                <h3 class="text-md font-700 text-slate-300">System Orbit Array is Blank</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-5">Deploy your foundational geometric layer to activate dynamic interactive orbit simulations.</p>
                <a href="{{ route('admin.technologies.rings.create') }}" class="btn btn-primary px-5 py-2.5 text-xs font-600">
                    Add Initial Track Layer
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection