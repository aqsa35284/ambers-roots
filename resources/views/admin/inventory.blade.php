@extends('layouts.dashboard')

@section('title', 'Product Catalog & Inventory')
@section('header_title', 'Product Catalog & Inventory Management')
@section('header_subtitle', 'Add, edit, manage pricing, discounts, stock, and toggle store visibility')

@section('content')

<!-- Inventory Summary Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 1.3rem;">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Total Products</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">{{ $products->count() }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; font-size: 1.3rem;">
            <i class="fa-solid fa-eye"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Active Live (ON)</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #34d399; font-family: 'Cinzel', serif;">{{ $activeCount }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(148, 163, 184, 0.15); border: 1px solid rgba(148, 163, 184, 0.3); display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 1.3rem;">
            <i class="fa-solid fa-eye-slash"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Inactive (OFF)</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #94a3b8; font-family: 'Cinzel', serif;">{{ $inactiveCount }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); display: flex; align-items: center; justify-content: center; color: #f87171; font-size: 1.3rem;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Low Stock Alert</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: {{ $lowStockCount > 0 ? '#f87171' : '#34d399' }}; font-family: 'Cinzel', serif;">
                {{ $lowStockCount }}
            </div>
        </div>
    </div>
</div>

<!-- Products Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div>
            <div class="panel-title">
                <i class="fa-solid fa-box-open"></i> Product Catalog & Storefront Visibility
            </div>
            <div style="font-size: 0.8rem; color: var(--db-text-muted); margin-top: 4px;">
                Products marked <strong>Active (ON)</strong> are live on the website. Inactive products are hidden.
            </div>
        </div>
        <button type="button" class="btn-db btn-db-gold" onclick="openAddProductModal()">
            <i class="fa-solid fa-plus"></i> Add New Product
        </button>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Product & Formulation</th>
                    <th>Category</th>
                    <th>Selling Price</th>
                    <th>Discount / Sale</th>
                    <th>Stock Level</th>
                    <th>Store Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                    <tr>
                        <td>
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--db-gold); background: rgba(223, 194, 133, 0.1); padding: 4px 10px; border-radius: 4px; border: 1px solid rgba(223, 194, 133, 0.2);">
                                #{{ $prod->display_order }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 44px; height: 44px; border-radius: 8px; background: #faf5ee; border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                                    @if($prod->image)
                                        <img src="{{ $prod->image_url }}" alt="{{ $prod->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <i class="fa-solid {{ $prod->icon ?? 'fa-bottle-droplet' }}" style="color: var(--db-gold); font-size: 1.2rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 0.95rem;">
                                        {{ $prod->title }}
                                        @if($prod->is_featured)
                                            <span style="font-size: 0.65rem; background: var(--db-gold); color: #0a1e12; font-weight: 800; padding: 2px 6px; border-radius: 9999px; margin-left: 6px; text-transform: uppercase;">
                                                <i class="fa-solid fa-star"></i> Featured
                                            </span>
                                        @endif
                                    </div>
                                    <div style="display: flex; gap: 8px; align-items: center; margin-top: 2px;">
                                        <span style="font-size: 0.72rem; color: var(--db-gold); font-weight: 600;">{{ $prod->badge ?? 'AUTHENTIC' }}</span>
                                        <span style="color: #475569; font-size: 0.7rem;">&bull;</span>
                                        <span style="font-size: 0.72rem; color: #94a3b8;">{{ $prod->volume ?? 'Standard' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.82rem; color: #cbd5e1;">{{ $prod->category_name }}</span>
                        </td>
                        <td>
                            <div>
                                <strong style="color: #fff; font-family: 'Cinzel', serif; font-size: 1rem;">
                                    Rs. {{ number_format($prod->effective_price) }}
                                </strong>
                            </div>
                            @if($prod->original_price && $prod->original_price > $prod->effective_price)
                                <span style="text-decoration: line-through; color: #64748b; font-size: 0.8rem;">
                                    Rs. {{ number_format($prod->original_price) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($prod->hasActiveDiscount())
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.75rem; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                        {{ $prod->discount_percent ? $prod->discount_percent . '% OFF' : ($prod->discount ?? 'PROMO') }}
                                    </span>
                                    <form action="{{ route('admin.products.toggle-discount', $prod->id) }}" method="POST" style="margin: 0;" title="Pause Discount">
                                        @csrf
                                        <button type="submit" class="btn-db btn-db-outline" style="padding: 2px 6px; font-size: 0.68rem; color: #34d399; border-color: rgba(52, 211, 153, 0.3);">
                                            ON
                                        </button>
                                    </form>
                                </div>
                                @if($prod->discount_expires_at)
                                    <div style="font-size: 0.7rem; color: #f59e0b; margin-top: 3px;">
                                        Expires: {{ $prod->discount_expires_at->format('d M Y') }}
                                    </div>
                                @endif
                            @else
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="color: #64748b; font-size: 0.75rem;">No Active Sale</span>
                                    @if($prod->discount_percent > 0)
                                        <form action="{{ route('admin.products.toggle-discount', $prod->id) }}" method="POST" style="margin: 0;" title="Activate Discount">
                                            @csrf
                                            <button type="submit" class="btn-db btn-db-outline" style="padding: 2px 6px; font-size: 0.68rem; color: #94a3b8;">
                                                OFF
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($prod->stock > 15)
                                <span class="status-badge badge-active">
                                    <i class="fa-solid fa-circle-check"></i> {{ $prod->stock }} in Stock
                                </span>
                            @elseif($prod->stock > 0)
                                <span class="status-badge badge-pending" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.4); background: rgba(245, 158, 11, 0.1);">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Low ({{ $prod->stock }})
                                </span>
                            @else
                                <span class="status-badge badge-kicked">
                                    <i class="fa-solid fa-ban"></i> Out of Stock
                                </span>
                            @endif
                        </td>
                        <td>
                            <!-- Fast ON/OFF Storefront Switch -->
                            <form action="{{ route('admin.products.toggle-status', $prod->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @if($prod->is_active)
                                    <button type="submit" class="btn-db" style="background: rgba(52, 211, 153, 0.15); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.4); padding: 5px 12px; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; cursor: pointer;" title="Click to hide from store (Turn OFF)">
                                        <i class="fa-solid fa-toggle-on" style="font-size: 0.95rem; margin-right: 4px;"></i> Live (ON)
                                    </button>
                                @else
                                    <button type="submit" class="btn-db" style="background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); padding: 5px 12px; font-size: 0.78rem; font-weight: 700; border-radius: 9999px; cursor: pointer;" title="Click to show on store (Turn ON)">
                                        <i class="fa-solid fa-toggle-off" style="font-size: 0.95rem; margin-right: 4px;"></i> Hidden (OFF)
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <div style="display: inline-flex; gap: 8px;">
                                <button type="button" class="btn-db btn-db-outline" style="padding: 5px 12px;" onclick='openEditProductModal(@json($prod))' title="Edit Product">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" style="margin: 0;" data-confirm="Permanently delete product '{{ addslashes($prod->title) }}' from store catalog?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-db btn-db-outline" style="color: #f87171; border-color: rgba(239, 68, 68, 0.3); padding: 5px 10px;" title="Delete Product">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No products found in catalog.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Product (Premium Luxury Suite) -->
<div class="db-modal-backdrop" id="addProductModal">
    <div class="pm-modal-dialog">
        <!-- Header -->
        <div class="pm-modal-header">
            <div class="pm-modal-title-group">
                <div class="pm-modal-title-icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 class="pm-modal-title">Add New Product to Store</h3>
                    <p class="pm-modal-subtitle">Configure herbal formulation, pricing, dynamic discount, and 4-image showcase gallery</p>
                </div>
            </div>
            <button type="button" class="pm-close-btn" onclick="closeAddProductModal()" aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
            @csrf

            <!-- Scrollable Body -->
            <div class="pm-modal-body">

                <!-- SECTION 1: Product Classification & Identification -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-tag"></i></div>
                            <div>
                                <h4 class="pm-section-title">General Product Information</h4>
                                <p class="pm-section-desc">Set public title, category classification, volume and marketing badge</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label" for="add_title">
                            <span>Product Title <span class="pm-req">*</span></span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">Visible to all customers</span>
                        </label>
                        <div class="pm-input-wrap">
                            <i class="fa-solid fa-heading pm-input-icon"></i>
                            <input type="text" name="title" id="add_title" class="pm-input" placeholder="e.g. Amber's Roots 100% Herbal Hair Growth Oil" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                        <div class="pm-form-group">
                            <label class="pm-label" for="add_category">
                                <span>Category <span class="pm-req">*</span></span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-layer-group pm-input-icon"></i>
                                <select name="category" id="add_category" class="pm-select" required>
                                    <option value="hair-oil">Hair Oil (Herbal Treatment)</option>
                                    <option value="shampoo">Botanical Shampoo (Defense)</option>
                                    <option value="serum">Scalp Density Serum</option>
                                    <option value="skincare">Herbal Glow Skincare</option>
                                    <option value="bundle">Luxury Value Bundle</option>
                                </select>
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="add_volume">
                                <span>Volume / Pack Size <span class="pm-req">*</span></span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-flask pm-input-icon"></i>
                                <input type="text" name="volume" id="add_volume" class="pm-input" placeholder="e.g. 200ml Amber UV Glass Bottle" required>
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="add_badge">
                                <span>Product Badge</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-certificate pm-input-icon"></i>
                                <input type="text" name="badge" id="add_badge" class="pm-input" placeholder="e.g. BEST SELLER, 23% OFF">
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="add_display_order">
                                <span>Display Order / Rank</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-arrow-down-1-9 pm-input-icon"></i>
                                <input type="number" name="display_order" id="add_display_order" class="pm-input" value="0" min="0" placeholder="0 = Appears First">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Pricing, Stock & Dynamic Sale Engine -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-receipt"></i></div>
                            <div>
                                <h4 class="pm-section-title">Pricing, Inventory &amp; Dynamic Sale Engine</h4>
                                <p class="pm-section-desc">Manage retail prices, inventory count, and automated promotional discount</p>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                        <div class="pm-form-group">
                            <label class="pm-label" for="add_price">
                                <span>Selling Price (PKR) <span class="pm-req">*</span></span>
                                <span style="font-size: 0.72rem; color: #34d399;">Customer Pays</span>
                            </label>
                            <div class="pm-input-wrap">
                                <span style="position: absolute; left: 14px; color: var(--db-gold); font-weight: 700; font-size: 0.85rem;">Rs.</span>
                                <input type="number" name="price" id="add_price" class="pm-input" style="padding-left: 44px;" placeholder="2450" min="1" oninput="updateSavings('add')" required>
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="add_original_price">
                                <span>Original / Crossed Price (PKR)</span>
                                <span style="font-size: 0.72rem; color: #94a3b8;">Strike-Through</span>
                            </label>
                            <div class="pm-input-wrap">
                                <span style="position: absolute; left: 14px; color: #94a3b8; font-weight: 700; font-size: 0.85rem;">Rs.</span>
                                <input type="number" name="original_price" id="add_original_price" class="pm-input" style="padding-left: 44px;" placeholder="3200" oninput="updateSavings('add')">
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="add_stock">
                                <span>Stock Quantity <span class="pm-req">*</span></span>
                                <span style="font-size: 0.72rem; color: #60a5fa;">Available Units</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-boxes-stacked pm-input-icon"></i>
                                <input type="number" name="stock" id="add_stock" class="pm-input" value="100" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Discount Sub-Card -->
                    <div class="pm-discount-box">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                            <div style="font-weight: 700; color: var(--db-gold); font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-bolt"></i> Dynamic Sale Configuration
                            </div>
                            <div id="add_savings_pill" class="pm-savings-pill" style="display: none;"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; align-items: center;">
                            <div class="pm-form-group" style="margin-bottom: 0;">
                                <label class="pm-label" for="add_discount_percent" style="font-size: 0.78rem;">Discount Percentage (%)</label>
                                <div class="pm-input-wrap">
                                    <i class="fa-solid fa-percent pm-input-icon"></i>
                                    <input type="number" name="discount_percent" id="add_discount_percent" class="pm-input" placeholder="e.g. 23" min="0" max="95" oninput="updateSavings('add')">
                                </div>
                            </div>

                            <div class="pm-form-group" style="margin-bottom: 0;">
                                <label class="pm-label" for="add_discount_expires_at" style="font-size: 0.78rem;">Sale Expiry Date (Optional)</label>
                                <div class="pm-input-wrap">
                                    <i class="fa-solid fa-calendar-days pm-input-icon"></i>
                                    <input type="date" name="discount_expires_at" id="add_discount_expires_at" class="pm-input">
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(223, 194, 133, 0.2); border-radius: 10px;">
                                <div>
                                    <div style="font-size: 0.82rem; font-weight: 700; color: #fff;">Discount Active</div>
                                    <div style="font-size: 0.7rem; color: #94a3b8;">Display discount badge</div>
                                </div>
                                <label class="pm-toggle">
                                    <input type="checkbox" name="discount_active" id="add_discount_active" value="1" checked>
                                    <span class="pm-toggle-slider gold"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Visual Media & 4-Gallery Showcase -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-images"></i></div>
                            <div>
                                <h4 class="pm-section-title">Product Media &amp; 4-Image Showcase Gallery</h4>
                                <p class="pm-section-desc">Primary catalog photo and 4 high-resolution gallery angles for the detail page</p>
                            </div>
                        </div>
                    </div>

                    <!-- Primary Catalog Image -->
                    <div style="margin-bottom: 22px;">
                        <label class="pm-label">
                            <span>Primary Product Thumbnail (Catalog &amp; Cart)</span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">PNG, JPG, WEBP (Max 5MB)</span>
                        </label>
                        <div class="pm-primary-upload-wrap">
                            <img id="add_primary_preview" src="/assets/product/1000082361.jpg" alt="Primary Preview" class="pm-primary-thumb">
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; font-weight: 700; color: #fff; margin-bottom: 4px;">Main Product Photo</div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 8px;">Upload a clean bottle photo on transparent or light luxury background</div>
                                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                    <label class="pm-gallery-btn" style="width: auto; padding: 7px 18px;">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span>Choose Primary Photo</span>
                                        <input type="file" name="image" id="add_image" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'add_primary_preview', 'add_primary_status')">
                                    </label>
                                    <span id="add_primary_status" style="font-size: 0.78rem; color: #34d399; font-weight: 600; display: none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Gallery Images Showcase -->
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <label class="pm-label" style="margin-bottom: 0;">
                                <span>Detail Page Gallery Showcase (4 Angle Slots)</span>
                            </label>
                            <span style="font-size: 0.72rem; color: var(--db-gold);">Auto-syncs with customer page</span>
                        </div>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0 0 14px;">Leave empty to use high-definition authentic herbal product default photos.</p>

                        <div class="pm-gallery-grid">
                            <!-- Slot 1 -->
                            <div class="pm-gallery-card">
                                <div class="pm-gallery-thumb">
                                    <span class="pm-gallery-badge">Slot 1</span>
                                    <img id="add_gallery_preview_1" src="/assets/product/1000082361.jpg" alt="Image 1 Preview">
                                </div>
                                <div class="pm-gallery-label">Image 1 (Main Front)</div>
                                <label class="pm-gallery-btn">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Upload Image</span>
                                    <input type="file" name="gallery_image_1" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'add_gallery_preview_1', 'add_gallery_status_1')">
                                </label>
                                <span id="add_gallery_status_1" class="pm-gallery-status"></span>
                            </div>

                            <!-- Slot 2 -->
                            <div class="pm-gallery-card">
                                <div class="pm-gallery-thumb">
                                    <span class="pm-gallery-badge">Slot 2</span>
                                    <img id="add_gallery_preview_2" src="/assets/product/1000082362.jpg" alt="Image 2 Preview">
                                </div>
                                <div class="pm-gallery-label">Image 2 (Angle / Detail)</div>
                                <label class="pm-gallery-btn">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Upload Image</span>
                                    <input type="file" name="gallery_image_2" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'add_gallery_preview_2', 'add_gallery_status_2')">
                                </label>
                                <span id="add_gallery_status_2" class="pm-gallery-status"></span>
                            </div>

                            <!-- Slot 3 -->
                            <div class="pm-gallery-card">
                                <div class="pm-gallery-thumb">
                                    <span class="pm-gallery-badge">Slot 3</span>
                                    <img id="add_gallery_preview_3" src="/assets/product/1000082363.jpg" alt="Image 3 Preview">
                                </div>
                                <div class="pm-gallery-label">Image 3 (Texture / Herbs)</div>
                                <label class="pm-gallery-btn">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Upload Image</span>
                                    <input type="file" name="gallery_image_3" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'add_gallery_preview_3', 'add_gallery_status_3')">
                                </label>
                                <span id="add_gallery_status_3" class="pm-gallery-status"></span>
                            </div>

                            <!-- Slot 4 -->
                            <div class="pm-gallery-card">
                                <div class="pm-gallery-thumb">
                                    <span class="pm-gallery-badge">Slot 4</span>
                                    <img id="add_gallery_preview_4" src="/assets/product/1000082365.jpg" alt="Image 4 Preview">
                                </div>
                                <div class="pm-gallery-label">Image 4 (Box / Guarantee)</div>
                                <label class="pm-gallery-btn">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Upload Image</span>
                                    <input type="file" name="gallery_image_4" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'add_gallery_preview_4', 'add_gallery_status_4')">
                                </label>
                                <span id="add_gallery_status_4" class="pm-gallery-status"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: Herbal Formulation & Application Routine -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-leaf"></i></div>
                            <div>
                                <h4 class="pm-section-title">Herbal Description &amp; Application Guide</h4>
                                <p class="pm-section-desc">Ayurvedic properties, benefits summary, ingredients list, and customer usage steps</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label" for="add_desc">
                            <span>Short Description</span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">Main highlighted benefits on landing &amp; detail page</span>
                        </label>
                        <textarea name="short_desc" id="add_desc" rows="3" class="pm-textarea no-icon" placeholder="Highlight key botanical ingredients, clinically proven hair benefits, and quick summary..."></textarea>
                    </div>

                    <div class="db-form-row-2">
                        <div class="pm-form-group" style="margin-bottom: 0;">
                            <label class="pm-label" for="add_ingredients">
                                <span>Key Ayurvedic Ingredients</span>
                            </label>
                            <textarea name="ingredients" id="add_ingredients" rows="3" class="pm-textarea no-icon" placeholder="e.g. Amla, Shikakai, Bhringraj, Rosemary Extract, Kalonji Oil, Castor Oil, Virgin Coconut Oil..."></textarea>
                        </div>

                        <div class="pm-form-group" style="margin-bottom: 0;">
                            <label class="pm-label" for="add_how_to_use">
                                <span>How to Use Routine</span>
                            </label>
                            <textarea name="how_to_use" id="add_how_to_use" rows="3" class="pm-textarea no-icon" placeholder="e.g. Warm 5-10ml between palms, massage scalp for 5-10 mins in circular motion, leave for 2-3 hours or overnight..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 5: Visibility & Spotlight Controls -->
                <div class="pm-card-section" style="margin-bottom: 0;">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-sliders"></i></div>
                            <div>
                                <h4 class="pm-section-title">Store Visibility &amp; Featured Status</h4>
                                <p class="pm-section-desc">Control whether this formulation is actively purchasable and highlighted</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-switch-row">
                        <!-- Switch 1: Live Status -->
                        <div class="pm-switch-card">
                            <div class="pm-switch-info">
                                <div class="pm-switch-icon" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div>
                                    <div class="pm-switch-title">Show on Website (Live Active)</div>
                                    <div class="pm-switch-sub">Product is visible &amp; purchasable by customers</div>
                                </div>
                            </div>
                            <label class="pm-toggle">
                                <input type="checkbox" name="is_active" id="add_is_active" value="1" checked>
                                <span class="pm-toggle-slider green"></span>
                            </label>
                        </div>

                        <!-- Switch 2: Spotlight / Featured -->
                        <div class="pm-switch-card">
                            <div class="pm-switch-info">
                                <div class="pm-switch-icon" style="background: rgba(223, 194, 133, 0.15); color: var(--db-gold);">
                                    <i class="fa-solid fa-crown"></i>
                                </div>
                                <div>
                                    <div class="pm-switch-title">Spotlight / Featured Product</div>
                                    <div class="pm-switch-sub">Pin to Home Page hero and featured showcase</div>
                                </div>
                            </div>
                            <label class="pm-toggle">
                                <input type="checkbox" name="is_featured" id="add_is_featured" value="1">
                                <span class="pm-toggle-slider gold"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="pm-modal-footer">
                <button type="button" class="pm-btn-cancel" onclick="closeAddProductModal()">
                    Cancel
                </button>
                <button type="submit" class="pm-btn-save" style="background: linear-gradient(135deg, #f5dfa8 0%, #c9931b 100%) !important; color: #0c0f16 !important; font-weight: 800; border: 1.5px solid #fae092 !important; box-shadow: 0 4px 18px rgba(201, 147, 27, 0.45);">
                    <i class="fa-solid fa-check" style="color: #0c0f16 !important; font-size: 1rem;"></i>
                    <span style="color: #0c0f16 !important; font-weight: 800;">Save Product to Catalog</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Existing Product (Premium Luxury Suite) -->
<div class="db-modal-backdrop" id="editProductModal">
    <div class="pm-modal-dialog">
        <!-- Header -->
        <div class="pm-modal-header">
            <div class="pm-modal-title-group">
                <div class="pm-modal-title-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="pm-modal-title">Edit Formulation: <span id="editProductTitleHeader" style="color: var(--db-gold);"></span></h3>
                    <p class="pm-modal-subtitle">Update pricing, live discounts, stock level, herbal content, and 4-image showcase gallery</p>
                </div>
            </div>
            <button type="button" class="pm-close-btn" onclick="closeEditProductModal()" aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editProductForm" method="POST" action="" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
            @csrf
            @method('PUT')

            <!-- Scrollable Body -->
            <div class="pm-modal-body">

                <!-- SECTION 1: Product Classification & Identification -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-tag"></i></div>
                            <div>
                                <h4 class="pm-section-title">General Product Information</h4>
                                <p class="pm-section-desc">Public title, category classification, pack size, and marketing badge</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label" for="edit_title">
                            <span>Product Title <span class="pm-req">*</span></span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">Visible to all customers</span>
                        </label>
                        <div class="pm-input-wrap">
                            <i class="fa-solid fa-heading pm-input-icon"></i>
                            <input type="text" name="title" id="edit_title" class="pm-input" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_category">
                                <span>Category <span class="pm-req">*</span></span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-layer-group pm-input-icon"></i>
                                <select name="category" id="edit_category" class="pm-select" required>
                                    <option value="hair-oil">Hair Oil (Herbal Treatment)</option>
                                    <option value="shampoo">Botanical Shampoo (Defense)</option>
                                    <option value="serum">Scalp Density Serum</option>
                                    <option value="skincare">Herbal Glow Skincare</option>
                                    <option value="bundle">Luxury Value Bundle</option>
                                </select>
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_volume">
                                <span>Volume / Pack Size</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-flask pm-input-icon"></i>
                                <input type="text" name="volume" id="edit_volume" class="pm-input" placeholder="e.g. 200ml Amber UV Glass Bottle">
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_badge">
                                <span>Product Badge</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-certificate pm-input-icon"></i>
                                <input type="text" name="badge" id="edit_badge" class="pm-input" placeholder="e.g. BEST SELLER, 23% OFF">
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_display_order">
                                <span>Display Order / Rank</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-arrow-down-1-9 pm-input-icon"></i>
                                <input type="number" name="display_order" id="edit_display_order" class="pm-input" min="0" placeholder="0 = Appears First">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Pricing, Stock & Dynamic Sale Engine -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-receipt"></i></div>
                            <div>
                                <h4 class="pm-section-title">Pricing, Inventory &amp; Dynamic Sale Engine</h4>
                                <p class="pm-section-desc">Manage retail prices, inventory count, and automated promotional discount</p>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_price">
                                <span>Selling Price (PKR) <span class="pm-req">*</span></span>
                                <span style="font-size: 0.72rem; color: #34d399;">Customer Pays</span>
                            </label>
                            <div class="pm-input-wrap">
                                <span style="position: absolute; left: 14px; color: var(--db-gold); font-weight: 700; font-size: 0.85rem;">Rs.</span>
                                <input type="number" name="price" id="edit_price" class="pm-input" style="padding-left: 44px;" min="1" oninput="updateSavings('edit')" required>
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_original_price">
                                <span>Original / Crossed Price (PKR)</span>
                                <span style="font-size: 0.72rem; color: #94a3b8;">Strike-Through</span>
                            </label>
                            <div class="pm-input-wrap">
                                <span style="position: absolute; left: 14px; color: #94a3b8; font-weight: 700; font-size: 0.85rem;">Rs.</span>
                                <input type="number" name="original_price" id="edit_original_price" class="pm-input" style="padding-left: 44px;" oninput="updateSavings('edit')">
                            </div>
                        </div>

                        <div class="pm-form-group">
                            <label class="pm-label" for="edit_stock">
                                <span>Stock Quantity <span class="pm-req">*</span></span>
                                <span style="font-size: 0.72rem; color: #60a5fa;">Available Units</span>
                            </label>
                            <div class="pm-input-wrap">
                                <i class="fa-solid fa-boxes-stacked pm-input-icon"></i>
                                <input type="number" name="stock" id="edit_stock" class="pm-input" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Discount Sub-Card -->
                    <div class="pm-discount-box">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                            <div style="font-weight: 700; color: var(--db-gold); font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-bolt"></i> Dynamic Sale Configuration
                            </div>
                            <div id="edit_savings_pill" class="pm-savings-pill" style="display: none;"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; align-items: center;">
                            <div class="pm-form-group" style="margin-bottom: 0;">
                                <label class="pm-label" for="edit_discount_percent" style="font-size: 0.78rem;">Discount Percentage (%)</label>
                                <div class="pm-input-wrap">
                                    <i class="fa-solid fa-percent pm-input-icon"></i>
                                    <input type="number" name="discount_percent" id="edit_discount_percent" class="pm-input" min="0" max="95" oninput="updateSavings('edit')">
                                </div>
                            </div>

                            <div class="pm-form-group" style="margin-bottom: 0;">
                                <label class="pm-label" for="edit_discount_expires_at" style="font-size: 0.78rem;">Sale Expiry Date (Optional)</label>
                                <div class="pm-input-wrap">
                                    <i class="fa-solid fa-calendar-days pm-input-icon"></i>
                                    <input type="date" name="discount_expires_at" id="edit_discount_expires_at" class="pm-input">
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(223, 194, 133, 0.2); border-radius: 10px;">
                                <div>
                                    <div style="font-size: 0.82rem; font-weight: 700; color: #fff;">Discount Active</div>
                                    <div style="font-size: 0.7rem; color: #94a3b8;">Display discount badge</div>
                                </div>
                                <label class="pm-toggle">
                                    <input type="checkbox" name="discount_active" id="edit_discount_active" value="1">
                                    <span class="pm-toggle-slider gold"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Visual Media & 4-Gallery Showcase -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-images"></i></div>
                            <div>
                                <h4 class="pm-section-title">Product Media &amp; 4-Image Showcase Gallery</h4>
                                <p class="pm-section-desc">Primary catalog photo and 4 high-resolution gallery angles for the detail page</p>
                            </div>
                        </div>
                    </div>

                    <!-- Primary Catalog Image -->
                    <div style="margin-bottom: 22px;">
                        <label class="pm-label">
                            <span>Primary Product Thumbnail (Catalog &amp; Cart)</span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">Leave empty to keep current photo</span>
                        </label>
                        <div class="pm-primary-upload-wrap">
                            <img id="edit_primary_preview" src="/assets/product/1000082361.jpg" alt="Primary Preview" class="pm-primary-thumb">
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; font-weight: 700; color: #fff; margin-bottom: 4px;">Main Product Photo</div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 8px;">Upload a clean bottle photo to replace the current thumbnail</div>
                                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                    <label class="pm-gallery-btn" style="width: auto; padding: 7px 18px;">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span>Replace Primary Photo</span>
                                        <input type="file" name="image" id="edit_image" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'edit_primary_preview', 'edit_primary_status')">
                                    </label>
                                    <span id="edit_primary_status" style="font-size: 0.78rem; color: #34d399; font-weight: 600; display: none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Gallery Images Showcase -->
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <label class="pm-label" style="margin-bottom: 0;">
                                <span>Detail Page Gallery Showcase (4 Angle Slots)</span>
                            </label>
                            <span style="font-size: 0.72rem; color: var(--db-gold);">Instant Customer Showcase</span>
                        </div>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0 0 14px;">Upload new photos to replace any of the 4 slots. Leave empty to keep existing images.</p>

                        <div class="pm-gallery-grid">
                            @for($g = 1; $g <= 4; $g++)
                                @php
                                    $slotNames = [
                                        1 => 'Image 1 (Main Front)',
                                        2 => 'Image 2 (Angle / Detail)',
                                        3 => 'Image 3 (Texture / Dropper)',
                                        4 => 'Image 4 (Box / Guarantee)'
                                    ];
                                @endphp
                                <div class="pm-gallery-card">
                                    <div class="pm-gallery-thumb">
                                        <span class="pm-gallery-badge">Slot {{ $g }}</span>
                                        <img id="edit_gallery_preview_{{ $g }}" src="/assets/product/1000082361.jpg" alt="Slot {{ $g }}">
                                        <i id="edit_gallery_placeholder_{{ $g }}" class="fa-solid fa-image" style="color: #64748b; font-size: 1.5rem; display: none;"></i>
                                    </div>
                                    <div class="pm-gallery-label">{{ $slotNames[$g] }}</div>
                                    <label class="pm-gallery-btn">
                                        <i class="fa-solid fa-camera"></i>
                                        <span>Replace</span>
                                        <input type="file" name="gallery_image_{{ $g }}" accept="image/*" style="display: none;" onchange="previewSingleImage(this, 'edit_gallery_preview_{{ $g }}', 'edit_gallery_status_{{ $g }}')">
                                    </label>
                                    <span id="edit_gallery_status_{{ $g }}" class="pm-gallery-status"></span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: Herbal Formulation & Application Routine -->
                <div class="pm-card-section">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-leaf"></i></div>
                            <div>
                                <h4 class="pm-section-title">Herbal Description &amp; Application Guide</h4>
                                <p class="pm-section-desc">Ayurvedic properties, benefits summary, ingredients list, and customer usage steps</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-form-group">
                        <label class="pm-label" for="edit_desc">
                            <span>Short Description</span>
                            <span style="font-size: 0.72rem; color: #94a3b8;">Main highlighted benefits on landing &amp; detail page</span>
                        </label>
                        <textarea name="short_desc" id="edit_desc" rows="3" class="pm-textarea no-icon"></textarea>
                    </div>

                    <div class="db-form-row-2">
                        <div class="pm-form-group" style="margin-bottom: 0;">
                            <label class="pm-label" for="edit_ingredients">
                                <span>Key Ayurvedic Ingredients</span>
                            </label>
                            <textarea name="ingredients" id="edit_ingredients" rows="3" class="pm-textarea no-icon"></textarea>
                        </div>

                        <div class="pm-form-group" style="margin-bottom: 0;">
                            <label class="pm-label" for="edit_how_to_use">
                                <span>How to Use Routine</span>
                            </label>
                            <textarea name="how_to_use" id="edit_how_to_use" rows="3" class="pm-textarea no-icon"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 5: Visibility & Spotlight Controls -->
                <div class="pm-card-section" style="margin-bottom: 0;">
                    <div class="pm-section-head">
                        <div class="pm-section-title-wrap">
                            <div class="pm-section-icon"><i class="fa-solid fa-sliders"></i></div>
                            <div>
                                <h4 class="pm-section-title">Store Visibility &amp; Featured Status</h4>
                                <p class="pm-section-desc">Control whether this formulation is actively purchasable and highlighted</p>
                            </div>
                        </div>
                    </div>

                    <div class="pm-switch-row">
                        <!-- Switch 1: Live Status -->
                        <div class="pm-switch-card">
                            <div class="pm-switch-info">
                                <div class="pm-switch-icon" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div>
                                    <div class="pm-switch-title">Show on Website (Live Active)</div>
                                    <div class="pm-switch-sub">Product is visible &amp; purchasable by customers</div>
                                </div>
                            </div>
                            <label class="pm-toggle">
                                <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                                <span class="pm-toggle-slider green"></span>
                            </label>
                        </div>

                        <!-- Switch 2: Spotlight / Featured -->
                        <div class="pm-switch-card">
                            <div class="pm-switch-info">
                                <div class="pm-switch-icon" style="background: rgba(223, 194, 133, 0.15); color: var(--db-gold);">
                                    <i class="fa-solid fa-crown"></i>
                                </div>
                                <div>
                                    <div class="pm-switch-title">Spotlight / Featured Product</div>
                                    <div class="pm-switch-sub">Pin to Home Page hero and featured showcase</div>
                                </div>
                            </div>
                            <label class="pm-toggle">
                                <input type="checkbox" name="is_featured" id="edit_is_featured" value="1">
                                <span class="pm-toggle-slider gold"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="pm-modal-footer">
                <button type="button" class="pm-btn-cancel" onclick="closeEditProductModal()">
                    Cancel
                </button>
                <button type="submit" class="pm-btn-save" style="background: linear-gradient(135deg, #f5dfa8 0%, #c9931b 100%) !important; color: #0c0f16 !important; font-weight: 800; border: 1.5px solid #fae092 !important; box-shadow: 0 4px 18px rgba(201, 147, 27, 0.45);">
                    <i class="fa-solid fa-floppy-disk" style="color: #0c0f16 !important; font-size: 1rem;"></i>
                    <span style="color: #0c0f16 !important; font-weight: 800;">Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
/* ==========================================================================
   AMBER'S ROOTS - PREMIUM PRODUCT MANAGEMENT MODAL SUITE
   ========================================================================== */

/* Modal Dialog Sizing & Aesthetics */
.pm-modal-dialog {
    width: 95%;
    max-width: 920px;
    max-height: 90vh;
    background: linear-gradient(165deg, #131722 0%, #0c0f16 100%);
    border: 1.5px solid rgba(223, 194, 133, 0.35);
    border-radius: 20px;
    box-shadow: 0 35px 80px rgba(0, 0, 0, 0.85), 0 0 50px rgba(201, 147, 27, 0.12);
    display: flex;
    flex-direction: column;
    padding: 0;
    overflow: hidden;
    position: relative;
    animation: pmModalFadeIn 0.28s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes pmModalFadeIn {
    from { opacity: 0; transform: scale(0.96) translateY(14px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

/* Modal Header */
.pm-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 22px 28px;
    background: rgba(255, 255, 255, 0.02);
    border-bottom: 1px solid rgba(223, 194, 133, 0.2);
    flex-shrink: 0;
}

.pm-modal-title-group {
    display: flex;
    align-items: center;
    gap: 14px;
}

.pm-modal-title-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(223, 194, 133, 0.15);
    border: 1.5px solid rgba(223, 194, 133, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--db-gold);
    font-size: 1.25rem;
    box-shadow: 0 4px 14px rgba(201, 147, 27, 0.2);
}

.pm-modal-title {
    font-family: 'Cinzel', serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    line-height: 1.2;
}

.pm-modal-subtitle {
    font-size: 0.8rem;
    color: #94a3b8;
    margin: 3px 0 0;
}

.pm-close-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #cbd5e1;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.pm-close-btn:hover {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.4);
    color: #f87171;
    transform: rotate(90deg);
}

/* Modal Body */
.pm-modal-body {
    padding: 24px 28px;
    overflow-y: auto;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: rgba(223, 194, 133, 0.4) transparent;
}

.pm-modal-body::-webkit-scrollbar {
    width: 7px;
}

.pm-modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.pm-modal-body::-webkit-scrollbar-thumb {
    background: rgba(223, 194, 133, 0.35);
    border-radius: 10px;
}

/* Card-Based Modular Sections */
.pm-card-section {
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(223, 194, 133, 0.18);
    border-radius: 16px;
    padding: 20px 22px;
    margin-bottom: 20px;
    transition: border-color 0.25s ease;
}

.pm-card-section:hover {
    border-color: rgba(223, 194, 133, 0.35);
}

.pm-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.pm-section-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pm-section-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(223, 194, 133, 0.12);
    color: var(--db-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
}

.pm-section-title {
    font-size: 0.98rem;
    font-weight: 700;
    color: #f8fafc;
    margin: 0;
}

.pm-section-desc {
    font-size: 0.78rem;
    color: #94a3b8;
    margin: 2px 0 0;
}

/* High Contrast Input Fields */
.pm-form-group {
    margin-bottom: 16px;
}

.pm-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.825rem;
    font-weight: 600;
    color: #f1f5f9;
    margin-bottom: 7px;
    letter-spacing: 0.01em;
}

.pm-req {
    color: var(--db-gold);
    margin-left: 3px;
    font-weight: 700;
}

.pm-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.pm-input-icon {
    position: absolute;
    left: 14px;
    color: #64748b;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.2s;
}

.pm-input-wrap:focus-within .pm-input-icon {
    color: var(--db-gold);
}

.pm-input, .pm-select, .pm-textarea {
    width: 100%;
    padding: 11px 14px 11px 40px;
    background: #080a0f;
    border: 1.5px solid rgba(255, 255, 255, 0.14);
    border-radius: 10px;
    color: #ffffff;
    font-size: 0.92rem;
    font-weight: 500;
    outline: none;
    transition: all 0.2s ease;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.4);
}

.pm-input.no-icon, .pm-select.no-icon, .pm-textarea.no-icon {
    padding-left: 14px;
}

.pm-input:focus, .pm-select:focus, .pm-textarea:focus {
    border-color: #dfc285;
    background: #0d1017;
    box-shadow: 0 0 0 3px rgba(223, 194, 133, 0.2), inset 0 1px 2px rgba(0, 0, 0, 0.3);
}

.pm-input::placeholder, .pm-textarea::placeholder {
    color: #475569;
}

.pm-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23dfc285'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 16px;
    padding-right: 38px;
}

.pm-select option {
    background: #11141c;
    color: #ffffff;
}

.pm-textarea {
    resize: vertical;
    min-height: 75px;
    line-height: 1.5;
    padding: 12px 14px;
}

/* Discount & Savings Engine Card */
.pm-discount-box {
    background: linear-gradient(135deg, rgba(201, 147, 27, 0.08) 0%, rgba(201, 147, 27, 0.02) 100%);
    border: 1.5px solid rgba(223, 194, 133, 0.3);
    border-radius: 14px;
    padding: 18px 20px;
    margin-top: 14px;
}

.pm-savings-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.35);
    color: #34d399;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 9999px;
}

/* 4-Image Showcase Cards */
.pm-gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 12px;
}

.pm-gallery-card {
    background: #090b10;
    border: 1.5px solid rgba(223, 194, 133, 0.25);
    border-radius: 14px;
    padding: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: all 0.25s ease;
    position: relative;
}

.pm-gallery-card:hover {
    border-color: var(--db-gold);
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.4);
}

.pm-gallery-thumb {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 10px;
    background: #05070a;
    border: 1px dashed rgba(223, 194, 133, 0.35);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    position: relative;
}

.pm-gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 9px;
    transition: transform 0.3s ease;
}

.pm-gallery-card:hover .pm-gallery-thumb img {
    transform: scale(1.04);
}

.pm-gallery-badge {
    position: absolute;
    top: 6px;
    left: 6px;
    background: rgba(0, 0, 0, 0.7);
    color: var(--db-gold);
    font-size: 0.68rem;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 6px;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(223, 194, 133, 0.3);
}

.pm-gallery-label {
    font-size: 0.76rem;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.pm-gallery-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 10px;
    background: rgba(223, 194, 133, 0.12);
    border: 1px solid rgba(223, 194, 133, 0.35);
    border-radius: 8px;
    color: var(--db-gold);
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}

.pm-gallery-btn:hover {
    background: var(--db-gold);
    color: #0d0f14;
    border-color: var(--db-gold);
    box-shadow: 0 4px 12px rgba(201, 147, 27, 0.3);
}

.pm-gallery-status {
    font-size: 0.68rem;
    color: #10b981;
    margin-top: 5px;
    display: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

/* Primary Image Upload Banner */
.pm-primary-upload-wrap {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 16px 20px;
    background: #090b10;
    border: 1.5px solid rgba(223, 194, 133, 0.25);
    border-radius: 14px;
}

.pm-primary-thumb {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    border: 1.5px solid rgba(223, 194, 133, 0.35);
    object-fit: cover;
    background: #05070a;
}

/* Illuminated iOS Toggle Switches */
.pm-switch-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.pm-switch-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #090b10;
    border: 1.5px solid rgba(255, 255, 255, 0.12);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.pm-switch-card:hover {
    border-color: rgba(223, 194, 133, 0.35);
}

.pm-switch-info {
    display: flex;
    align-items: center;
    gap: 14px;
}

.pm-switch-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
}

.pm-switch-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.pm-switch-sub {
    font-size: 0.74rem;
    color: #94a3b8;
    margin: 2px 0 0;
}

/* Switch UI Element */
.pm-toggle {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
}

.pm-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.pm-toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #262b36;
    transition: 0.3s;
    border-radius: 34px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.pm-toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: #ffffff;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
}

.pm-toggle input:checked + .pm-toggle-slider.green {
    background-color: #10b981;
    border-color: #10b981;
    box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
}

.pm-toggle input:checked + .pm-toggle-slider.gold {
    background-color: var(--db-gold);
    border-color: var(--db-gold);
    box-shadow: 0 0 12px rgba(223, 194, 133, 0.4);
}

.pm-toggle input:checked + .pm-toggle-slider:before {
    transform: translateX(22px);
}

/* Modal Footer */
.pm-modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 14px;
    padding: 18px 28px;
    background: rgba(14, 17, 24, 0.95);
    border-top: 1px solid rgba(223, 194, 133, 0.2);
    flex-shrink: 0;
}

.pm-btn-cancel {
    padding: 12px 24px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #f1f5f9;
    font-size: 0.92rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.pm-btn-cancel:hover {
    background: rgba(255, 255, 255, 0.16);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.35);
}

.pm-btn-save {
    padding: 12px 30px;
    background: linear-gradient(135deg, #f5dfa8 0%, #c9931b 100%) !important;
    border: 1.5px solid #fae092 !important;
    color: #0c0f16 !important;
    font-size: 0.95rem;
    font-weight: 800;
    border-radius: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 18px rgba(201, 147, 27, 0.45);
    transition: all 0.25s ease;
}

.pm-btn-save:hover {
    background: linear-gradient(135deg, #ffffff 0%, #dfc285 100%) !important;
    color: #000000 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(201, 147, 27, 0.65);
}

.pm-btn-save * {
    color: #0c0f16 !important;
}

.pm-btn-save:hover * {
    color: #000000 !important;
}

@media (max-width: 768px) {
    .pm-gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .pm-switch-row {
        grid-template-columns: 1fr;
    }
    .pm-modal-header {
        padding: 18px 20px;
    }
    .pm-modal-body {
        padding: 18px 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.add('is-open');
        updateSavings('add');
    }

    function closeAddProductModal() {
        document.getElementById('addProductModal').classList.remove('is-open');
    }

    function openEditProductModal(prod) {
        const form = document.getElementById('editProductForm');
        form.action = `/admin/products/${prod.id}`;
        
        document.getElementById('editProductTitleHeader').innerText = prod.title;
        document.getElementById('edit_title').value = prod.title || '';
        document.getElementById('edit_category').value = prod.category || 'hair-oil';
        document.getElementById('edit_volume').value = prod.volume || '';
        document.getElementById('edit_price').value = prod.price || '';
        document.getElementById('edit_original_price').value = prod.original_price || '';
        document.getElementById('edit_stock').value = prod.stock || 0;
        document.getElementById('edit_discount_percent').value = prod.discount_percent || '';
        document.getElementById('edit_discount_active').checked = !!prod.discount_active;
        
        if (prod.discount_expires_at) {
            const expDate = new Date(prod.discount_expires_at).toISOString().split('T')[0];
            document.getElementById('edit_discount_expires_at').value = expDate;
        } else {
            document.getElementById('edit_discount_expires_at').value = '';
        }

        document.getElementById('edit_display_order').value = prod.display_order || 0;
        document.getElementById('edit_badge').value = prod.badge || '';
        document.getElementById('edit_desc').value = prod.short_desc || '';
        document.getElementById('edit_ingredients').value = prod.ingredients || '';
        document.getElementById('edit_how_to_use').value = prod.how_to_use || '';
        document.getElementById('edit_is_active').checked = !!prod.is_active;
        document.getElementById('edit_is_featured').checked = !!prod.is_featured;

        // Primary Image Preview
        const primaryImg = document.getElementById('edit_primary_preview');
        if (primaryImg) {
            const pPath = prod.image || 'assets/product/1000082361.jpg';
            primaryImg.src = pPath.startsWith('http') || pPath.startsWith('/') ? pPath : `/${pPath}`;
        }
        const pStatus = document.getElementById('edit_primary_status');
        if (pStatus) pStatus.style.display = 'none';

        // 4 Gallery Images Showcase
        const defaultGallery = [
            'assets/product/1000082361.jpg',
            'assets/product/1000082362.jpg',
            'assets/product/1000082363.jpg',
            'assets/product/1000082365.jpg'
        ];
        const gallery = Array.isArray(prod.gallery) && prod.gallery.length > 0 ? prod.gallery : defaultGallery;

        for (let g = 1; g <= 4; g++) {
            const prevImg = document.getElementById(`edit_gallery_preview_${g}`);
            const prevPlaceholder = document.getElementById(`edit_gallery_placeholder_${g}`);
            const statusEl = document.getElementById(`edit_gallery_status_${g}`);
            const rawPath = gallery[g - 1] || defaultGallery[g - 1] || defaultGallery[0];

            if (statusEl) statusEl.style.display = 'none';

            if (rawPath && prevImg) {
                const fullUrl = rawPath.startsWith('http') || rawPath.startsWith('/') ? rawPath : `/${rawPath}`;
                prevImg.src = fullUrl;
                prevImg.style.display = 'block';
                if (prevPlaceholder) prevPlaceholder.style.display = 'none';
            } else if (prevPlaceholder) {
                if (prevImg) prevImg.style.display = 'none';
                prevPlaceholder.style.display = 'block';
            }
        }

        updateSavings('edit');
        document.getElementById('editProductModal').classList.add('is-open');
    }

    function closeEditProductModal() {
        document.getElementById('editProductModal').classList.remove('is-open');
    }

    // Live Image Preview Function for File Inputs
    function previewSingleImage(input, previewId, statusId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (statusId) {
                    const st = document.getElementById(statusId);
                    if (st) {
                        st.style.display = 'inline-block';
                        st.innerHTML = `<i class="fa-solid fa-check"></i> ${file.name.substring(0, 16)}`;
                        st.title = file.name;
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Live Savings & Discount Calculator
    function updateSavings(prefix) {
        const priceInput = document.getElementById(`${prefix}_price`);
        const origInput = document.getElementById(`${prefix}_original_price`);
        const discInput = document.getElementById(`${prefix}_discount_percent`);
        const pill = document.getElementById(`${prefix}_savings_pill`);

        if (!pill || !priceInput) return;

        const price = parseFloat(priceInput.value) || 0;
        const orig = parseFloat(origInput ? origInput.value : 0) || 0;
        let disc = parseFloat(discInput ? discInput.value : 0) || 0;

        if (orig > price && price > 0) {
            const saved = orig - price;
            const pct = Math.round((saved / orig) * 100);
            pill.style.display = 'inline-flex';
            pill.innerHTML = `<i class="fa-solid fa-tag"></i> Save Rs. ${saved.toLocaleString()} (${pct}% OFF)`;
            if (discInput && (!disc || disc === 0)) {
                discInput.value = pct;
            }
        } else if (disc > 0 && price > 0) {
            const origCalculated = Math.round(price / (1 - (disc / 100)));
            const saved = origCalculated - price;
            pill.style.display = 'inline-flex';
            pill.innerHTML = `<i class="fa-solid fa-tag"></i> Save Rs. ${saved.toLocaleString()} (${disc}% OFF)`;
        } else {
            pill.style.display = 'none';
        }
    }

    // Close on Backdrop Click or Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddProductModal();
            closeEditProductModal();
        }
    });

    ['addProductModal', 'editProductModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    if (id === 'addProductModal') closeAddProductModal();
                    if (id === 'editProductModal') closeEditProductModal();
                }
            });
        }
    });
</script>
@endpush

@endsection
