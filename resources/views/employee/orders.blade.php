@extends('layouts.dashboard')

@section('title', 'Order Fulfillment Queue')
@section('header_title', 'Order Fulfillment & Dispatch')
@section('header_subtitle', 'Pack, assign courier tracking numbers, and complete shipments')

@section('content')

<!-- Filter Tabs -->
<div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
    <a href="{{ route('employee.orders') }}" class="btn-db {{ !$status ? 'btn-db-gold' : 'btn-db-outline' }}">
        All Available Orders
    </a>
    <a href="{{ route('employee.orders', ['status' => 'Pending']) }}" class="btn-db {{ $status === 'Pending' ? 'btn-db-gold' : 'btn-db-outline' }}">
        <i class="fa-solid fa-clock"></i> Pending Packaging
    </a>
    <a href="{{ route('employee.orders', ['status' => 'Processing']) }}" class="btn-db {{ $status === 'Processing' ? 'btn-db-gold' : 'btn-db-outline' }}">
        <i class="fa-solid fa-box"></i> In Packaging
    </a>
    <a href="{{ route('employee.orders', ['status' => 'Dispatched']) }}" class="btn-db {{ $status === 'Dispatched' ? 'btn-db-gold' : 'btn-db-outline' }}">
        <i class="fa-solid fa-truck-fast"></i> Dispatched
    </a>
    <a href="{{ route('employee.orders', ['status' => 'Delivered']) }}" class="btn-db {{ $status === 'Delivered' ? 'btn-db-gold' : 'btn-db-outline' }}">
        <i class="fa-solid fa-circle-check"></i> Delivered
    </a>
</div>

<!-- Fulfillment Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-dolly"></i> Orders in Queue
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            {{ $orders->total() }} Orders found
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer & Address</th>
                    <th>Ordered Products</th>
                    <th>Total & COD</th>
                    <th>Fulfillment Status</th>
                    <th>Courier Tracking</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong style="color: var(--db-gold); font-size: 0.95rem;">#{{ $order->order_number }}</strong>
                            <div style="font-size: 0.72rem; color: var(--db-text-dim);">{{ $order->created_at->format('d M, h:i A') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $order->customer_name }}</div>
                            <div style="font-size: 0.78rem; color: #94a3b8;"><i class="fa-solid fa-phone" style="color: var(--db-gold-dark);"></i> {{ $order->customer_phone }}</div>
                            <div style="font-size: 0.75rem; color: #cbd5e1; margin-top: 3px;">
                                <i class="fa-solid fa-location-dot" style="color: #60a5fa;"></i> {{ $order->shipping_address }}, {{ $order->city }}
                            </div>
                        </td>
                        <td>
                            @if(is_array($order->items))
                                @foreach($order->items as $item)
                                    <div style="font-size: 0.82rem; color: #e2e8f0;">
                                        &bull; {{ $item['title'] ?? 'Item' }} <strong style="color: var(--db-gold);">x{{ $item['qty'] ?? 1 }}</strong>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 800; font-family: 'Cinzel', serif; font-size: 1rem; color: #fff;">
                                Rs. {{ number_format($order->total) }}
                            </div>
                            <span style="font-size: 0.7rem; color: var(--db-gold); font-weight: 700;">{{ $order->payment_method }}</span>
                        </td>
                        <td>
                            @if($order->status === 'Pending')
                                <span class="status-badge badge-pending">Pending</span>
                            @elseif($order->status === 'Processing')
                                <span class="status-badge badge-processing">Processing</span>
                            @elseif($order->status === 'Dispatched')
                                <span class="status-badge badge-dispatched">Dispatched</span>
                            @elseif($order->status === 'Delivered')
                                <span class="status-badge badge-delivered">Delivered</span>
                            @else
                                <span class="status-badge badge-kicked">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($order->courier_service)
                                <div style="font-size: 0.82rem; font-weight: 600; color: #fff;">{{ $order->courier_service }}</div>
                                <div style="font-size: 0.72rem; color: var(--db-gold); font-family: monospace;">{{ $order->tracking_number ?? 'Pending code' }}</div>
                            @else
                                <span style="font-size: 0.75rem; color: #64748b;">Not assigned</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <button type="button" class="btn-db btn-db-gold" onclick="openFulfillModal('{{ $order->id }}', '{{ $order->order_number }}', '{{ $order->status }}', '{{ $order->courier_service }}', '{{ $order->tracking_number }}', '{{ addslashes($order->notes ?? '') }}')">
                                <i class="fa-solid fa-pen-to-square"></i> Fulfill
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No orders found in this fulfillment queue.
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

<!-- Modal: Employee Fulfill Order -->
<div class="db-modal-backdrop" id="fulfillOrderModal">
    <div class="db-modal-dialog">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.2rem; font-family: 'Cinzel', serif;">
                Process Order <span id="fulfillOrderNum"></span>
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeFulfillModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="fulfillOrderForm" method="POST" action="">
            @csrf

            <div class="db-form-group">
                <label class="db-form-label" for="f_status">Fulfillment Status *</label>
                <select name="status" id="f_status" class="db-form-select" required>
                    <option value="Pending">Pending (Not Packed)</option>
                    <option value="Processing">Processing (Packaging in Warehouse)</option>
                    <option value="Dispatched">Dispatched (Handed to Courier)</option>
                    <option value="Delivered">Delivered (Customer Confirmed Received)</option>
                </select>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="f_courier">Courier Partner</label>
                    <select name="courier_service" id="f_courier" class="db-form-select">
                        <option value="">-- Select Courier --</option>
                        <option value="Trax Express">Trax Express</option>
                        <option value="TCS Express">TCS Express</option>
                        <option value="Leopards Courier">Leopards Courier</option>
                        <option value="PostEx">PostEx</option>
                    </select>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="f_tracking">Tracking Number / Airway Bill</label>
                    <input type="text" name="tracking_number" id="f_tracking" class="db-form-input" placeholder="e.g. TRX-908234">
                </div>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="f_notes">Fulfillment Notes</label>
                <textarea name="notes" id="f_notes" rows="2" class="db-form-textarea" placeholder="Packing remarks, verification timestamp..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeFulfillModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 20px;">
                    <i class="fa-solid fa-check"></i> Update Fulfillment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openFulfillModal(orderId, orderNum, status, courier, tracking, notes) {
        const form = document.getElementById('fulfillOrderForm');
        form.action = `/employee/orders/${orderId}/update`;
        document.getElementById('fulfillOrderNum').innerText = '#' + orderNum;
        document.getElementById('f_status').value = status;
        document.getElementById('f_courier').value = courier || '';
        document.getElementById('f_tracking').value = tracking || '';
        document.getElementById('f_notes').value = notes || '';
        document.getElementById('fulfillOrderModal').classList.add('is-open');
    }

    function closeFulfillModal() {
        document.getElementById('fulfillOrderModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection
