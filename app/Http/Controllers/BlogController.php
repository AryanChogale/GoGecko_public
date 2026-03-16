<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with('author')->latest()->paginate(10);
        $categories = Product::distinct()->pluck('category')->sort()->values();

        return view('blogs.index', compact('blogs', 'categories'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $categories = Product::distinct()->pluck('category')->sort()->values();

        return view('blogs.show', compact('blog', 'categories'));
    }
}