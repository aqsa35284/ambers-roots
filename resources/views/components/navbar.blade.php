<!-- Announcement Strip -->
<div class="rm-announcement-bar">
    <div class="rm-announcement-container">
        <div class="rm-announcement-left">
            <span class="rm-announcement-item">
                <i class="fa-solid fa-phone"></i>
                <a href="tel:{{ $whatsappNumber ?? '923272222180' }}">{{ $storePhone ?? '+92 327 2222180' }}</a>
            </span>
            <span class="rm-announcement-item">
                <i class="fa-brands fa-whatsapp"></i>
                <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}" target="_blank">WhatsApp Support</a>
            </span>
        </div>

        <div class="rm-announcement-center">
            <span>{!! $announcementText ?? 'Trusted by 50,000+ customers across Pakistan &bull; 4.9★ rating' !!}</span>
        </div>

        <div class="rm-announcement-right">
            <span class="rm-announcement-item">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Free Express Shipping (COD)</span>
            </span>
        </div>
    </div>
</div>

<!-- Main Sticky Navbar -->
<header class="rm-header-wrapper">
    <div class="rm-navbar">
        <!-- Mobile Hamburger Button -->
        <button type="button" class="rm-mobile-toggle" id="rmMobileToggle" aria-label="Open Navigation Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="rm-logo-link" aria-label="Amber's Roots Herbal Hair Oil">
            <img src="{{ asset('assets/Logos/logo-trimmed.png') }}" 
                 alt="Amber's Roots Herbal Hair Oil" 
                 class="rm-navbar-logo"
                 onerror="this.onerror=null; this.src='{{ asset('assets/Logos/Logos/Ambers Roots Herbal Hair Oil Logo.png') }}';" />
        </a>

        <!-- Desktop Navigation Menu (Home, Product, About Us, Contact ONLY) -->
        <nav class="rm-nav-menu" aria-label="Main Navigation">
            <div class="rm-nav-item">
                <a href="{{ url('/') }}" class="rm-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    Home
                </a>
            </div>
            <div class="rm-nav-item">
                <a href="{{ url('/products') }}" class="rm-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                    Product
                </a>
            </div>
            <div class="rm-nav-item">
                <a href="{{ url('/about') }}" class="rm-nav-link {{ request()->is('about*') ? 'active' : '' }}">
                    About Us
                </a>
            </div>
            <div class="rm-nav-item">
                <a href="{{ url('/contact') }}" class="rm-nav-link {{ request()->is('contact*') ? 'active' : '' }}">
                    Contact
                </a>
            </div>
        </nav>

        <!-- Right Action Icons: Search, Login, Add to Cart -->
        <div class="rm-nav-actions">
            <!-- Search Button -->
            <button type="button" class="rm-action-btn" data-open-search title="Search Products" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <!-- Login / Account Button (Clean & Normal - No Admin Label) -->
            <button type="button" class="rm-action-btn login-btn-text" data-open-login title="Account / Login" aria-label="Login">
                <i class="fa-regular fa-user"></i>
                <span>Login</span>
            </button>

            <!-- Add to Cart / Cart Drawer Button -->
            <button type="button" class="rm-action-btn" data-open-cart title="Shopping Cart" aria-label="View Cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="rm-cart-badge">2</span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="rm-mobile-drawer" id="rmMobileDrawer">
    <div class="rm-mobile-drawer-content">
        <div class="rm-mobile-header">
            <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
                <img src="{{ asset('assets/Logos/logo-trimmed.png') }}" 
                     alt="Amber's Roots" 
                     class="rm-mobile-logo"
                     onerror="this.onerror=null; this.src='{{ asset('assets/Logos/Logos/Ambers Roots Herbal Hair Oil Logo.png') }}';" />
            </a>
            <button type="button" class="rm-modal-close-btn" id="rmMobileClose" aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="rm-mobile-nav">
            <a href="{{ url('/') }}" class="rm-mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                <span>Home</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            </a>
            <a href="{{ url('/products') }}" class="rm-mobile-nav-link {{ request()->is('products*') ? 'active' : '' }}">
                <span>Product</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            </a>
            <a href="{{ url('/about') }}" class="rm-mobile-nav-link {{ request()->is('about*') ? 'active' : '' }}">
                <span>About Us</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            </a>
            <a href="{{ url('/contact') }}" class="rm-mobile-nav-link {{ request()->is('contact*') ? 'active' : '' }}">
                <span>Contact</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            </a>
            <a href="{{ url('/cart') }}" class="rm-mobile-nav-link {{ request()->is('cart*') ? 'active' : '' }}">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-bag-shopping" style="color: var(--rm-gold-dark);"></i>
                    <span>Shopping Cart</span>
                </span>
                <span class="rm-cart-badge" style="position: static;">2</span>
            </a>
        </nav>

        <div class="rm-mobile-footer">
            <button type="button" class="rm-btn-primary" style="width: 100%; justify-content: center; padding: 12px;" data-open-login>
                <i class="fa-regular fa-user"></i>
                <span>Sign In / Register</span>
            </button>
            <div style="font-size: 0.8125rem; color: #64748b; text-align: center; margin-top: 6px;">
                <i class="fa-solid fa-phone" style="color: var(--rm-gold-dark);"></i> {{ $storePhone ?? '+92 327 2222180' }}
            </div>
        </div>
    </div>
</div>
