<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchProductController extends Controller
{
    public function index(Request $request): View
    {
        $branchId = auth()->user()->branch_id;
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        $query = Product::query()
            ->with([
                'subcategory:id,name,category_id',
                'subcategory.category:id,name',
                'branchPrices' => fn ($branchPricesQuery) => $branchPricesQuery->where('branch_id', $branchId),
            ]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('category_id', $request->category));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('branch.products.index', compact('products', 'categories', 'branchId'));
    }
}
