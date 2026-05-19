@extends('admin.layout')
@section('title', 'Manage Services')

@section('body')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="font-display text-2xl font-800 text-slate-100">Services</h1>
        <p class="text-sm text-slate-500 mt-1">Manage and organize your service offerings</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Add New Service
    </a>
</div>

<div class="page-content fade-in">
    <div class="card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="80">Order</th>
                        <th>Service Details</th>
                        <th>Color Theme</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="services-sortable">
                    @forelse($services as $service)
                    <tr data-id="{{ $service->id }}">
                        <td>
                            <span class="font-display font-800 text-slate-500 text-lg">#{{ $service->number_display }}</span>
                        </td>
                        <td>
    <div class="flex items-center gap-3">
        {{-- صندوق الأيقونة المحمي --}}
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-surface2 border border-border2 text-accent overflow-hidden flex-shrink-0">
            @if(str_contains($service->icon_path, '<svg'))
                {{-- إذا كان الكود يحتوي على وسم SVG كامل --}}
                {!! $service->icon_path !!}
            @else
                {{-- إذا كان الكود يحتوي على مسارات فقط، يتم تغليفه وحمايته هنا --}}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    {!! $service->icon_path !!}
                </svg>
            @endif
        </div>
        <div>
            <div class="font-600 text-slate-200">{{ $service->title_en }}</div>
            <div class="text-xs text-slate-500">{{ $service->title_ar }}</div>
        </div>
    </div>
</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <span class="color-swatch" style="background: {{ $service->color }}"></span>
                                <code class="text-xs text-slate-400">{{ $service->color }}</code>
                            </div>
                        </td>
                        <td>
                            @if($service->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-ghost btn-icon" data-tip="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" data-tip="Delete">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center text-slate-500">No services found. Start by adding one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection