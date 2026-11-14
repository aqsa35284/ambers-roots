@extends('layouts.dashboard')

@section('title', 'Employee Shift Hub')
@section('header_title', 'Staff Workspace & Shift Hub')
@section('header_subtitle', 'Logged in as ' . $employee->name . ' (' . ($employee->designation ?? 'Operations Specialist') . ')')

@section('content')

<!-- Shift Metrics Grid -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-info">
            <h5>Orders Assigned to Me</h5>
            <div class="metric-value">{{ $assignedOrders->count() }}</div>
            <div class="metric-sub" style="color: #60a5fa;"><i class="fa-solid fa-box-open"></i> In your active queue</div>
        </div>
        <div class="metric-icon-box icon-blue">
            <i class="fa-solid fa-boxes-packing"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Pending Fulfillment</h5>
            <div class="metric-value" style="color: #fbbf24;">{{ $pendingCount }}</div>
            <div class="metric-sub">Awaiting packaging & dispatch</div>
        </div>
        <div class="metric-icon-box icon-amber">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Completed / Delivered</h5>
            <div class="metric-value" style="color: #34d399;">{{ $deliveredCount }}</div>
            <div class="metric-sub"><i class="fa-solid fa-check"></i> Successfully dispatched</div>
        </div>
        <div class="metric-icon-box icon-green">
            <i class="fa-solid fa-truck-ramp-box"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Open Customer Inquiries</h5>
            <div class="metric-value" style="color: #c084fc;">{{ $openTicketsCount }}</div>
            <div class="metric-sub">Support questions to resolve</div>
        </div>
        <div class="metric-icon-box icon-gold">
            <i class="fa-solid fa-headset"></i>
        </div>
    </div>
</div>

<!-- Employee Welcome & Quick Actions -->
<div class="db-panel" style="background: linear-gradient(135deg, #151a24, #0f121a); border-left: 4px solid #60a5fa;">
    <div class="db-panel-header">
        <div>
            <div class="panel-title" style="color: #fff;">
                <i class="fa-solid fa-user-check" style="color: #60a5fa;"></i> Active Duty: {{ $employee->department ?? 'Store Operations' }}
            </div>
            <p style="font-size: 0.8rem; color: var(--db-text-muted); margin-top: 4px;">
                You are authorized to fulfill orders, attach courier tracking (TCS, Trax, Leopards), and answer customer queries.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('employee.orders') }}" class="btn-db btn-db-gold">
                <i class="fa-solid fa-dolly"></i> Process Assigned Orders
            </a>
            <a href="{{ route('employee.tickets') }}" class="btn-db btn-db-outline">
                <i class="fa-solid fa-comments"></i> Support Inquiries ({{ $openTicketsCount }})
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Orders assigned to this staff member -->
    <div class="db-panel">
        <div class="db-panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-dolly"></i> My Active Fulfillment Queue
            </div>
            <a href="{{ route('employee.orders') }}" class="btn-db btn-db-outline" style="font-size: 0.75rem;">
                View All <i class="fa-solid fa-arrow-right"></i>
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
                        <th style="text-align: right;">Action</th>
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
                                <div style="font-weight: 700; color: #fff;">{{ $order->customer_name }}</div>
                                <div style="font-size: 0.72rem; color: var(--db-text-muted);">{{ $order->customer_phone }}</div>
                            </td>
                            <td>{{ $order->city }}</td>
                            <td><strong>Rs. {{ number_format($order->total) }}</strong></td>
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
                            <td style="text-align: right;">
                                <a href="{{ route('employee.orders') }}" class="btn-db btn-db-outline" style="font-size: 0.75rem;">
                                    Fulfill <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--db-text-dim); padding: 32px;">
                                No orders currently assigned to you. Check the queue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Daily Shift Checklist -->
    <div class="db-panel">
        <div class="db-panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-clipboard-check"></i> Standard Operating Procedure
            </div>
        </div>
        <div style="padding: 18px;">
            <div style="display: flex; flex-direction: column; gap: 14px; font-size: 0.85rem;">
                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" checked style="accent-color: var(--db-gold); margin-top: 3px;">
                    <div>
                        <strong style="color: #fff;">Verify COD Phone Numbers</strong>
                        <div style="font-size: 0.75rem; color: var(--db-text-muted);">Call customers to confirm Karachi, Lahore, and Rawalpindi orders.</div>
                    </div>
                </label>

                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" checked style="accent-color: var(--db-gold); margin-top: 3px;">
                    <div>
                        <strong style="color: #fff;">Bubble-wrap Glass Oil Bottles</strong>
                        <div style="font-size: 0.75rem; color: var(--db-text-muted);">Ensure 200ml herbal hair oil bottles are sealed against courier damage.</div>
                    </div>
                </label>

                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" style="accent-color: var(--db-gold); margin-top: 3px;">
                    <div>
                        <strong style="color: #fff;">Attach Trax / TCS Barcodes</strong>
                        <div style="font-size: 0.75rem; color: var(--db-text-muted);">Paste printed airway bills and update the tracking number in portal.</div>
                    </div>
                </label>

                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" style="accent-color: var(--db-gold); margin-top: 3px;">
                    <div>
                        <strong style="color: #fff;">Respond to WhatsApp & Queries</strong>
                        <div style="font-size: 0.75rem; color: var(--db-text-muted);">Guide customers on pure herbal ingredients and application steps.</div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>

@endsection
