<footer class="rm-footer">
    <div class="rm-footer-container">
        <div class="rm-footer-grid">
            <!-- Brand Bio Column -->
            <div class="rm-footer-brand">
                <a href="{{ url('/') }}" class="rm-logo-link rm-footer-logo-link" aria-label="Amber's Roots Herbal Hair Oil">
                    <img src="{{ asset('assets/Logos/logo-vertical-trimmed.png') }}" 
                         alt="Amber's Roots Herbal Hair Oil" 
                         class="rm-footer-vertical-logo"
                         onerror="this.onerror=null; this.src='{{ asset('assets/Logos/logo-trimmed.png') }}';" />
                </a>

                <p class="rm-footer-bio">
                    "Your Hair, Your Confidence." Mazboot, chamakdaar aur sehatmand baal – sirf Amber’s Roots 100% Organic Herbal Hair Oil ke saath. Pure natural formulations designed for authentic hair growth, deep root nourishment, and scalp vitality.
                </p>

                <!-- Social Icons -->
                <div class="rm-footer-socials">
                    <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}" target="_blank" class="rm-social-btn" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="rm-social-btn" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank" class="rm-social-btn" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://tiktok.com" target="_blank" class="rm-social-btn" title="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="rm-social-btn" title="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div>
                <h4 class="rm-footer-col-title">Quick Links</h4>
                <div class="rm-footer-links">
                    <a href="{{ url('/') }}" class="rm-footer-link">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ url('/products') }}" class="rm-footer-link">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Product</span>
                    </a>
                    <a href="{{ url('/about') }}" class="rm-footer-link">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>About Us</span>
                    </a>
                    <a href="{{ url('/contact') }}" class="rm-footer-link">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>

            <!-- Customer Care & Policies -->
            <div>
                <h4 class="rm-footer-col-title">Customer Care</h4>
                <div class="rm-footer-links">
                    <a href="#" class="rm-footer-link" onclick="event.preventDefault(); showToast('Shipping policy: Free delivery across Pakistan in 2-4 working days.');">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Shipping Policy</span>
                    </a>
                    <a href="#" class="rm-footer-link" onclick="event.preventDefault(); showToast('Return policy: 7-day hassle-free return policy.');">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Return & Refund</span>
                    </a>
                    <a href="#" class="rm-footer-link" onclick="event.preventDefault(); showToast('Privacy Policy is strictly maintained.');">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Privacy Policy</span>
                    </a>
                    <a href="#" class="rm-footer-link" onclick="event.preventDefault(); showToast('Terms and conditions apply on all orders.');">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Terms of Service</span>
                    </a>
                    <a href="{{ url('/contact') }}" class="rm-footer-link">
                        <i class="fa-solid fa-angle-right"></i>
                        <span>Help & Support</span>
                    </a>
                </div>
            </div>

            <!-- Contact & Newsletter -->
            <div>
                <h4 class="rm-footer-col-title">Get in Touch</h4>
                <div class="rm-footer-contact-list">
                    <div class="rm-contact-item">
                        <div class="rm-contact-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <strong>Location:</strong> {{ $storeAddress ?? 'Big City Plaza Laboratory' }}
                        </div>
                    </div>
                    <div class="rm-contact-item">
                        <div class="rm-contact-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <strong>Helpline:</strong> <a href="tel:{{ $whatsappNumber ?? '923272222180' }}" style="color: #e2e8f0;">{{ $storePhone ?? '+92 327 2222180' }}</a>
                        </div>
                    </div>
                    <div class="rm-contact-item">
                        <div class="rm-contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <strong>Email:</strong> <a href="mailto:{{ $storeEmail ?? 'info@ambersroots.com' }}" style="color: #e2e8f0;">{{ $storeEmail ?? 'info@ambersroots.com' }}</a>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <p class="rm-newsletter-desc">
                    Subscribe to get special discounts, hair care advice & new launch updates!
                </p>
                <form class="rm-newsletter-form">
                    <input type="email" class="rm-newsletter-input" placeholder="Your email address..." required>
                    <button type="submit" class="rm-newsletter-btn" aria-label="Subscribe to newsletter">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="rm-footer-bottom" style="justify-content: center; text-align: center;">
            <div>
                &copy; {{ date('Y') }} <strong>{{ $storeName ?? "Amber's Roots" }}</strong>. All rights reserved. Pure Herbs, Pure Results.
            </div>
        </div>
    </div>
</footer>
