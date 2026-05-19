<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use App\Models\AboutSkill;
use App\Models\AboutStat;
use App\Models\ContactContent;
use App\Models\ContactItem;
use App\Models\HeroContent;
use App\Models\NavigationLink;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Technology;
use App\Models\TechnologyRing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->truncateTables();
        $this->seedAdminUser();
        $this->seedSettings();
        $this->seedNavigation();
        $this->seedHero();
        $this->seedServices();
        $this->seedTechnologies();
        $this->seedProjects();
        $this->seedAbout();
        $this->seedContact();
        $this->seedSocialLinks();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function truncateTables(): void
    {
        // Child tables first
        Technology::truncate();
        TechnologyRing::truncate();

        ContactItem::truncate();
        ContactContent::truncate();

        AboutSkill::truncate();
        AboutStat::truncate();
        AboutContent::truncate();

        Project::truncate();
        Service::truncate();
        HeroContent::truncate();
        NavigationLink::truncate();
        SocialLink::truncate();
        Setting::truncate();

        User::where('email', 'admin@jiljam.com')->delete();
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@jiljam.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            ['key' => 'brand_name',        'value' => 'JILJAM', 'group' => 'brand'],
            ['key' => 'brand_logo',        'value' => null, 'group' => 'brand'],
            ['key' => 'default_theme',     'value' => 'dark', 'group' => 'appearance'],
            ['key' => 'default_lang',      'value' => 'en', 'group' => 'appearance'],
            ['key' => 'particles_enabled', 'value' => '1', 'group' => 'appearance'],

            ['key' => 'tech_badge_en',     'value' => 'Our Stack', 'group' => 'tech'],
            ['key' => 'tech_heading_en',   'value' => 'Technologies', 'group' => 'tech'],
            ['key' => 'tech_sub_en',       'value' => 'The tools and frameworks we use to craft exceptional digital products.', 'group' => 'tech'],
            ['key' => 'tech_badge_ar',     'value' => 'تقنياتنا', 'group' => 'tech'],
            ['key' => 'tech_heading_ar',   'value' => 'التقنيات', 'group' => 'tech'],
            ['key' => 'tech_sub_ar',       'value' => 'الأدوات والأطر التي نستخدمها لصناعة منتجات رقمية استثنائية.', 'group' => 'tech'],
            ['key' => 'orbit_center_logo',  'value' => null, 'group' => 'tech'],
            ['key' => 'orbit_center_size',  'value' => '88', 'group' => 'tech'],
            ['key' => 'orbit_center_text',  'value' => '', 'group' => 'tech'],

            ['key' => 'svc_badge_en',   'value' => 'What We Do', 'group' => 'services'],
            ['key' => 'svc_heading_en', 'value' => 'Our Services', 'group' => 'services'],
            ['key' => 'svc_sub_en',     'value' => 'From architecture to pixels — complete digital products engineered to scale.', 'group' => 'services'],
            ['key' => 'svc_badge_ar',   'value' => 'ما نقدمه', 'group' => 'services'],
            ['key' => 'svc_heading_ar', 'value' => 'خدماتنا', 'group' => 'services'],
            ['key' => 'svc_sub_ar',     'value' => 'من البنية التحتية إلى كل بكسل — منتجات رقمية متكاملة مصممة للنمو.', 'group' => 'services'],

            ['key' => 'proj_badge_en',   'value' => 'Selected Work', 'group' => 'projects'],
            ['key' => 'proj_heading_en', 'value' => 'Our Projects', 'group' => 'projects'],
            ['key' => 'proj_sub_en',     'value' => 'Built with precision and care', 'group' => 'projects'],
            ['key' => 'proj_badge_ar',   'value' => 'أبرز الأعمال', 'group' => 'projects'],
            ['key' => 'proj_heading_ar', 'value' => 'مشاريعنا', 'group' => 'projects'],
            ['key' => 'proj_sub_ar',     'value' => 'مبنية بدقة واهتمام بالتفاصيل', 'group' => 'projects'],

            ['key' => 'footer_rights_en', 'value' => '© 2025 JILJAM. All rights reserved.', 'group' => 'footer'],
            ['key' => 'footer_rights_ar', 'value' => '© 2025 JILJAM. جميع الحقوق محفوظة.', 'group' => 'footer'],
            ['key' => 'footer_craft_en',  'value' => 'Crafted with', 'group' => 'footer'],
            ['key' => 'footer_craft_ar',  'value' => 'صُنع بـ', 'group' => 'footer'],
            ['key' => 'footer_city_en',   'value' => 'in Rotterdam', 'group' => 'footer'],
            ['key' => 'footer_city_ar',   'value' => 'في روتردام', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }

    private function seedNavigation(): void
    {
        $navItems = [
            ['label_en' => 'Services',  'label_ar' => 'خدماتنا',  'href' => '#services',      'sort_order' => 1],
            ['label_en' => 'Stack',     'label_ar' => 'التقنيات', 'href' => '#technologies',  'sort_order' => 2],
            ['label_en' => 'Projects',  'label_ar' => 'المشاريع', 'href' => '#projects',      'sort_order' => 3],
            ['label_en' => 'About',     'label_ar' => 'من نحن',   'href' => '#about',         'sort_order' => 4],
            ['label_en' => 'Contact',   'label_ar' => 'تواصل',    'href' => '#contact',       'sort_order' => 5],
        ];

        foreach ($navItems as $item) {
            NavigationLink::create($item + ['is_active' => true]);
        }
    }

    private function seedHero(): void
    {
        HeroContent::create([
            'badge_en'  => 'Software Engineering Studio · Rotterdam',
            'badge_ar'  => 'استوديو هندسة البرمجيات · روتردام',
            'line1_en'  => 'We Build',
            'line1_ar'  => 'نبني',
            'line2_en'  => 'Software That',
            'line2_ar'  => 'برمجيات',
            'line3_en'  => 'Matters',
            'line3_ar'  => 'تصنع الفارق',
            'desc_en'   => 'JILJAM is a precision-focused software studio crafting scalable digital solutions for ambitious businesses.',
            'desc_ar'   => 'JILJAM استوديو برمجيات متخصص في بناء حلول رقمية متطورة وقابلة للتوسع للشركات الطموحة.',
            'cta1_en'   => 'View Our Work',
            'cta1_ar'   => 'استعرض أعمالنا',
            'cta2_en'   => 'Get In Touch',
            'cta2_ar'   => 'تواصل معنا',
            'scroll_en' => 'Scroll',
            'scroll_ar' => 'للأسفل',
        ]);
    }

    private function seedServices(): void
    {
        $services = [
            [
                'number_display' => '01',
                'color' => '#3b82f6',
                'sort_order' => 1,
                'title_en' => 'Software Engineering',
                'title_ar' => 'هندسة البرمجيات',
                'desc_en' => 'Full-stack systems built on clean architecture — performant, maintainable, and designed to grow.',
                'desc_ar' => 'أنظمة متكاملة مبنية على هندسة نظيفة — عالية الأداء، سهلة الصيانة، ومصممة للنمو.',
                'icon_path' => 'M8 6L2 12 8 18',
                'icon_path2' => 'M16 18L22 12 16 6',
            ],
            [
                'number_display' => '02',
                'color' => '#8b5cf6',
                'sort_order' => 2,
                'title_en' => 'Web Development',
                'title_ar' => 'تطوير الويب',
                'desc_en' => 'High-performance web applications with modern stacks — Laravel, Vue, React, and beyond.',
                'desc_ar' => 'تطبيقات ويب عالية الأداء باستخدام تقنيات حديثة — Laravel وVue وReact وما هو أبعد.',
                'icon_circle' => true,
                'icon_path' => 'M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20',
            ],
            [
                'number_display' => '03',
                'color' => '#f472b6',
                'sort_order' => 3,
                'title_en' => 'UI/UX Design',
                'title_ar' => 'تصميم واجهات المستخدم',
                'desc_en' => 'Interfaces that feel inevitable — research-grounded, pixel-perfect, and a delight to use.',
                'desc_ar' => 'واجهات تشعر وكأنها حتمية — مبنية على البحث، مثالية في التفاصيل، ومبهجة الاستخدام.',
                'icon_path' => 'M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z',
            ],
            [
                'number_display' => '04',
                'color' => '#10b981',
                'sort_order' => 4,
                'title_en' => 'Scalable Systems',
                'title_ar' => 'أنظمة قابلة للتوسع',
                'desc_en' => 'Cloud-native infrastructure, microservices, and DevOps pipelines that carry millions.',
                'desc_ar' => 'بنية تحتية سحابية، خدمات مصغرة، وخطوط DevOps تدعم الملايين.',
                'icon_rect' => ['x' => 2, 'y' => 3, 'w' => 20, 'h' => 14, 'rx' => 2],
                'icon_path' => 'M8 21h8M12 17v4M7 8h.01M11 8h6M7 11h.01M11 11h6',
            ],
            [
                'number_display' => '05',
                'color' => '#f59e0b',
                'sort_order' => 5,
                'title_en' => 'Custom Digital Solutions',
                'title_ar' => 'حلول رقمية مخصصة',
                'desc_en' => 'Bespoke platforms, automation, and integrations built precisely for your domain.',
                'desc_ar' => 'منصات مخصصة وأتمتة وتكاملات مبنية بدقة لنطاق عملك.',
                'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z',
            ],
            [
                'number_display' => '06',
                'color' => '#06b6d4',
                'sort_order' => 6,
                'title_en' => 'Mobile & Cross-Platform',
                'title_ar' => 'تطبيقات الجوال والمنصات',
                'desc_en' => 'Native-quality apps with Flutter and React Native — one codebase, every platform.',
                'desc_ar' => 'تطبيقات عالية الجودة باستخدام Flutter وReact Native — قاعدة كود واحدة لكل المنصات.',
                'icon_rect' => ['x' => 5, 'y' => 2, 'w' => 14, 'h' => 20, 'rx' => 2],
                'icon_path' => 'M12 18h.01',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service + ['is_active' => true]);
        }
    }

    private function seedTechnologies(): void
    {
        $rings = [
            [
                'ring_number' => 1,
                'color' => 'rgba(100,160,255,0.18)',
                'duration_seconds' => 22,
                'direction' => 'cw',
                'radius_px' => 230,
                'sort_order' => 1,
                'techs' => [
                    ['name' => 'Flutter', 'icon' => '🐦'],
                    ['name' => 'React', 'icon' => '⚛️'],
                    ['name' => 'Vue.js', 'icon' => '💚'],
                    ['name' => 'TypeScript', 'icon' => '🔷'],
                ],
            ],
            [
                'ring_number' => 2,
                'color' => 'rgba(139,92,246,0.15)',
                'duration_seconds' => 32,
                'direction' => 'ccw',
                'radius_px' => 360,
                'sort_order' => 2,
                'techs' => [
                    ['name' => 'Laravel', 'icon' => '🔴'],
                    ['name' => 'Node.js', 'icon' => '🟩'],
                    ['name' => 'Tailwind', 'icon' => '🌊'],
                    ['name' => 'Supabase', 'icon' => '⚡'],
                    ['name' => 'Docker', 'icon' => '🐳'],
                    ['name' => 'Firebase', 'icon' => '🔥'],
                ],
            ],
            [
                'ring_number' => 3,
                'color' => 'rgba(6,182,212,0.12)',
                'duration_seconds' => 42,
                'direction' => 'cw',
                'radius_px' => 500,
                'sort_order' => 3,
                'techs' => [
                    ['name' => 'HTML', 'icon' => '🟧'],
                    ['name' => 'CSS', 'icon' => '🎨'],
                    ['name' => 'JavaScript', 'icon' => '🟡'],
                    ['name' => 'PostgreSQL', 'icon' => '🐘'],
                    ['name' => 'GitHub', 'icon' => '🐙'],
                    ['name' => 'WordPress', 'icon' => '📝'],
                ],
            ],
        ];

        foreach ($rings as $ringData) {
            $techs = $ringData['techs'];
            unset($ringData['techs']);

            $ring = TechnologyRing::create($ringData + ['is_active' => true]);

            foreach ($techs as $index => $tech) {
                Technology::create([
                    'ring_id' => $ring->id,
                    'name' => $tech['name'],
                    'icon' => $tech['icon'],
                    'icon_type' => 'emoji',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'title_en' => 'Nova Commerce',
                'title_ar' => 'نوفا كوميرس',
                'abbr' => 'NC',
                'sort_order' => 1,
                'desc_en' => 'E-commerce platform with a fast checkout flow, analytics dashboard, and modular product management.',
                'desc_ar' => 'منصة تجارة إلكترونية بتجربة دفع سريعة ولوحة تحليلات وإدارة منتجات معيارية.',
                'stack' => ['Laravel', 'Vue', 'Tailwind'],
                'bg_gradient' => 'linear-gradient(135deg,#24344c,#3b82f6)',
            ],
            [
                'title_en' => 'Pulse CRM',
                'title_ar' => 'بالس CRM',
                'abbr' => 'PC',
                'sort_order' => 2,
                'desc_en' => 'Internal CRM for sales teams with pipeline tracking, automated follow-ups, and role-based access.',
                'desc_ar' => 'نظام CRM داخلي لفرق المبيعات مع تتبع المسار ومتابعات آلية وصلاحيات متعددة.',
                'stack' => ['React', 'Node.js', 'PostgreSQL'],
                'bg_gradient' => 'linear-gradient(135deg,#4c1d95,#8b5cf6)',
            ],
            [
                'title_en' => 'Atlas Ops',
                'title_ar' => 'أطلس أوبس',
                'abbr' => 'AO',
                'sort_order' => 3,
                'desc_en' => 'Operations dashboard for monitoring workflows, incidents, and team performance in real time.',
                'desc_ar' => 'لوحة تحكم عمليات لمراقبة سير العمل والحوادث وأداء الفريق في الوقت الفعلي.',
                'stack' => ['Next.js', 'TypeScript', 'Supabase'],
                'bg_gradient' => 'linear-gradient(135deg,#0f766e,#06b6d4)',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project + ['is_active' => true]);
        }
    }

    private function seedAbout(): void
    {
        AboutContent::create([
            'badge_en' => 'Who We Are',
            'badge_ar' => 'من نحن',
            'heading_en' => 'Precision at every layer',
            'heading_ar' => 'الدقة في كل مستوى',
            'desc_en' => 'We are a software studio that combines technical excellence with thoughtful design to deliver products that perform at scale — from architecture to the last pixel.',
            'desc_ar' => 'نحن استوديو برمجيات يجمع بين التميز التقني والتصميم المدروس لتسليم منتجات تعمل على نطاق واسع — من البنية التحتية إلى آخر بكسل.',
            'skills_title_en' => 'Technical Proficiency',
            'skills_title_ar' => 'الكفاءة التقنية',
        ]);

        $stats = [
            ['number' => '12+', 'label_en' => 'Projects Delivered', 'label_ar' => 'مشروع تم تسليمه', 'sort_order' => 1],
            ['number' => '8', 'label_en' => 'Years Experience', 'label_ar' => 'سنوات خبرة', 'sort_order' => 2],
            ['number' => '99%', 'label_en' => 'Client Satisfaction', 'label_ar' => 'رضا العملاء', 'sort_order' => 3],
            ['number' => '24h', 'label_en' => 'Avg Response', 'label_ar' => 'متوسط وقت الرد', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            AboutStat::create($stat + ['is_active' => true]);
        }

        $skills = [
            ['name_en' => 'Frontend Development', 'name_ar' => 'تطوير الواجهة الأمامية', 'percentage' => 96, 'sort_order' => 1],
            ['name_en' => 'Backend Architecture', 'name_ar' => 'هندسة الخادم', 'percentage' => 92, 'sort_order' => 2],
            ['name_en' => 'UI/UX Design', 'name_ar' => 'تصميم واجهة المستخدم', 'percentage' => 88, 'sort_order' => 3],
            ['name_en' => 'DevOps & Deployment', 'name_ar' => 'DevOps والنشر', 'percentage' => 84, 'sort_order' => 4],
        ];

        foreach ($skills as $skill) {
            AboutSkill::create($skill + ['is_active' => true]);
        }
    }

    private function seedContact(): void
    {
        ContactContent::create([
            'badge_en' => 'Get In Touch',
            'badge_ar' => 'تواصل معنا',
            'heading_en' => "Let's build something great",
            'heading_ar' => 'لنبنِ شيئاً رائعاً معاً',
            'desc_en' => "Have a project in mind? We'd love to hear from you.",
            'desc_ar' => 'هل لديك مشروع في ذهنك؟ يسعدنا الاستماع إليك.',
            'cta_en' => 'Send Us A Message',
            'cta_ar' => 'راسلنا الآن',
            'cta_email' => 'hello@jiljam.com',
        ]);

        $items = [
            [
                'label_en' => 'Email',
                'label_ar' => 'البريد الإلكتروني',
                'value_en' => 'hello@jiljam.com',
                'value_ar' => 'hello@jiljam.com',
                'color' => '#3b82f6',
                'icon_path' => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z',
                'icon_path2' => 'M22,6 12,13 2,6',
                'sort_order' => 1,
            ],
            [
                'label_en' => 'Location',
                'label_ar' => 'الموقع',
                'value_en' => 'Rotterdam, Netherlands',
                'value_ar' => 'روتردام، هولندا',
                'color' => '#10b981',
                'icon_path' => 'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z',
                'sort_order' => 2,
            ],
            [
                'label_en' => 'Response Time',
                'label_ar' => 'وقت الاستجابة',
                'value_en' => 'Within 24 hours',
                'value_ar' => 'خلال 24 ساعة',
                'color' => '#8b5cf6',
                'icon_circle' => true,
                'icon_path' => 'M12 6v6l4 2',
                'sort_order' => 3,
            ],
        ];

        foreach ($items as $item) {
            ContactItem::create($item + ['is_active' => true]);
        }
    }

    private function seedSocialLinks(): void
    {
        $socials = [
            [
                'label' => 'GitHub',
                'href' => '#',
                'sort_order' => 1,
                'icon_svg' => 'M12 2A10 10 0 002 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0012 2z',
            ],
            [
                'label' => 'LinkedIn',
                'href' => '#',
                'sort_order' => 2,
                'icon_svg' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
            ],
            [
                'label' => 'Twitter',
                'href' => '#',
                'sort_order' => 3,
                'icon_svg' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
            ],
        ];

        foreach ($socials as $social) {
            SocialLink::create($social + ['is_active' => true]);
        }
    }
}