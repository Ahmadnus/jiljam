<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create() { return view('admin.services.form', ['service' => new Service]); }

    public function store(Request $request)
    {
        $data = $this->validate($request);
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service) { return view('admin.services.form', compact('service')); }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validate($request));
        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);
        foreach ($request->ids as $order => $id) {
            Service::where('id', $id)->update(['sort_order' => $order + 1]);
        }
        return response()->json(['ok' => true]);
    }

    private function validate(Request $request): array
    {
        return $request->validate([
            'number_display' => 'required|string|max:10',
            'title_en'       => 'required|string|max:120',
            'title_ar'       => 'required|string|max:120',
            'desc_en'        => 'required|string|max:500',
            'desc_ar'        => 'required|string|max:500',
            'color'          => 'required|string|max:30',
            'icon_path'      => 'required|string',
            'icon_path2'     => 'nullable|string',
            'icon_circle'    => 'nullable|boolean',
            'icon_rect'      => 'nullable|json',
            'sort_order'     => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
        ]);
    }
}