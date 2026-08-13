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
        'use_as_category_card',
        'category',
        'is_active',
        'for_kids',
        'has_length',
        'has_tip_finish',
        'has_row_options',
        'has_eight_to_ten_rows',
        'has_fifteen_plus_rows',
        'eight_to_ten_rows_price',
        'ten_plus_rows_price',
        'fifteen_plus_rows_price',
        'duration',
        'size_options',
    ];

    protected $casts = [
        'base_price'       => 'decimal:2',
        'discount_price'   => 'decimal:2',
        'discount_ends_at' => 'datetime',
        'is_active'        => 'boolean',
        'for_kids'         => 'boolean',
        'use_as_category_card' => 'boolean',
        'has_length'       => 'boolean',
        'has_tip_finish'   => 'boolean',
        'has_row_options'  => 'boolean',
        'has_eight_to_ten_rows' => 'boolean',
        'has_fifteen_plus_rows' => 'boolean',
        'eight_to_ten_rows_price' => 'decimal:2',
        'ten_plus_rows_price' => 'decimal:2',
        'fifteen_plus_rows_price' => 'decimal:2',
        'size_options'     => 'array',
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
