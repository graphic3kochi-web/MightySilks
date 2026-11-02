<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Blog extends Model
{
    public const CATEGORIES = ['bridal' => 'Bridal', 'festive' => 'Festive', 'style' => 'Style Guide', 'care' => 'Saree Care', 'trends' => 'Trends'];

    protected function casts(): array
    {
        return [
            'published_on' => 'date',
            'body' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /** The js/blogs.js entry /blog-details renders. */
    public function toScript(): array
    {
        return array_filter([
            'title' => $this->title,
            'tag' => $this->tag,
            'category' => $this->category,
            'date' => $this->published_on->toDateString(),
            'readTime' => $this->read_time,
            'image' => $this->image,
            'alt' => (string) $this->alt,
            'excerpt' => $this->excerpt,
            'shop' => $this->shop_href ? ['label' => $this->shop_label ?: 'Shop Now', 'href' => $this->shop_href] : null,
            'body' => $this->body,
        ], fn ($v) => $v !== null);
    }

    /**
     * The body as the admin editor writes it: "## " a heading, "- " list items, "> " a quote,
     * anything else a paragraph; blank lines separate blocks.
     */
    public function bodyText(): string
    {
        return collect($this->body)->map(fn ($block) => match (true) {
            isset($block['h']) => '## '.$block['h'],
            isset($block['list']) => collect($block['list'])->map(fn ($item) => '- '.$item)->implode("\n"),
            isset($block['quote']) => '> '.$block['quote'],
            default => $block['p'] ?? '',
        })->implode("\n\n");
    }

    public static function parseBody(string $text): array
    {
        $blocks = [];
        foreach (preg_split('/\R\s*\R/', trim(str_replace("\r\n", "\n", $text))) as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            $lines = array_map('trim', explode("\n", $chunk));
            if (str_starts_with($chunk, '## ')) {
                $blocks[] = ['h' => trim(substr($chunk, 3))];
            } elseif (str_starts_with($chunk, '> ')) {
                $blocks[] = ['quote' => trim(substr(implode(' ', $lines), 2))];
            } elseif (collect($lines)->every(fn ($l) => str_starts_with($l, '- '))) {
                $blocks[] = ['list' => array_map(fn ($l) => trim(substr($l, 2)), $lines)];
            } else {
                $blocks[] = ['p' => implode(' ', $lines)];
            }
        }

        return $blocks;
    }
}
