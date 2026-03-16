<?php

namespace App\Http\Controllers;

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
        $categories = Product::distinct()->pluck('category')->sort()->values();

        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products  = $query->latest()->paginate(12)->withQueryString();
        $branchId  = $this->getCustomerBranchId();

        return view('products.index', compact('products', 'categories', 'branchId'));
    }

    public function show(Product $product): View
    {
        $branchId = $this->getCustomerBranchId();

        return view('products.show', compact('product', 'branchId'));
    }
}