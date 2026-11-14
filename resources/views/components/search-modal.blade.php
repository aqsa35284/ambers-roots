<!-- Search Modal -->
<div class="rm-modal-backdrop" id="rmSearchModal" aria-hidden="true">
    <div class="rm-search-modal-box">
        <!-- Search Input Bar -->
        <div class="rm-search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="rmSearchInput" class="rm-search-input" placeholder="Search for hair oil, organic shampoo, face wash, serums..." autocomplete="off">
            <button type="button" class="rm-modal-close-btn" data-close-search aria-label="Close search">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Search Body / Suggestions -->
        <div class="rm-search-body">
            <div class="rm-search-tags-title">Popular Searches</div>
            <div class="rm-search-tags">
                <span class="rm-tag-chip">Amber's Roots Hair Oil</span>
                <span class="rm-tag-chip">Anti Hairfall Shampoo</span>
                <span class="rm-tag-chip">Herbal Scalp Serum</span>
                <span class="rm-tag-chip">Organic Face Wash</span>
                <span class="rm-tag-chip">Mega Azadi Bundle</span>
            </div>

            <div class="rm-search-tags-title">Featured Formulations</div>
            
            <!-- Result 1 -->
            <div class="rm-quick-product-item">
                <a href="{{ url('/product/rivaaj-mahal-hair-oil') }}" style="display:flex; align-items:center; gap: 14px; flex: 1; text-decoration: none;">
                    <div class="rm-quick-product-img" style="display:flex; align-items:center; justify-content:center; background:#f5efe6; color:var(--rm-gold-dark); font-size:1.5rem;">
                        <i class="fa-solid fa-bottle-droplet"></i>
                    </div>
                    <div class="rm-quick-product-info">
                        <div class="rm-quick-product-title">Amber's Roots 100% Herbal Hair Growth Oil (200ml)</div>
                        <div class="rm-quick-product-price">Rs. 2,450 <span style="text-decoration: line-through; color: #94a3b8; font-size: 0.8rem; margin-left: 6px;">Rs. 3,200</span></div>
                    </div>
                </a>
                <button type="button" class="rm-btn-primary" style="padding: 8px 16px; font-size: 0.8rem;" 
                        data-add-to-cart 
                        data-product-title="Amber's Roots 100% Herbal Hair Growth Oil" 
                        data-product-price="Rs. 2,450"
                        data-product-slug="rivaaj-mahal-hair-oil"
                        data-product-icon="fa-bottle-droplet">
                    <i class="fa-solid fa-cart-plus"></i> Add
                </button>
            </div>

            <!-- Result 2 -->
            <div class="rm-quick-product-item">
                <a href="{{ url('/product/organic-botanical-shampoo') }}" style="display:flex; align-items:center; gap: 14px; flex: 1; text-decoration: none;">
                    <div class="rm-quick-product-img" style="display:flex; align-items:center; justify-content:center; background:#f5efe6; color:#9e7a33; font-size:1.5rem;">
                        <i class="fa-solid fa-pump-soap"></i>
                    </div>
                    <div class="rm-quick-product-info">
                        <div class="rm-quick-product-title">Organic Botanical Anti-Hairfall & Strengthening Shampoo (300ml)</div>
                        <div class="rm-quick-product-price">Rs. 1,850</div>
                    </div>
                </a>
                <button type="button" class="rm-btn-primary" style="padding: 8px 16px; font-size: 0.8rem;" 
                        data-add-to-cart 
                        data-product-title="Organic Botanical Anti-Hairfall & Strengthening Shampoo" 
                        data-product-price="Rs. 1,850"
                        data-product-slug="organic-botanical-shampoo"
                        data-product-icon="fa-pump-soap">
                    <i class="fa-solid fa-cart-plus"></i> Add
                </button>
            </div>

            <!-- Result 3 -->
            <div class="rm-quick-product-item">
                <a href="{{ url('/product/complete-hair-care-azadi-bundle') }}" style="display:flex; align-items:center; gap: 14px; flex: 1; text-decoration: none;">
                    <div class="rm-quick-product-img" style="display:flex; align-items:center; justify-content:center; background:#f5efe6; color:#9e7a33; font-size:1.5rem;">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div class="rm-quick-product-info">
                        <div class="rm-quick-product-title">Complete Hair Care Azadi Package (Full Kit)</div>
                        <div class="rm-quick-product-price">Rs. 4,990 <span style="text-decoration: line-through; color: #94a3b8; font-size: 0.8rem; margin-left: 6px;">Rs. 7,600</span></div>
                    </div>
                </a>
                <button type="button" class="rm-btn-primary" style="padding: 8px 16px; font-size: 0.8rem;" 
                        data-add-to-cart 
                        data-product-title="Complete Hair Care Azadi Package" 
                        data-product-price="Rs. 4,990"
                        data-product-slug="complete-hair-care-azadi-bundle"
                        data-product-icon="fa-boxes-stacked">
                    <i class="fa-solid fa-cart-plus"></i> Add
                </button>
            </div>
        </div>
    </div>
</div>
