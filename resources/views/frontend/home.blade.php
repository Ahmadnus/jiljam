@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
{{-- ══ NAV ══════════════════════════════════════════════════════════════ --}}
<nav class="fixed top-0 inset-x-0 z-50"
     :class="isDark ? 'glass-nav-dark' : 'glass-nav-light'"
     role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-14 sm:h-16 flex items-center justify-between gap-3">

        <a href="#" class="flex items-center gap-2 flex-shrink-0" aria-label="Home">
            @if(!empty($settings['brand_logo']))
                <img src="{{ asset('storage/'.$settings['brand_logo']) }}" alt="{{ $settings['brand_name'] ?? 'JILJAM' }}" class="h-8 w-auto">
            @else
            <svg width="26" height="26" viewBox="0 0 32 32" fill="none">
                <path d="M6 4L26 4L26 14L14 14L14 18L26 18L26 28L6 28L6 20L16 20L16 16L6 16Z" :fill="isDark?'#94a3b8':'#24344c'" opacity=".9"/>
                <path d="M8 6L24 6L24 12L12 12L12 20L8 20Z" fill="url(#ngrd)" opacity=".75"/>
                <defs><linearGradient id="ngrd" x1="8" y1="6" x2="24" y2="20"><stop offset="0%" stop-color="#3a6fa8"/><stop offset="100%" stop-color="#24344c"/></linearGradient></defs>
            </svg>
            @endif
         
        </a>

        <div class="hidden md:flex items-center gap-5 lg:gap-8 text-xs font-medium tracking-widest uppercase">
            <template x-for="link in d.navLinks" :key="link.href">
                <a :href="link.href" :class="isDark?'text-slate-400 hover:text-slate-100':'text-[#24344c]/60 hover:text-[#24344c]'" class="transition-colors" x-text="isAr ? link.label_ar : link.label_en"></a>
            </template>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <button @click="toggleLang()" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-semibold tracking-wide transition-all hover:-translate-y-px"
                :class="isDark?'border-slate-600 text-slate-300 hover:border-slate-400':'border-[#24344c]/25 text-[#24344c]/65 hover:border-[#24344c]/50'" aria-label="Switch language">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
                <span x-text="isAr?'English':'عربي'"></span>
            </button>

            <button @click="toggleTheme()"
                class="relative w-12 sm:w-14 h-6 sm:h-7 rounded-full border flex items-center px-0.5 sm:px-1 focus:outline-none transition-all duration-500"
                :class="isDark?'bg-[#24344c]/70 border-[#24344c]/50 justify-end':'bg-[#24344c]/10 border-[#24344c]/30 justify-start'" aria-label="Toggle theme">
                <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center text-xs transition-all duration-500" :class="isDark?'bg-slate-200 text-[#24344c]':'bg-[#24344c] text-[#FFFDF5]'">
                    <span x-show="isDark">☽</span><span x-show="!isDark">☀</span>
                </span>
            </button>

            <button @click="menuOpen=!menuOpen" class="md:hidden p-1.5" aria-label="Menu" :aria-expanded="menuOpen">
                <svg x-show="!menuOpen" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
                <svg x-show="menuOpen"  width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round"/></svg>
            </button>
        </div>
    </div>

    <div x-show="menuOpen"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden border-t px-4 py-4 space-y-3" :class="isDark?'border-slate-800/60 bg-[#0f172a]/96':'border-[#24344c]/10 bg-[#FFFDF5]/96'">
        <template x-for="link in d.navLinks" :key="link.href">
            <a :href="link.href" @click="menuOpen=false" :class="isDark?'text-slate-300':'text-[#24344c]/70'" class="block text-sm font-medium uppercase tracking-widest py-1" x-text="isAr ? link.label_ar : link.label_en"></a>
        </template>
        <button @click="toggleLang()" class="text-sm font-semibold flex items-center gap-2 pt-1" :class="isDark?'text-blue-400':'text-blue-600'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
            <span x-text="isAr?'English':'عربي'"></span>
        </button>
    </div>
</nav>

{{-- ══ HERO ══════════════════════════════════════════════════════════════ --}}
<section class="min-h-screen flex items-center justify-center px-4 sm:px-6 pt-20 pb-12 relative z-10" aria-label="Hero">
    <div class="max-w-5xl w-full text-center">
        <div data-aos="fade-down" data-aos-delay="100"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-full border mb-8 text-[10px] sm:text-xs uppercase tracking-widest font-medium"
             :class="isDark?'border-slate-700 text-slate-400':'border-[#24344c]/25 text-[#24344c]/60'">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 pulse-dot flex-shrink-0"></span>
            <span x-text="isAr ? d.hero.badge_ar : d.hero.badge_en"></span>
        </div>

        <h1 data-aos="fade-up" data-aos-delay="200"
            class="font-bold leading-[0.9] tracking-[-0.025em] mb-6 sm:mb-8 float-anim"
            :style="isAr ? 'font-family:\'Cairo\',sans-serif; font-size:clamp(2.2rem,8vw,5.8rem)' : 'font-family:\'Syne\',sans-serif; font-size:clamp(2.6rem,9vw,6.2rem)'"
            :class="isDark?'text-slate-50':'text-[#24344c]'">
            <span x-text="isAr ? d.hero.line1_ar : d.hero.line1_en"></span><br>
            <span class="font-light italic" :class="isDark?'text-slate-400':'text-[#24344c]/55'" x-text="isAr ? d.hero.line2_ar : d.hero.line2_en"></span><br>
            <span class="gradient-text" x-text="isAr ? d.hero.line3_ar : d.hero.line3_en"></span>
        </h1>

        <p data-aos="fade-up" data-aos-delay="350"
           class="max-w-sm sm:max-w-xl mx-auto text-base sm:text-lg opacity-55 mb-10 sm:mb-12 leading-relaxed"
           x-text="isAr ? d.hero.desc_ar : d.hero.desc_en"></p>

        <div data-aos="fade-up" data-aos-delay="500" class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 sm:gap-4">
            <a href="#projects"
               class="w-full sm:w-auto px-7 sm:px-8 py-3.5 rounded-full bg-[#24344c] text-[#FFFDF5] font-semibold text-sm tracking-wide hover:bg-[#2d4266] hover:-translate-y-0.5 transition-all shadow-lg shadow-[#24344c]/30 text-center"
               x-text="isAr ? d.hero.cta1_ar : d.hero.cta1_en"></a>
            <a href="#contact"
               class="w-full sm:w-auto px-7 sm:px-8 py-3.5 rounded-full border font-semibold text-sm tracking-wide hover:-translate-y-0.5 transition-all text-center"
               :class="isDark?'border-slate-600 text-slate-300 hover:border-slate-400':'border-[#24344c]/35 text-[#24344c]'"
               x-text="isAr ? d.hero.cta2_ar : d.hero.cta2_en"></a>
        </div>

        <div data-aos="fade-in" data-aos-delay="900" class="mt-16 sm:mt-20 flex justify-center opacity-20">
            <div class="flex flex-col items-center gap-2 text-xs uppercase tracking-widest">
                <div class="w-px h-10 sm:h-12 bg-current animate-pulse"></div>
                <span x-text="isAr ? d.hero.scroll_ar : d.hero.scroll_en"></span>
            </div>
        </div>
    </div>
</section>

{{-- ══ SERVICES ══════════════════════════════════════════════════════════ --}}
<section id="services" class="py-20 sm:py-28 px-4 sm:px-6 relative z-10" aria-labelledby="svc-heading">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 sm:mb-16">
            <div>
                <div data-aos="fade-right" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs uppercase tracking-widest font-medium mb-3 sm:mb-4"
                     :class="isDark?'border-slate-700 text-slate-400':'border-[#24344c]/20 text-[#24344c]/55'">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#3b82f6"></span>
                    <span x-text="isAr ? (d.svcSection?.badge_ar || '') : (d.svcSection?.badge_en || '')"></span>
                </div>
                <h2 id="svc-heading" data-aos="fade-right" data-aos-delay="80"
                    class="font-bold text-4xl sm:text-5xl md:text-6xl leading-tight"
                    :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                    :class="isDark?'text-slate-50':'text-[#24344c]'"
                    x-text="isAr ? (d.svcSection?.heading_ar || '') : (d.svcSection?.heading_en || '')"></h2>
                <div class="section-divider mt-3 sm:mt-4" data-aos="fade-right" data-aos-delay="140"></div>
            </div>
            <p data-aos="fade-left" data-aos-delay="120"
               class="max-w-xs text-sm leading-relaxed opacity-45 pb-1"
               :class="isAr?'md:text-left':'md:text-right'"
               x-text="isAr ? (d.svcSection?.sub_ar || '') : (d.svcSection?.sub_en || '')"></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-7">
            <template x-for="(svc, i) in (d.services || [])" :key="svc.id || i">
                <article class="svc-card" :class="isDark?'glass-dark':'glass-light'" data-aos="fade-up" :data-aos-delay="(i%3)*80">
                    <div class="svc-orb w-40 h-40 sm:w-52 sm:h-52" :style="'background:'+(svc.color || '#3b82f6')+';top:-56px;'+(isAr?'right:-40px':'left:-40px')"></div>
                    
                    <span class="svc-num" x-text="svc.num || ''"></span>
                    
                    {{-- صندوق الأيقونة الصافي والمحمي تماماً للـ Frontend --}}
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center mb-4 sm:mb-5 relative z-10" 
                         :style="'background:'+(svc.color || '#3b82f6')+'22'">
                        
                        <div class="w-full h-full flex items-center justify-center"
                             :style="'color:' + (svc.color || '#3b82f6')"
                             x-html="(() => {
                                // تعديل الحقل ليتوافق مع السيرفر: الاستدعاء بـ iconPath
                                let rawIcon = svc.iconPath || svc.icon_path || '';
                                if (!rawIcon) return '';
                                
                                // إذا كان يحتوي على وسم SVG كامل
                                if (rawIcon.includes('<svg')) {
                                    return rawIcon;
                                }
                                
                                // إذا كان عبارة عن مسارات فقط (Paths)
                                return `<svg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' class='w-5 h-5 sm:w-6 sm:h-6'>${rawIcon}</svg>`;
                             })()">
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <h3 class="font-bold text-base sm:text-lg mb-2 sm:mb-2.5"
                            :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                            :class="isDark?'text-slate-100':'text-[#24344c]'"
                            x-text="isAr ? (svc.title_ar || '') : (svc.title_en || '')"></h3>
                        <p class="text-sm leading-relaxed opacity-55" x-text="isAr ? (svc.desc_ar || '') : (svc.desc_en || '')"></p>
                    </div>
                </article>
            </template>
        </div>
    </div>
</section>
<section id="technologies" class="py-20 sm:py-28 px-4 sm:px-6 relative overflow-hidden flex flex-col items-center justify-center" aria-labelledby="tech-heading">
    <div class="absolute inset-0 pointer-events-none -z-10">
        <div class="absolute rounded-full" style="width:min(400px,80vw);height:min(400px,80vw);top:-60px;left:calc(50% - 200px);filter:blur(90px);background:radial-gradient(circle,#3b82f6,transparent 70%)" :style="isDark?'opacity:.06':'opacity:.03'"></div>
        <div class="absolute rounded-full" style="width:min(350px,70vw);height:min(350px,70vw);bottom:-60px;right:10%;filter:blur(90px);background:radial-gradient(circle,#8b5cf6,transparent 70%)" :style="isDark?'opacity:.05':'opacity:.025'"></div>
    </div>

    <div class="max-w-7xl w-full mx-auto relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-16 sm:mb-24">
            <div>
                <div data-aos="fade-right" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs uppercase tracking-widest font-medium mb-4"
                     :class="isDark?'border-slate-700 text-slate-400':'border-[#24344c]/20 text-[#24344c]/55'">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#06b6d4"></span>
                    <span x-text="isAr ? (d.techSection?.badge_ar || '') : (d.techSection?.badge_en || '')"></span>
                </div>
                <h2 id="tech-heading" data-aos="fade-right" data-aos-delay="80"
                    class="font-bold text-4xl sm:text-5xl md:text-6xl leading-tight"
                    :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                    :class="isDark?'text-slate-50':'text-[#24344c]'"
                    x-text="isAr ? (d.techSection?.heading_ar || '') : (d.techSection?.heading_en || '')"></h2>
                <div class="section-divider mt-4" data-aos="fade-right" data-aos-delay="140" style="background:linear-gradient(to right,#06b6d4,transparent)"></div>
            </div>
            <p data-aos="fade-left" data-aos-delay="120"
               class="max-w-xs text-sm leading-relaxed opacity-45 pb-1"
               :class="isAr?'md:text-left':'md:text-right'"
               x-text="isAr ? (d.techSection?.sub_ar || '') : (d.techSection?.sub_en || '')"></p>
        </div>

        <div data-aos="zoom-in" data-aos-delay="200" class="relative flex items-center justify-center py-12 sm:py-20">
            <div class="orbit-arena shrink-0" id="orbitArena">
                <div class="o-glow" style="width:200px;height:200px;animation-delay:0s"></div>
                <div class="o-glow" style="width:300px;height:300px;animation-delay:2s;opacity:.03"></div>

                {{-- الحلقات المدارية الديناميكية الموزعة هندسياً --}}
                <template x-for="(ring, ri) in (d.techRings || [])" :key="ring.id || ri">
                    <div class="o-ring"
                         :style="'--ring-d: calc(' + (ring.radius || 100) + 'px * var(--scale, 1)); --ring-anim: ring-spin-' + (ring.direction || 'cw') + '; --ring-dur: ' + (ring.duration || 20) + 's; border-color: ' + (ring.color || '#3b82f6') + ';'">
                        
                        <template x-for="(node, idx) in (ring.nodes || [])" :key="node.name || idx">
                            <div class="o-node-wrap"
                                 :style="'transform: rotate(' + (idx * (360 / (ring.nodes.length || 1))) + 'deg) translateX(calc(var(--ring-d) / 2))'">
                                
                                <div class="o-node-inner"
                                     :style="'animation-name: node-spin-' + (ring.direction === 'cw' ? 'ccw' : 'cw') + '; animation-duration: ' + (ring.duration || 20) + 's;'">
                                    
                                    <div class="o-icon" :class="isDark ? 'o-icon-dark' : 'o-icon-light'" :style="'width: var(--icon-sz, 44px); height: var(--icon-sz, 44px); font-size: var(--icon-fs, 16px);'">
                                        <template x-if="node.icon_type === 'image' && node.icon_image">
                                            <img :src="node.icon_image" :alt="node.name || ''" style="width:100%;height:100%;object-fit:contain;border-radius:8px">
                                        </template>
                                        <template x-if="!(node.icon_type === 'image' && node.icon_image)">
                                            <span x-text="node.icon || ''"></span>
                                        </template>
                                    </div>
                                    <span class="o-label mt-1" :class="isDark ? 'o-label-dark' : 'o-label-light'" x-text="node.name || ''"></span>
                                </div>

                            </div>
                        </template>

                    </div>
                </template>

                {{-- مركز المدار (Hub) --}}
                <div class="orbit-hub shadow-2xl" :class="isDark?'orbit-hub-dark':'orbit-hub-light'"
                     :style="'width: ' + (d.orbitCenter?.size || 88) + 'px; height: ' + (d.orbitCenter?.size || 88) + 'px;'">
                    
                    <template x-if="d.orbitCenter?.logo">
                        <img :src="d.orbitCenter.logo" alt="Center Logo" :style="'width: ' + ((d.orbitCenter?.size || 88) * 0.6) + 'px; height: ' + ((d.orbitCenter?.size || 88) * 0.6) + 'px; object-fit: contain;'">
                    </template>
                    
                    <template x-if="!d.orbitCenter?.logo && d.orbitCenter?.text">
                        <span class="font-bold text-sm gradient-text" x-text="d.orbitCenter.text"></span>
                    </template>
                    
                    <template x-if="!d.orbitCenter?.logo && !d.orbitCenter?.text">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 animate-pulse">
                            <polyline points="16 18 22 12 16 6"></polyline>
                            <polyline points="8 6 2 12 8 18"></polyline>
                        </svg>
                    </template>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ══ PROJECTS ══════════════════════════════════════════════════════════ --}}
<section id="projects" class="py-20 sm:py-28 px-4 sm:px-6 relative z-10" aria-labelledby="proj-heading">
    <div class="max-w-7xl mx-auto">
        <div data-aos="fade-up" class="mb-12 sm:mb-16 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-widest opacity-45 mb-2 font-medium"
                   x-text="isAr ? d.projSection.badge_ar : d.projSection.badge_en"></p>
                <h2 id="proj-heading" class="font-bold text-4xl sm:text-5xl"
                    :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                    :class="isDark?'text-slate-50':'text-[#24344c]'"
                    x-text="isAr ? d.projSection.heading_ar : d.projSection.heading_en"></h2>
                <div class="section-divider mt-3 sm:mt-4"></div>
            </div>
            <div class="h-px flex-1 mx-8 mb-3 hidden md:block" :class="isDark?'bg-slate-700/50':'bg-[#24344c]/12'"></div>
            <p class="text-sm opacity-40 max-w-xs" x-text="isAr ? d.projSection.sub_ar : d.projSection.sub_en"></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            <template x-for="(p,i) in d.projects" :key="i">
                <article class="proj-card" :class="isDark?'glass-dark':'glass-light'" data-aos="fade-up" :data-aos-delay="(i%3)*100">
                    <div class="aspect-video flex items-center justify-center relative overflow-hidden" :style="'background:'+p.bg">
                        <div class="absolute inset-0 opacity-10" style="background-image:linear-gradient(rgba(255,255,255,.15)1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.15)1px,transparent 1px);background-size:30px 30px"></div>
                        <template x-if="p.image">
                            <img :src="p.image" :alt="p.title_en" class="absolute inset-0 w-full h-full object-cover opacity-60">
                        </template>
                        <span class="font-extrabold text-2xl tracking-wider text-white/80 relative z-10" style="font-family:'Syne',sans-serif" x-text="p.abbr"></span>
                    </div>
                    <div class="p-5 sm:p-6">
                        <h3 class="font-bold text-base sm:text-lg mb-2"
                            :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                            :class="isDark?'text-slate-100':'text-[#24344c]'"
                            x-text="isAr ? p.title_ar : p.title_en"></h3>
                        <p class="text-sm opacity-55 mb-4 leading-relaxed line-clamp-2" x-text="isAr ? p.desc_ar : p.desc_en"></p>
                        <div class="flex flex-wrap gap-1.5 mb-4 sm:mb-5">
                            <template x-for="tag in p.stack" :key="tag">
                                <span class="text-xs px-2.5 py-1 rounded-full border font-medium opacity-75"
                                      :class="isDark?'border-slate-600 text-slate-300':'border-[#24344c]/20 text-[#24344c]'" x-text="tag"></span>
                            </template>
                        </div>
                        <div class="flex gap-4 sm:gap-5">
                            <a :href="p.live_url || '#'" class="text-xs font-semibold uppercase tracking-wide opacity-55 hover:opacity-100 flex items-center gap-1.5 transition-opacity">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="2" stroke-linecap="round"/></svg>
                                <span>Live</span>
                            </a>
                            <a :href="p.code_url || '#'" class="text-xs font-semibold uppercase tracking-wide opacity-55 hover:opacity-100 flex items-center gap-1.5 transition-opacity">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2A10 10 0 002 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0012 2z"/></svg>
                                <span>Code</span>
                            </a>
                        </div>
                    </div>
                </article>
            </template>
        </div>
    </div>
</section>

{{-- ══ ABOUT ══════════════════════════════════════════════════════════════ --}}
<section id="about" class="py-20 sm:py-28 px-4 sm:px-6 relative z-10" aria-labelledby="about-heading">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 sm:gap-16 items-center">
            <div>
                <div data-aos="fade-right" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs uppercase tracking-widest font-medium mb-3 sm:mb-4"
                     :class="isDark?'border-slate-700 text-slate-400':'border-[#24344c]/20 text-[#24344c]/55'">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                    <span x-text="isAr ? d.about.badge_ar : d.about.badge_en"></span>
                </div>
                <h2 id="about-heading" data-aos="fade-right" data-aos-delay="80"
                    class="font-bold text-3xl sm:text-4xl md:text-5xl mb-3 sm:mb-4 leading-tight"
                    :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
                    :class="isDark?'text-slate-50':'text-[#24344c]'"
                    x-text="isAr ? d.about.heading_ar : d.about.heading_en"></h2>
                <div class="section-divider mb-5 sm:mb-6" data-aos="fade-right" data-aos-delay="120" style="background:linear-gradient(to right,#10b981,transparent)"></div>
                <p data-aos="fade-right" data-aos-delay="160" class="opacity-55 leading-relaxed mb-8 sm:mb-10 text-base"
                   x-text="isAr ? d.about.desc_ar : d.about.desc_en"></p>
                <div data-aos="fade-right" data-aos-delay="240" class="grid grid-cols-2 gap-3 sm:gap-4">
                    <template x-for="stat in d.about.stats" :key="stat.num">
                        <div class="rounded-2xl p-4 sm:p-5 hover:-translate-y-1 transition-transform duration-300" :class="isDark?'glass-dark':'glass-light'">
                            <p class="font-extrabold text-2xl sm:text-3xl mb-1 gradient-text"
                               :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'" x-text="stat.num"></p>
                            <p class="text-xs opacity-45 uppercase tracking-wide leading-snug"
                               x-text="isAr ? stat.label_ar : stat.label_en"></p>
                        </div>
                    </template>
                </div>
            </div>

            <div data-aos="fade-left" data-aos-delay="100" class="rounded-3xl p-6 sm:p-8 space-y-5 sm:space-y-6" :class="isDark?'glass-dark':'glass-light'">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center flex-shrink-0" :class="isDark?'bg-blue-500/20':'bg-blue-50'">
                        <svg width="14" height="14" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24" class="sm:w-4 sm:h-4">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-sm opacity-70"
                          x-text="isAr ? d.about.skills_title_ar : d.about.skills_title_en"></span>
                </div>
                <template x-for="skill in d.about.skills" :key="skill.name_en">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-sm" x-text="isAr ? skill.name_ar : skill.name_en"></span>
                            <span class="opacity-35 text-xs font-mono" x-text="skill.pct+'%'"></span>
                        </div>
                        <div class="h-1.5 rounded-full overflow-hidden" :class="isDark?'bg-slate-700/60':'bg-[#24344c]/10'"
                             :aria-valuenow="skill.pct" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="skill-bar" :data-pct="skill.pct" style="width:0%"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ══ CONTACT ══════════════════════════════════════════════════════════ --}}
<section id="contact" class="py-20 sm:py-28 px-4 sm:px-6 relative z-10" aria-labelledby="contact-heading">
    <div class="max-w-2xl mx-auto text-center">
        <div data-aos="fade-up" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs uppercase tracking-widest font-medium mb-3 sm:mb-4"
             :class="isDark?'border-slate-700 text-slate-400':'border-[#24344c]/20 text-[#24344c]/55'">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 pulse-dot flex-shrink-0"></span>
            <span x-text="isAr ? (d.contact?.badge_ar || '') : (d.contact?.badge_en || '')"></span>
        </div>
        <h2 id="contact-heading" data-aos="fade-up" data-aos-delay="80"
            class="font-bold text-3xl sm:text-4xl md:text-5xl mb-4 sm:mb-5 leading-tight"
            :style="isAr?'font-family:\'Cairo\',sans-serif':'font-family:\'Syne\',sans-serif'"
            :class="isDark?'text-slate-50':'text-[#24344c]'"
            x-text="isAr ? (d.contact?.heading_ar || '') : (d.contact?.heading_en || '')"></h2>
        <div class="flex justify-center mb-6 sm:mb-8" data-aos="fade-up" data-aos-delay="120"><div class="section-divider"></div></div>
        <p data-aos="fade-up" data-aos-delay="160" class="opacity-55 mb-10 sm:mb-12 text-base leading-relaxed"
           x-text="isAr ? (d.contact?.desc_ar || '') : (d.contact?.desc_en || '')"></p>

        <div data-aos="fade-up" data-aos-delay="240" class="rounded-3xl p-5 sm:p-10 space-y-2 sm:space-y-4"
             :class="[isDark?'glass-dark':'glass-light', isAr?'text-right':'text-left']">
            
           <template x-for="(item, index) in (d.contact?.items || [])" :key="item.id || index">
    <div>
        <div class="contact-item flex items-center gap-3 sm:gap-5 p-3 sm:p-4"
             :class="[isDark?'hover:bg-white/5':'hover:bg-[#24344c]/4', isAr?'flex-row-reverse':'']">

            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 :style="'background:' + (item.color || '#3b82f6') + '22'">
                <i :class="item.icon || 'fa-solid fa-circle-question'"
                   class="text-sm sm:text-base"
                   :style="'color:' + (item.color || '#3b82f6')"></i>
            </div>

            <div>
                <p class="text-xs uppercase tracking-widest opacity-35 mb-0.5"
                   x-text="isAr ? (item.label_ar || '') : (item.label_en || '')"></p>
                <p class="font-medium text-sm sm:text-base" :class="isDark?'text-slate-100':'text-[#24344c]'"
                   x-text="isAr ? (item.value_ar || '') : (item.value_en || '')"></p>
            </div>
        </div>
    </div>
</template>
        </div>

        
    </div>
</section>

{{-- ══ FOOTER ══════════════════════════════════════════════════════════ --}}
{{-- ══ FOOTER ══════════════════════════════════════════════════════════ --}}
{{-- ══ FOOTER ══════════════════════════════════════════════════════════ --}}
<footer class="relative z-10 border-t py-10 sm:py-14 px-4 sm:px-6" :class="isDark ? 'border-slate-800/60' : 'border-[#24344c]/10'">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8"
     :class="isAr ? 'md:flex-row-reverse' : ''">

    {{-- LOGO --}}
    <a href="#" class="flex items-center gap-2 flex-shrink-0" aria-label="Home">
        @if(!empty($settings['brand_logo']))
            <img src="{{ asset('storage/'.$settings['brand_logo']) }}"
                 alt="{{ $settings['brand_name'] ?? 'JILJAM' }}"
                 class="h-8 w-auto">
        @else
            <svg width="26" height="26" viewBox="0 0 32 32" fill="none">
                <path d="M6 4L26 4L26 14L14 14L14 18L26 18L26 28L6 28L6 20L16 20L16 16L6 16Z"
                      :fill="isDark?'#94a3b8':'#24344c'" opacity=".9"/>
                <path d="M8 6L24 6L24 12L12 12L12 20L8 20Z"
                      fill="url(#footerNgrd)" opacity=".75"/>
                <defs>
                    <linearGradient id="footerNgrd" x1="8" y1="6" x2="24" y2="20">
                        <stop offset="0%" stop-color="#3a6fa8"/>
                        <stop offset="100%" stop-color="#24344c"/>
                    </linearGradient>
                </defs>
            </svg>
        @endif
    </a>

    {{-- SOCIALS --}}
    <div class="flex items-center gap-2 sm:gap-3">
        <template x-for="(s, index) in (d.footer?.socials || [])" :key="s.id || index">
            <a :href="s.href || '#'"
               target="_blank"
               rel="noopener noreferrer"
               class="footer-link w-10 h-10 sm:w-11 sm:h-11 rounded-xl flex items-center justify-center border transition-all duration-300 hover:-translate-y-0.5"
               :class="isDark
                    ? 'border-slate-700 text-slate-400 hover:border-slate-500 hover:text-slate-200 hover:bg-white/5'
                    : 'border-[#24344c]/15 text-[#24344c]/55 hover:border-[#24344c]/35 hover:text-[#24344c] hover:bg-[#24344c]/5'"
               :aria-label="s.label || s.platform_key">

                <i :class="s.icon || 'fa-solid fa-link'"
                   class="text-[15px] sm:text-[16px] leading-none"></i>
            </a>
        </template>
    </div>

</div>
        
        <div class="h-px mb-6 sm:mb-8" :class="isDark ? 'bg-slate-800/60' : 'bg-[#24344c]/8'"></div>
        
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3" :class="isAr ? 'sm:flex-row-reverse' : ''">
            <p class="text-xs opacity-30" x-text="isAr ? (d.footer?.rights_ar || '') : (d.footer?.rights_en || '')"></p>
            <div class="flex items-center gap-2 text-xs opacity-25">
                <span x-text="isAr ? (d.footer?.craft_ar || '') : (d.footer?.craft_en || '')"></span>
                <svg width="12" height="12" fill="#ef4444" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                <span x-text="isAr ? (d.footer?.city_ar || '') : (d.footer?.city_en || '')"></span>
            </div>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script>
function jiljamApp() {
    return {
        isDark: true,
        isAr: false,
        menuOpen: false,
        d: {},

        init() {
            this.d = {
                brandName   : _phpData.brandName,
                navLinks    : _phpData.navLinks,
                hero        : _phpData.hero,
                services    : _phpData.services,
                svcSection  : { badge_en: '{{ $settings["svc_badge_en"] ?? "What We Do" }}', badge_ar: '{{ $settings["svc_badge_ar"] ?? "ما نقدمه" }}', heading_en: '{{ $settings["svc_heading_en"] ?? "Our Services" }}', heading_ar: '{{ $settings["svc_heading_ar"] ?? "خدماتنا" }}', sub_en: '{{ $settings["svc_sub_en"] ?? "" }}', sub_ar: '{{ $settings["svc_sub_ar"] ?? "" }}' },
                techRings   : _phpData.techRings,
                techSection : _phpData.techSection,
                projects    : _phpData.projects,
                projSection : _phpData.projSection,
                about       : _phpData.about,
                contact     : _phpData.contact,
                footer      : _phpData.footer,
                orbitCenter : _phpData.orbitCenter,
            };

            const savedTheme = localStorage.getItem('jiljam_theme');
            const savedLang  = localStorage.getItem('jiljam_lang');
            this.isDark = savedTheme !== null ? savedTheme === 'dark' : (_phpData.defaultTheme === 'dark');
            this.isAr   = savedLang !== null ? savedLang === 'ar' : (_phpData.defaultLang === 'ar');

            document.documentElement.classList.toggle('dark', this.isDark);
            this.applyLocale();

            this.$nextTick(() => {
                this.initParticles();
                AOS.init({ once:true, duration:900, offset:60, easing:'ease-out-cubic' });
                this.setupServiceCards();
                this.setupSkillBars();
                this.setupTilt();
            });
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
            h.classList.toggle('ar-mode', this.isAr);
        },

        toggleTheme() {
            this.isDark = !this.isDark;
            document.documentElement.classList.toggle('dark', this.isDark);
            localStorage.setItem('jiljam_theme', this.isDark ? 'dark' : 'light');
            this.$nextTick(() => this.reloadParticles());
        },

        particlesConfig(dark) {
            const lc = dark ? '#24344c' : '#8a9db5';
            const dc = dark ? '#2d4a72' : '#24344c';
            return {
                background:{ color:{ value:'transparent' } },
                fpsLimit: 60,
                interactivity:{ events:{ onHover:{ enable:true, mode:'grab' }, resize:true }, modes:{ grab:{ distance:180, links:{ opacity:.6, color:lc } } } },
                particles:{
                    color:{ value:dc },
                    links:{ color:lc, distance:120, enable:true, opacity:dark?.28:.14, width:1 },
                    move:{ enable:true, outModes:'bounce', random:true, speed:.55 },
                    number:{ density:{ enable:true, area:900 }, value:68 },
                    opacity:{ value:{ min:.2, max:dark?.65:.38 } },
                    shape:{ type:'circle' },
                    size:{ value:{ min:1, max:3 } },
                },
                detectRetina: true,
            };
        },

        async initParticles() {
            if (window.tsParticles) await tsParticles.load('tsparticles', this.particlesConfig(this.isDark));
        },

        async reloadParticles() {
            try { const c = tsParticles.domItem(0); if(c) await c.destroy(); } catch(e){}
            await this.initParticles();
        },

        setupServiceCards() {
            const cards = document.querySelectorAll('.svc-card');
            if (!cards.length) return;

            const obs = new IntersectionObserver((entries, o) => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('spin-once');
                    setTimeout(() => e.target.classList.add('spin-on'), 920);
                    o.unobserve(e.target);
                });
            }, { threshold:.28 });

            cards.forEach(c => {
                obs.observe(c);
                c.addEventListener('mousemove', e => {
                    const r = c.getBoundingClientRect();
                    c.style.setProperty('--mx', ((e.clientX-r.left)/r.width*100).toFixed(1)+'%');
                    c.style.setProperty('--my', ((e.clientY-r.top)/r.height*100).toFixed(1)+'%');
                });
            });
        },

        setupSkillBars() {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    e.target.style.width = e.target.dataset.pct + '%';
                    obs.unobserve(e.target);
                });
            }, { threshold:.5 });

            document.querySelectorAll('.skill-bar[data-pct]').forEach(b => {
                b.style.width = '0';
                obs.observe(b);
            });
        },

        setupTilt() {
            document.querySelectorAll('.proj-card').forEach(card => {
                card.addEventListener('mousemove', e => {
                    const r = card.getBoundingClientRect();
                    const x = (e.clientX-r.left)/r.width-.5;
                    const y = (e.clientY-r.top)/r.height-.5;
                    card.style.transform = `perspective(700px) rotateX(${-y*7}deg) rotateY(${x*7}deg) translateZ(6px) translateY(-8px) scale(1.01)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(700px) rotateX(0) rotateY(0) translateZ(0)';
                });
            });
        },
    };
}

/* ========= ICON HELPERS ========= */
const FOOTER_ICON_MAP = {
    facebook:  'fa-brands fa-facebook-f',
    instagram: 'fa-brands fa-instagram',
    whatsapp:  'fa-brands fa-whatsapp',
    tiktok:    'fa-brands fa-tiktok',
    twitter_x: 'fa-brands fa-x-twitter',
    twitter:   'fa-brands fa-x-twitter',
    x:         'fa-brands fa-x-twitter',
    linkedin:  'fa-brands fa-linkedin-in',
    youtube:   'fa-brands fa-youtube',
    snapchat:  'fa-brands fa-snapchat',
    telegram:  'fa-brands fa-telegram',
    pinterest: 'fa-brands fa-pinterest-p',
    github:    'fa-brands fa-github',
    gitlab:    'fa-brands fa-gitlab',
    dribbble:  'fa-brands fa-dribbble',
    behance:   'fa-brands fa-behance',
    custom:    'fa-solid fa-link'
};

function getSocialIconClass(s) {
    if (!s) return FOOTER_ICON_MAP.custom;

    if (typeof s.icon === 'string' && s.icon.trim() !== '') {
        return s.icon.trim();
    }

    if (typeof s.icon_class === 'string' && s.icon_class.trim() !== '') {
        return s.icon_class.trim();
    }

    if (typeof s.iconClass === 'string' && s.iconClass.trim() !== '') {
        return s.iconClass.trim();
    }

    if (s.platform && typeof s.platform === 'object') {
        if (typeof s.platform.icon === 'string' && s.platform.icon.trim() !== '') {
            return s.platform.icon.trim();
        }

        if (typeof s.platform.icon_class === 'string' && s.platform.icon_class.trim() !== '') {
            return s.platform.icon_class.trim();
        }
    }

    const key = String(s.platform_key || s.key || 'custom').toLowerCase();
    return FOOTER_ICON_MAP[key] || FOOTER_ICON_MAP.custom;
}

function renderSocialIcon(s) {
    const cls = getSocialIconClass(s);
    return `<i class="${cls} text-[11px] sm:text-xs"></i>`;
}

/* اختيارية: لو حبيت أيقونة داخل كروت about */
function renderAboutIcon(iconKey) {
    const map = {
        growth: 'fa-solid fa-chart-line',
        design: 'fa-solid fa-pen-ruler',
        code: 'fa-solid fa-code',
        support: 'fa-solid fa-headset',
        custom: 'fa-solid fa-circle-info',
    };

    return map[iconKey || 'custom'] || map.custom;
}
</script>
    

@endsection