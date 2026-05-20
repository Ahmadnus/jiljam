<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — JILJAM Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root {
    --bg:       #080d14;
    --surface:  #0d1520;
    --surface2: #111b2a;
    --border:   rgba(255,255,255,0.06);
    --border2:  rgba(255,255,255,0.10);
    --text:     #e2e8f0;
    --muted:    #64748b;
    --accent:   #3b82f6;
    --accent2:  #8b5cf6;
    --success:  #10b981;
    --warning:  #f59e0b;
    --danger:   #ef4444;
    --navy:     #24344c;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    overflow-x: hidden;
}
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: var(--surface); }
::-webkit-scrollbar-thumb { background: var(--navy); border-radius: 4px; }
.font-display { font-family: 'Syne', sans-serif; }

/* Layout */
.admin-sidebar {
    position: fixed; left: 0; top: 0; bottom: 0; width: 240px;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column;
    z-index: 40;
    transition: transform 0.3s ease;
}
.admin-main { margin-left: 240px; min-height: 100vh; }
@media (max-width: 1024px) {
    .admin-sidebar { transform: translateX(-100%); }
    .admin-sidebar.open { transform: translateX(0); }
    .admin-main { margin-left: 0; }
}

/* Sidebar nav */
.nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 16px; border-radius: 8px; margin: 1px 8px;
    font-size: 13px; font-weight: 500; color: var(--muted);
    text-decoration: none; cursor: pointer;
    transition: all 0.18s ease;
    position: relative;
}
.nav-item:hover { background: rgba(255,255,255,0.05); color: var(--text); }
.nav-item.active { background: rgba(59,130,246,0.12); color: var(--accent); }
.nav-item.active::before {
    content: ''; position: absolute; left: -8px; top: 50%;
    transform: translateY(-50%); width: 3px; height: 18px;
    background: var(--accent); border-radius: 0 3px 3px 0;
}
.nav-group-label {
    font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--muted);
    padding: 16px 24px 6px; opacity: 0.5;
}

/* Cards */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}
.card-header {
    padding: 18px 22px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.card-body { padding: 22px; }

/* Inputs */
.field { margin-bottom: 18px; }
.label {
    display: block; font-size: 12px; font-weight: 600;
    color: var(--muted); letter-spacing: 0.05em;
    text-transform: uppercase; margin-bottom: 7px;
}
.input {
    width: 100%; background: var(--bg); border: 1px solid var(--border2);
    border-radius: 9px; padding: 10px 14px; font-size: 14px;
    color: var(--text); font-family: 'DM Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.input::placeholder { color: var(--muted); opacity: 0.6; }
textarea.input { resize: vertical; min-height: 80px; }
select.input { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2364748b' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }

/* Buttons */
.btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    padding: 9px 18px; border-radius: 9px; font-size: 13px; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer; border: none;
    text-decoration: none; transition: all 0.18s ease; white-space: nowrap;
}
.btn-primary { background: var(--accent); color: #fff; }
.btn-primary:hover { background: #2563eb; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(59,130,246,0.35); }
.btn-ghost { background: rgba(255,255,255,0.05); color: var(--text); border: 1px solid var(--border2); }
.btn-ghost:hover { background: rgba(255,255,255,0.10); }
.btn-danger { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
.btn-danger:hover { background: rgba(239,68,68,0.22); }
.btn-success { background: rgba(16,185,129,0.12); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
.btn-success:hover { background: rgba(16,185,129,0.22); }
.btn-sm { padding: 6px 13px; font-size: 12px; border-radius: 7px; }
.btn-icon { width: 34px; height: 34px; padding: 0; border-radius: 8px; }

/* Table */
.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
    font-size: 11px; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted); opacity: 0.7;
    padding: 10px 14px; text-align: left; border-bottom: 1px solid var(--border);
}
.data-table td { padding: 13px 14px; border-bottom: 1px solid var(--border); font-size: 13.5px; vertical-align: middle; }
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: rgba(255,255,255,0.02); }

/* Badges */
.badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600;
}
.badge-blue { background: rgba(59,130,246,0.15); color: #93c5fd; }
.badge-green { background: rgba(16,185,129,0.15); color: #6ee7b7; }
.badge-red { background: rgba(239,68,68,0.15); color: #fca5a5; }
.badge-amber { background: rgba(245,158,11,0.15); color: #fcd34d; }

/* Color swatch */
.color-swatch { width: 18px; height: 18px; border-radius: 5px; display: inline-block; flex-shrink: 0; }

/* Toggle */
.toggle {
    position: relative; width: 40px; height: 22px;
    background: var(--border2); border-radius: 11px;
    cursor: pointer; transition: background 0.2s;
    flex-shrink: 0;
}
.toggle.on { background: var(--accent); }
.toggle::after {
    content: ''; position: absolute; top: 3px; left: 3px;
    width: 16px; height: 16px; background: white; border-radius: 50%;
    transition: transform 0.2s;
}
.toggle.on::after { transform: translateX(18px); }

/* Alert */
.alert {
    padding: 12px 16px; border-radius: 10px; font-size: 13.5px;
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}
.alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
.alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; }

/* Icon picker */
.icon-picker-grid {
    display: grid; grid-template-columns: repeat(8, 1fr); gap: 6px;
    max-height: 280px; overflow-y: auto; padding: 4px;
}
.icon-opt {
    aspect-ratio: 1; border-radius: 8px; border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s;
    background: var(--surface2);
}
.icon-opt:hover { border-color: var(--accent); background: rgba(59,130,246,0.1); }
.icon-opt.selected { border-color: var(--accent); background: rgba(59,130,246,0.18); }
.icon-opt svg { width: 18px; height: 18px; }

/* Drag handle */
.drag-handle { cursor: grab; opacity: 0.4; transition: opacity 0.2s; }
.drag-handle:hover { opacity: 1; }

/* Stat cards */
.stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 14px; padding: 20px 22px;
    transition: border-color 0.2s, transform 0.2s;
}
.stat-card:hover { border-color: var(--border2); transform: translateY(-2px); }

/* Page header */
.page-header {
    padding: 28px 32px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.page-content { padding: 28px 32px; }

/* Topbar */
.topbar {
    position: sticky; top: 0; z-index: 30;
    background: rgba(8,13,20,0.85);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 32px;
    height: 56px;
    display: flex; align-items: center; justify-content: space-between;
}

/* Sidebar overlay for mobile */
.sidebar-overlay {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6);
    z-index: 39; backdrop-filter: blur(2px);
}
@media (max-width: 1024px) {
    .sidebar-overlay.show { display: block; }
    .page-header, .page-content, .topbar { padding-left: 20px; padding-right: 20px; }
}

/* Animations */
@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
.fade-in { animation: fadeIn 0.3s ease forwards; }

/* Tooltip */
[data-tip] { position: relative; }
[data-tip]:hover::after {
    content: attr(data-tip);
    position: absolute; bottom: calc(100% + 6px); left: 50%;
    transform: translateX(-50%); background: var(--surface2);
    color: var(--text); font-size: 11px; padding: 4px 9px;
    border-radius: 6px; white-space: nowrap; pointer-events: none;
    border: 1px solid var(--border2);
    z-index: 100;
}

/* Two-col form grid */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }

/* Sidebar brand pulse dot */
@keyframes pulse { 0%,100%{opacity:1}50%{opacity:0.4} }
.live-dot { animation: pulse 2s infinite; }
</style>
</head>

<body x-data="adminApp()" @keydown.escape="sidebarOpen = false">

{{-- Overlay --}}
<div class="sidebar-overlay" :class="sidebarOpen ? 'show' : ''" @click="sidebarOpen = false"></div>

{{-- ══ SIDEBAR ══════════════════════════════════════════════════════ --}}
<aside class="admin-sidebar" :class="sidebarOpen ? 'open' : ''">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b" style="border-color:var(--border)">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#8b5cf6)">
            <svg width="16" height="16" viewBox="0 0 32 32" fill="none">
                <path d="M6 4L26 4L26 14L14 14L14 18L26 18L26 28L6 28L6 20L16 20L16 16L6 16Z" fill="white" opacity=".9"/>
            </svg>
        </div>
        <div>
            <div class="font-display text-sm font-700 tracking-widest text-slate-100">JILJAM</div>
            <div class="text-[10px] flex items-center gap-1.5" style="color:var(--muted)">
                <span class="live-dot w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                Admin Panel
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-3">

        <div class="nav-group-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="nav-group-label">Content</div>
        <a href="{{ route('admin.content.hero') }}" class="nav-item {{ request()->routeIs('admin.content.hero*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Hero Section
        </a>
        <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Services
        </a>
        <a href="{{ route('admin.technologies.index') }}" class="nav-item {{ request()->routeIs('admin.technologies*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="4.93" y1="4.93" x2="9.17" y2="9.17"/><line x1="14.83" y1="14.83" x2="19.07" y2="19.07"/><line x1="14.83" y1="9.17" x2="19.07" y2="4.93"/><line x1="4.93" y1="19.07" x2="9.17" y2="14.83"/></svg>
            Technologies
        </a>
        <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            Projects
        </a>
        <a href="{{ route('admin.content.about') }}" class="nav-item {{ request()->routeIs('admin.content.about*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            About
        </a>
        <a href="{{ route('admin.content.contact') }}" class="nav-item {{ request()->routeIs('admin.content.contact*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Contact
        </a>

        <div class="nav-group-label">Site</div>
        <a href="{{ route('admin.content.navigation') }}" class="nav-item {{ request()->routeIs('admin.content.navigation*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            Navigation
        </a>
        <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
            Settings
        </a>

        <div class="nav-group-label mt-2">Quick Links</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Site
        </a>
    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t" style="border-color:var(--border)">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item w-full text-left" style="background:rgba(239,68,68,0.08);color:#fca5a5;margin:0">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ══ MAIN ══════════════════════════════════════════════════════════ --}}
<div class="admin-main">

    {{-- Topbar --}}
    <header class="topbar">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden btn btn-ghost btn-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="text-sm font-600" style="color:var(--muted)">
                <span style="color:var(--text)">@yield('title', 'Dashboard')</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-xs px-3 py-1.5 rounded-full" style="background:var(--surface2);color:var(--muted);border:1px solid var(--border)">
                {{ auth()->user()->name ?? 'Admin' }}
            </div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-ghost btn-sm">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                View Site
            </a>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="px-8 pt-5">
        <div class="alert alert-success fade-in">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if(session('error') || $errors->any())
    <div class="px-8 pt-5">
        <div class="alert alert-error fade-in">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') ?? 'Please fix the errors below.' }}
        </div>
    </div>
    @endif

    {{-- Page content --}}
    @yield('body')

</div>

<script>
function adminApp() {
    return {
        sidebarOpen: false,
    };
}

// CSRF for fetch
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Confirm delete helper
function confirmDelete(form) {
    if (confirm('Are you sure you want to delete this? This cannot be undone.')) {
        form.submit();
    }
}

// Drag & drop reorder
function initDragSort(containerId, endpoint) {
    const container = document.getElementById(containerId);
    if (!container) return;
    let dragEl = null;

    container.querySelectorAll('[draggable="true"]').forEach(row => {
        row.addEventListener('dragstart', e => {
            dragEl = row;
            row.style.opacity = '0.4';
            e.dataTransfer.effectAllowed = 'move';
        });
        row.addEventListener('dragend', () => {
            row.style.opacity = '1';
            const ids = [...container.querySelectorAll('[data-id]')].map(r => r.dataset.id);
            fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                body: JSON.stringify({ ids })
            });
        });
        row.addEventListener('dragover', e => {
            e.preventDefault();
            const rect = row.getBoundingClientRect();
            const mid = rect.top + rect.height / 2;
            if (e.clientY < mid) container.insertBefore(dragEl, row);
            else row.after(dragEl);
        });
    });
}
</script>

@stack('scripts')
</body>
</html>