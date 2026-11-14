@extends('layouts.app')

@section('title', "Contact Us – Amber's Roots Support & Orders")

@section('content')
<!-- Page Header -->
<div style="background: radial-gradient(circle at 50% 0%, rgba(197, 160, 89, 0.15) 0%, rgba(250, 247, 242, 1) 100%); padding: 50px 24px 40px; border-bottom: 1px solid var(--rm-border); text-align: center;">
    <div style="max-width: 1320px; margin: 0 auto;">
        <div style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; color: var(--rm-gold-dark); letter-spacing: 0.1em; margin-bottom: 8px;">
            <a href="{{ url('/') }}" style="color: #64748b;">Home</a> &nbsp;/&nbsp; <span style="color: var(--rm-gold-dark);">Contact</span>
        </div>
        <h1 style="font-family: var(--rm-font-display); font-size: 2.6rem; font-weight: 700; color: var(--rm-dark);">
            We Are Here To Assist You
        </h1>
        <p style="color: #64748b; font-size: 1rem; max-width: 600px; margin: 10px auto 0;">
            Have a question about your order, tracking, or which herbal hair oil is right for your scalp? Reach out to our dedicated care team.
        </p>
    </div>
</div>

<!-- Main Contact Section -->
<section style="padding: clamp(30px, 5vw, 70px) clamp(12px, 3vw, 24px); max-width: 1200px; margin: 0 auto;">
    <div class="rm-contact-grid">
        <!-- Contact Details Card -->
        <div style="background: #ffffff; border-radius: 20px; border: 1px solid var(--rm-border); padding: clamp(16px, 4vw, 36px); box-shadow: var(--rm-shadow-md);">
            <div class="rm-hero-badge" style="margin-bottom: 16px;">
                <i class="fa-solid fa-headset" style="color: var(--rm-gold-dark);"></i>
                <span>Direct Support Channels</span>
            </div>
            <h3 style="font-family: var(--rm-font-display); font-size: 1.6rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 24px;">
                Get in Touch
            </h3>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- WhatsApp -->
                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--rm-dark);">Official WhatsApp Order Line</div>
                        <div style="font-size: 0.8125rem; color: #64748b; margin: 2px 0 6px;">Instant response for parcel tracking and consultations</div>
                        <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}" target="_blank" style="color: #16a34a; font-weight: 700; font-size: 0.9375rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Chat on WhatsApp ({{ $storePhone ?? '+92 327 2222180' }})</span>
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                        </a>
                    </div>
                </div>

                <!-- Phone -->
                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--rm-gold-subtle); color: var(--rm-gold-dark); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--rm-dark);">Phone Helpline</div>
                        <div style="font-size: 0.8125rem; color: #64748b; margin: 2px 0 6px;">Mon - Sat, 10:00 AM - 8:00 PM PKT</div>
                        <a href="tel:{{ $whatsappNumber ?? '923272222180' }}" style="color: var(--rm-gold-dark); font-weight: 700; font-size: 0.9375rem;">
                            {{ $storePhone ?? '+92 327 2222180' }}
                        </a>
                    </div>
                </div>

                <!-- Email -->
                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9; color: #334155; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--rm-dark);">Email Support</div>
                        <div style="font-size: 0.8125rem; color: #64748b; margin: 2px 0 6px;">For complaints, corporate inquiries & wholesale</div>
                        <a href="mailto:{{ $storeEmail ?? 'info@ambersroots.com' }}" style="color: var(--rm-gold-dark); font-weight: 700; font-size: 0.9375rem;">
                            {{ $storeEmail ?? 'info@ambersroots.com' }}
                        </a>
                    </div>
                </div>

                <!-- Location -->
                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--rm-dark);">Dispatch Center / Laboratory</div>
                        <div style="font-size: 0.8125rem; color: #64748b; margin-top: 2px;">
                            {{ $storeAddress ?? 'Big City Plaza Laboratory' }} (Delivery to all cities across Pakistan)
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Card -->
        <div style="background: #ffffff; border-radius: 20px; border: 1px solid var(--rm-border); padding: clamp(16px, 4vw, 36px); box-shadow: var(--rm-shadow-md);">
            <h3 style="font-family: var(--rm-font-display); font-size: 1.6rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 6px;">
                Send Us a Message
            </h3>
            <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 24px;">
                Fill out the form below and our hair care experts will respond within a few hours.
            </p>

            <!-- Flash Alerts -->
            @if(session('success'))
                <div style="background: rgba(34, 197, 94, 0.1); border: 1.5px solid #22c55e; color: #15803d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid #ef4444; color: #b91c1c; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.92rem;">
                    <strong><i class="fa-solid fa-triangle-exclamation"></i> Please correct the following errors:</strong>
                    <ul style="margin: 6px 0 0 18px; padding: 0;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="contactAjaxSuccessBox" style="display: none; background: #f0fdf4; border: 1.5px solid #22c55e; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 0.92rem;">
                <div style="font-weight: 700; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                    <span>Inquiry Submitted Successfully!</span>
                </div>
                <p id="contactAjaxSuccessMsg" style="margin: 6px 0 0; color: #15803d; line-height: 1.45;"></p>
            </div>

            <form id="contactInquiryForm" action="{{ route('contact.submit') }}" method="POST" onsubmit="handleContactSubmit(event)">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="rm-form-label" for="contactName">Your Name *</label>
                        <input type="text" id="contactName" name="name" class="rm-form-input" placeholder="e.g. Fatima Ali" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label class="rm-form-label" for="contactPhone">Phone / WhatsApp *</label>
                        <input type="text" id="contactPhone" name="phone" class="rm-form-input" placeholder="0327-XXXXXXX" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="rm-form-group">
                    <label class="rm-form-label" for="contactEmail">Email Address <span style="color: #94a3b8; font-weight: normal; font-size: 0.78rem;">(Optional)</span></label>
                    <input type="email" id="contactEmail" name="email" class="rm-form-input" placeholder="youremail@example.com" value="{{ old('email') }}">
                </div>

                <div class="rm-form-group">
                    <label class="rm-form-label" for="contactSubject">Subject *</label>
                    <select id="contactSubject" name="subject" class="rm-form-input" required>
                        <option value="Order Status / Tracking Inquiry">Order Status / Tracking Inquiry</option>
                        <option value="Product Usage & Consultation">Product Usage & Consultation</option>
                        <option value="Return / Exchange Request">Return / Exchange Request</option>
                        <option value="Wholesale / Bulk Orders">Wholesale / Bulk Orders</option>
                        <option value="General Feedback">General Feedback</option>
                    </select>
                </div>

                <div class="rm-form-group">
                    <label class="rm-form-label" for="contactMessage">Your Message *</label>
                    <textarea id="contactMessage" name="message" class="rm-form-input" rows="5" placeholder="Write your question, order details, or hair concern here..." required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" id="contactSubmitBtn" class="rm-btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-weight: 700;">
                    <i class="fa-regular fa-paper-plane" id="contactBtnIcon"></i>
                    <span id="contactBtnText">Send Inquiry</span>
                </button>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
function handleContactSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('contactInquiryForm');
    const btn = document.getElementById('contactSubmitBtn');
    const btnIcon = document.getElementById('contactBtnIcon');
    const btnText = document.getElementById('contactBtnText');
    const successBox = document.getElementById('contactAjaxSuccessBox');
    const successMsg = document.getElementById('contactAjaxSuccessMsg');

    btn.disabled = true;
    btn.style.opacity = '0.75';
    btnIcon.className = 'fa-solid fa-spinner fa-spin';
    btnText.textContent = 'Submitting Inquiry...';

    const formData = new FormData(form);

    const token = form.querySelector('input[name="_token"]')?.value || '';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(errData => { throw errData; });
        }
        return res.json();
    })
    .then(data => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btnIcon.className = 'fa-regular fa-paper-plane';
        btnText.textContent = 'Send Inquiry';

        if (successBox && successMsg) {
            successMsg.textContent = data.message || 'Your inquiry has been received. Our team will contact you shortly.';
            successBox.style.display = 'block';
            successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if (window.AmberAlert && typeof window.AmberAlert.success === 'function') {
            window.AmberAlert.success(data.message, 'Inquiry Submitted!');
        }

        form.reset();
    })
    .catch(err => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btnIcon.className = 'fa-regular fa-paper-plane';
        btnText.textContent = 'Send Inquiry';

        let errMsg = 'Failed to submit inquiry. Please try again.';
        if (err && err.errors) {
            const firstErr = Object.values(err.errors)[0];
            errMsg = Array.isArray(firstErr) ? firstErr[0] : firstErr;
        } else if (err && err.message) {
            errMsg = err.message;
        }

        if (window.AmberAlert && typeof window.AmberAlert.error === 'function') {
            window.AmberAlert.error(errMsg, 'Submission Error');
        } else {
            alert(errMsg);
        }
    });
}
</script>
@endpush
@endsection
