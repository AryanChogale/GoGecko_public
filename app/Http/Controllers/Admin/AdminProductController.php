<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(): View
    {
        $categories = Product::distinct()->pluck('category')->sort()->values();

        $query = Product::query();

        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        if (request()->filled('category')) {
            $query->where('category', request('category'));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        return view('admin.products.create');
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

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'price'        => $validated['price'],
            'quantity'     => $validated['quantity'],
            'category'     => $validated['category'],
            'sub_category' => $validated['sub_category'],
            'image_path'   => $path,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
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
            'category'     => $validated['category'],
            'sub_category' => $validated['sub_category'],
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
}
