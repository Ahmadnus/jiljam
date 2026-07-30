<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoriesController extends Controller
{
    public function index()
    {
        $categories = ProjectCategory::withCount('projects')->orderBy('sort_order')->get();
        return view('admin.projects.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:80',
            'name_ar' => 'required|string|max:80',
        ]);

        ProjectCategory::create([
            'name_en'    => $data['name_en'],
            'name_ar'    => $data['name_ar'],
            'slug'       => ProjectCategory::makeSlug($data['name_en']),
            'sort_order' => (ProjectCategory::max('sort_order') ?? 0) + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Category added.');
    }

    public function update(Request $request, ProjectCategory $category)
    {
        $data = $request->validate([
            'name_en'   => 'required|string|max:80',
            'name_ar'   => 'required|string|max:80',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name_en'   => $data['name_en'],
            'name_ar'   => $data['name_ar'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(ProjectCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
