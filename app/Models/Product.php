<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded(['id'])]
class Product extends Model
{
    /** Storefront categories, as the shop filters and product page name them. */
    public const CATEGORIES = [
        'saree' => 'Saree',
        'ready-to-wear' => 'Ready to Wear Saree',
        'lehenga' => 'Lehenga',
        'lacha' => 'Lacha',
        'dhawani' => 'Dhawani Set',
        'gown' => 'Gown',
        'salwar' => 'Salwar Suit',
        'frock' => 'Frock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'gallery' => 'array',
            'card_layers' => 'array',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class)->withPivot('position');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function image(): ?string
    {
        return $this->gallery[0] ?? $this->card_layers[0]['src'] ?? null;
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucwords(str_replace('-', ' ', $this->category));
    }

    /** The js/products.js entry the storefront scripts read (product page, cart, checkout). */
    public function toCatalogue(): array
    {
        return [
            'title' => $this->page_title ?: $this->title,
            'price' => inr($this->price),
            'sku' => $this->sku,
            'alt' => $this->alt ?? $this->title,
            'gallery' => $this->gallery,
            'category' => $this->category,
            'color' => (string) $this->color,
            'pattern' => (string) $this->pattern,
            'fabric' => (string) $this->fabric,
            'blouse' => (string) $this->blouse,
            'occasion' => (string) $this->occasion,
            'details' => [
                'product' => (string) $this->product_details,
                'design' => (string) $this->design_details,
                'care' => (string) $this->material_care,
            ],
            'stock' => $this->stock,
        ];
    }
}
