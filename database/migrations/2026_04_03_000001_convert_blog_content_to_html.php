<?php

use App\Support\BlogContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });

        DB::table('blogs')
            ->select('id', 'content')
            ->orderBy('id')
            ->chunkById(100, function ($blogs): void {
                foreach ($blogs as $blog) {
                    DB::table('blogs')
                        ->where('id', $blog->id)
                        ->update([
                            'content' => BlogContent::sanitizeHtml(
                                BlogContent::normalizeToHtml($blog->content)
                            ),
                        ]);
                }
            });
    }

    public function down(): void
    {
        DB::table('blogs')
            ->select('id', 'content')
            ->orderBy('id')
            ->chunkById(100, function ($blogs): void {
                foreach ($blogs as $blog) {
                    $content = trim(strip_tags((string) $blog->content));

                    DB::table('blogs')
                        ->where('id', $blog->id)
                        ->update([
                            'content' => json_encode([[
                                'header' => '',
                                'subheader' => '',
                                'content' => $content,
                            ]], JSON_UNESCAPED_UNICODE),
                        ]);
                }
            });

        Schema::table('blogs', function (Blueprint $table) {
            $table->json('content')->nullable()->change();
        });
    }
};
