@extends('layouts.app')

@section('title', $product['title'] . " – Amber's Roots")

@section('content')
<!-- Breadcrumbs -->
<div style="background: #faf8f5; border-bottom: 1px solid var(--rm-border); padding: 14px 24px;">
    <div style="max-width: 1320px; margin: 0 auto; font-size: 0.8125rem; color: #64748b; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="{{ url('/') }}" style="color: #64748b;">Home</a>
        <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #cbd5e1;"></i>
        <a href="{{ url('/products') }}" style="color: #64748b;">Products</a>
        <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #cbd5e1;"></i>
        <span style="color: var(--rm-gold-dark); font-weight: 600;">{{ $product['title'] }}</span>
    </div>
</div>

<!-- Product Detail Container -->
<section class="rm-detail-section" style="padding: 40px 20px; max-width: 1320px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: 1fr 1.15fr; gap: 40px; align-items: start;" class="rm-product-detail-layout">
        
        @php
            $galleryList = $product->gallery_images;
            if (empty($galleryList) || count($galleryList) < 4) {
                $galleryList = [
                    asset('assets/product/1000082361.jpg'),
                    asset('assets/product/1000082362.jpg'),
                    asset('assets/product/1000082363.jpg'),
                    asset('assets/product/1000082365.jpg'),
                ];
            }
            $initialMainImage = $galleryList[0];
        @endphp

        <!-- Left: Product Showcase Gallery (4 Images) -->
        <div class="rm-gallery-column">
            <div class="rm-gallery-card">
                @if(isset($product['badge']))
                    <span class="rm-gallery-badge-featured">
                        {{ $product['badge'] }}
                    </span>
                @endif
                @if(!empty($product['discount']))
                    <span class="rm-gallery-badge-discount">
                        {{ $product['discount'] }}
                    </span>
                @endif

                <!-- Main Display Image Stage -->
                <div class="rm-detail-stage" id="detailStageWrap">
                    <img id="detailActiveImg" 
                         src="{{ $initialMainImage }}" 
                         alt="{{ $product['title'] }}" 
                         class="rm-detail-active-img"
                         onerror="this.onerror=null; this.src='{{ asset('assets/product/1000082361.jpg') }}';">

                    <!-- Prev / Next Stage Arrows -->
                    <button type="button" class="rm-stage-arrow rm-stage-arrow-prev" onclick="cycleProductGallery(-1)" aria-label="Previous Image">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="rm-stage-arrow rm-stage-arrow-next" onclick="cycleProductGallery(1)" aria-label="Next Image">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <!-- Active Image Counter Badge -->
                    <div class="rm-stage-counter" id="detailGalleryCounter">
                        1 / {{ count($galleryList) }}
                    </div>
                </div>

                <!-- 4 Interactive Gallery Thumbnails -->
                <div class="rm-gallery-thumbs-grid" id="detailThumbsGrid">
                    @foreach($galleryList as $index => $thumbUrl)
                        <div class="rm-gallery-thumb-item {{ $index === 0 ? 'is-active' : '' }}" 
                             onclick="selectProductGalleryImage({{ $index }})" 
                             onmouseenter="selectProductGalleryImage({{ $index }})"
                             data-index="{{ $index }}"
                             data-src="{{ $thumbUrl }}"
                             title="Photo {{ $index + 1 }} - Amber's Roots">
                            <img src="{{ $thumbUrl }}" alt="{{ $product['title'] }} Photo {{ $index + 1 }}">
                            <span class="rm-thumb-dot-badge">{{ $index + 1 }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="rm-organic-cert-pill">
                    <i class="fa-solid fa-leaf" style="color: #16a34a; margin-right: 6px;"></i> 100% Certified Organic & Ayurvedic
                </div>
            </div>

            <!-- Trust Badges Under Image -->
            <div class="rm-trust-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 20px;">
                <div style="background: #ffffff; padding: 14px; border-radius: 12px; border: 1px solid var(--rm-border); display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-truck-fast" style="font-size: 1.4rem; color: var(--rm-gold-dark);"></i>
                    <div style="font-size: 0.8125rem;">
                        <strong>Free Delivery</strong>
                        <div style="color: #64748b;">All across Pakistan</div>
                    </div>
                </div>
                <div style="background: #ffffff; padding: 14px; border-radius: 12px; border: 1px solid var(--rm-border); display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 1.4rem; color: #16a34a;"></i>
                    <div style="font-size: 0.8125rem;">
                        <strong>Cash on Delivery</strong>
                        <div style="color: #64748b;">Pay at your doorstep</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Product Info & Purchase Actions -->
        <div>
            <div style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--rm-gold-dark); letter-spacing: 0.15em; margin-bottom: 6px;">
                Amber's Roots &bull; Pure Herbs
            </div>

            <h1 class="rm-detail-h1" style="font-family: var(--rm-font-display); font-size: clamp(1.4rem, 4vw, 2.3rem); font-weight: 700; color: var(--rm-dark); line-height: 1.2; margin-bottom: 12px;">
                {{ $product['title'] }}
            </h1>

            <!-- Ratings -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                <div style="display: flex; color: #eab308; font-size: 0.95rem; gap: 3px;">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <span style="font-size: 0.875rem; font-weight: 700; color: var(--rm-dark);">{{ $product['rating'] }} / 5.0</span>
                <span style="color: #cbd5e1;">&bull;</span>
                <span style="font-size: 0.875rem; color: #64748b;">({{ number_format($product['reviews_count']) }} Customer Reviews)</span>
            </div>

            <!-- Price Block -->
            <div class="rm-detail-price-box" style="background: #faf8f5; border: 1px solid var(--rm-gold-border); border-radius: 14px; padding: 18px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div>
                    <div style="display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap;">
                        <span class="rm-detail-price-val" style="font-size: clamp(1.4rem, 4.5vw, 2rem); font-weight: 800; color: var(--rm-gold-dark);" id="displayProductPrice">Rs. {{ number_format($product['price']) }}</span>
                        <span style="text-decoration: line-through; color: #94a3b8; font-size: 1.15rem;">Rs. {{ number_format($product['original_price']) }}</span>
                    </div>
                    <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 4px;">
                        <i class="fa-solid fa-circle-check"></i> In Stock &ndash; Ships within 24 Hours
                    </div>
                </div>
                <div style="background: var(--rm-gold-subtle); color: var(--rm-gold-dark); border: 1px solid var(--rm-gold-border); padding: 6px 14px; border-radius: 9999px; font-weight: 700; font-size: 0.8125rem;">
                    You Save Rs. {{ number_format($product['original_price'] - $product['price']) }}
                </div>
            </div>

            <!-- Short Description -->
            <p style="color: #4b5563; font-size: 0.95rem; line-height: 1.7; margin-bottom: 24px;">
                {{ $product['short_desc'] }}
            </p>

            <!-- Size / Volume Options -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: #334155; margin-bottom: 8px;">
                    Select Volume / Package:
                </label>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="rm-tag-chip" style="background: var(--rm-dark); color: #ffffff; border-color: var(--rm-dark); font-weight: 700;">
                        {{ $product['volume'] }} (Standard)
                    </button>
                    <button type="button" class="rm-tag-chip" onclick="showToast('Double pack offer: 15% extra off applied!');">
                        Duo Value Pack (Save 15%)
                    </button>
                </div>
            </div>

            <!-- Quantity & Add to Cart Controls -->
            <div class="rm-detail-controls-row" style="display: flex; gap: 14px; align-items: center; margin-bottom: 16px; flex-wrap: wrap;">
                <!-- Quantity Picker -->
                <div class="rm-detail-qty-picker" style="display: inline-flex; align-items: center; border: 1.5px solid var(--rm-border); border-radius: var(--rm-radius-full); background: #ffffff; padding: 4px;">
                    <button type="button" id="qtyMinus" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #334155;">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span id="qtyValue" style="width: 44px; text-align: center; font-weight: 700; font-size: 1.05rem; color: var(--rm-dark);">1</span>
                    <button type="button" id="qtyPlus" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #334155;">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <!-- Add To Cart Main Button -->
                <button type="button" class="rm-btn-primary" style="flex: 1; justify-content: center; padding: 16px 28px; font-size: 1.05rem;" 
                        id="addToCartDetailBtn"
                        data-add-to-cart 
                        data-product-title="{{ $product['title'] }}" 
                        data-product-price="Rs. {{ number_format($product['price']) }}"
                        data-product-slug="{{ $product['slug'] }}"
                        data-product-icon="{{ $product['icon'] }}"
                        data-product-image="{{ asset($product['image'] ?? 'assets/product/1000082361.jpg') }}">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>Add to Cart</span>
                </button>
            </div>

            <!-- Buy With Cash On Delivery Express Button -->
            <button type="button" class="rm-btn-primary" style="width: 100%; justify-content: center; background: var(--rm-gold-gradient); color: #121316; border-color: transparent; padding: 16px; font-size: 1.05rem; margin-bottom: 16px; box-shadow: var(--rm-shadow-gold);"
                    onclick="triggerCodDirectCheckout('{{ $product['title'] }}', 'Rs. {{ number_format($product['price']) }}', '{{ $product['slug'] }}', '{{ $product['icon'] }}', '{{ asset($product['image'] ?? 'assets/product/1000082361.jpg') }}');">
                <i class="fa-solid fa-hand-holding-dollar" style="font-size: 1.2rem;"></i>
                <span>Buy with Cash on Delivery (Instant Order)</span>
            </button>

            <!-- WhatsApp Direct Order -->
            <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello ' . ($storeName ?? "Amber's Roots") . '! I want to order ' . $product['title'] . ' with Cash on Delivery.') }}" 
               target="_blank" 
               class="rm-btn-secondary" 
               style="width: 100%; justify-content: center; padding: 14px; border-color: #25d366; color: #15803d;">
                <i class="fa-brands fa-whatsapp" style="color: #25d366; font-size: 1.25rem;"></i>
                <span>Order via WhatsApp ({{ $storePhone ?? '+92 327 2222180' }})</span>
            </a>

            <!-- Quick Guarantee Ribbon -->
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--rm-border); display: flex; gap: 20px; font-size: 0.8125rem; color: #64748b; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-shield-halved" style="color: #16a34a;"></i>
                    <span>100% Original Formula</span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left" style="color: var(--rm-gold-dark);"></i>
                    <span>7-Day Return Policy</span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-truck" style="color: #0284c7;"></i>
                    <span>Doorstep COD in Pakistan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Info Tabs (Benefits, Ingredients, How to Use, Reviews) -->
<section style="background: #ffffff; padding: 60px 24px; border-top: 1px solid var(--rm-border); border-bottom: 1px solid var(--rm-border);">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        <!-- Tab Navigation -->
        <div style="display: flex; gap: 12px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 32px; overflow-x: auto;">
            <button type="button" class="rm-tab-btn active" data-tab="tab-benefits" style="padding: 10px 20px; font-size: 0.95rem; font-weight: 700; color: var(--rm-gold-dark); border-bottom: 3px solid var(--rm-gold-primary); background: none;">
                🌿 Key Benefits
            </button>
            <button type="button" class="rm-tab-btn" data-tab="tab-ingredients" style="padding: 10px 20px; font-size: 0.95rem; font-weight: 600; color: #64748b; background: none;">
                🧪 Herbal Ingredients
            </button>
            <button type="button" class="rm-tab-btn" data-tab="tab-usage" style="padding: 10px 20px; font-size: 0.95rem; font-weight: 600; color: #64748b; background: none;">
                📖 How to Use
            </button>
            <button type="button" class="rm-tab-btn" data-tab="tab-delivery" style="padding: 10px 20px; font-size: 0.95rem; font-weight: 600; color: #64748b; background: none;">
                🚚 Delivery &amp; Returns
            </button>
            <button type="button" class="rm-tab-btn" data-tab="tab-reviews" style="padding: 10px 20px; font-size: 0.95rem; font-weight: 600; color: #64748b; background: none;">
                ⭐ Verified Reviews ({{ $product['reviews_count'] }})
            </button>
        </div>

        <!-- Tab 1: Benefits -->
        <div class="rm-tab-content" id="tab-benefits" style="display: block;">
            <h3 style="font-family: var(--rm-font-display); font-size: 1.4rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 20px;">
                Proven Botanical Benefits for Your Hair
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
                @foreach($product['benefits'] as $benefit)
                    <div style="display: flex; align-items: flex-start; gap: 12px; background: #faf8f5; padding: 16px; border-radius: 12px; border: 1px solid var(--rm-border);">
                        <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 1.1rem; margin-top: 3px;"></i>
                        <span style="font-size: 0.9375rem; color: #334155; font-weight: 500;">{{ $benefit }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tab 2: Ingredients -->
        <div class="rm-tab-content" id="tab-ingredients" style="display: none;">
            <h3 style="font-family: var(--rm-font-display); font-size: 1.4rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 16px;">
                100% Pure Ayurvedic Herbal Ingredients
            </h3>
            <p style="color: #4b5563; font-size: 0.95rem; line-height: 1.8; margin-bottom: 20px;">
                {{ $product['ingredients'] }}
            </p>
            <div style="background: #faf8f5; border: 1px solid var(--rm-gold-border); border-radius: 12px; padding: 20px;">
                <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--rm-gold-dark); margin-bottom: 8px;">Our Purity Promise</h4>
                <p style="font-size: 0.875rem; color: #64748b; line-height: 1.6;">
                    No Artificial Fragrances &bull; No Mineral Oil &bull; Zero Silicones &bull; Cruelty-Free &bull; Tested on all hair types including oily, dry, chemical-treated, and colored hair.
                </p>
            </div>
        </div>

        <!-- Tab 3: Usage -->
        <div class="rm-tab-content" id="tab-usage" style="display: none;">
            <h3 style="font-family: var(--rm-font-display); font-size: 1.4rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 16px;">
                Recommended Application Routine (Istemal Ka Tareeqa)
            </h3>
            <div style="background: #faf8f5; border: 1px solid var(--rm-border); border-radius: 14px; padding: 24px; font-size: 0.95rem; color: #334155; line-height: 1.8; margin-bottom: 20px;">
                {{ $product['how_to_use'] }}
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                <div style="background: #ffffff; border: 1px solid var(--rm-border); border-radius: 10px; padding: 14px; text-align: center;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--rm-dark); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">1</div>
                    <strong style="font-size: 0.85rem; color: var(--rm-dark); display: block;">Warm in Palms</strong>
                    <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0;">5-10 ml oil warm karein</p>
                </div>
                <div style="background: #ffffff; border: 1px solid var(--rm-border); border-radius: 10px; padding: 14px; text-align: center;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--rm-dark); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">2</div>
                    <strong style="font-size: 0.85rem; color: var(--rm-dark); display: block;">Scalp Massage</strong>
                    <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0;">5-10 mins halka massage</p>
                </div>
                <div style="background: #ffffff; border: 1px solid var(--rm-border); border-radius: 10px; padding: 14px; text-align: center;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--rm-dark); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">3</div>
                    <strong style="font-size: 0.85rem; color: var(--rm-dark); display: block;">Leave In</strong>
                    <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0;">2-3 ghantay ya overnight</p>
                </div>
                <div style="background: #ffffff; border: 1px solid var(--rm-border); border-radius: 10px; padding: 14px; text-align: center;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--rm-dark); color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">4</div>
                    <strong style="font-size: 0.85rem; color: var(--rm-dark); display: block;">Wash Off</strong>
                    <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0;">3 dafa haftay mein lagayein</p>
                </div>
            </div>
        </div>

        <!-- Tab 4: Delivery & Returns -->
        <div class="rm-tab-content" id="tab-delivery" style="display: none;">
            <h3 style="font-family: var(--rm-font-display); font-size: 1.4rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 16px;">
                Doorstep Delivery &amp; Return Guarantee
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 24px;">
                <div style="background: #faf8f5; border: 1px solid var(--rm-border); border-radius: 12px; padding: 18px;">
                    <i class="fa-solid fa-truck-fast" style="color: var(--rm-gold-dark); font-size: 1.35rem; margin-bottom: 10px;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 4px;">100% Free Shipping</h4>
                    <p style="font-size: 0.8125rem; color: #64748b; margin: 0; line-height: 1.45;">Poore Pakistan mein 2-4 business days ke andar baghair kisi shipping fee ke delivery.</p>
                </div>
                <div style="background: #faf8f5; border: 1px solid var(--rm-border); border-radius: 12px; padding: 18px;">
                    <i class="fa-solid fa-money-bill-wave" style="color: #16a34a; font-size: 1.35rem; margin-bottom: 10px;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 4px;">Cash on Delivery</h4>
                    <p style="font-size: 0.8125rem; color: #64748b; margin: 0; line-height: 1.45;">Advance payment ki zaroorat nahi. Parcel ghar pohnchne par rider ko cash dein.</p>
                </div>
                <div style="background: #faf8f5; border: 1px solid var(--rm-border); border-radius: 12px; padding: 18px;">
                    <i class="fa-solid fa-box-open" style="color: #0284c7; font-size: 1.35rem; margin-bottom: 10px;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 4px;">Open Parcel Allowed</h4>
                    <p style="font-size: 0.8125rem; color: #64748b; margin: 0; line-height: 1.45;">Courier rider ke samnay parcel open karke bottle aur packing check kar sakte hain.</p>
                </div>
                <div style="background: #faf8f5; border: 1px solid var(--rm-border); border-radius: 12px; padding: 18px;">
                    <i class="fa-solid fa-shield-heart" style="color: #d97706; font-size: 1.35rem; margin-bottom: 10px;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 4px;">7-Day Return Guarantee</h4>
                    <p style="font-size: 0.8125rem; color: #64748b; margin: 0; line-height: 1.45;">Agar aap result se mutma'in na hon to 7 din ke andar asaan return &amp; refund.</p>
                </div>
            </div>
            <div style="background: #faf8f5; border: 1.5px solid var(--rm-gold-border); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <div>
                    <strong style="color: var(--rm-dark); font-size: 0.92rem;">Need Help or Tracking Update?</strong>
                    <div style="font-size: 0.8rem; color: #64748b;">WhatsApp Helpline: {{ $storePhone ?? '+92 327 2222180' }} (9:00 AM - 9:00 PM)</div>
                </div>
                <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello Amber\'s Roots! I would like to inquire about my delivery or product.') }}" 
                   target="_blank" 
                   class="rm-btn-secondary" 
                   style="padding: 8px 18px; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i> Chat on WhatsApp
                </a>
            </div>
        </div>

        <!-- Tab 4: Reviews -->
        <div class="rm-tab-content" id="tab-reviews" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h3 style="font-family: var(--rm-font-display); font-size: 1.4rem; font-weight: 700; color: var(--rm-dark);">
                        Customer Experiences ({{ $product['reviews_count'] }})
                    </h3>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px; color: #eab308;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span style="color: #0f172a; font-weight: 700; font-size: 0.95rem;">{{ $product['rating'] }} out of 5 stars</span>
                    </div>
                </div>
                <button type="button" class="rm-btn-secondary" onclick="showToast('Review submission modal opened!');">
                    Write a Review
                </button>
            </div>

            <!-- Dynamic Customer Reviews -->
            @if(isset($approvedReviews) && count($approvedReviews) > 0)
                @foreach($approvedReviews as $rev)
                    <div style="padding: 20px; border-radius: 12px; background: #faf8f5; border: 1px solid var(--rm-border); margin-bottom: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <div>
                                <strong>{{ $rev->customer_name }}</strong>
                                <span style="background: #dcfce7; color: #15803d; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 9999px; margin-left: 6px;">Verified Buyer</span>
                            </div>
                            <span style="font-size: 0.75rem; color: #94a3b8;">{{ $rev->created_at->format('d M Y') }}</span>
                        </div>
                        <div style="color: #eab308; font-size: 0.8rem; margin-bottom: 8px;">
                            @for($s = 1; $s <= 5; $s++)
                                @if($s <= $rev->rating)
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star" style="color: #cbd5e1;"></i>
                                @endif
                            @endfor
                        </div>
                        <p style="font-size: 0.875rem; color: #475569; line-height: 1.6;">
                            "{{ $rev->review_text }}"
                        </p>
                    </div>
                @endforeach
            @else
                <div style="padding: 24px; text-align: center; color: #64748b; background: #faf8f5; border-radius: 12px;">
                    No reviews yet. Share your experience with us!
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Products Showcase -->
<section style="padding: 70px 24px; max-width: 1320px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
        <span style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--rm-gold-dark); letter-spacing: 0.12em;">Pair with other essentials</span>
        <h2 style="font-family: var(--rm-font-display); font-size: 2rem; font-weight: 700; color: var(--rm-dark); margin-top: 6px;">
            Frequently Bought Together
        </h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
        @foreach(array_slice($relatedProducts, 0, 3) as $related)
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid var(--rm-border); padding: 20px; box-shadow: var(--rm-shadow-sm); display: flex; flex-direction: column; justify-content: space-between;">
                <a href="{{ url('/product/' . $related['slug']) }}" style="display: block; text-decoration: none;">
                    <div style="height: 180px; display: flex; align-items: center; justify-content: center; background: #faf5ec; border-radius: 12px; margin-bottom: 16px; color: #c5a059; font-size: 3.5rem;">
                        <i class="fa-solid {{ $related['icon'] }}"></i>
                    </div>
                    <h4 style="font-size: 1rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 6px;">
                        {{ $related['title'] }}
                    </h4>
                    <div style="font-size: 1.15rem; font-weight: 800; color: var(--rm-gold-dark); margin-bottom: 12px;">
                        Rs. {{ number_format($related['price']) }}
                    </div>
                </a>
                <a href="{{ url('/product/' . $related['slug']) }}" class="rm-btn-secondary" style="width: 100%; justify-content: center; padding: 10px; font-size: 0.875rem;">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</section>

@push('scripts')
<script>
    // Tab switching logic
    document.querySelectorAll('.rm-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.rm-tab-btn').forEach(b => {
                b.style.color = '#64748b';
                b.style.borderBottom = 'none';
            });
            document.querySelectorAll('.rm-tab-content').forEach(c => c.style.display = 'none');

            btn.style.color = 'var(--rm-gold-dark)';
            btn.style.borderBottom = '3px solid var(--rm-gold-primary)';
            const target = btn.getAttribute('data-tab');
            const targetEl = document.getElementById(target);
            if (targetEl) targetEl.style.display = 'block';
        });
    });

    // Quantity selector logic on Detail Page
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    const qtyVal = document.getElementById('qtyValue');
    const addBtn = document.getElementById('addToCartDetailBtn');
    const basePrice = {{ $product['price'] }};
    const displayPrice = document.getElementById('displayProductPrice');

    if (qtyMinus && qtyPlus && qtyVal) {
        qtyMinus.addEventListener('click', () => {
            let val = parseInt(qtyVal.textContent) || 1;
            if (val > 1) {
                val--;
                qtyVal.textContent = val;
                updateButtonPrice(val);
            }
        });

        qtyPlus.addEventListener('click', () => {
            let val = parseInt(qtyVal.textContent) || 1;
            val++;
            qtyVal.textContent = val;
            updateButtonPrice(val);
        });
    }

    function updateButtonPrice(qty) {
        if (addBtn) {
            addBtn.innerHTML = `<i class="fa-solid fa-cart-plus"></i> <span>Add to Cart</span>`;
        }
    }

    function triggerCodDirectCheckout(title, price, slug, icon, image) {
        // Add to cart with current quantity and redirect to /cart page!
        const qty = parseInt(qtyVal.textContent) || 1;
        if (window.RivaajCart) {
            window.RivaajCart.addItem({
                title: title,
                price: price,
                slug: slug,
                icon: icon,
                image: image || '/assets/product/1000082361.jpg',
                quantity: qty
            });
        }
        showToast('Direct order initiated! Redirecting to checkout...');
        setTimeout(() => {
            window.location.href = "{{ url('/checkout') }}";
        }, 500);
    }

    // Product Gallery 4-Image Switcher & Carousel
    const galleryItems = @json($galleryList);
    let currentGalleryIdx = 0;

    function selectProductGalleryImage(index) {
        if (!galleryItems || !galleryItems[index]) return;
        currentGalleryIdx = index;

        const mainImg = document.getElementById('detailActiveImg');
        const counter = document.getElementById('detailGalleryCounter');
        const thumbs = document.querySelectorAll('.rm-gallery-thumb-item');

        if (mainImg) {
            mainImg.style.opacity = '0.35';
            setTimeout(() => {
                mainImg.src = galleryItems[index];
                mainImg.style.opacity = '1';
            }, 100);
        }

        if (counter) {
            counter.textContent = `${index + 1} / ${galleryItems.length}`;
        }

        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle('is-active', i === index);
        });
    }

    function cycleProductGallery(delta) {
        if (!galleryItems || galleryItems.length === 0) return;
        let nextIdx = (currentGalleryIdx + delta) % galleryItems.length;
        if (nextIdx < 0) nextIdx = galleryItems.length - 1;
        selectProductGalleryImage(nextIdx);
    }
</script>
@endpush

@push('styles')
<style>
/* Product Detail 4-Image Gallery */
.rm-gallery-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid var(--rm-gold-border);
    padding: 24px 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    position: relative;
    text-align: center;
}

.rm-gallery-badge-featured {
    position: absolute;
    top: 18px;
    left: 18px;
    background: var(--rm-gold-gradient);
    color: #121316;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 9999px;
    letter-spacing: 0.05em;
    z-index: 5;
    box-shadow: 0 4px 12px rgba(201, 147, 27, 0.25);
}

.rm-gallery-badge-discount {
    position: absolute;
    top: 18px;
    right: 18px;
    background: #dc2626;
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 9999px;
    z-index: 5;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
}

.rm-detail-stage {
    position: relative;
    width: 100%;
    height: 430px;
    border-radius: 16px;
    background: radial-gradient(circle, #fcfbf8 0%, #f4eee2 100%);
    border: 1.5px solid var(--rm-gold-border);
    margin: 14px auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.02);
}

.rm-detail-active-img {
    max-width: 92%;
    max-height: 92%;
    object-fit: contain;
    transition: opacity 0.22s ease, transform 0.3s ease;
    filter: drop-shadow(0 12px 28px rgba(0, 0, 0, 0.14));
}

.rm-detail-active-img:hover {
    transform: scale(1.04);
}

.rm-stage-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid var(--rm-gold-border);
    color: var(--rm-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    z-index: 4;
}

.rm-stage-arrow:hover {
    background: var(--rm-gold-dark);
    color: #ffffff;
    border-color: var(--rm-gold-dark);
    transform: translateY(-50%) scale(1.08);
}

.rm-stage-arrow-prev {
    left: 12px;
}

.rm-stage-arrow-next {
    right: 12px;
}

.rm-stage-counter {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(10, 30, 18, 0.75);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 9999px;
    backdrop-filter: blur(4px);
    letter-spacing: 0.05em;
    z-index: 4;
}

/* 4 Thumbnails Grid */
.rm-gallery-thumbs-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin: 16px 0 14px;
}

.rm-gallery-thumb-item {
    position: relative;
    height: 86px;
    border-radius: 12px;
    border: 2px solid var(--rm-border);
    background: #ffffff;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
}

.rm-gallery-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.25s ease;
}

.rm-gallery-thumb-item:hover {
    border-color: var(--rm-gold-primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
}

.rm-gallery-thumb-item.is-active {
    border-color: var(--rm-gold-dark);
    box-shadow: 0 0 0 1px var(--rm-gold-dark), 0 6px 16px rgba(184, 134, 11, 0.25);
    transform: translateY(-2px);
}

.rm-thumb-dot-badge {
    position: absolute;
    bottom: 4px;
    right: 4px;
    background: rgba(10, 30, 18, 0.7);
    color: #fff;
    font-size: 0.62rem;
    font-weight: 700;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rm-gallery-thumb-item.is-active .rm-thumb-dot-badge {
    background: var(--rm-gold-dark);
    color: #fff;
}

.rm-organic-cert-pill {
    display: inline-block;
    background: #faf8f5;
    border: 1px solid var(--rm-border);
    padding: 8px 18px;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #4b5563;
    margin-top: 6px;
}

@media (max-width: 600px) {
    .rm-detail-stage {
        height: 320px;
    }
    .rm-gallery-thumb-item {
        height: 68px;
    }
}
/* Product Detail Responsive Enhancements (220px - 3000px) */
.rm-detail-main-img-wrap {
    width: min(220px, 55vw) !important;
    height: min(220px, 55vw) !important;
}

@media (max-width: 900px) {
    .rm-product-detail-layout {
        grid-template-columns: 1fr !important;
        gap: 28px !important;
    }
}

@media (max-width: 600px) {
    .rm-detail-section {
        padding: 24px 12px !important;
    }
    .rm-detail-h1 {
        font-size: 1.65rem !important;
    }
    .rm-trust-grid {
        grid-template-columns: 1fr !important;
        gap: 10px !important;
    }
}

@media (max-width: 380px) {
    .rm-detail-section {
        padding: 16px 6px !important;
    }
    .rm-detail-h1 {
        font-size: 1.35rem !important;
    }
    .rm-detail-price-box {
        padding: 12px 10px !important;
    }
    .rm-detail-price-val {
        font-size: 1.45rem !important;
    }
    .rm-detail-controls-row {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 10px !important;
    }
    .rm-detail-qty-picker {
        width: 100% !important;
        justify-content: center !important;
    }
}

@media (max-width: 280px) {
    .rm-detail-section {
        padding: 12px 4px !important;
    }
    .rm-detail-stage {
        height: 220px !important;
    }
    .rm-gallery-thumb-item {
        height: 50px !important;
        width: 50px !important;
    }
    .rm-detail-h1 {
        font-size: 1.15rem !important;
    }
    .rm-detail-price-val {
        font-size: 1.25rem !important;
    }
    .rm-tab-btn {
        font-size: 0.78rem !important;
        padding: 8px 4px !important;
    }
    .rm-detail-cta-btn {
        padding: 10px 8px !important;
        font-size: 0.8rem !important;
    }
}

@media (min-width: 1920px) {
    .rm-detail-section {
        max-width: 1680px !important;
        padding: 70px 32px !important;
    }
    .rm-detail-h1 {
        font-size: 3rem !important;
    }
    .rm-detail-main-img-wrap {
        width: 280px !important;
        height: 280px !important;
        font-size: 7.5rem !important;
    }
}

@media (min-width: 2561px) {
    .rm-detail-section {
        max-width: 2100px !important;
        padding: 90px 44px !important;
    }
    .rm-detail-h1 {
        font-size: 3.6rem !important;
    }
    .rm-detail-main-img-wrap {
        width: 340px !important;
        height: 340px !important;
        font-size: 9rem !important;
    }
}
</style>
@endpush
@endsection
