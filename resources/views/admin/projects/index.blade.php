@extends('admin.layout')
@section('title', 'Projects Portfolio')

@section('body')
<div class="page-header">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="font-display text-2xl font-800 text-slate-100">Portfolio Projects</h1>
            <p class="text-sm text-slate-500 mt-1">Showcase, reorder, and manage your technical build assignments.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Project
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

    <div class="card border border-border/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface2/50 border-b border-border text-slate-400 text-xs font-700 uppercase tracking-wider">
                        <th class="p-4 w-20 text-center">Order</th>
                        <th class="p-4">Project Preview & Title</th>
                        <th class="p-4 w-32">Abbreviation</th>
                        <th class="p-4 w-32 text-center">Status</th>
                        <th class="p-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/40 text-sm">
                    @forelse ($projects as $project)
                        <tr class="hover:bg-surface2/20 transition-colors">
                            {{-- رقم الترتيب --}}
                            <td class="p-4 text-center font-mono font-700 text-slate-500">
                                #{{ $project->sort_order ?? 0 }}
                            </td>
                            
                            {{-- العنوان والصورة --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-14 h-10 rounded-lg bg-surface2 border border-border2 flex items-center justify-center overflow-hidden flex-shrink-0 shadow-inner">
                                        @if($project->image)
                                            <img src="{{ asset('storage/' . $project->image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] font-bold text-slate-600 font-mono">N/A</span>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="font-600 text-slate-200 truncate">{{ $project->title_en }}</div>
                                        <div class="text-xs text-slate-500 truncate mt-0.5" dir="rtl">{{ $project->title_ar }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- الاختصار --}}
                            <td class="p-4 font-mono text-xs text-accent font-700">
                                {{ $project->abbr ?: '—' }}
                            </td>

                            {{-- حالة المشروع --}}
                            <td class="p-4 text-center">
                                @if($project->is_active)
                                    <span class="text-[10px] font-700 uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Visible</span>
                                @else
                                    <span class="text-[10px] font-700 uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-500 border border-border2">Hidden</span>
                                @endif
                            </td>

                            {{-- إجراءات التحكم --}}
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 text-slate-400 hover:text-amber-400 rounded-lg hover:bg-surface2 transition-colors">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to completely remove this project assignment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-500 rounded-lg hover:bg-surface2 transition-colors">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-500 italic tracking-wide bg-surface/10">
                                No portfolio projects discovered within database cluster pipelines.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection