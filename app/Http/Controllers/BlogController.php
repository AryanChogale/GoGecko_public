<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with('author')->latest()->paginate(10);
        $categories = Category::query()->orderBy('name')->pluck('name');

        return view('blogs.index', compact('blogs', 'categories'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $categories = Category::query()->orderBy('name')->pluck('name');

        return view('blogs.show', compact('blog', 'categories'));
    }
}