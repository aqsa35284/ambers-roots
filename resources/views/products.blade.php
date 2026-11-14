@extends('layouts.app')

@section('title', "All Herbal Formulations – Amber's Roots | Pure Herbs, Pure Results")

@section('content')
<!-- Luxury Catalog Hero Banner -->
<section class="rm-catalog-hero">
    <div class="rm-catalog-hero-inner">
        <!-- Breadcrumb -->
        <nav class="rm-catalog-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
            <span class="rm-breadcrumb-sep">/</span>
            <span class="rm-breadcrumb-active">All Formulations</span>
        </nav>

        <!-- Royal Badge -->
        <div class="rm-catalog-badge">
            <i class="fa-solid fa-crown"></i>
            <span>100% Pure Organic Ayurvedic Formulations</span>
        </div>

        <!-- Main Headline -->
        <h1 class="rm-catalog-title">
            The Royal Botanical Collection
        </h1>

        <p class="rm-catalog-subtitle">
            Mazboot, chamakdaar aur sehatmand baal – handcrafted with 21 rare wild-harvested Eastern herbs and cold-pressed botanical oils. 
            Clinically formulated to stop hair fall, eliminate dandruff, and stimulate thick new hair growth.
        </p>

        <!-- Key Trust Pillars Ribbon -->
        <div class="rm-catalog-pillars">
            <div class="rm-pillar-item">
                <i class="fa-solid fa-leaf"></i>
                <span>100% Herbal & Sulfate-Free</span>
            </div>
            <div class="rm-pillar-item">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Free Express Shipping (Rs. 3,000+)</span>
            </div>
            <div class="rm-pillar-item">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Cash on Delivery Anywhere in Pakistan</span>
            </div>
            <div class="rm-pillar-item">
                <i class="fa-solid fa-shield-halved"></i>
                <span>100% Moneyback Promise</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Section -->
<section class="rm-catalog-main">
    <div class="rm-catalog-container">
        
        <!-- Interactive Controls Bar: Filter Pills + Search + Sort -->
        <div class="rm-catalog-toolbar">
            <!-- Category Filter Pills -->
            <div class="rm-filter-pills" id="categoryFilterPills" role="tablist">
                @php
                    $prodCollection = collect($products ?? []);
                    $oilCount = $prodCollection->where('category', 'hair-oil')->count();
                    $shampooCount = $prodCollection->where('category', 'shampoo')->count();
                    $serumCount = $prodCollection->where('category', 'serum')->count();
                    $skincareCount = $prodCollection->where('category', 'skincare')->count();
                    $bundleCount = $prodCollection->where('category', 'bundle')->count();
                @endphp
                <button type="button" class="rm-filter-pill is-active" data-cat="all">
                    <span>All Formulations</span>
                    <span class="rm-pill-count">{{ $prodCollection->count() }}</span>
                </button>
                @if($oilCount > 0)
                <button type="button" class="rm-filter-pill" data-cat="hair-oil">
                    <i class="fa-solid fa-bottle-droplet"></i>
                    <span>Hair Oils</span>
                    <span class="rm-pill-count">{{ $oilCount }}</span>
                </button>
                @endif
                @if($shampooCount > 0)
                <button type="button" class="rm-filter-pill" data-cat="shampoo">
                    <i class="fa-solid fa-pump-soap"></i>
                    <span>Shampoos</span>
                    <span class="rm-pill-count">{{ $shampooCount }}</span>
                </button>
                @endif
                @if($serumCount > 0)
                <button type="button" class="rm-filter-pill" data-cat="serum">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Scalp Serums</span>
                    <span class="rm-pill-count">{{ $serumCount }}</span>
                </button>
                @endif
                @if($skincareCount > 0)
                <button type="button" class="rm-filter-pill" data-cat="skincare">
                    <i class="fa-solid fa-spa"></i>
                    <span>Skincare</span>
                    <span class="rm-pill-count">{{ $skincareCount }}</span>
                </button>
                @endif
                @if($bundleCount > 0)
                <button type="button" class="rm-filter-pill" data-cat="bundle">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Value Bundles</span>
                    <span class="rm-pill-count">{{ $bundleCount }}</span>
                </button>
                @endif
            </div>

            <!-- Search & Sort Row -->
            <div class="rm-toolbar-actions">
                <!-- Search Box -->
                <div class="rm-search-box">
                    <i class="fa-solid fa-magnifying-glass rm-search-icon"></i>
                    <input type="text" id="catalogSearchInput" placeholder="Search by name, ingredient, benefit..." aria-label="Search formulations">
                    <button type="button" id="catalogSearchClear" class="rm-search-clear" title="Clear search" style="display: none;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Sort Dropdown -->
                <div class="rm-sort-box">
                    <label for="catalogSortSelect"><i class="fa-solid fa-arrow-down-short-wide"></i> Sort:</label>
                    <select id="catalogSortSelect" aria-label="Sort products">
                        <option value="featured">Featured & Best Selling</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                        <option value="savings">Biggest Discount</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Catalog Status Bar -->
        <div class="rm-catalog-status">
            <span id="catalogResultsCount">Showing <strong>{{ count($products ?? []) }} Formulations</strong></span>
            <span class="rm-status-tip"><i class="fa-solid fa-circle-info"></i> Click any product image or title to read full Ayurvedic ingredients & application instructions</span>
        </div>

        <!-- Products 3-Column Luxury Grid -->
        <div class="rm-catalog-grid" id="catalogGrid">
            @foreach($products ?? [] as $prod)
                <div class="rm-catalog-card" 
                     data-category="{{ $prod['category'] ?? 'all' }}"
                     data-price="{{ $prod['price'] ?? 0 }}"
                     data-original-price="{{ $prod['original_price'] ?? 0 }}"
                     data-rating="{{ $prod['rating'] ?? 5 }}"
                     data-savings="{{ ($prod['original_price'] ?? 0) - ($prod['price'] ?? 0) }}"
                     data-title="{{ strtolower($prod['title'] ?? '') }}"
                     data-desc="{{ strtolower($prod['short_desc'] ?? '') }}"
                     data-ingredients="{{ strtolower($prod['ingredients'] ?? '') }}">
                    
                    <!-- Top Image Stage (Clickable to /product/{slug}) -->
                    <a href="{{ url('/product/' . $prod['slug']) }}" class="rm-card-stage" aria-label="View {{ $prod['title'] }} details">
                        <!-- Discount Badge -->
                        <span class="rm-stage-badge-discount">
                            {{ $prod['discount'] }}
                        </span>

                        <!-- Status Badge (e.g. BEST SELLER) -->
                        @if(isset($prod['badge']))
                            <span class="rm-stage-badge-status">
                                <i class="fa-solid fa-crown" style="font-size: 0.65rem;"></i> {{ $prod['badge'] }}
                            </span>
                        @endif

                        <!-- Luxury Icon / Image Display -->
                        <div class="rm-stage-icon-wrap">
                            <div class="rm-stage-icon-halo"></div>
                            @if(!empty($prod['image']))
                                <img src="{{ str_starts_with($prod['image'], 'http') ? $prod['image'] : asset($prod['image']) }}" alt="{{ $prod['title'] }}" style="width: 100%; height: 100%; object-fit: contain; z-index: 2; position: relative;">
                            @else
                                <i class="fa-solid {{ $prod['icon'] ?? 'fa-bottle-droplet' }} rm-stage-icon"></i>
                            @endif
                        </div>

                        <!-- Volume Pill -->
                        <div class="rm-stage-volume-pill">
                            <i class="fa-solid fa-flask"></i>
                            <span>{{ $prod['volume'] }}</span>
                        </div>

                        <!-- Click Overlay Hint -->
                        <div class="rm-stage-hover-hint">
                            <span><i class="fa-solid fa-arrow-up-right-from-square"></i> Full Details</span>
                        </div>
                    </a>

                    <!-- Card Body Content -->
                    <div class="rm-card-body">
                        <!-- Meta: Category & Rating -->
                        <div class="rm-card-meta">
                            <span class="rm-card-cat-label">{{ $prod['category_name'] ?? 'Herbal Formula' }}</span>
                            <div class="rm-card-stars-wrap">
                                <div class="rm-card-stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <span class="rm-card-score">{{ number_format($prod['rating'], 1) }}</span>
                                <span class="rm-card-reviews">({{ number_format($prod['reviews_count']) }})</span>
                            </div>
                        </div>

                        <!-- Product Title (Clickable) -->
                        <h3 class="rm-card-title">
                            <a href="{{ url('/product/' . $prod['slug']) }}">{{ $prod['title'] }}</a>
                        </h3>

                        <!-- Short Description -->
                        <p class="rm-card-desc">
                            {{ $prod['short_desc'] }}
                        </p>

                        <!-- Key Botanical Herbs Mini Strip -->
                        @php
                            $herbList = array_slice(array_map('trim', explode(',', $prod['ingredients'] ?? '')), 0, 3);
                        @endphp
                        @if(!empty($herbList))
                            <div class="rm-card-herbs-strip">
                                <i class="fa-solid fa-seedling"></i>
                                <span>{{ implode(' • ', $herbList) }}</span>
                            </div>
                        @endif

                        <!-- Price & Savings Row -->
                        <div class="rm-card-price-row">
                            <div class="rm-price-group">
                                <span class="rm-current-price">Rs. {{ number_format($prod['price']) }}</span>
                                <span class="rm-original-price">Rs. {{ number_format($prod['original_price']) }}</span>
                            </div>
                            <span class="rm-savings-pill">
                                Save Rs. {{ number_format($prod['original_price'] - $prod['price']) }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="rm-card-actions">
                            <a href="{{ url('/product/' . $prod['slug']) }}" class="rm-card-btn-view" title="View formulation, usage and reviews">
                                <i class="fa-solid fa-eye"></i>
                                <span>View Details</span>
                            </a>
                            <button type="button" class="rm-card-btn-add" 
                                    data-add-to-cart 
                                    data-product-title="{{ $prod['title'] }}" 
                                    data-product-price="Rs. {{ number_format($prod['price']) }}"
                                    data-product-slug="{{ $prod['slug'] }}"
                                    data-product-icon="{{ $prod['icon'] }}"
                                    data-product-image="{{ asset($prod['image'] ?? 'assets/product/1000082361.jpg') }}">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State (Shown if search/filter matches 0) -->
        <div class="rm-catalog-empty" id="catalogEmptyState" style="display: none;">
            <div class="rm-empty-icon">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <h3 class="rm-empty-title">No Matching Formulations Found</h3>
            <p class="rm-empty-desc">We couldn't find any products matching your current search or category filter. Try using different keywords or reset filters.</p>
            <button type="button" class="rm-btn-primary" id="catalogResetBtn">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset All Filters</span>
            </button>
        </div>

        <!-- WhatsApp Consultation Strip -->
        <div class="rm-catalog-consultation">
            <div class="rm-consultation-left">
                <div class="rm-consultation-icon">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="rm-consultation-title">Need Personalized Hair Care Advice?</h3>
                    <p class="rm-consultation-desc">Talk directly with our Ayurvedic formulation specialist on WhatsApp for free guidance on hair thinning, dandruff, or damage.</p>
                </div>
            </div>
            <a href="https://wa.me/923272222180?text={{ urlencode("Hello Amber's Roots! I would like free consultation to choose the best hair care formulation for my hair.") }}" target="_blank" class="rm-consultation-btn">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Chat with Specialist</span>
            </a>
        </div>

    </div>
</section>

@push('styles')
<style>
/* ==========================================================================
   AMBER'S ROOTS - LUXURY PRODUCTS CATALOG STYLES
   ========================================================================== */

/* Catalog Hero Banner */
.rm-catalog-hero {
    position: relative;
    background: radial-gradient(circle at 50% 10%, rgba(197, 160, 89, 0.2) 0%, rgba(253, 251, 247, 1) 75%);
    padding: clamp(40px, 6vw, 75px) 24px clamp(35px, 5vw, 60px);
    border-bottom: 1px solid var(--rm-border);
    text-align: center;
    overflow: hidden;
}

.rm-catalog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 600px;
    height: 100%;
    background: radial-gradient(ellipse at top, rgba(223, 194, 133, 0.25) 0%, transparent 70%);
    pointer-events: none;
}

.rm-catalog-hero-inner {
    max-width: 980px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* Breadcrumb */
.rm-catalog-breadcrumb {
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
}

.rm-catalog-breadcrumb a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s ease;
}

.rm-catalog-breadcrumb a:hover {
    color: var(--rm-gold-dark);
}

.rm-breadcrumb-sep {
    color: #cbd5e1;
}

.rm-breadcrumb-active {
    color: var(--rm-gold-dark);
    font-weight: 700;
}

/* Royal Badge */
.rm-catalog-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid var(--rm-gold-border);
    padding: 6px 16px;
    border-radius: var(--rm-radius-full);
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--rm-gold-dark);
    margin-bottom: 18px;
    box-shadow: var(--rm-shadow-sm);
}

.rm-catalog-badge i {
    color: var(--rm-gold-dark);
}

/* Titles */
.rm-catalog-title {
    font-family: var(--rm-font-display);
    font-size: clamp(2rem, 4.5vw, 3.2rem);
    font-weight: 700;
    color: var(--rm-dark);
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 16px;
}

.rm-catalog-subtitle {
    color: #4b5563;
    font-size: clamp(0.92rem, 1.6vw, 1.05rem);
    line-height: 1.7;
    max-width: 760px;
    margin: 0 auto 28px;
}

/* Trust Pillars Ribbon */
.rm-catalog-pillars {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px clamp(12px, 2.5vw, 24px);
    flex-wrap: wrap;
    padding-top: 18px;
    border-top: 1px dashed rgba(197, 160, 89, 0.4);
}

.rm-pillar-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #1e293b;
    background: rgba(255, 255, 255, 0.85);
    padding: 6px 14px;
    border-radius: 9999px;
    border: 1px solid rgba(197, 160, 89, 0.3);
}

.rm-pillar-item i {
    color: var(--rm-gold-dark);
    font-size: 0.85rem;
}

/* Main Catalog Container */
.rm-catalog-main {
    padding: clamp(28px, 4vw, 56px) 20px clamp(48px, 6vw, 80px);
    background: #faf8f5;
    min-height: 60vh;
}

.rm-catalog-container {
    max-width: 1320px;
    margin: 0 auto;
}

/* Toolbar: Filters + Search + Sort */
.rm-catalog-toolbar {
    background: #ffffff;
    border: 1px solid var(--rm-border);
    border-radius: 20px;
    padding: 18px 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    margin-bottom: 28px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Category Filter Pills */
.rm-filter-pills {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    overflow-x: auto;
    padding-bottom: 2px;
}

.rm-filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    padding: 9px 18px;
    border-radius: 9999px;
    font-family: inherit;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    white-space: nowrap;
    user-select: none;
}

.rm-filter-pill:hover {
    background: #f1f5f9;
    color: var(--rm-dark);
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

.rm-filter-pill.is-active {
    background: var(--rm-dark) !important;
    color: #ffffff !important;
    border-color: var(--rm-gold-primary) !important;
    box-shadow: 0 4px 14px rgba(18, 19, 22, 0.25);
}

.rm-filter-pill.is-active i {
    color: var(--rm-gold-light) !important;
}

.rm-pill-count {
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 9999px;
}

.rm-filter-pill.is-active .rm-pill-count {
    background: var(--rm-gold-primary);
    color: #121316;
}

/* Toolbar Search & Sort Row */
.rm-toolbar-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
}

.rm-search-box {
    position: relative;
    flex: 1 1 300px;
    max-width: 460px;
}

.rm-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
}

.rm-search-box input {
    width: 100%;
    padding: 10px 38px 10px 38px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-family: inherit;
    font-size: 0.875rem;
    color: var(--rm-dark);
    transition: all 0.2s ease;
    outline: none;
}

.rm-search-box input:focus {
    background: #ffffff;
    border-color: var(--rm-gold-primary);
    box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.18);
}

.rm-search-clear {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 0.85rem;
    padding: 4px;
}

.rm-search-clear:hover {
    color: #dc2626;
}

.rm-sort-box {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
}

.rm-sort-box select {
    padding: 9px 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-family: inherit;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--rm-dark);
    cursor: pointer;
    outline: none;
    transition: border-color 0.2s ease;
}

.rm-sort-box select:focus {
    border-color: var(--rm-gold-primary);
}

/* Status Bar */
.rm-catalog-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    font-size: 0.875rem;
    color: #64748b;
    flex-wrap: wrap;
    gap: 10px;
}

.rm-status-tip {
    font-size: 0.8125rem;
    color: #78716c;
}

.rm-status-tip i {
    color: var(--rm-gold-dark);
}

/* ==========================================================================
   PRODUCT CARDS GRID (3 Columns Desktop, 2 Tablet, 1 Mobile)
   ========================================================================== */
.rm-catalog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

/* Luxury Card Item */
.rm-catalog-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #ebd9b8;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.rm-catalog-card:hover {
    transform: translateY(-8px);
    border-color: var(--rm-gold-primary);
    box-shadow: 0 20px 42px rgba(197, 160, 89, 0.22);
}

/* Card Top Stage */
.rm-card-stage {
    position: relative;
    height: 235px !important;
    min-height: 235px !important;
    max-height: 235px !important;
    width: 100% !important;
    flex: 0 0 235px !important;
    flex-shrink: 0 !important;
    background: radial-gradient(circle at center, #fbf7ef 0%, #eee1c8 100%);
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-decoration: none;
    color: inherit;
    overflow: hidden;
    border-bottom: 1px solid #f1e5cf;
}

/* Stage Discount Badge */
.rm-stage-badge-discount {
    position: absolute;
    top: 14px;
    left: 14px;
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 9999px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    z-index: 3;
}

/* Stage Status Badge */
.rm-stage-badge-status {
    position: absolute;
    top: 14px;
    right: 14px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid var(--rm-gold-border);
    color: var(--rm-gold-dark);
    font-size: 0.72rem;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 9999px;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    z-index: 3;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Icon Wrap & Halo */
.rm-stage-icon-wrap {
    position: relative;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid var(--rm-gold-primary);
    box-shadow: 0 10px 28px rgba(197, 160, 89, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.35s ease;
}

.rm-catalog-card:hover .rm-stage-icon-wrap {
    transform: scale(1.08) rotate(-3deg);
    box-shadow: 0 14px 36px rgba(197, 160, 89, 0.45);
}

.rm-stage-icon {
    font-size: 3.6rem !important;
    color: var(--rm-gold-dark);
    filter: drop-shadow(0 4px 8px rgba(197, 160, 89, 0.3));
}

/* Volume Pill */
.rm-stage-volume-pill {
    position: absolute;
    bottom: 12px;
    right: 14px;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(197, 160, 89, 0.3);
    color: #475569;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    backdrop-filter: blur(4px);
    z-index: 2;
}

.rm-stage-volume-pill i {
    color: var(--rm-gold-dark);
}

/* Hover Hint Overlay */
.rm-stage-hover-hint {
    position: absolute;
    inset: 0;
    background: rgba(18, 19, 22, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s ease;
    z-index: 2;
}

.rm-stage-hover-hint span {
    background: #ffffff;
    color: var(--rm-dark);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 9999px;
    border: 1px solid var(--rm-gold-primary);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    transform: translateY(8px);
    transition: transform 0.25s ease;
}

.rm-catalog-card:hover .rm-stage-hover-hint {
    opacity: 1;
}

.rm-catalog-card:hover .rm-stage-hover-hint span {
    transform: translateY(0);
}

/* Card Body */
.rm-card-body {
    padding: 22px 20px 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1 1 auto;
}

/* Meta: Category & Rating */
.rm-card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 0.78rem;
}

.rm-card-cat-label {
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: var(--rm-gold-dark);
}

.rm-card-stars-wrap {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.rm-card-stars {
    color: #eab308;
    font-size: 0.75rem;
    display: inline-flex;
    gap: 2px;
}

.rm-card-score {
    font-weight: 700;
    color: #1e293b;
    margin-left: 2px;
}

.rm-card-reviews {
    color: #94a3b8;
    font-size: 0.72rem;
}

/* Product Title */
.rm-card-title {
    font-family: var(--rm-font-display);
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.35;
    color: var(--rm-dark);
    margin-bottom: 8px;
    min-height: 2.7em;
}

.rm-card-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}

.rm-catalog-card:hover .rm-card-title a {
    color: var(--rm-gold-dark);
}

/* Short Description */
.rm-card-desc {
    font-size: 0.8125rem;
    color: #64748b;
    line-height: 1.55;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.5em;
}

/* Key Ingredients Strip */
.rm-card-herbs-strip {
    background: #f4f8f3;
    border: 1px solid #d1e7dd;
    color: #166534;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 8px;
    margin-bottom: 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.rm-card-herbs-strip i {
    color: #15803d;
    flex-shrink: 0;
}

/* Price & Savings Row */
.rm-card-price-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-top: 12px;
    border-top: 1px dashed #e2e8f0;
}

.rm-price-group {
    display: inline-flex;
    align-items: baseline;
    gap: 8px;
}

.rm-current-price {
    font-size: 1.38rem;
    font-weight: 800;
    color: var(--rm-dark);
    letter-spacing: -0.01em;
}

.rm-original-price {
    font-size: 0.88rem;
    color: #94a3b8;
    text-decoration: line-through;
    font-weight: 500;
}

.rm-savings-pill {
    background: #dcfce7;
    color: #15803d;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
}

/* Action Buttons */
.rm-card-actions {
    display: grid;
    grid-template-columns: 1fr 1.35fr;
    gap: 8px;
}

.rm-card-btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #ffffff;
    color: var(--rm-dark);
    border: 1.5px solid #cbd5e1;
    padding: 10px 12px;
    border-radius: 12px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.rm-card-btn-view:hover {
    border-color: var(--rm-gold-primary);
    color: var(--rm-gold-dark);
    background: #faf7f2;
}

.rm-card-btn-add {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: var(--rm-dark);
    color: #ffffff;
    border: 1.5px solid var(--rm-gold-primary);
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    white-space: nowrap;
}

.rm-card-btn-add:hover {
    background: var(--rm-gold-gradient);
    color: #121316;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: var(--rm-shadow-gold);
}

.rm-card-btn-add i {
    font-size: 0.85rem;
}

/* Empty State */
.rm-catalog-empty {
    text-align: center;
    padding: 60px 20px;
    background: #ffffff;
    border-radius: 20px;
    border: 1px dashed var(--rm-gold-border);
    max-width: 540px;
    margin: 20px auto 40px;
}

.rm-empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--rm-gold-subtle);
    color: var(--rm-gold-dark);
    font-size: 1.8rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.rm-empty-title {
    font-family: var(--rm-font-display);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--rm-dark);
    margin-bottom: 8px;
}

.rm-empty-desc {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 24px;
}

/* WhatsApp Consultation Banner */
.rm-catalog-consultation {
    margin-top: 50px;
    background: linear-gradient(135deg, #121316 0%, #1e2025 100%);
    border: 1.5px solid var(--rm-gold-primary);
    border-radius: 20px;
    padding: 30px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.25);
    flex-wrap: wrap;
}

.rm-consultation-left {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1 1 400px;
}

.rm-consultation-icon {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #25d366;
    color: #ffffff;
    font-size: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
}

.rm-consultation-title {
    font-family: var(--rm-font-display);
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 4px;
}

.rm-consultation-desc {
    color: #cbd5e1;
    font-size: 0.88rem;
    line-height: 1.5;
}

.rm-consultation-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #25d366;
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 14px 26px;
    border-radius: 9999px;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
    white-space: nowrap;
}

.rm-consultation-btn:hover {
    background: #20bd5a;
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(37, 211, 102, 0.45);
}

/* ==========================================================================
   RESPONSIVE BREAKPOINTS (220px to 3000px)
   ========================================================================== */
@media (max-width: 1024px) {
    .rm-catalog-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
    }
    .rm-consultation-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .rm-catalog-toolbar {
        padding: 14px 16px;
    }
    .rm-toolbar-actions {
        flex-direction: column;
        align-items: stretch;
    }
    .rm-search-box {
        max-width: 100%;
    }
    .rm-sort-box {
        width: 100%;
        justify-content: space-between;
    }
    .rm-sort-box select {
        flex: 1;
    }
}

@media (max-width: 640px) {
    .rm-catalog-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .rm-catalog-card {
        max-width: 440px;
        margin: 0 auto;
        width: 100%;
    }
    .rm-card-stage {
        height: 220px !important;
        min-height: 220px !important;
        max-height: 220px !important;
        flex: 0 0 220px !important;
    }
    .rm-card-actions {
        grid-template-columns: 1fr 1fr;
    }
    .rm-consultation-left {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 380px) {
    .rm-card-actions {
        grid-template-columns: 1fr;
    }
    .rm-filter-pill {
        padding: 7px 12px;
        font-size: 0.78rem;
    }
}

/* Micro screens (234px - 280px) */
@media (max-width: 280px) {
    .rm-catalog-hero {
        padding: 24px 6px 18px;
    }
    .rm-catalog-title {
        font-size: 1.35rem;
    }
    .rm-catalog-card {
        padding: 12px 8px;
    }
    .rm-filter-pill {
        padding: 5px 8px;
        font-size: 0.72rem;
    }
    .rm-card-stage {
        height: 180px !important;
        min-height: 180px !important;
        max-height: 180px !important;
        flex: 0 0 180px !important;
    }
    .rm-btn-order-direct {
        font-size: 0.78rem;
        padding: 10px 8px;
    }
}

/* Ultra-Wide 2K/4K Scaling */
@media (min-width: 1920px) {
    .rm-catalog-container {
        max-width: 1800px;
    }
    .rm-catalog-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }
    .rm-card-stage {
        height: 270px !important;
        min-height: 270px !important;
        max-height: 270px !important;
        flex: 0 0 270px !important;
    }
    .rm-stage-icon-wrap {
        width: 150px;
        height: 150px;
    }
    .rm-stage-icon {
        font-size: 4.2rem !important;
    }
}

@media (min-width: 2101px) {
    .rm-catalog-container {
        max-width: 2050px;
    }
    .rm-catalog-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 48px;
    }
    .rm-card-stage {
        height: 310px !important;
        min-height: 310px !important;
        max-height: 310px !important;
        flex: 0 0 310px !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterPills = document.querySelectorAll('.rm-filter-pill');
    const searchInput = document.getElementById('catalogSearchInput');
    const searchClear = document.getElementById('catalogSearchClear');
    const sortSelect = document.getElementById('catalogSortSelect');
    const cards = Array.from(document.querySelectorAll('.rm-catalog-card'));
    const grid = document.getElementById('catalogGrid');
    const emptyState = document.getElementById('catalogEmptyState');
    const countDisplay = document.getElementById('catalogResultsCount');
    const resetBtn = document.getElementById('catalogResetBtn');

    let currentCategory = 'all';
    let currentQuery = '';
    let currentSort = 'featured';

    function applyFiltersAndSort() {
        let visibleCount = 0;

        // 1. Filter
        cards.forEach(card => {
            const cat = card.getAttribute('data-category');
            const title = card.getAttribute('data-title') || '';
            const desc = card.getAttribute('data-desc') || '';
            const herbs = card.getAttribute('data-ingredients') || '';

            const matchesCategory = (currentCategory === 'all' || cat === currentCategory);
            const matchesQuery = !currentQuery || 
                title.includes(currentQuery) || 
                desc.includes(currentQuery) || 
                herbs.includes(currentQuery);

            if (matchesCategory && matchesQuery) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // 2. Sort visible cards in DOM
        const visibleCards = cards.filter(c => c.style.display !== 'none');
        visibleCards.sort((a, b) => {
            const priceA = parseFloat(a.getAttribute('data-price')) || 0;
            const priceB = parseFloat(b.getAttribute('data-price')) || 0;
            const ratingA = parseFloat(a.getAttribute('data-rating')) || 0;
            const ratingB = parseFloat(b.getAttribute('data-rating')) || 0;
            const savingsA = parseFloat(a.getAttribute('data-savings')) || 0;
            const savingsB = parseFloat(b.getAttribute('data-savings')) || 0;

            if (currentSort === 'price-asc') return priceA - priceB;
            if (currentSort === 'price-desc') return priceB - priceA;
            if (currentSort === 'rating') return ratingB - ratingA;
            if (currentSort === 'savings') return savingsB - savingsA;
            return 0; // Default featured order
        });

        visibleCards.forEach(card => grid.appendChild(card));

        // 3. Update count & empty state
        if (visibleCount === 0) {
            grid.style.display = 'none';
            emptyState.style.display = 'block';
            countDisplay.innerHTML = 'Showing <strong>0 Formulations</strong>';
        } else {
            grid.style.display = 'grid';
            emptyState.style.display = 'none';
            countDisplay.innerHTML = `Showing <strong>${visibleCount} of ${cards.length} Formulations</strong>`;
        }
    }

    // Category click handler
    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => p.classList.remove('is-active'));
            this.classList.add('is-active');
            currentCategory = this.getAttribute('data-cat') || 'all';
            applyFiltersAndSort();
        });
    });

    // Search input handler
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentQuery = this.value.trim().toLowerCase();
            if (searchClear) {
                searchClear.style.display = currentQuery ? 'block' : 'none';
            }
            applyFiltersAndSort();
        });
    }

    // Search clear button
    if (searchClear) {
        searchClear.addEventListener('click', function () {
            searchInput.value = '';
            currentQuery = '';
            this.style.display = 'none';
            applyFiltersAndSort();
            searchInput.focus();
        });
    }

    // Sort select handler
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            currentSort = this.value;
            applyFiltersAndSort();
        });
    }

    // Reset button handler
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            currentCategory = 'all';
            currentQuery = '';
            currentSort = 'featured';
            if (searchInput) searchInput.value = '';
            if (searchClear) searchClear.style.display = 'none';
            if (sortSelect) sortSelect.value = 'featured';
            filterPills.forEach(p => {
                p.classList.toggle('is-active', p.getAttribute('data-cat') === 'all');
            });
            applyFiltersAndSort();
        });
    }
});
</script>
@endpush
@endsection
