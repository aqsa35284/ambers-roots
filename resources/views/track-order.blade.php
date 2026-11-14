@extends('layouts.app')

@section('title', "Track Your Order – Amber's Roots Official")

@section('content')
<section style="background: linear-gradient(180deg, #faf8f3 0%, #ffffff 100%); padding: 50px 20px 80px; min-height: 70vh;">
    <div style="max-width: 760px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 36px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(201, 147, 27, 0.12); color: var(--rm-gold-dark); padding: 6px 16px; border-radius: 9999px; font-size: 0.8125rem; font-weight: 700; margin-bottom: 12px; border: 1px solid var(--rm-gold-border);">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Fast Doorstep Delivery Tracking</span>
            </div>
            <h1 style="font-family: var(--rm-font-display); font-size: clamp(1.8rem, 4vw, 2.4rem); font-weight: 700; color: var(--rm-dark); margin: 0 0 10px;">
                Track Your Order
            </h1>
            <p style="color: #64748b; font-size: 0.95rem; max-width: 500px; margin: 0 auto;">
                Apna Order Number (e.g. <strong>AR-261104-XXXX</strong>) ya apna Phone Number enter karein taake order ka status check kar sakein.
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="rm-track-search-card" style="background: #ffffff; border: 1px solid var(--rm-gold-border); border-radius: 16px; padding: clamp(14px, 4vw, 28px); box-shadow: var(--rm-shadow-md); margin-bottom: 32px;">
            <form action="{{ route('orders.track') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div style="flex: 1 1 200px; min-width: 0; position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--rm-gold-dark);"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Enter Order # (#AR-...) or Mobile (03XX...)" required style="width: 100%; padding: 12px 14px 12px 40px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-family: inherit; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--rm-gold-primary)'" onblur="this.style.borderColor='#cbd5e1'">
                </div>
                <button type="submit" class="rm-btn-primary" style="padding: 12px 24px; flex-shrink: 0; min-width: 140px; justify-content: center;">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <span>Track Order</span>
                </button>
            </form>
        </div>

        <!-- Tracking Results -->
        @if($search !== '')
            @if($orders->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($orders as $order)
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: var(--rm-shadow-sm);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b;">Order Number</span>
                                    <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--rm-dark); margin: 2px 0 0; font-family: 'Cinzel', serif;">
                                        #{{ $order->order_number }}
                                    </h3>
                                    <span style="font-size: 0.8rem; color: #94a3b8;">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</span>
                                </div>

                                <div>
                                    @if($order->status === 'Pending')
                                        <span style="background: #fef3c7; color: #b45309; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-clock"></i> Pending Confirmation
                                        </span>
                                    @elseif($order->status === 'Confirmed')
                                        <span style="background: #d1fae5; color: #065f46; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-circle-check"></i> Order Confirmed
                                        </span>
                                    @elseif($order->status === 'Processing')
                                        <span style="background: #dbeafe; color: #1e40af; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-gear"></i> Packaging & Processing
                                        </span>
                                    @elseif(in_array($order->status, ['Shipped', 'Dispatched']))
                                        <span style="background: #e0f2fe; color: #0369a1; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-truck-fast"></i> Shipped / On the Way
                                        </span>
                                    @elseif($order->status === 'Delivered')
                                        <span style="background: #dcfce7; color: #15803d; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-box-open"></i> Delivered
                                        </span>
                                    @else
                                        <span style="background: #fee2e2; color: #b91c1c; padding: 6px 14px; border-radius: 9999px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-ban"></i> {{ $order->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Stepper Timeline -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 24px 0 20px; text-align: center;">
                                @php
                                    $isStep1 = true;
                                    $isStep2 = in_array($order->status, ['Confirmed', 'Processing', 'Shipped', 'Dispatched', 'Delivered']);
                                    $isStep3 = in_array($order->status, ['Processing', 'Shipped', 'Dispatched', 'Delivered']);
                                    $isStep4 = in_array($order->status, ['Shipped', 'Dispatched', 'Delivered']);
                                @endphp
                                <div>
                                    <div style="width: 36px; height: 36px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; background: {{ $isStep1 ? '#15803d' : '#e2e8f0' }}; color: #ffffff;">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #1e293b;">Order Received</div>
                                </div>

                                <div>
                                    <div style="width: 36px; height: 36px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; background: {{ $isStep2 ? '#15803d' : '#e2e8f0' }}; color: #ffffff;">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #1e293b;">Confirmed</div>
                                </div>

                                <div>
                                    <div style="width: 36px; height: 36px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; background: {{ $isStep3 ? '#15803d' : '#e2e8f0' }}; color: #ffffff;">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </div>
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #1e293b;">Packaging</div>
                                </div>

                                <div>
                                    <div style="width: 36px; height: 36px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; background: {{ $isStep4 ? '#15803d' : '#e2e8f0' }}; color: #ffffff;">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </div>
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #1e293b;">Shipped</div>
                                </div>
                            </div>

                            <!-- Details list -->
                            <div style="background: #faf8f3; border-radius: 12px; padding: 16px; font-size: 0.88rem; margin-top: 16px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: #64748b;">Deliver To:</span>
                                    <strong style="color: #0f172a;">{{ $order->customer_name }} ({{ $order->city }})</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: #64748b;">Shipping Address:</span>
                                    <span style="color: #334155; text-align: right; max-width: 60%;">{{ $order->shipping_address }}</span>
                                </div>
                                @if($order->courier_service)
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                        <span style="color: #64748b;">Courier Service:</span>
                                        <strong style="color: #0f172a;">{{ $order->courier_service }} (Tracking: {{ $order->tracking_number ?? 'In Progress' }})</strong>
                                    </div>
                                @endif
                                <div style="display: flex; justify-content: space-between; border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 8px;">
                                    <span style="color: #64748b;">Total Amount Payable (COD):</span>
                                    <strong style="color: #15803d; font-size: 1.05rem;">Rs. {{ number_format($order->total) }}</strong>
                                </div>
                            </div>

                            <!-- WhatsApp Inquiry Button -->
                            <div style="margin-top: 16px; text-align: right;">
                                <a href="https://wa.me/923272222180?text={{ rawurlencode("Hello Amber's Roots! I am inquiring about my order #{$order->order_number}.") }}" target="_blank" class="rm-btn-secondary" style="display: inline-flex; padding: 8px 18px; font-size: 0.82rem;">
                                    <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                                    <span>Ask on WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px 20px; text-align: center;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #ef4444; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0 0 6px;">No Order Found</h3>
                    <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0 auto 20px;">
                        Could not find any order matching "<strong>{{ $search }}</strong>". Please double check your order number or phone number.
                    </p>
                    <a href="https://wa.me/923272222180" target="_blank" class="rm-btn-secondary" style="display: inline-flex; padding: 10px 22px;">
                        <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                        <span>Contact Support via WhatsApp</span>
                    </a>
                </div>
            @endif
        @endif

    </div>
</section>
@endsection

