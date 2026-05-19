<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Service, Project, TechnologyRing, Technology};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services'    => Service::count(),
            'projects'    => Project::count(),
            'rings'       => TechnologyRing::count(),
            'technologies'=> Technology::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}