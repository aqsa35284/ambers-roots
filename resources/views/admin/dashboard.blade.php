@extends('layouts.dashboard')

@section('title', 'Operations Overview')
@section('header_title', 'Store Operations Overview')
@section('header_subtitle', 'Live store performance, revenue statistics, inventory and order fulfillment')

@section('content')

@php
    $isAdmin = Auth::user() && Auth::user()->role === 'admin';
@endphp

<!-- Metrics Row -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-info">
            <h5>Total Gross Revenue</h5>
            <div class="metric-value">Rs. {{ number_format($totalRevenue) }}</div>
            <div class="metric-sub" style="color: #34d399;"><i class="fa-solid fa-arrow-trend-up"></i> Realized from active orders</div>
        </div>
        <div class="metric-icon-box icon-gold">
            <i class="fa-solid fa-coins"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Customer Orders</h5>
            <div class="metric-value">{{ $totalOrders }}</div>
            <div class="metric-sub">
                <span style="color: #fbbf24;">{{ $pendingOrders }} Pending</span> &bull; 
                <span style="color: #34d399;">{{ $confirmedOrders ?? 0 }} Confirmed</span>
            </div>
        </div>
        <div class="metric-icon-box icon-blue">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Store Products</h5>
            <div class="metric-value">{{ $activeProducts ?? 1 }} Active Live</div>
            <div class="metric-sub">
                <span style="color: #34d399;">{{ $activeProducts ?? 1 }} ON</span> &bull; 
                <span style="color: #94a3b8;">{{ ($totalProducts ?? 6) - ($activeProducts ?? 1) }} OFF</span>
                @if(($lowStockCount ?? 0) > 0)
                    &bull; <span style="color: #f87171;">{{ $lowStockCount }} Low Stock</span>
                @endif
            </div>
        </div>
        <div class="metric-icon-box icon-amber">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Customer Reviews</h5>
            <div class="metric-value">{{ $averageRating ?? 4.9 }} ★</div>
            <div class="metric-sub">
                <span style="color: #34d399;">{{ ($totalReviews ?? 3) - ($pendingReviewsCount ?? 0) }} Approved</span> &bull; 
                <span style="color: #fbbf24;">{{ $pendingReviewsCount ?? 0 }} Pending</span>
            </div>
        </div>
        <div class="metric-icon-box icon-green">
            <i class="fa-solid fa-star"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Customer Inquiries</h5>
            <div class="metric-value">{{ $openTicketsCount ?? 0 }} Pending</div>
            <div class="metric-sub">
                <span style="color: #34d399;">{{ ($totalTickets ?? 0) - ($openTicketsCount ?? 0) }} Resolved</span> &bull; 
                <span style="color: #fbbf24;">{{ $openTicketsCount ?? 0 }} Open</span>
            </div>
        </div>
        <div class="metric-icon-box" style="background: rgba(192, 132, 252, 0.15); color: #c084fc;">
            <i class="fa-solid fa-headset"></i>
        </div>
    </div>
</div>

<!-- Quick Actions Banner -->
<div class="db-panel" style="background: linear-gradient(135deg, #151822, #0d0f15); border-left: 4px solid var(--db-gold);">
    <div class="db-panel-header">
        <div>
            <div class="panel-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Executive Management Commands</div>
            <p style="font-size: 0.8rem; color: var(--db-text-muted); margin-top: 4px;">Direct shortcuts for inventory control, discount sales, customer reviews and orders</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.inventory') }}" class="btn-db btn-db-gold">
                <i class="fa-solid fa-boxes-stacked"></i> Manage Products & Discounts
            </a>
            <a href="{{ route('admin.orders') }}" class="btn-db btn-db-outline">
                <i class="fa-solid fa-boxes-packing"></i> Order Management
            </a>
            <a href="{{ route('admin.tickets') }}" class="btn-db btn-db-outline">
                <i class="fa-solid fa-headset"></i> Customer Inquiries ({{ $openTicketsCount ?? 0 }})
            </a>
            <a href="{{ route('admin.reviews') }}" class="btn-db btn-db-outline">
                <i class="fa-solid fa-star-half-stroke"></i> Reviews Moderation
            </a>
            @if($isAdmin)
            <a href="{{ route('admin.employees') }}" class="btn-db btn-db-outline">
                <i class="fa-solid fa-users-gear"></i> Staff
            </a>
            @endif
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Orders Panel -->
    <div class="db-panel">
        <div class="db-panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-bag-shopping"></i> Latest Customer Orders
            </div>
            <a href="{{ route('admin.orders') }}" class="btn-db btn-db-outline" style="font-size: 0.75rem;">
                View All Orders <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="db-table-responsive">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>City</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Fulfillment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                <strong style="color: var(--db-gold);">#{{ $order->order_number }}</strong>
                                <div style="font-size: 0.7rem; color: var(--db-text-dim);">{{ $order->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div><strong>{{ $order->customer_name }}</strong></div>
                                <div style="font-size: 0.75rem; color: var(--db-text-muted);">{{ $order->customer_phone }}</div>
                            </td>
                            <td>{{ $order->city }}</td>
                            <td>
                                <strong>Rs. {{ number_format($order->total) }}</strong>
                                <span style="font-size: 0.7rem; color: var(--db-text-dim); display: block;">{{ $order->payment_method }}</span>
                            </td>
                            <td>
                                @if($order->status === 'Pending')
                                    <span class="status-badge badge-pending">Pending</span>
                                @elseif($order->status === 'Confirmed')
                                    <span class="status-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);">Confirmed</span>
                                @elseif($order->status === 'Processing')
                                    <span class="status-badge badge-processing">Processing</span>
                                @elseif(in_array($order->status, ['Shipped', 'Dispatched']))
                                    <span class="status-badge badge-dispatched">Shipped</span>
                                @elseif($order->status === 'Delivered')
                                    <span class="status-badge badge-delivered">Delivered</span>
                                @else
                                    <span class="status-badge badge-kicked">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'Delivered')
                                    <span style="font-size: 0.78rem; color: #34d399;">
                                        <i class="fa-solid fa-circle-check"></i> Delivered
                                    </span>
                                @elseif($order->assignedEmployee)
                                    <span style="font-size: 0.78rem; color: #60a5fa;">
                                        <i class="fa-solid fa-user-check"></i> In Progress
                                    </span>
                                @else
                                    <span style="font-size: 0.75rem; color: #94a3b8;">
                                        <i class="fa-solid fa-clock"></i> Queued
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--db-text-dim); padding: 32px;">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($isAdmin)
        <!-- Super Admin Only: Staff Quick Access Panel -->
        <div class="db-panel">
            <div class="db-panel-header">
                <div class="panel-title">
                    <i class="fa-solid fa-users"></i> Staff Quick Access
                </div>
            </div>
            <div style="padding: 16px;">
                <p style="font-size: 0.78rem; color: var(--db-text-muted); margin-bottom: 16px;">
                    Enter any employee's workspace in shadow mode without alerting them.
                </p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($employees as $emp)
                        <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 8px; padding: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(201,147,27,0.2); border: 1px solid var(--db-gold); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 0.8rem;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.82rem; font-weight: 700; color: #fff;">{{ $emp->department }}</div>
                                    <div style="font-size: 0.7rem; color: var(--db-text-dim);">{{ $emp->designation }}</div>
                                </div>
                            </div>

                            <div>
                                @if($emp->status === 'active')
                                    <form action="{{ route('admin.impersonate.enter', $emp->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-db btn-db-impersonate" style="padding: 4px 10px; font-size: 0.72rem;" title="Enter shadow mode">
                                            <i class="fa-solid fa-eye"></i> Shadow
                                        </button>
                                    </form>
                                @else
                                    <span class="status-badge badge-kicked" style="font-size: 0.65rem;">Kicked</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 18px; text-align: center;">
                    <a href="{{ route('admin.employees') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: center; font-size: 0.78rem;">
                        Full Employee Management <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Basic Employer Dashboard: Store Quick Operations Panel (No Staff Management, No Names) -->
        <div class="db-panel">
            <div class="db-panel-header">
                <div class="panel-title">
                    <i class="fa-solid fa-bolt"></i> Store Quick Actions
                </div>
            </div>
            <div style="padding: 16px;">
                <p style="font-size: 0.78rem; color: var(--db-text-muted); margin-bottom: 16px;">
                    Fast operational shortcuts to manage the store in real-time.
                </p>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ route('admin.inventory') }}" class="btn-db btn-db-gold" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-solid fa-boxes-stacked"></i> Products Management
                    </a>
                    <a href="{{ route('admin.discounts') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-solid fa-percent"></i> Discounts & Coupons
                    </a>
                    <a href="{{ route('admin.orders') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-solid fa-truck-fast"></i> Order Processing & Dispatch
                    </a>
                    <a href="{{ route('admin.customers') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-solid fa-users"></i> Customers Directory
                    </a>
                    <a href="{{ route('admin.reviews') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-solid fa-star"></i> Customer Reviews
                    </a>
                    <a href="{{ route('admin.settings.whatsapp') }}" class="btn-db btn-db-outline" style="width: 100%; justify-content: flex-start; padding: 10px 14px;">
                        <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i> WhatsApp Settings
                    </a>
                </div>

                <div style="margin-top: 20px; padding: 14px; background: rgba(0,0,0,0.2); border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="font-size: 0.78rem; color: #94a3b8; display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Store Operational Status:</span>
                        <span style="color: #34d399; font-weight: 700;"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> Active Live</span>
                    </div>
                    <div style="font-size: 0.78rem; color: #94a3b8; display: flex; justify-content: space-between;">
                        <span>Delivery Network:</span>
                        <span style="color: var(--db-gold); font-weight: 700;">Cash on Delivery (Pakistan)</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Recent Customer Inquiries & Contact Submissions Panel -->
<div class="db-panel" style="margin-top: 24px;">
    <div class="db-panel-header">
        <div>
            <div class="panel-title">
                <i class="fa-solid fa-headset"></i> Latest Customer Inquiries (Contact Submissions)
            </div>
            <p style="font-size: 0.8rem; color: var(--db-text-muted); margin-top: 4px;">
                Direct inquiries and customer consultation requests submitted via Contact Page
            </p>
        </div>
        <a href="{{ route('admin.tickets') }}" class="btn-db btn-db-outline" style="font-size: 0.75rem;">
            View All Inquiries <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Customer Name & Contact</th>
                    <th>Subject</th>
                    <th>Message Excerpt</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTickets ?? [] as $t)
                    <tr>
                        <td>
                            <strong style="color: var(--db-gold); font-family: monospace;">{{ $t->ticket_id }}</strong>
                            <div style="font-size: 0.7rem; color: var(--db-text-dim);">{{ $t->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $t->customer_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--db-text-muted);">
                                <i class="fa-solid fa-phone" style="color: var(--db-gold-dark);"></i> {{ $t->customer_phone }}
                            </div>
                            @if($t->customer_email)
                                <div style="font-size: 0.72rem; color: #94a3b8;">
                                    <i class="fa-regular fa-envelope"></i> {{ $t->customer_email }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.84rem; font-weight: 600; color: #fff;">{{ $t->subject }}</div>
                            <div style="font-size: 0.72rem; color: var(--db-gold);">{{ $t->product_related ?? 'General Care' }}</div>
                        </td>
                        <td style="max-width: 280px;">
                            <div style="font-size: 0.82rem; color: #cbd5e1; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                "{{ $t->message }}"
                            </div>
                        </td>
                        <td>
                            @if($t->status === 'open')
                                <span class="status-badge badge-pending">Open</span>
                            @elseif($t->status === 'in_progress')
                                <span class="status-badge badge-processing">In Progress</span>
                            @else
                                <span class="status-badge badge-active">Resolved</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $t->customer_phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '92' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <div style="display: inline-flex; gap: 6px;">
                                @if(!empty($cleanPhone))
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hello ' . $t->customer_name . '! Thank you for contacting Amber\'s Roots (Ticket #' . $t->ticket_id . '). How can we assist you today?') }}" target="_blank" class="btn-db" style="background: rgba(37, 211, 102, 0.15); color: #25d366; border: 1px solid rgba(37, 211, 102, 0.3); padding: 4px 8px; font-size: 0.75rem;" title="Chat on WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.tickets') }}" class="btn-db btn-db-outline" style="padding: 4px 10px; font-size: 0.75rem;">
                                    Manage
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--db-text-dim); padding: 32px;">
                            <i class="fa-solid fa-inbox" style="font-size: 1.5rem; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                            No customer inquiries received yet. Inquiries submitted via Contact Page will appear here automatically.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
