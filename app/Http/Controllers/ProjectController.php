<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function show($slug)
    {
        $project = Project::with(['serviceCategory', 'blockContents.templateBlock'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get ordered blocks for this project
        $blocks = $project->blockContents()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();


        return view('front.pages.projects.project', compact('project', 'blocks'));
    }

    public function index()
    {
        $projects = Project::with('serviceCategory')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.projects.index', compact('projects'));
    }

    public function category($categorySlug)
    {
        $category = \App\Models\ServiceCategory::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $projects = Project::with('serviceCategory')
            ->where('service_category_id', $category->id)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.pages.services.' . $categorySlug, compact('category', 'projects'));
    }
}
