@extends('layouts.app')

@section('title', "About Us – Amber's Roots | Pure Herbs, Pure Results")

@section('content')
<!-- Page Header -->
<div style="background: radial-gradient(circle at 50% 0%, rgba(201, 147, 27, 0.15) 0%, rgba(250, 248, 243, 1) 100%); padding: 50px 24px 40px; border-bottom: 1px solid var(--rm-border); text-align: center;">
    <div style="max-width: 1320px; margin: 0 auto;">
        <div style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; color: var(--rm-gold-dark); letter-spacing: 0.1em; margin-bottom: 8px;">
            <a href="{{ url('/') }}" style="color: #64748b;">Home</a> &nbsp;/&nbsp; <span style="color: var(--rm-gold-dark);">About Us</span>
        </div>
        <h1 style="font-family: var(--rm-font-display); font-size: 2.6rem; font-weight: 700; color: var(--rm-dark);">
            The Amber’s Roots Legacy
        </h1>
        <p style="color: #64748b; font-size: 1.05rem; max-width: 650px; margin: 10px auto 0;">
            Rediscovering ancient Eastern hair wellness secrets to give you natural strength, volume, and radiant confidence.
        </p>
    </div>
</div>

<!-- Main About Content -->
<section style="padding: clamp(30px, 5vw, 70px) clamp(12px, 3vw, 24px); max-width: 1200px; margin: 0 auto;">
    <div class="rm-about-grid">
        <div>
            <div class="rm-hero-badge" style="margin-bottom: 16px;">
                <i class="fa-solid fa-seedling" style="color: var(--rm-gold-dark);"></i>
                <span>Our Philosophy</span>
            </div>
            <h2 style="font-family: var(--rm-font-display); font-size: 2.1rem; font-weight: 700; color: var(--rm-dark); line-height: 1.25; margin-bottom: 20px;">
                "Pure Herbs, Pure Results." <br>
                <span style="color: var(--rm-gold-dark);">Crafted Without Compromise.</span>
            </h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 16px;">
                At <strong>Ambers Roots</strong>, we believe genuine beauty doesn't require harsh chemicals or artificial additives. For generations, traditional Eastern households depended on authentic Ayurvedic oils infused with wild-harvested herbs like Amla, Bhringraj, Shikakai, Rosemary, and Kalonji (Black Seed).
            </p>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 24px;">
                We revived these sacred heirloom recipes, extracting them using slow cold-press techniques to preserve every delicate nutrient. The result is our signature formula that strengthens roots, stops hair fall, treats persistent dandruff, and stimulates voluminous new growth.
            </p>

            <div style="display: flex; gap: 20px; flex-wrap: wrap; align-items: center;">
                <div>
                    <div style="font-family: var(--rm-font-display); font-size: 2.2rem; font-weight: 800; color: var(--rm-gold-dark);">50,000+</div>
                    <div style="font-size: 0.8125rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Satisfied Customers</div>
                </div>
                <div class="rm-about-stat-sep" style="width: 1px; height: 50px; background: var(--rm-border);"></div>
                <div>
                    <div style="font-family: var(--rm-font-display); font-size: 2.2rem; font-weight: 800; color: var(--rm-gold-dark);">21</div>
                    <div style="font-size: 0.8125rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Pure Rare Herbs</div>
                </div>
                <div class="rm-about-stat-sep" style="width: 1px; height: 50px; background: var(--rm-border);"></div>
                <div>
                    <div style="font-family: var(--rm-font-display); font-size: 2.2rem; font-weight: 800; color: var(--rm-gold-dark);">100%</div>
                    <div style="font-size: 0.8125rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Natural Ingredients</div>
                </div>
            </div>
        </div>

        <!-- Visual Side Card -->
        <div style="background: #ffffff; border-radius: 20px; border: 1px solid var(--rm-gold-border); padding: clamp(16px, 4vw, 36px); box-shadow: var(--rm-shadow-lg); text-align: center;">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: #ffffff; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; border: 3px solid var(--rm-gold-primary); box-shadow: var(--rm-shadow-gold); padding: 10px;">
                <img src="{{ asset('assets/Logos/logo-emblem-trimmed.png') }}" 
                     alt="Amber's Roots Emblem" 
                     style="width: 100%; height: 100%; object-fit: contain;"
                     onerror="this.onerror=null; this.src='{{ asset('assets/Logos/Logos/Ambers Roots Herbal Hair Oil Emblem.png') }}';" />
            </div>
            <h3 style="font-family: var(--rm-font-display); font-size: 1.5rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 10px;">
                The Amber’s Roots Promise
            </h3>
            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.7; margin-bottom: 24px;">
                "Every drop of Amber’s Roots Herbal Hair Oil is packed with therapeutic botanical goodness. No parabens, no mineral oils, no artificial fragrances – just pure results."
            </p>
            <a href="{{ url('/products') }}" class="rm-btn-primary" style="justify-content: center; width: 100%;">
                <i class="fa-solid fa-bag-shopping"></i> Explore Our Products
            </a>
        </div>
    </div>
</section>

<!-- 3 Guiding Pillars -->
<section style="background: #ffffff; padding: 70px 24px; border-top: 1px solid var(--rm-border); border-bottom: 1px solid var(--rm-border);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--rm-gold-dark); letter-spacing: 0.1em;">Guaranteed Standards</span>
            <h2 style="font-family: var(--rm-font-display); font-size: 2rem; font-weight: 700; color: var(--rm-dark); margin-top: 6px;">
                Why Thousands Choose Amber's Roots
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div style="padding: 30px; border-radius: 14px; background: #faf8f5; border: 1px solid var(--rm-border);">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--rm-gold-subtle); display: flex; align-items: center; justify-content: center; color: var(--rm-gold-dark); font-size: 1.4rem; margin-bottom: 18px;">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 10px;">100% Ayurvedic Ingredients</h4>
                <p style="color: #64748b; font-size: 0.875rem; line-height: 1.7;">
                    Sourced from organic botanical farms across the subcontinent, guaranteeing peak potency and nutrient density in every batch.
                </p>
            </div>

            <div style="padding: 30px; border-radius: 14px; background: #faf8f5; border: 1px solid var(--rm-border);">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--rm-gold-subtle); display: flex; align-items: center; justify-content: center; color: var(--rm-gold-dark); font-size: 1.4rem; margin-bottom: 18px;">
                    <i class="fa-solid fa-vial-circle-check"></i>
                </div>
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 10px;">Clinically Observed Results</h4>
                <p style="color: #64748b; font-size: 0.875rem; line-height: 1.7;">
                    Our formula has shown remarkable reduction in daily hair fall and noticeable thickening within 3 to 4 weeks of consistent application.
                </p>
            </div>

            <div style="padding: 30px; border-radius: 14px; background: #faf8f5; border: 1px solid var(--rm-border);">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--rm-gold-subtle); display: flex; align-items: center; justify-content: center; color: var(--rm-gold-dark); font-size: 1.4rem; margin-bottom: 18px;">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--rm-dark); margin-bottom: 10px;">Customer First Service</h4>
                <p style="color: #64748b; font-size: 0.875rem; line-height: 1.7;">
                    Direct WhatsApp consultations, transparent shipment updates, free doorstep cash-on-delivery, and dedicated after-sale guidance.
                </p>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
@media (max-width: 480px) {
    .rm-about-stat-sep {
        display: none !important;
    }
}
</style>
@endpush
@endsection
