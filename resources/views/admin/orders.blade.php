@extends('layouts.dashboard')

@section('title', 'Manage Orders')
@section('header_title', 'Customer Orders Management')
@section('header_subtitle', 'Dispatch control, status tracking, customer WhatsApp communication & courier logistics')

@section('content')

<!-- Order Sales & Volume Overview Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 1.3rem;">
            <i class="fa-solid fa-boxes-packing"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Total Orders</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">{{ $counts['all'] }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; font-size: 1.3rem;">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Total Sales (PKR)</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #34d399; font-family: 'Cinzel', serif;">Rs. {{ number_format($totalSales) }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(234, 179, 8, 0.15); border: 1px solid rgba(234, 179, 8, 0.3); display: flex; align-items: center; justify-content: center; color: #facc15; font-size: 1.3rem;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Pending Orders</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #facc15; font-family: 'Cinzel', serif;">{{ $counts['pending'] }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); display: flex; align-items: center; justify-content: center; color: #38bdf8; font-size: 1.3rem;">
            <i class="fa-solid fa-truck-fast"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Shipped / Out for Delivery</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #38bdf8; font-family: 'Cinzel', serif;">{{ $counts['shipped'] }}</div>
        </div>
    </div>
</div>

<!-- Order Status Filter Tabs & Search Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 20px;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('admin.orders') }}" class="btn-db {{ !$status ? 'btn-db-gold' : 'btn-db-outline' }}">
            All ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Pending']) }}" class="btn-db {{ $status === 'Pending' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-clock"></i> Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Confirmed']) }}" class="btn-db {{ $status === 'Confirmed' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-check"></i> Confirmed ({{ $counts['confirmed'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Processing']) }}" class="btn-db {{ $status === 'Processing' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-gear"></i> Processing ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Shipped']) }}" class="btn-db {{ in_array($status, ['Shipped', 'Dispatched']) ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-truck-fast"></i> Shipped ({{ $counts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Delivered']) }}" class="btn-db {{ $status === 'Delivered' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-circle-check"></i> Delivered ({{ $counts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders', ['status' => 'Cancelled']) }}" class="btn-db {{ $status === 'Cancelled' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-ban"></i> Cancelled ({{ $counts['cancelled'] }})
        </a>
    </div>

    <!-- Search input -->
    <form action="{{ route('admin.orders') }}" method="GET" style="display: flex; gap: 8px; margin: 0;">
        @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <input type="text" name="q" value="{{ $search }}" placeholder="Search order #, customer, phone, city..." class="db-form-input" style="width: 260px; padding: 7px 12px; font-size: 0.85rem;">
        <button type="submit" class="btn-db btn-db-outline" style="padding: 7px 14px;">
            <i class="fa-solid fa-search"></i>
        </button>
        @if($search)
            <a href="{{ route('admin.orders', $status ? ['status' => $status] : []) }}" class="btn-db btn-db-outline" style="padding: 7px 12px;" title="Clear Search">
                <i class="fa-solid fa-xmark"></i>
            </a>
        @endif
    </form>
</div>

<!-- Orders Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-boxes-packing"></i> Customer Orders List
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Showing {{ $orders->count() }} of {{ $orders->total() }} records
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Order # & Date</th>
                    <th>Customer Details</th>
                    <th>Ordered Formulation</th>
                    <th>Payment & Total</th>
                    <th>Status</th>
                    <th>Courier & Tracking</th>
                    <th>Direct Chat</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $waPhone = '92' . substr($cleanPhone, 1);
                        } else {
                            $waPhone = $cleanPhone;
                        }
                        $waChatMsg = rawurlencode("Assalam-o-Alaikum {$order->customer_name}! This is Amber's Roots Official Store regarding your Order #{$order->order_number} for Rs. " . number_format($order->total) . ". We are preparing your parcel for dispatch.");
                    @endphp
                    <tr>
                        <td>
                            <strong style="color: var(--db-gold); font-size: 0.95rem;">#{{ $order->order_number }}</strong>
                            <div style="font-size: 0.72rem; color: var(--db-text-dim);">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $order->customer_name }}</div>
                            <div style="font-size: 0.78rem; color: #94a3b8;">
                                <i class="fa-solid fa-phone" style="color: var(--db-gold-dark);"></i> {{ $order->customer_phone }}
                            </div>
                            <div style="font-size: 0.72rem; color: var(--db-text-dim); max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $order->shipping_address }}, {{ $order->city }}">
                                <i class="fa-solid fa-location-dot"></i> {{ $order->city }}
                            </div>
                        </td>
                        <td>
                            @if(is_array($order->items))
                                @foreach($order->items as $item)
                                    <div style="font-size: 0.8rem; color: #e2e8f0; margin-bottom: 2px;">
                                        &bull; {{ $item['title'] ?? "Amber's Roots Hair Oil" }} 
                                        <span style="color: var(--db-gold); font-weight: 700;">x{{ $item['qty'] ?? 1 }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div style="font-size: 0.8rem; color: #e2e8f0;">
                                    &bull; Amber's Roots 100% Herbal Hair Oil <span style="color: var(--db-gold); font-weight: 700;">x1</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 800; font-family: 'Cinzel', serif; font-size: 1rem; color: #fff;">
                                Rs. {{ number_format($order->total) }}
                            </div>
                            <span style="font-size: 0.7rem; color: var(--db-gold); font-weight: 700; text-transform: uppercase;">
                                {{ $order->payment_method }}
                            </span>
                        </td>
                        <td>
                            @if($order->status === 'Pending')
                                <span class="status-badge badge-pending">
                                    <i class="fa-solid fa-clock"></i> Pending
                                </span>
                            @elseif($order->status === 'Confirmed')
                                <span class="status-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fa-solid fa-check"></i> Confirmed
                                </span>
                            @elseif($order->status === 'Processing')
                                <span class="status-badge badge-processing">
                                    <i class="fa-solid fa-gear"></i> Processing
                                </span>
                            @elseif(in_array($order->status, ['Shipped', 'Dispatched']))
                                <span class="status-badge badge-dispatched">
                                    <i class="fa-solid fa-truck-fast"></i> Shipped
                                </span>
                            @elseif($order->status === 'Delivered')
                                <span class="status-badge badge-delivered">
                                    <i class="fa-solid fa-circle-check"></i> Delivered
                                </span>
                            @else
                                <span class="status-badge badge-kicked">
                                    <i class="fa-solid fa-ban"></i> {{ $order->status }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($order->courier_service)
                                <div style="font-size: 0.82rem; font-weight: 600; color: #fff;">
                                    <i class="fa-solid fa-truck"></i> {{ $order->courier_service }}
                                </div>
                                <div style="font-size: 0.72rem; color: var(--db-gold); font-family: monospace;">
                                    {{ $order->tracking_number ?? 'No Code' }}
                                </div>
                            @else
                                <span style="font-size: 0.75rem; color: #64748b;">Not assigned</span>
                            @endif
                        </td>
                        <td>
                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waChatMsg }}" target="_blank" class="btn-db btn-db-outline" style="color: #25d366; border-color: rgba(37, 211, 102, 0.4); padding: 4px 10px; font-size: 0.78rem;" title="Chat directly with customer on WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        </td>
                        <td style="text-align: right;">
                            <button type="button" class="btn-db btn-db-outline" onclick="openOrderModal('{{ $order->id }}', '{{ $order->order_number }}', '{{ $order->status }}', '{{ $order->courier_service }}', '{{ $order->tracking_number }}', '{{ $order->assigned_employee_id }}', '{{ addslashes($order->notes ?? '') }}')">
                                <i class="fa-solid fa-pen-to-square"></i> Update
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No orders found matching the filter or search query.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<!-- Modal: Update Order Status & Courier Details -->
<div class="db-modal-backdrop" id="updateOrderModal">
    <div class="db-modal-dialog">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.2rem; font-family: 'Cinzel', serif;">
                Update Order <span id="modalOrderNumber"></span>
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeOrderModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="updateOrderForm" method="POST" action="">
            @csrf

            <div class="db-form-group">
                <label class="db-form-label" for="order_status">Order Status *</label>
                <select name="status" id="order_status" class="db-form-select" required>
                    <option value="Pending">Pending (Awaiting Confirmation)</option>
                    <option value="Confirmed">Confirmed (Verified with Customer)</option>
                    <option value="Processing">Processing (Packaging Order)</option>
                    <option value="Shipped">Shipped (Handed to Courier)</option>
                    <option value="Delivered">Delivered (Cash Collected)</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="courier_service">Courier Service</label>
                    <select name="courier_service" id="courier_service" class="db-form-select">
                        <option value="">-- None / Select Courier --</option>
                        <option value="Trax Express">Trax Express</option>
                        <option value="TCS Express">TCS Express</option>
                        <option value="Leopards Courier">Leopards Courier</option>
                        <option value="PostEx">PostEx</option>
                        <option value="Call Courier">Call Courier</option>
                        <option value="M&P Express">M&P Express</option>
                    </select>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="tracking_number">Tracking Code</label>
                    <input type="text" name="tracking_number" id="tracking_number" class="db-form-input" placeholder="e.g. TRX-998241">
                </div>
            </div>

            @if(Auth::user() && Auth::user()->role === 'admin')
            <div class="db-form-group">
                <label class="db-form-label" for="assigned_employee_id">Assign to Staff Member</label>
                <select name="assigned_employee_id" id="assigned_employee_id" class="db-form-select">
                    <option value="">-- Leave Unassigned --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">Staff #{{ $emp->id }} ({{ $emp->department }})</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="db-form-group">
                <label class="db-form-label" for="order_notes">Staff Notes</label>
                <textarea name="notes" id="order_notes" rows="2" class="db-form-textarea" placeholder="Special delivery instructions or verification remarks..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeOrderModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 20px;">
                    <i class="fa-solid fa-save"></i> Save Order Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openOrderModal(orderId, orderNum, status, courier, tracking, assignedId, notes) {
        const form = document.getElementById('updateOrderForm');
        form.action = `/admin/orders/${orderId}/update`;
        document.getElementById('modalOrderNumber').innerText = '#' + orderNum;
        document.getElementById('order_status').value = (status === 'Dispatched') ? 'Shipped' : status;
        document.getElementById('courier_service').value = courier || '';
        document.getElementById('tracking_number').value = tracking || '';
        document.getElementById('assigned_employee_id').value = assignedId || '';
        document.getElementById('order_notes').value = notes || '';
        document.getElementById('updateOrderModal').classList.add('is-open');
    }

    function closeOrderModal() {
        document.getElementById('updateOrderModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection
