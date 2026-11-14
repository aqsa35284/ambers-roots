@extends('layouts.dashboard')

@section('title', 'Customer Support Inquiries')
@section('header_title', 'Customer Queries & Inquiries')
@section('header_subtitle', 'Address product guidance and delivery status tickets')

@section('content')

<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-headset"></i> Assigned Support Tickets
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            {{ $tickets->total() }} customer tickets
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Customer</th>
                    <th>Product / Topic</th>
                    <th>Customer Inquiry Message</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                    <tr>
                        <td>
                            <strong style="color: var(--db-gold);">{{ $t->ticket_id }}</strong>
                            <div style="font-size: 0.7rem; color: var(--db-text-dim);">{{ $t->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $t->customer_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--db-text-muted);">
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
                        <td>
                            <div style="font-size: 0.85rem; font-weight: 600; color: #fff;">{{ $t->subject }}</div>
                            <div style="font-size: 0.72rem; color: var(--db-gold);">{{ $t->product_related ?? 'General Store' }}</div>
                        </td>
                        <td style="max-width: 260px;">
                            <div style="font-size: 0.82rem; color: #cbd5e1; line-height: 1.4;">
                                "{{ $t->message }}"
                            </div>
                            @if($t->resolution_notes)
                                <div style="font-size: 0.72rem; color: #34d399; margin-top: 4px; background: rgba(16, 185, 129, 0.08); padding: 4px 8px; border-radius: 4px;">
                                    <strong>Resolution:</strong> {{ $t->resolution_notes }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($t->priority === 'urgent')
                                <span class="status-badge badge-kicked">Urgent</span>
                            @elseif($t->priority === 'low')
                                <span class="status-badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8;">Low</span>
                            @else
                                <span class="status-badge badge-processing">Normal</span>
                            @endif
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
                                $waText = "Hello {$t->customer_name}! Thank you for contacting Amber's Roots regarding ticket #{$t->ticket_id}. How may we assist you today?";
                            @endphp
                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                @if(!empty($cleanPhone))
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waText) }}" target="_blank" class="btn-db" style="background: rgba(37, 211, 102, 0.15); color: #25d366; border: 1px solid rgba(37, 211, 102, 0.35); padding: 5px 8px; font-size: 0.75rem;" title="Chat directly with customer on WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif
                                <button type="button" class="btn-db btn-db-outline" style="padding: 5px 10px; font-size: 0.75rem;" onclick="openTicketModal('{{ $t->id }}', '{{ $t->ticket_id }}', '{{ $t->status }}', '{{ addslashes($t->resolution_notes ?? '') }}')">
                                    <i class="fa-solid fa-reply"></i> Update
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No support tickets assigned to you right now.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $tickets->links() }}
        </div>
    @endif
</div>

<!-- Modal: Update Ticket -->
<div class="db-modal-backdrop" id="updateTicketModal">
    <div class="db-modal-dialog">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.2rem; font-family: 'Cinzel', serif;">
                Update Ticket <span id="modalTicketId"></span>
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeTicketModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="updateTicketForm" method="POST" action="">
            @csrf

            <div class="db-form-group">
                <label class="db-form-label" for="t_status">Ticket Status *</label>
                <select name="status" id="t_status" class="db-form-select" required>
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="t_resolution">Staff Response & Resolution Notes</label>
                <textarea name="resolution_notes" id="t_resolution" rows="3" class="db-form-textarea" placeholder="Detail the guidance provided to the customer..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeTicketModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 20px;">
                    <i class="fa-solid fa-save"></i> Save Ticket Status
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openTicketModal(ticketId, ticketCode, status, resolution) {
        const form = document.getElementById('updateTicketForm');
        form.action = `/employee/tickets/${ticketId}/update`;
        document.getElementById('modalTicketId').innerText = ticketCode;
        document.getElementById('t_status').value = status;
        document.getElementById('t_resolution').value = resolution || '';
        document.getElementById('updateTicketModal').classList.add('is-open');
    }

    function closeTicketModal() {
        document.getElementById('updateTicketModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection
