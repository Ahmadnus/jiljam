<header class="bg-white border-b border-slate-200 px-4 md:px-6 py-4 flex items-center justify-between">
    <div>
        <h1 class="text-lg md:text-xl font-semibold">@yield('page-title', 'Dashboard')</h1>
        <p class="text-sm text-slate-500">@yield('page-subtitle', 'Manage website content and settings')</p>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-700">
            View Site
        </a>
    </div>
</header>