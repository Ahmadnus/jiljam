<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create() { return view('admin.projects.form', ['project' => new Project]); }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data = $this->handleImage($request, $data);
        $data['stack'] = array_filter(array_map('trim', explode(',', $request->stack_raw)));
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project) { return view('admin.projects.form', compact('project')); }

    public function update(Request $request, Project $project)
    {
        $data = $this->validateData($request);
        $data = $this->handleImage($request, $data, $project);
        $data['stack'] = array_filter(array_map('trim', explode(',', $request->stack_raw)));
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) Storage::disk('public')->delete($project->image);
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $order => $id) {
            Project::where('id', $id)->update(['sort_order' => $order + 1]);
        }
        return response()->json(['ok' => true]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title_en'    => 'required|string|max:120',
            'title_ar'    => 'required|string|max:120',
            'desc_en'     => 'required|string|max:500',
            'desc_ar'     => 'required|string|max:500',
            'stack_raw'   => 'required|string',
            'bg_gradient' => 'required|string|max:200',
            'abbr'        => 'required|string|max:10',
            'live_url'    => 'nullable|url|max:255',
            'code_url'    => 'nullable|url|max:255',
            'image'       => 'nullable|image|max:4096',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);
    }

    private function handleImage(Request $request, array $data, ?Project $project = null): array
    {
        unset($data['image']);
        if ($request->hasFile('image')) {
            if ($project && $project->image) Storage::disk('public')->delete($project->image);
            $data['image'] = $request->file('image')->store('projects', 'public');
        }
        return $data;
    }
}