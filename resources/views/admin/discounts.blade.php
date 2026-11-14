@extends('layouts.dashboard')

@section('title', 'Discount Management')
@section('header_title', 'Dynamic Discount & Promotion Management')
@section('header_subtitle', 'Manage product discount offers, sale badges, expiry dates, and coupon codes')

@section('content')

<!-- Metrics Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 1.3rem;">
            <i class="fa-solid fa-percent"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Active Discount Offers</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">{{ $activeDiscountsCount }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; font-size: 1.3rem;">
            <i class="fa-solid fa-ticket"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Active Promo Coupons</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #34d399; font-family: 'Cinzel', serif;">{{ $activeCouponsCount }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); display: flex; align-items: center; justify-content: center; color: #f87171; font-size: 1.3rem;">
            <i class="fa-solid fa-fire"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Landing Page Offer</div>
            @php
                $activeHairOil = $products->firstWhere('slug', 'rivaaj-mahal-hair-oil') ?? $products->first();
            @endphp
            <div style="font-size: 1.3rem; font-weight: 800; color: #f87171; font-family: 'Cinzel', serif;">
                {{ $activeHairOil?->discount_percent ? $activeHairOil->discount_percent . '% OFF' : ($activeHairOil?->discount ?? '23% OFF') }}
            </div>
        </div>
    </div>
</div>

<!-- Notice Banner -->
<div style="background: rgba(223, 194, 133, 0.08); border: 1px solid rgba(223, 194, 133, 0.25); border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 14px;">
    <i class="fa-solid fa-lightbulb" style="color: var(--db-gold); font-size: 1.4rem;"></i>
    <div style="font-size: 0.85rem; color: #e2e8f0;">
        <strong style="color: var(--db-gold);">Instant Landing Page Sync:</strong>
        When you update the discount % on the active product below, the discount offer badge on the customer landing page automatically updates instantly!
    </div>
</div>

<!-- Product Discounts Table -->
<div class="db-panel" style="margin-bottom: 30px;">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-tags"></i> Product Discount Configuration
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Set percentage (%) discounts and expiry dates for each formulation
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Original Price</th>
                    <th>Discount %</th>
                    <th>Discounted Price</th>
                    <th>Discount Status</th>
                    <th>Expiry Date</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $prod)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: #faf5ee; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(223, 194, 133, 0.3);">
                                    <img src="{{ $prod->image_url }}" alt="{{ $prod->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #fff;">{{ $prod->title }}</div>
                                    <div style="font-size: 0.72rem; color: var(--db-gold);">
                                        {{ $prod->is_active ? 'Live on Store' : 'Inactive in Catalog' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.9rem; color: #94a3b8; text-decoration: line-through;">
                                Rs. {{ number_format($prod->original_price ?? ($prod->price * 1.25)) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.discounts.update', $prod->id) }}" method="POST" id="form-discount-{{ $prod->id }}" style="margin: 0; display: flex; align-items: center; gap: 6px;">
                                @csrf
                                <input type="number" name="discount_percent" value="{{ $prod->discount_percent ?? 20 }}" min="0" max="90" class="db-form-input" style="width: 80px; padding: 6px 8px; font-size: 0.9rem; text-align: center; font-weight: 700; color: #f87171;" required>
                                <span style="color: #cbd5e1; font-weight: 700;">%</span>
                        </td>
                        <td>
                            <strong style="color: #34d399; font-family: 'Cinzel', serif; font-size: 1rem;">
                                Rs. {{ number_format($prod->effective_price) }}
                            </strong>
                        </td>
                        <td>
                                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; color: #e2e8f0; font-size: 0.8rem;">
                                    <input type="checkbox" name="discount_active" value="1" {{ $prod->discount_active ? 'checked' : '' }} style="accent-color: var(--db-gold); width: 16px; height: 16px;">
                                    <span>{{ $prod->discount_active ? 'Active (ON)' : 'Paused (OFF)' }}</span>
                                </label>
                        </td>
                        <td>
                                <input type="date" name="discount_expires_at" value="{{ $prod->discount_expires_at ? $prod->discount_expires_at->format('Y-m-d') : '' }}" class="db-form-input" style="padding: 5px 8px; font-size: 0.8rem; width: 140px;">
                        </td>
                        <td style="text-align: right;">
                                <button type="submit" class="btn-db btn-db-gold" style="padding: 6px 14px; font-size: 0.8rem;">
                                    <i class="fa-solid fa-floppy-disk"></i> Save Offer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Coupons Management Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-ticket"></i> Promotional Coupon Codes (Checkout Discounts)
        </div>
        <button type="button" class="btn-db btn-db-gold" onclick="openAddCouponModal()">
            <i class="fa-solid fa-plus"></i> Create New Coupon
        </button>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Coupon Code</th>
                    <th>Discount Type</th>
                    <th>Discount Amount</th>
                    <th>Min. Order Amount</th>
                    <th>Status</th>
                    <th>Expires On</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $c)
                    <tr>
                        <td>
                            <strong style="color: var(--db-gold); font-family: monospace; font-size: 1rem; letter-spacing: 0.05em; background: rgba(223, 194, 133, 0.1); padding: 4px 10px; border-radius: 4px; border: 1px dashed var(--db-gold);">
                                {{ $c->code }}
                            </strong>
                        </td>
                        <td>
                            <span style="text-transform: capitalize; color: #cbd5e1; font-size: 0.85rem;">{{ $c->discount_type }}</span>
                        </td>
                        <td>
                            <strong style="color: #34d399; font-size: 0.95rem;">
                                {{ $c->discount_type === 'percentage' ? $c->discount_value . '% OFF' : 'Rs. ' . number_format($c->discount_value) . ' OFF' }}
                            </strong>
                        </td>
                        <td>
                            <span style="color: #94a3b8; font-size: 0.82rem;">
                                {{ $c->min_order_amount > 0 ? 'Rs. ' . number_format($c->min_order_amount) : 'No Minimum' }}
                            </span>
                        </td>
                        <td>
                            @if($c->is_active && (!$c->expires_at || $c->expires_at->isFuture()))
                                <span class="status-badge badge-active"><i class="fa-solid fa-circle-check"></i> Active</span>
                            @else
                                <span class="status-badge badge-kicked"><i class="fa-solid fa-ban"></i> Expired</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.8rem; color: #94a3b8;">
                                {{ $c->expires_at ? $c->expires_at->format('d M Y') : 'Never' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <form action="{{ route('admin.coupons.delete', $c->id) }}" method="POST" style="margin: 0;" data-confirm="Are you sure you want to delete coupon code {{ $c->code }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-db btn-db-outline" style="color: #f87171; border-color: rgba(239, 68, 68, 0.3); padding: 5px 10px;" title="Delete Coupon">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--db-text-dim); padding: 32px;">
                            No coupon codes configured yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Coupon -->
<div class="db-modal-backdrop" id="addCouponModal">
    <div class="db-modal-dialog" style="max-width: 500px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.25rem; font-family: 'Cinzel', serif;">
                <i class="fa-solid fa-plus-circle"></i> Create New Promo Coupon
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeAddCouponModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="db-form-group">
                <label class="db-form-label" for="c_code">Coupon Code *</label>
                <input type="text" name="code" id="c_code" class="db-form-input" placeholder="e.g. AMBERS10, AZADI20" style="text-transform: uppercase;" required>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="c_type">Discount Type *</label>
                    <select name="discount_type" id="c_type" class="db-form-select" required>
                        <option value="percentage">Percentage (%) OFF</option>
                        <option value="fixed">Fixed Amount (PKR) OFF</option>
                    </select>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="c_val">Discount Value *</label>
                    <input type="number" name="discount_value" id="c_val" class="db-form-input" placeholder="e.g. 10 or 300" min="1" required>
                </div>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="c_min">Min Order Amount (PKR)</label>
                    <input type="number" name="min_order_amount" id="c_min" class="db-form-input" placeholder="0 = No minimum">
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="c_exp">Expiry Date (Optional)</label>
                    <input type="date" name="expires_at" id="c_exp" class="db-form-input">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeAddCouponModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 20px;">
                    <i class="fa-solid fa-check"></i> Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddCouponModal() {
        document.getElementById('addCouponModal').classList.add('is-open');
    }
    function closeAddCouponModal() {
        document.getElementById('addCouponModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection

