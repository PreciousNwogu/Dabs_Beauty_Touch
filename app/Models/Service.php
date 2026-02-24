<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'base_price',
        'discount_price',
        'discount_ends_at',
        'description',
        'image_url',
        'category',
        'is_active',
        'for_kids',
    ];

    protected $casts = [
        'base_price'       => 'decimal:2',
        'discount_price'   => 'decimal:2',
        'discount_ends_at' => 'datetime',
        'is_active'        => 'boolean',
        'for_kids'         => 'boolean',
    ];

    /** True when a discount price is set AND (has no expiry OR expiry is in the future). */
    public function getIsDiscountActiveAttribute(): bool
    {
        if ($this->discount_price === null || $this->discount_price >= $this->base_price) {
            return false;
        }
        return $this->discount_ends_at === null || $this->discount_ends_at->isFuture();
    }

    /** Effective price: discount if active, otherwise base. */
    public function getEffectivePriceAttribute(): float
    {
        return $this->is_discount_active ? (float) $this->discount_price : (float) $this->base_price;
    }

    /** True when a discount is active (alias for backwards compat). */
    public function getHasDiscountAttribute(): bool
    {
        return $this->is_discount_active;
    }

    /** Generate a URL-friendly slug from a name. */
    public static function makeSlug(string $name): string
    {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($name)));
    }
}
