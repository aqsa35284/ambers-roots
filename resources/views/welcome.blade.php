@extends('layouts.app')

@section('title', "Amber's Roots – Pure Herbs, Pure Results | Official Store")

@section('content')
<!-- Hero Section (Oil ki bari bottle photo, short brand message, price & Order Now button) -->
<section class="rm-hero">
    <div class="rm-hero-container">
        @php
            $heroProd = $featuredProduct ?? ($activeProducts->first() ?? null);
            $heroDiscount = '23% OFF';
            if ($heroProd) {
                if ($heroProd->discount_percent && $heroProd->discount_percent > 0) {
                    $heroDiscount = $heroProd->discount_percent . '% OFF';
                } elseif (!empty($heroProd->discount)) {
                    $heroDiscount = $heroProd->discount;
                }
            }
        @endphp

        <!-- Left Column: Short Brand Message, Price & CTA Buttons -->
        <div class="rm-hero-content">
            <div class="rm-hero-badge">
                <i class="fa-solid fa-leaf text-gold"></i>
                <span>100% Pure Organic Ayurvedic Oil &bull; 21 Rare Botanical Herbs</span>
            </div>

            <h1 class="rm-hero-title">
                <span class="rm-hero-title-main">Ambers Roots</span> <br>
                <span class="rm-hero-title-gold">100% Herbal Hair Oil</span>
            </h1>

            <!-- Short Brand Message -->
            <p class="rm-hero-subtitle">
                Mazboot, chamakdaar aur sehatmand baal – sirf <strong>Amber’s Roots Herbal Hair Oil</strong> ke saath! Infused with 21 rare Ayurvedic herbs &amp; cold-pressed botanical oils to stop severe hair fall, eliminate dandruff, and stimulate thick, shiny new hair growth.
            </p>

            <!-- Prominent Price & Savings Block -->
            <div class="rm-hero-price-card">
                <div class="rm-hero-price-line">
                    <span class="rm-hero-price-current">Rs. {{ number_format($heroProd?->effective_price ?? 2450) }}</span>
                    @if($heroProd?->original_price && $heroProd->original_price > ($heroProd->effective_price ?? 2450))
                        <span class="rm-hero-price-original">Rs. {{ number_format($heroProd->original_price) }}</span>
                    @else
                        <span class="rm-hero-price-original">Rs. 3,200</span>
                    @endif
                    <span class="rm-hero-save-badge">
                        <i class="fa-solid fa-tag"></i> {{ $heroDiscount }} (Save Rs. {{ number_format(($heroProd?->original_price ?? 3200) - ($heroProd?->effective_price ?? 2450)) }})
                    </span>
                </div>
                <div class="rm-hero-delivery-tag">
                    <i class="fa-solid fa-truck-fast text-emerald"></i>
                    <span>Free Doorstep Delivery Across Pakistan &bull; Cash on Delivery (COD)</span>
                </div>
            </div>

            <!-- "Order Now" & WhatsApp CTA Group -->
            <div class="rm-hero-cta-group">
                <a href="{{ url('/checkout') }}" class="rm-btn-primary rm-hero-cta-order">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span>Order Now (Cash on Delivery)</span>
                </a>
                <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello Amber\'s Roots! I would like to order Amber\'s Roots Herbal Hair Growth Oil (200ml) with Cash on Delivery.') }}" target="_blank" class="rm-btn-secondary rm-hero-cta-wa">
                    <i class="fa-brands fa-whatsapp" style="color: #25d366; font-size: 1.25rem;"></i>
                    <span>Order via WhatsApp</span>
                </a>
            </div>

            <!-- Trust / Social Proof Rating Bar -->
            <div class="rm-hero-social-proof">
                <div class="rm-hero-rating-stars">
                    <div style="color: #eab308; font-size: 0.95rem; display: flex; gap: 3px;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="rm-hero-rating-score">4.9 / 5.0</span>
                </div>
                <span class="rm-hero-divider">|</span>
                <div class="rm-hero-proof-text">
                    <strong style="color: #0f172a;">50,000+</strong> Happy Customers across Pakistan
                </div>
            </div>
        </div>

        <!-- Right Column: Oil ki bari, high-quality bottle photo (with Fade-in & Slow Subtle Float) -->
        <div class="rm-hero-visual">
            <div class="rm-hero-bottle-stage">
                <!-- Floating Discount Tag -->
                <span class="rm-bottle-badge-discount">
                    <i class="fa-solid fa-tag"></i> {{ $heroDiscount }}
                </span>

                <!-- Floating Best Seller Pill -->
                <span class="rm-bottle-badge-bestseller">
                    <i class="fa-solid fa-crown"></i> BEST SELLER
                </span>

                <!-- Large Bottle Photo with subtle float animation -->
                <div class="rm-hero-bottle-wrap">
                    <img src="{{ asset('assets/product/1000082361.jpg') }}" 
                         alt="Amber's Roots 100% Herbal Hair Growth Oil" 
                         class="rm-hero-bottle-img rm-hero-bottle-float"
                         onerror="this.onerror=null; this.src='{{ asset('images/products/hair-oil.jpg') }}';" />
                </div>

                <!-- Floating Bottom Trust Pill -->
                <div class="rm-hero-floating-badge">
                    <div class="rm-hero-badge-icon">
                        <i class="fa-solid fa-shield-heart text-emerald"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">100% Organic &bull; 200ml Glass Bottle</div>
                        <div style="font-size: 0.74rem; color: #64748b;">No Chemicals &bull; Open Parcel on Delivery Allowed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Value Pillars / Badges -->
<section class="rm-value-pillars-section">
    <div class="rm-benefits-grid">
        <div class="rm-pillar-item">
            <div class="rm-pillar-icon">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div>
                <h4 class="rm-pillar-title">21 Ayurvedic Herbs</h4>
                <p class="rm-pillar-sub">100% Natural cold-pressed oils</p>
            </div>
        </div>

        <div class="rm-pillar-item">
            <div class="rm-pillar-icon">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h4 class="rm-pillar-title">Free Express Delivery</h4>
                <p class="rm-pillar-sub">2-4 Days all across Pakistan</p>
            </div>
        </div>

        <div class="rm-pillar-item">
            <div class="rm-pillar-icon">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <h4 class="rm-pillar-title">Cash on Delivery (COD)</h4>
                <p class="rm-pillar-sub">Pay at doorstep &bull; Open parcel allowed</p>
            </div>
        </div>

        <div class="rm-pillar-item">
            <div class="rm-pillar-icon">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h4 class="rm-pillar-title">Live WhatsApp Helpline</h4>
                <p class="rm-pillar-sub">Instant response: {{ $storePhone ?? '+92 327 2222180' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Center Product Display (Sirf Image aur Dynamic Discount Offer, No Name, No Price, No Information) -->
<section class="rm-home-center-product-section">
    <div class="rm-home-center-product-container">
        @if($heroProd)
            <a href="{{ url('/product/' . $heroProd->slug) }}" class="rm-center-product-card" aria-label="View details of Amber's Roots Herbal Hair Oil">
                <!-- Dynamic Discount Offer Badge (Admin se automatically update hota hai) -->
                <div class="rm-center-discount-badge">
                    <i class="fa-solid fa-tag"></i>
                    <span>{{ $heroDiscount }}</span>
                </div>

                @if(!empty($heroProd->badge))
                    <div class="rm-center-badge-pill">
                        {{ $heroProd->badge }}
                    </div>
                @endif

                <!-- Center Product Image Display (Sirf Image, No Text, No Information) -->
                <div class="rm-center-img-holder">
                    <img src="{{ $heroProd->image_url ?? asset('assets/product/1000082361.jpg') }}" 
                         alt="Amber's Roots" 
                         class="rm-center-product-img"
                         onerror="this.onerror=null; this.src='{{ asset('assets/product/1000082361.jpg') }}';">
                </div>
            </a>
        @else
            <div class="rm-center-product-card">
                <div class="rm-center-discount-badge">
                    <i class="fa-solid fa-tag"></i>
                    <span>23% OFF</span>
                </div>
                <div class="rm-center-img-holder">
                    <img src="{{ asset('assets/product/1000082361.jpg') }}" 
                         alt="Amber's Roots" 
                         class="rm-center-product-img">
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Additional Active Products (Agar future mein mazeed products add hon) -->
@if(isset($activeProducts) && $activeProducts->count() > 1)
<section style="padding: 20px 20px 60px; max-width: 1240px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="font-family: var(--rm-font-display); font-size: 1.6rem; font-weight: 700; color: var(--rm-dark);">
            More Herbal Formulations
        </h3>
    </div>
    <div class="rm-featured-grid">
        @foreach($activeProducts->where('id', '!=', $heroProd?->id) as $extraProd)
            <a href="{{ url('/product/' . $extraProd->slug) }}" class="rm-clean-product-card">
                @if($extraProd->hasActiveDiscount())
                    <span style="position: absolute; top: 16px; left: 16px; background: #dc2626; color: #fff; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; text-transform: uppercase; z-index: 2;">
                        {{ $extraProd->discount_percent ? $extraProd->discount_percent . '% OFF' : ($extraProd->discount ?? 'SALE') }}
                    </span>
                @endif
                <div class="rm-card-img-wrap">
                    <img src="{{ $extraProd->image_url }}" alt="{{ $extraProd->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="rm-clean-product-info">
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 6px;">{{ $extraProd->title }}</h4>
                    <p style="font-size: 0.8125rem; color: #64748b; margin-bottom: 12px;">{{ $extraProd->short_desc }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: baseline; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        <strong style="font-size: 1.1rem; color: var(--rm-gold-dark);">Rs. {{ number_format($extraProd->effective_price) }}</strong>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--rm-dark);">View Details &rarr;</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

<!-- REVIEWS SECTION: Real Customer Feedback Live Feed (Royal Deep Forest Green Theme) -->
<section class="rm-reviews-master-section">
    <div class="rm-reviews-master-container">
        <div class="rm-reviews-block" id="rmReviewsBlock">
            
            <div class="rm-reviews-header">
                <div class="rm-reviews-header-info">
                    <div class="rm-reviews-eyebrow">
                        <span class="rm-pulse-dot"></span>
                        <span>Real Customer Feedback &bull; Live Feed</span>
                    </div>
                    <h2 class="rm-reviews-title">
                        What Our Customers Say Across Pakistan
                    </h2>
                    <div class="rm-reviews-rating-bar">
                        <div class="rm-reviews-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <span class="rm-reviews-score">{{ $averageRating ?? 4.9 }} out of 5.0</span>
                        <span class="rm-reviews-badge-txt">&bull; 100% Verified Customer Reviews</span>
                    </div>
                </div>

                <!-- Header Actions: Write a Review & Carousel Navigation Arrows -->
                <div class="rm-reviews-actions">
                    <button type="button" class="rm-btn-write-review" onclick="openReviewModal()">
                        <i class="fa-solid fa-pen-nib"></i>
                        <span>Write a Review</span>
                    </button>
                    <div class="rm-carousel-nav-btns">
                        <button type="button" class="rm-carousel-btn rm-carousel-prev" id="reviewsPrevBtn" aria-label="Previous Review" title="Previous Review">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <button type="button" class="rm-carousel-btn rm-carousel-next" id="reviewsNextBtn" aria-label="Next Review" title="Next Review">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Customer Reviews Smooth Auto-Scrolling Ribbon -->
            <div class="rm-reviews-carousel-wrapper" id="reviewsCarouselWrapper">
                <div class="rm-reviews-carousel-track" id="reviewsCarouselTrack">
                    @if($approvedReviews->isNotEmpty())
                        {{-- Primary Set --}}
                        @foreach($approvedReviews as $review)
                            @php
                                $rawName = $review->customer_name;
                                $city = 'Pakistan';
                                if (preg_match('/\((.*?)\)/', $rawName, $m)) {
                                    $city = trim($m[1]);
                                    $cleanName = trim(preg_replace('/\(.*?\)/', '', $rawName));
                                } else {
                                    $cleanName = $rawName;
                                }
                                $initial = strtoupper(substr($cleanName, 0, 1));
                            @endphp
                            <div class="rm-review-card rm-carousel-slide">
                                <div class="rm-card-watermark"><i class="fa-solid fa-quote-right"></i></div>
                                <div class="rm-review-card-top">
                                    <div class="rm-review-card-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rm-review-card-date">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <p class="rm-review-card-text">
                                    "{{ $review->review_text }}"
                                </p>

                                <div class="rm-review-card-author">
                                    <div class="rm-review-card-avatar">{{ $initial }}</div>
                                    <div class="rm-review-author-meta">
                                        <div class="rm-review-card-name">{{ $cleanName }}</div>
                                        <div class="rm-review-card-verified">
                                            <i class="fa-solid fa-circle-check"></i> {{ $city }} &bull; Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Secondary Set (Clone for seamless infinite scrolling loop) --}}
                        @foreach($approvedReviews as $review)
                            @php
                                $rawName = $review->customer_name;
                                $city = 'Pakistan';
                                if (preg_match('/\((.*?)\)/', $rawName, $m)) {
                                    $city = trim($m[1]);
                                    $cleanName = trim(preg_replace('/\(.*?\)/', '', $rawName));
                                } else {
                                    $cleanName = $rawName;
                                }
                                $initial = strtoupper(substr($cleanName, 0, 1));
                            @endphp
                            <div class="rm-review-card rm-carousel-slide rm-carousel-clone" aria-hidden="true">
                                <div class="rm-card-watermark"><i class="fa-solid fa-quote-right"></i></div>
                                <div class="rm-review-card-top">
                                    <div class="rm-review-card-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rm-review-card-date">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <p class="rm-review-card-text">
                                    "{{ $review->review_text }}"
                                </p>

                                <div class="rm-review-card-author">
                                    <div class="rm-review-card-avatar">{{ $initial }}</div>
                                    <div class="rm-review-author-meta">
                                        <div class="rm-review-card-name">{{ $cleanName }}</div>
                                        <div class="rm-review-card-verified">
                                            <i class="fa-solid fa-circle-check"></i> {{ $city }} &bull; Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="rm-no-reviews">
                            No reviews yet. Be the first to share your experience!
                        </div>
                    @endif
                </div>
            </div>

            <!-- Hint footer: Hover to pause & swipe to scroll -->
            <div class="rm-reviews-scroll-hint">
                <i class="fa-solid fa-arrows-left-right"></i>
                <span>Auto-scrolling live feed &bull; Hover to pause &bull; Drag or swipe to explore</span>
            </div>
        </div>
    </div>
</section>

<!-- TRUST SECTION: Guarantees, Contact/WhatsApp Details, and Delivery/Return Policy -->
<section class="rm-trust-master-section">
    <div class="rm-trust-master-container">

        <!-- PART 2: Delivery & Return Policy Highlights -->
        <div class="rm-trust-guarantees-grid">
            <div class="rm-guarantee-box">
                <div class="rm-guarantee-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h4 class="rm-guarantee-title">Free Express Shipping</h4>
                <p class="rm-guarantee-desc">Poore Pakistan mein 2-4 business days ke andar doorstep delivery bilkul muft hai.</p>
            </div>
            <div class="rm-guarantee-box">
                <div class="rm-guarantee-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                <h4 class="rm-guarantee-title">Cash on Delivery (COD)</h4>
                <p class="rm-guarantee-desc">Baghair kisi advance transfer ya card ke, parcel pohnchne par courier ko cash ada karein.</p>
            </div>
            <div class="rm-guarantee-box">
                <div class="rm-guarantee-icon"><i class="fa-solid fa-box-open"></i></div>
                <h4 class="rm-guarantee-title">Open Parcel Allowed</h4>
                <p class="rm-guarantee-desc">Courier rider ke samnay parcel open karke tasalli se check karne ki mukammal ijazat hai.</p>
            </div>
            <div class="rm-guarantee-box">
                <div class="rm-guarantee-icon"><i class="fa-solid fa-shield-heart"></i></div>
                <h4 class="rm-guarantee-title">7-Day Return Guarantee</h4>
                <p class="rm-guarantee-desc">Agar aap result se mutma'in na hon to 7 din ke andar asaan return aur exchange policy available hai.</p>
            </div>
        </div>
    </div>
</section>

<!-- MODAL 1: Fast WhatsApp COD Checkout Modal -->
<div id="quickOrderModal" class="rm-modal-backdrop">
    <div class="rm-modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div>
                <span style="font-size: 0.72rem; font-weight: 700; color: var(--rm-gold-dark); text-transform: uppercase; letter-spacing: 0.08em;">Instant Doorstep Order</span>
                <h3 style="font-family: var(--rm-font-display); font-size: 1.25rem; font-weight: 700; color: var(--rm-dark); margin: 2px 0 0;" id="qModalProductTitle">
                    Order Amber's Roots Hair Oil
                </h3>
            </div>
            <button type="button" onclick="closeDirectOrderModal()" style="background: none; border: none; font-size: 1.25rem; color: #94a3b8; cursor: pointer; padding: 4px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="quickOrderForm" onsubmit="event.preventDefault(); submitQuickOrder();">
            <input type="hidden" id="qProductId" value="1">

            <!-- Quantity & Total Selector -->
            <div style="background: #faf8f3; border: 1px solid var(--rm-gold-border); border-radius: 8px; padding: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <label style="font-size: 0.78rem; font-weight: 700; color: var(--rm-dark); display: block; margin-bottom: 4px;">Quantity (Bottles):</label>
                    <div style="display: inline-flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 6px; background: #fff;">
                        <button type="button" onclick="adjustQuickQty(-1)" style="border: none; background: none; padding: 6px 12px; font-weight: 700; cursor: pointer; color: #475569;">-</button>
                        <span id="qQtyDisplay" style="padding: 6px 12px; font-weight: 700; font-size: 0.95rem; color: #0f172a;">1</span>
                        <button type="button" onclick="adjustQuickQty(1)" style="border: none; background: none; padding: 6px 12px; font-weight: 700; cursor: pointer; color: #475569;">+</button>
                    </div>
                </div>

                <div style="text-align: right;">
                    <span style="font-size: 0.72rem; color: #64748b; display: block;">Total Amount (COD):</span>
                    <strong id="qTotalDisplay" style="font-size: 1.35rem; font-weight: 800; color: var(--rm-dark); font-family: 'Cinzel', serif;">
                        Rs. 2,450
                    </strong>
                    <div style="font-size: 0.7rem; color: #15803d; font-weight: 700;">Free Delivery Included</div>
                </div>
            </div>

            <!-- Customer Details Fields -->
            <div style="margin-bottom: 10px;">
                <label class="rm-form-label" for="qCustName">Full Name *</label>
                <input type="text" id="qCustName" class="rm-form-input" placeholder="e.g. Fatima Zahra" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                <div>
                    <label class="rm-form-label" for="qCustPhone">Mobile Number *</label>
                    <input type="tel" id="qCustPhone" class="rm-form-input" placeholder="03XX XXXXXXX" required>
                </div>
                <div>
                    <label class="rm-form-label" for="qCustCity">City *</label>
                    <input type="text" id="qCustCity" class="rm-form-input" placeholder="e.g. Lahore, Karachi" required>
                </div>
            </div>

            <div style="margin-bottom: 12px;">
                <label class="rm-form-label" for="qCustAddress">Complete Delivery Address *</label>
                <input type="text" id="qCustAddress" class="rm-form-input" placeholder="House #, Street #, Mohalla / Sector" required>
            </div>

            <!-- Payment Method Notice (COD Only) -->
            <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 6px; padding: 10px 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-money-bill-wave" style="color: #15803d; font-size: 1.1rem;"></i>
                <div style="font-size: 0.8rem; color: #166534;">
                    <strong>Payment: Cash on Delivery (COD)</strong> &bull; Parcel milne par payment karein.
                </div>
            </div>

            <button type="submit" id="qSubmitBtn" class="rm-btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem; color: #25d366;"></i>
                <span>Confirm Order via WhatsApp</span>
            </button>
            <p style="text-align: center; font-size: 0.72rem; color: #94a3b8; margin-top: 8px;">
                Order will be saved in our system first, then WhatsApp will open for instant confirmation.
            </p>
        </form>
    </div>
</div>

<!-- MODAL 2: Write a Review Modal -->
<div id="writeReviewModal" class="rm-modal-backdrop">
    <div class="rm-modal-box" style="max-width: 520px; border-radius: 20px; border: 1.5px solid rgba(201, 147, 27, 0.35);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <div>
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--rm-gold-dark); text-transform: uppercase; letter-spacing: 0.1em; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-leaf"></i> Verified Buyer Community
                </span>
                <h3 style="font-family: var(--rm-font-display); font-size: 1.35rem; font-weight: 700; color: var(--rm-dark); margin: 4px 0 0;">
                    Share Your Honest Experience
                </h3>
            </div>
            <button type="button" onclick="closeReviewModal()" style="background: #f8fafc; border: 1px solid #e2e8f0; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #64748b; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="submitReviewForm" onsubmit="event.preventDefault(); handleReviewSubmit();">
            <!-- Interactive 5-Star Picker -->
            <div style="text-align: center; margin-bottom: 20px; background: #faf7f2; border: 1px dashed rgba(201, 147, 27, 0.35); border-radius: 14px; padding: 14px 16px;">
                <label style="font-size: 0.82rem; font-weight: 700; color: var(--rm-dark); display: block; margin-bottom: 8px;">
                    How Would You Rate Amber's Roots?
                </label>
                <div id="starRatingPicker" style="font-size: 2rem; color: #eab308; cursor: pointer; display: inline-flex; gap: 8px;">
                    <i class="fa-solid fa-star" data-val="1" onclick="setRating(1)"></i>
                    <i class="fa-solid fa-star" data-val="2" onclick="setRating(2)"></i>
                    <i class="fa-solid fa-star" data-val="3" onclick="setRating(3)"></i>
                    <i class="fa-solid fa-star" data-val="4" onclick="setRating(4)"></i>
                    <i class="fa-solid fa-star" data-val="5" onclick="setRating(5)"></i>
                </div>
                <input type="hidden" id="revRatingInput" value="5">
                <div id="revRatingLabel" style="font-size: 0.8rem; font-weight: 700; color: var(--rm-gold-dark); margin-top: 6px;">
                    5.0 ★ Outstanding Results &bull; Highly Recommended!
                </div>
            </div>

            <!-- Name and City in a 2-column grid -->
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <label class="rm-form-label" for="revName">Your Full Name *</label>
                    <input type="text" id="revName" class="rm-form-input" placeholder="e.g. Ayesha Khan" required>
                </div>
                <div>
                    <label class="rm-form-label" for="revCity">City / Location *</label>
                    <input type="text" id="revCity" class="rm-form-input" placeholder="e.g. Lahore / Karachi" required>
                </div>
            </div>

            <div style="margin-bottom: 12px;">
                <label class="rm-form-label" for="revPhone">Phone / WhatsApp Number (Optional, for COD verification)</label>
                <input type="tel" id="revPhone" class="rm-form-input" placeholder="03XX XXXXXXX">
                <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 3px;">
                    <i class="fa-solid fa-lock" style="font-size: 0.65rem;"></i> Kept 100% confidential. Never shown publicly.
                </span>
            </div>

            <div style="margin-bottom: 16px;">
                <label class="rm-form-label" for="revText">Your Honest Review &amp; Results *</label>
                <textarea id="revText" rows="3" class="rm-form-input" placeholder="Describe your experience: Did hair fall reduce? How long did it take? How is the texture, fragrance & results?..." required></textarea>
            </div>

            <button type="submit" id="revSubmitBtn" class="rm-btn-primary" style="width: 100%; justify-content: center; padding: 13px; font-weight: 700; font-size: 0.95rem; border-radius: 12px;">
                <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i>
                <span>Submit Verified Review</span>
            </button>
            <div id="revNotice" style="font-size: 0.74rem; text-align: center; margin-top: 10px; color: #64748b; line-height: 1.4;">
                <i class="fa-solid fa-shield-check" style="color: #10b981;"></i> Submitted feedback is verified against parcel dispatch records to preserve genuine buyer authenticity.
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
/* ==========================================================================
   AMBER'S ROOTS HOME HERO & PRODUCT DETAILS STYLING
   ========================================================================== */

/* Hero Price Card */
.rm-hero-price-card {
    background: #ffffff;
    border: 1.5px solid var(--rm-gold-border);
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 26px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
    max-width: 540px;
}

.rm-hero-price-line {
    display: flex;
    align-items: baseline;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 6px;
}

.rm-hero-price-current {
    font-family: 'Cinzel', serif;
    font-size: 2.1rem;
    font-weight: 800;
    color: var(--rm-dark);
}

.rm-hero-price-original {
    font-size: 1.2rem;
    color: #94a3b8;
    text-decoration: line-through;
}

.rm-hero-save-badge {
    background: #dcfce7;
    color: #15803d;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 9999px;
    border: 1px solid #bbf7d0;
    letter-spacing: 0.02em;
}

.rm-hero-delivery-tag {
    font-size: 0.82rem;
    color: #4b5563;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
}

.rm-hero-cta-order {
    padding: 16px 32px;
    font-size: 0.96rem;
}

.rm-hero-cta-wa {
    padding: 16px 28px;
    font-size: 0.96rem;
}

.rm-hero-social-proof {
    margin-top: 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.rm-hero-rating-stars {
    display: flex;
    align-items: center;
    gap: 8px;
}

.rm-hero-rating-score {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
}

.rm-hero-divider {
    color: #cbd5e1;
}

.rm-hero-proof-text {
    font-size: 0.88rem;
    color: #64748b;
    font-weight: 500;
}

/* Hero Bottle Stage */
.rm-hero-bottle-stage {
    position: relative;
    background: radial-gradient(circle at 50% 50%, rgba(197, 160, 89, 0.22) 0%, rgba(250, 248, 243, 0.9) 65%, #ffffff 100%);
    border: 2px solid var(--rm-gold-border);
    border-radius: 28px;
    padding: 38px 24px 34px;
    box-shadow: 0 20px 50px rgba(10, 56, 24, 0.09);
    text-align: center;
}

.rm-bottle-badge-discount {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #dc2626;
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 9999px;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
    z-index: 3;
}

.rm-bottle-badge-bestseller {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--rm-gold-gradient);
    color: #121316;
    font-size: 0.74rem;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 9999px;
    box-shadow: 0 4px 12px rgba(201, 147, 27, 0.25);
    z-index: 3;
}

.rm-hero-bottle-wrap {
    height: 440px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px auto 14px;
}

.rm-hero-bottle-img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    filter: drop-shadow(0 20px 36px rgba(10, 56, 24, 0.22));
}

/* Value Pillars Section */
.rm-value-pillars-section {
    position: relative;
    z-index: 2;
    background: #ffffff;
    padding: 34px 20px;
    border-top: 1px solid var(--rm-border);
    border-bottom: 1px solid var(--rm-border);
}

.rm-benefits-grid {
    max-width: 1320px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.rm-pillar-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px;
}

.rm-pillar-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--rm-gold-subtle);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rm-gold-dark);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.rm-pillar-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--rm-dark);
    margin: 0 0 2px 0;
}

.rm-pillar-sub {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0;
}

/* ==========================================================================
   CENTER PRODUCT DISPLAY SECTION (Sirf Image aur Dynamic Discount Offer)
   ========================================================================== */
.rm-home-center-product-section {
    position: relative;
    z-index: 1;
    padding: 60px 20px 40px;
    max-width: 1240px;
    margin: 0 auto;
}

.rm-home-center-product-container {
    max-width: 540px;
    margin: 0 auto;
    text-align: center;
}

.rm-center-product-card {
    display: block;
    text-decoration: none;
    color: inherit;
    background: radial-gradient(circle at 50% 35%, #ffffff 0%, #faf6ee 65%, #ede3cf 100%);
    border: 2px solid var(--rm-gold-border);
    border-radius: 28px;
    padding: 44px 28px 36px;
    position: relative;
    box-shadow: 0 20px 50px rgba(10, 56, 24, 0.08);
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: pointer;
    overflow: hidden;
}

.rm-center-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 28px 60px rgba(10, 56, 24, 0.15);
    border-color: var(--rm-gold-primary);
}

.rm-center-discount-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #dc2626;
    color: #ffffff;
    font-size: 0.88rem;
    font-weight: 800;
    padding: 7px 16px;
    border-radius: 9999px;
    text-transform: uppercase;
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    z-index: 3;
}

.rm-center-badge-pill {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--rm-gold-gradient);
    color: #121316;
    font-size: 0.74rem;
    font-weight: 800;
    padding: 6px 16px;
    border-radius: 9999px;
    letter-spacing: 0.06em;
    z-index: 3;
    box-shadow: 0 4px 12px rgba(201, 147, 27, 0.25);
}

.rm-center-img-holder {
    width: 320px;
    height: 400px;
    margin: 10px auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rm-center-product-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 20px 38px rgba(10, 56, 24, 0.22));
    transition: transform 0.4s ease;
}

.rm-center-product-card:hover .rm-center-product-img {
    transform: scale(1.05);
}

@media (max-width: 600px) {
    .rm-center-img-holder {
        width: 240px;
        height: 300px;
    }
    .rm-center-product-card {
        padding: 30px 18px;
        border-radius: 20px;
    }
}

/* ==========================================================================
   TRUST SECTION: Reviews, Guarantees & Support
   ========================================================================== */
.rm-trust-master-section {
    background: #ffffff;
    padding: 50px 20px;
    border-bottom: 1px solid var(--rm-border);
}

.rm-trust-master-container {
    max-width: 1240px;
    margin: 0 auto;
}

/* ==========================================================================
   REVIEWS MASTER SECTION - ROYAL FOOTER DEEP GREEN THEME
   ========================================================================== */
.rm-reviews-master-section {
    background: var(--rm-dark);
    background: linear-gradient(180deg, #072610 0%, #0a3818 50%, #06220e 100%);
    padding: 75px 20px 80px;
    border-top: 2px solid var(--rm-gold-border);
    border-bottom: 2px solid var(--rm-gold-border);
    position: relative;
    overflow: hidden;
}

/* Subtle luxury gold glow in the center */
.rm-reviews-master-section::before {
    content: '';
    position: absolute;
    top: -80px;
    left: 50%;
    transform: translateX(-50%);
    width: 850px;
    height: 450px;
    background: radial-gradient(circle, rgba(201, 147, 27, 0.12) 0%, transparent 70%);
    pointer-events: none;
}

.rm-reviews-master-container {
    max-width: 1240px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.rm-reviews-block {
    margin-bottom: 0;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.rm-reviews-block.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Header Area */
.rm-reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.rm-reviews-header-info {
    max-width: 680px;
}

.rm-reviews-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--rm-gold-light);
    background: rgba(201, 147, 27, 0.15);
    border: 1px solid rgba(201, 147, 27, 0.35);
    padding: 5px 14px;
    border-radius: 9999px;
    margin-bottom: 12px;
}

.rm-pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: rmPulseGlow 2s infinite;
}

@keyframes rmPulseGlow {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.rm-reviews-title {
    font-family: var(--rm-font-display);
    font-size: clamp(1.85rem, 3.4vw, 2.45rem);
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 10px;
    line-height: 1.25;
    letter-spacing: -0.01em;
}

.rm-reviews-rating-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.rm-reviews-stars {
    color: #f59e0b;
    font-size: 1rem;
    letter-spacing: 2.5px;
}

.rm-reviews-score {
    font-weight: 800;
    color: #ffffff;
    font-size: 0.95rem;
}

.rm-reviews-badge-txt {
    color: rgba(255, 255, 255, 0.72);
    font-size: 0.85rem;
}

/* Header Actions */
.rm-reviews-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.rm-btn-write-review {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    border: 1.5px solid var(--rm-gold-primary);
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
    transition: all 0.25s ease;
}

.rm-btn-write-review i {
    color: var(--rm-gold-light);
    transition: color 0.25s ease;
}

.rm-btn-write-review:hover {
    background: var(--rm-gold-gradient);
    color: #121316;
    border-color: var(--rm-gold-primary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(201, 147, 27, 0.35);
}

.rm-btn-write-review:hover i {
    color: #121316;
}

.rm-carousel-nav-btns {
    display: flex;
    align-items: center;
    gap: 8px;
}

.rm-carousel-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1.5px solid rgba(201, 147, 27, 0.35);
    color: #ffffff;
    font-size: 0.95rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.rm-carousel-btn:hover {
    background: var(--rm-gold-primary);
    color: #121316;
    border-color: var(--rm-gold-primary);
    transform: scale(1.06);
}

/* Continuous Scroll Ribbon with Gradient Fade Masks */
.rm-reviews-carousel-wrapper {
    position: relative;
    overflow: hidden;
    padding: 16px 0 20px;
    mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
    cursor: grab;
}

.rm-reviews-carousel-wrapper:active {
    cursor: grabbing;
}

.rm-reviews-carousel-track {
    display: flex;
    gap: 22px;
    width: max-content;
    will-change: transform;
    user-select: none;
    padding: 8px 4px;
}

.rm-carousel-slide {
    flex: 0 0 365px;
    width: 365px;
    max-width: 82vw;
}

/* Review Card Styling - Crisp White Cards with Gold Accents */
.rm-review-card {
    position: relative;
    background: #ffffff;
    border: 1.5px solid rgba(201, 147, 27, 0.28);
    border-radius: 20px;
    padding: 26px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    min-height: 235px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.28);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease, box-shadow 0.35s ease;
    overflow: hidden;
}

.rm-card-watermark {
    position: absolute;
    top: 14px;
    right: 18px;
    font-size: 2.8rem;
    color: rgba(201, 147, 27, 0.08);
    pointer-events: none;
    line-height: 1;
}

.rm-review-card:hover {
    transform: translateY(-6px);
    border-color: var(--rm-gold-primary);
    box-shadow: 0 20px 45px rgba(201, 147, 27, 0.25);
}

.rm-review-card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    position: relative;
    z-index: 1;
}

.rm-review-card-stars {
    color: #eab308;
    font-size: 0.88rem;
    letter-spacing: 2px;
}

.rm-review-card-date {
    font-size: 0.74rem;
    color: #94a3b8;
    font-weight: 500;
}

.rm-review-card-text {
    font-size: 0.925rem;
    color: #334155;
    line-height: 1.65;
    margin: 0 0 18px;
    font-style: italic;
    flex: 1;
    position: relative;
    z-index: 1;
}

.rm-review-card-author {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 1px solid #f1ece4;
    padding-top: 14px;
    position: relative;
    z-index: 1;
}

.rm-review-card-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dfb15b 0%, #c9931b 100%);
    color: #121316;
    font-weight: 800;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(201, 147, 27, 0.2);
}

.rm-review-author-meta {
    min-width: 0;
}

.rm-review-card-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--rm-dark);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rm-review-card-verified {
    font-size: 0.72rem;
    color: #15803d;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

.rm-review-card-verified i {
    color: #10b981;
    font-size: 0.75rem;
}

/* Hint footer */
.rm-reviews-scroll-hint {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 18px;
    font-size: 0.78rem;
    color: rgba(255, 255, 255, 0.7);
    text-align: center;
}

.rm-reviews-scroll-hint i {
    color: var(--rm-gold-light);
    font-size: 0.75rem;
}

@media (max-width: 640px) {
    .rm-reviews-master-section {
        padding: 45px 14px 50px;
    }
    .rm-carousel-slide {
        flex: 0 0 290px;
        width: 290px;
        max-width: calc(100vw - 28px);
    }
    .rm-review-card {
        padding: 20px 16px;
    }
    .rm-reviews-actions {
        width: 100%;
        justify-content: space-between;
    }
    .rm-btn-write-review {
        flex: 1;
        justify-content: center;
    }
}

@media (max-width: 380px) {
    .rm-reviews-master-section {
        padding: 35px 10px 40px;
    }
    .rm-reviews-title {
        font-size: 1.35rem;
    }
    .rm-carousel-slide {
        flex: 0 0 calc(100vw - 24px);
        width: calc(100vw - 24px);
        max-width: 260px;
    }
    .rm-review-card {
        padding: 16px 14px;
    }
    .rm-reviews-rating-bar {
        font-size: 0.75rem;
        gap: 6px;
    }
    .rm-reviews-score {
        font-size: 0.82rem;
    }
    .rm-btn-write-review {
        padding: 8px 12px;
        font-size: 0.78rem;
    }
}

/* Micro screens (234px - 280px) */
@media (max-width: 280px) {
    .rm-reviews-master-section {
        padding: 26px 6px 30px;
    }
    .rm-reviews-title {
        font-size: 1.15rem;
    }
    .rm-reviews-eyebrow {
        font-size: 0.65rem;
    }
    .rm-carousel-slide {
        flex: 0 0 calc(100vw - 16px);
        width: calc(100vw - 16px);
        max-width: 215px;
    }
    .rm-review-card {
        padding: 12px 10px;
    }
    .rm-review-card-avatar {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
    .rm-review-card-name {
        font-size: 0.78rem;
    }
    .rm-review-card-verified {
        font-size: 0.64rem;
    }
    .rm-review-card-text {
        font-size: 0.78rem;
        line-height: 1.45;
    }
}

/* Guarantees 4-Grid */
.rm-trust-guarantees-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 0;
}

.rm-guarantee-box {
    background: #fcfaf7;
    border: 1.5px solid var(--rm-border);
    border-radius: 16px;
    padding: 24px 20px;
    text-align: center;
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.rm-guarantee-box:hover {
    transform: translateY(-3px);
    border-color: var(--rm-gold-border);
}

.rm-guarantee-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: var(--rm-gold-subtle);
    color: var(--rm-gold-dark);
    font-size: 1.35rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
}

.rm-guarantee-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--rm-dark);
    margin: 0 0 8px 0;
}

.rm-guarantee-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0;
    line-height: 1.45;
}

/* Contact / Support Card */
.rm-contact-support-card {
    background: linear-gradient(135deg, #0f291e 0%, #1b4332 100%);
    border-radius: 24px;
    padding: 40px 36px;
    color: #ffffff;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 32px;
    align-items: center;
    box-shadow: 0 16px 40px rgba(15, 41, 30, 0.2);
}

.rm-support-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(197, 160, 89, 0.2);
    color: var(--rm-gold-light);
    border: 1px solid rgba(197, 160, 89, 0.35);
    padding: 4px 14px;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.rm-support-title {
    font-family: var(--rm-font-display);
    font-size: 1.85rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 10px 0;
}

.rm-support-desc {
    font-size: 0.92rem;
    color: #d1d5db;
    line-height: 1.6;
    margin: 0 0 20px 0;
}

.rm-support-contact-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.rm-info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.86rem;
    color: #e5e7eb;
}

.rm-info-item i {
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

.rm-support-right {
    text-align: center;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 18px;
    padding: 30px 24px;
}

.rm-btn-wa-live {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    background: #25d366;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 9999px;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    transition: transform 0.2s ease, filter 0.2s ease;
}

.rm-btn-wa-live:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
}

.rm-btn-wa-live i {
    font-size: 1.35rem;
}

.rm-support-response-time {
    display: block;
    font-size: 0.78rem;
    color: #9ca3af;
    margin-top: 12px;
}

/* Responsive Media Queries */
@media (max-width: 1024px) {
    .rm-benefits-grid,
    .rm-trust-guarantees-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .rm-details-grid-layout {
        grid-template-columns: 1fr;
    }
    .rm-details-left-visual {
        position: static;
    }
    .rm-contact-support-card {
        grid-template-columns: 1fr;
    }
    .rm-carousel-slide {
        flex: 0 0 calc((100% - 22px) / 2);
    }
}

@media (max-width: 640px) {
    .rm-hero-bottle-wrap {
        height: 320px;
    }
    .rm-benefits-grid,
    .rm-trust-guarantees-grid {
        grid-template-columns: 1fr;
    }
    .rm-contact-support-card {
        padding: 26px 20px;
    }
}

@media (max-width: 480px) {
    .rm-hero-bottle-wrap {
        height: 260px;
    }
    .rm-guarantee-box {
        padding: 16px 12px;
    }
}

/* Micro screens (234px - 280px) */
@media (max-width: 280px) {
    .rm-hero-bottle-wrap {
        height: 200px;
    }
    .rm-guarantee-box {
        padding: 12px 8px;
    }
    .rm-guarantee-icon {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        margin-bottom: 8px;
    }
    .rm-guarantee-title {
        font-size: 0.88rem;
    }
    .rm-guarantee-desc {
        font-size: 0.72rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Direct / Quick Order Modal Logic
    let currentProdId = 1;
    let currentProdPrice = 2450;
    let currentQuickQty = 1;

    function openDirectOrderModal(id, title, price) {
        currentProdId = id;
        currentProdPrice = price;
        currentQuickQty = 1;

        document.getElementById('qProductId').value = id;
        document.getElementById('qModalProductTitle').textContent = 'Order ' + title;
        document.getElementById('qQtyDisplay').textContent = 1;
        document.getElementById('qTotalDisplay').textContent = 'Rs. ' + price.toLocaleString();

        document.getElementById('quickOrderModal').classList.add('active');
    }

    function closeDirectOrderModal() {
        document.getElementById('quickOrderModal').classList.remove('active');
    }

    function adjustQuickQty(delta) {
        currentQuickQty = Math.max(1, currentQuickQty + delta);
        document.getElementById('qQtyDisplay').textContent = currentQuickQty;
        const total = currentQuickQty * currentProdPrice;
        document.getElementById('qTotalDisplay').textContent = 'Rs. ' + total.toLocaleString();
    }

    function submitQuickOrder() {
        const name = document.getElementById('qCustName').value.trim();
        const phone = document.getElementById('qCustPhone').value.trim();
        const city = document.getElementById('qCustCity').value.trim();
        const address = document.getElementById('qCustAddress').value.trim();
        const btn = document.getElementById('qSubmitBtn');

        if (!name || !phone || !city || !address) {
            AmberAlert.warning('Please fill in your name, mobile number, city, and address.', 'Delivery Details Required');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Placing Order...';

        fetch('/orders/place', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: currentProdId,
                quantity: currentQuickQty,
                customer_name: name,
                customer_phone: phone,
                city: city,
                shipping_address: address
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeDirectOrderModal();
                AmberAlert.success('Order #' + data.order_number + ' recorded successfully! Opening WhatsApp for confirmation...', 'Order Placed');
                setTimeout(() => {
                    window.open(data.whatsapp_url, '_blank');
                }, 700);
            } else {
                AmberAlert.error(data.message || 'Could not place order. Please try again.', 'Order Notice');
            }
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-brands fa-whatsapp" style="font-size: 1.2rem; color: #25d366;"></i> <span>Confirm Order via WhatsApp</span>';
        })
        .catch(err => {
            AmberAlert.error('Could not connect to server. Please try again.', 'Connection Error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-brands fa-whatsapp" style="font-size: 1.2rem; color: #25d366;"></i> <span>Confirm Order via WhatsApp</span>';
        });
    }

    // Write Review Modal Logic & Interactive Rating
    function openReviewModal() {
        document.getElementById('writeReviewModal').classList.add('active');
    }

    function closeReviewModal() {
        document.getElementById('writeReviewModal').classList.remove('active');
    }

    const ratingDescriptions = {
        5: "5.0 ★ Outstanding Results &bull; Highly Recommended! 🌟",
        4: "4.0 ★ Very Good &bull; Noticeable Hair Improvement! 👍",
        3: "3.0 ★ Good &bull; Decent Results &bull; Satisfied 😊",
        2: "2.0 ★ Fair &bull; Average Experience 😐",
        1: "1.0 ★ Poor &bull; Needs Improvement 😞"
    };

    function setRating(val) {
        document.getElementById('revRatingInput').value = val;
        const stars = document.querySelectorAll('#starRatingPicker i');
        stars.forEach((star, index) => {
            if (index < val) {
                star.className = 'fa-solid fa-star';
            } else {
                star.className = 'fa-regular fa-star';
            }
        });
        const label = document.getElementById('revRatingLabel');
        if (label && ratingDescriptions[val]) {
            label.innerHTML = ratingDescriptions[val];
        }
    }

    function handleReviewSubmit() {
        const rating = document.getElementById('revRatingInput').value;
        const name = document.getElementById('revName').value.trim();
        const city = document.getElementById('revCity') ? document.getElementById('revCity').value.trim() : '';
        const phone = document.getElementById('revPhone').value.trim();
        const text = document.getElementById('revText').value.trim();
        const btn = document.getElementById('revSubmitBtn');

        if (!name || !text) {
            AmberAlert.warning('Please enter your name and honest review text.', 'Required Fields');
            return;
        }

        const fullName = city ? `${name} (${city})` : name;

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';

        fetch('/reviews/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: currentProdId,
                customer_name: fullName,
                customer_phone: phone,
                rating: parseInt(rating),
                review_text: text
            })
        })
        .then(res => res.json())
        .then(data => {
            closeReviewModal();
            AmberAlert.success(
                data.message || "Thank you for sharing your experience! Your review will be displayed after quick verification.",
                data.title || "Review Submitted Successfully!"
            );
            document.getElementById('submitReviewForm').reset();
            setRating(5);
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> <span>Submit Verified Review</span>';
        })
        .catch(err => {
            AmberAlert.error('Could not submit review. Please try again.', 'Submission Error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> <span>Submit Verified Review</span>';
        });
    }

    // Real Customer Feedback: Silky Smooth Continuous Drift & Interaction
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('reviewsCarouselWrapper');
        const track = document.getElementById('reviewsCarouselTrack');
        const prevBtn = document.getElementById('reviewsPrevBtn');
        const nextBtn = document.getElementById('reviewsNextBtn');
        const block = document.getElementById('rmReviewsBlock') || document.querySelector('.rm-reviews-block');

        if (!track || !wrapper) return;

        // 1. Scroll-triggered entrance reveal
        if (block && 'IntersectionObserver' in window) {
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        block.classList.add('is-visible');
                        sectionObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            sectionObserver.observe(block);
        } else if (block) {
            block.classList.add('is-visible');
        }

        const slides = track.querySelectorAll('.rm-carousel-slide');
        if (!slides || slides.length === 0) return;

        let currentX = 0;
        let speed = 0.65; // pixels per frame (smooth, calm, elegant drift)
        let isPaused = false;
        let isDragging = false;
        let startPointerX = 0;
        let dragStartX = 0;
        let rafId = null;
        let isVisibleOnScreen = true;
        let pauseTimeout = null;

        function getSlideStep() {
            const firstSlide = slides[0];
            return firstSlide ? (firstSlide.offsetWidth + 22) : 377;
        }

        function getHalfWidth() {
            return track.scrollWidth / 2;
        }

        function temporaryPause(duration = 3500) {
            isPaused = true;
            if (pauseTimeout) clearTimeout(pauseTimeout);
            pauseTimeout = setTimeout(() => {
                isPaused = false;
            }, duration);
        }

        // 2. High-Performance Subpixel Continuous Animation Loop
        function tick() {
            if (!isPaused && !isDragging && isVisibleOnScreen) {
                currentX -= speed;
                const halfWidth = getHalfWidth();
                if (halfWidth > 0 && Math.abs(currentX) >= halfWidth) {
                    currentX += halfWidth;
                }
                track.style.transform = `translate3d(${currentX}px, 0, 0)`;
            }
            rafId = requestAnimationFrame(tick);
        }

        rafId = requestAnimationFrame(tick);

        // 3. Pause on Desktop Hover
        wrapper.addEventListener('mouseenter', () => { isPaused = true; });
        wrapper.addEventListener('mouseleave', () => { if (!isDragging) isPaused = false; });

        // 4. Touch Gestures on Mobile
        wrapper.addEventListener('touchstart', (e) => {
            isPaused = true;
            startPointerX = e.touches[0].clientX;
            dragStartX = currentX;
            isDragging = true;
        }, { passive: true });

        wrapper.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const diff = e.touches[0].clientX - startPointerX;
            currentX = dragStartX + diff;
            const halfWidth = getHalfWidth();
            if (currentX > 0) currentX -= halfWidth;
            if (Math.abs(currentX) >= halfWidth) currentX += halfWidth;
            track.style.transform = `translate3d(${currentX}px, 0, 0)`;
        }, { passive: true });

        wrapper.addEventListener('touchend', () => {
            isDragging = false;
            temporaryPause(2500);
        }, { passive: true });

        // 5. Mouse Drag-to-Scroll on Desktop
        wrapper.addEventListener('mousedown', (e) => {
            isPaused = true;
            isDragging = true;
            startPointerX = e.clientX;
            dragStartX = currentX;
            wrapper.style.cursor = 'grabbing';
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const diff = e.clientX - startPointerX;
            currentX = dragStartX + diff;
            const halfWidth = getHalfWidth();
            if (currentX > 0) currentX -= halfWidth;
            if (Math.abs(currentX) >= halfWidth) currentX += halfWidth;
            track.style.transform = `translate3d(${currentX}px, 0, 0)`;
        });

        window.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                wrapper.style.cursor = 'grab';
                temporaryPause(2500);
            }
        });

        // 6. Navigation Buttons (Smooth Animated Shift)
        function animateShift(distance) {
            temporaryPause(4000);
            const start = currentX;
            const duration = 400;
            const startTime = performance.now();

            function easeOutCubic(t) {
                return (--t) * t * t + 1;
            }

            function stepShift(now) {
                const elapsed = now - startTime;
                const progress = Math.min(1, elapsed / duration);
                const eased = easeOutCubic(progress);
                currentX = start + (distance * eased);

                const halfWidth = getHalfWidth();
                if (currentX > 0) currentX -= halfWidth;
                if (Math.abs(currentX) >= halfWidth) currentX += halfWidth;

                track.style.transform = `translate3d(${currentX}px, 0, 0)`;

                if (progress < 1) {
                    requestAnimationFrame(stepShift);
                }
            }
            requestAnimationFrame(stepShift);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                animateShift(-getSlideStep());
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                animateShift(getSlideStep());
            });
        }

        // 7. Viewport Observer (Save GPU when off-screen)
        if ('IntersectionObserver' in window) {
            const visibilityObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    isVisibleOnScreen = entry.isIntersecting;
                });
            }, { threshold: 0.05 });
            visibilityObserver.observe(wrapper);
        }
    });
</script>
@endpush
@endsection
