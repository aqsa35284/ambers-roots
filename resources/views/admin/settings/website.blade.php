@extends('layouts.dashboard')

@section('title', 'Website Settings')
@section('header_title', 'Website General Settings & Branding')
@section('header_subtitle', 'Configure store brand title, header announcement messages, contact email, and shipping policy')

@section('content')

<div style="max-width: 840px;">
    
    <div class="db-panel">
        <div class="db-panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-sliders"></i> Store Configuration & Information
            </div>
        </div>

        <form action="{{ route('admin.settings.website.update') }}" method="POST" style="padding: 20px 24px;">
            @csrf

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="store_name">Store Brand Name *</label>
                    <input type="text" name="store_name" id="store_name" value="{{ $storeName }}" class="db-form-input" required>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="store_tagline">Store Tagline</label>
                    <input type="text" name="store_tagline" id="store_tagline" value="{{ $storeTagline }}" class="db-form-input">
                </div>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="announcement_text">Header Announcement Message *</label>
                <input type="text" name="announcement_text" id="announcement_text" value="{{ $announcementText }}" class="db-form-input" required>
                <div style="font-size: 0.75rem; color: var(--db-text-dim); margin-top: 4px;">
                    Displayed in the golden top ribbon above the navbar on every storefront page.
                </div>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="store_phone">Customer Support Phone</label>
                    <input type="text" name="store_phone" id="store_phone" value="{{ $storePhone }}" class="db-form-input">
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="store_email">Support Email Address</label>
                    <input type="email" name="store_email" id="store_email" value="{{ $storeEmail }}" class="db-form-input">
                </div>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="store_address">Dispatch Center / Store Laboratory Address</label>
                <input type="text" name="store_address" id="store_address" value="{{ $storeAddress }}" class="db-form-input" placeholder="e.g. Big City Plaza Laboratory">
                <div style="font-size: 0.75rem; color: var(--db-text-dim); margin-top: 4px;">
                    Displayed in the footer contact block and Contact Us page across the store.
                </div>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="free_shipping_min">Free Shipping Threshold (PKR)</label>
                <input type="number" name="free_shipping_min" id="free_shipping_min" value="{{ $freeShippingMin }}" class="db-form-input" placeholder="0 = Free delivery on all orders">
                <div style="font-size: 0.75rem; color: var(--db-text-dim); margin-top: 4px;">
                    Set to 0 for Free Delivery on all COD orders across Pakistan.
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
                <button type="submit" class="btn-db btn-db-gold" style="padding: 12px 28px; font-size: 0.95rem;">
                    <i class="fa-solid fa-save"></i> Save Website Settings
                </button>
            </div>
        </form>
    </div>

</div>

@endsection

