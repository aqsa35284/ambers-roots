@extends('layouts.app')

@section('title', "Your Cart – Amber's Roots")

@section('content')
<!-- Page Header (Exact Match to Screenshot) -->
<div class="an-cart-header-wrap">
    <div class="an-cart-breadcrumbs">
        <a href="{{ url('/') }}">HOME</a> &nbsp;/&nbsp; <span>CART</span>
    </div>
    <h1 class="an-cart-page-title">Your Cart</h1>
</div>

<!-- Main Cart Container -->
<section class="an-cart-section">
    
    <!-- Empty Cart State -->
    <div id="fullCartEmpty" style="display: none;" class="an-cart-empty-box">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #f3f4f6; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 2.2rem;">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <h2 style="font-size: 1.6rem; font-weight: 700; color: #111827; margin-bottom: 8px;">Your Cart is Empty</h2>
        <p style="color: #6b7280; font-size: 0.95rem; margin-bottom: 24px;">Browse our herbal hair formulations and add products to your cart.</p>
        <a href="{{ url('/products') }}" class="an-btn-checkout" style="display: inline-block; width: auto; padding: 12px 28px; text-decoration: none;">
            Start Shopping &rarr;
        </a>
    </div>

    <!-- Active Cart Layout (2 Columns: Left Items, Right Black Order Summary) -->
    <div id="fullCartActive" class="an-cart-layout">
        
        <!-- LEFT COLUMN: Cart Items List -->
        <div class="an-cart-items-column">
            <div id="fullCartItemsContainer" style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Populated dynamically via JavaScript -->
            </div>
        </div>

        <!-- RIGHT COLUMN: Dark Order Summary Box (Exact Match to Screenshot) -->
        <div class="an-cart-summary-column">
            <div class="an-order-summary-box">
                <h3 class="an-summary-heading">Order Summary</h3>

                <div class="an-summary-line">
                    <span>Subtotal</span>
                    <span id="fullCartSubtotal" class="an-summary-val">Rs. 0</span>
                </div>

                <div class="an-summary-line">
                    <span>Shipping</span>
                    <span class="an-summary-val" style="color: #9ca3af;">Free</span>
                </div>

                <div class="an-summary-total-line">
                    <span>Total</span>
                    <span id="fullCartTotal" class="an-summary-total-val">Rs. 0</span>
                </div>

                <!-- Green Proceed to Checkout Button -->
                <button type="button" class="an-btn-checkout" onclick="window.location.href='{{ url('/checkout') }}'">
                    Proceed to Checkout (COD) &rarr;
                </button>

                <!-- Direct WhatsApp Order Button -->
                <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello Amber\'s Roots! I would like to order my selected hair care items with Cash on Delivery.') }}" 
                   target="_blank" 
                   class="an-btn-wa-order"
                   style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #ffffff; font-weight: 700; border-radius: 6px; text-decoration: none; font-size: 0.92rem; margin-top: 10px; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.25rem;"></i> Order via WhatsApp (COD)
                </a>

                <!-- Continue Shopping Link -->
                <a href="{{ url('/products') }}" class="an-continue-shopping-link">
                    CONTINUE SHOPPING
                </a>

                <!-- Free Delivery Note -->
                <div class="an-delivery-note">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a; margin-right: 4px;"></i> Free Doorstep Delivery Across Pakistan &bull; Cash on Delivery
                </div>
            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
/* ==========================================================================
   AL NOOR / SCREENSHOT INSPIRED CART STYLING
   ========================================================================== */
.an-cart-header-wrap {
    padding: 50px 20px 30px;
    text-align: center;
    background: #ffffff;
}

.an-cart-breadcrumbs {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    color: #9ca3af;
    margin-bottom: 12px;
    text-transform: uppercase;
}

.an-cart-breadcrumbs a {
    color: #6b7280;
    text-decoration: none;
}

.an-cart-breadcrumbs a:hover {
    color: #111827;
}

.an-cart-page-title {
    font-family: var(--rm-font-sans), system-ui, -apple-system, sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
    letter-spacing: -0.02em;
}

.an-cart-section {
    max-width: 1140px;
    margin: 0 auto;
    padding: 10px 24px 80px;
}

.an-cart-layout {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 40px;
    align-items: start;
}

/* Cart Item Card (White rectangular box with subtle border) */
.an-cart-item-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    padding: 20px;
    display: flex;
    gap: 20px;
    transition: box-shadow 0.2s ease;
}

.an-cart-item-card:hover {
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
}

.an-cart-item-img {
    width: 76px;
    height: 76px;
    border: 1px solid #f1f5f9;
    background: #fdfaf6;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rm-gold-dark);
    font-size: 2.2rem;
    flex-shrink: 0;
}

.an-cart-item-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.an-cart-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
}

.an-cart-item-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 4px 0;
    line-height: 1.3;
}

.an-cart-item-meta {
    font-size: 0.75rem;
    font-weight: 500;
    color: #888888;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 14px;
}

.an-cart-item-price {
    font-size: 1.05rem;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
}

.an-cart-item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}

/* Quantity Box: [- 1 +] */
.an-qty-box {
    display: inline-flex;
    align-items: center;
    border: 1px solid #d1d5db;
    border-radius: 3px;
    background: #ffffff;
    height: 34px;
}

.an-qty-btn {
    width: 32px;
    height: 100%;
    border: none;
    background: none;
    font-size: 1rem;
    color: #374151;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s ease;
}

.an-qty-btn:hover {
    background: #f3f4f6;
    color: #111827;
}

.an-qty-val {
    width: 36px;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    color: #111827;
}

.an-remove-btn {
    background: none;
    border: none;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    color: #6b7280;
    text-decoration: underline;
    cursor: pointer;
    padding: 4px 0;
    transition: color 0.15s ease;
}

.an-remove-btn:hover {
    color: #dc2626;
}

/* RIGHT COLUMN: Dark Order Summary Box (Screenshot Replica) */
.an-order-summary-box {
    background: #141618;
    color: #ffffff;
    border-radius: 4px;
    padding: 30px 26px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.an-summary-heading {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 20px 0;
    letter-spacing: -0.01em;
}

.an-summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9375rem;
    color: #9ca3af;
    margin-bottom: 14px;
}

.an-summary-val {
    color: #ffffff;
    font-weight: 500;
}

.an-summary-total-line {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    border-top: 1px solid #282b30;
    padding-top: 18px;
    margin-top: 18px;
    margin-bottom: 24px;
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
}

.an-summary-total-val {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
}

/* Green Proceed to Checkout Button */
.an-btn-checkout {
    display: block;
    width: 100%;
    padding: 14px;
    background: #275a36;
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.1s ease;
}

.an-btn-checkout:hover {
    background: #1f492b;
}

.an-continue-shopping-link {
    display: block;
    text-align: center;
    margin-top: 18px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    color: #9ca3af;
    text-decoration: none;
    transition: color 0.15s ease;
}

.an-continue-shopping-link:hover {
    color: #ffffff;
}

.an-delivery-note {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 26px;
    line-height: 1.4;
}

/* Empty Box */
.an-cart-empty-box {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

/* Floating WhatsApp Button */
.an-floating-whatsapp {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #25D366;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.85rem;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4);
    z-index: 1000;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none;
}

.an-floating-whatsapp:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.55);
}

@media (max-width: 900px) {
    .an-cart-layout {
        grid-template-columns: 1fr;
        gap: 28px;
    }
}

@media (max-width: 600px) {
    .an-cart-header-wrap {
        padding: 30px 14px 20px;
    }
    .an-cart-page-title {
        font-size: 1.85rem;
    }
    .an-cart-section {
        padding: 10px 12px 50px;
    }
    .an-cart-item-card {
        padding: 14px;
        gap: 12px;
    }
    .an-cart-item-img {
        width: 60px;
        height: 60px;
        font-size: 1.7rem;
    }
    .an-order-summary-box {
        padding: 20px 16px;
    }
}

/* Small Phones (<= 380px) */
@media (max-width: 380px) {
    .an-cart-header-wrap {
        padding: 20px 8px 12px;
    }
    .an-cart-page-title {
        font-size: 1.45rem;
    }
    .an-cart-breadcrumbs {
        font-size: 0.65rem;
    }
    .an-cart-section {
        padding: 6px 6px 40px;
    }
    .an-cart-item-card {
        padding: 10px;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .an-cart-item-img {
        width: 50px;
        height: 50px;
        font-size: 1.4rem;
    }
    .an-cart-item-header {
        flex-direction: column;
        gap: 4px;
    }
    .an-cart-item-title {
        font-size: 0.95rem;
    }
    .an-cart-item-price {
        font-size: 1rem;
    }
    .an-cart-item-footer {
        flex-wrap: wrap;
        gap: 8px;
    }
    .an-order-summary-box {
        padding: 16px 12px;
    }
    .an-summary-heading {
        font-size: 1.25rem;
    }
    .an-btn-checkout {
        padding: 11px;
        font-size: 0.9rem;
    }
    .an-floating-whatsapp {
        width: 44px;
        height: 44px;
        font-size: 1.4rem;
        bottom: 14px;
        right: 14px;
    }
}

/* Micro screens (220px - 280px) */
@media (max-width: 280px) {
    .an-cart-page-title {
        font-size: 1.25rem;
    }
    .an-qty-box {
        height: 28px;
    }
    .an-qty-btn {
        width: 24px;
        font-size: 0.85rem;
    }
    .an-qty-val {
        width: 26px;
        font-size: 0.8rem;
    }
    .an-remove-btn {
        font-size: 0.7rem;
    }
}

/* Ultrawide 2K / 4K Monitors (up to 3000px) */
@media (min-width: 1800px) {
    .an-cart-section {
        max-width: 1440px;
    }
    .an-cart-layout {
        gap: 50px;
    }
    .an-cart-page-title {
        font-size: 2.8rem;
    }
}

@media (min-width: 2400px) {
    .an-cart-section {
        max-width: 1750px;
    }
    .an-cart-page-title {
        font-size: 3.4rem;
    }
    .an-cart-item-title {
        font-size: 1.3rem;
    }
    .an-cart-item-price {
        font-size: 1.35rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        renderAlNoorCartView();

        window.addEventListener('cart-updated', () => {
            renderAlNoorCartView();
        });
    });

    function renderAlNoorCartView() {
        const cart = window.RivaajCart ? window.RivaajCart.getCart() : [];
        const emptyBox = document.getElementById('fullCartEmpty');
        const activeLayout = document.getElementById('fullCartActive');
        const container = document.getElementById('fullCartItemsContainer');
        const subtotalEl = document.getElementById('fullCartSubtotal');
        const totalEl = document.getElementById('fullCartTotal');

        if (!cart || cart.length === 0) {
            if (emptyBox) emptyBox.style.display = 'block';
            if (activeLayout) activeLayout.style.display = 'none';
            return;
        }

        if (emptyBox) emptyBox.style.display = 'none';
        if (activeLayout) activeLayout.style.display = 'grid';

        let totalSum = 0;

        if (container) {
            container.innerHTML = '';
            cart.forEach((item, index) => {
                const numericPrice = parseInt(item.price.toString().replace(/[^0-9]/g, '')) || 0;
                const itemQty = parseInt(item.quantity) || 1;
                const itemTotal = numericPrice * itemQty;
                totalSum += itemTotal;
                const itemImg = item.image || ((item.title && item.title.toLowerCase().includes('shampoo')) ? '/assets/product/1000082362.jpg' : '/assets/product/1000082361.jpg');
                const safeTitle = (item.title || '').replace(/"/g, '&quot;');

                const card = document.createElement('div');
                card.className = 'an-cart-item-card';
                card.innerHTML = `
                    <!-- Left: Square Thumbnail -->
                    <a href="/product/${item.slug || 'rivaaj-mahal-hair-oil'}" class="an-cart-item-img" style="text-decoration: none; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #faf8f5;">
                        <img src="${itemImg}" alt="${safeTitle}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;" onerror="this.onerror=null; this.src='/assets/product/1000082361.jpg';">
                    </a>

                    <!-- Middle & Right Content -->
                    <div class="an-cart-item-content">
                        <div class="an-cart-item-header">
                            <div>
                                <h3 class="an-cart-item-title">
                                    <a href="/product/${item.slug || 'rivaaj-mahal-hair-oil'}" style="color: inherit; text-decoration: none;">
                                        ${item.title}
                                    </a>
                                </h3>
                                <div class="an-cart-item-meta">
                                    ${itemQty > 1 ? itemQty + ' BOTTLES' : '1 BOTTLE'} &bull; SAVE RS. 200
                                </div>
                            </div>
                            <div class="an-cart-item-price">
                                Rs. ${itemTotal.toLocaleString()}
                            </div>
                        </div>

                        <div class="an-cart-item-footer">
                            <!-- Quantity Box: [- 1 +] -->
                            <div class="an-qty-box">
                                <button type="button" class="an-qty-btn" aria-label="Decrease quantity" onclick="window.RivaajCart.updateQuantityByIndex(${index}, ${itemQty - 1})">-</button>
                                <span class="an-qty-val">${itemQty}</span>
                                <button type="button" class="an-qty-btn" aria-label="Increase quantity" onclick="window.RivaajCart.updateQuantityByIndex(${index}, ${itemQty + 1})">+</button>
                            </div>

                            <!-- REMOVE link -->
                            <button type="button" class="an-remove-btn" aria-label="Remove item" onclick="window.RivaajCart.removeItemByIndex(${index})">
                                REMOVE
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        if (subtotalEl) subtotalEl.textContent = 'Rs. ' + totalSum.toLocaleString();
        if (totalEl) totalEl.textContent = 'Rs. ' + totalSum.toLocaleString();
    }
</script>
@endpush
@endsection
