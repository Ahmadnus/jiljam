<!DOCTYPE html>
<html
    lang="{{ $lang ?? 'en' }}"
    dir="{{ ($lang ?? 'en') === 'ar' ? 'rtl' : 'ltr' }}"
    x-data="jiljamApp()"
    x-init="init()"
    :class="{ 'dark': isDark, 'ar-mode': isAr }"
    class="scroll-smooth"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['brand_name'] ?? '' }} — A precision-focused software engineering studio crafting scalable digital solutions.">
    <meta property="og:title" content="{{ $settings['brand_name'] ?? '' }} — Software Engineering Studio">
    <meta property="og:type" content="website">
    <title>{{ $settings['brand_name'] ?? '' }} — Software Engineering Studio</title>

    <!-- 1. تجميع البيانات وتجهيزها (PHP Section) -->
    @php
        $frontendData = [
            'defaultTheme' => $settings['default_theme'] ?? 'dark',
            'defaultLang'  => $settings['default_lang'] ?? 'en',
            'brandName'    => $settings['brand_name'] ?? '',
            'navLinks'     => collect($navLinks ?? [])->map(fn($l) => [
                'href' => $l->href, 
                'label_en' => $l->label_en, 
                'label_ar' => $l->label_ar
            ]),
            'hero' => [
                'badge_en' => $hero->badge_en ?? '', 'badge_ar' => $hero->badge_ar ?? '',
                'line1_en' => $hero->line1_en ?? '', 'line1_ar' => $hero->line1_ar ?? '',
                'line2_en' => $hero->line2_en ?? '', 'line2_ar' => $hero->line2_ar ?? '',
                'line3_en' => $hero->line3_en ?? '', 'line3_ar' => $hero->line3_ar ?? '',
                'desc_en'  => $hero->desc_en ?? '',  'desc_ar'  => $hero->desc_ar ?? '',
                'cta1_en'  => $hero->cta1_en ?? '',  'cta1_ar'  => $hero->cta1_ar ?? '',
                'cta2_en'  => $hero->cta2_en ?? '',  'cta2_ar'  => $hero->cta2_ar ?? '',
                'scroll_en'=> $hero->scroll_en ?? '','scroll_ar'=> $hero->scroll_ar ?? '',
            ],
            'services' => collect($services ?? [])->map(fn($s) => [
                'num' => $s->number_display, 
                'color' => $s->color,
                'title_en' => $s->title_en, 
                'title_ar' => $s->title_ar,
                'desc_en' => $s->desc_en,   
                'desc_ar' => $s->desc_ar,
                'iconPath' => $s->icon_path, 
                'iconPath2' => $s->icon_path2,
                'iconCircle' => (bool)($s->icon_circle ?? false), 
                'iconRect' => $s->icon_rect,
            ]),
            'techRings' => $techRingsJson ?? [],
            'techSection' => [
                'badge_en' => $settings['tech_badge_en'] ?? 'Our Stack',
                'badge_ar' => $settings['tech_badge_ar'] ?? 'تقنياتنا',
                'heading_en' => $settings['tech_heading_en'] ?? 'Technologies',
                'heading_ar' => $settings['tech_heading_ar'] ?? 'التقنيات',
            ],
            'projects' => collect($projects ?? [])->map(fn($p) => [
                'title_en' => $p->title_en, 'title_ar' => $p->title_ar,
                'desc_en'  => $p->desc_en,  'desc_ar'  => $p->desc_ar,
                'stack' => $p->stack, 'bg' => $p->bg_gradient, 'abbr' => $p->abbr,
                'live_url' => $p->live_url, 'code_url' => $p->code_url,
                'image' => $p->image ? asset('storage/'.$p->image) : null,
            ]),
            'projSection' => [
                'badge_en' => $settings['proj_badge_en'] ?? 'Selected Work',
                'badge_ar' => $settings['proj_badge_ar'] ?? 'أبرز الأعمال',
                'heading_en' => $settings['proj_heading_en'] ?? 'Our Projects',
                'heading_ar' => $settings['proj_heading_ar'] ?? 'مشاريعنا',
            ],
            'about' => [
                'badge_en' => $about->badge_en ?? '', 'badge_ar' => $about->badge_ar ?? '',
                'heading_en' => $about->heading_en ?? '', 'heading_ar' => $about->heading_ar ?? '',
                'desc_en' => $about->desc_en ?? '',  'desc_ar' => $about->desc_ar ?? '',
                'stats' => collect($stats ?? [])->map(fn($s) => ['num' => $s->number, 'label_en' => $s->label_en, 'label_ar' => $s->label_ar]),
                'skills' => collect($skills ?? [])->map(fn($s) => ['name_en' => $s->name_en, 'name_ar' => $s->name_ar, 'pct' => $s->percentage]),
            ],
            'contact' => [
                'badge_en' => $contact->badge_en ?? '', 'badge_ar' => $contact->badge_ar ?? '',
                'heading_en' => $contact->heading_en ?? '', 'heading_ar' => $contact->heading_ar ?? '',
                'items' => collect($contactItems ?? [])->map(fn($i) => [
                    'label_en' => $i->label_en, 'label_ar' => $i->label_ar,
                    'value_en' => $i->value_en, 'value_ar' => $i->value_ar,
                    'color' => $i->color, 'iconPath' => $i->icon_path,
                ]),
            ],
            'footer' => [
                'rights_en' => $settings['footer_rights_en'] ?? '© 2025 JILJAM.',
                'rights_ar' => $settings['footer_rights_ar'] ?? '© 2025 JILJAM.',
                'socials' => collect($socials ?? [])->map(fn($s) => ['label' => $s->label, 'href' => $s->href, 'icon' => $s->icon_svg]),
            ],
            'orbitCenter' => [
                'logo' => ($settings['orbit_center_logo'] ?? null) ? asset('storage/'.$settings['orbit_center_logo']) : null,
                'size' => (int)($settings['orbit_center_size'] ?? 88),
                'text' => $settings['orbit_center_text'] ?? '',
            ],
        ];
    @endphp

    <!-- 2. حقن البيانات في JavaScript (يجب أن يكون قبل Alpine.js) -->
    <script>
        window._phpData = @js($frontendData);
    </script>

    <!-- 3. الموارد الخارجية (Libraries) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { navy: { DEFAULT:'#24344c', light:'#2d4266', dark:'#1a2638' }, cream:'#FFFDF5' } } }
        }
    </script>

    <!-- تحميل Alpine.js و tsParticles -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>

    <!-- 4. التنسيقات المخصصة (Custom Styles) -->
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{font-family:'DM Sans',sans-serif;min-height:100vh;overflow-x:hidden;transition:background-color 500ms ease,color 500ms ease}
        [x-cloak]{display:none!important}
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-thumb{background:#24344c;border-radius:4px}
        .ar-mode,.ar-mode body{font-family:'Tajawal','Cairo',sans-serif!important;direction:rtl}
        .ar-mode .font-display{font-family:'Cairo','Tajawal',sans-serif!important}
        html.ar-mode body{font-family:'Tajawal',sans-serif!important}
        html.ar-mode .font-display,html.ar-mode h1,html.ar-mode h2,html.ar-mode h3{font-family:'Cairo',sans-serif!important}
        #tsparticles{position:fixed;inset:0;z-index:0;pointer-events:none}
        .glass-nav-dark{background:rgba(15,23,42,.62);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.06)}
        .glass-nav-light{background:rgba(255,253,245,.88);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(36,52,76,.10)}
        .glass-dark{background:rgba(36,52,76,.28);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.07)}
        .glass-light{background:rgba(255,253,245,.68);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(36,52,76,.13)}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}
        @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}
        @keyframes gradMove{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        @keyframes spin-border{to{--a:360deg}}
        @keyframes spinIn{from{transform:perspective(900px) rotateY(-80deg);opacity:0}to{transform:perspective(900px) rotateY(0deg);opacity:1}}
        @keyframes spin-cw{to{transform:rotate(360deg)}}
        @keyframes spin-ccw{to{transform:rotate(-360deg)}}
        @keyframes glow-pulse{0%,100%{opacity:.06;transform:scale(1)}50%{opacity:.13;transform:scale(1.1)}}
        .float-anim{animation:float 6s ease-in-out infinite}
        .pulse-dot{animation:pulse-dot 2.2s ease-in-out infinite}
        .gradient-text{background:linear-gradient(135deg,#3b82f6,#8b5cf6,#06b6d4);background-size:200% 200%;animation:gradMove 4s ease infinite;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .section-divider{width:56px;height:2px;background:linear-gradient(to right,#3b82f6,transparent);border-radius:2px}
        .ar-mode .section-divider{background:linear-gradient(to left,#3b82f6,transparent)}
        @property --a{syntax:'<angle>';initial-value:0deg;inherits:false}
        .svc-card{position:relative;overflow:hidden;cursor:default;will-change:transform,opacity;min-height:210px;padding:24px 20px 20px;transition:box-shadow 300ms ease}
        @media(min-width:640px){.svc-card{min-height:230px;padding:28px 24px 24px}}
        @media(min-width:768px){.svc-card{min-height:240px;padding:34px 30px 28px}}
        .svc-card:nth-child(odd){border-radius:28px 8px 28px 8px}
        .svc-card:nth-child(even){border-radius:8px 28px 8px 28px}
        .svc-card::before{content:'';position:absolute;inset:0;border-radius:inherit;padding:1.5px;background:conic-gradient(from var(--a,0deg),transparent 55%,rgba(100,160,255,.52) 75%,transparent 100%);-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
        .svc-card.spin-on::before{animation:spin-border 2.8s linear infinite}
        .svc-card::after{content:'';position:absolute;inset:0;border-radius:inherit;pointer-events:none;opacity:0;transition:opacity .4s;background:radial-gradient(circle at var(--mx,50%) var(--my,50%),rgba(80,140,255,.11) 0%,transparent 60%)}
        .svc-card:hover::after{opacity:1}
        .svc-card:hover{box-shadow:0 20px 60px rgba(36,52,76,.15)}
        .svc-orb{position:absolute;border-radius:50%;filter:blur(50px);pointer-events:none;opacity:.14;transition:opacity .5s}
        .svc-card:hover .svc-orb{opacity:.26}
        .svc-num{position:absolute;top:14px;right:20px;font-family:'Syne',sans-serif;font-size:44px;font-weight:800;line-height:1;opacity:.055;pointer-events:none;user-select:none}
        @media(min-width:768px){.svc-num{font-size:52px}}
        html.ar-mode .svc-num{right:auto!important;left:20px!important;font-family:'Cairo',sans-serif}
        .spin-once{animation:spinIn 900ms cubic-bezier(0.22,1,0.36,1) both}
        .skill-bar{height:100%;border-radius:inherit;background:linear-gradient(to right,#3b82f6,#8b5cf6);transition:width 1.4s cubic-bezier(0.4,0,0.2,1)}
        .proj-card{border-radius:16px;overflow:hidden;transition:transform 320ms cubic-bezier(0.34,1.56,0.64,1),box-shadow 320ms ease;transform-style:preserve-3d;will-change:transform}
        .proj-card:hover{transform:translateY(-8px) scale(1.01);box-shadow:0 30px 70px rgba(0,0,0,.2)}
        .contact-item{transition:transform 280ms ease,background 280ms ease;border-radius:14px}
        .contact-item:hover{transform:translateX(6px)}
        .ar-mode .contact-item:hover{transform:translateX(-6px)}
        .footer-link{transition:opacity .25s ease,transform .25s ease}
        .footer-link:hover{transform:translateY(-2px)}
      .orbit-arena{
    position: relative;
    width: min(96vw, 860px);
    height: min(96vw, 860px);
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: visible;
    max-width: 100%;
    min-width: 0;
}
        .o-ring{position:absolute;border-radius:50%;border:1px dashed;width:var(--ring-d);height:var(--ring-d);top:50%;left:50%;transform-origin:0 0;margin-top:calc(var(--ring-d) / -2);margin-left:calc(var(--ring-d) / -2);animation:var(--ring-anim) var(--ring-dur) linear infinite}
        .o-node-wrap{position:absolute;width:var(--node-half-w);height:var(--node-half-w);top:calc(50% - var(--node-half-w));left:calc(50% - var(--node-half-w));transform-origin:center center;animation:var(--wrap-anim) var(--ring-dur) linear infinite}
        .o-node-inner{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;gap:4px;animation:var(--inner-anim) var(--ring-dur) linear infinite}
        .o-icon{width:var(--icon-sz);height:var(--icon-sz);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:var(--icon-fs);transition:transform .3s cubic-bezier(.34,1.56,.64,1),box-shadow .3s;flex-shrink:0;position:relative;top:calc(var(--icon-sz) / -2 + var(--node-half-w) / 2)}
        .o-icon-dark{background:rgba(36,52,76,.60);border:1px solid rgba(255,255,255,.10);backdrop-filter:blur(10px)}
        .o-icon-light{background:rgba(255,253,245,.85);border:1px solid rgba(36,52,76,.13);backdrop-filter:blur(10px);box-shadow:0 2px 8px rgba(36,52,76,.07)}
        .o-node-wrap:hover .o-icon{transform:scale(1.25);box-shadow:0 8px 24px rgba(59,130,246,.30)}
        .o-node-wrap:hover .o-icon-dark{border-color:rgba(100,160,255,.4);background:rgba(59,130,246,.20)}
        .o-node-wrap:hover .o-icon-light{border-color:rgba(59,130,246,.35)}
        .o-label{font-size:9px;font-weight:600;letter-spacing:.04em;white-space:nowrap;opacity:0;transition:opacity .25s;padding:2px 6px;border-radius:4px;pointer-events:none;position:relative;top:calc(var(--icon-sz) / -2 + var(--node-half-w) / 2)}
        .o-node-wrap:hover .o-label{opacity:1}
        .o-label-dark{background:rgba(15,23,42,.85);color:#94a3b8}
        .o-label-light{background:rgba(255,253,245,.94);color:#24344c;border:1px solid rgba(36,52,76,.1)}
        .orbit-hub{position:absolute;top:50%;left:50%;z-index:10;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:transform .4s ease;transform:translate(-50%,-50%)}
        .orbit-hub:hover{transform:translate(-50%,-50%) scale(1.08)}
        .orbit-hub-dark{background:radial-gradient(circle at 35% 35%, rgba(59,130,246,.22), rgba(139,92,246,.18));border:1.5px solid rgba(100,160,255,.28);box-shadow:0 0 0 10px rgba(59,130,246,.04),0 0 0 22px rgba(59,130,246,.02),0 0 40px rgba(59,130,246,.13),inset 0 1px 0 rgba(255,255,255,.08)}
        .orbit-hub-light{background:radial-gradient(circle at 35% 35%, rgba(59,130,246,.12), rgba(139,92,246,.08));border:1.5px solid rgba(36,52,76,.16);box-shadow:0 0 0 10px rgba(59,130,246,.03),0 0 0 22px rgba(59,130,246,.015),0 0 30px rgba(59,130,246,.08),inset 0 1px 0 rgba(255,255,255,.5)}
        .o-glow{position:absolute;border-radius:50%;background:radial-gradient(circle,#3b82f6,transparent 70%);animation:glow-pulse 4s ease-in-out infinite;pointer-events:none}
      :root{
    --scale: 0.78;
    --hub-sz: calc(100px * var(--scale));
    --icon-sz: calc(50px * var(--scale));
    --icon-fs: calc(20px * var(--scale));
    --node-half-w: calc(var(--icon-sz) / 2);
    --r1-d: calc(260px * var(--scale));
    --r2-d: calc(400px * var(--scale));
    --r3-d: calc(560px * var(--scale));
}

    @media(min-width:400px){:root{--scale:0.86}}
@media(min-width:500px){:root{--scale:0.94}}
@media(min-width:640px){:root{--scale:1.02}}
@media(min-width:768px){:root{--scale:1.10}}
@media(min-width:1024px){:root{--scale:1.18}}
@media(min-width:1280px){:root{--scale:1.26}}
        html,body{width:100%;max-width:100vw;overflow-x:hidden;position:relative}
        [data-aos]{will-change:transform,opacity}
       
    @keyframes spin-cw { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes spin-ccw { from { transform: rotate(0deg); } to { transform: rotate(-360deg); } }
    .o-ring { animation: var(--ring-anim) var(--ring-dur) linear infinite; }
    .o-node-inner { animation-fill-mode: forwards; animation-timing-function: linear; animation-iteration-count: infinite; }
/* ══ الأنماط المحدثة للمدارات لضمان توزيع وسنترة مثالية ══ */
@keyframes ring-spin-cw { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@keyframes ring-spin-ccw { from { transform: rotate(0deg); } to { transform: rotate(-360deg); } }
@keyframes node-spin-cw { from { transform: translate(-50%, -50%) rotate(0deg); } to { transform: translate(-50%, -50%) rotate(360deg); } }
@keyframes node-spin-ccw { from { transform: translate(-50%, -50%) rotate(0deg); } to { transform: translate(-50%, -50%) rotate(-360deg); } }

.orbit-arena { position: relative; width: min(92vw, 720px); height: min(92vw, 720px); margin: 0 auto; display: flex; align-items: center; justify-content: center; overflow: visible; max-width: 100%; min-width: 0; }

.o-ring { 
    position: absolute; 
    border-radius: 50%; 
    border: 1px dashed; 
    width: var(--ring-d); 
    height: var(--ring-d); 
    top: 50%; 
    left: 50%; 
    transform-origin: center center !important; 
    margin-top: calc(var(--ring-d) / -2); 
    margin-left: calc(var(--ring-d) / -2); 
    animation: var(--ring-anim) var(--ring-dur) linear infinite; 
}

.o-node-wrap { 
    position: absolute; 
    width: 0; 
    height: 0; 
    top: 50%; 
    left: 50%; 
    transform-origin: center center; 
}

.o-node-inner { 
    position: absolute; 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    justify-content: center; 
    transform: translate(-50%, -50%); 
    white-space: nowrap; 
    animation-fill-mode: forwards; 
    animation-timing-function: linear; 
    animation-iteration-count: infinite; 
}

.o-icon{
    width: var(--icon-sz);
    height: var(--icon-sz);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--icon-fs);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s;
    flex-shrink: 0;
    position: relative;
    top: calc(var(--icon-sz) / -2 + var(--node-half-w) / 2);
}

.orbit-hub{
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 10;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .4s ease;
    transform: translate(-50%,-50%);
}
    </style>
</head>

<body :class="isDark ? 'bg-[#0f172a] text-slate-200' : 'bg-[#FFFDF5] text-[#24344c]'" class="antialiased">
    <div id="tsparticles"></div>

    <!-- 5. مكان عرض المحتوى (Sections) -->
    @yield('content')

    <!-- 6. السكربتات النهائية -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    
    <!-- التأكد من جاهزية Alpine قبل تشغيل أي شيء -->
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized with Data:', window._phpData);
        });
        
        // تشغيل AOS للأنيميشن
        window.addEventListener('load', () => {
            AOS.init({
                duration: 800,
                once: true,
                easing: 'ease-out-cubic'
            });
        });
    </script>

    @yield('scripts')
</body>
</html>