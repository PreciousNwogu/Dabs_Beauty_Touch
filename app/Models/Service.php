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
        'description',
        'image_url',
        'category',
        'is_active',
    ];

    protected $casts = [
        'base_price'     => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    /** Effective price: discount if set, otherwise base. */
    public function getEffectivePriceAttribute(): float
    {
        return $this->discount_price !== null ? (float) $this->discount_price : (float) $this->base_price;
    }

    /** True when a discount is active. */
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null && $this->discount_price < $this->base_price;
    }

    /** Generate a URL-friendly slug from a name. */
    public static function makeSlug(string $name): string
    {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($name)));
    }
}
