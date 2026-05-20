<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    NavigationLink, HeroContent, AboutContent, AboutStat, AboutSkill,
    ContactContent, ContactItem, SocialLink
};
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // ── Navigation ────────────────────────────────────────────────

    public function navIndex()
    {
        $links = NavigationLink::orderBy('sort_order')->get();
        return view('admin.content.navigation', compact('links'));
    }

    public function navStore(Request $request)
    {
        $request->validate(['label_en' => 'required|max:60', 'label_ar' => 'required|max:60', 'href' => 'required|max:100']);
        NavigationLink::create($request->only('label_en', 'label_ar', 'href') + [
            'sort_order' => NavigationLink::max('sort_order') + 1,
            'is_active'  => true,
        ]);
        return back()->with('success', 'Link added.');
    }

    public function navUpdate(Request $request, NavigationLink $link)
    {
        $request->validate(['label_en' => 'required|max:60', 'label_ar' => 'required|max:60', 'href' => 'required|max:100']);
        $link->update($request->only('label_en', 'label_ar', 'href', 'is_active'));
        return back()->with('success', 'Link updated.');
    }

    public function navDestroy(NavigationLink $link)
    {
        $link->delete();
        return back()->with('success', 'Link deleted.');
    }

    public function navReorder(Request $request)
    {
        foreach ($request->ids as $i => $id) {
            NavigationLink::where('id', $id)->update(['sort_order' => $i + 1]);
        }
        return response()->json(['ok' => true]);
    }

    // ── Hero ──────────────────────────────────────────────────────

    public function hero()
    {
        $hero = HeroContent::current();
        return view('admin.content.hero', compact('hero'));
    }

    public function heroUpdate(Request $request)
    {
        $request->validate([
            'badge_en'  => 'required|max:120', 'badge_ar'  => 'required|max:120',
            'line1_en'  => 'required|max:80',  'line1_ar'  => 'required|max:80',
            'line2_en'  => 'required|max:80',  'line2_ar'  => 'required|max:80',
            'line3_en'  => 'required|max:80',  'line3_ar'  => 'required|max:80',
            'desc_en'   => 'required|max:400', 'desc_ar'   => 'required|max:400',
            'cta1_en'   => 'required|max:60',  'cta1_ar'   => 'required|max:60',
            'cta2_en'   => 'required|max:60',  'cta2_ar'   => 'required|max:60',
        ]);
        HeroContent::current()->update($request->validated());
        return back()->with('success', 'Hero updated.');
    }

    // ── About ─────────────────────────────────────────────────────

    public function about()
    {
        $about  = AboutContent::current();
        $stats  = AboutStat::orderBy('sort_order')->get();
        $skills = AboutSkill::orderBy('sort_order')->get();
        return view('admin.content.about', compact('about', 'stats', 'skills'));
    }

    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'badge_en'        => 'required|max:80',  'badge_ar'        => 'required|max:80',
            'heading_en'      => 'required|max:150', 'heading_ar'      => 'required|max:150',
            'desc_en'         => 'required|max:600', 'desc_ar'         => 'required|max:600',
            'skills_title_en' => 'required|max:80',  'skills_title_ar' => 'required|max:80',
        ]);
        AboutContent::current()->update($request->validated());
        return back()->with('success', 'About updated.');
    }

    public function statStore(Request $request)
    {
        $request->validate(['number' => 'required|max:20', 'label_en' => 'required|max:80', 'label_ar' => 'required|max:80']);
        AboutStat::create($request->only('number', 'label_en', 'label_ar') + [
            'sort_order' => AboutStat::max('sort_order') + 1,
            'is_active'  => true,
        ]);
        return back()->with('success', 'Stat added.');
    }

    public function statUpdate(Request $request, AboutStat $stat)
    {
        $request->validate(['number' => 'required|max:20', 'label_en' => 'required|max:80', 'label_ar' => 'required|max:80']);
        $stat->update($request->only('number', 'label_en', 'label_ar', 'is_active'));
        return back()->with('success', 'Stat updated.');
    }

    public function statDestroy(AboutStat $stat)
    {
        $stat->delete();
        return back()->with('success', 'Stat deleted.');
    }

    public function skillStore(Request $request)
    {
        $request->validate(['name_en' => 'required|max:80', 'name_ar' => 'required|max:80', 'percentage' => 'required|integer|min:0|max:100']);
        AboutSkill::create($request->only('name_en', 'name_ar', 'percentage') + [
            'sort_order' => AboutSkill::max('sort_order') + 1,
            'is_active'  => true,
        ]);
        return back()->with('success', 'Skill added.');
    }

    public function skillUpdate(Request $request, AboutSkill $skill)
    {
        $request->validate(['name_en' => 'required|max:80', 'name_ar' => 'required|max:80', 'percentage' => 'required|integer|min:0|max:100']);
        $skill->update($request->only('name_en', 'name_ar', 'percentage', 'is_active'));
        return back()->with('success', 'Skill updated.');
    }

    public function skillDestroy(AboutSkill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }

    // ── Contact ───────────────────────────────────────────────────

    public function contact()
    {
        $contact = ContactContent::current();
        $items   = ContactItem::orderBy('sort_order')->get();
        $socials = SocialLink::orderBy('sort_order')->get();

        // Pass icon definitions to the view
        $contactIconOptions = ContactItem::iconOptions();
        $socialPlatforms    = SocialLink::platforms();

        return view('admin.content.contact', compact(
            'contact', 'items', 'socials',
            'contactIconOptions', 'socialPlatforms'
        ));
    }

 public function contactUpdate(Request $request)
{
    $validated = $request->validate([
        'badge_en'   => 'required|max:80',
        'badge_ar'   => 'required|max:80',
        'heading_en' => 'required|max:150',
        'heading_ar' => 'required|max:150',
        'desc_en'    => 'required|max:400',
        'desc_ar'    => 'required|max:400',
        'cta_en'     => 'required|max:80',
        'cta_ar'     => 'required|max:80',
        'cta_email'  => 'required|email|max:120',
    ]);

    ContactContent::current()->update($validated);

    return back()->with('success', 'Contact updated.');
}

    public function contactItemStore(Request $request)
    {
        $request->validate([
            'label_en' => 'required|max:80',
            'label_ar' => 'required|max:80',
            'value_en' => 'required|max:200',
            'value_ar' => 'required|max:200',
            'icon_key' => 'required|string|max:30',
        ]);

        // Resolve color from icon_key if not provided
        $color = $request->color ?: ContactItem::colorFor($request->icon_key);

        ContactItem::create([
            'label_en'   => $request->label_en,
            'label_ar'   => $request->label_ar,
            'value_en'   => $request->value_en,
            'value_ar'   => $request->value_ar,
            'icon_key'   => $request->icon_key,
            'color'      => $color,
            'icon_path'  => ContactItem::pathFor($request->icon_key),
            'sort_order' => ContactItem::max('sort_order') + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Contact item added.');
    }

    public function contactItemUpdate(Request $request, ContactItem $item)
    {
        $request->validate([
            'label_en' => 'required|max:80',
            'label_ar' => 'required|max:80',
            'value_en' => 'required|max:200',
            'value_ar' => 'required|max:200',
            'icon_key' => 'required|string|max:30',
        ]);

        $color = $request->color ?: ContactItem::colorFor($request->icon_key);

        $item->update([
            'label_en'  => $request->label_en,
            'label_ar'  => $request->label_ar,
            'value_en'  => $request->value_en,
            'value_ar'  => $request->value_ar,
            'icon_key'  => $request->icon_key,
            'color'     => $color,
            'icon_path' => ContactItem::pathFor($request->icon_key),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Item updated.');
    }

    public function contactItemDestroy(ContactItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item deleted.');
    }

    // ── Social Links (NEW SYSTEM) ──────────────────────────────────

    public function socialStore(Request $request)
    {
        $isWhatsapp = $request->platform_key === 'whatsapp';

        $request->validate([
            'platform_key'     => 'required|string|max:30',
            'href'             => $isWhatsapp ? 'nullable|url|max:255' : 'required|url|max:255',
            'whatsapp_number'  => $isWhatsapp ? 'required|string|max:20' : 'nullable|string|max:20',
        ]);

        $platforms = SocialLink::platforms();
        $label     = $platforms[$request->platform_key]['label'] ?? ucfirst($request->platform_key);

        SocialLink::create([
            'label'           => $label,
            'platform_key'    => $request->platform_key,
            'href'            => $request->href ?? '',
            'whatsapp_number' => $request->whatsapp_number,
            'is_floating'     => $request->boolean('is_floating'),
            'sort_order'      => SocialLink::max('sort_order') + 1,
            'is_active'       => true,
        ]);

        return back()->with('success', 'Social link added.');
    }

    public function socialUpdate(Request $request, SocialLink $social)
    {
        $isWhatsapp = $request->platform_key === 'whatsapp';

        $request->validate([
            'platform_key'    => 'required|string|max:30',
            'href'            => $isWhatsapp ? 'nullable|url|max:255' : 'required|url|max:255',
            'whatsapp_number' => $isWhatsapp ? 'required|string|max:20' : 'nullable|string|max:20',
        ]);

        $platforms = SocialLink::platforms();
        $label     = $platforms[$request->platform_key]['label'] ?? ucfirst($request->platform_key);

        $social->update([
            'label'           => $label,
            'platform_key'    => $request->platform_key,
            'href'            => $request->href ?? '',
            'whatsapp_number' => $request->whatsapp_number,
            'is_floating'     => $request->boolean('is_floating'),
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Social link updated.');
    }

    public function socialDestroy(SocialLink $social)
    {
        $social->delete();
        return back()->with('success', 'Social link deleted.');
    }
}