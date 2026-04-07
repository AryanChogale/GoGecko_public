<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'subcategory_id',
        'image_path',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function branchPrices(): HasMany
    {
        return $this->hasMany(BranchProductPrice::class);
    }

    /**
     * Get the price for a specific branch.
     * Falls back to global products.price if no branch-specific price is set.
     */
    public function priceForBranch(?int $branchId): float
    {
        if (!$branchId) {
            return (float) $this->price;
        }

        if ($this->relationLoaded('branchPrices')) {
            $branchPrice = $this->branchPrices->firstWhere('branch_id', $branchId);

            return $branchPrice ? (float) $branchPrice->price : (float) $this->price;
        }

        $branchPrice = $this->branchPrices()
            ->where('branch_id', $branchId)
            ->first();

        return $branchPrice ? (float) $branchPrice->price : (float) $this->price;
    }
}
