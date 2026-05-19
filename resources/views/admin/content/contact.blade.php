{{-- resources/views/admin/content/contact.blade.php --}}
@extends('admin.layout')

@section('title', 'Contact Content')

@php
    // مصفوفة السوشيال ميديا (Solid SVG & Valid PHP)
    $socialIconPresets = [
        ['code' => 'LN', 'label' => 'LinkedIn', 'bg' => '#0A66C2', 'svg' => '<path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>'],
        ['code' => 'GH', 'label' => 'GitHub', 'bg' => '#24292F', 'svg' => '<path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.268 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.026 2.747-1.026.546 1.379.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.161 22 16.416 22 12c0-5.523-4.477-10-10-10z"/>'],
        ['code' => 'X', 'label' => 'X / Twitter', 'bg' => '#111111', 'svg' => '<path d="M18.24 2.55h3.31l-7.23 8.26 8.5 11.23h-6.66l-5.21-6.81-5.97 6.81H1.67l7.73-8.83L1.25 2.55h6.82l4.71 6.23 5.46-6.23zm-1.16 17.52h1.83L7.08 4.45H5.12l11.96 15.62z"/>'],
        ['code' => 'IG', 'label' => 'Instagram', 'bg' => '#E1306C', 'svg' => '<path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.67 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.64-.07-4.85s.01-3.58.07-4.85c.15-3.27 1.67-4.77 4.92-4.92 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07c-4.27.2-6.78 2.71-6.98 6.98C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.27 2.71 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.27-.2 6.78-2.71 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.27-2.71-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.84-11.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/>'],
        ['code' => 'FB', 'label' => 'Facebook', 'bg' => '#1877F2', 'svg' => '<path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7.5v-3H10V9.5C10 7.03 11.47 5.66 13.79 5.66c1.09 0 2.23.19 2.23.19v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 3h-2.33v6.8C18.56 20.87 22 16.84 22 12z"/>'],
        ['code' => 'WA', 'label' => 'WhatsApp', 'bg' => '#25D366', 'svg' => '<path d="M12.03 2C6.5 2 2 6.5 2 12.04c0 1.77.46 3.49 1.33 5.01L2 22l5.09-1.33A9.97 9.97 0 0012.03 22c5.53 0 10.02-4.49 10.02-10.01S17.56 2 12.03 2zm5.34 14.37c-.22.63-1.3 1.2-1.78 1.25-.44.05-.98.1-1.57-.1-1.38-.47-3.03-1.63-4.22-3-1.2-1.38-2.02-2.8-2.12-4-.09-1.18.5-1.8.76-2.07.25-.26.55-.32.74-.32s.37 0 .52.02c.16.02.38-.06.59.45.22.52.71 1.73.77 1.86.06.13.1.28.02.43-.08.15-.12.24-.24.38-.11.13-.24.28-.33.38-.1.11-.22.22-.1.43.12.21.52.88 1.13 1.42.79.7 1.45.92 1.66 1.03.22.11.35.09.48-.06.13-.15.56-.65.71-.87.15-.22.3-.18.5-.11.2.08 1.28.6 1.5.72.22.11.37.17.42.27.05.09.05.53-.17 1.16z"/>'],
    ];

    // مصفوفة أيقونات التواصل (Solid SVG & Valid PHP)
    $contactIconPresets = [
        ['code' => 'EM', 'label' => 'Email', 'bg' => '#3B82F6', 'svg' => '<path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>'],
        ['code' => 'PH', 'label' => 'Phone', 'bg' => '#10B981', 'svg' => '<path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>'],
        ['code' => 'MP', 'label' => 'Map Pin', 'bg' => '#EF4444', 'svg' => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>'],
        ['code' => 'CL', 'label' => 'Clock', 'bg' => '#F59E0B', 'svg' => '<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>'],
        ['code' => 'GL', 'label' => 'Globe', 'bg' => '#14B8A6', 'svg' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>'],
    ];
@endphp

@section('body')
<div class="page-header">
    <div>
        <h1 class="font-display text-2xl font-bold">Contact Content</h1>
        <p class="text-sm" style="color:var(--muted)">Edit contact headline, items, and social links.</p>
    </div>
</div>

<div class="page-content">
    @if(session('success'))
        <div class="alert alert-success fade-in">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card fade-in mb-4">
        <div class="card-header">
            <h2 class="text-sm font-semibold">Main Contact Section</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.content.contact.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label class="label">Badge EN</label>
                        <input type="text" name="badge_en" class="input" value="{{ old('badge_en', $contact->badge_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Badge AR</label>
                        <input type="text" name="badge_ar" class="input" value="{{ old('badge_ar', $contact->badge_ar ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label class="label">Heading EN</label>
                        <input type="text" name="heading_en" class="input" value="{{ old('heading_en', $contact->heading_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Heading AR</label>
                        <input type="text" name="heading_ar" class="input" value="{{ old('heading_ar', $contact->heading_ar ?? '') }}" required>
                    </div>

                    <div class="field md:col-span-2">
                        <label class="label">Description EN</label>
                        <textarea name="desc_en" class="input" rows="4" required>{{ old('desc_en', $contact->desc_en ?? '') }}</textarea>
                    </div>
                    <div class="field md:col-span-2">
                        <label class="label">Description AR</label>
                        <textarea name="desc_ar" class="input" rows="4" required>{{ old('desc_ar', $contact->desc_ar ?? '') }}</textarea>
                    </div>

                    <div class="field">
                        <label class="label">CTA EN</label>
                        <input type="text" name="cta_en" class="input" value="{{ old('cta_en', $contact->cta_en ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label class="label">CTA AR</label>
                        <input type="text" name="cta_ar" class="input" value="{{ old('cta_ar', $contact->cta_ar ?? '') }}" required>
                    </div>

                    <div class="field md:col-span-2">
                        <label class="label">CTA Email</label>
                        <input type="email" name="cta_email" class="input" value="{{ old('cta_email', $contact->cta_email ?? '') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">Save Contact Content</button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <div class="card fade-in">
            <div class="card-header">
                <h2 class="text-sm font-semibold">Contact Items</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.contact.item.store') }}" class="mb-5">
                    @csrf

                    <div class="form-grid">
                        <div class="field">
                            <label class="label">Label EN</label>
                            <input type="text" name="label_en" class="input" placeholder="Email" required>
                        </div>
                        <div class="field">
                            <label class="label">Label AR</label>
                            <input type="text" name="label_ar" class="input" placeholder="البريد" required>
                        </div>
                        <div class="field">
                            <label class="label">Value EN</label>
                            <input type="text" name="value_en" class="input" placeholder="hello@example.com" required>
                        </div>
                        <div class="field">
                            <label class="label">Value AR</label>
                            <input type="text" name="value_ar" class="input" placeholder="hello@example.com" required>
                        </div>
                        <div class="field md:col-span-2">
                            <label class="label">Color</label>
                            <input type="text" name="color" class="input" placeholder="#3b82f6" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Icon SVG</label>
                        <textarea id="contact_item_icon_svg" name="icon_path" class="input" rows="5" placeholder="<svg>...</svg>"></textarea>
                    </div>

                    <div class="field">
                        <label class="label">Icon SVG 2</label>
                        <textarea id="contact_item_icon_svg_2" name="icon_path2" class="input" rows="5" placeholder="<svg>...</svg>"></textarea>
                    </div>

                    <div class="field flex items-center gap-3">
                        <input type="checkbox" name="icon_circle" value="1" id="icon_circle" class="h-4 w-4 rounded border-slate-600 bg-transparent">
                        <label for="icon_circle" class="label mb-0 normal-case" style="text-transform:none;letter-spacing:0">Icon Circle</label>
                    </div>

                    <div class="field">
                        <label class="label">Suggestions</label>
                        <div class="icon-picker-grid flex flex-wrap gap-2">
                            @foreach($contactIconPresets as $icon)
                                <button type="button"
                                        class="icon-opt flex items-center justify-center w-10 h-10 rounded text-white transition-all hover:scale-110"
                                        style="background-color: {{ $icon['bg'] }}"
                                        title="{{ $icon['label'] }}"
                                        data-svg="{{ htmlspecialchars($icon['svg']) }}"
                                        onclick="fillContactIcon(this.getAttribute('data-svg'))">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        {!! $icon['svg'] !!}
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <button class="btn btn-ghost">Add Item</button>
                </form>

                <div class="space-y-3">
                    @forelse($items ?? [] as $item)
                        <div class="rounded-xl border p-4" style="border-color:var(--border);background:var(--surface2)">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ $item->label_en }} / {{ $item->label_ar }}</div>
                                    <div class="text-sm" style="color:var(--muted)">{{ $item->value_en }}</div>
                                </div>
                                <form method="POST" action="{{ route('admin.content.contact.item.destroy', $item) }}" onsubmit="return confirm('Delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm" style="color:var(--muted)">No contact items yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card fade-in">
            <div class="card-header">
                <h2 class="text-sm font-semibold">Social Links</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.social.store') }}" class="mb-5">
                    @csrf

                    <div class="form-grid">
                        <div class="field">
                            <label class="label">Label</label>
                            <input type="text" name="label" class="input" placeholder="Instagram" required>
                        </div>
                        <div class="field">
                            <label class="label">Href</label>
                            <input type="url" name="href" class="input" placeholder="https://..." required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">SVG Icon</label>
                        <textarea id="social_icon_svg" name="icon_svg" class="input" rows="5" placeholder="<svg>...</svg>" required></textarea>
                    </div>

                    <div class="field">
                        <label class="label">Suggestions</label>
                        <div class="icon-picker-grid flex flex-wrap gap-2">
                            @foreach($socialIconPresets as $icon)
                                <button type="button"
                                        class="icon-opt flex items-center justify-center w-10 h-10 rounded text-white transition-all hover:scale-110"
                                        style="background-color: {{ $icon['bg'] }}"
                                        title="{{ $icon['label'] }}"
                                        data-svg="{{ htmlspecialchars($icon['svg']) }}"
                                        onclick="fillSocialIcon(this.getAttribute('data-svg'))">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        {!! $icon['svg'] !!}
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <button class="btn btn-ghost">Add Social Link</button>
                </form>

                <div class="space-y-3">
                    @forelse($socials ?? [] as $social)
                        <div class="rounded-xl border p-4" style="border-color:var(--border);background:var(--surface2)">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ $social->label }}</div>
                                    <div class="truncate text-sm" style="color:var(--muted);max-width:280px;">{{ $social->href }}</div>
                                </div>
                                <form method="POST" action="{{ route('admin.content.social.destroy', $social) }}" onsubmit="return confirm('Delete this social link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm" style="color:var(--muted)">No social links yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// الدالة المسؤولة عن تغليف المسار (Path) داخل تاج الـ SVG ليكون جاهز للحفظ والاستخدام بالواجهة
function buildSvgString(path) {
    return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">\n  ${path}\n</svg>`;
}

function fillSocialIcon(svgPath) {
    const el = document.getElementById('social_icon_svg');
    if (!el) return;
    el.value = buildSvgString(svgPath);
    el.dispatchEvent(new Event('input', { bubbles: true }));
}

function fillContactIcon(svgPath) {
    const primary = document.getElementById('contact_item_icon_svg');
    const secondary = document.getElementById('contact_item_icon_svg_2');
    const svgCode = buildSvgString(svgPath);

    if (primary) {
        primary.value = svgCode;
        primary.dispatchEvent(new Event('input', { bubbles: true }));
    }

    if (secondary) {
        secondary.value = svgCode;
        secondary.dispatchEvent(new Event('input', { bubbles: true }));
    }
}
</script>
@endpush