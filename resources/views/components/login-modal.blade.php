<!-- Login & Register Modal -->
<div class="rm-modal-backdrop" id="rmLoginModal" aria-hidden="true">
    <div class="rm-auth-modal-box">
        <!-- Close Button -->
        <button type="button" class="rm-modal-close-btn" data-close-login aria-label="Close modal" style="position: absolute; top: 16px; right: 16px; z-index: 10;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="rm-auth-header">
            <div style="text-align: center; margin-bottom: 12px;">
                <img src="{{ asset('assets/Logos/logo-emblem-trimmed.png') }}" 
                     alt="Amber's Roots Emblem" 
                     style="width: 54px; height: 54px; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(201, 147, 27, 0.35));"
                     onerror="this.onerror=null; this.src='{{ asset('assets/Logos/Logos/Ambers Roots Herbal Hair Oil Emblem.png') }}';" />
            </div>
            <h3 class="rm-auth-title">Welcome Back</h3>
            <p class="rm-auth-subtitle">Sign in to your Amber's Roots account</p>
        </div>

        <div class="rm-auth-body">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="rm-form-group">
                    <label class="rm-form-label" for="loginEmail">Email Address</label>
                    <input type="email" id="loginEmail" name="email" class="rm-form-input" placeholder="admin@rivaaj.com or staff@rivaaj.com" required>
                </div>

                <div class="rm-form-group">
                    <label class="rm-form-label" for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="password" class="rm-form-input" placeholder="Enter password" required>
                </div>

                <div class="rm-auth-options">
                    <label class="rm-remember-label">
                        <input type="checkbox" name="remember" checked style="accent-color: var(--rm-gold-primary);">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('login') }}" class="rm-forgot-link">Open Full Portal</a>
                </div>

                <button type="submit" class="rm-btn-submit-auth">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</div>
