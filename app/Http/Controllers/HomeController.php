<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        $data['services'] = ServiceCategory::all();
        $data['projects'] = Project::where('is_featured', 1)->orderBy('sort_order', 'asc')->take(10)->with('serviceCategory')->get();
        return view('front.home', compact('data'));
    }
}
