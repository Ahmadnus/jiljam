<!doctype html>
<html lang="en" dir="ltr" class="scroll-smooth"
      x-data="projectsPage()" x-init="init()"
      :class="{ 'dark': isDark, 'ar-mode': isAr }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['brand_name'] ?? '' }} — All Projects, filterable by category.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>Projects — {{ $settings['brand_name'] ?? '' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @php
        $fontsConfig = config('fonts');
        $arFontKey = $settings['font_arabic'] ?? $fontsConfig['default_arabic'];
        $enFontKey = $settings['font_english'] ?? $fontsConfig['default_english'];
        $arFont = $fontsConfig['arabic'][$arFontKey] ?? $fontsConfig['arabic'][$fontsConfig['default_arabic']];
        $enFont = $fontsConfig['english'][$enFontKey] ?? $fontsConfig['english'][$fontsConfig['default_english']];
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family={{ $arFont['google'] }}&family={{ $enFont['google'] }}&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { navy: { DEFAULT:'#24344c', light:'#2d4266', dark:'#1a2638' }, cream:'#FFFDF5' } } } };
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root{
            --font-arabic: '{{ $arFont['family'] }}', sans-serif;
            --font-english: '{{ $enFont['family'] }}', sans-serif;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:var(--font-english);min-height:100vh;transition:background-color 500ms ease,color 500ms ease}
        [x-cloak]{display:none!important}
        [dir="rtl"],[lang="ar"]{font-family:var(--font-arabic)}
        [dir="ltr"],[lang="en"]{font-family:var(--font-english)}
        .ar-mode body{font-family:var(--font-arabic)!important;direction:rtl}
        .ar-mode .font-display{font-family:var(--font-arabic)!important}
        .glass-nav-dark{background:rgba(15,23,42,.62);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.06)}
        .glass-nav-light{background:rgba(255,253,245,.88);backdrop-filter:blur(20px);border-bottom:1px solid rgba(36,52,76,.10)}
        .glass-dark{background:rgba(36,52,76,.28);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.07)}
        .glass-light{background:rgba(255,253,245,.68);backdrop-filter:blur(16px);border:1px solid rgba(36,52,76,.13)}
        .proj-card{border-radius:16px;overflow:hidden;transition:transform 320ms cubic-bezier(0.34,1.56,0.64,1),box-shadow 320ms ease}
        .proj-card:hover{transform:translateY(-8px) scale(1.01);box-shadow:0 30px 70px rgba(0,0,0,.2)}
        .cat-pill{transition:all .25s ease;cursor:pointer}
    </style>
</head>
<body :class="isDark ? 'bg-[#0f172a] text-slate-200' : 'bg-[#FFFDF5] text-[#24344c]'" class="antialiased">

{{-- ══ NAV ══ --}}
<nav class="fixed top-0 inset-x-0 z-50" :class="isDark ? 'glass-nav-dark' : 'glass-nav-light'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-14 sm:h-16 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
            @if(!empty($settings['brand_logo']))
                <img src="{{ asset('storage/'.$settings['brand_logo']) }}" alt="{{ $settings['brand_name'] ?? 'JILJAM' }}" class="h-8 w-auto">
            @else
                <span class="font-bold text-lg" :class="isDark?'text-slate-100':'text-[#24344c]'">{{ $settings['brand_name'] ?? 'JILJAM' }}</span>
            @endif
        </a>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('home') }}" class="text-xs font-semibold uppercase tracking-widest opacity-60 hover:opacity-100"
               :class="isDark?'text-slate-300':'text-[#24344c]'" x-text="isAr ? 'الرئيسية' : 'Home'"></a>

            <button @click="toggleLang()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-semibold tracking-wide"
                :class="isDark?'border-slate-600 text-slate-300':'border-[#24344c]/25 text-[#24344c]/65'">
                <span x-text="isAr?'English':'عربي'"></span>
            </button>

            <button @click="toggleTheme()"
                class="relative w-12 h-6 rounded-full border flex items-center px-0.5"
                :class="isDark?'bg-[#24344c]/70 border-[#24344c]/50 justify-end':'bg-[#24344c]/10 border-[#24344c]/30 justify-start'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs" :class="isDark?'bg-slate-200 text-[#24344c]':'bg-[#24344c] text-[#FFFDF5]'">
                    <span x-show="isDark">☽</span><span x-show="!isDark">☀</span>
                </span>
            </button>
        </div>
    </div>
</nav>

{{-- ══ HEADER ══ --}}
<section class="pt-28 sm:pt-36 pb-10 sm:pb-14 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="font-bold text-4xl sm:text-5xl md:text-6xl mb-4"
            :style="isAr?'font-family:var(--font-arabic)':'font-family:\'Syne\',sans-serif'"
            :class="isDark?'text-slate-50':'text-[#24344c]'"
            x-text="isAr ? 'جميع المشاريع' : 'All Projects'"></h1>
        <p class="opacity-55 max-w-xl mx-auto" x-text="isAr ? 'استعرض جميع أعمالنا، وقم بالتصفية حسب التصنيف.' : 'Browse our full portfolio and filter by category.'"></p>
    </div>
</section>

{{-- ══ CATEGORY FILTER ══ --}}
<section class="px-4 sm:px-6 mb-10">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-2 sm:gap-3">
        <button @click="activeCategory = null" class="cat-pill px-4 sm:px-5 py-2 rounded-full border text-xs sm:text-sm font-semibold"
                :class="activeCategory === null ? 'bg-[#24344c] text-[#FFFDF5] border-[#24344c]' : (isDark ? 'border-slate-600 text-slate-300' : 'border-[#24344c]/25 text-[#24344c]/70')"
                x-text="isAr ? 'الكل' : 'All'"></button>

        <template x-for="cat in categories" :key="cat.id">
            <button @click="activeCategory = cat.id" class="cat-pill px-4 sm:px-5 py-2 rounded-full border text-xs sm:text-sm font-semibold"
                    :class="activeCategory === cat.id ? 'bg-[#24344c] text-[#FFFDF5] border-[#24344c]' : (isDark ? 'border-slate-600 text-slate-300' : 'border-[#24344c]/25 text-[#24344c]/70')"
                    x-text="isAr ? cat.name_ar : cat.name_en"></button>
        </template>
    </div>
</section>

{{-- ══ PROJECTS GRID ══ --}}
<section class="px-4 sm:px-6 pb-24">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6" x-show="filteredProjects.length">
            <template x-for="p in filteredProjects" :key="p.id">
                <article class="proj-card" :class="isDark?'glass-dark':'glass-light'">
                    <div class="aspect-video flex items-center justify-center relative overflow-hidden" :style="'background:'+p.bg">
                        <template x-if="p.image">
                            <img :src="p.image" :alt="p.title_en" class="absolute inset-0 w-full h-full object-cover opacity-70">
                        </template>
                        <span class="font-extrabold text-2xl tracking-wider text-white/80 relative z-10" style="font-family:'Syne',sans-serif" x-text="p.abbr"></span>
                    </div>
                    <div class="p-5 sm:p-6">
                        <h3 class="font-bold text-base sm:text-lg mb-2" :class="isDark?'text-slate-100':'text-[#24344c]'"
                            x-text="isAr ? p.title_ar : p.title_en"></h3>
                        <p class="text-sm opacity-55 mb-4 leading-relaxed line-clamp-2" x-text="isAr ? p.desc_ar : p.desc_en"></p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <template x-for="tag in (p.stack || [])" :key="tag">
                                <span class="text-xs px-2.5 py-1 rounded-full border font-medium opacity-75"
                                      :class="isDark?'border-slate-600 text-slate-300':'border-[#24344c]/20 text-[#24344c]'" x-text="tag"></span>
                            </template>
                        </div>
                        <div class="flex gap-4">
                            <a :href="p.live_url || '#'" class="text-xs font-semibold uppercase tracking-wide opacity-55 hover:opacity-100">Live</a>
                            <a :href="p.code_url || '#'" class="text-xs font-semibold uppercase tracking-wide opacity-55 hover:opacity-100">Code</a>
                        </div>
                    </div>
                </article>
            </template>
        </div>

        <div x-show="!filteredProjects.length" class="text-center py-24 opacity-50" x-text="isAr ? 'لا توجد مشاريع في هذا التصنيف.' : 'No projects in this category yet.'"></div>
    </div>
</section>

<script>
    window._projectsData = @js(['projects' => $projectsJs, 'categories' => $categoriesJs]);

    function projectsPage() {
        return {
            isDark: true,
            isAr: false,
            activeCategory: null,
            projects: [],
            categories: [],

            get filteredProjects() {
                if (this.activeCategory === null) return this.projects;
                return this.projects.filter(p => p.category_id === this.activeCategory);
            },

            init() {
                this.projects = window._projectsData.projects || [];
                this.categories = window._projectsData.categories || [];

                const savedTheme = localStorage.getItem('jiljam_theme');
                const savedLang  = localStorage.getItem('jiljam_lang');
                this.isDark = savedTheme !== null ? savedTheme === 'dark' : true;
                this.isAr   = savedLang !== null ? savedLang === 'ar' : false;
                this.applyLocale();
            },

            toggleLang() {
                this.isAr = !this.isAr;
                localStorage.setItem('jiljam_lang', this.isAr ? 'ar' : 'en');
                this.applyLocale();
            },

            applyLocale() {
                const h = document.documentElement;
                h.setAttribute('lang', this.isAr ? 'ar' : 'en');
                h.setAttribute('dir', this.isAr ? 'rtl' : 'ltr');
            },

            toggleTheme() {
                this.isDark = !this.isDark;
                localStorage.setItem('jiljam_theme', this.isDark ? 'dark' : 'light');
            },
        };
    }
</script>
</body>
</html>
