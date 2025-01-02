<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();

        return view('back.blog', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|',
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        return $request;

        $image_name = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/blogs'), $image_name);

        Blog::create([
            'title' => $request->title,
            'image' => $image_name,
            'description' => $request->decription,
        ]);

        return view('back.blog', compact('blogs'));
    }
}
