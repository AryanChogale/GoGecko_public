<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $categories = BlogCategory::query()->orderBy('name')->get(['id', 'name']);
        $selectedCategory = $request->integer('category') ?: null;

        $blogs = Blog::with(['author', 'blogCategory'])
            ->when($selectedCategory, function ($query) use ($selectedCategory, $categories) {
                $selectedCategoryModel = $categories->firstWhere('id', $selectedCategory);

                $query->where(function ($blogQuery) use ($selectedCategory, $selectedCategoryModel) {
                    $blogQuery->where('blog_category_id', $selectedCategory);

                    if ($selectedCategoryModel) {
                        $blogQuery->orWhere(function ($legacyQuery) use ($selectedCategoryModel) {
                            $legacyQuery->whereNull('blog_category_id')
                                ->where('category', $selectedCategoryModel->name);
                        });
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('blogs.index', compact('blogs', 'categories', 'selectedCategory'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::with('blogCategory')->where('slug', $slug)->firstOrFail();
        $categories = BlogCategory::query()->orderBy('name')->pluck('name');

        return view('blogs.show', compact('blog', 'categories'));
    }
}
