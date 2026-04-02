<?php

namespace App\Models;

use App\Support\BlogContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'category',
        'blog_category_id',
        'content',
        'image_path',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function getCategoryNameAttribute(): ?string
    {
        return $this->blogCategory?->name ?? $this->category;
    }

    public function getEditorContentAttribute(): string
    {
        return BlogContent::normalizeToHtml($this->getRawOriginal('content'));
    }

    public function getRenderedContentAttribute(): string
    {
        return BlogContent::sanitizeHtml(BlogContent::normalizeToHtml($this->getRawOriginal('content')));
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(BlogContent::plainText($this->getRawOriginal('content')));

        return (int) ceil($words / 200) ?: 1;
    }
}
