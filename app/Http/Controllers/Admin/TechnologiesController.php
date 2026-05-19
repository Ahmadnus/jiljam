<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{TechnologyRing, Technology};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologiesController extends Controller
{
    // ── Rings ─────────────────────────────────────────────────────

    public function index()
    {
        $rings = TechnologyRing::with('technologies')->orderBy('sort_order')->get();
        return view('admin.technologies.index', compact('rings'));
    }

    public function createRing() { return view('admin.technologies.ring-form', ['ring' => new TechnologyRing]); }

   public function storeRing(Request $request)
{
    $data = $request->validate([
        'ring_number'      => 'required|integer|min:1',
        'color'            => 'required|string|max:80',
        'duration_seconds' => 'required|integer|min:5|max:200',
        'direction'        => 'required|in:cw,ccw',
        'radius_px'        => 'required|integer|min:80|max:800',
        'sort_order'       => 'nullable|integer',
    ]);

    TechnologyRing::create($data + ['is_active' => $request->boolean('is_active', true)]);

    return redirect()->route('admin.technologies.index')->with('success', 'Ring created.');
}

    public function editRing(TechnologyRing $ring) { return view('admin.technologies.ring-form', compact('ring')); }

    public function updateRing(Request $request, TechnologyRing $ring)
{
    $data = $request->validate([
        'ring_number'      => 'required|integer|min:1',
        'color'            => 'required|string|max:80',
        'duration_seconds' => 'required|integer|min:5|max:200',
        'direction'        => 'required|in:cw,ccw',
        'radius_px'        => 'required|integer|min:80|max:800',
        'sort_order'       => 'nullable|integer',
    ]);

    $ring->update($data + ['is_active' => $request->boolean('is_active', true)]);

    return redirect()->route('admin.technologies.index')->with('success', 'Ring updated.');
}

    public function destroyRing(TechnologyRing $ring)
    {
        $ring->technologies()->each(fn($t) => $this->deleteTechImage($t));
        $ring->delete();
        return back()->with('success', 'Ring deleted.');
    }

    // ── Technologies ─────────────────────────────────────────────

    public function createTech(TechnologyRing $ring)
    {
        return view('admin.technologies.tech-form', ['tech' => new Technology, 'ring' => $ring]);
    }

    public function storeTech(Request $request, TechnologyRing $ring)
    {
        $data = $this->validateTech($request);
        $data = $this->handleTechImage($request, $data);
        $ring->technologies()->create($data);
        return redirect()->route('admin.technologies.index')->with('success', 'Technology added.');
    }

    public function editTech(TechnologyRing $ring, Technology $tech)
    {
        return view('admin.technologies.tech-form', compact('ring', 'tech'));
    }

    public function updateTech(Request $request, TechnologyRing $ring, Technology $tech)
    {
        $data = $this->validateTech($request);
        $data = $this->handleTechImage($request, $data, $tech);
        $tech->update($data);
        return redirect()->route('admin.technologies.index')->with('success', 'Technology updated.');
    }

    public function destroyTech(TechnologyRing $ring, Technology $tech)
    {
        $this->deleteTechImage($tech);
        $tech->delete();
        return back()->with('success', 'Technology deleted.');
    }

    public function reorderTech(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $order => $id) {
            Technology::where('id', $id)->update(['sort_order' => $order + 1]);
        }
        return response()->json(['ok' => true]);
    }

    private function validateTech(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|string|max:60',
            'icon'       => 'nullable|string|max:20',
            'icon_type'  => 'required|in:emoji,image',
            'icon_image' => 'nullable|image|max:1024',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);
    }

    private function handleTechImage(Request $request, array $data, ?Technology $tech = null): array
    {
        unset($data['icon_image']);
        if ($request->hasFile('icon_image')) {
            if ($tech && $tech->icon_image) Storage::disk('public')->delete($tech->icon_image);
            $data['icon_image'] = $request->file('icon_image')->store('tech-icons', 'public');
            $data['icon_type']  = 'image';
        }
        return $data;
    }

    private function deleteTechImage(Technology $tech): void
    {
        if ($tech->icon_image) Storage::disk('public')->delete($tech->icon_image);
    }
}