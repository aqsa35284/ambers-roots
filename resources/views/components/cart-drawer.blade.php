<!-- Slide-out Cart Drawer -->
<div class="rm-cart-drawer-backdrop" id="rmCartDrawer" aria-hidden="true">
    <div class="rm-cart-drawer">
        <!-- Header -->
        <div class="rm-cart-header">
            <div class="rm-cart-title">
                <i class="fa-solid fa-bag-shopping" style="color: var(--rm-gold-primary);"></i>
                <span>Your Shopping Bag</span>
            </div>
            <button type="button" class="rm-modal-close-btn" data-close-cart aria-label="Close cart">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Free Shipping Progress -->
        <div class="rm-cart-free-shipping">
            <div style="display: flex; justify-content: space-between; font-weight: 600;">
                <span>🎉 Qualified for <strong>FREE DOORSTEP DELIVERY</strong>!</span>
            </div>
            <div class="rm-shipping-bar">
                <div class="rm-shipping-fill" style="width: 100%;"></div>
            </div>
        </div>

        <!-- Cart Items List (Dynamically populated by RivaajCart) -->
        <div class="rm-cart-items-wrap">
            <!-- Items rendered via RivaajCart in rivaaj-main.js -->
        </div>

        <!-- Footer / Subtotal, Full Page Link & Checkout -->
        <div class="rm-cart-footer">
            <div class="rm-cart-subtotal-row">
                <span>Subtotal</span>
                <span class="rm-cart-subtotal-val">Rs. 0</span>
            </div>

            <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-shield-halved" style="color: #10b981;"></i>
                <span>Free Doorstep Cash on Delivery All Across Pakistan</span>
            </div>

            <!-- View Full Cart Page Button -->
            <a href="{{ url('/cart') }}" class="rm-btn-secondary" style="width: 100%; justify-content: center; padding: 12px; font-size: 0.9rem; font-weight: 700;">
                <i class="fa-solid fa-eye"></i>
                <span>View Full Cart Page</span>
            </a>

            <!-- Proceed to Checkout Direct -->
            <button type="button" class="rm-btn-checkout" onclick="window.location.href='{{ url('/checkout') }}'">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Proceed to Checkout (COD)</span>
            </button>

            <!-- Direct WhatsApp Order -->
            <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello Amber\'s Roots! I would like to order my selected hair care items with Cash on Delivery.') }}" 
               target="_blank" 
               class="rm-btn-wa-drawer" 
               style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #ffffff; font-weight: 700; border-radius: 9999px; text-decoration: none; font-size: 0.92rem; margin-top: 8px; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3); transition: transform 0.2s ease;">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.25rem;"></i>
                <span>Order via WhatsApp (COD)</span>
            </a>
        </div>
    </div>
</div>
