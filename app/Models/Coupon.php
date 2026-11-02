<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Coupon extends Model
{
    protected function casts(): array
    {
        return [
            'min_subtotal' => 'decimal:2',
            'expires_at' => 'date',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /** Why the coupon can't be used on this subtotal, or null when it can. */
    public function problemFor(float $subtotal): ?string
    {
        return match (true) {
            ! $this->is_active => 'That code isn\'t active.',
            $this->expires_at && $this->expires_at->endOfDay()->isPast() => 'That code has expired.',
            $this->max_uses !== null && $this->used_count >= $this->max_uses => 'That code has been fully used.',
            $subtotal < (float) $this->min_subtotal => 'That code needs an order of at least '.inr($this->min_subtotal).'.',
            default => null,
        };
    }

    /** The coupon offered in the cart drawer and accepted at checkout by js/main.js. */
    public static function featured(): ?self
    {
        return static::where('is_featured', true)->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhereDate('expires_at', '>=', now()))
            ->first();
    }
}
