@extends('layouts.app')

@section('title', "Checkout – Amber's Roots")

@section('content')
<!-- Page Header (Luxury Amber's Roots Theme) -->
<div class="an-co-header-wrap">
    <div class="an-co-header-inner">
        <div class="an-co-breadcrumbs">
            <a href="{{ url('/') }}"><i class="fa-solid fa-house" style="font-size: 0.72rem;"></i> HOME</a>
            <span class="an-co-bc-sep"><i class="fa-solid fa-chevron-right"></i></span>
            <a href="{{ url('/cart') }}">CART</a>
            <span class="an-co-bc-sep"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="an-co-bc-current">EXPRESS CHECKOUT</span>
        </div>
        <div class="an-co-badge">
            <i class="fa-solid fa-shield-halved"></i> 256-Bit SSL Encrypted &bull; Official Amber's Roots Store
        </div>
        <h1 class="an-co-title">Express Checkout</h1>
        <p class="an-co-subtitle">
            <span><i class="fa-solid fa-truck-fast text-gold"></i> Free Doorstep Delivery Across Pakistan</span>
            <span class="an-sub-sep">&bull;</span>
            <span><i class="fa-solid fa-hand-holding-dollar text-gold"></i> Cash on Delivery (Pay When You Receive)</span>
        </p>
    </div>
</div>

<!-- Main Checkout Section -->
<section class="an-co-section">
    <!-- Active Checkout Form & Summary Grid -->
    <div id="checkoutMainContainer" class="an-co-layout">
        
        <!-- LEFT COLUMN: Luxury Form Cards -->
        <div class="an-co-left-col">
            <form id="checkoutForm" onsubmit="event.preventDefault(); submitAlNoorOrder();">
                
                <!-- BOX 1: Contact Information -->
                <div class="an-co-card">
                    <div class="an-card-head">
                        <div class="an-step-num"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <h2 class="an-co-card-title">Contact Information</h2>
                            <p class="an-card-desc">We will send your order updates &amp; courier tracking via SMS and WhatsApp.</p>
                        </div>
                    </div>

                    <div class="an-co-row-2">
                        <div class="an-co-field">
                            <label class="an-co-label" for="custName">Full Name <span class="an-req">*</span></label>
                            <div class="an-input-wrap">
                                <i class="fa-regular fa-user an-input-icon"></i>
                                <input type="text" id="custName" class="an-co-input" placeholder="e.g. Muhammad Usman" required>
                            </div>
                        </div>
                        <div class="an-co-field">
                            <label class="an-co-label" for="custPhone">Mobile Number (WhatsApp) <span class="an-req">*</span></label>
                            <div class="an-input-wrap">
                                <i class="fa-solid fa-phone an-input-icon"></i>
                                <input type="tel" id="custPhone" class="an-co-input" placeholder="03XX XXXXXXX" required>
                            </div>
                        </div>
                    </div>

                    <div class="an-co-field" style="margin-top: 14px;">
                        <label class="an-co-label" for="custEmail">Email Address <span class="an-opt">(Optional)</span></label>
                        <div class="an-input-wrap">
                            <i class="fa-regular fa-envelope an-input-icon"></i>
                            <input type="email" id="custEmail" class="an-co-input" placeholder="you@example.com">
                        </div>
                    </div>
                </div>

                <!-- BOX 2: Shipping Address -->
                <div class="an-co-card">
                    <div class="an-card-head">
                        <div class="an-step-num"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h2 class="an-co-card-title">Shipping Address</h2>
                            <p class="an-card-desc">Please enter your complete physical doorstep delivery address in Pakistan.</p>
                        </div>
                    </div>

                    <div class="an-co-field">
                        <label class="an-co-label" for="custAddress">Street Address / House # <span class="an-req">*</span></label>
                        <div class="an-input-wrap">
                            <i class="fa-solid fa-house-chimney an-input-icon"></i>
                            <input type="text" id="custAddress" class="an-co-input" placeholder="House #, Street #, Sector / Colony / Area" required>
                        </div>
                    </div>

                    <div class="an-co-row-2" style="margin-top: 14px;">
                        <div class="an-co-field">
                            <label class="an-co-label" for="custCity">City <span class="an-req">*</span></label>
                            <div class="an-input-wrap">
                                <i class="fa-solid fa-city an-input-icon"></i>
                                <input type="text" id="custCity" class="an-co-input" placeholder="e.g. Lahore, Karachi, Islamabad" required>
                            </div>
                        </div>
                        <div class="an-co-field">
                            <label class="an-co-label" for="custPostal">Postal / ZIP Code <span class="an-opt">(Optional)</span></label>
                            <div class="an-input-wrap">
                                <i class="fa-solid fa-envelopes-bulk an-input-icon"></i>
                                <input type="text" id="custPostal" class="an-co-input" placeholder="e.g. 54000">
                            </div>
                        </div>
                    </div>

                    <div class="an-co-field" style="margin-top: 14px;">
                        <label class="an-co-label" for="custNotes">Delivery Notes / Landmark <span class="an-opt">(Optional)</span></label>
                        <div class="an-input-wrap">
                            <i class="fa-solid fa-clipboard-check an-input-icon"></i>
                            <input type="text" id="custNotes" class="an-co-input" placeholder="Nearby famous landmark, school, bell instructions, etc.">
                        </div>
                    </div>
                </div>

                <!-- BOX 3: Payment Method (Cash on Delivery Only) -->
                <div class="an-co-card" style="margin-bottom: 0;">
                    <div class="an-card-head">
                        <div class="an-step-num"><i class="fa-solid fa-wallet"></i></div>
                        <div>
                            <h2 class="an-co-card-title">Payment Method</h2>
                            <p class="an-card-desc">Safe, secure, and hassle-free payment on delivery.</p>
                        </div>
                    </div>

                    <div class="an-payment-options-grid">
                        <label class="an-pay-box selected" id="optCodLabel">
                            <div class="an-pay-box-header">
                                <div class="an-pay-radio-title">
                                    <input type="radio" name="anPaymentMethod" value="Cash on Delivery" checked class="an-radio-dot">
                                    <span class="an-pay-title">
                                        <i class="fa-solid fa-money-bill-wave text-emerald"></i> Cash on Delivery (COD)
                                    </span>
                                </div>
                                <span class="an-pay-badge"><i class="fa-solid fa-circle-check"></i> Most Popular</span>
                            </div>
                            <div class="an-pay-desc">
                                Pay cash to the courier rider upon parcel arrival at your doorstep anywhere in Pakistan. Open parcel facility allowed for complete peace of mind.
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Hidden form submit trigger -->
                <button type="submit" id="hiddenFormSubmitBtn" style="display: none;"></button>
            </form>
        </div>

        <!-- RIGHT COLUMN: Luxury Order Summary Box (Sticky) -->
        <div class="an-co-right-col">
            <div class="an-co-summary-box">
                <div class="an-summary-head">
                    <h3 class="an-co-summary-title">
                        <i class="fa-solid fa-bag-shopping text-gold"></i> Order Summary
                    </h3>
                    <span id="checkoutItemCountBadge" class="an-item-count-badge">0 Items</span>
                </div>

                <!-- Cart Items Preview List -->
                <div id="checkoutSummaryItems" class="an-co-items-list">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Coupon Promo Code Input -->
                <div class="an-promo-wrap">
                    <div class="an-promo-input-group">
                        <input type="text" id="couponInput" placeholder="Promo code (e.g. AMBERS10)" class="an-promo-input">
                        <button type="button" onclick="applyCouponCode()" class="an-promo-btn">
                            Apply
                        </button>
                    </div>
                    <div id="couponMessage" class="an-promo-msg"></div>
                </div>

                <!-- Cost Breakdown -->
                <div class="an-cost-breakdown">
                    <div class="an-co-summary-row">
                        <span>Subtotal</span>
                        <span id="checkoutSubtotal" class="an-co-summary-val">Rs. 0</span>
                    </div>

                    <div class="an-co-summary-row" id="couponDiscountRow" style="display: none; color: #16a34a;">
                        <span><i class="fa-solid fa-tag"></i> Discount (<span id="appliedCouponCode"></span>)</span>
                        <span id="checkoutDiscount" class="an-co-summary-val" style="color: #16a34a; font-weight: 700;">-Rs. 0</span>
                    </div>

                    <div class="an-co-summary-row">
                        <span>Shipping Delivery</span>
                        <span class="an-co-summary-val an-free-delivery">
                            <i class="fa-solid fa-circle-check"></i> Free Doorstep Delivery
                        </span>
                    </div>

                    <!-- Total Row -->
                    <div class="an-co-summary-total-row">
                        <div>
                            <div class="an-total-label">Total Payable (COD)</div>
                            <div class="an-total-subtext">Pay cash when received</div>
                        </div>
                        <span id="checkoutTotal" class="an-co-summary-total-val">Rs. 0</span>
                    </div>
                </div>

                <!-- WhatsApp Place Order Button -->
                <button type="button" id="placeOrderBtn" class="an-btn-place-order" onclick="document.getElementById('hiddenFormSubmitBtn').click();">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>Place Order via WhatsApp (COD)</span>
                </button>

                <!-- Trust Guarantees Highlights -->
                <div class="an-co-trust-highlights">
                    <div class="an-trust-pill">
                        <i class="fa-solid fa-box-open text-emerald"></i>
                        <span>Open Parcel Allowed</span>
                    </div>
                    <div class="an-trust-pill">
                        <i class="fa-solid fa-truck-fast text-emerald"></i>
                        <span>2-4 Days Express Delivery</span>
                    </div>
                    <div class="an-trust-pill">
                        <i class="fa-solid fa-leaf text-emerald"></i>
                        <span>100% Herbal Authentic</span>
                    </div>
                    <div class="an-trust-pill">
                        <i class="fa-solid fa-shield-heart text-emerald"></i>
                        <span>Customer Satisfaction Guaranteed</span>
                    </div>
                </div>

                <!-- Terms Note -->
                <p class="an-co-terms-note">
                    <i class="fa-solid fa-lock" style="color: #10b981; margin-right: 4px;"></i> 256-Bit SSL Encrypted &bull; By placing order you agree to our Terms &amp; Policies.
                </p>
            </div>
        </div>

    </div>

    <!-- ORDER SUCCESSFUL CONFIRMATION VIEW -->
    <div id="checkoutSuccessView" style="display: none;" class="an-co-success-container">
        <div class="an-success-icon-wrap">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h2 class="an-success-title">Order Placed Successfully!</h2>
        <p class="an-success-subtitle">Thank you for choosing Amber's Roots. We are preparing your fresh herbal package for priority dispatch.</p>

        <div class="an-co-success-card">
            <div class="an-success-detail-row">
                <span class="an-detail-label">Order Number</span>
                <strong class="an-detail-val" id="successOrderId">#RM-94821</strong>
            </div>
            <div class="an-success-detail-row">
                <span class="an-detail-label">Estimated Delivery</span>
                <strong class="an-detail-val" style="color: #16a34a;">2 - 4 Business Days (Free Express Delivery)</strong>
            </div>
            <div class="an-success-detail-row">
                <span class="an-detail-label">Deliver To</span>
                <span class="an-detail-val" id="successDeliverTo">Customer Name, Lahore</span>
            </div>
            <div class="an-success-detail-row" style="border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                <span class="an-detail-label">Total Payable (COD)</span>
                <strong class="an-detail-val" style="color: #1b4332; font-size: 1.3rem;" id="successTotalAmount">Rs. 0</strong>
            </div>
        </div>

        <div class="an-success-actions">
            <a id="successWhatsAppBtn" href="#" target="_blank" class="an-btn-place-order" style="display: inline-flex; width: auto; padding: 12px 28px; text-decoration: none; align-items: center; gap: 10px; font-size: 1rem;">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.25rem;"></i>
                <span>Confirm on WhatsApp</span>
            </a>
            <a href="{{ url('/') }}" class="an-btn-return-home">
                <i class="fa-solid fa-house"></i> Return to Home
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ==========================================================================
   AMBER'S ROOTS LUXURY CHECKOUT THEME
   ========================================================================== */
:root {
    --ar-gold: #c5a059;
    --ar-gold-dark: #9e7a33;
    --ar-gold-light: #e5cb93;
    --ar-gold-border: rgba(197, 160, 89, 0.35);
    --ar-emerald: #1b4332;
    --ar-emerald-dark: #0f291e;
    --ar-emerald-light: #2d6a4f;
    --ar-bg-soft: #fcfaf7;
    --ar-border: #e6dfd3;
    --ar-text-dark: #1f2937;
    --ar-text-muted: #6b7280;
}

body {
    background-color: var(--ar-bg-soft);
}

.text-gold {
    color: var(--ar-gold);
}

.text-emerald {
    color: var(--ar-emerald);
}

/* Header Section */
.an-co-header-wrap {
    padding: 28px 20px 18px;
    background: linear-gradient(180deg, #ffffff 0%, var(--ar-bg-soft) 100%);
    border-bottom: 1px solid var(--ar-border);
    text-align: center;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow-x: hidden;
}

.an-co-header-inner {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    box-sizing: border-box;
}

.an-co-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    color: var(--ar-text-muted);
    text-transform: uppercase;
    margin-bottom: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.an-co-breadcrumbs a {
    color: var(--ar-text-muted);
    text-decoration: none;
    transition: color 0.2s ease;
}

.an-co-breadcrumbs a:hover {
    color: var(--ar-emerald);
}

.an-co-bc-sep {
    font-size: 0.6rem;
    color: #cbd5e1;
}

.an-co-bc-current {
    color: var(--ar-gold-dark);
}

.an-co-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(39, 90, 54, 0.08);
    color: var(--ar-emerald);
    border: 1px solid rgba(39, 90, 54, 0.2);
    border-radius: 999px;
    padding: 4px 14px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 8px;
    max-width: 100%;
    box-sizing: border-box;
    white-space: normal;
    text-align: center;
}

.an-co-title {
    font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
    font-size: 2.1rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    margin: 4px 0 6px;
    line-height: 1.2;
    letter-spacing: -0.01em;
    word-break: break-word;
}

.an-co-subtitle {
    font-size: 0.88rem;
    color: var(--ar-text-muted);
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.an-sub-sep {
    color: #cbd5e1;
}

/* Layout Grid */
.an-co-section {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    padding: 28px 20px 60px;
    box-sizing: border-box;
    overflow-x: hidden;
}

.an-co-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.45fr) minmax(0, 1fr);
    gap: 32px;
    align-items: start;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.an-co-left-col,
.an-co-right-col {
    min-width: 0;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

/* LEFT COLUMN: Luxury Form Cards */
.an-co-card {
    background: #ffffff;
    border: 1.5px solid var(--ar-border);
    border-radius: 18px;
    padding: 22px 26px;
    margin-bottom: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.an-co-card:hover {
    border-color: var(--ar-gold-border);
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.05);
}

.an-card-head {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1ece2;
    width: 100%;
    box-sizing: border-box;
}

.an-card-head > div:last-child {
    min-width: 0;
    flex: 1;
}

.an-step-num {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(197, 160, 89, 0.15) 0%, rgba(39, 90, 54, 0.1) 100%);
    color: var(--ar-emerald);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    font-weight: 700;
    flex-shrink: 0;
    border: 1px solid var(--ar-gold-border);
}

.an-co-card-title {
    font-family: 'Cinzel', Georgia, serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    margin: 0 0 2px 0;
    letter-spacing: -0.01em;
    word-break: break-word;
}

.an-card-desc {
    font-size: 0.78rem;
    color: var(--ar-text-muted);
    margin: 0;
    line-height: 1.35;
    word-break: break-word;
}

.an-co-row-2 {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 16px;
    width: 100%;
    box-sizing: border-box;
}

.an-co-field {
    display: flex;
    flex-direction: column;
}

.an-co-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.an-req {
    color: #dc2626;
    font-weight: 700;
}

.an-opt {
    color: #9ca3af;
    font-weight: 400;
    font-size: 0.72rem;
}

.an-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.an-input-icon {
    position: absolute;
    left: 14px;
    color: #9ca3af;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.2s ease;
}

.an-co-input {
    width: 100%;
    height: 44px;
    padding: 10px 14px 10px 40px;
    border: 1.5px solid #d9d2c5;
    border-radius: 10px;
    font-size: 0.88rem;
    color: #111827;
    background: #ffffff;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
}

.an-co-input:focus {
    border-color: var(--ar-emerald);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(39, 90, 54, 0.12);
}

.an-co-input:focus + .an-input-icon,
.an-input-wrap:focus-within .an-input-icon {
    color: var(--ar-emerald);
}

.an-co-input::placeholder {
    color: #9ca3af;
    font-size: 0.82rem;
}

/* Payment Method Box */
.an-payment-options-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
}

.an-pay-box {
    border: 2px solid var(--ar-emerald);
    border-radius: 14px;
    padding: 16px 18px;
    background: linear-gradient(135deg, rgba(39, 90, 54, 0.04) 0%, rgba(197, 160, 89, 0.06) 100%);
    cursor: default;
    display: block;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    word-break: break-word;
}

.an-pay-box-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
    flex-wrap: wrap;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
}

.an-pay-radio-title {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    min-width: 0;
}

.an-radio-dot {
    accent-color: var(--ar-emerald);
    width: 18px;
    height: 18px;
    cursor: pointer;
    flex-shrink: 0;
}

.an-pay-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    word-break: break-word;
}

.an-pay-badge {
    background: #dcfce7;
    color: #166534;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    letter-spacing: 0.02em;
    flex-shrink: 0;
    white-space: nowrap;
}

.an-pay-desc {
    font-size: 0.8rem;
    color: #4b5563;
    line-height: 1.45;
    margin-left: 28px;
    word-break: break-word;
    box-sizing: border-box;
    max-width: 100%;
}

/* RIGHT COLUMN: Luxury Order Summary Box */
.an-co-right-col {
    position: sticky;
    top: 96px;
    z-index: 10;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    min-width: 0;
}

.an-co-summary-box {
    background: #ffffff;
    border: 1.5px solid var(--ar-gold-border);
    border-radius: 20px;
    padding: 24px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(197, 160, 89, 0.15);
}

.an-summary-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1ece2;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
}

.an-co-summary-title {
    font-family: 'Cinzel', Georgia, serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    margin: 0;
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
    gap: 8px;
}

.an-item-count-badge {
    background: rgba(197, 160, 89, 0.15);
    color: var(--ar-gold-dark);
    font-size: 0.75rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    border: 1px solid rgba(197, 160, 89, 0.3);
}

/* Items List Container */
.an-co-items-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1ece2;
    max-height: 310px;
    overflow-y: auto;
    padding-right: 6px;
    width: 100%;
    box-sizing: border-box;
}

/* Sleek Slim Gold Scrollbar */
.an-co-items-list::-webkit-scrollbar {
    width: 5px;
}
.an-co-items-list::-webkit-scrollbar-track {
    background: #f7f4ef;
    border-radius: 10px;
}
.an-co-items-list::-webkit-scrollbar-thumb {
    background: var(--ar-gold);
    border-radius: 10px;
}
.an-co-items-list::-webkit-scrollbar-thumb:hover {
    background: var(--ar-gold-dark);
}

/* Item Row */
.an-co-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 8px 10px;
    background: #fbf9f6;
    border: 1px solid #f0eae1;
    border-radius: 12px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    transition: transform 0.15s ease, border-color 0.15s ease;
}

.an-co-item-row:hover {
    border-color: var(--ar-gold-border);
    transform: translateY(-1px);
}

.an-co-thumb-wrap {
    position: relative;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
}

.an-co-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5ded2;
    background: #ffffff;
    display: block;
}

.an-co-thumb-qty {
    position: absolute;
    top: -6px;
    right: -6px;
    background: var(--ar-emerald);
    color: #ffffff;
    font-size: 0.68rem;
    font-weight: 700;
    width: 19px;
    height: 19px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

.an-co-item-info {
    flex: 1 1 0;
    min-width: 0;
    overflow: hidden;
}

.an-co-item-name {
    font-size: 0.84rem;
    font-weight: 700;
    color: var(--ar-text-dark);
    line-height: 1.25;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
    display: block;
}

.an-co-item-sub {
    font-size: 0.72rem;
    color: var(--ar-text-muted);
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.an-co-item-price {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    white-space: nowrap;
    flex-shrink: 0;
    text-align: right;
    margin-left: auto;
}

/* Promo Code Section */
.an-promo-wrap {
    margin: 14px 0 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1ece2;
    width: 100%;
    box-sizing: border-box;
}

.an-promo-input-group {
    display: flex;
    gap: 8px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.an-promo-input {
    flex: 1 1 0;
    min-width: 0;
    width: 100%;
    max-width: 100%;
    height: 40px;
    padding: 8px 12px;
    border: 1.5px solid #d9d2c5;
    border-radius: 8px;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #111827;
    background: #ffffff;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.an-promo-input:focus {
    border-color: var(--ar-gold);
    box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.15);
}

.an-promo-btn {
    flex-shrink: 0;
    width: auto;
    padding: 0 16px;
    font-size: 0.82rem;
    font-weight: 700;
    height: 40px;
    white-space: nowrap;
    background: var(--ar-gold);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-sizing: border-box;
    transition: background-color 0.2s ease, transform 0.1s ease;
}

.an-promo-btn:hover {
    background: var(--ar-gold-dark);
}

.an-promo-msg {
    font-size: 0.74rem;
    margin-top: 6px;
    font-weight: 600;
    display: none;
}

/* Cost Breakdown */
.an-cost-breakdown {
    margin-bottom: 18px;
    width: 100%;
    box-sizing: border-box;
}

.an-co-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.86rem;
    color: #4b5563;
    margin-bottom: 10px;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
}

.an-co-summary-val {
    color: var(--ar-text-dark);
    font-weight: 600;
    flex-shrink: 0;
    white-space: nowrap;
    text-align: right;
}

.an-free-delivery {
    color: #16a34a;
    font-weight: 700;
}

.an-co-summary-total-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    border-top: 1.5px dashed var(--ar-border);
    padding-top: 14px;
    margin-top: 14px;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
}

.an-total-label {
    font-size: 0.92rem;
    font-weight: 800;
    color: var(--ar-emerald-dark);
    letter-spacing: -0.01em;
    min-width: 0;
    flex: 1;
}

.an-total-subtext {
    font-size: 0.72rem;
    color: var(--ar-text-muted);
    font-weight: 500;
}

.an-co-summary-total-val {
    font-size: 1.45rem;
    font-weight: 800;
    color: var(--ar-emerald-dark);
    letter-spacing: -0.02em;
    flex-shrink: 0;
    white-space: nowrap;
    text-align: right;
    margin-left: auto;
}

/* WhatsApp Place Order CTA Button */
.an-btn-place-order {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    height: auto;
    min-height: 50px;
    padding: 12px 18px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #ffffff;
    font-size: 0.98rem;
    font-weight: 700;
    text-align: center;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.35);
    white-space: normal;
    word-break: break-word;
    line-height: 1.3;
    transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
}

.an-btn-place-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.45);
    filter: brightness(1.04);
}

.an-btn-place-order:active {
    transform: translateY(0);
}

.an-btn-place-order i {
    font-size: 1.3rem;
    flex-shrink: 0;
}

/* Trust Perks Grid Under CTA */
.an-co-trust-highlights {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-top: 18px;
    padding-top: 16px;
    border-top: 1px solid #f1ece2;
}

.an-trust-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fbf9f6;
    border: 1px solid #f0eae1;
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 0.72rem;
    font-weight: 600;
    color: #4b5563;
    line-height: 1.25;
}

.an-trust-pill i {
    font-size: 0.85rem;
    flex-shrink: 0;
}

.an-co-terms-note {
    font-size: 0.72rem;
    color: #9ca3af;
    margin-top: 14px;
    text-align: center;
    line-height: 1.4;
}

/* Success Card */
.an-co-success-container {
    max-width: 620px;
    margin: 30px auto;
    background: #ffffff;
    border: 1.5px solid var(--ar-gold-border);
    border-radius: 20px;
    padding: 38px 30px;
    text-align: center;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
}

.an-success-icon-wrap {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #dcfce7;
    color: #16a34a;
    font-size: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
}

.an-success-title {
    font-family: 'Cinzel', Georgia, serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--ar-emerald-dark);
    margin: 0 0 6px;
}

.an-success-subtitle {
    color: var(--ar-text-muted);
    font-size: 0.92rem;
    margin: 0 0 24px;
    line-height: 1.5;
}

.an-co-success-card {
    background: #faf8f5;
    border: 1.5px solid #ece5d8;
    border-radius: 14px;
    padding: 20px 22px;
    margin: 20px 0;
    text-align: left;
}

.an-success-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ebe4d7;
    padding-bottom: 12px;
    margin-bottom: 12px;
}

.an-detail-label {
    color: #6b7280;
    font-size: 0.85rem;
}

.an-detail-val {
    color: var(--ar-text-dark);
    font-size: 0.95rem;
    font-weight: 700;
}

.an-success-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 24px;
}

.an-btn-return-home {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--ar-text-muted);
    border: 1.5px solid #d1d5db;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.92rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.an-btn-return-home:hover {
    color: var(--ar-emerald-dark);
    border-color: var(--ar-emerald-dark);
    background: #f9fafb;
}

/* Responsive Breakpoints (234px to 2100px+) */

/* Tablets & Small Laptops (<= 960px) */
@media (max-width: 960px) {
    .an-co-layout {
        display: flex !important;
        flex-direction: column !important;
        gap: 20px !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    .an-co-left-col,
    .an-co-right-col {
        position: static !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
    }
}

/* Mobile Screens (<= 640px) */
@media (max-width: 640px) {
    .an-co-header-wrap {
        padding: 18px 12px 14px !important;
    }
    .an-co-title {
        font-size: 1.55rem !important;
    }
    .an-co-subtitle {
        font-size: 0.8rem !important;
        gap: 6px !important;
    }
    .an-co-section {
        padding: 14px 10px 36px !important;
        width: 100% !important;
        max-width: 100vw !important;
    }
    .an-co-card {
        padding: 16px 14px !important;
        border-radius: 14px !important;
        margin-bottom: 16px !important;
        width: 100% !important;
    }
    .an-card-head {
        gap: 10px !important;
        margin-bottom: 14px !important;
        padding-bottom: 12px !important;
    }
    .an-step-num {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.85rem !important;
        border-radius: 10px !important;
    }
    .an-co-card-title {
        font-size: 1.05rem !important;
    }
    .an-co-row-2 {
        grid-template-columns: 1fr !important;
        gap: 12px !important;
    }
    .an-co-input {
        height: 42px !important;
        font-size: 0.84rem !important;
        padding: 8px 12px 8px 36px !important;
    }
    .an-input-icon {
        left: 12px !important;
        font-size: 0.82rem !important;
    }
    
    /* Box 3 Payment */
    .an-pay-box {
        padding: 14px 12px !important;
        width: 100% !important;
    }
    .an-pay-box-header {
        flex-direction: row !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 6px !important;
    }
    .an-pay-radio-title {
        gap: 8px !important;
        min-width: 0 !important;
    }
    .an-pay-title {
        font-size: 0.88rem !important;
    }
    .an-pay-badge {
        font-size: 0.68rem !important;
        padding: 2px 8px !important;
    }
    .an-pay-desc {
        margin-left: 0 !important;
        margin-top: 8px !important;
        font-size: 0.78rem !important;
    }
    
    /* Summary Box */
    .an-co-summary-box {
        padding: 16px 14px !important;
        border-radius: 16px !important;
        width: 100% !important;
    }
    .an-co-summary-title {
        font-size: 1.1rem !important;
    }
    .an-co-item-row {
        padding: 8px 8px !important;
        gap: 8px !important;
    }
    .an-co-thumb-wrap {
        width: 42px !important;
        height: 42px !important;
    }
    .an-co-item-name {
        font-size: 0.8rem !important;
    }
    .an-co-item-sub {
        font-size: 0.7rem !important;
    }
    .an-co-item-price {
        font-size: 0.84rem !important;
    }
    .an-promo-wrap {
        margin: 12px 0 14px !important;
        padding-bottom: 12px !important;
    }
    .an-promo-input-group {
        gap: 6px !important;
        width: 100% !important;
    }
    .an-promo-input {
        min-width: 0 !important;
        flex: 1 1 0 !important;
        padding: 8px 10px !important;
        font-size: 0.78rem !important;
        height: 38px !important;
    }
    .an-promo-btn {
        padding: 0 14px !important;
        font-size: 0.78rem !important;
        height: 38px !important;
        flex-shrink: 0 !important;
    }
    .an-co-summary-row {
        font-size: 0.82rem !important;
        margin-bottom: 8px !important;
    }
    .an-co-summary-total-val {
        font-size: 1.3rem !important;
    }
    .an-btn-place-order {
        min-height: 46px !important;
        font-size: 0.9rem !important;
        padding: 10px 14px !important;
    }
    .an-co-trust-highlights {
        grid-template-columns: 1fr !important;
        gap: 6px !important;
        margin-top: 14px !important;
        padding-top: 12px !important;
    }
    .an-trust-pill {
        padding: 7px 10px !important;
        font-size: 0.72rem !important;
    }
}

/* Small Smart Phones (<= 480px, e.g. iPhone, Galaxy) */
@media (max-width: 480px) {
    .an-co-header-wrap {
        padding: 14px 10px 10px !important;
    }
    .an-co-badge {
        font-size: 0.7rem !important;
        padding: 3px 10px !important;
    }
    .an-co-title {
        font-size: 1.35rem !important;
    }
    .an-co-section {
        padding: 10px 8px 30px !important;
    }
    .an-co-card,
    .an-co-summary-box {
        padding: 14px 10px !important;
        border-radius: 12px !important;
    }
    .an-pay-box {
        padding: 12px 10px !important;
    }
    .an-pay-box-header {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 6px !important;
    }
    .an-pay-title {
        font-size: 0.85rem !important;
    }
    .an-pay-badge {
        margin-left: 26px !important;
    }
    .an-co-summary-total-val {
        font-size: 1.22rem !important;
    }
    .an-btn-place-order {
        min-height: 44px !important;
        font-size: 0.86rem !important;
        gap: 6px !important;
    }
    .an-btn-place-order i {
        font-size: 1.15rem !important;
    }
}

/* Mini Phones (<= 360px, e.g. iPhone SE, Xperia Mini) */
@media (max-width: 360px) {
    .an-co-header-wrap {
        padding: 12px 6px 8px !important;
    }
    .an-co-title {
        font-size: 1.2rem !important;
    }
    .an-co-section {
        padding: 8px 6px 24px !important;
    }
    .an-co-card,
    .an-co-summary-box {
        padding: 12px 8px !important;
        border-radius: 10px !important;
    }
    .an-card-head {
        gap: 8px !important;
    }
    .an-step-num {
        width: 28px !important;
        height: 28px !important;
        font-size: 0.78rem !important;
    }
    .an-co-card-title {
        font-size: 0.98rem !important;
    }
    .an-co-input {
        height: 38px !important;
        font-size: 0.8rem !important;
        padding: 6px 10px 6px 32px !important;
    }
    .an-promo-input-group {
        flex-direction: column !important;
        gap: 6px !important;
    }
    .an-promo-btn {
        width: 100% !important;
        height: 36px !important;
    }
    .an-co-summary-total-val {
        font-size: 1.15rem !important;
    }
    .an-btn-place-order {
        font-size: 0.82rem !important;
        padding: 10px 8px !important;
    }
    .an-trust-pill {
        font-size: 0.68rem !important;
        padding: 6px 8px !important;
    }
}

/* Micro Displays (234px - 280px, e.g. Fold Cover Screen, Smart Watch / Ultra narrow) */
@media (max-width: 280px) {
    .an-co-header-wrap {
        padding: 10px 4px 6px !important;
    }
    .an-co-breadcrumbs {
        font-size: 0.64rem !important;
        gap: 4px !important;
    }
    .an-co-badge {
        font-size: 0.62rem !important;
        padding: 2px 6px !important;
    }
    .an-co-title {
        font-size: 1.05rem !important;
    }
    .an-co-subtitle {
        display: none !important;
    }
    .an-co-section {
        padding: 6px 4px 18px !important;
    }
    .an-co-card,
    .an-co-summary-box {
        padding: 10px 6px !important;
        border-radius: 8px !important;
    }
    .an-step-num {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.72rem !important;
    }
    .an-co-card-title {
        font-size: 0.9rem !important;
    }
    .an-card-desc {
        font-size: 0.7rem !important;
    }
    .an-co-label {
        font-size: 0.74rem !important;
    }
    .an-co-input {
        height: 36px !important;
        font-size: 0.76rem !important;
        padding: 6px 8px 6px 28px !important;
    }
    .an-input-icon {
        left: 8px !important;
        font-size: 0.75rem !important;
    }
    .an-pay-title {
        font-size: 0.78rem !important;
    }
    .an-pay-badge {
        font-size: 0.62rem !important;
        margin-left: 0 !important;
    }
    .an-pay-desc {
        font-size: 0.7rem !important;
    }
    .an-co-item-row {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 6px !important;
    }
    .an-co-item-price {
        margin-left: 0 !important;
        align-self: flex-end !important;
    }
    .an-co-summary-row {
        font-size: 0.75rem !important;
    }
    .an-total-label {
        font-size: 0.8rem !important;
    }
    .an-co-summary-total-val {
        font-size: 1.05rem !important;
    }
    .an-btn-place-order {
        height: auto !important;
        min-height: 40px !important;
        font-size: 0.76rem !important;
        padding: 8px 6px !important;
    }
    .an-btn-place-order i {
        font-size: 0.95rem !important;
    }
    .an-trust-pill {
        padding: 5px 6px !important;
        font-size: 0.64rem !important;
        gap: 5px !important;
    }
}

/* Ultrawide 2K & 4K Displays (1920px - 2100px+) */
@media (min-width: 1920px) {
    .an-co-section {
        max-width: 1750px !important;
        padding: 40px 32px 80px !important;
    }
    .an-co-layout {
        gap: 40px !important;
    }
    .an-co-title {
        font-size: 2.6rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
    let appliedCoupon = null;
    let currentSubtotal = 0;
    let currentDiscount = 0;

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutItemsPreview();
    });

    function sanitizeItemTitle(title) {
        if (!title) return "Amber's Roots 100% Herbal Hair Growth Oil";
        return String(title).replace(/Rivaaj\s*Mahal/gi, "Amber's Roots").replace(/\bRivaaj\b/gi, "Amber's Roots");
    }

    function removeCheckoutItem(index) {
        if (window.RivaajCart) {
            window.RivaajCart.removeItemByIndex(index);
            renderCheckoutItemsPreview();
        }
    }

    window.addEventListener('cart-updated', () => {
        renderCheckoutItemsPreview();
    });

    function getItemImage(item) {
        if (item.image && typeof item.image === 'string' && item.image.length > 3) {
            return item.image.startsWith('/') ? item.image : '/' + item.image;
        }
        const titleLower = (item.title || '').toLowerCase();
        if (titleLower.includes('shampoo')) {
            return '/assets/product/1000082362.jpg';
        }
        return '/assets/product/1000082361.jpg';
    }

    function applyCouponCode() {
        const input = document.getElementById('couponInput');
        const code = input ? input.value.trim() : '';
        const msgEl = document.getElementById('couponMessage');

        if (!code) {
            msgEl.style.display = 'block';
            msgEl.style.color = '#dc2626';
            msgEl.textContent = 'Please enter a coupon code.';
            return;
        }

        fetch('/api/coupon/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                code: code,
                subtotal: currentSubtotal
            })
        })
        .then(res => res.json())
        .then(data => {
            msgEl.style.display = 'block';
            if (data.valid) {
                appliedCoupon = data.code;
                currentDiscount = data.discount;
                msgEl.style.color = '#16a34a';
                msgEl.textContent = data.message;
                
                document.getElementById('couponDiscountRow').style.display = 'flex';
                document.getElementById('appliedCouponCode').textContent = data.code;
                document.getElementById('checkoutDiscount').textContent = '-Rs. ' + Number(currentDiscount).toLocaleString();
                
                const finalTotal = Math.max(0, currentSubtotal - currentDiscount);
                document.getElementById('checkoutTotal').textContent = 'Rs. ' + finalTotal.toLocaleString();
            } else {
                msgEl.style.color = '#dc2626';
                msgEl.textContent = data.message || 'Invalid coupon code.';
            }
        })
        .catch(err => {
            msgEl.style.display = 'block';
            msgEl.style.color = '#dc2626';
            msgEl.textContent = 'Could not validate coupon. Please try again.';
        });
    }

    function renderCheckoutItemsPreview() {
        const cart = window.RivaajCart ? window.RivaajCart.getCart() : [];
        const container = document.getElementById('checkoutSummaryItems');
        const countBadge = document.getElementById('checkoutItemCountBadge');
        const subtotalEl = document.getElementById('checkoutSubtotal');
        const totalEl = document.getElementById('checkoutTotal');

        if (!container) return;
        container.innerHTML = '';

        if (!cart || cart.length === 0) {
            // Default to single active hair oil for quick checkout if cart is empty
            const fallbackItem = {
                title: "Amber's Roots 100% Herbal Hair Growth Oil",
                price: "Rs. 2,450",
                image: "/assets/product/1000082361.jpg",
                quantity: 1
            };
            currentSubtotal = 2450;
            if (countBadge) countBadge.textContent = '1 Item';

            const row = document.createElement('div');
            row.className = 'an-co-item-row';
            row.innerHTML = `
                <div class="an-co-thumb-wrap">
                    <img src="${fallbackItem.image}" alt="${fallbackItem.title}" class="an-co-thumb-img" onerror="this.onerror=null; this.src='/assets/product/1000082361.jpg';">
                    <span class="an-co-thumb-qty">1</span>
                </div>
                <div class="an-co-item-info">
                    <div class="an-co-item-name">${fallbackItem.title}</div>
                    <div class="an-co-item-sub">Rs. 2,450 &bull; 200ml Bottle</div>
                </div>
                <div class="an-co-item-price">Rs. 2,450</div>
            `;
            container.appendChild(row);
            if (subtotalEl) subtotalEl.textContent = 'Rs. 2,450';
            if (totalEl) totalEl.textContent = 'Rs. 2,450';
            return;
        }

        let totalAmount = 0;
        let totalCount = 0;

        cart.forEach((item, index) => {
            const numericPrice = parseInt(item.price.toString().replace(/[^0-9]/g, '')) || 0;
            const itemQty = parseInt(item.quantity) || 1;
            const itemTotal = numericPrice * itemQty;
            totalAmount += itemTotal;
            totalCount += itemQty;

            const sanitizedTitle = sanitizeItemTitle(item.title);
            const safeTitle = sanitizedTitle.replace(/"/g, '&quot;');
            const itemImg = getItemImage(item);

            const row = document.createElement('div');
            row.className = 'an-co-item-row';
            row.innerHTML = `
                <div class="an-co-thumb-wrap">
                    <img src="${itemImg}" alt="${safeTitle}" class="an-co-thumb-img" onerror="this.onerror=null; this.src='/assets/product/1000082361.jpg';">
                    <span class="an-co-thumb-qty">${itemQty}</span>
                </div>
                <div class="an-co-item-info">
                    <div class="an-co-item-name" title="${safeTitle}">${sanitizedTitle}</div>
                    <div class="an-co-item-sub">
                        Rs. ${numericPrice.toLocaleString()} each &bull; 
                        <button type="button" onclick="removeCheckoutItem(${index})" style="background:none; border:none; color:#ef4444; font-size:0.75rem; font-weight:600; cursor:pointer; padding:0; text-decoration:underline;">Remove</button>
                    </div>
                </div>
                <div class="an-co-item-price">
                    Rs. ${itemTotal.toLocaleString()}
                </div>
            `;
            container.appendChild(row);
        });

        if (countBadge) {
            countBadge.textContent = totalCount === 1 ? '1 Item' : totalCount + ' Items';
        }

        currentSubtotal = totalAmount;
        const finalTotal = Math.max(0, currentSubtotal - currentDiscount);

        if (subtotalEl) subtotalEl.textContent = 'Rs. ' + totalAmount.toLocaleString();
        if (totalEl) totalEl.textContent = 'Rs. ' + finalTotal.toLocaleString();
    }

    function submitAlNoorOrder() {
        const name = document.getElementById('custName').value.trim();
        const phone = document.getElementById('custPhone').value.trim();
        const address = document.getElementById('custAddress').value.trim();
        const city = document.getElementById('custCity').value.trim();
        const email = document.getElementById('custEmail') ? document.getElementById('custEmail').value.trim() : '';
        const notes = document.getElementById('custNotes') ? document.getElementById('custNotes').value.trim() : '';
        const btn = document.getElementById('placeOrderBtn');

        if (!name || !phone || !address || !city) {
            AmberAlert.warning('Please enter your Full Name, Mobile Number, Street Address, and City to complete your COD order.', 'Incomplete Delivery Details');
            return;
        }

        const cart = window.RivaajCart ? window.RivaajCart.getCart() : [];
        const items = (cart && cart.length > 0) ? cart.map(it => ({
            title: sanitizeItemTitle(it.title),
            slug: it.slug || 'ambers-roots-hair-oil',
            price: parseInt(it.price.toString().replace(/[^0-9]/g, '')) || 2450,
            qty: it.quantity || 1,
            icon: it.icon || 'fa-bottle-droplet',
            image: getItemImage(it)
        })) : [{
            title: "Amber's Roots 100% Herbal Hair Growth Oil",
            slug: 'ambers-roots-hair-oil',
            price: 2450,
            qty: 1,
            icon: 'fa-bottle-droplet',
            image: '/assets/product/1000082361.jpg'
        }];

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Placing Order...';
        }

        // Send AJAX to server to record order in database FIRST
        fetch('/orders/place', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                customer_name: name,
                customer_phone: phone,
                shipping_address: address,
                city: city,
                customer_email: email,
                notes: notes,
                coupon_code: appliedCoupon,
                items: items
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.message || 'Error saving order.'); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate confirmation screen
                document.getElementById('successOrderId').textContent = '#' + data.order_number;
                document.getElementById('successDeliverTo').textContent = `${data.customer_name}, ${data.shipping_address}, ${data.city} (${data.customer_phone})`;
                document.getElementById('successTotalAmount').textContent = data.total_formatted;
                document.getElementById('successWhatsAppBtn').href = data.whatsapp_url;

                // Clear cart in localStorage
                if (window.RivaajCart) {
                    window.RivaajCart.saveCart([]);
                }

                // Show confirmation screen
                document.getElementById('checkoutMainContainer').style.display = 'none';
                document.getElementById('checkoutSuccessView').style.display = 'block';
                window.scrollTo({ top: 30, behavior: 'smooth' });

                // Open WhatsApp in new tab for customer convenience
                try {
                    window.open(data.whatsapp_url, '_blank');
                } catch (e) {
                    // Browser popup blocker fallback
                }
            } else {
                AmberAlert.error(data.message || 'Could not place order. Please check your delivery information.', 'Order Placement Failed');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-brands fa-whatsapp"></i> <span>Place Order via WhatsApp (COD)</span>';
                }
            }
        })
        .catch(err => {
            AmberAlert.error(err.message || 'A network error occurred. Please try again.', 'Connection Notice');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-brands fa-whatsapp"></i> <span>Place Order via WhatsApp (COD)</span>';
            }
        });
    }
</script>
@endpush
