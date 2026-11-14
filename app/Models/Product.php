<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'category',
        'category_name',
        'volume',
        'price',
        'original_price',
        'discount',
        'discount_percent',
        'discount_active',
        'discount_expires_at',
        'rating',
        'reviews_count',
        'badge',
        'icon',
        'image',
        'gallery',
        'short_desc',
        'ingredients',
        'how_to_use',
        'benefits',
        'stock',
        'is_active',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'stock' => 'integer',
        'reviews_count' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'discount_active' => 'boolean',
        'discount_percent' => 'integer',
        'display_order' => 'integer',
        'discount_expires_at' => 'datetime',
    ];

    /**
     * Scope only active products for customer-facing store.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Approved reviews relation.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    /**
     * Calculate display price based on discount rules.
     */
    public function getEffectivePriceAttribute(): float
    {
        if ($this->hasActiveDiscount() && $this->discount_percent > 0 && $this->original_price) {
            return round((float)$this->original_price * (1 - ($this->discount_percent / 100)));
        }
        return (float)$this->price;
    }

    /**
     * Check if discount is currently active and not expired.
     */
    public function hasActiveDiscount(): bool
    {
        if (!$this->discount_active) {
            return false;
        }
        if ($this->discount_expires_at && $this->discount_expires_at->isPast()) {
            return false;
        }
        return ($this->discount_percent > 0 || !empty($this->discount));
    }

    /**
     * Get image URL with fallback to assets/product/1000082361.jpg.
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            return asset($this->image);
        }
        if ($this->category === 'hair-oil' || str_contains($this->slug, 'hair-oil')) {
            return asset('assets/product/1000082361.jpg');
        }
        return asset('assets/product/1000082361.jpg');
    }

    /**
     * Get 4 gallery image URLs for product showcase.
     */
    public function getGalleryImagesAttribute(): array
    {
        if (!empty($this->gallery) && is_array($this->gallery) && count($this->gallery) > 0) {
            return array_values(array_map(function ($img) {
                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                    return $img;
                }
                return asset($img);
            }, $this->gallery));
        }

        return [
            asset('assets/product/1000082361.jpg'),
            asset('assets/product/1000082362.jpg'),
            asset('assets/product/1000082363.jpg'),
            asset('assets/product/1000082365.jpg'),
        ];
    }
}
