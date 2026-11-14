<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function isValidForAmount(float $subtotal): bool
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->min_order_amount > 0 && $subtotal < $this->min_order_amount) {
            return false;
        }
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (!$this->isValidForAmount($subtotal)) {
            return 0.0;
        }
        if ($this->discount_type === 'percentage') {
            return round($subtotal * ($this->discount_value / 100), 2);
        }
        return min((float)$this->discount_value, $subtotal);
    }
}
