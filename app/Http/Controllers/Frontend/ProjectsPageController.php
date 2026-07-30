<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\{Setting, NavigationLink, HeroContent, AboutContent, ContactContent, ContactItem, SocialLink, Project, ProjectCategory};

class ProjectsPageController extends Controller
{
    public function index()
    {
        $settings   = Setting::allKeyed();
        $navLinks   = NavigationLink::active()->get();
        $categories = ProjectCategory::active()->withCount(['projects' => fn($q) => $q->where('is_active', true)])->get();
        $projects   = Project::active()->with('category')->get();
        $socials    = SocialLink::active()->where('is_floating', false)->get();

        $projectsJs = $projects->map(fn($p) => [
            'id'          => $p->id,
            'title_en'    => $p->title_en,
            'title_ar'    => $p->title_ar,
            'desc_en'     => $p->desc_en,
            'desc_ar'     => $p->desc_ar,
            'stack'       => $p->stack,
            'bg'          => $p->bg_gradient,
            'abbr'        => $p->abbr,
            'live_url'    => $p->live_url,
            'code_url'    => $p->code_url,
            'image'       => $p->image ? asset('storage/' . $p->image) : null,
            'category_id' => $p->category_id,
        ])->values();

        $categoriesJs = $categories->map(fn($c) => [
            'id'      => $c->id,
            'slug'    => $c->slug,
            'name_en' => $c->name_en,
            'name_ar' => $c->name_ar,
            'count'   => $c->projects_count,
        ])->values();

        return view('frontend.projects', compact(
            'settings', 'navLinks', 'projects', 'projectsJs', 'categories', 'categoriesJs', 'socials'
        ));
    }
}
