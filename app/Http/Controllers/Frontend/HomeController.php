<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\{
    Setting, NavigationLink, HeroContent, Service,
    TechnologyRing, Project, AboutContent, AboutStat, AboutSkill,
    ContactContent, ContactItem, SocialLink
};

class HomeController extends Controller
{
    public function index()
    {
        $settings     = Setting::allKeyed();
        $navLinks     = NavigationLink::active()->get();
        $hero         = HeroContent::current();
        $services     = Service::active()->get();
        $rings        = TechnologyRing::with(['technologies' => fn($q) => $q->active()])
                            ->active()->get();
        $projects     = Project::active()->get();
        $about        = AboutContent::current();
        $stats        = AboutStat::active()->get();
        $skills       = AboutSkill::active()->get();
        $contact      = ContactContent::current();
        $contactItems = ContactItem::active()->get();
        $socials      = SocialLink::active()->get();

        // First floating social link (for floating button in footer)
        $floatingBtn  = SocialLink::active()->where('is_floating', true)->first();

        // JS-friendly rings array
        $techRingsJson = $rings->map(fn($ring) => [
            'id'        => $ring->id,
            'color'     => $ring->color,
            'duration'  => $ring->duration_seconds,
            'direction' => $ring->direction,
            'radius'    => $ring->radius_px,
            'nodes'     => $ring->technologies->map(fn($t) => [
                'name'       => $t->name,
                'icon'       => $t->icon,
                'icon_type'  => $t->icon_type,
                'icon_image' => $t->icon_image ? asset('storage/' . $t->icon_image) : null,
            ])->values(),
        ])->values();

        // Contact items — icon_path filled from icon_key for Alpine rendering
        $contactItemsJs = $contactItems->map(fn($item) => [
            'id'        => $item->id,
            'label_en'  => $item->label_en,
            'label_ar'  => $item->label_ar,
            'value_en'  => $item->value_en,
            'value_ar'  => $item->value_ar,
            'color'     => $item->color,
            'icon_key'  => $item->icon_key,
            'icon_path' => $item->icon_path,
        ]);

        // Socials — only non-floating, with resolved href (wa.me for WA)
 // HomeController
$socialsJs = $socials->where('is_floating', false)->map(fn($s) => [
    'id'           => $s->id,
    'label'        => $s->label,
    'platform_key' => $s->platform_key,
    'href'         => $s->resolved_href,
    'color'        => $s->platform_color,
    'icon'         => $s->platform_icon,
    'whatsapp_number' => $s->whatsapp_number,
])->values();

        return view('frontend.home', compact(
            'settings', 'navLinks', 'hero', 'services', 'rings',
            'techRingsJson', 'projects', 'about', 'stats', 'skills',
            'contact', 'contactItems', 'contactItemsJs',
            'socials', 'socialsJs', 'floatingBtn'
        ));
    }
}