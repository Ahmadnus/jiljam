<aside class="sidebar">
    <div class="brand">
        JILJAM
    </div>

    <nav class="nav flex-column">

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Settings</span>
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Services</span>
        </a>

        <a href="{{ route('admin.projects.index') }}"
           class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="bi bi-kanban"></i>
            <span>Projects</span>
        </a>

        <a href="{{ route('admin.technologies.index') }}"
           class="nav-link {{ request()->routeIs('admin.technologies.*') ? 'active' : '' }}">
            <i class="bi bi-cpu"></i>
            <span>Technologies</span>
        </a>

        <div class="pt-3 mt-3 border-top border-secondary-subtle">
            <div class="px-4 mb-2 text-xs uppercase tracking-widest text-slate-400">
                Content
            </div>

            <a href="{{ route('admin.content.navigation') }}"
               class="nav-link {{ request()->routeIs('admin.content.navigation*') ? 'active' : '' }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Navigation</span>
            </a>

            <a href="{{ route('admin.content.hero') }}"
               class="nav-link {{ request()->routeIs('admin.content.hero*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i>
                <span>Hero</span>
            </a>

            <a href="{{ route('admin.content.about') }}"
               class="nav-link {{ request()->routeIs('admin.content.about*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>About</span>
            </a>

            <a href="{{ route('admin.content.contact') }}"
               class="nav-link {{ request()->routeIs('admin.content.contact*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper"></i>
                <span>Contact</span>
            </a>
        </div>

    </nav>
</aside>