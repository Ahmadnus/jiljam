@extends('admin.layout')

@section('title', 'Contact & Social')

@php
    /**
     * Font Awesome icon classes for social platforms.
     */
    $socialIconMap = [
        'facebook'  => 'fa-brands fa-facebook-f',
        'instagram' => 'fa-brands fa-instagram',
        'whatsapp'  => 'fa-brands fa-whatsapp',
        'tiktok'    => 'fa-brands fa-tiktok',
        'twitter_x' => 'fa-brands fa-x-twitter',
        'linkedin'  => 'fa-brands fa-linkedin-in',
        'youtube'   => 'fa-brands fa-youtube',
        'snapchat'  => 'fa-brands fa-snapchat',
        'telegram'  => 'fa-brands fa-telegram',
        'pinterest' => 'fa-brands fa-pinterest-p',
        'github'    => 'fa-brands fa-github',
        'gitlab'    => 'fa-brands fa-gitlab',
        'dribbble'  => 'fa-brands fa-dribbble',
        'behance'   => 'fa-brands fa-behance',
        'custom'    => 'fa-solid fa-link',
    ];

    /**
     * Font Awesome icon classes for contact items.
     * Keep your existing contactIconOptions keys; just add icon class for each one.
     */
    $contactFaIconMap = [
        'email'    => 'fa-solid fa-envelope',
        'phone'    => 'fa-solid fa-phone',
        'mobile'   => 'fa-solid fa-mobile-screen-button',
        'whatsapp' => 'fa-brands fa-whatsapp',
        'location' => 'fa-solid fa-location-dot',
        'website'  => 'fa-solid fa-globe',
        'hours'    => 'fa-regular fa-clock',
        'fax'      => 'fa-solid fa-fax',
        'custom'   => 'fa-solid fa-circle-question',
    ];
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endpush

@section('body')
<div class="page-header">
    <div>
        <h1 class="font-display text-2xl font-bold">Contact &amp; Social</h1>
        <p class="text-sm mt-1" style="color:var(--muted)">Manage contact section text, contact info items, and social media links.</p>
    </div>
</div>

<div class="page-content" x-data="contactPage()">

    {{-- Contact Section Text --}}
    <div class="card fade-in mb-6">
        <div class="card-header">
            <div class="flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:var(--accent)">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                </svg>
                <h2 class="text-sm font-semibold">Section Content</h2>
            </div>
            <button type="button" @click="sectionOpen = !sectionOpen" class="btn btn-ghost btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" :style="sectionOpen ? 'transform:rotate(180deg)' : ''">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
                <span x-text="sectionOpen ? 'Collapse' : 'Expand'"></span>
            </button>
        </div>

        <div x-show="sectionOpen" x-transition class="card-body">
            <form method="POST" action="{{ route('admin.content.contact.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label class="label">Badge EN</label>
                        <input type="text" name="badge_en" class="input" value="{{ old('badge_en', $contact->badge_en) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Badge AR</label>
                        <input type="text" name="badge_ar" class="input" value="{{ old('badge_ar', $contact->badge_ar) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Heading EN</label>
                        <input type="text" name="heading_en" class="input" value="{{ old('heading_en', $contact->heading_en) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Heading AR</label>
                        <input type="text" name="heading_ar" class="input" value="{{ old('heading_ar', $contact->heading_ar) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">Description EN</label>
                        <textarea name="desc_en" class="input" rows="3" required>{{ old('desc_en', $contact->desc_en) }}</textarea>
                    </div>
                    <div class="field">
                        <label class="label">Description AR</label>
                        <textarea name="desc_ar" class="input" rows="3" required>{{ old('desc_ar', $contact->desc_ar) }}</textarea>
                    </div>
                    <div class="field">
                        <label class="label">CTA Button EN</label>
                        <input type="text" name="cta_en" class="input" value="{{ old('cta_en', $contact->cta_en) }}" required>
                    </div>
                    <div class="field">
                        <label class="label">CTA Button AR</label>
                        <input type="text" name="cta_ar" class="input" value="{{ old('cta_ar', $contact->cta_ar) }}" required>
                    </div>
                    <div class="field" style="grid-column: 1/-1">
                        <label class="label">CTA Email Address</label>
                        <input type="email" name="cta_email" class="input" value="{{ old('cta_email', $contact->cta_email) }}" required>
                    </div>
                </div>

                <button class="btn btn-primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save Section
                </button>
            </form>
        </div>
    </div>

    <div class="grid gap-6" style="grid-template-columns: 1fr 1fr">

        {{-- Contact Items --}}
        <div class="card fade-in">
            <div class="card-header">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:var(--accent)">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4M12 16h.01"/>
                    </svg>
                    <h2 class="text-sm font-semibold">Contact Info Items</h2>
                </div>
                <span class="badge badge-blue">{{ $items->count() }}</span>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.contact.item.store') }}"
                      x-data="contactItemForm()"
                      class="mb-6 pb-6"
                      style="border-bottom:1px solid var(--border)">
                    @csrf

                    <div class="field">
                        <label class="label">Icon Type</label>
                        <select id="contactIconSelect" name="icon_key" class="input" x-model="selectedKey" @change="syncIcon()">
                            @foreach($contactIconOptions as $key => $opt)
                                <option value="{{ $key }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4 mb-4 p-3 rounded-xl" style="background:var(--surface2);border:1px solid var(--border)">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-white"
                             :style="'background:' + currentColor">
                            <i :class="currentIcon" class="text-lg"></i>
                        </div>

                        <div class="flex-1">
                            <div class="text-xs font-semibold mb-1" style="color:var(--muted)">Preview</div>
                            <div class="text-sm font-medium" x-text="currentLabel"></div>
                        </div>

                        <div>
                            <label class="label mb-1">Color</label>
                            <div class="flex items-center gap-2">
                                <input type="color" name="color" x-model="currentColor"
                                       class="w-8 h-8 rounded cursor-pointer" style="border:none;padding:1px;background:none">
                                <input type="text" x-model="currentColor"
                                       class="input text-xs font-mono" style="width:90px;padding:6px 10px">
                            </div>
                        </div>
                    </div>

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
                    </div>

                    <button type="submit" class="btn btn-ghost btn-sm">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Add Item
                    </button>
                </form>

               <div id="contactItemsList" class="space-y-2" x-data="{ editingId: null }">
    @forelse($items as $item)
        @php
            $itemIconKey = $item->icon_key ?? 'custom';
            $itemIconClass = $contactFaIconMap[$itemIconKey] ?? $contactFaIconMap['custom'];
        @endphp

        <div class="p-3 rounded-xl"
             style="background:var(--surface2);border:1px solid var(--border)"
             data-id="{{ $item->id }}" draggable="true">

            <div class="flex items-center gap-3">
                <div class="drag-handle flex-shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="9" y1="6" x2="9" y2="6"/>
                        <line x1="15" y1="6" x2="15" y2="6"/>
                        <line x1="9" y1="12" x2="9" y2="12"/>
                        <line x1="15" y1="12" x2="15" y2="12"/>
                        <line x1="9" y1="18" x2="9" y2="18"/>
                        <line x1="15" y1="18" x2="15" y2="18"/>
                    </svg>
                </div>

                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-white"
                     style="background:{{ $item->color ?? '#3b82f6' }}">
                    <i class="{{ $itemIconClass }} text-xs"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold truncate">{{ $item->label_en }}</div>
                    <div class="text-xs truncate" style="color:var(--muted)">{{ $item->value_en }}</div>
                </div>

                <div class="flex items-center gap-1 flex-shrink-0">
                    <button type="button"
                            class="btn btn-ghost btn-icon btn-sm"
                            @click="editingId = editingId === {{ $item->id }} ? null : {{ $item->id }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.1 2.1 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                        </svg>
                    </button>

                    <span class="badge {{ $item->is_active ? 'badge-green' : 'badge-red' }} text-[10px]">
                        {{ $item->is_active ? 'On' : 'Off' }}
                    </span>

                    <form method="POST" action="{{ route('admin.content.contact.item.destroy', $item) }}"
                          onsubmit="return confirm('Delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-icon btn-sm" data-tip="Delete">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div x-show="editingId === {{ $item->id }}" x-cloak class="mt-4 pt-4" style="border-top:1px solid var(--border)">
                <form method="POST" action="{{ route('admin.content.contact.item.update', $item) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="field">
                            <label class="label">Icon Type</label>
                            <select name="icon_key" class="input" required>
                                @foreach($contactIconOptions as $key => $opt)
                                    <option value="{{ $key }}" @selected($item->icon_key === $key)>
                                        {{ $opt['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label class="label">Color</label>
                            <input type="color" name="color" class="input" value="{{ $item->color ?? '#3b82f6' }}">
                        </div>

                        <div class="field">
                            <label class="label">Label EN</label>
                            <input type="text" name="label_en" class="input" value="{{ $item->label_en }}" required>
                        </div>

                        <div class="field">
                            <label class="label">Label AR</label>
                            <input type="text" name="label_ar" class="input" value="{{ $item->label_ar }}" required>
                        </div>

                        <div class="field">
                            <label class="label">Value EN</label>
                            <input type="text" name="value_en" class="input" value="{{ $item->value_en }}" required>
                        </div>

                        <div class="field">
                            <label class="label">Value AR</label>
                            <input type="text" name="value_ar" class="input" value="{{ $item->value_ar }}" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        <button type="button" class="btn btn-ghost btn-sm" @click="editingId = null">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-8 text-sm" style="color:var(--muted)">
            No contact items yet. Add one above.
        </div>
    @endforelse
</div>
            </div>
        </div>

        {{-- Social Links --}}
        <div class="card fade-in">
            <div class="card-header">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:var(--accent2)">
                        <circle cx="18" cy="5" r="3"/>
                        <circle cx="6" cy="12" r="3"/>
                        <circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                    <h2 class="text-sm font-semibold">Social Media Links</h2>
                </div>
                <span class="badge badge-blue">{{ $socials->count() }}</span>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.social.store') }}"
                      x-data="socialForm()"
                      class="mb-6 pb-6"
                      style="border-bottom:1px solid var(--border)">
                    @csrf

                    <div class="field">
                        <label class="label">Platform</label>
                        <select id="platformSelect" name="platform_key" class="input" x-model="selectedPlatform" @change="onPlatformChange()">
                            <optgroup label="Social Media">
                                @foreach($socialPlatforms as $key => $plat)
                                    @if($plat['category'] === 'social')
                                        <option value="{{ $key }}">{{ $plat['label'] }}</option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Developer">
                                @foreach($socialPlatforms as $key => $plat)
                                    @if($plat['category'] === 'dev')
                                        <option value="{{ $key }}">{{ $plat['label'] }}</option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Design">
                                @foreach($socialPlatforms as $key => $plat)
                                    @if($plat['category'] === 'design')
                                        <option value="{{ $key }}">{{ $plat['label'] }}</option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Other">
                                @foreach($socialPlatforms as $key => $plat)
                                    @if($plat['category'] === 'other')
                                        <option value="{{ $key }}">{{ $plat['label'] }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl mb-4" style="background:var(--surface2);border:1px solid var(--border)">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-white"
                             :style="'background:' + platformColor">
                            <i :class="platformIcon" class="text-lg"></i>
                        </div>
                        <div>
                            <div class="text-xs" style="color:var(--muted)">Selected Platform</div>
                            <div class="text-sm font-semibold" x-text="platformLabel"></div>
                        </div>
                        <div class="ml-auto" x-show="selectedPlatform === 'whatsapp'">
                            <span class="badge badge-green text-[10px]">WhatsApp Mode</span>
                        </div>
                    </div>

                    <div class="field" x-show="selectedPlatform === 'whatsapp'" x-transition>
                        <label class="label">WhatsApp Number</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm" style="color:var(--muted)">+</span>
                            <input type="text" name="whatsapp_number"
                                   class="input pl-7 font-mono"
                                   placeholder="31612345678"
                                   :required="selectedPlatform === 'whatsapp'"
                                   x-model="waNumber">
                        </div>
                        <div class="mt-1 text-xs" style="color:var(--muted)">
                            Include country code, no spaces or dashes. e.g. <code class="font-mono">31612345678</code>
                        </div>
                        <div class="mt-2 text-xs font-mono px-3 py-2 rounded-lg"
                             style="background:var(--bg);color:var(--accent)"
                             x-show="waNumber"
                             x-text="'https://wa.me/' + waNumber.replace(/\\D/g,'')"></div>
                    </div>

                    <div class="field" x-show="selectedPlatform !== 'whatsapp'" x-transition>
                        <label class="label">URL</label>
                        <input type="url" name="href"
                               class="input"
                               placeholder="https://..."
                               :required="selectedPlatform !== 'whatsapp'">
                    </div>

                    <div class="flex items-center gap-3 mb-4 p-3 rounded-xl" style="background:var(--surface2);border:1px solid var(--border)">
                        <div x-data="{ on: false }">
                            <input type="hidden" name="is_floating" :value="on ? '1' : '0'">
                            <button type="button" @click="on = !on" class="toggle" :class="on ? 'on' : ''"></button>
                        </div>
                        <div>
                            <div class="text-sm font-semibold">Floating Button</div>
                            <div class="text-xs" style="color:var(--muted)">Show as floating action button on the site (ideal for WhatsApp)</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ghost btn-sm">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Add Social Link
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Link / Number</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($socials as $social)
                                @php
                                    $platformKey = strtolower($social->platform_key ?? 'custom');
                                    $platformMeta = $socialPlatforms[$platformKey] ?? $socialPlatforms['custom'] ?? [];
                                    $platformIconClass = $socialIconMap[$platformKey] ?? $socialIconMap['custom'];
                                @endphp

                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-white"
                                                 style="background:{{ $platformMeta['color'] ?? '#64748b' }}">
                                                <i class="{{ $platformIconClass }} text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold">{{ $social->label }}</div>
                                                <div class="text-[10px] uppercase tracking-wide" style="color:var(--muted)">{{ $social->platform_key }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if($social->platform_key === 'whatsapp' && $social->whatsapp_number)
                                            <span class="font-mono text-xs" style="color:var(--success)">+{{ $social->whatsapp_number }}</span>
                                        @elseif($social->href)
                                            <a href="{{ $social->href }}" target="_blank"
                                               class="text-xs truncate block max-w-[160px] hover:underline"
                                               style="color:var(--accent)">
                                                {{ $social->href }}
                                            </a>
                                        @else
                                            <span style="color:var(--muted)">—</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($social->is_floating)
                                            <span class="badge badge-amber text-[10px]">
                                                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                                Floating
                                            </span>
                                        @else
                                            <span class="badge badge-blue text-[10px]">Footer</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="badge {{ $social->is_active ? 'badge-green' : 'badge-red' }} text-[10px]">
                                            {{ $social->is_active ? 'Active' : 'Hidden' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <form method="POST" action="{{ route('admin.content.social.update', $social) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="platform_key" value="{{ $social->platform_key }}">
                                                <input type="hidden" name="href" value="{{ $social->href }}">
                                                <input type="hidden" name="whatsapp_number" value="{{ $social->whatsapp_number }}">
                                                <input type="hidden" name="is_floating" value="{{ $social->is_floating ? '1' : '0' }}">
                                                <input type="hidden" name="is_active" value="{{ $social->is_active ? '0' : '1' }}">
                                                <button type="submit" class="btn btn-ghost btn-icon btn-sm"
                                                        data-tip="{{ $social->is_active ? 'Deactivate' : 'Activate' }}">
                                                    @if($social->is_active)
                                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                                            <line x1="1" y1="1" x2="23" y2="23"/>
                                                        </svg>
                                                    @else
                                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                            <circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.content.social.destroy', $social) }}"
                                                  onsubmit="return confirm('Delete {{ $social->label }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon btn-sm" data-tip="Delete">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                        <polyline points="3 6 5 6 21 6"/>
                                                        <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-sm" style="color:var(--muted)">
                                        No social links yet. Add one above.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const PLATFORM_DATA   = @json($socialPlatforms);
    const CONTACT_ICONS   = @json($contactIconOptions);
    const SOCIAL_ICON_MAP = @json($socialIconMap);
    const CONTACT_FA_MAP  = @json($contactFaIconMap);

    function getIconClass(icon, fallbackKey) {
        if (!icon) return CONTACT_FA_MAP[fallbackKey] || CONTACT_FA_MAP.custom || 'fa-solid fa-circle-question';

        if (typeof icon === 'string') return icon;
        if (typeof icon.icon === 'string') return icon.icon;
        if (typeof icon.icon_class === 'string') return icon.icon_class;
        if (typeof icon.class === 'string') return icon.class;

        return CONTACT_FA_MAP[fallbackKey] || CONTACT_FA_MAP.custom || 'fa-solid fa-circle-question';
    }

    function getSocialIconClass(plat, fallbackKey) {
        if (!plat) return SOCIAL_ICON_MAP[fallbackKey] || SOCIAL_ICON_MAP.custom || 'fa-solid fa-link';

        if (typeof plat === 'string') return plat;
        if (typeof plat.icon === 'string') return plat.icon;
        if (typeof plat.icon_class === 'string') return plat.icon_class;

        return SOCIAL_ICON_MAP[fallbackKey] || SOCIAL_ICON_MAP.custom || 'fa-solid fa-link';
    }

    function contactPage() {
        return {
            sectionOpen: false,
        };
    }

    function contactItemForm() {
        const firstKey = Object.keys(CONTACT_ICONS)[0] || 'email';
        const firstIcon = CONTACT_ICONS[firstKey] || {};

        return {
            selectedKey: firstKey,
            currentColor: firstIcon.color || '#3B82F6',
            currentLabel: firstIcon.label || 'Email',
            currentIcon: getIconClass(firstIcon, firstKey),

            syncIcon() {
                const icon = CONTACT_ICONS[this.selectedKey] || {};
                this.currentColor = icon.color || '#3B82F6';
                this.currentLabel = icon.label || this.selectedKey;
                this.currentIcon = getIconClass(icon, this.selectedKey);
            }
        };
    }

    function socialForm() {
        const firstKey = Object.keys(PLATFORM_DATA)[0] || 'facebook';
        const firstPlat = PLATFORM_DATA[firstKey] || {};

        return {
            selectedPlatform: firstKey,
            platformLabel: firstPlat.label || 'Facebook',
            platformColor: firstPlat.color || '#1877F2',
            platformIcon: getSocialIconClass(firstPlat, firstKey),
            waNumber: '',

            onPlatformChange() {
                const plat = PLATFORM_DATA[this.selectedPlatform] || {};
                this.platformLabel = plat.label || this.selectedPlatform;
                this.platformColor = plat.color || '#64748B';
                this.platformIcon = getSocialIconClass(plat, this.selectedPlatform);
            }
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        initDragSort('contactItemsList', '{{ route("admin.content.contact.item.store") }}/reorder');
    });
</script>
@endpush