@extends('layouts.dashboard')

@section('title', 'Customer Inquiries & Support Tickets')
@section('header_title', 'Customer Inquiries & Support Hub')
@section('header_subtitle', 'Manage contact form submissions, customer queries, and staff assignments')

@section('content')

<!-- Metrics Row -->
<div class="metrics-grid" style="margin-bottom: 24px;">
    <div class="metric-card">
        <div class="metric-info">
            <h5>Total Inquiries Received</h5>
            <div class="metric-value">{{ $totalTickets }}</div>
            <div class="metric-sub" style="color: #60a5fa;"><i class="fa-solid fa-envelope-open-text"></i> From store contact form</div>
        </div>
        <div class="metric-icon-box icon-blue">
            <i class="fa-solid fa-headset"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Open / Pending Action</h5>
            <div class="metric-value" style="color: #fbbf24;">{{ $openTickets }}</div>
            <div class="metric-sub" style="color: #fbbf24;"><i class="fa-solid fa-clock"></i> Awaiting staff response</div>
        </div>
        <div class="metric-icon-box icon-amber">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Currently In Progress</h5>
            <div class="metric-value" style="color: #c084fc;">{{ $inProgressTickets }}</div>
            <div class="metric-sub" style="color: #c084fc;"><i class="fa-solid fa-user-clock"></i> Being handled by staff</div>
        </div>
        <div class="metric-icon-box" style="background: rgba(192, 132, 252, 0.15); color: #c084fc;">
            <i class="fa-solid fa-comments"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <h5>Resolved Inquiries</h5>
            <div class="metric-value" style="color: #34d399;">{{ $resolvedTickets }}</div>
            <div class="metric-sub" style="color: #34d399;"><i class="fa-solid fa-check-double"></i> Successfully answered</div>
        </div>
        <div class="metric-icon-box icon-green">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>
</div>

<!-- Filter & Search Toolbar Panel -->
<div class="db-panel" style="margin-bottom: 24px; padding: 18px 24px;">
    <form method="GET" action="{{ route('admin.tickets') }}" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center; justify-content: space-between; margin: 0;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; flex: 1; min-width: 280px;">
            <div style="position: relative; flex: 1; min-width: 220px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--db-text-dim); font-size: 0.85rem;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer, phone, email, ticket #..." class="filter-input" style="width: 100%; padding-left: 36px; height: 40px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(223, 194, 133, 0.2); border-radius: 8px; color: #fff; font-size: 0.84rem;">
            </div>

            <select name="status" class="filter-select" style="height: 40px; background: #131722; border: 1px solid rgba(223, 194, 133, 0.2); border-radius: 8px; color: #fff; padding: 0 14px; font-size: 0.84rem;">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open (Pending)</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>

            <select name="priority" class="filter-select" style="height: 40px; background: #131722; border: 1px solid rgba(223, 194, 133, 0.2); border-radius: 8px; color: #fff; padding: 0 14px; font-size: 0.84rem;">
                <option value="all" {{ request('priority') == 'all' || !request('priority') ? 'selected' : '' }}>All Priorities</option>
                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>

        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn-db btn-db-gold" style="height: 40px; padding: 0 18px;">
                <i class="fa-solid fa-filter"></i> Apply Filters
            </button>
            @if(request()->hasAny(['search', 'status', 'priority']))
                <a href="{{ route('admin.tickets') }}" class="btn-db btn-db-outline" style="height: 40px; padding: 0 14px;" title="Reset filters">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Main Tickets Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-inbox"></i> Inquiries & Support Tickets List
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Showing {{ $tickets->count() }} of {{ $tickets->total() }} total customer tickets
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Customer Contact</th>
                    <th>Subject & Focus</th>
                    <th>Customer Message</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                    <tr>
                        <!-- Ticket ID & Date -->
                        <td>
                            <strong style="color: var(--db-gold); font-family: monospace; font-size: 0.9rem;">{{ $t->ticket_id }}</strong>
                            <div style="font-size: 0.72rem; color: var(--db-text-dim); margin-top: 2px;">
                                <i class="fa-regular fa-clock"></i> {{ $t->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div style="font-size: 0.68rem; color: #94a3b8;">
                                ({{ $t->created_at->diffForHumans() }})
                            </div>
                        </td>

                        <!-- Customer Details -->
                        <td>
                            <div style="font-weight: 700; color: #fff; font-size: 0.9rem;">{{ $t->customer_name }}</div>
                            <div style="font-size: 0.76rem; color: var(--db-text-muted); margin-top: 2px;">
                                <a href="tel:{{ $t->customer_phone }}" style="color: var(--db-gold); text-decoration: none;">
                                    <i class="fa-solid fa-phone"></i> {{ $t->customer_phone }}
                                </a>
                            </div>
                            @if($t->customer_email)
                                <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 2px;">
                                    <a href="mailto:{{ $t->customer_email }}" style="color: #94a3b8; text-decoration: none;">
                                        <i class="fa-regular fa-envelope"></i> {{ $t->customer_email }}
                                    </a>
                                </div>
                            @endif
                        </td>

                        <!-- Subject -->
                        <td>
                            <div style="font-size: 0.86rem; font-weight: 700; color: #fff;">{{ $t->subject }}</div>
                            <div style="font-size: 0.72rem; color: var(--db-gold); margin-top: 2px;">
                                <i class="fa-solid fa-tag"></i> {{ $t->product_related ?? 'Amber\'s Roots Herbal Care' }}
                            </div>
                        </td>

                        <!-- Message -->
                        <td style="max-width: 320px;">
                            <div style="font-size: 0.82rem; color: #e2e8f0; line-height: 1.45; background: rgba(255, 255, 255, 0.02); padding: 8px 12px; border-radius: 8px; border-left: 2px solid var(--db-gold);">
                                "{{ $t->message }}"
                            </div>
                            @if($t->resolution_notes)
                                <div style="font-size: 0.72rem; color: #34d399; margin-top: 6px; background: rgba(16, 185, 129, 0.08); padding: 5px 8px; border-radius: 6px; border: 1px solid rgba(16, 185, 129, 0.2);">
                                    <strong><i class="fa-solid fa-circle-check"></i> Resolution Note:</strong> {{ $t->resolution_notes }}
                                </div>
                            @endif
                        </td>

                        <!-- Priority -->
                        <td>
                            @if($t->priority === 'urgent')
                                <span class="status-badge badge-kicked" style="box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Urgent
                                </span>
                            @elseif($t->priority === 'low')
                                <span class="status-badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8;">
                                    Low
                                </span>
                            @else
                                <span class="status-badge badge-processing">
                                    Normal
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td>
                            @if($t->status === 'open')
                                <span class="status-badge badge-pending">
                                    <i class="fa-solid fa-clock"></i> Open
                                </span>
                            @elseif($t->status === 'in_progress')
                                <span class="status-badge badge-processing">
                                    <i class="fa-solid fa-spinner fa-spin"></i> In Progress
                                </span>
                            @else
                                <span class="status-badge badge-active">
                                    <i class="fa-solid fa-check"></i> Resolved
                                </span>
                            @endif
                        </td>

                        <!-- Action Buttons -->
                        <td style="text-align: right;">
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $t->customer_phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '92' . substr($cleanPhone, 1);
                                }
                                $waText = "Hello {$t->customer_name}! Thank you for contacting Amber's Roots regarding ticket #{$t->ticket_id} ({$t->subject}). How may we assist you today?";
                            @endphp

                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                @if(!empty($cleanPhone))
                                    <!-- WhatsApp Direct Button -->
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waText) }}" target="_blank" class="btn-db" style="background: rgba(37, 211, 102, 0.15); color: #25d366; border: 1px solid rgba(37, 211, 102, 0.35); padding: 6px 10px; font-size: 0.78rem;" title="Chat directly with customer on WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif

                                <!-- Manage / Update Modal Button -->
                                <button type="button" class="btn-db btn-db-outline" style="padding: 6px 12px; font-size: 0.78rem;" onclick="openTicketModal('{{ $t->id }}', '{{ $t->ticket_id }}', '{{ addslashes($t->customer_name) }}', '{{ $t->status }}', '{{ $t->priority }}', '{{ addslashes($t->resolution_notes ?? '') }}')">
                                    <i class="fa-solid fa-pen-to-square"></i> Update
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.tickets.delete', $t->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete inquiry ticket #{{ $t->ticket_id }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-db" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 6px 8px; font-size: 0.78rem;" title="Delete Ticket">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--db-text-dim); padding: 48px;">
                            <div style="font-size: 2.2rem; color: rgba(223, 194, 133, 0.4); margin-bottom: 12px;">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <h4 style="color: #fff; font-size: 1.1rem; margin-bottom: 6px;">No Customer Inquiries Found</h4>
                            <p style="font-size: 0.85rem; color: var(--db-text-muted); max-width: 460px; margin: 0 auto;">
                                Any client queries, consultation requests, or messages submitted through the store’s Contact Page will automatically populate here in real-time.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div style="padding: 18px 24px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $tickets->links() }}
        </div>
    @endif
</div>

<!-- Update & Staff Assignment Modal -->
<div id="ticketUpdateModal" class="db-modal-backdrop" style="display: none;">
    <div class="db-modal-box" style="max-width: 580px;">
        <div class="db-modal-header">
            <div>
                <h3 id="modalTicketTitle" style="font-family: 'Cinzel', serif; font-size: 1.25rem; font-weight: 700; color: #fff;">
                    Update Ticket #<span id="modalTicketNumber"></span>
                </h3>
                <div style="font-size: 0.8rem; color: var(--db-gold); margin-top: 2px;">
                    Customer: <span id="modalCustomerName" style="color: #fff; font-weight: 700;"></span>
                </div>
            </div>
            <button type="button" class="db-modal-close" onclick="closeTicketModal()">&times;</button>
        </div>

        <form id="ticketUpdateForm" method="POST" action="">
            @csrf
            <div class="db-modal-body" style="display: flex; flex-direction: column; gap: 16px; padding: 20px 24px;">
                <!-- Status & Priority Row (Responsive) -->
                <div class="db-form-row-2">
                    <div>
                        <label class="form-label">
                            Ticket Status *
                        </label>
                        <select name="status" id="modalStatusSelect" required style="width: 100%; height: 42px; background: #0c0f16; border: 1px solid rgba(223, 194, 133, 0.3); border-radius: 8px; color: #fff; padding: 0 12px; font-size: 0.88rem;">
                            <option value="open">Open (Pending)</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label" style="display: block; font-size: 0.78rem; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">
                            Priority Level *
                        </label>
                        <select name="priority" id="modalPrioritySelect" required style="width: 100%; height: 42px; background: #0c0f16; border: 1px solid rgba(223, 194, 133, 0.3); border-radius: 8px; color: #fff; padding: 0 12px; font-size: 0.88rem;">
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>

                <!-- Internal Notes / Resolution Summary -->
                <div>
                    <label class="form-label" style="display: block; font-size: 0.78rem; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">
                        Customer Follow-up / Resolution Notes
                    </label>
                    <textarea name="resolution_notes" id="modalResolutionNotes" rows="4" placeholder="Enter notes on customer guidance provided, call outcomes, or wholesale deals..." style="width: 100%; background: #0c0f16; border: 1px solid rgba(223, 194, 133, 0.3); border-radius: 8px; color: #fff; padding: 10px 12px; font-size: 0.85rem; line-height: 1.45;"></textarea>
                </div>
            </div>

            <div class="db-modal-footer" style="padding: 16px 24px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeTicketModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold">
                    <i class="fa-solid fa-floppy-disk"></i> Save Ticket Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openTicketModal(id, ticketId, customerName, status, priority, notes) {
    const modal = document.getElementById('ticketUpdateModal');
    const form = document.getElementById('ticketUpdateForm');
    
    form.action = `/admin/tickets/${id}/update`;
    document.getElementById('modalTicketNumber').textContent = ticketId;
    document.getElementById('modalCustomerName').textContent = customerName;
    document.getElementById('modalStatusSelect').value = status || 'open';
    document.getElementById('modalPrioritySelect').value = priority || 'normal';
    document.getElementById('modalResolutionNotes').value = notes || '';

    modal.style.display = 'flex';
}

function closeTicketModal() {
    document.getElementById('ticketUpdateModal').style.display = 'none';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('ticketUpdateModal');
    if (e.target === modal) {
        closeTicketModal();
    }
});
</script>
@endpush

@endsection

