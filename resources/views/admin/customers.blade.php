@extends('layouts.dashboard')

@section('title', 'Customers Directory')
@section('header_title', 'Customer Directory & Order History')
@section('header_subtitle', 'View verified customer records, total purchases, lifetime value, and direct WhatsApp contact')

@section('content')

<!-- Metrics Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 1.3rem;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Unique Customers</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">{{ $totalCustomersCount }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; font-size: 1.3rem;">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Repeat Customers</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #34d399; font-family: 'Cinzel', serif;">{{ $repeatCustomersCount }}</div>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 20px;">
    <div style="font-size: 0.95rem; font-weight: 700; color: #fff;">
        <i class="fa-solid fa-address-book" style="color: var(--db-gold);"></i> Verified Buyers List
    </div>

    <form action="{{ route('admin.customers') }}" method="GET" style="display: flex; gap: 8px; margin: 0;">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search customer, phone, city..." class="db-form-input" style="width: 260px; padding: 7px 12px; font-size: 0.85rem;">
        <button type="submit" class="btn-db btn-db-outline" style="padding: 7px 14px;">
            <i class="fa-solid fa-search"></i>
        </button>
        @if($search)
            <a href="{{ route('admin.customers') }}" class="btn-db btn-db-outline" style="padding: 7px 12px;" title="Clear Search">
                <i class="fa-solid fa-xmark"></i>
            </a>
        @endif
    </form>
</div>

<!-- Customers Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-user-group"></i> Customer Profiles & Orders History
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Showing {{ $customers->count() }} of {{ $customers->total() }} records
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>City & Address</th>
                    <th>Total Orders</th>
                    <th>Total Spent (PKR)</th>
                    <th>Last Order Date</th>
                    <th>Customer Type</th>
                    <th style="text-align: right;">Contact</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $c->customer_phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $waPhone = '92' . substr($cleanPhone, 1);
                        } else {
                            $waPhone = $cleanPhone;
                        }
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $c->customer_name }}</div>
                        </td>
                        <td>
                            <span style="color: var(--db-gold); font-family: monospace; font-size: 0.9rem;">
                                {{ $c->customer_phone }}
                            </span>
                        </td>
                        <td>
                            <div style="color: #cbd5e1; font-size: 0.82rem;">{{ $c->city }}</div>
                            <div style="font-size: 0.72rem; color: var(--db-text-dim); max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $c->shipping_address }}">
                                {{ $c->shipping_address }}
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: #fff; font-size: 0.9rem;">
                                {{ $c->total_orders }} {{ $c->total_orders > 1 ? 'Orders' : 'Order' }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #34d399; font-family: 'Cinzel', serif; font-size: 0.95rem;">
                                Rs. {{ number_format($c->total_spent) }}
                            </strong>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; color: var(--db-text-dim);">
                                {{ \Carbon\Carbon::parse($c->last_ordered_at)->format('d M Y, h:i A') }}
                            </span>
                        </td>
                        <td>
                            @if($c->total_orders >= 3 || $c->total_spent >= 8000)
                                <span class="status-badge" style="background: rgba(223, 194, 133, 0.2); color: var(--db-gold); border: 1px solid var(--db-gold);">
                                    <i class="fa-solid fa-crown"></i> VIP Customer
                                </span>
                            @elseif($c->total_orders > 1)
                                <span class="status-badge badge-active">
                                    <i class="fa-solid fa-repeat"></i> Repeat Buyer
                                </span>
                            @else
                                <span class="status-badge badge-pending">
                                    <i class="fa-solid fa-user"></i> First-time Buyer
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="https://wa.me/{{ $waPhone }}?text={{ rawurlencode("Assalam-o-Alaikum {$c->customer_name}! This is Amber's Roots Official Store. Thank you for shopping with us.") }}" target="_blank" class="btn-db btn-db-outline" style="color: #25d366; border-color: rgba(37, 211, 102, 0.4); padding: 5px 12px; font-size: 0.78rem;">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--db-text-dim); padding: 36px;">
                            No customers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $customers->links() }}
        </div>
    @endif
</div>

@endsection

