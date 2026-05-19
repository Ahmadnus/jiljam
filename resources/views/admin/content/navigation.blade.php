{{-- resources/views/admin/content/navigation.blade.php --}}
@extends('admin.layout')

@section('title', 'Navigation')

@section('body')
<div class="page-header">
    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold">Navigation Links</h1>
            <p class="text-sm" style="color:var(--muted)">Manage menu links shown in the frontend navbar.</p>
        </div>
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

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
        <div class="xl:col-span-4">
            <div class="card fade-in">
                <div class="card-header">
                    <h2 class="text-sm font-semibold">Add Link</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.content.navigation.store') }}">
                        @csrf

                        <div class="field">
                            <label class="label">Label EN</label>
                            <input type="text" name="label_en" class="input" value="{{ old('label_en') }}" required>
                            @error('label_en') <div class="mt-1 text-sm text-red-400">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label class="label">Label AR</label>
                            <input type="text" name="label_ar" class="input" value="{{ old('label_ar') }}" required>
                            @error('label_ar') <div class="mt-1 text-sm text-red-400">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label class="label">Href</label>
                            <input type="text" name="href" class="input" value="{{ old('href') }}" placeholder="#services" required>
                            @error('href') <div class="mt-1 text-sm text-red-400">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">Add Link</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="xl:col-span-8">
            <div class="card fade-in">
                <div class="card-header">
                    <h2 class="text-sm font-semibold">Links</h2>
                </div>
                <div class="card-body p-0 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Label EN</th>
                                    <th>Label AR</th>
                                    <th>Href</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($links as $link)
                                    <tr>
                                        <td>{{ $link->sort_order }}</td>
                                        <td>{{ $link->label_en }}</td>
                                        <td dir="rtl">{{ $link->label_ar }}</td>
                                        <td><code>{{ $link->href }}</code></td>
                                        <td>
                                            @if($link->is_active)
                                                <span class="badge badge-green">Active</span>
                                            @else
                                                <span class="badge badge-amber">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <form method="POST" action="{{ route('admin.content.navigation.destroy', $link) }}" onsubmit="return confirm('Delete this link?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center" style="color:var(--muted)">No navigation links yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection