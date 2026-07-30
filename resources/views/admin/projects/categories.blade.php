@extends('admin.layout')

@section('title', 'Project Categories')

@section('body')
<div class="page-header">
    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold">Project Categories</h1>
            <p class="text-sm" style="color:var(--muted)">Organize projects into categories (e.g. E-commerce, Portfolio, Web Apps).</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-sm">Back to Projects</a>
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
                    <h2 class="text-sm font-semibold">Add Category</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.categories.store') }}">
                        @csrf

                        <div class="field">
                            <label class="label">Name EN</label>
                            <input type="text" name="name_en" class="input" value="{{ old('name_en') }}" placeholder="E-commerce" required>
                            @error('name_en') <div class="mt-1 text-sm text-red-400">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label class="label">Name AR</label>
                            <input type="text" name="name_ar" class="input" value="{{ old('name_ar') }}" dir="rtl" placeholder="متجر إلكتروني" required>
                            @error('name_ar') <div class="mt-1 text-sm text-red-400">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="xl:col-span-8">
            <div class="card fade-in">
                <div class="card-header">
                    <h2 class="text-sm font-semibold">Categories</h2>
                    <span class="badge badge-blue">{{ $categories->count() }}</span>
                </div>
                <div class="card-body p-0 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name EN</th>
                                    <th>Name AR</th>
                                    <th class="text-center">Projects</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody x-data="{ editingId: null }">
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->name_en }}</td>
                                        <td dir="rtl">{{ $category->name_ar }}</td>
                                        <td class="text-center">{{ $category->projects_count }}</td>
                                        <td class="text-center">
                                            @if($category->is_active)
                                                <span class="badge badge-green">Active</span>
                                            @else
                                                <span class="badge badge-amber">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button type="button" class="btn btn-ghost btn-sm"
                                                        @click="editingId = editingId === {{ $category->id }} ? null : {{ $category->id }}">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.projects.categories.destroy', $category) }}"
                                                      onsubmit="return confirm('Delete this category? Projects using it will become uncategorized.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr x-show="editingId === {{ $category->id }}" x-cloak>
                                        <td colspan="5" class="bg-surface2/40">
                                            <form method="POST" action="{{ route('admin.projects.categories.update', $category) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                                    <div class="field mb-0">
                                                        <label class="label">Name EN</label>
                                                        <input type="text" name="name_en" class="input" value="{{ $category->name_en }}" required>
                                                    </div>
                                                    <div class="field mb-0">
                                                        <label class="label">Name AR</label>
                                                        <input type="text" name="name_ar" class="input" value="{{ $category->name_ar }}" dir="rtl" required>
                                                    </div>
                                                    <div class="field mb-0">
                                                        <label class="label">Active</label>
                                                        <select name="is_active" class="input">
                                                            <option value="1" @selected($category->is_active)>Active</option>
                                                            <option value="0" @selected(!$category->is_active)>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center" style="color:var(--muted)">No categories yet.</td>
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
