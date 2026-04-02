<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        $query = Product::query()->with(['subcategory:id,name,category_id', 'subcategory.category:id,name']);

        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        if (request()->filled('category')) {
            $query->whereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('category_id', request('category')));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categoryOptions = $this->categoryOptions();

        return view('admin.products.create', compact('categoryOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'price'        => ['required', 'numeric', 'min:0'],
            'quantity'     => ['required', 'integer', 'min:0'],
            'category'     => ['required', 'string', 'max:255'],
            'sub_category' => ['required', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'max:2048'],
        ]);

        $category = Category::firstOrCreate([
            'name' => trim($validated['category']),
        ]);

        $subcategory = Subcategory::firstOrCreate([
            'category_id' => $category->id,
            'name' => trim($validated['sub_category']),
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'price'        => $validated['price'],
            'quantity'     => $validated['quantity'],
            'subcategory_id' => $subcategory->id,
            'image_path'   => $path,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $product->load(['subcategory:id,name,category_id', 'subcategory.category:id,name']);
        $categoryOptions = $this->categoryOptions();

        return view('admin.products.edit', compact('product', 'categoryOptions'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'price'        => ['required', 'numeric', 'min:0'],
            'quantity'     => ['required', 'integer', 'min:0'],
            'category'     => ['required', 'string', 'max:255'],
            'sub_category' => ['required', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'max:2048'],
        ]);

        $category = Category::firstOrCreate([
            'name' => trim($validated['category']),
        ]);

        $subcategory = Subcategory::firstOrCreate([
            'category_id' => $category->id,
            'name' => trim($validated['sub_category']),
        ]);

        $path = $product->image_path;
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'price'        => $validated['price'],
            'quantity'     => $validated['quantity'],
            'subcategory_id' => $subcategory->id,
            'image_path'   => $path,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function categoryOptions(): array
    {
        return Category::query()
            ->with(['subcategories:id,category_id,name'])
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Category $category) => [
                'name' => $category->name,
                'subcategories' => $category->subcategories
                    ->pluck('name')
                    ->sort()
                    ->values()
                    ->all(),
            ])
            ->all();
    }
}
