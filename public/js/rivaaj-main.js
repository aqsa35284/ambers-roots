/**
 * Amber's Roots - Dynamic Cart Store (localStorage), Modals, and Navigation
 */

// ==========================================================================
// AMBER'S ROOTS CART MANAGER (Dynamic LocalStorage Store)
// ==========================================================================
window.RivaajCart = {
    STORAGE_KEY: 'rivaaj_mahal_cart_v1',

    getCart: function() {
        try {
            const data = localStorage.getItem(this.STORAGE_KEY);
            if (data !== null) {
                let cart = JSON.parse(data);
                if (Array.isArray(cart)) {
                    let modified = false;
                    const merged = [];
                    cart.forEach(item => {
                        if (!item || !item.title) return;
                        let cleanTitle = String(item.title)
                            .replace(/Rivaaj\s*Mahal/gi, "Amber's Roots")
                            .replace(/\bRivaaj\b/gi, "Amber's Roots")
                            .trim();

                        if (cleanTitle !== item.title) {
                            item.title = cleanTitle;
                            modified = true;
                        }

                        if (!item.image) {
                            item.image = cleanTitle.toLowerCase().includes('shampoo') 
                                ? '/assets/product/1000082362.jpg' 
                                : '/assets/product/1000082361.jpg';
                            modified = true;
                        }

                        // Deduplicate items with matching title
                        const existing = merged.find(m => m.title.trim().toLowerCase() === item.title.trim().toLowerCase());
                        if (existing) {
                            existing.quantity = (parseInt(existing.quantity) || 1) + (parseInt(item.quantity) || 1);
                            modified = true;
                        } else {
                            merged.push(item);
                        }
                    });

                    if (modified) {
                        try {
                            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(merged));
                        } catch (e) {}
                    }
                    return merged;
                }
            }
        } catch (e) {
            console.error('Error loading cart', e);
        }

        // Only on fresh first visit when no storage key exists at all
        const initialCart = [
            {
                title: "Amber's Roots 100% Herbal Hair Growth Oil",
                price: 'Rs. 2,450',
                slug: 'rivaaj-mahal-hair-oil',
                image: '/assets/product/1000082361.jpg',
                icon: 'fa-bottle-droplet',
                quantity: 1
            }
        ];
        this.saveCart(initialCart);
        return initialCart;
    },

    saveCart: function(cart) {
        try {
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(cart));
            this.updateBadge();
            this.renderDrawer();
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: cart }));
        } catch (e) {
            console.error('Error saving cart', e);
        }
    },

    addItem: function(item) {
        const cart = this.getCart();
        const rawTitle = (item && item.title) ? String(item.title) : "Amber's Roots 100% Herbal Hair Growth Oil";
        const cleanTitle = rawTitle.replace(/Rivaaj\s*Mahal/gi, "Amber's Roots").replace(/\bRivaaj\b/gi, "Amber's Roots").trim();
        const existing = cart.find(i => i.title.trim().toLowerCase() === cleanTitle.toLowerCase());
        const addQty = parseInt(item.quantity) || 1;
        const defaultImg = cleanTitle.toLowerCase().includes('shampoo') 
            ? '/assets/product/1000082362.jpg' 
            : '/assets/product/1000082361.jpg';

        if (existing) {
            existing.quantity += addQty;
            if (!existing.image) existing.image = item.image || defaultImg;
        } else {
            cart.push({
                title: cleanTitle,
                price: item.price || 'Rs. 2,450',
                slug: item.slug || 'rivaaj-mahal-hair-oil',
                image: item.image || defaultImg,
                icon: item.icon || 'fa-bottle-droplet',
                quantity: addQty
            });
        }

        this.saveCart(cart);
        this.triggerCartPop();
        showToast(`Added ${addQty}x "${cleanTitle}" to your cart!`);
    },

    triggerCartPop: function() {
        const targets = document.querySelectorAll('.rm-cart-badge, [data-open-cart] i, .rm-nav-cart-btn i');
        targets.forEach(el => {
            el.classList.remove('rm-cart-pop');
            void el.offsetWidth;
            el.classList.add('rm-cart-pop');
            setTimeout(() => {
                el.classList.remove('rm-cart-pop');
            }, 500);
        });
    },

    removeItemByIndex: function(index) {
        let cart = this.getCart();
        const idx = parseInt(index);
        if (!isNaN(idx) && idx >= 0 && idx < cart.length) {
            const removed = cart.splice(idx, 1)[0];
            this.saveCart(cart);
            showToast(`Removed "${removed ? removed.title : 'Item'}" from cart`);
        }
    },

    removeItem: function(identifier) {
        if (typeof identifier === 'number') {
            return this.removeItemByIndex(identifier);
        }
        if (!identifier) return;
        const target = String(identifier).trim().toLowerCase().replace(/['"’]/g, '');
        let cart = this.getCart();
        const initialLength = cart.length;
        cart = cart.filter(i => {
            const norm = (i.title || '').trim().toLowerCase().replace(/['"’]/g, '');
            const slugNorm = (i.slug || '').trim().toLowerCase();
            return norm !== target && slugNorm !== target;
        });
        if (cart.length !== initialLength) {
            this.saveCart(cart);
            showToast('Item removed from cart');
        }
    },

    updateQuantityByIndex: function(index, newQty) {
        let cart = this.getCart();
        const idx = parseInt(index);
        const qty = parseInt(newQty);
        if (!isNaN(idx) && idx >= 0 && idx < cart.length) {
            if (isNaN(qty) || qty <= 0) {
                this.removeItemByIndex(idx);
                return;
            }
            cart[idx].quantity = qty;
            this.saveCart(cart);
        }
    },

    updateQuantity: function(identifier, newQty) {
        if (typeof identifier === 'number') {
            return this.updateQuantityByIndex(identifier, newQty);
        }
        if (!identifier) return;
        const target = String(identifier).trim().toLowerCase().replace(/['"’]/g, '');
        let cart = this.getCart();
        const idx = cart.findIndex(i => {
            const norm = (i.title || '').trim().toLowerCase().replace(/['"’]/g, '');
            const slugNorm = (i.slug || '').trim().toLowerCase();
            return norm === target || slugNorm === target;
        });
        if (idx !== -1) {
            const qty = parseInt(newQty);
            if (isNaN(qty) || qty <= 0) {
                this.removeItemByIndex(idx);
            } else {
                cart[idx].quantity = qty;
                this.saveCart(cart);
            }
        }
    },

    getTotalCount: function() {
        const cart = this.getCart();
        return cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
    },

    getTotalAmount: function() {
        const cart = this.getCart();
        return cart.reduce((sum, item) => {
            const numericPrice = parseInt(item.price.replace(/[^0-9]/g, '')) || 0;
            return sum + (numericPrice * (parseInt(item.quantity) || 1));
        }, 0);
    },

    updateBadge: function() {
        const badges = document.querySelectorAll('.rm-cart-badge');
        const count = this.getTotalCount();
        badges.forEach(b => {
            b.textContent = count;
            b.style.display = count > 0 ? 'flex' : 'none';
        });
    },

    renderDrawer: function() {
        const container = document.querySelector('.rm-cart-items-wrap');
        const subtotalEl = document.querySelector('.rm-cart-subtotal-val');
        if (!container) return;

        const cart = this.getCart();

        if (cart.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px 10px; color: #64748b;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--rm-gold-subtle); margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; color: var(--rm-gold-dark); font-size: 1.5rem;">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; color: var(--rm-dark); margin-bottom: 6px;">Your Cart is Empty</h4>
                    <p style="font-size: 0.8125rem; margin-bottom: 18px;">Add your favorite herbal hair care products to get started.</p>
                    <a href="/products" class="rm-btn-secondary" style="display: inline-flex; padding: 8px 18px; font-size: 0.8125rem;">
                        Browse Products
                    </a>
                </div>
            `;
            if (subtotalEl) subtotalEl.textContent = 'Rs. 0';
            return;
        }

        container.innerHTML = '';
        cart.forEach((item, index) => {
            const itemEl = document.createElement('div');
            itemEl.className = 'rm-cart-item';
            const itemImg = item.image || ((item.title && item.title.toLowerCase().includes('shampoo')) ? '/assets/product/1000082362.jpg' : '/assets/product/1000082361.jpg');
            const safeTitle = item.title.replace(/"/g, '&quot;');
            itemEl.innerHTML = `
                <a href="/product/${item.slug || 'rivaaj-mahal-hair-oil'}" class="rm-cart-item-img" style="display:flex; align-items:center; justify-content:center; background:#faf5ee; text-decoration: none; overflow: hidden; padding: 2px;">
                    <img src="${itemImg}" alt="${safeTitle}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" onerror="this.onerror=null; this.src='/assets/product/1000082361.jpg';">
                </a>
                <div class="rm-cart-item-details">
                    <div>
                        <a href="/product/${item.slug || 'rivaaj-mahal-hair-oil'}" class="rm-cart-item-title" style="text-decoration:none; display:block;">
                            ${item.title}
                        </a>
                        <div class="rm-cart-item-price">${item.price}</div>
                    </div>
                    <div class="rm-cart-qty-ctrl">
                        <button type="button" class="rm-qty-btn qty-minus" aria-label="Decrease quantity" onclick="window.RivaajCart.updateQuantityByIndex(${index}, ${item.quantity - 1})">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="rm-qty-num">${item.quantity}</span>
                        <button type="button" class="rm-qty-btn qty-plus" aria-label="Increase quantity" onclick="window.RivaajCart.updateQuantityByIndex(${index}, ${item.quantity + 1})">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="rm-cart-item-remove" title="Remove item" aria-label="Remove item" onclick="window.RivaajCart.removeItemByIndex(${index})">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            `;
            container.appendChild(itemEl);
        });

        if (subtotalEl) {
            subtotalEl.textContent = 'Rs. ' + this.getTotalAmount().toLocaleString();
        }
    }
};

// ==========================================================================
// DOM INTERACTION INITIALIZER
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Cart State
    window.RivaajCart.updateBadge();
    window.RivaajCart.renderDrawer();

    // ----------------------------------------------------
    // Sticky Header Scroll Effect
    // ----------------------------------------------------
    const headerWrapper = document.querySelector('.rm-header-wrapper');
    if (headerWrapper) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                headerWrapper.classList.add('is-scrolled');
            } else {
                headerWrapper.classList.remove('is-scrolled');
            }
        });
    }

    // ----------------------------------------------------
    // Search Modal
    // ----------------------------------------------------
    const searchModal = document.getElementById('rmSearchModal');
    const searchOpenBtns = document.querySelectorAll('[data-open-search]');
    const searchCloseBtns = document.querySelectorAll('[data-close-search]');
    const searchInput = document.getElementById('rmSearchInput');

    function openSearch() {
        if (!searchModal) return;
        searchModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 150);
    }

    function closeSearch() {
        if (!searchModal) return;
        searchModal.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    searchOpenBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        openSearch();
    }));

    searchCloseBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        closeSearch();
    }));

    if (searchModal) {
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) closeSearch();
        });
    }

    // Search tag click fills search
    const tagChips = document.querySelectorAll('.rm-tag-chip');
    tagChips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (searchInput) {
                searchInput.value = chip.textContent.trim();
                searchInput.focus();
            }
        });
    });

    // ----------------------------------------------------
    // Cart Drawer Open/Close
    // ----------------------------------------------------
    const cartDrawer = document.getElementById('rmCartDrawer');
    const cartOpenBtns = document.querySelectorAll('[data-open-cart]');
    const cartCloseBtns = document.querySelectorAll('[data-close-cart]');

    window.openCartDrawer = function() {
        if (!cartDrawer) return;
        window.RivaajCart.renderDrawer();
        cartDrawer.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    };

    window.closeCartDrawer = function() {
        if (!cartDrawer) return;
        cartDrawer.classList.remove('is-open');
        document.body.style.overflow = '';
    };

    cartOpenBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        window.openCartDrawer();
    }));

    cartCloseBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        window.closeCartDrawer();
    }));

    if (cartDrawer) {
        cartDrawer.addEventListener('click', (e) => {
            if (e.target === cartDrawer) window.closeCartDrawer();
        });
    }

    // ----------------------------------------------------
    // Add To Cart Event Delegation (Handles all buttons across pages)
    // ----------------------------------------------------
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-add-to-cart]');
        if (btn) {
            e.preventDefault();
            const rawTitle = btn.getAttribute('data-product-title') || "Amber's Roots 100% Herbal Hair Growth Oil";
            const title = rawTitle.replace(/Rivaaj\s*Mahal/gi, "Amber's Roots").replace(/\bRivaaj\b/gi, "Amber's Roots");
            const price = btn.getAttribute('data-product-price') || 'Rs. 2,450';
            const slug = btn.getAttribute('data-product-slug') || 'ambers-roots-hair-oil';
            const icon = btn.getAttribute('data-product-icon') || 'fa-bottle-droplet';
            const image = btn.getAttribute('data-product-image') || '';
            
            // Check if there is a quantity input on the page (e.g. Product Detail page)
            const qtyEl = document.getElementById('qtyValue');
            const qty = qtyEl ? (parseInt(qtyEl.textContent) || 1) : 1;

            window.RivaajCart.addItem({
                title: title,
                price: price,
                slug: slug,
                icon: icon,
                image: image,
                quantity: qty
            });

            setTimeout(() => {
                window.openCartDrawer();
            }, 300);
        }
    });

    // ----------------------------------------------------
    // Login Modal
    // ----------------------------------------------------
    const loginModal = document.getElementById('rmLoginModal');
    const loginOpenBtns = document.querySelectorAll('[data-open-login]');
    const loginCloseBtns = document.querySelectorAll('[data-close-login]');

    function openLogin() {
        if (!loginModal) return;
        loginModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeLogin() {
        if (!loginModal) return;
        loginModal.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    loginOpenBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        openLogin();
    }));

    loginCloseBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        closeLogin();
    }));

    if (loginModal) {
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) closeLogin();
        });
    }

    // ----------------------------------------------------
    // Mobile Drawer
    // ----------------------------------------------------
    const mobileDrawer = document.getElementById('rmMobileDrawer');
    const mobileToggle = document.getElementById('rmMobileToggle');
    const mobileClose = document.getElementById('rmMobileClose');

    function openMobileNav() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileNav() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', (e) => {
            e.preventDefault();
            openMobileNav();
        });
    }

    if (mobileClose) {
        mobileClose.addEventListener('click', (e) => {
            e.preventDefault();
            closeMobileNav();
        });
    }

    if (mobileDrawer) {
        mobileDrawer.addEventListener('click', (e) => {
            if (e.target === mobileDrawer) closeMobileNav();
        });
    }

    // ----------------------------------------------------
    // Global ESC Key Listener
    // ----------------------------------------------------
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSearch();
            window.closeCartDrawer();
            closeLogin();
            closeMobileNav();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openSearch();
        }
    });

    // ----------------------------------------------------
    // Toast Notification Utility
    // ----------------------------------------------------
    window.showToast = function(message) {
        let toast = document.querySelector('.rm-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'rm-toast';
            document.body.appendChild(toast);
        }
        toast.innerHTML = `<i class="fa-solid fa-circle-check"></i> <span>${message}</span>`;
        toast.classList.add('is-active');

        setTimeout(() => {
            toast.classList.remove('is-active');
        }, 3200);
    };

    // Newsletter submit feedback
    const newsletterForm = document.querySelector('.rm-newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = newsletterForm.querySelector('input');
            if (input && input.value) {
                showToast("Thank you for subscribing to Amber's Roots!");
                input.value = '';
            }
        });
    }
});
