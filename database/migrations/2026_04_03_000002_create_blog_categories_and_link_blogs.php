<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('blog_category_id')
                ->nullable()
                ->after('category')
                ->constrained('blog_categories')
                ->nullOnDelete();
        });

        DB::table('blogs')
            ->select('id', 'category')
            ->whereNotNull('category')
            ->orderBy('id')
            ->chunkById(100, function ($blogs): void {
                foreach ($blogs as $blog) {
                    $name = trim((string) $blog->category);

                    if ($name === '') {
                        continue;
                    }

                    $existing = DB::table('blog_categories')->where('name', $name)->value('id');

                    if (!$existing) {
                        $existing = DB::table('blog_categories')->insertGetId([
                            'name' => $name,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    DB::table('blogs')
                        ->where('id', $blog->id)
                        ->update(['blog_category_id' => $existing]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['blog_category_id']);
            $table->dropColumn('blog_category_id');
        });

        Schema::dropIfExists('blog_categories');
    }
};
