<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Get the logged-in customer's assigned branch ID from customer_profiles.
     */
    private function getCustomerBranchId(): ?int
    {
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            return null;
        }

        $profile = DB::table('customer_profiles')
            ->where('user_id', auth()->id())
            ->first();

        return $profile?->selected_branch_id;
    }

    public function index(Request $request): View
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        $query = Product::query()->with(['subcategory:id,name,category_id', 'subcategory.category:id,name']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('category_id', $request->category));
        }

        $products  = $query->latest()->paginate(12)->withQueryString();
        $branchId  = $this->getCustomerBranchId();

        return view('products.index', compact('products', 'categories', 'branchId'));
    }

    public function show(Product $product): View
    {
        $product->load(['subcategory:id,name,category_id', 'subcategory.category:id,name']);
        $branchId = $this->getCustomerBranchId();

        return view('products.show', compact('product', 'branchId'));
    }
}
