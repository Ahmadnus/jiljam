{{-- resources/views/admin/content/about.blade.php --}}
@extends('admin.layout')

@section('title', 'About Content')

@section('body')
<div class="page-header">
    <div>
        <h1 class="font-display text-2xl font-bold">About Content</h1>
        <p class="text-sm" style="color:var(--muted)">Edit the about text, stats, and skills shown on the frontend.</p>
    </div>
</div>

<div class="page-content">
    <div class="card fade-in mb-4">
        <div class="card-header">
            <h2 class="text-sm font-semibold">About Section</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.content.about.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label class="label">Badge EN</label>
                        <input type="text" name="badge_en" class="input" value="{{ old('badge_en', $about->badge_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Badge AR</label>
                        <input type="text" name="badge_ar" class="input" value="{{ old('badge_ar', $about->badge_ar ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label class="label">Heading EN</label>
                        <input type="text" name="heading_en" class="input" value="{{ old('heading_en', $about->heading_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Heading AR</label>
                        <input type="text" name="heading_ar" class="input" value="{{ old('heading_ar', $about->heading_ar ?? '') }}" required>
                    </div>

                    <div class="field md:col-span-2">
                        <label class="label">Description EN</label>
                        <textarea name="desc_en" class="input" rows="4" required>{{ old('desc_en', $about->desc_en ?? '') }}</textarea>
                    </div>
                    <div class="field md:col-span-2">
                        <label class="label">Description AR</label>
                        <textarea name="desc_ar" class="input" rows="4" required>{{ old('desc_ar', $about->desc_ar ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label class="label">Skills Title EN</label>
                        <input type="text" name="skills_title_en" class="input" value="{{ old('skills_title_en', $about->skills_title_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Skills Title AR</label>
                        <input type="text" name="skills_title_ar" class="input" value="{{ old('skills_title_ar', $about->skills_title_ar ?? '') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">Save About Content</button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <div class="card fade-in">
            <div class="card-header">
                <h2 class="text-sm font-semibold">Stats</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.about.stat.store') }}" class="mb-5">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label class="label">Number</label>
                            <input type="text" name="number" class="input" placeholder="24+" required>
                        </div>
                        <div class="field">
                            <label class="label">Label EN</label>
                            <input type="text" name="label_en" class="input" placeholder="Projects" required>
                        </div>
                        <div class="field">
                            <label class="label">Label AR</label>
                            <input type="text" name="label_ar" class="input" placeholder="مشاريع" required>
                        </div>
                    </div>

                    <button class="btn btn-ghost">Add Stat</button>
                </form>

                <div class="space-y-3">
                    @forelse($stats as $stat)
                        <div class="rounded-xl border p-4" style="border-color:var(--border);background:var(--surface2)">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="text-2xl font-bold">{{ $stat->number }}</div>
                                    <div class="text-sm" style="color:var(--muted)">{{ $stat->label_en }} / {{ $stat->label_ar }}</div>
                                </div>
                                <form method="POST" action="{{ route('admin.content.about.stat.destroy', $stat) }}" onsubmit="return confirm('Delete this stat?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm" style="color:var(--muted)">No stats yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card fade-in">
            <div class="card-header">
                <h2 class="text-sm font-semibold">Skills</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.about.skill.store') }}" class="mb-5">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label class="label">Name EN</label>
                            <input type="text" name="name_en" class="input" placeholder="Laravel" required>
                        </div>
                        <div class="field">
                            <label class="label">Name AR</label>
                            <input type="text" name="name_ar" class="input" placeholder="لارافيل" required>
                        </div>
                        <div class="field">
                            <label class="label">Percentage</label>
                            <input type="number" name="percentage" class="input" min="0" max="100" placeholder="90" required>
                        </div>
                    </div>

                    <button class="btn btn-ghost">Add Skill</button>
                </form>

                <div class="space-y-3">
                    @forelse($skills as $skill)
                        <div class="rounded-xl border p-4" style="border-color:var(--border);background:var(--surface2)">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ $skill->name_en }} / {{ $skill->name_ar }}</div>
                                    <div class="text-sm" style="color:var(--muted)">{{ $skill->percentage }}%</div>
                                </div>
                                <form method="POST" action="{{ route('admin.content.about.skill.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm" style="color:var(--muted)">No skills yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection