<?php

namespace App\Models;

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
        'content',
        'image_path',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getReadingTimeAttribute(): int
    {
        $text = '';
        if (is_array($this->content)) {
            foreach ($this->content as $block) {
                $text .= ' ' . ($block['header'] ?? '');
                $text .= ' ' . ($block['subheader'] ?? '');
                $text .= ' ' . ($block['content'] ?? '');
            }
        }
        $words = str_word_count(strip_tags(trim($text)));
        return (int) ceil($words / 200) ?: 1;
    }
}