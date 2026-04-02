<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\BlogContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $categories = BlogCategory::query()->orderBy('name')->get(['id', 'name']);
        $selectedCategory = request()->integer('category') ?: null;

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

        return view('admin.blogs.index', compact('blogs', 'categories', 'selectedCategory'));
    }

    public function create(): View
    {
        $categories = BlogCategory::query()->orderBy('name')->pluck('name');

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'excerpt'            => ['required', 'string', 'max:500'],
            'category'           => ['nullable', 'string', 'max:255'],
            'image'              => ['nullable', 'image', 'max:2048'],
            'content'            => ['required', 'string'],
        ]);

        $content = BlogContent::sanitizeHtml($validated['content']);

        if (!BlogContent::hasMeaningfulContent($content)) {
            return back()
                ->withErrors(['content' => 'Blog content cannot be empty.'])
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->storeBlogImage($request->file('image'));
        }

        $categoryName = trim((string) ($validated['category'] ?? ''));
        $blogCategory = $categoryName !== ''
            ? BlogCategory::firstOrCreate(['name' => $categoryName])
            : null;

        Blog::create([
            'author_id'  => auth()->id(),
            'title'      => $validated['title'],
            'slug'       => Str::slug($validated['title']),
            'excerpt'    => $validated['excerpt'],
            'category'   => $categoryName !== '' ? $categoryName : null,
            'blog_category_id' => $blogCategory?->id,
            'content'    => $content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post published.');
    }

    public function edit(Blog $blog): View
    {
        $categories = BlogCategory::query()->orderBy('name')->pluck('name');

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'excerpt'            => ['required', 'string', 'max:500'],
            'category'           => ['nullable', 'string', 'max:255'],
            'image'              => ['nullable', 'image', 'max:2048'],
            'content'            => ['required', 'string'],
        ]);

        $content = BlogContent::sanitizeHtml($validated['content']);

        if (!BlogContent::hasMeaningfulContent($content)) {
            return back()
                ->withErrors(['content' => 'Blog content cannot be empty.'])
                ->withInput();
        }

        $imagePath = $blog->image_path;
        if ($request->hasFile('image')) {
            $this->deleteBlogImage($blog->image_path);
            $imagePath = $this->storeBlogImage($request->file('image'));
        }

        $categoryName = trim((string) ($validated['category'] ?? ''));
        $blogCategory = $categoryName !== ''
            ? BlogCategory::firstOrCreate(['name' => $categoryName])
            : null;

        $blog->update([
            'title'      => $validated['title'],
            'slug'       => Str::slug($validated['title']),
            'excerpt'    => $validated['excerpt'],
            'category'   => $categoryName !== '' ? $categoryName : null,
            'blog_category_id' => $blogCategory?->id,
            'content'    => $content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->deleteBlogImage($blog->image_path);

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted.');
    }

    private function storeBlogImage(UploadedFile $image): string
    {
        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $relativePath = 'blogs/' . $filename;

        File::ensureDirectoryExists(public_path('storage/blogs'));
        $image->move(public_path('storage/blogs'), $filename);

        return $relativePath;
    }

    private function deleteBlogImage(?string $imagePath): void
    {
        if (!$imagePath) {
            return;
        }

        Storage::disk('public')->delete($imagePath);

        $publicPath = public_path('storage/' . ltrim($imagePath, '/'));
        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }
    }
}
