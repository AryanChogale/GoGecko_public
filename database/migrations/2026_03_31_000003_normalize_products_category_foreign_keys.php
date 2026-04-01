<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('price');
            $table->foreignId('subcategory_id')->nullable()->after('category_id');
        });

        Product::query()
            ->select('id', 'category', 'sub_category')
            ->orderBy('id')
            ->chunkById(200, function ($products) {
                foreach ($products as $product) {
                    $categoryName = trim((string) $product->category);
                    $subcategoryName = trim((string) $product->sub_category);

                    if ($categoryName === '' || $subcategoryName === '') {
                        continue;
                    }

                    $category = Category::firstOrCreate(['name' => $categoryName]);
                    $subcategory = Subcategory::firstOrCreate([
                        'category_id' => $category->id,
                        'name' => $subcategoryName,
                    ]);

                    Product::query()
                        ->where('id', $product->id)
                        ->update([
                            'category_id' => $category->id,
                            'subcategory_id' => $subcategory->id,
                        ]);
                }
            });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'sub_category']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('subcategory_id');
            $table->string('sub_category')->nullable()->after('category');
        });

        Product::query()
            ->with(['category:id,name', 'subcategory:id,name'])
            ->select('id', 'category_id', 'subcategory_id')
            ->orderBy('id')
            ->chunkById(200, function ($products) {
                foreach ($products as $product) {
                    Product::query()
                        ->where('id', $product->id)
                        ->update([
                            'category' => $product->category?->name,
                            'sub_category' => $product->subcategory?->name,
                        ]);
                }
            });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn(['category_id', 'subcategory_id']);
        });
    }
};
