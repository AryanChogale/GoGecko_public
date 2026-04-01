<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with('author')->latest()->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->pluck('name');

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'excerpt'            => ['required', 'string', 'max:500'],
            'category'           => ['nullable', 'string', 'max:255'],
            'image'              => ['nullable', 'image', 'max:2048'],
            'blocks'             => ['required', 'array', 'min:1'],
            'blocks.*.header'    => ['nullable', 'string', 'max:255'],
            'blocks.*.subheader' => ['nullable', 'string', 'max:255'],
            'blocks.*.content'   => ['nullable', 'string'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'author_id'  => auth()->id(),
            'title'      => $validated['title'],
            'slug'       => Str::slug($validated['title']),
            'excerpt'    => $validated['excerpt'],
            'category'   => $validated['category'] ?? null,
            'content'    => $validated['blocks'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post published.');
    }

    public function edit(Blog $blog): View
    {
        $categories = Category::query()->orderBy('name')->pluck('name');

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'excerpt'            => ['required', 'string', 'max:500'],
            'category'           => ['nullable', 'string', 'max:255'],
            'image'              => ['nullable', 'image', 'max:2048'],
            'blocks'             => ['required', 'array', 'min:1'],
            'blocks.*.header'    => ['nullable', 'string', 'max:255'],
            'blocks.*.subheader' => ['nullable', 'string', 'max:255'],
            'blocks.*.content'   => ['nullable', 'string'],
        ]);

        $imagePath = $blog->image_path;
        if ($request->hasFile('image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'title'      => $validated['title'],
            'slug'       => Str::slug($validated['title']),
            'excerpt'    => $validated['excerpt'],
            'category'   => $validated['category'] ?? null,
            'content'    => $validated['blocks'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted.');
    }
}