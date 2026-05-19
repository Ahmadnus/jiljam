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
        $settings    = Setting::allKeyed();
        $navLinks    = NavigationLink::active()->get();
        $hero        = HeroContent::current();
        $services    = Service::active()->get();
        $rings       = TechnologyRing::with(['technologies' => fn($q) => $q->active()])
                            ->active()->get();
        $projects    = Project::active()->get();
        $about       = AboutContent::current();
        $stats       = AboutStat::active()->get();
        $skills      = AboutSkill::active()->get();
        $contact     = ContactContent::current();
        $contactItems= ContactItem::active()->get();
        $socials     = SocialLink::active()->get();

        // Build JS-friendly rings array for Alpine
        $techRingsJson = $rings->map(fn($ring) => [
            'id'        => $ring->id,
            'color'     => $ring->color,
            'duration'  => $ring->duration_seconds,
            'direction' => $ring->direction,
            'radius'    => $ring->radius_px,
            'nodes'     => $ring->technologies->map(fn($t) => [
                'name'      => $t->name,
                'icon'      => $t->icon,
                'icon_type' => $t->icon_type,
                'icon_image'=> $t->icon_image ? asset('storage/'.$t->icon_image) : null,
            ])->values(),
        ])->values();

        return view('frontend.home', compact(
            'settings','navLinks','hero','services','rings',
            'techRingsJson','projects','about','stats','skills',
            'contact','contactItems','socials'
        ));
    }
}